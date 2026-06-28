<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $id = filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

    if (!$id) {

        throw new Exception(
            'ID produk tidak valid'
        );

    }

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

    $stmt->execute([
        $id
    ]);

    $product =
    $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {

        throw new Exception(
            'Produk tidak ditemukan'
        );

    }

    $imageStmt = $pdo->prepare("
        SELECT
            id,
            gambar
        FROM product_images
        WHERE product_id = ?
        ORDER BY id ASC
    ");

    $imageStmt->execute([
        $id
    ]);

    $product['images'] =
    $imageStmt->fetchAll(
        PDO::FETCH_ASSOC
    );

    echo json_encode(
        $product,
        JSON_UNESCAPED_UNICODE
    );

}

catch (Exception $e) {

    http_response_code(400);

    echo json_encode([

        'success' => false,

        'message' => $e->getMessage()

    ]);

}