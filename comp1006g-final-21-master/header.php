<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Lamp Food || <?php echo $pageTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="css/styles.css" />

    <!-- link to custom js file to use delete confirmation function -->
    <script type="text/javascript" src="js/scripts.js" defer></script>

    <!-- bootstrap js for css animations -->
    <script type="text/javascript" src="js/bootstrap.min.js" defer></script>

    <!-- table sorting from https://www.kryogenix.org/code/browser/sorttable/ -->
    <script type="text/javascript" src="js/sorttable.js" defer></script>
</head>
<body>
<!-- Bootstrap navbar from https://getbootstrap.com/docs/5.0/components/navbar/#nav -->
<nav class="navbar navbar-expand-lg navbar-dark custom-primary">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">LAMP FOOD</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="items.php">Grocery List</a>
                </li>
            </ul>
            <ul class="navbar-nav ms-auto">
                <?php
                session_start();
                if (empty($_SESSION['username'])) {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="register.php">Register</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Login</a>
                    </li>
                <?php
                }
                else {
                ?>
                    <li class="nav-item">
                        <a class="nav-link" href="#"><?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>

