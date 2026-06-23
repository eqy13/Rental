<?php

header('Content-Type: application/json');

require_once '../config/db.php';

try {

$stmt = $pdo->query("
    SELECT
        p.id,
        p.metode_pembayaran,
        p.status AS payment_status,

        r.status AS rental_status,
        r.total_harga,

        p.bukti_pembayaran,
        p.created_at,

        COALESCE(
            r.nama_pelanggan,
            u.nama_lengkap
        ) AS nama_pelanggan,

        COALESCE(
            r.nomor_hp,
            u.nomor_hp
        ) AS nomor_hp

    FROM payments p

    LEFT JOIN rentals r
        ON p.rental_id = r.id

    LEFT JOIN users u
        ON r.user_id = u.id

    ORDER BY p.id DESC
");

    echo json_encode(
        $stmt->fetchAll(PDO::FETCH_ASSOC)
    );

} catch(Exception $e){

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}