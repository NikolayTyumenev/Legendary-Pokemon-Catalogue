<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();

$connection = db_connect();

$id = $_GET['id'] ?? 0;
$errors = [];

// Get existing Pokemon data from sql database
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

// submission form handling
if (is_post_request()) {
    // Get form data
    $name = trim($_POST['name'] ?? '');
    $pokedex_number = $_POST['pokedex_number'] ?? '';
    $type1 = $_POST['type1'] ?? '';
    $type2 = $_POST['type2'] ?? null;
    $classification = $_POST['classification'] ?? '';
    $generation = $_POST['generation'] ?? '';
    $region = trim($_POST['region'] ?? '');
    
    // Stats
    $hp = $_POST['hp'] ?? '';
    $attack = $_POST['attack'] ?? '';
    $defense = $_POST['defense'] ?? '';
    $sp_attack = $_POST['sp_attack'] ?? '';
    $sp_defense = $_POST['sp_defense'] ?? '';
    $speed = $_POST['speed'] ?? '';
    
    // Description
    $description = trim($_POST['description'] ?? '');
    $lore_story = trim($_POST['lore_story'] ?? '');
    $how_to_obtain = trim($_POST['how_to_obtain'] ?? '');
    
    // Additional
    $legendary_group = trim($_POST['legendary_group'] ?? '');
    $abilities = trim($_POST['abilities'] ?? '');
    $signature_move = trim($_POST['signature_move'] ?? '');
    $height_m = $_POST['height_m'] ?? null;
    $weight_kg = $_POST['weight_kg'] ?? null;
    $is_event_exclusive = isset($_POST['is_event_exclusive']) ? 1 : 0;
    $games_available = trim($_POST['games_available'] ?? '');
    
    // Validation
    if (empty($name)) {
        $errors[] = "Name is required";
    }
    
    if (!is_numeric($pokedex_number) || $pokedex_number < 1) {
        $errors[] = "Pokedex number must be positive";
    }
    
    if (empty($type1)) {
        $errors[] = "Primary type is required";
    }
    
    if (empty($classification)) {
        $errors[] = "Classification is required";
    }
    
    if (!is_numeric($generation) || $generation < 1 || $generation > 9) {
        $errors[] = "Generation must be 1-9";
    }
    
    if (empty($region)) {
        $errors[] = "Region is required";
    }
    
    // Validate stats
    $stat_fields = ['hp', 'attack', 'defense', 'sp_attack', 'sp_defense', 'speed'];
    foreach ($stat_fields as $field) {
        if (!is_numeric($$field) || $$field < 0) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " must be non-negative";
        }
    }
    
    if (empty($description)) {
        $errors[] = "Description is required";
    }
    
    // If no errors, update (including image handling)
    if (count($errors) === 0) {
        $base_stat_total = $hp + $attack + $defense + $sp_attack + $sp_defense + $speed;
        
        if (empty($type2)) {
            $type2 = null;
        }
        
        // Keep existing images by default
        $thumbnail_image = $pokemon['thumbnail_image'];
        $fullsize_image = $pokemon['fullsize_image'];
        $regular_image = $pokemon['regular_image'];
        $shiny_image = $pokemon['shiny_image'];
        
        // Check if new image uploaded
        if (isset($_FILES['pokemon_image']) && $_FILES['pokemon_image']['error'] !== UPLOAD_ERR_NO_FILE) {
            $image_result = process_pokemon_image($_FILES['pokemon_image']);
            
            if ($image_result['success']) {
                // Delete old images
                if ($pokemon['thumbnail_image'] && $pokemon['fullsize_image']) {
                    delete_pokemon_images($pokemon['thumbnail_image'], $pokemon['fullsize_image']);
                }
                
                // Use new images
                $thumbnail_image = $image_result['thumbnail'];
                $fullsize_image = $image_result['fullsize'];
                $regular_image = $image_result['fullsize'];
            } else {
                $errors[] = "Image upload error: " . $image_result['error'];
            }
        }
        
        // If still no errors, update database
        if (count($errors) === 0) {
            $update_query = "UPDATE pokemon SET 
                name = ?, pokedex_number = ?, type1 = ?, type2 = ?, 
                classification = ?, generation = ?, region = ?,
                hp = ?, attack = ?, defense = ?, sp_attack = ?, sp_defense = ?, speed = ?, 
                base_stat_total = ?,
                regular_image = ?, thumbnail_image = ?, fullsize_image = ?, shiny_image = ?, has_alternate_forms = ?,
                description = ?, lore_story = ?, how_to_obtain = ?,
                legendary_group = ?, abilities = ?, signature_move = ?, 
                height_m = ?, weight_kg = ?,
                is_event_exclusive = ?, games_available = ?
                WHERE id = ?";
            
            $update_stmt = mysqli_prepare($connection, $update_query);
            
            if ($update_stmt) {
                $has_alternate_forms = 0;
                
                // 29 parameters + 1 for id = 30 total
                mysqli_stmt_bind_param($update_stmt, "sisssisiiiiiiissssissssssddisi",
                    $name, $pokedex_number, $type1, $type2, 
                    $classification, $generation, $region,
                    $hp, $attack, $defense, $sp_attack, $sp_defense, $speed, 
                    $base_stat_total,
                    $regular_image, $thumbnail_image, $fullsize_image, $shiny_image, $has_alternate_forms,
                    $description, $lore_story, $how_to_obtain,
                    $legendary_group, $abilities, $signature_move, 
                    $height_m, $weight_kg,
                    $is_event_exclusive, $games_available,
                    $id
                );
                
                if (mysqli_stmt_execute($update_stmt)) {
                    mysqli_stmt_close($update_stmt);
                    db_disconnect($connection);
                    header("Location: view.php?id=" . $id);
                    exit;
                } else {
                    $errors[] = "Update failed: " . mysqli_stmt_error($update_stmt);
                }
                
                mysqli_stmt_close($update_stmt);
            } else {
                $errors[] = "Failed to prepare update: " . mysqli_error($connection);
            }
        }
    }
    
    // If errors, update $pokemon with POST data for form
    if (count($errors) > 0) {
        $pokemon = array_merge($pokemon, $_POST);
    }
}

$page_title = "Edit Pokemon - " . $pokemon['name'];
include('includes/header.php');
?>

<h1>Edit Pokemon: <?php echo h($pokemon['name']); ?></h1>

<?php if (count($errors) > 0): ?>
    <div class="alert alert-danger">
        <h5>Please fix the following errors:</h5>
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?php echo h($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="post" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
    <div class="row g-3">
        <!-- Basic Info -->
        <div class="col-md-6">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control" 
                   value="<?php echo h($pokemon['name']); ?>" required>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Pokedex Number *</label>
            <input type="number" name="pokedex_number" class="form-control" 
                   value="<?php echo h($pokemon['pokedex_number']); ?>" required>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Primary Type *</label>
            <select name="type1" class="form-select" required>
                <option value="">Select Type</option>
                <?php
                $types = ['Normal', 'Fire', 'Water', 'Electric', 'Grass', 'Ice', 'Fighting', 
                          'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost', 
                          'Dragon', 'Dark', 'Steel', 'Fairy'];
                foreach ($types as $type) {
                    $selected = ($pokemon['type1'] === $type) ? 'selected' : '';
                    echo "<option value=\"$type\" $selected>$type</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Secondary Type</label>
            <select name="type2" class="form-select">
                <option value="">None</option>
                <?php
                foreach ($types as $type) {
                    $selected = ($pokemon['type2'] === $type) ? 'selected' : '';
                    echo "<option value=\"$type\" $selected>$type</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Classification *</label>
            <select name="classification" class="form-select" required>
                <?php
                $classifications = ['Legendary', 'Mythical', 'Sub-Legendary', 'Ultra Beast', 'Paradox'];
                foreach ($classifications as $class) {
                    $selected = ($pokemon['classification'] === $class) ? 'selected' : '';
                    echo "<option value=\"$class\" $selected>$class</option>";
                }
                ?>
            </select>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Generation *</label>
            <select name="generation" class="form-select" required>
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <option value="<?php echo $i; ?>" 
                            <?php echo ($pokemon['generation'] == $i) ? 'selected' : ''; ?>>
                        Generation <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Region *</label>
            <input type="text" name="region" class="form-control" 
                   value="<?php echo h($pokemon['region']); ?>" required>
        </div>
        
        <!-- Stats -->
        <div class="col-12"><h4 class="mt-3">Base Stats *</h4></div>
        
        <div class="col-md-2">
            <label class="form-label">HP</label>
            <input type="number" name="hp" class="form-control" min="0"
                   value="<?php echo h($pokemon['hp']); ?>" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Attack</label>
            <input type="number" name="attack" class="form-control" min="0"
                   value="<?php echo h($pokemon['attack']); ?>" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Defense</label>
            <input type="number" name="defense" class="form-control" min="0"
                   value="<?php echo h($pokemon['defense']); ?>" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Sp. Attack</label>
            <input type="number" name="sp_attack" class="form-control" min="0"
                   value="<?php echo h($pokemon['sp_attack']); ?>" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Sp. Defense</label>
            <input type="number" name="sp_defense" class="form-control" min="0"
                   value="<?php echo h($pokemon['sp_defense']); ?>" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Speed</label>
            <input type="number" name="speed" class="form-control" min="0"
                   value="<?php echo h($pokemon['speed']); ?>" required>
        </div>
        
        <!-- Current Image -->
        <div class="col-12"><h4 class="mt-3">Current Image</h4></div>
        
        <?php if ($pokemon['thumbnail_image']): ?>
            <div class="col-12">
                <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                     alt="Current image" style="max-width: 200px;">
            </div>
        <?php endif; ?>
        
        <!-- New Image Upload -->
        <div class="col-12">
            <label class="form-label">Upload New Image (Optional)</label>
            <input type="file" name="pokemon_image" class="form-control" 
                   accept="image/jpeg,image/png,image/gif,image/webp">
            <div class="form-text">
                Leave empty to keep current image. Upload new to replace.
            </div>
        </div>
        
        <!-- Description -->
        <div class="col-12"><h4 class="mt-3">Description *</h4></div>
        
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required><?php echo h($pokemon['description']); ?></textarea>
        </div>
        
        <div class="col-12">
            <label class="form-label">Lore/Story</label>
            <textarea name="lore_story" class="form-control" rows="3"><?php echo h($pokemon['lore_story']); ?></textarea>
        </div>
        
        <div class="col-12">
            <label class="form-label">How to Obtain</label>
            <textarea name="how_to_obtain" class="form-control" rows="2"><?php echo h($pokemon['how_to_obtain']); ?></textarea>
        </div>
        
        <!-- Additional Info -->
        <div class="col-12"><h4 class="mt-3">Additional Information</h4></div>
        
        <div class="col-md-6">
            <label class="form-label">Legendary Group</label>
            <input type="text" name="legendary_group" class="form-control" 
                   value="<?php echo h($pokemon['legendary_group']); ?>">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Abilities</label>
            <input type="text" name="abilities" class="form-control" 
                   value="<?php echo h($pokemon['abilities']); ?>">
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Signature Move</label>
            <input type="text" name="signature_move" class="form-control" 
                   value="<?php echo h($pokemon['signature_move']); ?>">
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Height (m)</label>
            <input type="number" name="height_m" class="form-control" step="0.01" min="0"
                   value="<?php echo h($pokemon['height_m']); ?>">
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Weight (kg)</label>
            <input type="number" name="weight_kg" class="form-control" step="0.1" min="0"
                   value="<?php echo h($pokemon['weight_kg']); ?>">
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Games Available</label>
            <input type="text" name="games_available" class="form-control" 
                   value="<?php echo h($pokemon['games_available']); ?>">
        </div>
        
        <div class="col-md-6">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_event_exclusive" 
                       id="is_event_exclusive" value="1"
                       <?php echo ($pokemon['is_event_exclusive']) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_event_exclusive">
                    Event Exclusive
                </label>
            </div>
        </div>
        
        <!-- Buttons -->
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-warning">
                Update Pokemon
            </button>
            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </div>
</form>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>