<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

if (!isset($_SESSION["user_id"])) {
    echo json_encode([]);
    exit;
}

$user_id = $_SESSION["user_id"];

$stmt = $pdo->prepare("

SELECT
    p.id,
    p.nama_produk,
    p.harga_sewa,
    p.stok,
    p.kondisi,

    (
        SELECT gambar
        FROM product_images
        WHERE product_id = p.id
        LIMIT 1
    ) AS gambar

FROM likes l

JOIN products p
ON p.id = l.product_id

WHERE l.user_id = ?

ORDER BY l.id DESC

");

$stmt->execute([$user_id]);

$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($data);