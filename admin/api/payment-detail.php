<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $paymentId = filter_input(
        INPUT_GET,
        'id',
        FILTER_VALIDATE_INT
    );

    if (!$paymentId) {

        throw new Exception(
            'ID Rental tidak valid'
        );

    }

    $stmt = $pdo->prepare("
        SELECT
            u.nama_lengkap,
            u.email,
            p.nama_produk,
            rd.qty,
            rd.harga,
            r.tanggal_sewa,
            r.tanggal_kembali,
            r.total_harga,
            r.status AS rental_status,
            pay.metode_pembayaran,
            pay.status AS payment_status,
            pay.bukti_pembayaran

        FROM payments pay

        INNER JOIN rentals r
            ON r.id = pay.rental_id

        INNER JOIN users u
            ON u.id = r.user_id

        INNER JOIN rental_details rd
            ON rd.rental_id = r.id

        INNER JOIN products p
            ON p.id = rd.product_id

        WHERE pay.id = ?

        LIMIT 1
    ");

    $stmt->execute([$paymentId]);

    $detail =
    $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$detail) {

        throw new Exception(
            'Data tidak ditemukan'
        );

    }

    echo json_encode([
        'success' => true,
        'data' => $detail
    ]);

}
catch(Exception $e){

    http_response_code(400);

    echo json_encode([

        'success' => false,

        'message' => $e->getMessage()

    ]);

}