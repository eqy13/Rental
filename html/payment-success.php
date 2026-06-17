<?php

$rental_id = $_GET['id'] ?? 0;

?>

<!DOCTYPE html>
<html>
<head>
    <title>Berhasil</title>
</head>
<body>

<h1>Pesanan Berhasil Dibuat</h1>

<p>
Rental ID :
<?= $rental_id ?>
</p>

<a href="dashboard-user.php">
Kembali ke Dashboard
</a>

</body>
</html>