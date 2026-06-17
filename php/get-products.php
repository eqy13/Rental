<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

$user_id =
$_SESSION['user_id']
?? 0;

$stmt =
$pdo->prepare("
SELECT
    p.*,

    c.nama_kategori,

    (
        SELECT gambar
        FROM product_images pi
        WHERE pi.product_id = p.id
        LIMIT 1
    ) AS gambar,

    IF(
        l.id IS NULL,
        0,
        1
    ) AS liked

FROM products p

LEFT JOIN categories c
ON c.id = p.category_id

LEFT JOIN likes l
ON l.product_id = p.id
AND l.user_id = ?

WHERE p.status = 'tersedia'

ORDER BY p.created_at DESC

LIMIT 8
");

$stmt->execute([
    $user_id
]);

echo json_encode(
    $stmt->fetchAll(
        PDO::FETCH_ASSOC
    )
);