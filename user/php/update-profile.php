```php
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
   AMBIL DATA FORM
========================= */

$nama   = trim($_POST["nama_lengkap"] ?? "");
$email  = trim($_POST["email"] ?? "");
$phone  = trim($_POST["nomor_hp"] ?? "");
$alamat = trim($_POST["alamat"] ?? "");

/* =========================
   VALIDASI
========================= */

if (
    empty($nama) ||
    empty($email) ||
    empty($phone)
) {

    header("Location: ../html/user.php?status=kosong");
    exit;
}

/* =========================
   CEK EMAIL DUPLIKAT
========================= */

$cek = $pdo->prepare("
SELECT id
FROM users
WHERE email=?
AND id<>?
");

$cek->execute([
    $email,
    $id
]);

if ($cek->rowCount() > 0) {

    header("Location: ../html/user.php?status=email");
    exit;
}

/* =========================
   AMBIL DATA USER LAMA
========================= */

$getUser = $pdo->prepare("
SELECT *
FROM users
WHERE id=?
");

$getUser->execute([$id]);

$user = $getUser->fetch(PDO::FETCH_ASSOC);

if (!$user) {

    header("Location: ../html/user.php?status=gagal");
    exit;
}

/* =========================
   FOTO DEFAULT
========================= */

$fotoBaru = $user["foto_profil"];

/* =========================
   LOKASI FOLDER UPLOAD
========================= */

$folder = dirname(__DIR__, 2) . "/uploads/user/";

if ($folder === false) {

    die("Folder uploads/user tidak ditemukan.");

}

$folder .= DIRECTORY_SEPARATOR;

/* =========================
   UPLOAD FOTO BARU
========================= */

if (

    isset($_FILES["foto_profil"]) &&
    $_FILES["foto_profil"]["error"] == 0

) {

    $ext = strtolower(

        pathinfo(
            $_FILES["foto_profil"]["name"],
            PATHINFO_EXTENSION
        )

    );

    $allowed = [
        "jpg",
        "jpeg",
        "png",
        "webp"
    ];

    if (!in_array($ext, $allowed)) {

        header("Location: ../html/user.php?status=format");
        exit;
    }

    $fotoBaru =
        time() .
        "_" .
        uniqid() .
        "." .
        $ext;

    $tujuan =
        $folder .
        $fotoBaru;

    if (

        move_uploaded_file(
            $_FILES["foto_profil"]["tmp_name"],
            $tujuan
        )

    ) {

        if (

            !empty($user["foto_profil"]) &&
            $user["foto_profil"] != "default-user.png"

        ) {

            $fotoLama =
                $folder .
                $user["foto_profil"];

            if (file_exists($fotoLama)) {

                unlink($fotoLama);

            }

        }

    } else {

        header("Location: ../html/user.php?status=upload");
        exit;

    }

}

/* =========================
   UPDATE DATABASE
========================= */

$stmt = $pdo->prepare("

UPDATE users
SET

nama_lengkap=?,
email=?,
nomor_hp=?,
alamat=?,
foto_profil=?,
updated_at=NOW()

WHERE id=?

");

$sukses = $stmt->execute([

    $nama,
    $email,
    $phone,
    $alamat,
    $fotoBaru,
    $id

]);

/* =========================
   UPDATE SESSION
========================= */

if ($sukses) {

    $_SESSION["nama_lengkap"] = $nama;
    $_SESSION["foto_profil"] = $fotoBaru;

    header(
        "Location: ../html/user.php?status=success"
    );
    exit;

}

header(
    "Location: ../html/user.php?status=gagal"
);
exit;

?>
```
