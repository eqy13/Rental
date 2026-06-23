<?php


session_start();


require_once './config/db.php';

$admin =
$pdo->query("
SELECT *
FROM admins
LIMIT 1
")->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Pengaturan Admin
    </title>

    <link
        rel="stylesheet"
        href="./assets/css/pages/style-settings-admin.css"
    >

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >

</head>

<body>

<div class="layout">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">
            <img
                src="./assets/logo/logo-rental4.png"
                alt="Outdoor Rent Logo">

            <span>
                OutdoorRent
            </span>

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

            <a href="pelanggan-admin.php">
                <i class="fa-solid fa-users"></i>
                Data Pelanggan
            </a>

            <p class="menu-title">
                SYSTEM
            </p>

            <a
                href="settings-admin.php"
                class="active"
            >
                <i class="fa-solid fa-gear"></i>
                Pengaturan
            </a>

        </nav>

    </aside>

    <!-- ================= MAIN ================= -->

    <main class="main">

        <!-- HEADER -->

        <div class="topbar">

            <div>

                <h1>
                    Pengaturan Sistem
                </h1>

                <p>
                    Kelola profil admin, sistem, dan konfigurasi aplikasi
                </p>

            </div>

        </div>

        <!-- ================= PROFILE ================= -->

        <div class="glass-card profile-card">

            <div class="profile-left">

            <img
                id="adminPhoto"
                src="../uploads/admins/<?= $admin['foto'] ?: 'default-admin.png' ?>"
                alt="Admin"
            >

                <div>

                    <h2 id="adminName">
                        <?= htmlspecialchars($admin['nama_lengkap']) ?>
                    </h2>

                    <p id="adminEmail">
                        <?= htmlspecialchars($admin['email']) ?>
                    </p>

                </div>

            </div>

            <button
                class="primary-btn"
                id="editProfileBtn"
            >
                <i class="fa-solid fa-pen"></i>
                Edit Profil
            </button>

        </div>

    

        <!-- ================= SETTINGS GRID ================= -->

        <div class="settings-grid">

            <!-- THEME -->

            <div class="glass-card">

                <h3>
                    <i class="fa-solid fa-moon"></i>
                    Tampilan
                </h3>

                <div class="setting-item">

                    <span>
                        Dark Mode
                    </span>

                    <label class="switch">

                        <input
                            type="checkbox"
                            id="darkToggle"
                        >

                        <span class="slider"></span>

                    </label>

                </div>

            </div>

            <!-- PASSWORD -->

            <div class="glass-card">

                <h3>
                    <i class="fa-solid fa-lock"></i>
                    Keamanan
                </h3>

                <button
                    class="primary-btn full-btn"
                    id="changePasswordBtn"
                >
                    Ubah Password
                </button>

            </div>

            <!-- BACKUP -->

            <div class="glass-card">

                <h3>
                    <i class="fa-solid fa-database"></i>
                    Backup Database
                </h3>

                <button
                    class="primary-btn full-btn"
                    id="backupBtn"
                >
                    Download Backup
                </button>

            </div>

        </div>

        <!-- ================= LOGOUT ================= -->

        <div class="glass-card logout-card">

            <h2>
                Logout
            </h2>

            <p>
                Keluar dari dashboard administrator.
            </p>

            <button
                class="danger-btn"
                id="logoutBtn"
            >

                <i class="fa-solid fa-right-from-bracket"></i>

                Logout

            </button>

        </div>

    </main>

</div>

<!-- ================= EDIT PROFILE MODAL ================= -->

<div class="modal-overlay" id="profileModal">

    <div class="modal-box glass-card">

        <div class="modal-header">

            <h2>Edit Profil</h2>

            <button
                type="button"
                id="closeProfileModal"
                class="close-btn">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form
            id="profileForm"
            enctype="multipart/form-data">

            <div class="form-group">

                <label>Nama Lengkap</label>

                <input
                    type="text"
                    name="nama_lengkap"
                    value="<?= htmlspecialchars($admin['nama_lengkap']) ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Email</label>

                <input
                    type="email"
                    name="email"
                    value="<?= htmlspecialchars($admin['email']) ?>"
                    required>

            </div>

            <div class="form-group">

                <label>Foto Profil</label>

                <input
                    type="file"
                    name="foto"
                    id="foto">

            </div>

            <div class="form-group">

                <?php

                $fotoAdmin =
                !empty($admin['foto'])
                ? "./uploads/admins/".$admin['foto']
                : "./uploads/admins/default-admin.png";

                ?>

                <img
                    id="previewPhoto"
                    src="<?= $fotoAdmin ?>"
                    width="120"
                >

            </div>

            <div class="modal-footer">

                <button
                    type="button"
                    class="danger-btn"
                    id="cancelProfile">

                    Batal

                </button>

                <button
                    type="submit"
                    class="primary-btn">

                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>

<!-- ================= MODAL PASSWORD ================= -->

<div class="modal-overlay" id="passwordModal">

    <div class="modal-box glass-card">

        <div class="modal-header">

            <h2>
                Ubah Password
            </h2>

            <button
                type="button"
                class="close-btn"
                id="closePasswordModal">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <form id="passwordForm">

            <div class="form-group">

                <label>
                    Password Baru
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Masukkan password baru"
                    required
                >

            </div>

            <div class="form-group">

                <label>
                    Konfirmasi Password
                </label>

                <input
                    type="password"
                    id="confirmPassword"
                    placeholder="Ulangi password"
                    required
                >

            </div>

            <div
                style="
                display:flex;
                gap:10px;
                justify-content:flex-end;
                margin-top:20px;
                "
            >

                <button
                    type="button"
                    class="secondary-btn"
                    id="cancelPassword">

                    Batal

                </button>

                <button
                    type="submit"
                    class="primary-btn">

                    Simpan Password

                </button>

            </div>

        </form>

    </div>

</div>

<script src="./assets/js/script-settings-admin.js"></script>

</body>
</html>