<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');

$connection = db_connect();

$page_title = "Browse Pokemon";
include('includes/header.php');
?>

<h1>Browse Pokemon Catalogue</h1>
<p class="lead">All Legendary & Mythical Pokemon</p>

<div class="row g-4">
    <?php
    $query = "SELECT id, name, pokedex_number, type1, type2, classification, generation, thumbnail_image 
              FROM pokemon 
              ORDER BY pokedex_number";
    $result = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($result)):
    ?>
    
    <div class="col-lg-3 col-md-4 col-sm-6">
        <div class="card h-100 shadow-sm">
            <?php if ($row['thumbnail_image']): ?>
                <img src="images/pokemon/thumbnails/<?php echo htmlspecialchars($row['thumbnail_image']); ?>" 
                     class="card-img-top" 
                     alt="<?php echo htmlspecialchars($row['name']); ?>"
                     style="height: 200px; object-fit: contain; padding: 10px;">
            <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                     style="height: 200px;">
                    <span class="text-muted">No Image</span>
                </div>
            <?php endif; ?>
            
            <div class="card-body">
                <h5 class="card-title">
                    <?php echo htmlspecialchars($row['name']); ?> 
                    <small class="text-muted">#<?php echo htmlspecialchars($row['pokedex_number']); ?></small>
                </h5>
                <p class="card-text">
                    <span class="badge bg-primary"><?php echo htmlspecialchars($row['type1']); ?></span>
                    <?php if ($row['type2']): ?>
                        <span class="badge bg-secondary"><?php echo htmlspecialchars($row['type2']); ?></span>
                    <?php endif; ?>
                </p>
                <p class="card-text">
                    <small class="text-muted">
                        <?php echo htmlspecialchars($row['classification']); ?> | 
                        Gen <?php echo htmlspecialchars($row['generation']); ?>
                    </small>
                </p>
            </div>
            <div class="card-footer">
                <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-eye"></i> View Details
                </a>
            </div>
        </div>
    </div>
    
    <?php endwhile; ?>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
