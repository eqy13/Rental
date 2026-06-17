<?php

header('Content-Type: application/json');

require '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    echo json_encode([
        'success' => false,
        'message' => 'Method tidak diizinkan'
    ]);

    exit;
}

/* ====================================
   AMBIL DATA
==================================== */

$nama_lengkap = trim($_POST['name'] ?? '');

$email = trim($_POST['email'] ?? '');

$nomor_hp = trim($_POST['phone'] ?? '');

$alamat = trim($_POST['address'] ?? '');

$password = trim($_POST['password'] ?? '');

/* ====================================
   VALIDASI
==================================== */

if (
    empty($nama_lengkap) ||
    empty($email) ||
    empty($nomor_hp) ||
    empty($alamat) ||
    empty($password)
) {

    echo json_encode([
        'success' => false,
        'message' => 'Semua field wajib diisi'
    ]);

    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

    echo json_encode([
        'success' => false,
        'message' => 'Format email tidak valid'
    ]);

    exit;
}

if (!preg_match('/^[0-9]{10,15}$/', $nomor_hp)) {

    echo json_encode([
        'success' => false,
        'message' => 'Nomor HP tidak valid'
    ]);

    exit;
}

if (strlen($password) < 8) {

    echo json_encode([
        'success' => false,
        'message' => 'Password minimal 8 karakter'
    ]);

    exit;
}

/* ====================================
   CEK EMAIL
==================================== */

$cekEmail = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE email = ?"
);

$cekEmail->execute([$email]);

if ($cekEmail->rowCount() > 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Email sudah digunakan'
    ]);

    exit;
}

/* ====================================
   CEK NOMOR HP
==================================== */

$cekPhone = $pdo->prepare(
    "SELECT id
     FROM users
     WHERE nomor_hp = ?"
);

$cekPhone->execute([$nomor_hp]);

if ($cekPhone->rowCount() > 0) {

    echo json_encode([
        'success' => false,
        'message' => 'Nomor HP sudah digunakan'
    ]);

    exit;
}

/* ====================================
   HASH PASSWORD
==================================== */

$passwordHash = password_hash(
    $password,
    PASSWORD_DEFAULT
);

/* ====================================
   INSERT USER
==================================== */

$stmt = $pdo->prepare(
    "INSERT INTO users
    (
        nama_lengkap,
        email,
        nomor_hp,
        alamat,
        password,
        foto_profil,
        role,
        status,
        created_at,
        updated_at
    )
    VALUES
    (
        ?,
        ?,
        ?,
        ?,
        ?,
        'default-user.png',
        'user',
        'aktif',
        NOW(),
        NOW()
    )"
);

$success = $stmt->execute([
    $nama_lengkap,
    $email,
    $nomor_hp,
    $alamat,
    $passwordHash
]);

/* ====================================
   RESPONSE
==================================== */

if ($success) {

    echo json_encode([
        'success' => true,
        'message' => 'Registrasi berhasil'
    ]);

} else {

    echo json_encode([
        'success' => false,
        'message' => 'Registrasi gagal'
    ]);

}