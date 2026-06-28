<?php

session_start();

if (!isset($_SESSION['user_id'])) {

    header('Location: login-user.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outdoor Categories</title>

    <link rel="stylesheet" href="../css/style-dashboard.css">
    <link rel="stylesheet" href="../css/style-kategori.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<div class="container">

<header class="header">

    <div class="header-content">

        <div class="header-top">

            <a href="dashboard-user.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <h1>Browse Equipment</h1>

        </div>

        <div class="search-box">

            <i class="fa-solid fa-magnifying-glass"></i>

            <input
                type="text"
                id="searchInput"
                placeholder="Search gear, cameras, equipment..."
            >

        </div>

    </div>

</header>

<!-- CATEGORY GRID -->
<div
    class="category-grid"
    id="categoryGrid"
></div>

<div class="category-info">
    <span class="product-count-tag">0 Products</span>
</div>

<!-- FILTER -->
<div class="filter-wrapper">

    <div class="filter-top">
        <button class="filter-toggle">
            <i class="fa-solid fa-sliders"></i>
            Filters
        </button>
    </div>

    <div class="filter-panel">

        <div class="filter-group">

            <h3>Price Range (per day)</h3>

            <div class="price-range">

                <input type="number" class="min-price" placeholder="Min">

                <span>to</span>

                <input type="number" class="max-price" placeholder="Max">

            </div>

        </div>


        <div class="filter-actions">

            <button class="reset-btn">Reset</button>
            <button class="apply-btn">Apply</button>

        </div>

    </div>

</div>

<!-- PRODUCTS -->
<div class="equipment-grid" id="equipmentGrid"></div>

</div>

<script src="../js/script-kategori.js"></script>

</body>
</html>