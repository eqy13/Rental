<?php

require_once '../config/db.php';

$stmt = $pdo->query("
    SELECT
        r.id,

        COALESCE(
            r.nama_pelanggan,
            u.nama_lengkap
        ) AS nama_pelanggan,

        r.tanggal_kembali

    FROM rentals r

    LEFT JOIN users u
        ON u.id = r.user_id

    WHERE r.status = 'disewa'

    ORDER BY r.id DESC
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);