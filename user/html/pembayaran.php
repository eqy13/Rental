<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login-user.php');
    exit;
}

require "../config/koneksi.php";

$product_id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
    SELECT
        p.*,
        c.nama_kategori
    FROM products p
    LEFT JOIN categories c
        ON c.id = p.category_id
    WHERE p.id = ?
");

$stmt->execute([$product_id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){

    die("Produk tidak ditemukan");
}

$stmtImage = $pdo->prepare("
    SELECT gambar
    FROM product_images
    WHERE product_id = ?
    LIMIT 1
");

$stmtImage->execute([
    $product_id
]);

$image =
$stmtImage->fetchColumn()
?? 'no-image.png';

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Rental</title>

    <link rel="stylesheet" href="../css/style-pembayaran.css">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body 
    data-price="<?= $product['harga_sewa'] ?>"
    data-deposit="<?= $product['deposit'] ?>"
    >

<form
    action="../php/create-rental.php"
    method="POST"
    enctype="multipart/form-data"
>

<div class="payment-page">

    <header class="payment-header">
        <button type="button" class="back-btn" id="backBtn">
            <i class="fa-solid fa-arrow-left"></i>
        </button>
        <h1>Pembayaran</h1>
    </header>

    <!-- PRODUCT -->
    <section class="payment-card glass">

        <div class="card-title">
            <i class="fa-solid fa-box"></i>
            <h2>Produk Rental</h2>
        </div>

        <!-- SIMULASI PRODUCT (HARUSNYA DARI DB / URL ID) -->
        <input
            type="hidden"
            name="product_id"
            value="<?= $product['id'] ?>"
        >

        <div class="product-box">

            <img
            src="../../uploads/products/<?= $image ?>"
            class="product-image">

            <div class="product-info">
                <h3>
                <?= htmlspecialchars(
                $product['nama_produk']
                ) ?>
                </h3>
                <p class="product-tag">
                <?= htmlspecialchars(
                $product['nama_kategori']
                ) ?>
                </p>
                <p class="product-price">
                Rp <?= number_format(
                $product['harga_sewa'],
                0,
                ',',
                '.'
                ) ?>
                / hari
                </p>
            </div>

        </div>

        <!-- RENTAL INPUT -->
        <div class="rental-grid">

            <div class="input-group">
                <label>Tanggal Mulai</label>
                <input type="date" name="start_date" id="startDate" required>
            </div>

            <div class="input-group">
                <label>Tanggal Berakhir</label>
                <input type="date" name="end_date" id="endDate" required readonly>
            </div>

            <div class="input-group">
                <label>Jumlah Hari</label>
                <div class="qty-box">
                    <button type="button" id="minusDay">-</button>
                    <span id="dayCount">1</span>
                    <button type="button" id="plusDay">+</button>
                </div>
            </div>

            <div class="input-group">
                <label>Jumlah Barang</label>
                <div class="qty-box">
                    <button type="button" id="minusQty">-</button>
                    <span id="qtyCount">1</span>
                    <button type="button" id="plusQty">+</button>
                </div>
            </div>

        </div>

        <input type="hidden" name="qty" id="qtyInput" value="1">
        <input type="hidden" name="payment_method" id="paymentMethod">

    </section>

<!-- SUMMARY -->
<section class="payment-card glass">

    <div class="card-title">

        <i class="fa-solid fa-receipt"></i>

        <h2>Ringkasan</h2>

    </div>

    <div class="summary-box">

        <div class="summary-item">

            <span>Harga Sewa / Hari</span>

            <strong id="priceText">
                Rp0
            </strong>

        </div>

        <div class="summary-item">

            <span>Jumlah Hari</span>

            <strong id="daysText">
                1 Hari
            </strong>

        </div>

        <div class="summary-item">

            <span>Jumlah Barang</span>

            <strong id="qtyText">
                1
            </strong>

        </div>

        <div class="summary-item">

            <span>Subtotal Rental</span>

            <strong id="subtotalText">
                Rp0
            </strong>

        </div>

        <div class="summary-item">

            <span>Deposit</span>

            <strong id="depositText">
                Rp0
            </strong>

        </div>

        <div class="summary-item total">

            <span>Total Pembayaran</span>

            <strong id="totalText">
                Rp0
            </strong>

        </div>

    </div>

</section>



    <button type="button" class="pay-btn" id="payBtn">
        Bayar Sekarang
    </button>

</div>

<!-- MODAL -->
<div id="paymentModal" class="modal hidden">

    <div class="modal-content">
        <h2>Pilih Metode</h2>

        <div id="methodContainer">

            <button type="button" class="method-btn" data-method="bank">
                Bank
            </button>

            <button type="button" class="method-btn" data-method="qris">
                QRIS
            </button>

            <button type="button" class="method-btn" data-method="cash">
                Cash
            </button>

        </div>
         <div
            id="proofContainer"
            style="display:none;"
        >

            <label>
                Upload Bukti Pembayaran
            </label>

            <input
                type="file"
                name="payment_proof"
                id="paymentProof"
                accept="image/*"
            >

            <button
                type="submit"
                id="confirmPayment"
            >
                Kirim Pembayaran
            </button>

        </div>

        <button type="button" id="closeModal">Batal</button>
    </div>

</div>

</form>

<script src="../js/pembayaran.js"></script>
</body>
</html>