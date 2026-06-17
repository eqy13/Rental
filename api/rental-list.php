<?php

require_once '../config/db.php';

$stmt = $pdo->query("
SELECT
    rentals.id,
    users.nama_lengkap,
    rentals.total_harga,
    rentals.status
FROM rentals
JOIN users
ON users.id = rentals.user_id
ORDER BY rentals.id ASC
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);