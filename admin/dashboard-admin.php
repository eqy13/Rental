<?php

session_start();

require './config/db.php';

$stmt = $pdo->prepare("
    SELECT foto
    FROM admins
    WHERE id = ?
");

$stmt->execute([
    $_SESSION['admin_id']
]);

$admin = $stmt->fetch();

?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Outdoor Rental Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/css/pages/style-dashboard-admin.css">


    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div id="toastContainer"></div>

<div class="layout">

    <!-- ================= SIDEBAR ================= -->
    <aside class="sidebar" id="sidebar">

        <div class="logo">
            <img src="./assets/logo/logo-rental4.png" alt="Outdoor Rent Logo">
            <span>OutdoorRent</span>
        </div>

        <nav class="menu">

            <p class="menu-title">MAIN</p>

            <a class="active" href="dashboard-admin.php">
                <i class="fa-solid fa-chart-line"></i>
                Dashboard
            </a>

            <p class="menu-title">MASTER DATA</p>

            <a href="products-admin.php">
                <i class="fa-solid fa-campground"></i>
                Kelola Alat Rental
            </a>

            <a href="kategori-admin.php">
                <i class="fa-solid fa-layer-group"></i>
                Kategori Alat
            </a>

            <a href="stok-admin.php">
                <i class="fa-solid fa-boxes-stacked"></i>
                Stok Barang
            </a>

            <p class="menu-title">TRANSAKSI</p>

            <a href="transaksi-admin.php">
                <i class="fa-solid fa-receipt"></i>
                Kasir / Transaksi
            </a>

            <a href="pembayaran-admin.php">
                <i class="fa-solid fa-wallet"></i>
                Pembayaran
            </a>

            <a href="returns-admin.php">
                <i class="fa-solid fa-rotate-left"></i>
                Pengembalian
            </a>

            <p class="menu-title">USER</p>

            <a href="pelanggan-admin.php">
                <i class="fa-solid fa-users"></i>
                Data Pelanggan
            </a>

            <p class="menu-title">SYSTEM</p>

            <a href="settings-admin.php">
                <i class="fa-solid fa-gear"></i>
                Pengaturan
            </a>

        </nav>
    </aside>

    <!-- ================= MAIN ================= -->
    <main class="main">

        <!-- TOPBAR -->
        <header class="topbar">

            <div class="topbar-left">
                <div>
                    <h1>Dashboard</h1>
                    <p>Selamat datang kembali, Admin</p>
                </div>

            </div>

            <div class="topbar-right">

                <button class="glass-btn" id="notifBtn">
                    <i class="fa-solid fa-bell"></i>
                    <span class="dot"></span>
                </button>

                <div class="profile-card">

                    <img
                        class="profile"
                        id="adminPhoto"
                        src="../uploads/admins/<?= $admin['foto'] ?: 'default-admin.png' ?>"
                        alt="Admin"
                        onerror="this.src='../uploads/admins/default-admin.png'">

                    <div>
                        <h4>Administrator</h4>
                        <span>Outdoor Rent</span>
                    </div>

                </div>

            </div>

        </header>

        <!-- ================= STATS ================= -->
        <section class="stats-grid">

            <div class="glass-card stat-card">
                <p>Total Produk</p>
                <h2 id="totalProducts">0</h2>
                <i class="fa-solid fa-campground"></i>
            </div>

            <div class="glass-card stat-card">
                <p>Akun Pelanggan</p>
                <h2 id="totalUsers">0</h2>
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="glass-card stat-card">
                <p>Barang Tersedia</p>
                <h2 id="availableStock">0</h2>
                <i class="fa-solid fa-box-open"></i>
            </div>

            <div class="glass-card stat-card">
                <p>Total Pendapatan</p>
                <h2 id="totalIncome">Rp 0</h2>
                <i class="fa-solid fa-wallet"></i>
            </div>

        </section>

        <!-- ================= ANALYTICS ================= -->
        <section class="analytics-grid">

            <!-- REVENUE -->
            <div class="chart-card">

                <div class="chart-header">

                    <div>
                        <span class="card-label">Revenue Analytics</span>
                        <h2>Pendapatan Mingguan</h2>
                    </div>

                    <div class="chart-total">
                        <h3 id="weeklyIncome">Rp 0</h3>

                        <span class="growth-up" id="incomeGrowth">
                            <i class="fa-solid fa-arrow-trend-up"></i>
                            0%
                        </span>
                    </div>

                </div>

                <div class="chart-wrapper">

                    <svg
                        class="revenue-chart"
                        viewBox="0 0 600 300"
                        preserveAspectRatio="none"
                    >

                        <defs>

                            <linearGradient
                                id="lineGradient"
                                x1="0%"
                                y1="0%"
                                x2="100%"
                                y2="0%"
                            >
                                <stop offset="0%" stop-color="#4F46E5"/>
                                <stop offset="100%" stop-color="#06B6D4"/>
                            </linearGradient>

                        </defs>

                        <polyline
                            id="incomeChartLine"
                            points=""
                        ></polyline>

                    </svg>

                </div>

                <div class="chart-labels" id="chartLabels"></div>

            </div>

            <!-- CATEGORY -->
            <div class="category-card">

                <div class="card-header">
                    <div>
                        <span class="card-label">Popular Category</span>
                        <h3>Kategori Favorit</h3>
                    </div>
                </div>

                <div class="donut-wrapper">

                    <div class="donut-chart" id="donutChart">

                        <div class="donut-center">
                            <h2 id="donutPercent">0%</h2>
                            <span>Terbanyak</span>
                        </div>

                    </div>

                </div>

                <div class="category-list" id="categoryList"></div>

            </div>

        </section>

        <!-- ================= TABLE ================= -->
        <section class="dashboard-grid">

            <div class="glass-card">

                <div class="card-header">
                    <h3>Pesanan Terbaru</h3>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Pelanggan</th>
                            <th>Produk</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody id="latestOrdersTable"></tbody>
                </table>

            </div>

            <div class="glass-card">

                <div class="card-header">
                    <h3>Reminder Pengembalian</h3>
                </div>

                <div id="reminderContainer"></div>

            </div>

        </section>

    </main>

</div>

<script src="./assets/js/script-dashboard-admin.js"></script>

</body>
</html>