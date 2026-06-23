<?php

session_start();

header('Content-Type: application/json');

require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);

    exit;
}

$email = trim($_POST['email'] ?? '');
$password = trim($_POST['password'] ?? '');

if (
    empty($email) ||
    empty($password)
) {

    echo json_encode([
        'success' => false,
        'message' => 'Email dan password wajib diisi'
    ]);

    exit;
}

$stmt = $pdo->prepare("
    SELECT *
    FROM admins
    WHERE email = ?
    LIMIT 1
");

$stmt->execute([
    $email
]);

$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {

    echo json_encode([
        'success' => false,
        'message' => 'Email tidak ditemukan'
    ]);

    exit;
}

if (
    !password_verify(
        $password,
        $admin['password']
    )
) {

    echo json_encode([
        'success' => false,
        'message' => 'Password salah'
    ]);

    exit;
}

session_regenerate_id(true);

$_SESSION['admin_id'] =
$admin['id'];

$_SESSION['nama_lengkap'] =
$admin['nama_lengkap'];

$_SESSION['email'] =
$admin['email'];

$_SESSION['foto'] =
$admin['foto'];

/*
==========================
UPDATE LAST LOGIN
==========================
*/

$stmt = $pdo->prepare("
    UPDATE admins
    SET last_login = NOW()
    WHERE id = ?
");

$stmt->execute([
    $admin['id']
]);

echo json_encode([
    'success' => true,
    'message' => 'Login berhasil'
]);