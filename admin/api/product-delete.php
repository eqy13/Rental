<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $data =
    json_decode(
        file_get_contents(
            'php://input'
        ),
        true
    );

    $id =
    (int)($data['id'] ?? 0);

    if (!$id) {

        throw new Exception(
            'ID tidak valid'
        );

    }

    $stmtImg =
    $pdo->prepare("
        SELECT gambar
        FROM product_images
        WHERE product_id = ?
    ");

    $stmtImg->execute([
        $id
    ]);

    $images =
    $stmtImg->fetchAll();

    foreach ($images as $img) {

        $path =
        '../uploads/products/' .
        $img['gambar'];

        if (
            file_exists($path)
        ) {

            unlink($path);

        }

    }

    $stmt =
    $pdo->prepare("
        DELETE FROM products
        WHERE id = ?
    ");

    $stmt->execute([
        $id
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Produk berhasil dihapus'
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}