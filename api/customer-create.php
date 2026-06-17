<?php

header('Content-Type: application/json');

require_once '../config/db.php';

try{

    $data = json_decode(
        file_get_contents('php://input'),
        true
    );

    $nama =
    trim($data['nama_lengkap']);

    $email =
    trim($data['email']);

    $no_hp =
    trim($data['no_hp']);

    $password =
    password_hash(
        $data['password'],
        PASSWORD_DEFAULT
    );

    $cek = $pdo->prepare("
        SELECT id
        FROM users
        WHERE email = ?
    ");

    $cek->execute([
        $email
    ]);

    if($cek->fetch()){

        echo json_encode([
            'success' => false,
            'message' => 'Email sudah digunakan'
        ]);

        exit;
    }

$stmt = $pdo->prepare("
    INSERT INTO users
    (
        nama_lengkap,
        email,
        nomor_hp,
        password,
        role,
        status
    )
    VALUES
    (
        ?, ?, ?, ?, ?, ?
    )
");

$stmt->execute([
    $nama,
    $email,
    $no_hp,
    $password,
    'user',
    'aktif'
]);

    echo json_encode([
        'success' => true
    ]);

}
catch(Exception $e){

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}