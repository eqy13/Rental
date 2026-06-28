<?php

require "../config/koneksi.php";

header("Content-Type: application/json");

$stmt = $pdo->query("
SELECT *
FROM categories
ORDER BY nama_kategori
");

echo json_encode(
    $stmt->fetchAll(PDO::FETCH_ASSOC)
);