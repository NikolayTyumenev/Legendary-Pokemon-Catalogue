<?php

define("DB_SERVER", "mysql");
define("DB_USER", "student");
define("DB_PASS", "student");
define("DB_NAME", "dmit2025");

function db_connect() {
    $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME, 3306);
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        $connection->set_charset('utf8mb4');
        return $connection;
    }
}

function db_disconnect($connection) {
    if(isset($connection)) {
        mysqli_close($connection);
    }
}

?>
