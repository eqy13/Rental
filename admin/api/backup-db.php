<?php

$date = date('Y-m-d_H-i-s');

$filename = "backup_$date.sql";

$filepath = __DIR__ . "/../backups/$filename";


$mysqldump =
'"C:\\laragon\\bin\\mysql\\mysql-8.0.30-winx64\\bin\\mysqldump.exe"';

$command =
$mysqldump .
' -u root rental > "' .
$filepath .
'" 2>&1';

$output = [];
$return = 0;

exec($command, $output, $return);

echo json_encode([
    'success' => $return === 0,
    'return_code' => $return,
    'output' => $output,
    'file' => $filename
]);