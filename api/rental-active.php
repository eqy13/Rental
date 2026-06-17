<?php

require_once '../config/db.php';

$stmt = $pdo->query("
    SELECT
        rentals.id,
        users.nama_lengkap,
        rentals.tanggal_kembali
    FROM rentals
    JOIN users
        ON users.id = rentals.user_id
    WHERE rentals.status = 'disewa'
    ORDER BY rentals.id DESC
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);