<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');

require_login();  // redirect to login if not logged in
$connection = db_connect();

// Get stats
$count_query = "SELECT COUNT(*) as total FROM pokemon";
$count_result = mysqli_query($connection, $count_query);
$total_pokemon = mysqli_fetch_assoc($count_result)['total'];

$page_title = "Admin Dashboard";
include('includes/header.php');
?>

<h1>Admin Dashboard</h1>
<p class="lead">Welcome, <?php echo htmlspecialchars(get_current_username()); ?>!</p>

<div class="row g-4 mt-3">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Total Pokemon</h5>
                <h2 class="display-4"><?php echo $total_pokemon; ?></h2>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5 class="card-title">Quick Actions</h5>
                <a href="add.php" class="btn btn-light mt-2">
                    <i class="bi bi-plus-circle"></i> Add Pokemon
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <h5 class="card-title">Navigation</h5>
                <a href="browse.php" class="btn btn-light mt-2">
                    <i class="bi bi-grid-fill"></i> Browse Catalogue
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card mt-4">
    <div class="card-header">
        <h5 class="mb-0">Admin Menu</h5>
    </div>
    <div class="card-body">
        <div class="list-group">
            <a href="browse.php" class="list-group-item list-group-item-action">
                <i class="bi bi-grid-fill"></i> Browse All Pokemon
            </a>
            <a href="add.php" class="list-group-item list-group-item-action">
                <i class="bi bi-plus-circle"></i> Add New Pokemon
            </a>
            <a href="logout.php" class="list-group-item list-group-item-action text-danger">
                <i class="bi bi-box-arrow-right"></i> Logout
            </a>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
