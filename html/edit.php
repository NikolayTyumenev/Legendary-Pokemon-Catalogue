<?php
// edit.php - Edit existing Pokemon
// Located in: html/edit.php

require_once '../data/connect.php';

$pageTitle = 'Edit Pokemon';

// TODO: Get Pokemon ID from URL
// TODO: Load existing Pokemon data
// TODO: Handle form submission
// TODO: Update database

include 'includes/header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Edit Pokemon</li>
    </ol>
</nav>

<h2 class="mb-4">Edit Pokemon</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="edit.php">
            <div class="row g-3">
                <!-- TODO: Add form fields pre-populated with existing data -->
                <!-- Use Bootstrap form-control, form-select classes -->
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-check-circle"></i> Update Pokemon
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
