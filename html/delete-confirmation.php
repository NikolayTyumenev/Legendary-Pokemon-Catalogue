<?php
session_start();
require_once('../private/connect.php');
require_once('../private/authentication.php');
require_once('../private/functions.php');

require_login();  // Must be logged in to delete! not like our password is hard to guess :)

$connection = db_connect();

$id = $_GET['id'] ?? 0;

if ($id > 0) {
    // Get image filenames before deleting
    $query = "SELECT thumbnail_image, fullsize_image FROM pokemon WHERE id = ?";
    $stmt = mysqli_prepare($connection, $query);
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $pokemon = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);
    
    if ($pokemon) {
        // Delete image files from server
        if ($pokemon['thumbnail_image']) {
            delete_pokemon_images($pokemon['thumbnail_image'], $pokemon['fullsize_image']);
        }
        
        // Delete from database
        $delete_query = "DELETE FROM pokemon WHERE id = ?";
        $delete_stmt = mysqli_prepare($connection, $delete_query);
        mysqli_stmt_bind_param($delete_stmt, "i", $id);
        mysqli_stmt_execute($delete_stmt);
        mysqli_stmt_close($delete_stmt);
    }
}

set_success_message("Pokemon deleted successfully!");

db_disconnect($connection);
header('Location: browse.php');
exit;
?>