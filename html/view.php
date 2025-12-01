<?php
require_once('../private/connect.php');
$connection = db_connect();

// TODO: Get Pokemon ID from URL parameter
// $id = $_GET['id'] ?? 1;
// $query = "SELECT * FROM pokemon WHERE id = ?";

$page_title = "View Pokemon - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="browse.php">Browse</a></li>
        <li class="breadcrumb-item active">Pokemon Name</li>
    </ol>
</nav>

<div class="row">
    <!-- Image Gallery -->
    <div class="col-md-4">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Images</h5>
            </div>
            <div class="card-body">
                <img src="images/pokemon/placeholder.png" class="img-fluid mb-3" alt="Regular">
                <!-- TODO: Display pokemon_images gallery -->
                <div class="btn-group w-100" role="group">
                    <button type="button" class="btn btn-sm btn-outline-primary">Regular</button>
                    <button type="button" class="btn btn-sm btn-outline-primary">Shiny</button>
                    <button type="button" class="btn btn-sm btn-outline-primary">Mega</button>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Details -->
    <div class="col-md-8">
        <h1>Pokemon Name <span class="text-muted">#000</span></h1>
        
        <!-- Types and Tags -->
        <p>
            <span class="badge bg-primary">Type1</span>
            <span class="badge bg-secondary">Type2</span>
            <span class="badge bg-info">Tag1</span>
            <span class="badge bg-info">Tag2</span>
        </p>
        
        <!-- Base Stats -->
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Base Stats</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm">
                    <tr><th>HP</th><td>000</td></tr>
                    <tr><th>Attack</th><td>000</td></tr>
                    <tr><th>Defense</th><td>000</td></tr>
                    <tr><th>Sp. Attack</th><td>000</td></tr>
                    <tr><th>Sp. Defense</th><td>000</td></tr>
                    <tr><th>Speed</th><td>000</td></tr>
                    <tr class="table-primary"><th>Total</th><td><strong>000</strong></td></tr>
                </table>
            </div>
        </div>
        
        <!-- Description -->
        <div class="card mb-3">
            <div class="card-header">Description</div>
            <div class="card-body">
                <p>Pokemon description here...</p>
            </div>
        </div>
        
        <!-- Actions -->
        <a href="edit.php?id=1" class="btn btn-warning">
            <i class="bi bi-pencil"></i> Edit
        </a>
        <a href="delete.php?id=1" class="btn btn-danger">
            <i class="bi bi-trash"></i> Delete
        </a>
        <a href="browse.php" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Browse
        </a>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
