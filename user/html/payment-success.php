<?php

$rental_id = $_GET['id'] ?? 0;

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Pesanan Berhasil</title>

    <style>
        body{
            margin:0;
            font-family: Arial, sans-serif;
            background:#f5f5f5;
            display:flex;
            justify-content:center;
            align-items:center;
            height:100vh;
        }

        .toast{
            background:#fff;
            padding:30px 25px;
            border-radius:12px;
            box-shadow:0 10px 25px rgba(0,0,0,0.1);
            text-align:center;
            max-width:350px;
            animation:pop 0.3s ease;
        }

        .icon{
            font-size:50px;
            color:#22c55e;
            margin-bottom:10px;
        }

        h1{
            font-size:20px;
            margin:10px 0;
        }

        p{
            color:#666;
            margin:5px 0;
        }

        .btn{
            margin-top:15px;
            display:inline-block;
            padding:10px 15px;
            background:#2563eb;
            color:#fff;
            text-decoration:none;
            border-radius:8px;
        }

        @keyframes pop{
            from{transform:scale(0.8);opacity:0}
            to{transform:scale(1);opacity:1}
        }
    </style>

</head><body>

<div class="toast">

    <div class="icon">✔</div>

    <h1>Pesanan Berhasil Dibuat</h1>

    <p>
    Rental ID :
    <?= $rental_id ?>
    </p>

    <p>Kamu akan diarahkan ke dashboard...</p>

    <a class="btn" href="dashboard-user.php">
        Ke Dashboard
    </a>

</div>

<script>
    setTimeout(() => {
        window.location.href = "dashboard-user.php";
    }, 3000);
</script>

