<?php

header(
    'Content-Type: application/json'
);

require_once '../config/db.php';

try {

    $stmt = $pdo->query("
        SELECT
            products.id,
            products.nama_produk,
            products.stok,
            products.kondisi,
            products.status,
            categories.nama_kategori
        FROM products
        LEFT JOIN categories
        ON products.category_id = categories.id
        ORDER BY products.id DESC
    ");

    $products =
    $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'success' => true,
        'data' => $products
    ]);

} catch (Exception $e) {

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}