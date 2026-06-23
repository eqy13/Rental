<?php

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    $id = (int)($_GET['id'] ?? 0);

    if ($id <= 0) {
        throw new Exception('ID tidak valid');
    }

    $stmt = $pdo->prepare("
        SELECT
            r.id,
            r.tanggal_sewa,
            r.tanggal_kembali,
            r.total_harga,
            r.status,

            p.nama_produk,
            p.deposit,

            rd.qty,

            pay.metode_pembayaran

        FROM rentals r

        JOIN rental_details rd
            ON rd.rental_id = r.id

        JOIN products p
            ON p.id = rd.product_id

        LEFT JOIN payments pay
            ON pay.rental_id = r.id

        WHERE r.id = ?
        LIMIT 1
    ");

    $stmt->execute([$id]);

    $rental = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$rental) {
        throw new Exception('Data rental tidak ditemukan');
    }

    echo json_encode([
        'success' => true,
        'data' => $rental
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}