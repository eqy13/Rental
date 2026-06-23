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
    r.id,
    r.tanggal_sewa,
    r.tanggal_kembali,
    r.total_harga,
    r.status,

    p.nama_produk,

    rd.qty,

    pay.metode_pembayaran

FROM rentals r

LEFT JOIN rental_details rd
ON rd.rental_id = r.id

LEFT JOIN products p
ON p.id = rd.product_id

LEFT JOIN payments pay
ON pay.rental_id = r.id

WHERE r.user_id = ?

ORDER BY r.id DESC
");

$stmt->execute([$user_id]);

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);