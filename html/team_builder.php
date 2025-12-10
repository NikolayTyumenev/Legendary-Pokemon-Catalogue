<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
$connection = db_connect();

$page_title = "Team Builder - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Team Builder <span class="badge bg-success">Custom Challenge #15</span></h1>
<p class="lead">Select up to 6 Pokemon and analyze your team composition</p>

<!-- Current Team Section -->
<div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Your Team (0/6)</h5>
    </div>
    <div class="card-body">
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> Your team is empty. Add Pokemon from the list below.
        </div>
        <!-- Team display will be implemented in Milestone 3 -->
    </div>
</div>

<!-- Team Analysis (Only shown when team has Pokemon) -->
<div class="row mb-4">
    <!-- Average Stats -->
    <div class="col-lg-6 mb-3">
        <div class="card border-success">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0"><i class="bi bi-graph-up"></i> Average Stats</h5>
            </div>
            <div class="card-body">
                <p>Calculate and display average stats</p>
            </div>
        </div>
    </div>
    
    <!-- Type Distribution -->
    <div class="col-lg-6 mb-3">
        <div class="card border-info">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0"><i class="bi bi-pie-chart-fill"></i> Type Distribution</h5>
            </div>
            <div class="card-body">
                <p>Show type counts with badges</p>
            </div>
        </div>
    </div>
    
    <!-- Strongest Pokemon -->
    <div class="col-lg-6 mb-3">
        <div class="card border-warning">
            <div class="card-header bg-warning text-dark">
                <h5 class="mb-0"><i class="bi bi-trophy-fill"></i> Strongest in Each Category</h5>
            </div>
            <div class="card-body">
                <p>Show Pokemon with highest in each stat</p>
            </div>
        </div>
    </div>
    
    <!-- Team Weaknesses -->
    <div class="col-lg-6 mb-3">
        <div class="card border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Team Weaknesses</h5>
            </div>
            <div class="card-body">
                <p>Analyze shared weaknesses</p>
            </div>
        </div>
    </div>
</div>

<!-- Available Pokemon -->
<div class="card">
    <div class="card-header bg-secondary text-white">
        <h5 class="mb-0">Available Pokemon</h5>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <!-- Pokemon selection will be implemented in Milestone 3 -->
            <p>Load Pokemon from database</p>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
