<?php

session_start();

header('Content-Type: application/json');

require '../config/koneksi.php';

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

$stmt = $pdo->prepare(
    "SELECT *
     FROM users
     WHERE email = ?
     LIMIT 1"
);

$stmt->execute([$email]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    echo json_encode([
        'success' => false,
        'message' => 'Email tidak ditemukan'
    ]);

    exit;
}

if ($user['status'] !== 'aktif') {

    echo json_encode([
        'success' => false,
        'message' => 'Akun tidak aktif'
    ]);

    exit;
}

if (
    !password_verify(
        $password,
        $user['password']
    )
) {

    echo json_encode([
        'success' => false,
        'message' => 'Password salah'
    ]);

    exit;
}

session_regenerate_id(true);

$_SESSION['user_id'] = $user['id'];

$_SESSION['nama_lengkap'] =
$user['nama_lengkap'];

$_SESSION['email'] =
$user['email'];

$_SESSION['role'] =
$user['role'];

$_SESSION['foto_profil'] =
$user['foto_profil'];

echo json_encode([
    'success' => true,
    'message' => 'Login berhasil',
    'role' => $user['role']
]);