<?php

require_once '../config/db.php';

header('Content-Type: application/json');

try{

    $data =
    json_decode(
        file_get_contents("php://input"),
        true
    );

    $rental_id =
    (int)$data['rental_id'];

    $condition =
    $data['condition'];

    $penalty =
    (float)$data['penalty'];

    $late_days =
    (int)$data['late_days'];

    $pdo->beginTransaction();

    /*
    ===========================
    UPDATE RENTAL
    ===========================
    */

    $stmt =
    $pdo->prepare("
        UPDATE rentals
        SET status='selesai'
        WHERE id=?
    ");

    $stmt->execute([
        $rental_id
    ]);

    /*
    ===========================
    AMBIL PRODUK
    ===========================
    */

    $stmt =
    $pdo->prepare("
        SELECT
            product_id,
            qty
        FROM rental_details
        WHERE rental_id=?
    ");

    $stmt->execute([
        $rental_id
    ]);

    $items =
    $stmt->fetchAll();

    /*
===========================
KEMBALIKAN STOK
===========================
*/

if(
    $condition === 'baik' ||
    $condition === 'rusak_ringan'
){

    foreach($items as $item){

        $update =
        $pdo->prepare("
            UPDATE products
            SET stok = stok + ?
            WHERE id=?
        ");

        $update->execute([

            $item['qty'],

            $item['product_id']

        ]);

    }

}

    /*
    ===========================
    SIMPAN RETURN
    ===========================
    */

    $stmt =
    $pdo->prepare("
        INSERT INTO returns
        (
            rental_id,
            kondisi_barang,
            hari_terlambat,
            denda,
            tanggal_pengembalian
        )
        VALUES
        (
            ?,?,?,?,NOW()
        )
    ");

    $stmt->execute([

        $rental_id,

        $condition,

        $late_days,

        $penalty

    ]);

    $pdo->commit();

    echo json_encode([

        "success"=>true

    ]);

}
catch(Exception $e){

    if($pdo->inTransaction()){

        $pdo->rollBack();

    }

    echo json_encode([

        "success"=>false,

        "message"=>$e->getMessage()

    ]);

}