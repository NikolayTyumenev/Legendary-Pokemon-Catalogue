<?php
/**
 * auto_link_images_force.php
 * Auto-links images to Pokemon - INCLUDING those that already have images
 * Use this if you want to REPLACE existing images with new ones
 * 
 * CAUTION: This will overwrite existing image links!
 */

session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();

// Safety check - require confirmation
$confirmed = isset($_GET['confirm']) && $_GET['confirm'] === 'yes';

if (!$confirmed) {
    $page_title = "Force Auto-Link Images - Confirmation Required";
    include('includes/header.php');
    ?>
    <div class="alert alert-danger">
        <h3>⚠️ WARNING!</h3>
        <p><strong>This tool will OVERWRITE existing image links!</strong></p>
        <p>This means Pokemon that already have images will get NEW images if matching files are found.</p>
        <p>Only use this if you want to replace images with newly named files.</p>
    </div>
    
    <div class="card">
        <div class="card-body">
            <h4>Are you sure you want to continue?</h4>
            <p>This action will:</p>
            <ul>
                <li>Scan ALL Pokemon (including those with images)</li>
                <li>Replace image links if matching files are found</li>
                <li>Cannot be undone (unless you restore from backup)</li>
            </ul>
            
            <div class="mt-4">
                <a href="auto_link_images_force.php?confirm=yes" class="btn btn-danger btn-lg">
                    ⚠️ Yes, Force Overwrite All Images
                </a>
                <a href="auto_link_images.php" class="btn btn-secondary btn-lg">
                    ❌ No, Use Safe Mode (Skip Existing)
                </a>
                <a href="index.php" class="btn btn-light btn-lg">
                    Cancel
                </a>
            </div>
        </div>
    </div>
    <?php
    include('includes/footer.php');
    exit;
}

// If confirmed, proceed with force linking
$connection = db_connect();

$query = "SELECT id, name, pokedex_number, thumbnail_image, fullsize_image FROM pokemon ORDER BY pokedex_number";
$result = mysqli_query($connection, $query);

$results = [];
$updated = 0;
$skipped = 0;
$overwritten = 0;

$thumbnail_dir = 'images/pokemon/thumbnails/';
$fullsize_dir = 'images/pokemon/fullsize/';

$thumbnails = [];
$fullsize_images = [];

if (is_dir($thumbnail_dir)) {
    $files = scandir($thumbnail_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && $file != '.gitkeep') {
            $thumbnails[] = $file;
        }
    }
}

if (is_dir($fullsize_dir)) {
    $files = scandir($fullsize_dir);
    foreach ($files as $file) {
        if ($file != '.' && $file != '..' && $file != '.gitkeep') {
            $fullsize_images[] = $file;
        }
    }
}

if ($result) {
    while ($pokemon = mysqli_fetch_assoc($result)) {
        $had_images = (!empty($pokemon['thumbnail_image']) && !empty($pokemon['fullsize_image']));
        
        $found_thumb = null;
        $found_full = null;
        
        $name_lower = strtolower($pokemon['name']);
        $name_clean = str_replace([' ', '-', ':', '\'', '.'], '', $name_lower);
        $pokedex = (string)$pokemon['pokedex_number'];
        
        // Try to find thumbnail
        foreach ($thumbnails as $thumb) {
            $thumb_lower = strtolower($thumb);
            $thumb_clean = str_replace([' ', '-', '_', '.jpg', '.jpeg', '.png', '.gif', '.webp', 'thumb', 'thumbnail'], '', $thumb_lower);
            
            if (
                $thumb_lower === $name_lower . '.jpg' ||
                $thumb_lower === $name_lower . '.jpeg' ||
                $thumb_lower === $name_lower . '.png' ||
                $thumb_lower === $name_lower . '.gif' ||
                $thumb_lower === $name_lower . '.webp' ||
                $thumb_lower === $pokedex . '.jpg' ||
                $thumb_lower === $pokedex . '.jpeg' ||
                $thumb_lower === $pokedex . '.png' ||
                $thumb_lower === $pokedex . '.gif' ||
                $thumb_lower === $pokedex . '.webp' ||
                $thumb_lower === $name_lower . '_thumb.jpg' ||
                $thumb_lower === $name_lower . '_thumb.jpeg' ||
                $thumb_lower === $name_lower . '_thumb.png' ||
                $thumb_lower === $name_lower . '-thumb.jpg' ||
                $thumb_lower === $name_lower . '-thumb.jpeg' ||
                $thumb_lower === $name_lower . '-thumb.png' ||
                $thumb_lower === $pokedex . '_thumb.jpg' ||
                $thumb_lower === $pokedex . '_thumb.jpeg' ||
                $thumb_lower === $pokedex . '_thumb.png' ||
                $thumb_lower === $pokedex . '-thumb.jpg' ||
                $thumb_lower === $pokedex . '-thumb.jpeg' ||
                $thumb_lower === $pokedex . '-thumb.png' ||
                (strlen($name_clean) > 3 && strpos($thumb_clean, $name_clean) !== false) ||
                strpos($thumb_clean, $pokedex) !== false
            ) {
                $found_thumb = $thumb;
                break;
            }
        }
        
        // Try to find fullsize
        foreach ($fullsize_images as $full) {
            $full_lower = strtolower($full);
            $full_clean = str_replace([' ', '-', '_', '.jpg', '.jpeg', '.png', '.gif', '.webp', 'full', 'fullsize', 'large'], '', $full_lower);
            
            if (
                $full_lower === $name_lower . '.jpg' ||
                $full_lower === $name_lower . '.jpeg' ||
                $full_lower === $name_lower . '.png' ||
                $full_lower === $name_lower . '.gif' ||
                $full_lower === $name_lower . '.webp' ||
                $full_lower === $pokedex . '.jpg' ||
                $full_lower === $pokedex . '.jpeg' ||
                $full_lower === $pokedex . '.png' ||
                $full_lower === $pokedex . '.gif' ||
                $full_lower === $pokedex . '.webp' ||
                $full_lower === $name_lower . '_full.jpg' ||
                $full_lower === $name_lower . '_full.jpeg' ||
                $full_lower === $name_lower . '_full.png' ||
                $full_lower === $name_lower . '-full.jpg' ||
                $full_lower === $name_lower . '-full.jpeg' ||
                $full_lower === $name_lower . '-full.png' ||
                $full_lower === $pokedex . '_full.jpg' ||
                $full_lower === $pokedex . '_full.jpeg' ||
                $full_lower === $pokedex . '_full.png' ||
                $full_lower === $pokedex . '-full.jpg' ||
                $full_lower === $pokedex . '-full.jpeg' ||
                $full_lower === $pokedex . '-full.png' ||
                (strlen($name_clean) > 3 && strpos($full_clean, $name_clean) !== false) ||
                strpos($full_clean, $pokedex) !== false
            ) {
                $found_full = $full;
                break;
            }
        }
        
        if ($found_thumb && $found_full) {
            $update_query = "UPDATE pokemon SET 
                            regular_image = ?,
                            thumbnail_image = ?,
                            fullsize_image = ?
                            WHERE id = ?";
            
            $stmt = mysqli_prepare($connection, $update_query);
            mysqli_stmt_bind_param($stmt, "sssi", $found_full, $found_thumb, $found_full, $pokemon['id']);
            
            if (mysqli_stmt_execute($stmt)) {
                if ($had_images) {
                    $results[] = "🔄 <strong>{$pokemon['name']}</strong> (#$pokemon[pokedex_number]): <span class='text-warning'>OVERWRITTEN</span> - New images: thumb=<code>{$found_thumb}</code>, full=<code>{$found_full}</code>";
                    $overwritten++;
                } else {
                    $results[] = "✅ <strong>{$pokemon['name']}</strong> (#$pokemon[pokedex_number]): Linked thumb=<code>{$found_thumb}</code>, full=<code>{$found_full}</code>";
                    $updated++;
                }
            } else {
                $results[] = "❌ <strong>{$pokemon['name']}</strong>: Database update failed";
            }
            mysqli_stmt_close($stmt);
        } else {
            $results[] = "⏭️ <strong>{$pokemon['name']}</strong> (#$pokemon[pokedex_number]): No matching files found";
            $skipped++;
        }
    }
}

db_disconnect($connection);

$page_title = "Force Auto-Link Results";
include('includes/header.php');
?>

<h1>Force Auto-Link Results</h1>

<div class="alert alert-warning">
    <strong>⚠️ Force Mode Used:</strong> Existing image links were overwritten where matches were found.
</div>

<div class="row mb-4">
    <div class="col-md-3">
        <div class="card bg-success text-white">
            <div class="card-body text-center">
                <h2><?php echo $updated; ?></h2>
                <p class="mb-0">New Links</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-dark">
            <div class="card-body text-center">
                <h2><?php echo $overwritten; ?></h2>
                <p class="mb-0">Overwritten</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-secondary text-white">
            <div class="card-body text-center">
                <h2><?php echo $skipped; ?></h2>
                <p class="mb-0">Skipped</p>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white">
            <div class="card-body text-center">
                <h2><?php echo count($thumbnails); ?></h2>
                <p class="mb-0">Images Found</p>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3>Detailed Results</h3>
    </div>
    <div class="card-body" style="max-height: 500px; overflow-y: auto;">
        <ul class="list-unstyled">
            <?php foreach ($results as $result_msg): ?>
                <li class="mb-2"><?php echo $result_msg; ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>

<div class="mt-4">
    <a href="browse.php" class="btn btn-primary">View Browse Page</a>
    <a href="auto_link_images.php" class="btn btn-secondary">Safe Mode</a>
</div>

<?php include('includes/footer.php'); ?>