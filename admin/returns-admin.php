<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login-admin.php");
    exit;

}

?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="./assets/css/pages/style-returns-admin.css">
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

      <a href="returns-admin.php" class="active">
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

<main class="main">

    <div class="topbar">

        <div>
            <h1>Pengembalian Barang</h1>
            <p>Kelola proses pengembalian alat rental</p>
        </div>

    </div>

    <div class="glass-card">

        <form id="returnForm">

            <!-- RENTAL -->

            <div class="form-group">

                <label>Rental Aktif</label>

                <select id="rental_id">

                    <option>
                        Loading rental...
                    </option>

                </select>

            </div>

            <!-- KONDISI -->

            <div class="form-group">

                <label>Kondisi Barang</label>

                <select id="condition">

                    <option value="baik">
                        Baik
                    </option>

                    <option value="rusak_ringan">
                        Rusak Ringan
                    </option>

                    <option value="rusak_berat">
                        Rusak Berat
                    </option>

                    <option value="hilang">
                        Hilang
                    </option>

                </select>

            </div>

            <!-- KETERLAMBATAN -->

            <div class="invoice-item">

                <span>Terlambat</span>

                <strong id="lateDays">
                    0 Hari
                </strong>

            </div>

            <!-- DENDA -->

            <div class="invoice-item">

                <span>Denda</span>

                <strong id="penalty">
                    Rp 0
                </strong>

            </div>

            <button
                type="submit"
                class="primary-btn">

                Konfirmasi Pengembalian

            </button>

        </form>

    </div>

</main>
<script src="./assets/js/script-returns-admin.js"></script>
</body>
</html>