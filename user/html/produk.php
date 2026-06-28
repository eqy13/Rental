<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login-user.php");
    exit;
}

require "../config/koneksi.php";

/* =========================
   AMBIL PRODUK
========================= */

$stmt = $pdo->prepare("
    SELECT 
        p.*,
        c.nama_kategori
    FROM products p
    LEFT JOIN categories c ON p.category_id = c.id
    WHERE p.status = 'tersedia'
    ORDER BY p.created_at DESC
");

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk Rental</title>

    <link rel="stylesheet" href="../css/style-produk.css">

    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="product-page">

    <header class="product-header">
        <h1>Produk Tersedia</h1>
    </header>

    <div class="product-grid">

        <?php foreach ($products as $p): ?>

            <div class="product-card glass"
                 onclick="location.href='detail.php?id=<?= $p['id'] ?>'">

                <div class="product-info">

                    <h3><?= htmlspecialchars($p['nama_produk']) ?></h3>

                    <p class="category">
                        <?= htmlspecialchars($p['nama_kategori'] ?? 'Uncategorized') ?>
                    </p>

                    <p class="condition">
                        Kondisi: <?= $p['kondisi'] ?>
                    </p>

                    <p class="stock">
                        Stok: <?= $p['stok'] ?>
                    </p>

                </div>

                <div class="product-footer">

                    <span class="price">
                        Rp <?= number_format($p['harga_sewa'], 0, ',', '.') ?> / hari
                    </span>

                    <span class="status <?= $p['status'] ?>">
                        <?= $p['status'] ?>
                    </span>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

</body>
</html>