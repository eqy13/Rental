<?php

session_start();

require "../config/koneksi.php";

/* =========================
   CEK LOGIN
========================= */

if (!isset($_SESSION["user_id"])) {

    header("Location: ../html/login-user.php");
    exit;
}

$id = $_SESSION["user_id"];

/* =========================
   AMBIL DATA
========================= */

$passwordLama = $_POST["password_lama"] ?? "";
$passwordBaru = $_POST["password_baru"] ?? "";
$konfirmasi = $_POST["konfirmasi_password"] ?? "";

/* =========================
   VALIDASI
========================= */

if (

    empty($passwordLama) ||
    empty($passwordBaru) ||
    empty($konfirmasi)

) {

    header("Location: ../html/user.php?password=kosong");
    exit;
}

if ($passwordBaru != $konfirmasi) {

    header("Location: ../html/user.php?password=beda");
    exit;
}

if (strlen($passwordBaru) < 8) {

    header("Location: ../html/user.php?password=pendek");
    exit;
}

/* =========================
   AMBIL PASSWORD DATABASE
========================= */

$stmt = $pdo->prepare("

SELECT password
FROM users
WHERE id=?

");

$stmt->execute([$id]);

$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    header("Location: ../html/user.php?password=user");
    exit;
}

/* =========================
   CEK PASSWORD LAMA
========================= */

if (

    !password_verify(
        $passwordLama,
        $user["password"]
    )

) {

    header("Location: ../html/user.php?password=salah");
    exit;
}

/* =========================
   HASH PASSWORD BARU
========================= */

$passwordHash = password_hash(

    $passwordBaru,

    PASSWORD_DEFAULT

);

/* =========================
   UPDATE DATABASE
========================= */

$update = $pdo->prepare("

UPDATE users

SET

password=?,
updated_at=NOW()

WHERE id=?

");

$sukses = $update->execute([

    $passwordHash,
    $id

]);

if ($sukses) {

    header("Location: ../html/user.php?password=success");
    exit;

}

header("Location: ../html/user.php?password=gagal");
exit;

?>