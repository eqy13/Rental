<?php

session_start();
require "../config/koneksi.php";

if (!isset($_SESSION['user_id'])) {

    header("Location: ../html/login-user.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$product_id = (int) $_POST['product_id'];
$qty        = (int) $_POST['qty'];

$start  = $_POST['start_date'];
$end    = $_POST['end_date'];

$method = $_POST['payment_method'];

try{

    $pdo->beginTransaction();

    /*
    ======================
    AMBIL PRODUK
    ======================
    */

    $stmt = $pdo->prepare("
        SELECT *
        FROM products
        WHERE id = ?
    ");

    $stmt->execute([
        $product_id
    ]);

    $product =
    $stmt->fetch(PDO::FETCH_ASSOC);

    if(!$product){

        throw new Exception(
            "Produk tidak ditemukan"
        );
    }

    /*
    ======================
    CEK STOK
    ======================
    */

    if($qty > $product['stok']){

        throw new Exception(
            "Stok tidak mencukupi"
        );
    }

    /*
    ======================
    HITUNG TOTAL
    ======================
    */

    $harga =
    $product['harga_sewa'];

    $deposit =
    $product['deposit'];

    $startDate =
    new DateTime($start);

    $endDate =
    new DateTime($end);

    $days =
    $startDate
    ->diff($endDate)
    ->days;

    if($days < 1){

        $days = 1;
    }

    $total =
    ($harga * $qty * $days);

    /*
    ======================
    VALIDASI BUKTI
    ======================
    */

    if(
        $method !== 'cash'
        &&
        empty(
            $_FILES['payment_proof']['name']
        )
    ){

        throw new Exception(
            "Silakan upload bukti pembayaran"
        );
    }

    /*
    ======================
    RENTAL
    ======================
    */

$statusRental = 'pending';

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
        (
            ?, ?, ?, ?, ?
        )
    ");

    $stmt->execute([
        $user_id,
        $start,
        $end,
        $total,
        $statusRental
    ]);

    $rental_id =
    $pdo->lastInsertId();

    /*
    ======================
    UPLOAD BUKTI
    ======================
    */

    $bukti = null;

    if(
        !empty(
            $_FILES['payment_proof']['name']
        )
    ){

        $filename =
        time() .
        '_' .
        basename(
            $_FILES['payment_proof']['name']
        );

        $uploadPath =
        "../../uploads/payments/" .
        $filename;

        move_uploaded_file(
            $_FILES['payment_proof']['tmp_name'],
            $uploadPath
        );

        $bukti = $filename;
    }

    /*
    ======================
    PAYMENT
    ======================
    */

 $statusPembayaran = 'menunggu';

    $stmt = $pdo->prepare("
        INSERT INTO payments
        (
            rental_id,
            metode_pembayaran,
            status,
            bukti_pembayaran
        )
        VALUES
        (
            ?, ?, ?, ?
        )
    ");

    $stmt->execute([
        $rental_id,
        $method,
        $statusPembayaran,
        $bukti
    ]);

    /*
    ======================
    DETAIL RENTAL
    ======================
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
            ?, ?, ?, ?
        )
    ");

    $stmt->execute([
        $rental_id,
        $product_id,
        $qty,
        $harga
    ]);

    /*
    ======================
    KURANGI STOK
    ======================
    */

    $pdo->commit();

    header(
        "Location: ../html/payment-success.php?id=" .
        $rental_id
    );

    exit;
}
catch(Exception $e){

    if(
        $pdo->inTransaction()
    ){
        $pdo->rollBack();
    }

    die(
        "Error: " .
        $e->getMessage()
    );
}