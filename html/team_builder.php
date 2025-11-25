<?php
// team_builder.php - Team Builder with Stats Analysis
// Challenge Feature #15 - Custom Challenge
// Located in: html/team_builder.php

require_once '../data/connect.php';
session_start();

$pageTitle = 'Team Builder';

// Initialize team in session
if (!isset($_SESSION['team'])) {
    $_SESSION['team'] = [];
}

// TODO: Handle adding Pokemon to team
// if (isset($_GET['add'])) { ... }

// TODO: Handle removing Pokemon from team
// if (isset($_GET['remove'])) { ... }

// TODO: Handle clearing entire team
// if (isset($_GET['clear'])) { ... }

// If team has Pokemon, calculate statistics
if (!empty($_SESSION['team'])) {
    // TODO: Query database for selected Pokemon
    // TODO: Calculate average stats
    // TODO: Calculate type distribution
    // TODO: Calculate team weaknesses
    // TODO: Find strongest Pokemon in each category
}

include 'includes/header.php';
?>

<h2 class="mb-4"><i class="bi bi-people-fill"></i> Team Builder</h2>

<!-- SECTION 1: Current Team Display -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Your Team (<?= count($_SESSION['team']) ?>/6)</h5>
    </div>
    <div class="card-body">
        <?php if (empty($_SESSION['team'])): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> No Pokemon selected yet. Add some below!
            </div>
        <?php else: ?>
            <div class="row g-3 mb-3">
                <!-- TODO: Display selected Pokemon in Bootstrap cards
                <div class="col-lg-4 col-md-6">
                    <div class="card border-primary">
                        <img src="images/mewtwo.png" class="card-img-top" alt="Mewtwo">
                        <div class="card-body">
                            <h6 class="card-title">Mewtwo</h6>
                            <a href="team_builder.php?remove=150" class="btn btn-sm btn-danger w-100">
                                <i class="bi bi-x-circle"></i> Remove
                            </a>
                        </div>
                    </div>
                </div>
                -->
            </div>
            <a href="team_builder.php?clear=1" class="btn btn-warning">
                <i class="bi bi-trash"></i> Clear Team
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- SECTION 2: Team Analysis (only if team has Pokemon) -->
<?php if (!empty($_SESSION['team'])): ?>
<div class="row g-4 mb-4">
    <!-- Average Stats Card -->
    <div class="col-lg-6">
        <div class="card h-100 border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Average Stats</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Display calculated averages
                <div class="row">
                    <div class="col-6">HP: 100</div>
                    <div class="col-6">Attack: 108</div>
                    <div class="col-6">Defense: 104</div>
                    <div class="col-6">Sp. Attack: 120</div>
                    <div class="col-6">Sp. Defense: 111</div>
                    <div class="col-6">Speed: 98</div>
                </div>
                -->
            </div>
        </div>
    </div>
    
    <!-- Strongest Pokemon Card -->
    <div class="col-lg-6">
        <div class="card h-100 border-warning">
            <div class="card-header bg-warning">
                <h5 class="mb-0"><i class="bi bi-trophy-fill"></i> Strongest in Each Category</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Display strongest Pokemon
                <p><strong>Highest HP:</strong> Groudon (100)</p>
                <p><strong>Highest Attack:</strong> Groudon (150)</p>
                <p class="mb-0"><strong>🏆 Overall:</strong> Mewtwo (680)</p>
                -->
            </div>
        </div>
    </div>
    
    <!-- Type Distribution Card -->
    <div class="col-lg-6">
        <div class="card h-100 border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Type Distribution</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Display type counts with badges
                <span class="badge bg-primary me-2 mb-2">Flying: 3</span>
                <span class="badge bg-secondary me-2 mb-2">Psychic: 2</span>
                -->
            </div>
        </div>
    </div>
    
    <!-- Team Weaknesses Card -->
    <div class="col-lg-6">
        <div class="card h-100 border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Team Weaknesses</h5>
            </div>
            <div class="card-body">
                <!-- TODO: Display weaknesses with alert levels
                <div class="alert alert-danger mb-2">
                    <strong>🚨 CRITICAL:</strong> 4 Pokemon weak to Electric
                </div>
                <div class="alert alert-warning mb-2">
                    <strong>⚠️ WARNING:</strong> 3 Pokemon weak to Rock
                </div>
                -->
            </div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- SECTION 3: Available Pokemon to Add -->
<?php if (count($_SESSION['team']) < 6): ?>
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0"><i class="bi bi-plus-circle-fill"></i> Add Pokemon to Team</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!-- TODO: Display all Pokemon not in team
            <div class="col-lg-4 col-md-6">
                <div class="card">
                    <img src="images/mewtwo.png" class="card-img-top" alt="Mewtwo">
                    <div class="card-body">
                        <h6 class="card-title">Mewtwo</h6>
                        <p class="card-text small">
                            <span class="badge bg-primary">Psychic</span>
                            <span class="badge bg-secondary">BST: 680</span>
                        </p>
                        <a href="team_builder.php?add=150" class="btn btn-sm btn-success w-100">
                            <i class="bi bi-plus"></i> Add to Team
                        </a>
                    </div>
                </div>
            </div>
            -->
        </div>
    </div>
</div>
<?php else: ?>
<div class="alert alert-warning">
    <i class="bi bi-exclamation-triangle"></i> Team is full! Remove a Pokemon to add another.
</div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
