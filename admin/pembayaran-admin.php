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
<link rel="stylesheet" href="./assets/css/pages/style-pembayaran-admin.css">
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

      <a href="stok-admin.php">
        <i class="fa-solid fa-boxes-stacked"></i>
        Stok Barang
      </a>

      <p class="menu-title">TRANSAKSI</p>

      <a href="transaksi-admin.php">
        <i class="fa-solid fa-receipt"></i>
        Kasir / Transaksi
      </a>

      <a href="pembayaran-admin.php" class="active">
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

<main class="main">

<header class="topbar">
  <h1>Pembayaran</h1>
</header>

<div class="glass-card">

<table>

<thead>
<tr>
<th>ID</th>
<th>Pelanggan</th>
<th>Status</th>
<th>Total</th>
<th>Aksi</th>
<th>Detail</th>
</tr>
</thead>

<div class="glass-card toolbar">

    <input
        type="text"
        id="searchPayment"
        placeholder="Cari pembayaran..."
    >

</div>

<tbody id="paymentTable">

</tbody>

</table>

</div>

</div>
<div id="paymentModal" class="modal">
    <div class="modal-content">

        <span class="close" onclick="closePaymentModal()">&times;</span>

        <img
            id="paymentProofImage"
            src=""
            alt="Bukti Pembayaran">

    </div>
</div>

<div id="detailModal" class="modal">

    <div class="modal-content detail-modal">

        <button
            type="button"
            class="close-btn"
            onclick="closeDetailModal()"
        >
            <i class="fa-solid fa-xmark"></i>
        </button>

        <div class="detail-header">

            <div>

                <h2>
                    Detail Pesanan
                </h2>

                <p>
                    Informasi lengkap transaksi pelanggan.
                </p>

            </div>

        </div>

        <hr class="detail-divider">

        <div
            id="detailContent"
            class="detail-content"
        >

        </div>

    </div>

</div>

<script src="./assets/js/script-pembayaran-admin.js"></script>
</body>
</html>