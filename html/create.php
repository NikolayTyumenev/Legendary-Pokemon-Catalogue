<?php
// create.php - Add new Pokemon to catalogue
// Located in: html/create.php

require_once '../data/connect.php';

$pageTitle = 'Add New Pokemon';

// TODO: Handle form submission
// TODO: Validate input data
// TODO: Insert into database
// TODO: Handle image upload

include 'includes/header.php';
?>

<h2 class="mb-4">Add New Pokemon</h2>

<div class="card">
    <div class="card-body">
        <form method="POST" action="create.php" enctype="multipart/form-data">
            <div class="row g-3">
                <!-- TODO: Add form fields using Bootstrap form-control, form-select classes -->
                <!-- Example:
                <div class="col-md-6">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                
                <div class="col-md-6">
                    <label for="type1" class="form-label">Primary Type</label>
                    <select class="form-select" id="type1" name="type1" required>
                        <option value="">Select Type</option>
                        <option value="Fire">Fire</option>
                        ...
                    </select>
                </div>
                -->
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-plus-circle"></i> Add Pokemon
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="bi bi-x-circle"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
