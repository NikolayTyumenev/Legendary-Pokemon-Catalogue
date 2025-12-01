<?php
require_once('../private/connect.php');
$connection = db_connect();

$page_title = "Add Pokemon - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Add New Pokemon</h1>

<form method="post" action="add.php" enctype="multipart/form-data">
    <div class="row g-3">
        <!-- Basic Info -->
        <div class="col-md-6">
            <label class="form-label">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Pokedex Number</label>
            <input type="number" name="pokedex_number" class="form-control" required>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Primary Type</label>
            <select name="type1" class="form-select" required>
                <option value="">Select Type</option>
                <option value="Fire">Fire</option>
                <option value="Water">Water</option>
                <option value="Psychic">Psychic</option>
                <!-- TODO: Add all types -->
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Secondary Type</label>
            <select name="type2" class="form-select">
                <option value="">None</option>
                <option value="Flying">Flying</option>
                <!-- TODO: Add all types -->
            </select>
        </div>
        
        <div class="col-md-4">
            <label class="form-label">Classification</label>
            <select name="classification" class="form-select" required>
                <option value="Legendary">Legendary</option>
                <option value="Mythical">Mythical</option>
                <option value="Ultra Beast">Ultra Beast</option>
            </select>
        </div>
        
        <!-- Stats -->
        <div class="col-12"><h4 class="mt-3">Base Stats</h4></div>
        
        <div class="col-md-2">
            <label class="form-label">HP</label>
            <input type="number" name="hp" class="form-control" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Attack</label>
            <input type="number" name="attack" class="form-control" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Defense</label>
            <input type="number" name="defense" class="form-control" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Sp. Attack</label>
            <input type="number" name="sp_attack" class="form-control" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Sp. Defense</label>
            <input type="number" name="sp_defense" class="form-control" required>
        </div>
        
        <div class="col-md-2">
            <label class="form-label">Speed</label>
            <input type="number" name="speed" class="form-control" required>
        </div>
        
        <!-- Images -->
        <div class="col-12"><h4 class="mt-3">Images</h4></div>
        
        <div class="col-md-6">
            <label class="form-label">Regular Image</label>
            <input type="file" name="regular_image" class="form-control" accept="image/*" required>
        </div>
        
        <div class="col-md-6">
            <label class="form-label">Shiny Image</label>
            <input type="file" name="shiny_image" class="form-control" accept="image/*">
        </div>
        
        <!-- Description -->
        <div class="col-12">
            <label class="form-label">Description</label>
            <textarea name="description" class="form-control" rows="4" required></textarea>
        </div>
        
        <!-- Tags (TODO: Fetch from tags table) -->
        <div class="col-12"><h4 class="mt-3">Tags</h4></div>
        <div class="col-12">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="tags[]" value="1" id="tag1">
                <label class="form-check-label" for="tag1">Legendary</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="checkbox" name="tags[]" value="2" id="tag2">
                <label class="form-check-label" for="tag2">Generation 1</label>
            </div>
            <!-- TODO: Load tags from database -->
        </div>
        
        <!-- Buttons -->
        <div class="col-12 mt-4">
            <button type="submit" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Add Pokemon
            </button>
            <a href="browse.php" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </div>
    </div>
</form>

<?php
// TODO: Handle form submission
// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     // Validate and insert into database
// }

db_disconnect($connection);
include('includes/footer.php');
?>
