<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $stmt = $pdo->prepare("
        SELECT
            p.id,
            p.category_id,
            p.nama_produk,
            p.deskripsi,
            p.harga_sewa,
            p.stok,
            p.deposit,
            p.kondisi,
            p.status,
            p.created_at,

            c.nama_kategori,

            COALESCE(
                MAX(pi.gambar),
                ''
            ) AS gambar,

            COUNT(
                DISTINCT l.id
            ) AS total_likes

        FROM products p

        LEFT JOIN categories c
            ON c.id = p.category_id

        LEFT JOIN product_images pi
            ON pi.product_id = p.id

        LEFT JOIN likes l
            ON l.product_id = p.id

        GROUP BY
            p.id,
            p.category_id,
            p.nama_produk,
            p.deskripsi,
            p.harga_sewa,
            p.stok,
            p.kondisi,
            p.status,
            p.created_at,
            c.nama_kategori

        ORDER BY p.id DESC
    ");

    $stmt->execute();

    $products = $stmt->fetchAll();

    echo json_encode(
        $products,
        JSON_UNESCAPED_UNICODE
    );

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}