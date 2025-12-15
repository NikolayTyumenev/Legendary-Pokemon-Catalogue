<?php
session_start();
require_once('../private/connect.php');
require_once('../private/functions.php');

$connection = db_connect();

$id = $_GET['id'] ?? 0;
$showing_shiny = $_GET['shiny'] ?? 0; // Check if shiny version should be shown

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

$page_title = $pokemon['name'] . " - Pokemon Details";
include('includes/header.php');
?>

<style>
.pokemon-image-container {
    position: relative;
    display: inline-block;
    width: 100%;
}

.shiny-star {
    position: absolute;
    top: 15px;
    left: 15px;
    font-size: 3.5rem;
    cursor: pointer;
    transition: all 0.3s ease;
    z-index: 10;
    user-select: none;
    text-shadow: 
        0 0 10px rgba(0, 0, 0, 0.8),
        0 0 20px rgba(0, 0, 0, 0.6),
        0 2px 4px rgba(0, 0, 0, 0.9);
}

.shiny-star.active {
    filter: drop-shadow(0 0 15px rgba(255, 215, 0, 1)) 
            drop-shadow(0 0 25px rgba(255, 215, 0, 0.8));
    text-shadow: 
        0 0 10px rgba(255, 215, 0, 1),
        0 0 20px rgba(255, 215, 0, 0.8),
        0 2px 4px rgba(0, 0, 0, 0.5);
}

.shiny-star.inactive {
    opacity: 0.6;
    filter: grayscale(100%) brightness(1.5) drop-shadow(0 2px 6px rgba(0, 0, 0, 0.8));
    text-shadow: 
        0 0 10px rgba(0, 0, 0, 0.9),
        0 0 20px rgba(0, 0, 0, 0.7),
        0 2px 4px rgba(0, 0, 0, 1);
}

.shiny-star:hover {
    transform: scale(1.3) rotate(15deg);
}

.shiny-star:hover.active {
    filter: drop-shadow(0 0 20px rgba(255, 215, 0, 1)) 
            drop-shadow(0 0 35px rgba(255, 255, 0, 1));
}

.shiny-star:hover.inactive {
    opacity: 0.8;
    filter: grayscale(100%) brightness(2) drop-shadow(0 2px 8px rgba(0, 0, 0, 1));
}

.shiny-star:active {
    transform: scale(0.95) rotate(-15deg);
}

.shiny-star.sparkle {
    animation: sparkle 0.6s ease-in-out;
}

@keyframes sparkle {
    0%, 100% { 
        transform: scale(1) rotate(0deg);
    }
    25% {
        transform: scale(1.4) rotate(90deg);
        filter: drop-shadow(0 0 25px rgba(255, 215, 0, 1)) 
                drop-shadow(0 0 40px rgba(255, 255, 0, 1));
    }
    50% { 
        transform: scale(1.6) rotate(180deg);
        filter: drop-shadow(0 0 30px rgba(255, 255, 0, 1)) 
                drop-shadow(0 0 50px rgba(255, 215, 0, 1));
    }
    75% {
        transform: scale(1.4) rotate(270deg);
        filter: drop-shadow(0 0 25px rgba(255, 215, 0, 1));
    }
}

.pokemon-main-image {
    transition: all 0.4s ease;
    border-radius: 0.5rem;
}

.pokemon-main-image.shiny-flash {
    animation: shinyFlash 0.6s ease-in-out;
}

@keyframes shinyFlash {
    0%, 100% { 
        filter: brightness(1);
    }
    50% { 
        filter: brightness(1.8) saturate(1.5) hue-rotate(10deg);
    }
}

.shiny-badge {
    position: absolute;
    top: 15px;
    right: 15px;
    background: linear-gradient(135deg, #ffd700, #ffed4e, #ffd700);
    background-size: 200% 200%;
    color: #333;
    padding: 8px 16px;
    border-radius: 25px;
    font-weight: bold;
    font-size: 0.9rem;
    box-shadow: 
        0 4px 15px rgba(255, 215, 0, 0.8),
        0 0 20px rgba(255, 215, 0, 0.6);
    z-index: 10;
    display: none;
}

.shiny-badge.show {
    display: block;
    animation: fadeInBounce 0.5s ease, shimmer 3s ease-in-out infinite;
}

@keyframes shimmer {
    0%, 100% {
        background-position: 0% 50%;
    }
    50% {
        background-position: 100% 50%;
    }
}

@keyframes fadeInBounce {
    0% {
        opacity: 0;
        transform: translateY(-10px) scale(0.8);
    }
    60% {
        transform: translateY(5px) scale(1.1);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
    }
}
</style>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="browse.php">Browse</a></li>
        <li class="breadcrumb-item active"><?php echo h($pokemon['name']); ?></li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-4">
        <?php 
        // Determine which image to show
        $current_image = $showing_shiny && $pokemon['shiny_image'] 
            ? $pokemon['shiny_image'] 
            : $pokemon['fullsize_image'];
        ?>
        
        <div class="pokemon-image-container">
            <?php if ($pokemon['shiny_image']): ?>
                <!-- Shiny Star Toggle -->
                <span class="shiny-star <?php echo $showing_shiny ? 'active' : 'inactive'; ?>" 
                      id="shinyToggle" 
                      onclick="toggleShiny()"
                      title="<?php echo $showing_shiny ? 'Show Normal Version' : 'Show Shiny Version'; ?>">
                    ✨
                </span>
                
                <!-- Shiny Badge -->
                <span class="shiny-badge <?php echo $showing_shiny ? 'show' : ''; ?>" id="shinyBadge">
                    ✨ Shiny
                </span>
            <?php endif; ?>
            
            <!-- Pokemon Image -->
            <?php if ($current_image): ?>
                <img src="images/pokemon/fullsize/<?php echo h($current_image); ?>" 
                     class="img-fluid rounded shadow pokemon-main-image" 
                     id="pokemonImage"
                     alt="<?php echo h($pokemon['name']); ?>">
            <?php else: ?>
                <div class="bg-light rounded p-5 text-center shadow">
                    <span class="text-muted">No Image Available</span>
                </div>
            <?php endif; ?>
        </div>
        
        <!-- Team Builder Button -->
        <div class="card mt-3">
            <div class="card-body p-2">
                <form method="post" action="team_builder.php">
                    <input type="hidden" name="pokemon_id" value="<?php echo $pokemon['id']; ?>">
                    <?php if (count($_SESSION['team']) < 6 && !in_array($pokemon['id'], $_SESSION['team'])): ?>
                        <button type="submit" name="add_to_team" class="btn btn-success w-100">
                            ➕ Add to Team
                        </button>
                    <?php elseif (in_array($pokemon['id'], $_SESSION['team'])): ?>
                        <button type="submit" name="remove_from_team" class="btn btn-danger w-100">
                            ➖ Remove from Team
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-secondary w-100" disabled>
                            Team Full (6/6)
                        </button>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <h1>
            <?php echo h($pokemon['name']); ?> 
            <span class="text-muted">#<?php echo h($pokemon['pokedex_number']); ?></span>
        </h1>
        
        <p class="lead">
            <span class="badge bg-primary"><?php echo h($pokemon['type1']); ?></span>
            <?php if ($pokemon['type2']): ?>
                <span class="badge bg-secondary"><?php echo h($pokemon['type2']); ?></span>
            <?php endif; ?>
            <span class="badge bg-info"><?php echo h($pokemon['classification']); ?></span>
        </p>
        
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Base Stats</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="40%">HP</th><td><?php echo h($pokemon['hp']); ?></td></tr>
                    <tr><th>Attack</th><td><?php echo h($pokemon['attack']); ?></td></tr>
                    <tr><th>Defense</th><td><?php echo h($pokemon['defense']); ?></td></tr>
                    <tr><th>Sp. Attack</th><td><?php echo h($pokemon['sp_attack']); ?></td></tr>
                    <tr><th>Sp. Defense</th><td><?php echo h($pokemon['sp_defense']); ?></td></tr>
                    <tr><th>Speed</th><td><?php echo h($pokemon['speed']); ?></td></tr>
                    <tr class="table-primary"><th><strong>Total</strong></th><td><strong><?php echo h($pokemon['base_stat_total']); ?></strong></td></tr>
                </table>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Description</div>
            <div class="card-body">
                <p><?php echo nl2br(h($pokemon['description'])); ?></p>
                
                <?php if ($pokemon['lore_story']): ?>
                    <h6>Lore & Story</h6>
                    <p><?php echo nl2br(h($pokemon['lore_story'])); ?></p>
                <?php endif; ?>
                
                <?php if ($pokemon['how_to_obtain']): ?>
                    <h6>How to Obtain</h6>
                    <p><?php echo nl2br(h($pokemon['how_to_obtain'])); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Additional Information</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="40%">Generation</th><td><?php echo h($pokemon['generation']); ?></td></tr>
                    <tr><th>Region</th><td><?php echo h($pokemon['region']); ?></td></tr>
                    <?php if ($pokemon['legendary_group']): ?>
                        <tr><th>Group</th><td><?php echo h($pokemon['legendary_group']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['abilities']): ?>
                        <tr><th>Abilities</th><td><?php echo h($pokemon['abilities']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['signature_move']): ?>
                        <tr><th>Signature Move</th><td><?php echo h($pokemon['signature_move']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['height_m']): ?>
                        <tr><th>Height</th><td><?php echo h($pokemon['height_m']); ?>m</td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['weight_kg']): ?>
                        <tr><th>Weight</th><td><?php echo h($pokemon['weight_kg']); ?>kg</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        
        <div class="btn-group" role="group">
            <?php if (is_logged_in()): ?>
                <a href="edit.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-warning">
                    Edit
                </a>
                <a href="delete.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-danger">
                    Delete
                </a>
            <?php endif; ?>
            <a href="browse.php" class="btn btn-secondary">
                Back to Browse
            </a>
        </div>
    </div>
</div>

<script>
function toggleShiny() {
    const star = document.getElementById('shinyToggle');
    const image = document.getElementById('pokemonImage');
    const currentUrl = new URL(window.location.href);
    
    // Add sparkle animation to star
    star.classList.add('sparkle');
    
    // Add flash effect to image
    image.classList.add('shiny-flash');
    
    // Toggle shiny parameter
    if (currentUrl.searchParams.get('shiny') === '1') {
        currentUrl.searchParams.delete('shiny');
    } else {
        currentUrl.searchParams.set('shiny', '1');
    }
    
    // Navigate after animation
    setTimeout(() => {
        window.location.href = currentUrl.toString();
    }, 300);
}
</script>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>