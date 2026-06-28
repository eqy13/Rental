<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){

    echo json_encode([]);
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("
SELECT
    r.*,
    p.nama_produk,

    (
        SELECT gambar
        FROM product_images pi
        WHERE pi.product_id = p.id
        LIMIT 1
    ) AS gambar

FROM rentals r

JOIN rental_details rd
ON rd.rental_id = r.id

JOIN products p
ON p.id = rd.product_id

WHERE
r.user_id = ?
AND r.status IN
(
    'dibayar',
    'disewa'
)

ORDER BY r.id DESC
LIMIT 1
");

$stmt->execute([$user_id]);

echo json_encode(
    $stmt->fetch(PDO::FETCH_ASSOC)
);