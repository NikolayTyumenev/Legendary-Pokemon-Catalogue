<?php
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

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

$page_title = $pokemon['name'] . " - Pokemon Details";
include('includes/header.php');
?>

<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="index.php">Home</a></li>
        <li class="breadcrumb-item"><a href="browse.php">Browse</a></li>
        <li class="breadcrumb-item active"><?php echo h($pokemon['name']); ?></li>
    </ol>
</nav>

<div class="row">
    <div class="col-md-4">
        <?php if ($pokemon['fullsize_image']): ?>
            <img src="images/pokemon/fullsize/<?php echo h($pokemon['fullsize_image']); ?>" 
                 class="img-fluid rounded shadow" 
                 alt="<?php echo h($pokemon['name']); ?>">
        <?php else: ?>
            <div class="bg-light rounded p-5 text-center">
                <span class="text-muted">No Image Available</span>
            </div>
        <?php endif; ?>
    </div>
    
    <div class="col-md-8">
        <h1><?php echo h($pokemon['name']); ?> 
            <span class="text-muted">#<?php echo h($pokemon['pokedex_number']); ?></span>
        </h1>
        
        <p class="lead">
            <span class="badge bg-primary"><?php echo h($pokemon['type1']); ?></span>
            <?php if ($pokemon['type2']): ?>
                <span class="badge bg-secondary"><?php echo h($pokemon['type2']); ?></span>
            <?php endif; ?>
            <span class="badge bg-info"><?php echo h($pokemon['classification']); ?></span>
        </p>
        
        <div class="card mb-3">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">Base Stats</h5>
            </div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="40%">HP</th><td><?php echo h($pokemon['hp']); ?></td></tr>
                    <tr><th>Attack</th><td><?php echo h($pokemon['attack']); ?></td></tr>
                    <tr><th>Defense</th><td><?php echo h($pokemon['defense']); ?></td></tr>
                    <tr><th>Sp. Attack</th><td><?php echo h($pokemon['sp_attack']); ?></td></tr>
                    <tr><th>Sp. Defense</th><td><?php echo h($pokemon['sp_defense']); ?></td></tr>
                    <tr><th>Speed</th><td><?php echo h($pokemon['speed']); ?></td></tr>
                    <tr class="table-primary"><th><strong>Total</strong></th><td><strong><?php echo h($pokemon['base_stat_total']); ?></strong></td></tr>
                </table>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Description</div>
            <div class="card-body">
                <p><?php echo nl2br(h($pokemon['description'])); ?></p>
                
                <?php if ($pokemon['lore_story']): ?>
                    <h6>Lore & Story</h6>
                    <p><?php echo nl2br(h($pokemon['lore_story'])); ?></p>
                <?php endif; ?>
                
                <?php if ($pokemon['how_to_obtain']): ?>
                    <h6>How to Obtain</h6>
                    <p><?php echo nl2br(h($pokemon['how_to_obtain'])); ?></p>
                <?php endif; ?>
            </div>
        </div>
        
        <div class="card mb-3">
            <div class="card-header">Additional Information</div>
            <div class="card-body">
                <table class="table table-sm mb-0">
                    <tr><th width="40%">Generation</th><td><?php echo h($pokemon['generation']); ?></td></tr>
                    <tr><th>Region</th><td><?php echo h($pokemon['region']); ?></td></tr>
                    <?php if ($pokemon['legendary_group']): ?>
                        <tr><th>Group</th><td><?php echo h($pokemon['legendary_group']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['abilities']): ?>
                        <tr><th>Abilities</th><td><?php echo h($pokemon['abilities']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['signature_move']): ?>
                        <tr><th>Signature Move</th><td><?php echo h($pokemon['signature_move']); ?></td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['height_m']): ?>
                        <tr><th>Height</th><td><?php echo h($pokemon['height_m']); ?>m</td></tr>
                    <?php endif; ?>
                    <?php if ($pokemon['weight_kg']): ?>
                        <tr><th>Weight</th><td><?php echo h($pokemon['weight_kg']); ?>kg</td></tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
        
        <div class="btn-group" role="group">
            <?php if (is_logged_in()): ?>
                <a href="edit.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-warning">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <a href="delete.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-danger">
                    <i class="bi bi-trash"></i> Delete
                </a>
            <?php endif; ?>
            <a href="browse.php" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Back to Browse
            </a>
        </div>
    </div>
</div>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
