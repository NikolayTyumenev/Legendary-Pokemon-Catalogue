<?php
require_once('../private/connect.php');
$connection = db_connect();

// TODO: Actually delete the Pokemon from database
// DELETE FROM pokemon WHERE id = ?
// Then redirect to browse.php

header('Location: browse.php');
exit;
?>
