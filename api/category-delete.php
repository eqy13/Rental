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
            'ID kategori tidak valid'
        );

    }

    $stmt =
    $pdo->prepare("
        DELETE FROM categories
        WHERE id = ?
    ");

    $stmt->execute([
        $id
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Kategori berhasil dihapus'
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}