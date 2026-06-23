<?php

header('Content-Type: application/json');

require_once '../config/db.php';

try{

    // Total Member

    $stmt = $pdo->query("
        SELECT COUNT(*) total
        FROM users
        WHERE role='user'
    ");

    $member =
    (int)$stmt->fetch()['total'];

    // Total Non Member

    $stmt = $pdo->query("
        SELECT COUNT(*) total
        FROM (
            SELECT
                nama_pelanggan,
                nomor_hp
            FROM rentals
            WHERE nama_pelanggan IS NOT NULL
            AND nama_pelanggan <> ''
            GROUP BY
                nama_pelanggan,
                nomor_hp
        ) t
    ");

    $nonMember =
    (int)$stmt->fetch()['total'];

    echo json_encode([

        'success' => true,

        'member' => $member,

        'non_member' => $nonMember,

        'total' => $member + $nonMember

    ]);

}
catch(Exception $e){

    echo json_encode([

        'success' => false,

        'message' => $e->getMessage()

    ]);

}