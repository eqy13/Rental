<?php

function addLog(
$pdo,
$text
){

$stmt =
$pdo->prepare("
INSERT INTO activity_logs
(
aktivitas
)
VALUES
(?)
");

$stmt->execute([
$text
]);

}