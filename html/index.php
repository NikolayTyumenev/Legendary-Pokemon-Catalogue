<?php
$page_title = "Home - Pokemon Catalogue";
include('includes/header.php');
?>

<div class="jumbotron bg-light p-5 rounded">
    <h1 class="display-4">Welcome to the Legendary & Mythical Pokemon Catalogue</h1>
    <p class="lead">Explore the most powerful and rare Pokemon across all generations!</p>
    <hr class="my-4">
    <p>Browse through our comprehensive collection of Legendary and Mythical Pokemon, build your dream team, and compare their stats.</p>
    <a class="btn btn-primary btn-lg" href="browse.php" role="button">Browse Pokemon</a>
    <a class="btn btn-success btn-lg" href="team_builder.php" role="button">Team Builder</a>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h2>🔍</h2>
                <h5>Search & Filter</h5>
                <p>Find Pokemon by name, type, generation, or classification with advanced filtering options.</p>
                <a href="browse.php" class="btn btn-primary">Start Browsing</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h2>👥</h2>
                <h5>Team Builder</h5>
                <p>Create your ultimate team of up to 6 Pokemon and analyze their stats and type coverage.</p>
                <a href="team_builder.php" class="btn btn-success">Build Team</a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-body text-center">
                <h2>⚔️</h2>
                <h5>Compare Pokemon</h5>
                <p>Compare stats between Pokemon to find the strongest additions to your team.</p>
                <a href="team_builder.php" class="btn btn-info">Compare Now</a>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>