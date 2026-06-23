<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

$id = (int)($_GET['id'] ?? 0);

$stmt = $pdo->prepare("
SELECT
    p.*,
    c.nama_kategori
FROM products p
LEFT JOIN categories c
ON c.id = p.category_id
WHERE p.id = ?
LIMIT 1
");

$stmt->execute([$id]);

$product = $stmt->fetch(PDO::FETCH_ASSOC);

if(!$product){

    echo json_encode([
        "success" => false,
        "message" => "Produk tidak ditemukan"
    ]);

    exit;
}

$stmt = $pdo->prepare("
SELECT gambar
FROM product_images
WHERE product_id = ?
");

$stmt->execute([$id]);

$images = $stmt->fetchAll(PDO::FETCH_COLUMN);

echo json_encode([
    "success" => true,
    "product" => $product,
    "images" => $images
]);