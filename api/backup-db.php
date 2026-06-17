<?php

$date =
date('Y-m-d_H-i-s');

$filename =
"backup_$date.sql";

$filepath =
"../backups/$filename";

$command =
"mysqldump -u root rental_db > $filepath";

exec($command);

echo json_encode([
    'success' => true,
    'file' => $filename
]);