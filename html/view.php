<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

$connection = db_connect();

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM pokemon WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pokemon = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pokemon) {
    header('Location: browse.php');
    exit;
}

// Get previous and next Pokemon IDs
$prev_query = "SELECT id FROM pokemon WHERE pokedex_number < ? ORDER BY pokedex_number DESC LIMIT 1";
$prev_stmt = mysqli_prepare($connection, $prev_query);
mysqli_stmt_bind_param($prev_stmt, "i", $pokemon['pokedex_number']);
mysqli_stmt_execute($prev_stmt);
$prev_result = mysqli_stmt_get_result($prev_stmt);
$prev_pokemon = mysqli_fetch_assoc($prev_result);
mysqli_stmt_close($prev_stmt);

$next_query = "SELECT id FROM pokemon WHERE pokedex_number > ? ORDER BY pokedex_number ASC LIMIT 1";
$next_stmt = mysqli_prepare($connection, $next_query);
mysqli_stmt_bind_param($next_stmt, "i", $pokemon['pokedex_number']);
mysqli_stmt_execute($next_stmt);
$next_result = mysqli_stmt_get_result($next_stmt);
$next_pokemon = mysqli_fetch_assoc($next_result);
mysqli_stmt_close($next_stmt);

$page_title = $pokemon['name'] . " - Pokemon Details";
include('includes/header.php');
?>

<div class="pokemon-detail-container">
    <div class="row">
        <!-- Left Column - Image & Gallery -->
        <div class="col-lg-6">
            <!-- Pokemon Badge & Name -->
            <div class="pokemon-badge">#<?php echo str_pad($pokemon['pokedex_number'], 4, '0', STR_PAD_LEFT); ?></div>
            <h1 class="pokemon-name-title"><?php echo h($pokemon['name']); ?></h1>
            
            <!-- Description -->
            <p class="pokemon-description">
                <?php echo nl2br(h($pokemon['description'])); ?>
            </p>
            
            <!-- Main Pokemon Image with Type-Based Gradient -->
            <div class="pokemon-main-image main-image-<?php echo strtolower($pokemon['type1']); ?>">
                <?php if ($pokemon['fullsize_image']): ?>
                    <img src="images/pokemon/fullsize/<?php echo h($pokemon['fullsize_image']); ?>" 
                         alt="<?php echo h($pokemon['name']); ?>">
                <?php else: ?>
                    <div class="text-muted py-5">No Image Available</div>
                <?php endif; ?>
            </div>
            
            <!-- Image Gallery Thumbnails - Placeholder for Milestone 3 -->
            <?php if ($pokemon['shiny_image'] || $pokemon['has_alternate_forms']): ?>
                <div class="image-gallery">
                    <div class="gallery-thumb active gallery-thumb-<?php echo strtolower($pokemon['type1']); ?>">
                        <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                             alt="Regular">
                    </div>
                    <?php if ($pokemon['shiny_image']): ?>
                        <div class="gallery-thumb gallery-thumb-<?php echo strtolower($pokemon['type1']); ?>">
                            <img src="images/pokemon/thumbnails/<?php echo h($pokemon['shiny_image']); ?>" 
                                 alt="Shiny Form">
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Right Column - Stats & Info -->
        <div class="col-lg-6">
            <!-- Type Badges -->
            <div class="mb-4">
                <h5 class="stats-section"><i class="bi bi-tag-fill"></i> TYPE</h5>
                <span class="type-badge-large type-<?php echo strtolower($pokemon['type1']); ?>">
                    <?php echo h($pokemon['type1']); ?>
                </span>
                <?php if ($pokemon['type2']): ?>
                    <span class="type-badge-large type-<?php echo strtolower($pokemon['type2']); ?>">
                        <?php echo h($pokemon['type2']); ?>
                    </span>
                <?php endif; ?>
            </div>
            
            <!-- Base Stats -->
            <div class="stats-section mb-4">
                <h5><i class="bi bi-bar-chart-fill"></i> BASE STATS</h5>
                <div class="stat-item">
                    <span class="stat-label">HP</span>
                    <span class="stat-value"><?php echo h($pokemon['hp']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Attack</span>
                    <span class="stat-value"><?php echo h($pokemon['attack']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Defense</span>
                    <span class="stat-value"><?php echo h($pokemon['defense']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Sp. Attack</span>
                    <span class="stat-value"><?php echo h($pokemon['sp_attack']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Sp. Defense</span>
                    <span class="stat-value"><?php echo h($pokemon['sp_defense']); ?></span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Speed</span>
                    <span class="stat-value"><?php echo h($pokemon['speed']); ?></span>
                </div>
                <div class="stat-item" style="border-top: 2px solid #667eea; margin-top: 10px; padding-top: 15px;">
                    <span class="stat-label"><strong>TOTAL</strong></span>
                    <span class="stat-value" style="color: #667eea;"><?php echo h($pokemon['base_stat_total']); ?></span>
                </div>
            </div>
            
            <!-- Additional Info -->
            <?php if ($pokemon['lore_story']): ?>
                <div class="info-card">
                    <h6><i class="bi bi-book-fill"></i> Lore & Story</h6>
                    <p><?php echo nl2br(h($pokemon['lore_story'])); ?></p>
                </div>
            <?php endif; ?>
            
            <?php if ($pokemon['how_to_obtain']): ?>
                <div class="info-card">
                    <h6><i class="bi bi-geo-alt-fill"></i> How to Obtain</h6>
                    <p><?php echo nl2br(h($pokemon['how_to_obtain'])); ?></p>
                </div>
            <?php endif; ?>
            
            <!-- Pokemon Details -->
            <div class="info-card">
                <h6><i class="bi bi-info-circle-fill"></i> Details</h6>
                <table class="table table-sm mb-0">
                    <tr>
                        <td><strong>Classification:</strong></td>
                        <td><?php echo h($pokemon['classification']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Generation:</strong></td>
                        <td><?php echo h($pokemon['generation']); ?></td>
                    </tr>
                    <tr>
                        <td><strong>Region:</strong></td>
                        <td><?php echo h($pokemon['region']); ?></td>
                    </tr>
                    <?php if ($pokemon['legendary_group']): ?>
                        <tr>
                            <td><strong>Group:</strong></td>
                            <td><?php echo h($pokemon['legendary_group']); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['abilities']): ?>
                        <tr>
                            <td><strong>Abilities:</strong></td>
                            <td><?php echo h($pokemon['abilities']); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['signature_move']): ?>
                        <tr>
                            <td><strong>Signature Move:</strong></td>
                            <td><?php echo h($pokemon['signature_move']); ?></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['height_m']): ?>
                        <tr>
                            <td><strong>Height:</strong></td>
                            <td><?php echo h($pokemon['height_m']); ?> m</td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['weight_kg']): ?>
                        <tr>
                            <td><strong>Weight:</strong></td>
                            <td><?php echo h($pokemon['weight_kg']); ?> kg</td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['is_event_exclusive']): ?>
                        <tr>
                            <td><strong>Availability:</strong></td>
                            <td><span class="badge bg-danger">Event Exclusive</span></td>
                        </tr>
                    <?php endif; ?>
                    <?php if ($pokemon['games_available']): ?>
                        <tr>
                            <td><strong>Games:</strong></td>
                            <td><?php echo h($pokemon['games_available']); ?></td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            
            <!-- Admin Actions -->
            <?php if (is_logged_in()): ?>
                <div class="admin-actions mt-4">
                    <h6><i class="bi bi-shield-lock-fill"></i> Admin Actions</h6>
                    <a href="edit.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Pokemon
                    </a>
                    <a href="delete.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-danger">
                        <i class="bi bi-trash"></i> Delete Pokemon
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Navigation -->
    <div class="pokemon-nav">
        <?php if ($prev_pokemon): ?>
            <a href="view.php?id=<?php echo $prev_pokemon['id']; ?>" class="nav-button prev">
                <i class="bi bi-arrow-left-circle-fill"></i>
                <span>Previous</span>
            </a>
        <?php else: ?>
            <div></div>
        <?php endif; ?>
        
        <a href="browse.php" class="nav-button">
            <i class="bi bi-grid-fill"></i>
            <span>Back to Browse</span>
        </a>
        
        <?php if ($next_pokemon): ?>
            <a href="view.php?id=<?php echo $next_pokemon['id']; ?>" class="nav-button next">
                <span>Next</span>
                <i class="bi bi-arrow-right-circle-fill"></i>
            </a>
        <?php else: ?>
            <div></div>
        <?php endif; ?>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>