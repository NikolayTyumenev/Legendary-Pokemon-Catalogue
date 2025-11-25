<?php
// detail.php - Individual Pokemon detail page
// Located in: html/detail.php

require_once '../data/connect.php';

$pageTitle = 'Pokemon Details';

// TODO: Get Pokemon ID from URL parameter
// TODO: Query database for Pokemon details
// TODO: Handle invalid ID

include 'includes/header.php';
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item active">Pokemon Details</li>
    </ol>
</nav>

<div class="row">
    <!-- TODO: Display Pokemon details using Bootstrap grid and cards -->
    <!-- Example layout:
    
    <div class="col-md-4">
        <div class="card">
            <img src="images/mewtwo.png" class="card-img-top" alt="Mewtwo">
            <div class="card-body">
                <h5 class="card-title">Image Gallery</h5>
                <div class="btn-group w-100" role="group">
                    <button class="btn btn-sm btn-outline-primary">Regular</button>
                    <button class="btn btn-sm btn-outline-primary">Shiny</button>
                    <button class="btn btn-sm btn-outline-primary">Mega</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Mewtwo #150</h4>
            </div>
            <div class="card-body">
                <p><span class="badge bg-primary">Psychic</span> <span class="badge bg-info">Legendary</span></p>
                <p class="card-text">Description here...</p>
                
                <h5 class="mt-4">Base Stats</h5>
                <div class="row">
                    <div class="col-md-6">HP: 106</div>
                    <div class="col-md-6">Attack: 110</div>
                </div>
            </div>
        </div>
        
        <div class="btn-group">
            <a href="edit.php?id=150" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="delete.php?id=150" class="btn btn-danger">
                <i class="bi bi-trash"></i> Delete
            </a>
        </div>
    </div>
    
    -->
</div>

<?php include 'includes/footer.php'; ?>
