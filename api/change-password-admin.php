<?php

require_once '../config/db.php';

$data =
json_decode(
file_get_contents(
"php://input"
),
true
);

$hash =
password_hash(
$data['password'],
PASSWORD_DEFAULT
);

$stmt =
$pdo->prepare("
UPDATE admins
SET password=?
LIMIT 1
");

$stmt->execute([
$hash
]);

echo json_encode([
'success'=>true
]);