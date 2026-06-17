<?php

session_start();


?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk</title>

    <link rel="stylesheet" href="./assets/css/pages/style-products-admin.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

</head>

<body>

<div class="layout">

    <!-- ================= SIDEBAR ================= -->

    <aside class="sidebar">

        <div class="logo">

            <img
                src="./assets/logo/logo-rental.png"
                alt="Outdoor Rent Logo">

            <span>OutdoorRent</span>

        </div>

        <nav class="menu">

            <p class="menu-title">MAIN</p>

            <a href="dashboard-admin.php">

                <i class="fa-solid fa-chart-line"></i>
                Dashboard

            </a>

            <p class="menu-title">MASTER DATA</p>

            <a href="products-admin.php" class="active">

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

        <header class="topbar">

            <div>

                <h1>Kelola Produk</h1>
                <p>Manajemen alat rental outdoor</p>

            </div>

            <button
                class="primary-btn"
                id="openProductModal">

                <i class="fa-solid fa-plus"></i>
                Tambah Produk

            </button>

        </header>

        <!-- ================= MODAL ================= -->

        <div
            class="modal-overlay"
            id="productModal">

            <div class="product-modal glass-card">

                <div class="modal-header">

                    <h2 id="modalTitle">
                        Tambah Produk
                    </h2>

                    <button
                        class="close-modal"
                        id="closeModal">

                        <i class="fa-solid fa-xmark"></i>

                    </button>

                </div>

                <form
                    id="productForm"
                    class="product-form"
                    enctype="multipart/form-data">

                    <input
                        type="hidden"
                        id="product_id"
                        name="product_id">

                    <!-- IMAGE -->

                    <div class="upload-box">

                        <label for="productImage">

                            <i class="fa-solid fa-cloud-arrow-up"></i>

                            <p>Upload Foto Produk</p>

                        </label>

                        <input
                        type="file"
                        id="productImage"
                        name="productImage[]"
                        accept="image/*"
                        multiple
                        hidden>

                    </div>

                    <!-- GRID -->

                    <div class="form-grid">

                        <!-- NAMA -->

                        <div class="input-group">

                            <label>Nama Produk</label>

                            <input
                                type="text"
                                id="nama_produk"
                                name="nama_produk"
                                required>

                        </div>

                        <!-- KATEGORI -->

                        <div class="input-group">

                            <label>Kategori</label>

                            <select
                                id="category_id"
                                name="category_id"
                                required>

                                <option value="">
                                    Pilih Kategori
                                </option>

                            </select>

                        </div>

                        <!-- HARGA -->

                        <div class="input-group">

                            <label>Harga Sewa / Hari</label>

                            <input
                                type="number"
                                id="harga_sewa"
                                name="harga_sewa"
                                required>

                        </div>

                        <div class="input-group">

                            <label>Deposit / Jaminan</label>

                            <input
                                type="number"
                                id="deposit"
                                name="deposit"
                                min="0"
                                value="0"
                                required>

                        </div>

                        <!-- STOK -->

                        <div class="input-group">

                            <label>Jumlah Stok</label>

                            <input
                                type="number"
                                id="stok"
                                name="stok"
                                required>

                        </div>

                        <!-- KONDISI -->

                        <div class="input-group">

                            <label>Kondisi</label>

                            <select
                                id="kondisi"
                                name="kondisi">

                                <option value="baik">
                                    Baik
                                </option>

                                <option value="rusak_ringan">
                                    Rusak Ringan
                                </option>

                                <option value="rusak_berat">
                                    Rusak Berat
                                </option>

                            </select>

                        </div>

                                                <!-- STATUS -->

                        <div class="input-group">

                            <label>Status</label>

                            <select
                                id="status"
                                name="status">

                                <option value="tersedia">
                                    Tersedia
                                </option>

                                <option value="maintenance">
                                    Maintenance
                                </option>

                            </select>

                        </div>

                    </div>

                    <div class="input-group">

                        <label>Spesifikasi</label>

                        <textarea
                            id="spesifikasi"
                            name="spesifikasi"
                            rows="5"
                            placeholder="1 Orang&#10;Waterproof&#10;Berat 2kg"></textarea>

                    </div>

                    <div class="input-group">

                        <label>Include Item</label>

                        <textarea
                            id="include_item"
                            name="include_item"
                            rows="4"
                            placeholder="Flysheet, Pasak, Tas Tenda"></textarea>

                    </div>

                    <!-- DESKRIPSI -->

                    <div class="input-group">

                        <label>Deskripsi Produk</label>

                        <textarea
                            id="deskripsi"
                            name="deskripsi"
                            rows="5"
                            placeholder="Masukkan deskripsi produk"></textarea>

                    </div>

                    <!-- BUTTON -->

                    <div class="modal-actions">

                        <button
                            type="button"
                            class="cancel-btn"
                            id="cancelModal">

                            Batal

                        </button>

                        <button
                            type="submit"
                            class="save-btn"
                            id="saveProductBtn">

                            Simpan Produk

                        </button>

                    </div>

                </form>

            </div>

        </div>

        <!-- ================= TOOLBAR ================= -->

        <div class="glass-card toolbar">

            <input
                type="text"
                id="searchProduct"
                placeholder="Cari produk...">

            <select id="filterCategory">

                <option value="">
                    Semua Kategori
                </option>

            </select>

        </div>

        <!-- ================= TABLE ================= -->

        <div class="glass-card">

            <table>

                <thead>

                    <tr>

                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Deposit</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th>Aksi</th>

                    </tr>

                </thead>

                <tbody id="productTable">

                    <!-- Render dari JS -->

                </tbody>

            </table>

        </div>

    </main>

</div>

<div class="modal-overlay" id="detailModal">

    <div class="product-modal glass-card">

        <div class="modal-header">

            <h2>Detail Produk</h2>

            <button
                class="close-modal"
                onclick="document.getElementById('detailModal').classList.remove('active')">

                <i class="fa-solid fa-xmark"></i>

            </button>

        </div>

        <div class="detail-content">

        <div class="detail-image-section">

            <img
                id="detailImage"
                src="../uploads/products/no-image.png"
                alt="Produk"
            >

            <div
                id="detailGallery"
                class="detail-gallery">
            </div>

        </div>

    <div class="detail-main">

        <div class="detail-top">

            <span
                class="detail-category"
                id="detailCategory">
            </span>

            <h2 id="detailName"></h2>

            <div
                class="detail-status"
                id="detailStatus">
            </div>

            <div
                class="detail-price"
                id="detailPrice">
            </div>

        </div>

        <div class="detail-grid">

            <div class="info-card">
                <span>ID Produk</span>
                <strong id="detailId"></strong>
            </div>

            <div class="info-card">
                <span>Deposit</span>
                <strong id="detailDeposit"></strong>
            </div>

            <div class="info-card">
                <span>Stok</span>
                <strong id="detailStock"></strong>
            </div>

            <div class="info-card">
                <span>Kondisi</span>
                <strong id="detailCondition"></strong>
            </div>

        </div>

        <div class="detail-section">

            <h4>Deskripsi</h4>

            <p id="detailDescription"></p>

        </div>

        <div class="detail-section">

            <h4>Spesifikasi</h4>

            <p id="detailSpec"></p>

        </div>

        <div class="detail-section">

            <h4>Include Item</h4>

            <p id="detailInclude"></p>

        </div>

    </div>

</div>

</div>


    </div>

</div>

<script src="./assets/js/script-products-admin.js"></script>

</body>
</html>