<?php

require_once '../config/db.php';

$stmt = $pdo->query("
    SELECT
        r.id,

        COALESCE(
            r.nama_pelanggan,
            u.nama_lengkap
        ) AS nama_pelanggan,

        COALESCE(
            r.nomor_hp,
            u.nomor_hp
        ) AS nomor_hp,

        r.tanggal_sewa,
        r.tanggal_kembali,
        r.total_harga,
        r.status

    FROM rentals r

    LEFT JOIN users u
        ON u.id = r.user_id

    ORDER BY r.id DESC
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);