<?php

session_start();


?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./assets/css/pages/style-stok-admin.css">
  <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
</head>

<body>

<div class="layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">

    <div class="logo">
            <img
                src="./assets/logo/logo-rental4.png"
                alt="Outdoor Rent Logo">
      <span>OutdoorRent</span>
    </div>

   <!-- MENU -->
    <nav class="menu">

      <p class="menu-title">MAIN</p>

      <a href="dashboard-admin.php">
        <i class="fa-solid fa-chart-line"></i>
        Dashboard
      </a>

      <p class="menu-title">MASTER DATA</p>

      <a href="products-admin.php">
        <i class="fa-solid fa-campground"></i>
        Kelola Alat Rental
      </a>

      <a href="kategori-admin.php" >
        <i class="fa-solid fa-layer-group"></i>
        Kategori Alat
      </a>

      <a href="stok-admin.php" class="active">
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

<div class="main">

    <div class="topbar">

        <div>

            <h1>Monitoring Stok</h1>

            <p>
                Kelola stok seluruh alat rental
            </p>

        </div>

    </div>

    <!-- SEARCH DITARUH PALING ATAS -->

    <div class="glass-card toolbar">

        <input
            type="text"
            id="searchProduct"
            placeholder="Cari produk..."
        >

    </div>

    <!-- STATISTIK -->

    <div class="stock-grid">

        <div class="glass-card stat-card">
            <h3>Total Produk</h3>
            <h2 id="totalProducts">0</h2>
        </div>

        <div class="glass-card stat-card">
            <h3>Tersedia</h3>
            <h2 id="availableProducts">0</h2>
        </div>

        <div class="glass-card stat-card">
            <h3>Maintenance</h3>
            <h2 id="maintenanceProducts">0</h2>
        </div>

    </div>

    <!-- TABLE -->

    <div class="glass-card">

        <table>

            <thead>

                <tr>
                    <th>Produk</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Kondisi</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody id="stockTable">

            </tbody>

        </table>

    </div>

</div>

<script src="./assets/js/script-stok-admin.js"></script>
</body>
</html>