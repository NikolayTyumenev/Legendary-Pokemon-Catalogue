<?php
require_once('../private/connect.php');
$connection = db_connect();

$page_title = "Admin - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Admin Dashboard</h1>
<p class="lead">TODO: Manage Pokemon, users, and settings</p>

<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Pokemon</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Tags</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <h5>Total Images</h5>
                <h2>0</h2>
            </div>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
