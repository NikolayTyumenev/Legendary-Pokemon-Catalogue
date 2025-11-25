<?php
// search.php - Search and filter Pokemon
// Located in: html/search.php

require_once '../data/connect.php';

$pageTitle = 'Search Pokemon';

// TODO: Get search parameters from form
// TODO: Build dynamic SQL query with filters
// TODO: Display filtered results

include 'includes/header.php';
?>

<h2 class="mb-4">Search Legendary & Mythical Pokemon</h2>

<?php include 'includes/filter.php'; ?>

<div class="card">
    <div class="card-header bg-success text-white">
        <h5 class="mb-0"><i class="bi bi-list-check"></i> Search Results</h5>
    </div>
    <div class="card-body">
        <div class="row g-4">
            <!-- TODO: Display search results using Bootstrap cards (same format as index.php) -->
            <p class="text-muted">Apply filters above to search for Pokemon.</p>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
