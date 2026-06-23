<?php

header('Content-Type: application/json');

require_once '../config/db.php';

try {

    $stmt = $pdo->query("
        SELECT
            id,
            nama_lengkap AS name
        FROM users
        WHERE role = 'user'
        ORDER BY nama_lengkap ASC
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