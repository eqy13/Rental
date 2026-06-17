<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

        throw new Exception(
            'Method tidak diizinkan'
        );

    }

    $nama_kategori =
    trim(
        $_POST['nama_kategori']
        ?? ''
    );

    if (
        $nama_kategori === ''
    ) {

        throw new Exception(
            'Nama kategori wajib diisi'
        );

    }

    /* =========================
       CEK DUPLIKAT
    ========================= */

    $check =
    $pdo->prepare("
        SELECT id
        FROM categories
        WHERE nama_kategori = ?
        LIMIT 1
    ");

    $check->execute([
        $nama_kategori
    ]);

    if (
        $check->fetch()
    ) {

        throw new Exception(
            'Kategori sudah ada'
        );

    }

    /* =========================
       UPLOAD ICON
    ========================= */

    $icon = null;

    if (
        isset($_FILES['icon']) &&
        $_FILES['icon']['error']
        === UPLOAD_ERR_OK
    ) {

        $allowed =
        [
            'jpg',
            'jpeg',
            'png',
            'webp'
        ];

        $extension =
        strtolower(
            pathinfo(
                $_FILES['icon']['name'],
                PATHINFO_EXTENSION
            )
        );

        if (
            !in_array(
                $extension,
                $allowed
            )
        ) {

            throw new Exception(
                'Format gambar tidak didukung'
            );

        }

        $fileName =
        uniqid('cat_') .
        '.' .
        $extension;

        $uploadDir =
        '../../uploads/categories/';

        if (
            !is_dir($uploadDir)
        ) {

            mkdir(
                $uploadDir,
                0777,
                true
            );

        }

        $destination =
        $uploadDir .
        $fileName;

        if (
            !move_uploaded_file(
                $_FILES['icon']['tmp_name'],
                $destination
            )
        ) {

            throw new Exception(
                'Gagal upload gambar'
            );

        }

        $icon = $fileName;
    }

    /* =========================
       INSERT DATABASE
    ========================= */

    $stmt =
    $pdo->prepare("
        INSERT INTO categories
        (
            nama_kategori,
            icon
        )
        VALUES
        (
            ?,
            ?
        )
    ");

    $stmt->execute([
        $nama_kategori,
        $icon
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Kategori berhasil ditambahkan'
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}