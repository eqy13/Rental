<?php

require_once '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$payment_id =
(int)$data['payment_id'];

$status =
$data['status'];

$allowedStatus = [
    'menunggu',
    'diterima',
    'ditolak'
];

if(
    !in_array(
        $status,
        $allowedStatus
    )
){
    echo json_encode([
        'success' => false,
        'message' => 'Status tidak valid'
    ]);
    exit;
}

try{

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
    SELECT status, rental_id
    FROM payments
    WHERE id = ?
");

$stmt->execute([
    $payment_id
]);

$oldPayment = $stmt->fetch();

$oldStatus = $oldPayment['status'];

    // UPDATE PAYMENT

    $stmt = $pdo->prepare("
        UPDATE payments
        SET status = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $status,
        $payment_id
    ]);

    // AMBIL RENTAL ID

    $stmt = $pdo->prepare("
        SELECT rental_id
        FROM payments
        WHERE id = ?
    ");

    $stmt->execute([
        $payment_id
    ]);

    $payment =
    $stmt->fetch();

    // CEK STATUS RENTAL
    $stmt = $pdo->prepare("
        SELECT status
        FROM rentals
        WHERE id = ?
    ");

    $stmt->execute([
        $payment['rental_id']
    ]);

    $rental = $stmt->fetch();

    if(
        $rental &&
        $rental['status'] === 'selesai'
    ){
        throw new Exception(
            'Rental sudah selesai dan status pembayaran tidak dapat diubah'
        );
    }

    if($payment){

        if(
            $status === 'diterima'
        ){

            if(
                $status === 'diterima' &&
                $oldStatus !== 'diterima'
            ){

                    // Ubah status rental
                    $stmt = $pdo->prepare("
                        UPDATE rentals
                        SET status = 'disewa'
                        WHERE id = ?
                    ");

                    $stmt->execute([
                        $payment['rental_id']
                    ]);

                    // Ambil detail produk
                    $stmt = $pdo->prepare("
                        SELECT product_id, qty
                        FROM rental_details
                        WHERE rental_id = ?
                    ");

                    $stmt->execute([
                        $payment['rental_id']
                    ]);

                    $details = $stmt->fetchAll();

                    // Kurangi stok
                    foreach($details as $detail){

                        $stmt = $pdo->prepare("
                            UPDATE products
                            SET stok = stok - ?
                            WHERE id = ?
                        ");

                        $stmt->execute([
                            $detail['qty'],
                            $detail['product_id']
                        ]);
                    }
                }
            }

        if(
            $status === 'ditolak'
        ){

            $stmt =
            $pdo->prepare("
                UPDATE rentals
                SET status = 'dibatalkan'
                WHERE id = ?
            ");

            $stmt->execute([
    $payment['rental_id']
]);

        if($oldStatus === 'diterima'){

            $stmt = $pdo->prepare("
                SELECT product_id, qty
                FROM rental_details
                WHERE rental_id = ?
            ");

            $stmt->execute([
                $payment['rental_id']
            ]);

            $details = $stmt->fetchAll();

            foreach($details as $detail){

                $stmt = $pdo->prepare("
                    UPDATE products
                    SET stok = stok + ?
                    WHERE id = ?
                ");

                $stmt->execute([
                    $detail['qty'],
                    $detail['product_id']
                ]);
            }
        }


        }

    }

    $pdo->commit();

    echo json_encode([
        'success' => true
    ]);

}
catch(Exception $e){

    $pdo->rollBack();

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}