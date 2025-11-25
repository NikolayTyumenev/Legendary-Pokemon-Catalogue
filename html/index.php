<?php
// index.php - Main catalogue listing page
// Located in: html/index.php

require_once '../data/connect.php';
session_start();

$pageTitle = 'Home - Legendary Pokemon Catalogue';

// TODO: Query all Pokemon from database
// TODO: Add sorting options
// TODO: Add pagination

include 'includes/header.php';
?>

<h2 class="mb-4">All Legendary & Mythical Pokemon</h2>

<!-- TODO: Add sorting dropdown -->

<div class="row g-4">
    <!-- TODO: Loop through Pokemon and display cards -->
    <!-- Example Bootstrap card structure:
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 shadow-sm">
            <img src="images/mewtwo.png" class="card-img-top" alt="Mewtwo">
            <div class="card-body">
                <h5 class="card-title">Mewtwo</h5>
                <p class="card-text">
                    <span class="badge bg-primary">Psychic</span>
                    <span class="badge bg-secondary">Gen 1</span>
                </p>
                <p class="card-text text-muted">
                    <small>Legendary | Kanto | BST: 680</small>
                </p>
            </div>
            <div class="card-footer bg-transparent">
                <a href="detail.php?id=150" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-eye"></i> View Details
                </a>
            </div>
        </div>
    </div>
    
    -->
</div>

<?php include 'includes/footer.php'; ?>
