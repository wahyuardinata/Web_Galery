<?php
    session_start();

    // Cek apakah pengguna sudah login
    $is_logged_in = isset($_SESSION['UserID']);

    // Jika belum login, arahkan ke halaman login
    if (!$is_logged_in) {
        header('Location: /auth/login.php') || header('Location: /auth/login.php');
        exit(); // Pastikan script berhenti dieksekusi setelah pengalihan
    }

    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <title>My Project</title>
    <link href="/assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-dark fixed-top sticky-md-top backdrop-blur" data-bs-theme="dark">
        <div class="container"> 
            <a class="navbar-brand" href="#">
                    <img src="" width="100" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link <?= ($currentPage == 'index.php') ? 'active' : ''; ?>" aria-current="page" href="/index.php"><i class="fa-solid fa-house-chimney"></i>Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/views/data-foto/index.php">Foto</a>
                    </li>
                  
                    <li class="nav-item">
                        <a class="nav-link" href="/views/data-album/index.php">Album</a>
                    </li>
                    
                </ul>
                <div class="d-flex gap-2 justify-content-between">
                    <div class="navbar-text">
                        <button class="btn btn-danger"><a class="nav-link" href="/auth/logout.php">Sign Out</a></button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="container mt-5">