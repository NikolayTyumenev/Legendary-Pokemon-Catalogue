<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();
$connection = db_connect();

// Get stats
$count_query = "SELECT COUNT(*) as total FROM pokemon";
$count_result = mysqli_query($connection, $count_query);
$total_pokemon = mysqli_fetch_assoc($count_result)['total'];

// Get recent additions (last 5)
$recent_query = "SELECT id, name, pokedex_number, thumbnail_image, classification 
                 FROM pokemon 
                 ORDER BY id DESC 
                 LIMIT 5";
$recent_result = mysqli_query($connection, $recent_query);

// Get type distribution
$type_query = "SELECT type1 as type, COUNT(*) as count 
               FROM pokemon 
               GROUP BY type1 
               ORDER BY count DESC 
               LIMIT 5";
$type_result = mysqli_query($connection, $type_query);

$page_title = "Admin Dashboard";
include('includes/header.php');
?>

<div class="row mb-4">
    <div class="col">
        <h1 class="mb-1">
            <i class="bi bi-speedometer2 text-primary"></i> Admin Dashboard
        </h1>
        <p class="lead text-muted mb-0">Welcome back, <?php echo htmlspecialchars(get_current_username()); ?>! 👋</p>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-md-4">
        <div class="stat-card bg-primary">
            <div class="text-center">
                <div class="stat-icon">📊</div>
                <h5 class="mb-0">Total Pokemon</h5>
                <div class="stat-number"><?php echo $total_pokemon; ?></div>
                <small class="opacity-75">Legendary & Mythical</small>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card bg-success">
            <div class="text-center">
                <div class="stat-icon">⚡</div>
                <h5 class="mb-0">Quick Actions</h5>
                <div class="mt-3">
                    <a href="add.php" class="btn btn-light btn-lg">
                        <i class="bi bi-plus-circle"></i> Add Pokemon
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="stat-card bg-info">
            <div class="text-center">
                <div class="stat-icon">🔍</div>
                <h5 class="mb-0">Browse</h5>
                <div class="mt-3">
                    <a href="browse.php" class="btn btn-light btn-lg">
                        <i class="bi bi-grid-fill"></i> View Catalogue
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-clock-history text-primary"></i> Recent Additions
                </h5>
            </div>
            <div class="card-body">
                <div class="list-group list-group-flush">
                    <?php while ($pokemon = mysqli_fetch_assoc($recent_result)): ?>
                        <a href="view.php?id=<?php echo $pokemon['id']; ?>" 
                           class="list-group-item list-group-item-action border-0 px-0 py-3">
                            <div class="d-flex align-items-center gap-3">
                                <?php if ($pokemon['thumbnail_image']): ?>
                                    <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                                         class="recent-pokemon-img" 
                                         alt="<?php echo h($pokemon['name']); ?>">
                                <?php else: ?>
                                    <div class="bg-light recent-pokemon-img d-flex align-items-center justify-content-center">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                <?php endif; ?>
                                <div>
                                    <h6 class="mb-1"><?php echo h($pokemon['name']); ?></h6>
                                    <small class="text-muted">
                                        #<?php echo h($pokemon['pokedex_number']); ?> • 
                                        <span class="badge bg-info"><?php echo h($pokemon['classification']); ?></span>
                                    </small>
                                </div>
                            </div>
                        </a>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="card dashboard-card shadow-sm h-100">
            <div class="card-header bg-white border-0 py-3">
                <h5 class="mb-0">
                    <i class="bi bi-bar-chart-fill text-success"></i> Top Types
                </h5>
            </div>
            <div class="card-body">
                <?php while ($type = mysqli_fetch_assoc($type_result)): ?>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-1">
                            <span class="badge bg-primary"><?php echo h($type['type']); ?></span>
                            <strong><?php echo $type['count']; ?> Pokemon</strong>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" 
                                 style="width: <?php echo ($type['count'] / $total_pokemon * 100); ?>%">
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </div>
</div>

<div class="card dashboard-card shadow-sm mt-4">
    <div class="card-header bg-white border-0 py-3">
        <h5 class="mb-0">
            <i class="bi bi-gear-fill text-warning"></i> Admin Menu
        </h5>
    </div>
    <div class="card-body p-0">
        <a href="browse.php" class="admin-menu-item text-dark">
            <i class="bi bi-grid-fill text-primary"></i>
            <div>
                <strong>Browse All Pokemon</strong>
                <small class="d-block text-muted">View and manage the complete catalogue</small>
            </div>
        </a>
        <a href="add.php" class="admin-menu-item text-dark">
            <i class="bi bi-plus-circle-fill text-success"></i>
            <div>
                <strong>Add New Pokemon</strong>
                <small class="d-block text-muted">Add a new legendary or mythical Pokemon</small>
            </div>
        </a>
        <a href="admin_link_shiny_images.php" class="admin-menu-item text-dark">
            <i class="bi bi-stars text-warning"></i>
            <div>
                <strong>Manage Shiny Images</strong>
                <small class="d-block text-muted">Link shiny variants to Pokemon</small>
            </div>
        </a>
        <hr class="my-0">
        <a href="logout.php" class="admin-menu-item text-danger">
            <i class="bi bi-box-arrow-right"></i>
            <div>
                <strong>Logout</strong>
                <small class="d-block text-muted">Sign out of admin panel</small>
            </div>
        </a>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>