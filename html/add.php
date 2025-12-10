<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();

$connection = db_connect();

$errors = [];
$success_message = '';

// Handle form submission
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

    // Additional info
    $legendary_group = trim($_POST['legendary_group'] ?? '');
    $abilities = trim($_POST['abilities'] ?? '');
    $signature_move = trim($_POST['signature_move'] ?? '');
    $height_m = $_POST['height_m'] ?? null;
    $weight_kg = $_POST['weight_kg'] ?? null;
    $is_event_exclusive = isset($_POST['is_event_exclusive']) ? 1 : 0;
    $games_available = trim($_POST['games_available'] ?? '');

    // VALIDATION
    if (empty($name)) {
        $errors[] = "Name is required";
    }

    if (!is_numeric($pokedex_number) || $pokedex_number < 1) {
        $errors[] = "Pokedex number must be a positive number";
    }

    if (empty($type1)) {
        $errors[] = "Primary type is required";
    }

    if (empty($classification)) {
        $errors[] = "Classification is required";
    }

    if (!is_numeric($generation) || $generation < 1 || $generation > 9) {
        $errors[] = "Generation must be between 1 and 9";
    }

    if (empty($region)) {
        $errors[] = "Region is required";
    }

    // Validate stats
    $stat_fields = ['hp', 'attack', 'defense', 'sp_attack', 'sp_defense', 'speed'];
    foreach ($stat_fields as $field) {
        if (!is_numeric($$field) || $$field < 0) {
            $errors[] = ucfirst(str_replace('_', ' ', $field)) . " must be a non-negative number";
        }
    }

    if (empty($description)) {
        $errors[] = "Description is required";
    }

    // Image validation
    if (!isset($_FILES['pokemon_image']) || $_FILES['pokemon_image']['error'] === UPLOAD_ERR_NO_FILE) {
        $errors[] = "Pokemon image is required";
    }

    // If no errors, process and insert
    if (count($errors) === 0) {
        // Process image upload
        $image_result = process_pokemon_image($_FILES['pokemon_image']);

        if ($image_result['success']) {
            // Calculate base stat total
            $base_stat_total = $hp + $attack + $defense + $sp_attack + $sp_defense + $speed;

            // Empty type2 should be NULL
            if (empty($type2)) {
                $type2 = null;
            }

            // Prepare INSERT statement
            // Column order MUST match database schema exactly:
            // regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms
            $query = "INSERT INTO pokemon (
                name, pokedex_number, type1, type2, classification, generation, region,
                hp, attack, defense, sp_attack, sp_defense, speed, base_stat_total,
                regular_image, thumbnail_image, fullsize_image, shiny_image, has_alternate_forms,
                description, lore_story, how_to_obtain,
                legendary_group, abilities, signature_move, height_m, weight_kg,
                is_event_exclusive, games_available
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = mysqli_prepare($connection, $query);

            if ($stmt) {
                // Use fullsize as regular_image too
                $regular_image = $image_result['fullsize'];
                $thumbnail_image = $image_result['thumbnail'];
                $fullsize_image = $image_result['fullsize'];
                $shiny_image = NULL;  // No shiny image for now
                $has_alternate_forms = 0;

                // 29 parameters total, type string has 29 characters
                // Order matches column order in database
                mysqli_stmt_bind_param(
                    $stmt,
                    "sisssisiiiiiiissssissssssddis",
                    $name,
                    $pokedex_number,
                    $type1,
                    $type2,
                    $classification,
                    $generation,
                    $region,
                    $hp,
                    $attack,
                    $defense,
                    $sp_attack,
                    $sp_defense,
                    $speed,
                    $base_stat_total,
                    $regular_image,
                    $thumbnail_image,
                    $fullsize_image,
                    $shiny_image,
                    $has_alternate_forms,
                    $description,
                    $lore_story,
                    $how_to_obtain,
                    $legendary_group,
                    $abilities,
                    $signature_move,
                    $height_m,
                    $weight_kg,
                    $is_event_exclusive,
                    $games_available
                );

                if (mysqli_stmt_execute($stmt)) {
                    $inserted_id = mysqli_insert_id($connection);
                    mysqli_stmt_close($stmt);
                    
                    set_success_message("Pokemon '{$name}' added successfully!");
                    
                    db_disconnect($connection);
                    header("Location: view.php?id=" . $inserted_id);
                    exit;
                }

                mysqli_stmt_close($stmt);
            } else {
                $errors[] = "Failed to prepare statement: " . mysqli_error($connection);
            }
        } else {
            $errors[] = "Image upload error: " . $image_result['error'];
        }
    }
}

$page_title = "Add Pokemon";
include('includes/header.php');
?>

<h1>Add New Pokemon</h1>

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

<form method="post" action="add.php" enctype="multipart/form-data">
    <div class="row g-3">
        <!-- Basic Info -->
        <div class="col-md-6">
            <label class="form-label">Name *</label>
            <input type="text" name="name" class="form-control"
                value="<?php echo h($_POST['name'] ?? ''); ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Pokedex Number *</label>
            <input type="number" name="pokedex_number" class="form-control"
                value="<?php echo h($_POST['pokedex_number'] ?? ''); ?>" required>
        </div>

        <div class="col-md-4">
            <label class="form-label">Primary Type *</label>
            <select name="type1" class="form-select" required>
                <option value="">Select Type</option>
                <?php
                $types = [
                    'Normal', 'Fire', 'Water', 'Electric', 'Grass', 'Ice', 'Fighting',
                    'Poison', 'Ground', 'Flying', 'Psychic', 'Bug', 'Rock', 'Ghost',
                    'Dragon', 'Dark', 'Steel', 'Fairy'
                ];
                foreach ($types as $type) {
                    $selected = (isset($_POST['type1']) && $_POST['type1'] === $type) ? 'selected' : '';
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
                    $selected = (isset($_POST['type2']) && $_POST['type2'] === $type) ? 'selected' : '';
                    echo "<option value=\"$type\" $selected>$type</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-4">
            <label class="form-label">Classification *</label>
            <select name="classification" class="form-select" required>
                <option value="">Select Classification</option>
                <?php
                $classifications = ['Legendary', 'Mythical', 'Sub-Legendary', 'Ultra Beast', 'Paradox'];
                foreach ($classifications as $class) {
                    $selected = (isset($_POST['classification']) && $_POST['classification'] === $class) ? 'selected' : '';
                    echo "<option value=\"$class\" $selected>$class</option>";
                }
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Generation *</label>
            <select name="generation" class="form-select" required>
                <option value="">Select Generation</option>
                <?php for ($i = 1; $i <= 9; $i++): ?>
                    <option value="<?php echo $i; ?>"
                        <?php echo (isset($_POST['generation']) && $_POST['generation'] == $i) ? 'selected' : ''; ?>>
                        Generation <?php echo $i; ?>
                    </option>
                <?php endfor; ?>
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Region *</label>
            <input type="text" name="region" class="form-control"
                value="<?php echo h($_POST['region'] ?? ''); ?>"
                placeholder="e.g., Kanto, Johto, Hoenn" required>
        </div>

        <!-- Stats -->
        <div class="col-12">
            <h4 class="mt-3">Base Stats *</h4>
        </div>

        <div class="col-md-2">
            <label class="form-label">HP</label>
            <input type="number" name="hp" class="form-control" min="0"
                value="<?php echo h($_POST['hp'] ?? ''); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Attack</label>
            <input type="number" name="attack" class="form-control" min="0"
                value="<?php echo h($_POST['attack'] ?? ''); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Defense</label>
            <input type="number" name="defense" class="form-control" min="0"
                value="<?php echo h($_POST['defense'] ?? ''); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Sp. Attack</label>
            <input type="number" name="sp_attack" class="form-control" min="0"
                value="<?php echo h($_POST['sp_attack'] ?? ''); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Sp. Defense</label>
            <input type="number" name="sp_defense" class="form-control" min="0"
                value="<?php echo h($_POST['sp_defense'] ?? ''); ?>" required>
        </div>

        <div class="col-md-2">
            <label class="form-label">Speed</label>
            <input type="number" name="speed" class="form-control" min="0"
                value="<?php echo h($_POST['speed'] ?? ''); ?>" required>
        </div>

        <!-- Image Upload -->
        <div class="col-12">
            <h4 class="mt-3">Image Upload *</h4>
        </div>

        <div class="col-12">
            <label class="form-label">Pokemon Image</label>
            <input type="file" name="pokemon_image" class="form-control"
                accept="image/jpeg,image/png,image/gif,image/webp" required>
            <div class="form-text">
                JPG, PNG, GIF, or WEBP. Max 5MB. Will create 200px thumbnail and 720px full-size.
            </div>
        </div>

        <!-- Description -->
        <div class="col-12">
            <h4 class="mt-3">Description *</h4>
        </div>

        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="3" required><?php echo h($_POST['description'] ?? ''); ?></textarea>
        </div>

        <div class="col-12">
            <label class="form-label">Lore/Story (Optional)</label>
            <textarea name="lore_story" class="form-control" rows="3"><?php echo h($_POST['lore_story'] ?? ''); ?></textarea>
        </div>

        <div class="col-12">
            <label class="form-label">How to Obtain (Optional)</label>
            <textarea name="how_to_obtain" class="form-control" rows="2"><?php echo h($_POST['how_to_obtain'] ?? ''); ?></textarea>
        </div>

        <!-- Additional Info -->
        <div class="col-12">
            <h4 class="mt-3">Additional Information (Optional)</h4>
        </div>

        <div class="col-md-6">
            <label class="form-label">Legendary Group</label>
            <input type="text" name="legendary_group" class="form-control"
                value="<?php echo h($_POST['legendary_group'] ?? ''); ?>"
                placeholder="e.g., Legendary Birds, Weather Trio">
        </div>

        <div class="col-md-6">
            <label class="form-label">Abilities</label>
            <input type="text" name="abilities" class="form-control"
                value="<?php echo h($_POST['abilities'] ?? ''); ?>"
                placeholder="e.g., Pressure, Unnerve">
        </div>

        <div class="col-md-4">
            <label class="form-label">Signature Move</label>
            <input type="text" name="signature_move" class="form-control"
                value="<?php echo h($_POST['signature_move'] ?? ''); ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Height (meters)</label>
            <input type="number" name="height_m" class="form-control" step="0.01" min="0"
                value="<?php echo h($_POST['height_m'] ?? ''); ?>">
        </div>

        <div class="col-md-4">
            <label class="form-label">Weight (kg)</label>
            <input type="number" name="weight_kg" class="form-control" step="0.1" min="0"
                value="<?php echo h($_POST['weight_kg'] ?? ''); ?>">
        </div>

        <div class="col-md-6">
            <label class="form-label">Games Available</label>
            <input type="text" name="games_available" class="form-control"
                value="<?php echo h($_POST['games_available'] ?? ''); ?>"
                placeholder="e.g., RBY, GSC, FRLG, HGSS">
        </div>

        <div class="col-md-6">
            <div class="form-check mt-4">
                <input class="form-check-input" type="checkbox" name="is_event_exclusive"
                    id="is_event_exclusive" value="1"
                    <?php echo (isset($_POST['is_event_exclusive'])) ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_event_exclusive">
                    Event Exclusive
                </label>
            </div>
        </div>

        <!-- Buttons -->
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-success">
                Add Pokemon
            </button>
            <a href="browse.php" class="btn btn-secondary">
                Cancel
            </a>
        </div>
    </div>
</form>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>