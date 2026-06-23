<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

if(!isset($_SESSION['user_id'])){
    echo json_encode([
        'liked' => false
    ]);
    exit;
}

$user_id = $_SESSION['user_id'];
$product_id = $_GET['product_id'] ?? 0;

$stmt = $pdo->prepare("
SELECT id
FROM likes
WHERE user_id = ?
AND product_id = ?
");

$stmt->execute([
    $user_id,
    $product_id
]);

echo json_encode([
    'liked' => (bool)$stmt->fetch()
]);