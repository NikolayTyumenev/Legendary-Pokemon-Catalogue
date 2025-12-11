<?php
// Start output buffering to allow headers after HTML output
ob_start();

$page_title = "Team Builder";
include('includes/header.php');

require_once('../private/connect.php');
require_once('../private/functions.php');

$connection = db_connect();

// Handle add to team
if (isset($_POST['add_to_team'])) {
    $pokemon_id = (int)$_POST['pokemon_id'];
    if (count($_SESSION['team']) < 6 && !in_array($pokemon_id, $_SESSION['team'])) {
        $_SESSION['team'][] = $pokemon_id;
    }
    ob_end_clean();
    header('Location: team_builder.php');
    exit;
}

// Handle remove from team
if (isset($_POST['remove_from_team'])) {
    $pokemon_id = (int)$_POST['pokemon_id'];
    $_SESSION['team'] = array_values(array_diff($_SESSION['team'], [$pokemon_id]));
    ob_end_clean();
    header('Location: team_builder.php');
    exit;
}

// Handle clear team
if (isset($_POST['clear_team'])) {
    $_SESSION['team'] = [];
    ob_end_clean();
    header('Location: team_builder.php');
    exit;
}

// Get team Pokemon details
$team_pokemon = [];
if (!empty($_SESSION['team'])) {
    $placeholders = implode(',', array_fill(0, count($_SESSION['team']), '?'));
    $query = "SELECT * FROM pokemon WHERE id IN ($placeholders)";
    $stmt = mysqli_prepare($connection, $query);
    $types = str_repeat('i', count($_SESSION['team']));
    mysqli_stmt_bind_param($stmt, $types, ...$_SESSION['team']);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while ($row = mysqli_fetch_assoc($result)) {
        $team_pokemon[] = $row;
    }
    mysqli_stmt_close($stmt);
}

// Calculate team stats and find strongest
$total_hp = 0;
$total_attack = 0;
$total_defense = 0;
$total_sp_attack = 0;
$total_sp_defense = 0;
$total_speed = 0;
$type_coverage = [];
$strongest_pokemon = null;
$highest_bst = 0;

foreach ($team_pokemon as $pokemon) {
    $total_hp += $pokemon['hp'];
    $total_attack += $pokemon['attack'];
    $total_defense += $pokemon['defense'];
    $total_sp_attack += $pokemon['sp_attack'];
    $total_sp_defense += $pokemon['sp_defense'];
    $total_speed += $pokemon['speed'];
    
    $type_coverage[$pokemon['type1']] = true;
    if ($pokemon['type2']) {
        $type_coverage[$pokemon['type2']] = true;
    }
    
    // Find strongest (highest base stat total)
    if ($pokemon['base_stat_total'] > $highest_bst) {
        $highest_bst = $pokemon['base_stat_total'];
        $strongest_pokemon = $pokemon;
    }
}
?>

<h1>Pokemon Team Builder</h1>

<div class="row">
    <!-- Current Team -->
    <div class="col-md-8">
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4>Your Team (<?php echo count($_SESSION['team']); ?>/6)</h4>
                <?php if (!empty($_SESSION['team'])): ?>
                    <form method="post" style="display: inline;">
                        <button type="submit" name="clear_team" class="btn btn-sm btn-danger">Clear Team</button>
                    </form>
                <?php endif; ?>
            </div>
            <div class="card-body">
                <?php if (empty($team_pokemon)): ?>
                    <p class="text-muted">Your team is empty. Browse Pokemon and add them to your team!</p>
                    <a href="browse.php" class="btn btn-primary">Browse Pokemon</a>
                <?php else: ?>
                    <div class="row">
                        <?php foreach ($team_pokemon as $pokemon): ?>
                            <div class="col-md-4 mb-3">
                                <div class="card <?php echo $strongest_pokemon && $pokemon['id'] == $strongest_pokemon['id'] ? 'border-warning border-3' : ''; ?>">
                                    <?php if ($pokemon['thumbnail_image']): ?>
                                        <img src="images/pokemon/thumbnails/<?php echo h($pokemon['thumbnail_image']); ?>" 
                                             class="card-img-top" alt="<?php echo h($pokemon['name']); ?>">
                                    <?php else: ?>
                                        <div class="bg-secondary text-white text-center p-3">No Image</div>
                                    <?php endif; ?>
                                    <div class="card-body">
                                        <h6>
                                            <?php echo h($pokemon['name']); ?>
                                            <?php if ($strongest_pokemon && $pokemon['id'] == $strongest_pokemon['id']): ?>
                                                <span class="badge bg-warning">👑 Strongest</span>
                                            <?php endif; ?>
                                        </h6>
                                        <p class="small mb-1">
                                            <span class="badge bg-primary"><?php echo h($pokemon['type1']); ?></span>
                                            <?php if ($pokemon['type2']): ?>
                                                <span class="badge bg-secondary"><?php echo h($pokemon['type2']); ?></span>
                                            <?php endif; ?>
                                        </p>
                                        <p class="small mb-2">
                                            <strong>BST:</strong> <?php echo h($pokemon['base_stat_total']); ?>
                                        </p>
                                        <div class="btn-group w-100" role="group">
                                            <a href="view.php?id=<?php echo $pokemon['id']; ?>" class="btn btn-sm btn-info">View</a>
                                            <form method="post" class="flex-fill">
                                                <input type="hidden" name="pokemon_id" value="<?php echo $pokemon['id']; ?>">
                                                <button type="submit" name="remove_from_team" class="btn btn-sm btn-danger w-100">Remove</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Comparison Tool (if 2+ Pokemon) -->
        <?php if (count($team_pokemon) >= 2): ?>
            <div class="card mb-4">
                <div class="card-header">
                    <h5>📊 Compare Team Members</h5>
                </div>
                <div class="card-body">
                    <form method="get" class="row g-2">
                        <div class="col-md-5">
                            <select name="compare_id1" class="form-select" required>
                                <option value="">Select Pokemon 1</option>
                                <?php foreach ($team_pokemon as $p): ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo (isset($_GET['compare_id1']) && $_GET['compare_id1'] == $p['id']) ? 'selected' : ''; ?>>
                                        #<?php echo h($p['pokedex_number']); ?> - <?php echo h($p['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-2 text-center">
                            <strong class="d-block mt-2">VS</strong>
                        </div>
                        <div class="col-md-5">
                            <select name="compare_id2" class="form-select" required>
                                <option value="">Select Pokemon 2</option>
                                <?php foreach ($team_pokemon as $p): ?>
                                    <option value="<?php echo $p['id']; ?>" <?php echo (isset($_GET['compare_id2']) && $_GET['compare_id2'] == $p['id']) ? 'selected' : ''; ?>>
                                        #<?php echo h($p['pokedex_number']); ?> - <?php echo h($p['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">Compare</button>
                        </div>
                    </form>
                    
                    <?php 
                    // Display comparison if both selected
                    if (isset($_GET['compare_id1']) && isset($_GET['compare_id2'])) {
                        $compare_id1 = (int)$_GET['compare_id1'];
                        $compare_id2 = (int)$_GET['compare_id2'];
                        
                        $p1 = null;
                        $p2 = null;
                        foreach ($team_pokemon as $p) {
                            if ($p['id'] == $compare_id1) $p1 = $p;
                            if ($p['id'] == $compare_id2) $p2 = $p;
                        }
                        
                        if ($p1 && $p2):
                    ?>
                        <hr>
                        <div class="row mt-3">
                            <div class="col-5 text-center">
                                <h5><?php echo h($p1['name']); ?></h5>
                                <?php if ($p1['thumbnail_image']): ?>
                                    <img src="images/pokemon/thumbnails/<?php echo h($p1['thumbnail_image']); ?>" 
                                         class="img-fluid mb-2" style="max-height: 150px;" alt="<?php echo h($p1['name']); ?>">
                                <?php endif; ?>
                                <p>
                                    <span class="badge bg-primary"><?php echo h($p1['type1']); ?></span>
                                    <?php if ($p1['type2']): ?>
                                        <span class="badge bg-secondary"><?php echo h($p1['type2']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                            <div class="col-2 text-center">
                                <strong class="text-muted">VS</strong>
                            </div>
                            <div class="col-5 text-center">
                                <h5><?php echo h($p2['name']); ?></h5>
                                <?php if ($p2['thumbnail_image']): ?>
                                    <img src="images/pokemon/thumbnails/<?php echo h($p2['thumbnail_image']); ?>" 
                                         class="img-fluid mb-2" style="max-height: 150px;" alt="<?php echo h($p2['name']); ?>">
                                <?php endif; ?>
                                <p>
                                    <span class="badge bg-primary"><?php echo h($p2['type1']); ?></span>
                                    <?php if ($p2['type2']): ?>
                                        <span class="badge bg-secondary"><?php echo h($p2['type2']); ?></span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>
                        
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Stat</th>
                                    <th class="text-center"><?php echo h($p1['name']); ?></th>
                                    <th class="text-center">Winner</th>
                                    <th class="text-center"><?php echo h($p2['name']); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $stats = [
                                    'HP' => 'hp',
                                    'Attack' => 'attack',
                                    'Defense' => 'defense',
                                    'Sp. Attack' => 'sp_attack',
                                    'Sp. Defense' => 'sp_defense',
                                    'Speed' => 'speed',
                                    'Base Stat Total' => 'base_stat_total'
                                ];
                                
                                foreach ($stats as $label => $key):
                                    $val1 = $p1[$key];
                                    $val2 = $p2[$key];
                                    $winner = $val1 > $val2 ? 1 : ($val2 > $val1 ? 2 : 0);
                                ?>
                                    <tr>
                                        <td><strong><?php echo $label; ?></strong></td>
                                        <td class="text-center <?php echo $winner == 1 ? 'table-success' : ''; ?>">
                                            <?php echo h($val1); ?>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($winner == 1): ?>
                                                <span class="badge bg-success">←</span>
                                            <?php elseif ($winner == 2): ?>
                                                <span class="badge bg-success">→</span>
                                            <?php else: ?>
                                                <span class="badge bg-secondary">Tie</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center <?php echo $winner == 2 ? 'table-success' : ''; ?>">
                                            <?php echo h($val2); ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php 
                        endif;
                    }
                    ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Team Stats Sidebar -->
    <div class="col-md-4">
        <!-- Strongest Pokemon -->
        <?php if ($strongest_pokemon): ?>
            <div class="card mb-4 border-warning">
                <div class="card-header bg-warning">
                    <h5 class="mb-0">👑 Team Champion</h5>
                </div>
                <div class="card-body text-center">
                    <?php if ($strongest_pokemon['fullsize_image']): ?>
                        <img src="images/pokemon/fullsize/<?php echo h($strongest_pokemon['fullsize_image']); ?>" 
                             class="img-fluid mb-2" style="max-height: 200px;" 
                             alt="<?php echo h($strongest_pokemon['name']); ?>">
                    <?php endif; ?>
                    <h5><?php echo h($strongest_pokemon['name']); ?></h5>
                    <p class="mb-1">
                        <span class="badge bg-primary"><?php echo h($strongest_pokemon['type1']); ?></span>
                        <?php if ($strongest_pokemon['type2']): ?>
                            <span class="badge bg-secondary"><?php echo h($strongest_pokemon['type2']); ?></span>
                        <?php endif; ?>
                    </p>
                    <p class="mb-2">
                        <strong>Base Stat Total:</strong> 
                        <span class="badge bg-warning text-dark fs-5"><?php echo h($strongest_pokemon['base_stat_total']); ?></span>
                    </p>
                    <a href="view.php?id=<?php echo $strongest_pokemon['id']; ?>" class="btn btn-sm btn-warning">View Details</a>
                </div>
            </div>
        <?php endif; ?>
        
        <!-- Team Statistics -->
        <div class="card mb-4">
            <div class="card-header">
                <h5>Team Statistics</h5>
            </div>
            <div class="card-body">
                <?php if (!empty($team_pokemon)): ?>
                    <h6>Average Stats</h6>
                    <ul class="list-unstyled">
                        <li><strong>HP:</strong> <?php echo round($total_hp / count($team_pokemon)); ?></li>
                        <li><strong>Attack:</strong> <?php echo round($total_attack / count($team_pokemon)); ?></li>
                        <li><strong>Defense:</strong> <?php echo round($total_defense / count($team_pokemon)); ?></li>
                        <li><strong>Sp. Attack:</strong> <?php echo round($total_sp_attack / count($team_pokemon)); ?></li>
                        <li><strong>Sp. Defense:</strong> <?php echo round($total_sp_defense / count($team_pokemon)); ?></li>
                        <li><strong>Speed:</strong> <?php echo round($total_speed / count($team_pokemon)); ?></li>
                    </ul>
                    
                    <h6 class="mt-3">Type Coverage</h6>
                    <p>
                        <?php foreach (array_keys($type_coverage) as $type): ?>
                            <span class="badge bg-info me-1"><?php echo h($type); ?></span>
                        <?php endforeach; ?>
                    </p>
                    <p class="small text-muted"><?php echo count($type_coverage); ?> unique types</p>
                <?php else: ?>
                    <p class="text-muted">Add Pokemon to see team stats!</p>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Tips -->
        <div class="card">
            <div class="card-header">
                <h5>Tips</h5>
            </div>
            <div class="card-body">
                <ul class="small">
                    <li>Maximum 6 Pokemon per team</li>
                    <li>Your strongest Pokemon is highlighted with 👑</li>
                    <li>Try to have diverse types for better coverage</li>
                    <li>Balance offensive and defensive stats</li>
                    <li>Use the comparison tool to analyze matchups</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<!-- Add Pokemon Section -->
<div class="card mt-4">
    <div class="card-header">
        <h5>Add Pokemon to Team</h5>
    </div>
    <div class="card-body">
        <a href="browse.php" class="btn btn-primary">Browse All Pokemon</a>
        <p class="text-muted mt-2 mb-0">Browse Pokemon and add them to your team from their detail pages!</p>
    </div>
</div>

<?php 
db_disconnect($connection);
include('includes/footer.php'); 
?>