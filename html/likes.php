<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header('Location: login-user.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Produk Disukai</title>

    <link rel="stylesheet" href="../css/likes.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

    <div class="likes-page">

        <!-- HEADER -->
        <header class="likes-header">

            <a href="user.php" class="back-btn">

                <i class="fa-solid fa-arrow-left"></i>

            </a>

            <div>

                <h1>Produk Disukai</h1>

                <p>Semua produk favorit Anda</p>

            </div>

        </header>

        <!-- GRID -->
        <div class="likes-grid" id="likesGrid"></div>

    </div>

    <script src="../js/likes-pages.js"></script>

</body>

</html>