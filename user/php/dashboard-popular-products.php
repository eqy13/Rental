<?php

header('Content-Type: application/json');

require_once '../config/db.php';

$stmt = $pdo->query("
SELECT
id,
nama_produk,
harga_sewa,
foto_produk,
stok
FROM products
WHERE status='tersedia'
ORDER BY created_at DESC
LIMIT 8
");

echo json_encode(
$stmt->fetchAll(PDO::FETCH_ASSOC)
);