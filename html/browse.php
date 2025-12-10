<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');

$connection = db_connect();

$page_title = "Browse Pokemon";
include('includes/header.php');
?>

<!-- Hero Banner -->
<div class="hero-banner">
    <h1>Discover Pokémon</h1>
    <p class="lead">Explore the complete catalogue of Legendary & Mythical Pokémon</p>
</div>

<!-- Pokemon Grid -->
<div class="row g-4">
    <?php
    $query = "SELECT id, name, pokedex_number, type1, type2, classification, generation, thumbnail_image 
              FROM pokemon 
              ORDER BY pokedex_number";
    $result = mysqli_query($connection, $query);
    
    while ($row = mysqli_fetch_assoc($result)):
    ?>
    
    <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
        <a href="view.php?id=<?php echo $row['id']; ?>" class="pokemon-card">
            <!-- Circular Image with Type-Based Gradient -->
            <div class="pokemon-image-circle circle-<?php echo strtolower($row['type1']); ?>">
                <?php if ($row['thumbnail_image']): ?>
                    <img src="images/pokemon/thumbnails/<?php echo htmlspecialchars($row['thumbnail_image']); ?>" 
                         alt="<?php echo htmlspecialchars($row['name']); ?>">
                <?php else: ?>
                    <span class="text-muted">?</span>
                <?php endif; ?>
            </div>
            
            <!-- Pokemon Name -->
            <div class="pokemon-card-title"><?php echo htmlspecialchars($row['name']); ?></div>
            
            <!-- Pokedex Number -->
            <div class="pokemon-number">
                #<?php echo str_pad($row['pokedex_number'], 3, '0', STR_PAD_LEFT); ?>
            </div>
            
            <!-- Type Badges (Circles) -->
            <div class="type-badges">
                <div class="type-badge-circle type-<?php echo strtolower($row['type1']); ?>" 
                     title="<?php echo htmlspecialchars($row['type1']); ?>">
                    <?php echo strtoupper(substr($row['type1'], 0, 1)); ?>
                </div>
                <?php if ($row['type2']): ?>
                    <div class="type-badge-circle type-<?php echo strtolower($row['type2']); ?>"
                         title="<?php echo htmlspecialchars($row['type2']); ?>">
                        <?php echo strtoupper(substr($row['type2'], 0, 1)); ?>
                    </div>
                <?php endif; ?>
            </div>
        </a>
    </div>
    
    <?php endwhile; ?>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>