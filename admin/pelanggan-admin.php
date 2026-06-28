<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login-admin.php");
    exit;

}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Data Pelanggan</title>

    <link
        rel="stylesheet"
        href="./assets/css/pages/style-pelanggan-admin.css">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="layout">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">

            <img
                src="./assets/logo/logo-rental4.png"
                alt="Outdoor Rent Logo">
            <span>OutdoorRent</span>

        </div>

        <nav class="menu">

            <p class="menu-title">
                MAIN
            </p>

            <a href="dashboard-admin.php">

                <i class="fa-solid fa-chart-line"></i>
                Dashboard

            </a>

            <p class="menu-title">
                MASTER DATA
            </p>

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

            <p class="menu-title">
                TRANSAKSI
            </p>

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

            <p class="menu-title">
                USER
            </p>

            <a
                href="pelanggan-admin.php"
                class="active">

                <i class="fa-solid fa-users"></i>
                Data Pelanggan

            </a>

            <p class="menu-title">
                SYSTEM
            </p>

            <a href="settings-admin.php">

                <i class="fa-solid fa-gear"></i>
                Pengaturan

            </a>

        </nav>

    </aside>

    <!-- ================= MAIN ================= -->

    <main class="main">

        <header class="topbar">

            <div>

                <h1>
                    Data Pelanggan
                </h1>

                <p>
                    Daftar seluruh pelanggan rental
                </p>

            </div>

        </header>

        <!-- SEARCH -->

        <div class="glass-card toolbar">

            <div class="search-box">

                <i class="fa-solid fa-search"></i>

                <input
                    type="text"
                    id="searchCustomer"
                    placeholder="Cari nama, email atau nomor HP..."
                >

            </div>

        </div>

<div class="customer-stats">

    <div class="stat-card">

        <h4>Total Pelanggan</h4>

        <h2 id="totalCustomer">
            0
        </h2>

    </div>

    <div class="stat-card">

        <h4>Member</h4>

        <h2 id="memberCustomer">
            0
        </h2>

    </div>

    <div class="stat-card">

        <h4>Non-Member</h4>

        <h2 id="nonMemberCustomer">
            0
        </h2>

    </div>

</div>

        <!-- TABLE -->

        <div class="glass-card">

            <table>

                <thead>

                    <tr>

                        <th>
                            Nama
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            No HP
                        </th>

                        <th>
                            Tanggal Daftar
                        </th>

                        <th>
                            Status
                        </th>

                    </tr>

                </thead>

                <tbody id="customerTable">

                    <!-- Render dari JS -->

                </tbody>

            </table>

        </div>

    </main>

</div>
<div
    id="customerModal"
    class="modal"
    style="display:none;"
>

    <div class="modal-content">

        <h3>Tambah Pelanggan</h3>

        <input
            type="text"
            id="nama"
            placeholder="Nama Lengkap"
        >

        <input
            type="email"
            id="email"
            placeholder="Email"
        >

        <input
            type="text"
            id="no_hp"
            placeholder="Nomor HP"
        >

        <input
            type="password"
            id="password"
            placeholder="Password"
        >

        <button
            onclick="saveCustomer()"
        >
            Simpan
        </button>

    </div>

</div>
<script src="./assets/js/script-pelanggan-admin.js"></script>

</body>
</html>