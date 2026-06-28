<?php

session_start();
require "../config/koneksi.php";

header("Content-Type: application/json");

if (!isset($_SESSION['user_id'])) {

    echo json_encode([
        'success' => false
    ]);

    exit;
}

$user_id = $_SESSION['user_id'];

$product_id =
$_POST['product_id']
?? 0;

if (!$product_id) {

    echo json_encode([
        'success' => false
    ]);

    exit;
}

/* CEK SUDAH LIKE? */

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

$exists = $stmt->fetch();

/* UNLIKE */

if ($exists) {

    $stmt = $pdo->prepare("
    DELETE FROM likes
    WHERE user_id = ?
    AND product_id = ?
    ");

    $stmt->execute([
        $user_id,
        $product_id
    ]);

    echo json_encode([
        'liked' => false
    ]);

    exit;
}

/* LIKE */

$stmt = $pdo->prepare("
INSERT INTO likes
(
    user_id,
    product_id
)
VALUES
(
    ?,
    ?
)
");

$stmt->execute([
    $user_id,
    $product_id
]);

echo json_encode([
    'liked' => true
]);