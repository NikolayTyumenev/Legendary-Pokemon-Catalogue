<?php
require_once('../private/connect.php');
$connection = db_connect();

$page_title = "Delete Pokemon - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h4 class="mb-0"><i class="bi bi-exclamation-triangle-fill"></i> Delete Pokemon</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <strong>Warning!</strong> You are about to delete this Pokemon. This action cannot be undone.
        </div>
        
        <h5>Pokemon Name #000</h5>
        <p>Type1 / Type2 | Generation X</p>
        
        <a href="delete-confirmation.php?id=1" class="btn btn-danger">
            <i class="bi bi-trash"></i> Confirm Delete
        </a>
        <a href="view.php?id=1" class="btn btn-secondary">
            <i class="bi bi-x-circle"></i> Cancel
        </a>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
