<?php

require_once '../config/db.php';

$admin =
$pdo->query("
SELECT *
FROM admins
LIMIT 1
")->fetch();

$foto =
$admin['foto'];

if(
isset($_FILES['foto'])
&&
$_FILES['foto']['error']==0
){

$foto =
time().
'_'.
$_FILES['foto']['name'];

move_uploaded_file(
$_FILES['foto']['tmp_name'],
'../../uploads/admins/'.$foto
);

}

$stmt =
$pdo->prepare("
UPDATE admins
SET
nama_lengkap=?,
email=?,
foto=?
WHERE id=?
");

$stmt->execute([

$_POST['nama_lengkap'],
$_POST['email'],
$foto,
$admin['id']

]);

echo json_encode([
'success'=>true
]);