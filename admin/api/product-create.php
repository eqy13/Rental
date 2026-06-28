<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception('Method tidak diizinkan');
    }

    $nama_produk = trim($_POST['nama_produk'] ?? '');

    $category_id = (int)($_POST['category_id'] ?? 0);

    $harga_sewa = max(
        0,
        (float)($_POST['harga_sewa'] ?? 0)
    );

    $deposit = max(
        0,
        (float)($_POST['deposit'] ?? 0)
    );

    $stok = max(
        0,
        (int)($_POST['stok'] ?? 0)
    );


    $kondisi = trim($_POST['kondisi'] ?? 'baik');

    $deskripsi = trim($_POST['deskripsi'] ?? '');

    $spesifikasi = trim($_POST['spesifikasi'] ?? '');

    $include_item = trim($_POST['include_item'] ?? '');

    $status = $stok > 0
        ? 'tersedia'
        : 'maintenance';

    if (
        empty($nama_produk) ||
        empty($category_id) ||
        empty($harga_sewa)
    ) {
        throw new Exception('Data produk belum lengkap');
    }

    $pdo->beginTransaction();

    $stmt = $pdo->prepare("
        INSERT INTO products
        (
            nama_produk,
            category_id,
            harga_sewa,
            deposit,
            stok,
            kondisi,
            status,
            deskripsi,
            spesifikasi,
            include_item
        )
        VALUES
        (
            ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
        )
    ");

    $stmt->execute([
        $nama_produk,
        $category_id,
        $harga_sewa,
        $deposit,
        $stok,
        $kondisi,
        $status,
        $deskripsi,
        $spesifikasi,
        $include_item
    ]);



    $productId = $pdo->lastInsertId();

    if (
        isset($_FILES['productImage']) &&
        !empty($_FILES['productImage']['name'][0])
    ) {

        $uploadDir = '../../uploads/products/';

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $allow = [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $total = count($_FILES['productImage']['name']);

        for ($i = 0; $i < $total; $i++) {

            if (
                $_FILES['productImage']['error'][$i] !== UPLOAD_ERR_OK
            ) {
                continue;
            }

            $extension = strtolower(
                pathinfo(
                    $_FILES['productImage']['name'][$i],
                    PATHINFO_EXTENSION
                )
            );

            if (!in_array($extension, $allow)) {
                continue;
            }

            $newFileName =
                time() .
                '_' .
                uniqid() .
                '.' .
                $extension;

            $destination =
                $uploadDir .
                $newFileName;

            if (
                move_uploaded_file(
                    $_FILES['productImage']['tmp_name'][$i],
                    $destination
                )
            ) {

                $img = $pdo->prepare("
                    INSERT INTO product_images
                    (
                        product_id,
                        gambar
                    )
                    VALUES
                    (
                        ?,
                        ?
                    )
                ");

                $img->execute([
                    $productId,
                    $newFileName
                ]);
            }
        }
    }

    $pdo->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Produk berhasil ditambahkan'
    ]);

} catch (Exception $e) {

    if (
        isset($pdo) &&
        $pdo->inTransaction()
    ) {
        $pdo->rollBack();
    }

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}