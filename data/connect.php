<?php
// Database connection for Docker environment
// Located in: data/connect.php

$host = 'mysql';  // Docker service name from compose.yml
$dbname = 'legendary_pokemon_catalogue';
$username = 'student';
$password = 'student';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
