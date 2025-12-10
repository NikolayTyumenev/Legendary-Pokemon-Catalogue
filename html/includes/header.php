<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $page_title ?? 'Legendary & Mythical Pokemon Catalogue'; ?></title>

    <!-- Bootstrap 5.3.7 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
               <!-- Can add a logo or whatever you guys want here-->
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php"><i class="bi bi-house-fill"></i> Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="browse.php"><i class="bi bi-grid-fill"></i> Browse</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="team_builder.php"><i class="bi bi-people-fill"></i> Team Builder</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="add.php"><i class="bi bi-plus-circle-fill"></i> Add Pokemon</a>
                    </li>
                    <?php
                
                    if (session_status() === PHP_SESSION_NONE) {
                        session_start();
                    }
                    require_once('../private/authentication.php');
                    ?>


                    <?php if (is_logged_in()): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="admin.php">
                                <i class="bi bi-shield-lock-fill"></i> Admin
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="logout.php">
                                <i class="bi bi-box-arrow-right"></i> Logout (<?php echo htmlspecialchars(get_current_username()); ?>)
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">
                                <i class="bi bi-box-arrow-in-right"></i> Login
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <div class="container my-4">
        
        <?php 
        if (function_exists('display_success_message')) {
            echo display_success_message(); 
        }
        ?>