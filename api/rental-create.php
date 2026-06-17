<?php

require_once '../config/db.php';

header('Content-Type: application/json');

try {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    $user_id = (int)$data['user_id'];
    $product_id = (int)$data['product_id'];
    $qty = (int)$data['qty'];

    $tanggal_sewa = $data['start_date'];
    $tanggal_kembali = $data['end_date'];
    $payment_method = $data['payment_method'];

    /*
    ==========================
    AMBIL DATA PRODUK
    ==========================
    */

    $stmt = $pdo->prepare("
        SELECT
            id,
            nama_produk,
            harga_sewa,
            stok
        FROM products
        WHERE id = ?
    ");

    $stmt->execute([$product_id]);

    $product = $stmt->fetch();

    if (!$product) {

        echo json_encode([
            'success' => false,
            'message' => 'Produk tidak ditemukan'
        ]);

        exit;
    }

    if ($product['stok'] < $qty) {

        echo json_encode([
            'success' => false,
            'message' => 'Stok tidak mencukupi'
        ]);

        exit;
    }

    /*
    ==========================
    HITUNG HARI
    ==========================
    */

    $start = new DateTime($tanggal_sewa);
    $end   = new DateTime($tanggal_kembali);

    $days = $start->diff($end)->days;

    if ($days < 1) {
        $days = 1;
    }

    $total_harga =
        $product['harga_sewa']
        * $qty
        * $days;

    /*
    ==========================
    TRANSACTION
    ==========================
    */

    $pdo->beginTransaction();

    /*
    ==========================
    INSERT RENTALS
    ==========================
    */

    $stmt = $pdo->prepare("
        INSERT INTO rentals
        (
            user_id,
            tanggal_sewa,
            tanggal_kembali,
            total_harga,
            status
        )
        VALUES
        (?, ?, ?, ?, 'pending')
    ");

    $stmt->execute([
        $user_id,
        $tanggal_sewa,
        $tanggal_kembali,
        $total_harga
    ]);

    $rental_id =
    $pdo->lastInsertId();

    $statusPembayaran =
    'menunggu';

    $stmt = $pdo->prepare("
        INSERT INTO payments
        (
            rental_id,
            metode_pembayaran,
            status
        )
        VALUES
        (?, ?, ?)
    ");

    $stmt->execute([
        $rental_id,
        $payment_method,
        $statusPembayaran
    ]);

    /*
    ==========================
    INSERT DETAIL
    ==========================
    */

    $stmt = $pdo->prepare("
        INSERT INTO rental_details
        (
            rental_id,
            product_id,
            qty,
            harga
        )
        VALUES
        (?, ?, ?, ?)
    ");

    $stmt->execute([
        $rental_id,
        $product_id,
        $qty,
        $total_harga
    ]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Transaksi berhasil dibuat'
    ]);

} catch (Exception $e) {

    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}