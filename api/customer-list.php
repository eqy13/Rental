<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $stmt = $pdo->prepare("
        SELECT
            id,
            nama_lengkap,
            email,
            nomor_hp,
            foto_profil,
            status,
            created_at
        FROM users
        WHERE role = 'user'
        ORDER BY id DESC
    ");

    $stmt->execute();

    $customers = $stmt->fetchAll();

    foreach ($customers as &$customer) {

        if (
            empty($customer['foto_profil']) ||
            !file_exists(
                "../uploads/profile/" .
                $customer['foto_profil']
            )
        ) {

            $customer['foto_profil'] =
            "assets/images/default-user.png";

        } else {

            $customer['foto_profil'] =
            "uploads/profile/" .
            $customer['foto_profil'];

        }
    }

    echo json_encode([
        'success' => true,
        'data' => $customers
    ]);

} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}