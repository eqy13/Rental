<?php

header('Content-Type: application/json');

require_once '../config/db.php';

try {

    $stmt = $pdo->query("
        SELECT
            id,
            nama_produk,
            harga_sewa,
            deposit,
            stok
        FROM products
        WHERE status = 'tersedia'
        ORDER BY nama_produk ASC
    ");

    echo json_encode(
        $stmt->fetchAll(PDO::FETCH_ASSOC)
    );

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}