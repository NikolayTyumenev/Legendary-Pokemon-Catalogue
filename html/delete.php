<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();

$connection = db_connect();

$id = $_GET['id'] ?? 0;

$query = "SELECT * FROM pokemon WHERE id = ? LIMIT 1";
$stmt = mysqli_prepare($connection, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pokemon = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);

if (!$pokemon) {
    header('Location: browse.php');
    exit;
}

$page_title = "Delete Pokemon - " . $pokemon['name'];
include('includes/header.php');
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="browse.php">Browse</a></li>
        <li class="breadcrumb-item"><a href="view.php?id=<?php echo $id; ?>"><?php echo h($pokemon['name']); ?></a></li>
        <li class="breadcrumb-item active">Delete</li>
    </ol>
</nav>

<div class="card border-danger">
    <div class="card-header bg-danger text-white">
        <h4 class="mb-0">Delete Pokemon</h4>
    </div>
    <div class="card-body">
        <div class="alert alert-danger">
            <strong>Warning!</strong> You are about to permanently delete this Pokemon. This action cannot be undone.
        </div>
        
        <div class="row">
            <div class="col-md-3">
                <?php if ($pokemon['thumbnail_image']): ?>
                    <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                         class="img-fluid" alt="<?php echo h($pokemon['name']); ?>">
                <?php endif; ?>
            </div>
            <div class="col-md-9">
                <h3><?php echo h($pokemon['name']); ?> #<?php echo h($pokemon['pokedex_number']); ?></h3>
                <p>
                    <span class="badge bg-primary"><?php echo h($pokemon['type1']); ?></span>
                    <?php if ($pokemon['type2']): ?>
                        <span class="badge bg-secondary"><?php echo h($pokemon['type2']); ?></span>
                    <?php endif; ?>
                    <span class="badge bg-info"><?php echo h($pokemon['classification']); ?></span>
                </p>
                <p><?php echo h($pokemon['description']); ?></p>
                <p>
                    <strong>Generation:</strong> <?php echo h($pokemon['generation']); ?><br>
                    <strong>Region:</strong> <?php echo h($pokemon['region']); ?>
                </p>
            </div>
        </div>
        
        <hr>
        
        <p><strong>Are you absolutely sure you want to delete this Pokemon?</strong></p>
        
        <div class="btn-group" role="group">
            <a href="delete-confirmation.php?id=<?php echo $id; ?>" class="btn btn-danger">
                Yes, Delete Permanently
            </a>
            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-secondary">
                No, Cancel
            </a>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>