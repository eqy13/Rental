<?php

header('Content-Type: application/json');

require_once '../config/db.php';

$users =
$pdo->query("
    SELECT COUNT(*) total
    FROM users
")->fetch();

$products =
$pdo->query("
    SELECT COUNT(*) total
    FROM products
")->fetch();

$rentals =
$pdo->query("
    SELECT COUNT(*) total
    FROM rentals
")->fetch();

$categories =
$pdo->query("
    SELECT COUNT(*)
    FROM categories
")->fetchColumn();

$revenue = $pdo->query("
    SELECT
        COALESCE(
            (
                SELECT SUM(total_harga)
                FROM rentals
                WHERE status = 'selesai'
            ),
            0
        )
        +
        COALESCE(
            (
                SELECT SUM(denda)
                FROM returns
            ),
            0
        )
        AS total
")->fetch();

echo json_encode([
    'users' => $users['total'],
    'products' => $products['total'],
    'rentals' => $rentals['total'],
    'categories' => $categories,
    'revenue' => $revenue['total'] ?? 0
]);