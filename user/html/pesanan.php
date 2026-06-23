<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login-user.php');
    exit;
}

require "../config/koneksi.php";

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
    SELECT
        r.id,
        r.tanggal_sewa,
        r.tanggal_kembali,
        r.total_harga,
        r.status,

        p.nama_produk,
        p.deposit,

        rd.qty,

        pay.metode_pembayaran,
        pay.status AS payment_status,

        (
            SELECT gambar
            FROM product_images
            WHERE product_id = p.id
            LIMIT 1
        ) AS gambar

    FROM rentals r

    JOIN rental_details rd
        ON rd.rental_id = r.id

    JOIN products p
        ON p.id = rd.product_id

    LEFT JOIN payments pay
        ON pay.rental_id = r.id

    WHERE r.user_id = ?

    ORDER BY r.id DESC
");

$stmt->execute([$user_id]);

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Pesanan Saya</title>

<link rel="stylesheet" href="../css/style-pesanan.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="orders-page">

    <header class="orders-header">
        <div class="header-left">
            <a href="user.php" class="back-btn">
                <i class="fa-solid fa-arrow-left"></i>
            </a>

            <div>
                <h1>Pesanan Saya</h1>
                <p>Kelola semua pesanan dan rental Anda</p>
            </div>
        </div>
    </header>

    <div class="orders-container">

        <?php if (count($orders) === 0): ?>
            <p style="color:#999;">Belum ada pesanan</p>
        <?php endif; ?>

        <?php foreach ($orders as $order): ?>

            <div class="order-card glass">

                <div class="order-top">

                    <div>
                        <span class="order-id">
                            #RNT<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?>
                        </span>

                        <h2><?= htmlspecialchars($order['nama_produk']) ?></h2>
                    </div>

                    <span class="status <?= strtolower($order['status']) ?>">
                        <?= htmlspecialchars($order['status']) ?>
                    </span>

                </div>

                <div class="order-info">

                    <div class="info-box">
                        <p>Tanggal Ambil</p>
                        <h3><?= $order['tanggal_sewa'] ?></h3>
                    </div>

                    <div class="info-box">
                        <p>Tanggal Kembali</p>
                        <h3><?= $order['tanggal_kembali'] ?></h3>
                    </div>

                    <div class="info-box">
                        <p>Durasi</p>
                        <h3>
                            <?php
                                $start = new DateTime($order['tanggal_sewa']);
                                $end = new DateTime($order['tanggal_kembali']);
                                echo $start->diff($end)->days . " Hari";
                            ?>
                        </h3>
                    </div>

                    <div class="info-box">
                        <p>Jumlah</p>
                        <h3><?= $order['qty'] ?></h3>
                    </div>

                    <div class="info-box">
                        <p>Pembayaran</p>
                        <h3><?= strtoupper($order['metode_pembayaran'] ?? '-') ?></h3>
                    </div>

                </div>

                <div class="payment-box">

                    <div>
                        <p>Total Pembayaran</p>
                        <h2>
                            Rp <?= number_format($order['total_harga'],0,',','.') ?>
                        </h2>
                    </div>

                    <button
                        class="download-btn"
                        data-id="<?= $order['id'] ?>"
                    >
                        <i class="fa-solid fa-eye"></i>
                        Detail
                    </button>

                </div>

            </div>

        <?php endforeach; ?>

    </div>
</div>

<!-- MODAL -->
<div id="detailModal" class="modal">

    <div class="modal-content">

        <div class="modal-header">
            <h3>Detail Rental</h3>

            <button onclick="closeDetailModal()">✕</button>
        </div>

        <div id="detailContent"></div>

    </div>

</div>

<script src="../js/pesanan.js"></script>

</body>
</html>