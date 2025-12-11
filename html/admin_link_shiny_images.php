<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();

$connection = db_connect();
$message = '';
$linked_count = 0;

if (isset($_POST['link_shiny_images'])) {
    // Get all Pokemon
    $query = "SELECT id, pokedex_number, name FROM pokemon ORDER BY pokedex_number";
    $result = mysqli_query($connection, $query);
    
    while ($pokemon = mysqli_fetch_assoc($result)) {
        $id = $pokemon['id'];
        $pokedex = $pokemon['pokedex_number'];
        $name = strtolower(str_replace([' ', '.', "'"], ['', '', ''], $pokemon['name']));
        
        // Check for shiny images in fullsize directory (don't overwrite existing)
        $check_query = "SELECT shiny_image FROM pokemon WHERE id = ?";
        $check_stmt = mysqli_prepare($connection, $check_query);
        mysqli_stmt_bind_param($check_stmt, "i", $id);
        mysqli_stmt_execute($check_stmt);
        $check_result = mysqli_stmt_get_result($check_stmt);
        $current = mysqli_fetch_assoc($check_result);
        
        // Skip if already has shiny image
        if (!empty($current['shiny_image'])) {
            mysqli_stmt_close($check_stmt);
            continue;
        }
        
        mysqli_stmt_close($check_stmt);
        
        $shiny_image = null;
        $fullsize_dir = 'images/pokemon/fullsize/';
        
        // Try different naming patterns with _shiny suffix
        $patterns = [
            $name . '_shiny.jpg',
            $name . '_shiny.png',
            $name . '_shiny.webp',
            $pokedex . '_shiny.jpg',
            $pokedex . '_shiny.png',
            $pokedex . '_shiny.webp'
        ];
        
        foreach ($patterns as $pattern) {
            if (file_exists($fullsize_dir . $pattern)) {
                $shiny_image = $pattern;
                break;
            }
        }
        
        // Update if found
        if ($shiny_image) {
            $update_query = "UPDATE pokemon SET shiny_image = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($update_stmt, "si", $shiny_image, $id);
            
            if (mysqli_stmt_execute($update_stmt)) {
                $linked_count++;
            }
            
            mysqli_stmt_close($update_stmt);
        }
    }
    
    $message = "Successfully linked {$linked_count} shiny images!";
}

$page_title = "Auto-Link Shiny Images";
include('includes/header.php');
?>

<h1>Auto-Link Shiny Images</h1>

<?php if ($message): ?>
    <div class="alert alert-success"><?php echo h($message); ?></div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h5>Automatic Shiny Image Linking</h5>
    </div>
    <div class="card-body">
        <p>This tool will automatically link shiny images to Pokemon based on filename matching.</p>
        
        <div class="alert alert-info">
            <h6>How it works:</h6>
            <ul class="mb-0">
                <li>Looks for files in <code>images/pokemon/fullsize/</code></li>
                <li>Matches patterns: <code>name_shiny.jpg</code>, <code>pokedex_shiny.png</code>, etc.</li>
                <li><strong>Will NOT overwrite existing shiny images</strong></li>
                <li>Supports: .jpg, .png, .webp</li>
            </ul>
        </div>
        
        <div class="alert alert-warning">
            <strong>Naming Examples:</strong>
            <ul class="mb-0">
                <li>Articuno (#144) → <code>articuno_shiny.jpg</code> or <code>144_shiny.jpg</code></li>
                <li>Mewtwo (#150) → <code>mewtwo_shiny.png</code> or <code>150_shiny.png</code></li>
                <li>Ho-Oh (#250) → <code>hooh_shiny.webp</code> or <code>250_shiny.webp</code></li>
            </ul>
        </div>
        
        <form method="post" onsubmit="return confirm('Link shiny images for all Pokemon?');">
            <button type="submit" name="link_shiny_images" class="btn btn-primary">
                ✨ Auto-Link Shiny Images
            </button>
        </form>
        
        <hr>
        
        <h6>Current Shiny Images Status:</h6>
        <?php
        $count_query = "SELECT 
            COUNT(*) as total,
            SUM(CASE WHEN shiny_image IS NOT NULL AND shiny_image != '' THEN 1 ELSE 0 END) as with_shiny
        FROM pokemon";
        $count_result = mysqli_query($connection, $count_query);
        $counts = mysqli_fetch_assoc($count_result);
        ?>
        <p>
            <strong><?php echo $counts['with_shiny']; ?></strong> out of 
            <strong><?php echo $counts['total']; ?></strong> Pokemon have shiny images linked
            (<?php echo round(($counts['with_shiny'] / $counts['total']) * 100); ?>%)
        </p>
        
        <a href="admin.php" class="btn btn-secondary">Back to Admin</a>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5>Pokemon with Shiny Images</h5>
    </div>
    <div class="card-body">
        <?php
        $shiny_query = "SELECT id, pokedex_number, name, shiny_image 
                        FROM pokemon 
                        WHERE shiny_image IS NOT NULL AND shiny_image != ''
                        ORDER BY pokedex_number";
        $shiny_result = mysqli_query($connection, $shiny_query);
        
        if (mysqli_num_rows($shiny_result) > 0):
        ?>
            <div class="row">
                <?php while ($pokemon = mysqli_fetch_assoc($shiny_result)): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card">
                            <div class="row g-0">
                                <div class="col-6">
                                    <img src="images/pokemon/thumbnails/<?php echo h($pokemon['shiny_image']); ?>" 
                                         class="img-fluid" alt="Shiny <?php echo h($pokemon['name']); ?>">
                                    <small class="d-block text-center text-muted">Shiny</small>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <div class="card-body p-2">
                                        <h6 class="small mb-0"><?php echo h($pokemon['name']); ?></h6>
                                        <small class="text-muted">#<?php echo $pokemon['pokedex_number']; ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <p class="text-muted">No Pokemon have shiny images linked yet.</p>
        <?php endif; ?>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>