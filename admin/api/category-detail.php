<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $id =
    filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

    if (!$id) {

        throw new Exception(
            'ID kategori tidak valid'
        );

    }

    $stmt =
    $pdo->prepare("
        SELECT *
        FROM categories
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $id
    ]);

    $category =
    $stmt->fetch();

    if (!$category) {

        throw new Exception(
            'Kategori tidak ditemukan'
        );

    }

    echo json_encode(
        $category
    );

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}