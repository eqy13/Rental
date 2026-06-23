
<?php

require_once '../config/db.php';

header('Content-Type: application/json');

try {

    $data = json_decode(
        file_get_contents("php://input"),
        true
    );

    /*
    ==========================
    CUSTOMER
    ==========================
    */

    $user_id = null;

    $nama_pelanggan = trim(
        $data['nama_pelanggan'] ?? ''
    );

    $nomor_hp = trim(
        $data['nomor_hp'] ?? ''
    );

    /*
    ==========================
    CEK MEMBER OTOMATIS
    ==========================
    */

    if (!empty($nomor_hp)) {

        $stmt = $pdo->prepare("
            SELECT
                id,
                nama_lengkap,
                nomor_hp
            FROM users
            WHERE role = 'user'
            AND nomor_hp = ?
            LIMIT 1
        ");

        $stmt->execute([
            $nomor_hp
        ]);

        $member =
        $stmt->fetch(PDO::FETCH_ASSOC);

        if ($member) {

            $user_id =
            (int)$member['id'];

            $nama_pelanggan = null;
            $nomor_hp = null;
        }
    }

    /*
    ==========================
    RENTAL DATA
    ==========================
    */

    $product_id =
    (int)($data['product_id'] ?? 0);

    $qty =
    max(
        1,
        (int)($data['qty'] ?? 1)
    );

    $tanggal_sewa =
    $data['start_date'] ?? '';

    $tanggal_kembali =
    $data['end_date'] ?? '';

    $payment_method =
    $data['payment_method'] ?? 'cash';

    /*
    ==========================
    VALIDASI
    ==========================
    */

    if (
        empty($user_id)
        &&
        empty($nama_pelanggan)
    ) {

        echo json_encode([
            'success' => false,
            'message' =>
            'Nama pelanggan wajib diisi'
        ]);

        exit;
    }

    if ($product_id <= 0) {

        echo json_encode([
            'success' => false,
            'message' =>
            'Produk belum dipilih'
        ]);

        exit;
    }

    /*
    ==========================
    AMBIL PRODUK
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

    $stmt->execute([
        $product_id
    ]);

    $product =
    $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {

        echo json_encode([
            'success' => false,
            'message' =>
            'Produk tidak ditemukan'
        ]);

        exit;
    }

    if ($product['stok'] < $qty) {

        echo json_encode([
            'success' => false,
            'message' =>
            'Stok tidak mencukupi'
        ]);

        exit;
    }

    /*
    ==========================
    HITUNG HARI
    ==========================
    */

    $start =
    new DateTime($tanggal_sewa);

    $end =
    new DateTime($tanggal_kembali);

    $days =
    $start->diff($end)->days;

    if ($days < 1) {

        $days = 1;
    }

    /*
    ==========================
    TOTAL HARGA
    ==========================
    */

    $total_harga =
        $product['harga_sewa']
        *
        $qty
        *
        $days;

    /*
    ==========================
    TRANSACTION
    ==========================
    */

    $pdo->beginTransaction();

    /*
    ==========================
    INSERT RENTAL
    ==========================
    */

    $stmt = $pdo->prepare("
        INSERT INTO rentals
        (
            user_id,
            nama_pelanggan,
            nomor_hp,
            tanggal_sewa,
            tanggal_kembali,
            total_harga,
            status
        )
        VALUES
        (
            ?,
            ?,
            ?,
            ?,
            ?,
            ?,
            'pending'
        )
    ");

    $stmt->execute([

        $user_id,

        $nama_pelanggan,

        $nomor_hp,

        $tanggal_sewa,

        $tanggal_kembali,

        $total_harga

    ]);

    $rental_id =
    $pdo->lastInsertId();

    /*
    ==========================
    PAYMENT
    ==========================
    */

    $stmt = $pdo->prepare("
        INSERT INTO payments
        (
            rental_id,
            metode_pembayaran,
            status
        )
        VALUES
        (
            ?,
            ?,
            'menunggu'
        )
    ");

    $stmt->execute([

        $rental_id,

        $payment_method

    ]);

    /*
    ==========================
    DETAIL RENTAL
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
        (
            ?,
            ?,
            ?,
            ?
        )
    ");

    $stmt->execute([

        $rental_id,

        $product_id,

        $qty,

        $total_harga

    ]);

    /*
    ==========================
    UPDATE STOK
    ==========================
    */

    $stmt = $pdo->prepare("
        UPDATE products
        SET stok = stok - ?
        WHERE id = ?
    ");

    $stmt->execute([

        $qty,

        $product_id

    ]);

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' =>
        'Transaksi berhasil dibuat'
    ]);

} catch (Exception $e) {

    if (
        isset($pdo)
        &&
        $pdo->inTransaction()
    ) {

        $pdo->rollBack();
    }

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}
