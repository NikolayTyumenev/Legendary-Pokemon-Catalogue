<?php
require_once('../private/connect.php');
$connection = db_connect();

$page_title = "Browse - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Browse Pokemon</h1>
<p class="lead">Explore all Legendary and Mythical Pokemon</p>

<div class="row g-4">
    <?php
    // TODO: Fetch all Pokemon from database
    // $query = "SELECT * FROM pokemon ORDER BY pokedex_number";
    // $result = mysqli_query($connection, $query);
    
    // Example card (replace with database loop)
    ?>
    
    <div class="col-lg-4 col-md-6">
        <div class="card h-100 shadow-sm">
            <img src="images/pokemon/placeholder.png" class="card-img-top" alt="Pokemon" style="height: 200px; object-fit: contain;">
            <div class="card-body">
                <h5 class="card-title">Pokemon Name #000</h5>
                <p class="card-text">
                    <span class="badge bg-primary">Type1</span>
                    <span class="badge bg-secondary">Type2</span>
                </p>
                <p class="card-text">
                    <small class="text-muted">Generation X | Classification</small>
                </p>
            </div>
            <div class="card-footer">
                <a href="view.php?id=1" class="btn btn-primary btn-sm w-100">
                    <i class="bi bi-eye"></i> View Details
                </a>
            </div>
        </div>
    </div>
    
    <!-- TODO: Loop through database results and create cards -->
    
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
