<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $stmt = $pdo->prepare("
        SELECT
            id,
            nama,
            email,
            nomor_hp,
            foto_profil,
            tipe,
            created_at
        FROM (

            SELECT
                u.id,
                u.nama_lengkap AS nama,
                u.email,
                u.nomor_hp,
                u.foto_profil,
                'Member' AS tipe,
                u.created_at
            FROM users u
            WHERE u.role = 'user'

            UNION ALL

            SELECT
                NULL AS id,
                r.nama_pelanggan AS nama,
                NULL AS email,
                r.nomor_hp,
                NULL AS foto_profil,
                'Non-Member' AS tipe,
                MIN(r.created_at) AS created_at
            FROM rentals r
            WHERE r.nama_pelanggan IS NOT NULL
            AND r.nama_pelanggan <> ''
            GROUP BY
                r.nama_pelanggan,
                r.nomor_hp

        ) customers

        ORDER BY created_at DESC
    ");

    $stmt->execute();

    $customers = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($customers as &$customer) {

        /*
        ==========================
        FOTO MEMBER
        ==========================
        */

        if ($customer['tipe'] === 'Member') {

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

        /*
        ==========================
        FOTO NON MEMBER
        ==========================
        */

        else {

            $customer['foto_profil'] =
            "assets/images/default-user.png";

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