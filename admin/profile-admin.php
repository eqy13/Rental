<?php

session_start();

if (!isset($_SESSION['admin_id'])) {

    header("Location: login-admin.php");
    exit;

}

require_once './config/db.php';

$admin =
$pdo->query("
SELECT *
FROM admins
LIMIT 1
")->fetch();
?>

<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Edit Profil Admin</title>

<link rel="stylesheet"
href="./assets/css/pages/style-settings-admin.css">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="main">

<div class="glass-card"
style="max-width:700px;margin:auto;">

<h2>Edit Profil</h2>

<form
id="profileForm"
enctype="multipart/form-data">

<div class="form-group">

<label>Nama Lengkap</label>

<input
type="text"
name="nama_lengkap"
value="<?= htmlspecialchars($admin['nama_lengkap']) ?>"
required>

</div>

<div class="form-group">

<label>Email</label>

<input
type="email"
name="email"
value="<?= htmlspecialchars($admin['email']) ?>"
required>

</div>

<div class="form-group">

<label>Foto Profil</label>

<input
type="file"
name="foto">

</div>

<button
type="submit"
class="primary-btn">

Simpan Perubahan

</button>

</form>

</div>

</div>

<script>

document
.getElementById(
'profileForm'
)
.addEventListener(
'submit',
async e=>{

e.preventDefault();

const formData =
new FormData(e.target);

const response =
await fetch(
'./api/admin-profile-update.php',
{
method:'POST',
body:formData
}
);

const result =
await response.json();

if(result.success){

alert(
'Profil berhasil diupdate'
);

                    
 window.location.href =
 "settings-admin.php";

}

}
);

</script>

</body>
</html>