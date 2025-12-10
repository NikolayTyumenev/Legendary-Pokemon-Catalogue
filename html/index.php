<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
$connection = db_connect();

$page_title = "Home - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<div class="row">
    <div class="col-lg-12">
        <div class="hero-banner">
            <h1 class="display-4">Welcome to the Legendary & Mythical Pokémon Catalogue</h1>
            <p class="lead">
                Explore the rarest and most powerful Pokemon from all 9 generations. 
                Browse through 95 Legendary and Mythical Pokemon, build your ultimate team, 
                and discover their unique stats and abilities.
            </p>
            <hr class="my-4">
            <p>
                Get started by browsing the catalogue or building your perfect team!
            </p>
            <a class="btn btn-light btn-lg" href="browse.php" role="button">
                <i class="bi bi-grid-fill"></i> Browse Catalogue
            </a>
            <a class="btn btn-outline-light btn-lg" href="team_builder.php" role="button">
                <i class="bi bi-people-fill"></i> Team Builder
            </a>
        </div>
    </div>
</div>

<div class="row mt-5">
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-lightning-fill text-warning"></i> Legendary Pokemon</h5>
                <p class="card-text">
                    Discover powerful Legendary Pokemon from iconic groups like the Legendary Birds, 
                    Weather Trio, and Creation Trio.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-star-fill text-primary"></i> Mythical Pokemon</h5>
                <p class="card-text">
                    Explore rare Mythical Pokemon, often available only through special events 
                    and distributions.
                </p>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card h-100">
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-people-fill text-success"></i> Team Builder</h5>
                <p class="card-text">
                    Build your dream team of up to 6 Pokemon and analyze their stats, types, 
                    and weaknesses.
                </p>
            </div>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
