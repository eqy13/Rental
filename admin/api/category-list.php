<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'GET') {

        http_response_code(405);

        echo json_encode([
            'success' => false,
            'message' => 'Method tidak diizinkan'
        ]);

        exit;
    }

    $stmt = $pdo->query("
        SELECT
            id,
            nama_kategori,
            icon
        FROM categories
        ORDER BY nama_kategori ASC
    ");

    $categories = $stmt->fetchAll();

    echo json_encode(
        $categories,
        JSON_UNESCAPED_UNICODE
    );

} catch (PDOException $e) {

    error_log($e->getMessage());

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => 'Terjadi kesalahan server'
    ]);

}