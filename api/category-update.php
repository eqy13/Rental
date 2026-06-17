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

    $id =
    (int)(
        $_POST['category_id']
        ?? 0
    );

    $nama_kategori =
    trim(
        $_POST['nama_kategori']
        ?? ''
    );

    if (!$id) {

        throw new Exception(
            'ID kategori tidak valid'
        );

    }

    if ($nama_kategori === '') {

        throw new Exception(
            'Nama kategori wajib diisi'
        );

    }

    /* =========================
       AMBIL DATA LAMA
    ========================= */

    $stmt =
    $pdo->prepare("
        SELECT icon
        FROM categories
        WHERE id = ?
        LIMIT 1
    ");

    $stmt->execute([
        $id
    ]);

    $oldCategory =
    $stmt->fetch(
        PDO::FETCH_ASSOC
    );

    if (!$oldCategory) {

        throw new Exception(
            'Kategori tidak ditemukan'
        );

    }

    $icon =
    $oldCategory['icon'];

    /* =========================
       UPLOAD ICON BARU
    ========================= */

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

        /* hapus gambar lama */

        if (
            !empty($oldCategory['icon'])
        ) {

            $oldFile =
            $uploadDir .
            $oldCategory['icon'];

            if (
                file_exists($oldFile)
            ) {

                unlink(
                    $oldFile
                );

            }

        }

        $icon =
        $fileName;
    }

    /* =========================
       UPDATE
    ========================= */

    $stmt =
    $pdo->prepare("
        UPDATE categories
        SET
            nama_kategori = ?,
            icon = ?
        WHERE id = ?
    ");

    $stmt->execute([
        $nama_kategori,
        $icon,
        $id
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'Kategori berhasil diperbarui'
    ]);

} catch (Exception $e) {

    http_response_code(400);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
}