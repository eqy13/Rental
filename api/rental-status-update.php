<?php

require_once '../config/db.php';

header('Content-Type: application/json');

$data = json_decode(
    file_get_contents("php://input"),
    true
);

$allowedStatus = [
    'pending',
    'disewa',
    'selesai',
    'dibatalkan'
];

if(
    !in_array(
        $data['status'],
        $allowedStatus
    )
){
    echo json_encode([
        'success' => false,
        'message' => 'Status tidak valid'
    ]);
    exit;
}

$stmt = $pdo->prepare("
    UPDATE rentals
    SET status = ?
    WHERE id = ?
");

$stmt->execute([
    $data['status'],
    $data['id']
]);

echo json_encode([
    'success' => true
]);