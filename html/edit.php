<?php
require_once('../private/connect.php');
$connection = db_connect();

$page_title = "Edit Pokemon - Legendary Pokemon Catalogue";
include('includes/header.php');
?>

<h1>Edit Pokemon</h1>
<p class="text-muted">TODO: Similar to add.php but pre-populate fields with existing data</p>

<?php
db_disconnect($connection);
include('includes/footer.php');
?>
