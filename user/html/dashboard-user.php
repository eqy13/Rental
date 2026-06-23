<?php

session_start();

if (
    !isset($_SESSION['user_id'])
) {

    header(
        'Location: login-user.php'
    );

    exit;
}

require_once '../config/db.php';

$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
");

$stmt->execute([
    $_SESSION['user_id']
]);

$user = $stmt->fetch();

$namaUser =
$_SESSION['nama_lengkap'];

$foto =
$user['foto_profil']
?? 'default-user.png';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta 
        name="viewport" 
        content="width=device-width, initial-scale=1.0"
    >

    <title>Outdoor Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style-dashboard.css">

    <!-- Font Awesome -->
    <link 
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >
</head>

<body>

    <div class="dashboard">

        <!-- HEADER -->
        <header class="header">

            <div class="welcome-text">
                <p>Welcome back,</p>
                <h1><?= htmlspecialchars($namaUser); ?></h1>
            </div>

        <div class="header-right">

            <!-- NOTIFICATION -->

            <button class="notification" id="notificationBtn">

                <i class="fa-regular fa-bell"></i>

                <span class="dot"></span>

            </button>

            <!-- PROFILE -->

            <div class="profile">
                <a href="user.php" class="profile">
                    <img
                        src="../../uploads/user/<?= htmlspecialchars($foto) ?>"
                        alt="Profile"
                        onerror="this.src='../../uploads/user/no-image.png'"
                    >
                </a>

            </div>

        </div>

        </header>

        <!-- WEATHER -->
        <div class="weather-card">

            <!-- LEFT -->
            <div class="weather-left">

                <div class="weather-icon">
                    <i class="fa-solid fa-cloud-rain"></i>
                </div>

                <div class="weather-info">

                    <p>Weather Today</p>

                    <h2>22°C • Partly Cloudy</h2>

                </div>

            </div>

            <!-- RIGHT -->
            <div class="weather-right">

                <p>Perfect for</p>

                <h3>Outdoor Adventure</h3>

            </div>

        </div>

    
    

            <!-- PROMO BANNER -->

        <div class="promo-banner">

            <div class="promo-content">

                <p class="promo-label">
                    Praktikum Basis Data
                </p>

                <h1>
                    Kelompok 6
                </h1>

                <p class="promo-code">
                    1. Moch. Elqy Syaputra
                </p>

                <p class="promo-code">
                    1. Moch. Elqy Syaputra
                </p>

                 <p class="promo-code">
                    1. Moch. Elqy Syaputra
                </p>

                 <p class="promo-code">
                    1. Moch. Elqy Syaputra
                </p>


                <button>
                    Claim Offer
                </button>

            </div>

        </div>

        <!-- ACTIVE RENTALS -->

        <div class="section-header">

            <h2>Active Rentals</h2>

            <a href="#">View All</a>

        </div>

        <div class="rental-card">

            <div class="rental-info">

                <h3>Nikon Z6 II</h3>

                <p>Return by 2026-05-18</p>

            </div>

            <div class="rental-status">

                <span>1 days left</span>

                <p>On Rental</p>

            </div>

        </div>

        <!-- CATEGORIES -->

        <h2 class="category-title">
            Categories
        </h2>

            <div
                class="categories-grid"
                id="categoriesGrid"
            ></div>


        <div class="section-header">
            <h2 class="popular-title">Popular Equipment</h2>
            <a href="halaman-kategori.php">View All</a>
        </div>

        <div class="popular-grid"></div>

          

    </div>

    

    <!-- JS -->
    <script src="../js/script-dashboard.js"></script>

</body>

</html>
