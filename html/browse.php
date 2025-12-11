<?php
require_once('../private/connect.php');
require_once('../private/functions.php');

$connection = db_connect();

// Get filter values from GET
$search = $_GET['search'] ?? '';
$type_filter = $_GET['type'] ?? '';
$generation_filter = $_GET['generation'] ?? '';
$classification_filter = $_GET['classification'] ?? '';

// Pagination
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

// Build WHERE clause
$where_conditions = [];
$params = [];
$types = '';

// Search functionality
if (!empty($search)) {
    $where_conditions[] = "(name LIKE ? OR description LIKE ? OR abilities LIKE ? OR legendary_group LIKE ?)";
    $search_term = "%{$search}%";
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $params[] = $search_term;
    $types .= 'ssss';
}

// Type filter
if (!empty($type_filter)) {
    $where_conditions[] = "(type1 = ? OR type2 = ?)";
    $params[] = $type_filter;
    $params[] = $type_filter;
    $types .= 'ss';
}

// Generation filter
if (!empty($generation_filter)) {
    $where_conditions[] = "generation = ?";
    $params[] = $generation_filter;
    $types .= 'i';
}

// Classification filter
if (!empty($classification_filter)) {
    $where_conditions[] = "classification = ?";
    $params[] = $classification_filter;
    $types .= 's';
}

// Build final query
$where_clause = count($where_conditions) > 0 ? 'WHERE ' . implode(' AND ', $where_conditions) : '';

// Count total results
$count_query = "SELECT COUNT(*) as total FROM pokemon {$where_clause}";
$count_stmt = mysqli_prepare($connection, $count_query);
if (!empty($types)) {
    mysqli_stmt_bind_param($count_stmt, $types, ...$params);
}
mysqli_stmt_execute($count_stmt);
$count_result = mysqli_stmt_get_result($count_stmt);
$total_results = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_results / $per_page);
mysqli_stmt_close($count_stmt);

// Get paginated results
$query = "SELECT * FROM pokemon {$where_clause} ORDER BY pokedex_number LIMIT ? OFFSET ?";
$params[] = $per_page;
$params[] = $offset;
$types .= 'ii';

$stmt = mysqli_prepare($connection, $query);
if (!empty($types)) {
    mysqli_stmt_bind_param($stmt, $types, ...$params);
}
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// Get unique values for filters
$types_query = "SELECT DISTINCT type1 FROM pokemon UNION SELECT DISTINCT type2 FROM pokemon WHERE type2 IS NOT NULL ORDER BY type1";
$types_result = mysqli_query($connection, $types_query);
$available_types = [];
while ($row = mysqli_fetch_assoc($types_result)) {
    $available_types[] = $row['type1'];
}

$page_title = "Browse Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Browse Pokemon Catalogue</h1>

<!-- Search and Filter Form -->
<div class="card mb-4">
    <div class="card-header">
        <h5>Search & Filter</h5>
    </div>
    <div class="card-body">
        <form method="get" action="browse.php" class="row g-3">
            <!-- Search Box -->
            <div class="col-md-6">
                <label for="search" class="form-label">Search</label>
                <input type="text" class="form-control" id="search" name="search" 
                       placeholder="Search by name, description, abilities..." 
                       value="<?php echo h($search); ?>">
            </div>
            
            <!-- Type Filter -->
            <div class="col-md-2">
                <label for="type" class="form-label">Type</label>
                <select class="form-select" id="type" name="type">
                    <option value="">All Types</option>
                    <?php foreach ($available_types as $type): ?>
                        <option value="<?php echo h($type); ?>" <?php echo $type_filter === $type ? 'selected' : ''; ?>>
                            <?php echo h($type); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <!-- Generation Filter -->
            <div class="col-md-2">
                <label for="generation" class="form-label">Generation</label>
                <select class="form-select" id="generation" name="generation">
                    <option value="">All Generations</option>
                    <?php for ($i = 1; $i <= 9; $i++): ?>
                        <option value="<?php echo $i; ?>" <?php echo $generation_filter == $i ? 'selected' : ''; ?>>
                            Gen <?php echo $i; ?>
                        </option>
                    <?php endfor; ?>
                </select>
            </div>
            
            <!-- Classification Filter -->
            <div class="col-md-2">
                <label for="classification" class="form-label">Classification</label>
                <select class="form-select" id="classification" name="classification">
                    <option value="">All Types</option>
                    <option value="Legendary" <?php echo $classification_filter === 'Legendary' ? 'selected' : ''; ?>>Legendary</option>
                    <option value="Mythical" <?php echo $classification_filter === 'Mythical' ? 'selected' : ''; ?>>Mythical</option>
                    <option value="Sub-Legendary" <?php echo $classification_filter === 'Sub-Legendary' ? 'selected' : ''; ?>>Sub-Legendary</option>
                    <option value="Ultra Beast" <?php echo $classification_filter === 'Ultra Beast' ? 'selected' : ''; ?>>Ultra Beast</option>
                    <option value="Paradox" <?php echo $classification_filter === 'Paradox' ? 'selected' : ''; ?>>Paradox</option>
                </select>
            </div>
            
            <div class="col-12">
                <button type="submit" class="btn btn-primary">Apply Filters</button>
                <a href="browse.php" class="btn btn-secondary">Clear Filters</a>
            </div>
        </form>
    </div>
</div>

<!-- Results Summary -->
<div class="mb-3">
    <p class="text-muted">
        Showing <?php echo $total_results; ?> result<?php echo $total_results != 1 ? 's' : ''; ?>
        <?php if (!empty($search)): ?>
            for "<?php echo h($search); ?>"
        <?php endif; ?>
    </p>
</div>

<!-- Pokemon Grid -->
<div class="row">
    <?php if ($result && mysqli_num_rows($result) > 0): ?>
        <?php while ($pokemon = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-3 mb-4">
                <div class="card h-100">
                    <!-- Make image clickable -->
                    <a href="view.php?id=<?php echo $pokemon['id']; ?>">
                        <?php if ($pokemon['thumbnail_image']): ?>
                            <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                                 class="card-img-top" 
                                 alt="<?php echo h($pokemon['name']); ?>"
                                 style="cursor: pointer;">
                        <?php else: ?>
                            <div class="bg-secondary text-white text-center p-5">
                                No Image
                            </div>
                        <?php endif; ?>
                    </a>
                    <div class="card-body">
                        <!-- Make title clickable too -->
                        <h5 class="card-title">
                            <a href="view.php?id=<?php echo $pokemon['id']; ?>" class="text-decoration-none text-dark">
                                <?php echo h($pokemon['name']); ?>
                            </a>
                        </h5>
                        <p class="text-muted">#<?php echo h($pokemon['pokedex_number']); ?></p>
                        <p>
                            <span class="badge bg-primary"><?php echo h($pokemon['type1']); ?></span>
                            <?php if ($pokemon['type2']): ?>
                                <span class="badge bg-secondary"><?php echo h($pokemon['type2']); ?></span>
                            <?php endif; ?>
                        </p>
                        <p>
                            <span class="badge bg-info"><?php echo h($pokemon['classification']); ?></span>
                            <span class="badge bg-success">Gen <?php echo h($pokemon['generation']); ?></span>
                        </p>
                        <a href="view.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-primary btn-sm">View Details</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <div class="col-12">
            <div class="alert alert-info">
                No Pokemon found matching your criteria. 
                <a href="browse.php">Clear filters</a> to see all Pokemon.
            </div>
        </div>
    <?php endif; ?>
</div>

<!-- Pagination -->
<?php if ($total_pages > 1): ?>
    <nav aria-label="Pokemon pagination">
        <ul class="pagination justify-content-center">
            <!-- Previous Button -->
            <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page - 1])); ?>">
                    Previous
                </a>
            </li>
            
            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <?php if ($i == 1 || $i == $total_pages || ($i >= $page - 2 && $i <= $page + 2)): ?>
                    <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $i])); ?>">
                            <?php echo $i; ?>
                        </a>
                    </li>
                <?php elseif ($i == $page - 3 || $i == $page + 3): ?>
                    <li class="page-item disabled">
                        <span class="page-link">...</span>
                    </li>
                <?php endif; ?>
            <?php endfor; ?>
            
            <!-- Next Button -->
            <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                <a class="page-link" href="?<?php echo http_build_query(array_merge($_GET, ['page' => $page + 1])); ?>">
                    Next
                </a>
            </li>
        </ul>
    </nav>
<?php endif; ?>

<?php
mysqli_stmt_close($stmt);
db_disconnect($connection);
include('includes/footer.php');
?>