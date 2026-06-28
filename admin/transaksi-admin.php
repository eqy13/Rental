<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login-admin.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Transactions</title>

  <link rel="stylesheet" href="./assets/css/pages/style-transaksi-admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>
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

      <a href="transaksi-admin.php" class="active">
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

<div class="layout">

<main class="main">

    <div class="topbar">

        <div>

            <h1>Kasir / Transaksi Rental</h1>

            <p>Buat transaksi rental baru</p>

        </div>

    </div>

    <div class="transaction-grid">

        <!-- FORM -->

        <div class="glass-card">

            <form id="transactionForm">

                <div class="form-group">

                    <div class="form-group">
                        <label>Nama Pelanggan</label>
                        <input
                            type="text"
                            id="customer_name"
                            placeholder="Masukkan nama pelanggan"
                            required
                        >
                    </div>

                    <div class="form-group">
                        <label>No HP</label>
                        <input
                            type="text"
                            id="customer_phone"
                            placeholder="08xxxxxxxxxx"
                            required
                        >
                    </div>

                </div>

                <div class="form-group">

                    <label>Produk</label>

                    <select id="product_id">

                        <option>
                            Loading produk...
                        </option>

                    </select>

                </div>

                <div class="form-group">

                    <label>Jumlah</label>

                    <input
                        type="number"
                        id="qty"
                        value="1"
                        min="1"
                    >

                </div>

                <div class="form-group">

                    <label>Tanggal Rental</label>

                    <input
                        type="date"
                        min="<?= date('Y-m-d'); ?>"
                        id="start_date"
                    >

                </div>

                <div class="form-group">

                    <label>Tanggal Kembali</label>

                    <input
                        type="date"
                        min="<?= date('Y-m-d'); ?>"
                        id="end_date"
                    >

                </div>

                <div class="form-group">

                <label>Metode Pembayaran</label>

                <select id="payment_method">

                    <option value="cash">
                        Cash
                    </option>

                    <option value="bank">
                        Transfer Bank
                    </option>

                    <option value="qris">
                        QRIS
                    </option>

                </select>

            </div>

                <button
                    type="submit"
                    class="primary-btn"
                >
                    Simpan Transaksi
                </button>

            </form>

        </div>

        <!-- INVOICE -->
    <div class="glass-card">

            <h3>Invoice Preview</h3>

            <div class="invoice-item">
                <span>Total Hari</span>
                <strong id="totalDays">
                    0 Hari
                </strong>
            </div>

            <div class="invoice-item">
                <span>Harga Rental</span>
                <strong id="rentalPrice">
                    Rp 0
                </strong>
            </div>

            <div class="invoice-item">
                <span>Jaminan</span>
                <strong id="depositPrice">
                    Rp 0
                </strong>
            </div>

            <div class="invoice-item total">
                <span>Total</span>
                <strong id="grandTotal">
                    Rp 0
                </strong>
            </div>

        </div>

    </div>
<div class="glass-card transaction-history">

            <h3>Riwayat Transaksi</h3>

            <table>

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Pelanggan</th>
                        <th>Total</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody id="transactionTable">
                </tbody>

            </table>

        </div>
</main>

</div>
<script src="./assets/js/script-transaksi-admin.js"></script>
</body>
</html>