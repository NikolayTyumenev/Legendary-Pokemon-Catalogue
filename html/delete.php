<?php
// delete.php - Delete Pokemon from catalogue
// Located in: html/delete.php

require_once '../data/connect.php';

$pageTitle = 'Delete Pokemon';

// TODO: Get Pokemon ID from URL
// TODO: Show confirmation message
// TODO: Handle deletion confirmation
// TODO: Delete from database

include 'includes/header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Delete Pokemon</li>
    </ol>
</nav>

<h2 class="mb-4 text-danger"><i class="bi bi-exclamation-triangle-fill"></i> Delete Pokemon</h2>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h5 class="mb-0">Confirm Deletion</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <i class="bi bi-exclamation-triangle-fill"></i> 
            <strong>Warning!</strong> This action cannot be undone.
        </div>
        
        <!-- TODO: Display Pokemon details being deleted -->
        <p>Are you sure you want to delete this Pokemon?</p>
        
        <form method="POST" action="delete.php" class="mt-3">
            <button type="submit" name="confirm" class="btn btn-danger">
                <i class="bi bi-trash-fill"></i> Confirm Delete
            </button>
            <a href="index.php" class="btn btn-secondary">
                <i class="bi bi-x-circle"></i> Cancel
            </a>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
