<?php

session_start();

if(
    !isset($_SESSION['user_id'])
){

    header(
        'Location: login-user.php'
    );

    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Notifikasi</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style-notifikasi.css">

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

</head>

<body>

    <div class="notification-page">

        <!-- HEADER -->
        <header class="notification-header">

            <div class="header-left">

                <a
                    href="dashboard-user.php"
                    class="back-btn"
                >
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div>

                    <h1>Notifikasi</h1>

                    <p>
                        Semua update rental dan aktivitas akun Anda
                    </p>

                </div>

            </div>

            <!-- ACTION -->
            <button class="read-all-btn">

                <i class="fa-solid fa-check-double"></i>

                Tandai Dibaca

            </button>

        </header>

        <!-- FILTER -->
        <div class="notification-filter">

            <button class="filter-btn active">
                Semua
            </button>

            <button class="filter-btn">
                Rental
            </button>

            <button class="filter-btn">
                Pembayaran
            </button>

            <button class="filter-btn">
                Promo
            </button>

        </div>

        <!-- LIST -->
        <div class="notification-list">

            <!-- ITEM -->
            <div class="notification-card unread">

                <div class="notif-icon rental">

                    <i class="fa-solid fa-campground"></i>

                </div>

                <div class="notif-content">

                    <div class="notif-top">

                        <h3>
                            Rental Berhasil
                        </h3>

                        <span>
                            2 menit lalu
                        </span>

                    </div>

                    <p>
                        Pesanan Carrier Eiger 60L
                        berhasil dikonfirmasi.
                    </p>

                    <div class="notif-actions">

                        <button class="notif-btn">
                            Lihat Pesanan
                        </button>

                    </div>

                </div>

                <div class="notif-dot"></div>

            </div>

            <!-- ITEM -->
            <div class="notification-card unread">

                <div class="notif-icon warning">

                    <i class="fa-solid fa-clock"></i>

                </div>

                <div class="notif-content">

                    <div class="notif-top">

                        <h3>
                            Rental Akan Berakhir
                        </h3>

                        <span>
                            1 jam lalu
                        </span>

                    </div>

                    <p>
                        Rental Canon DSLR Kit akan
                        berakhir dalam 1 hari.
                    </p>

                    <div class="notif-actions">

                        <button class="notif-btn">
                            Perpanjang Rental
                        </button>

                    </div>

                </div>

                <div class="notif-dot"></div>

            </div>

            <!-- ITEM -->
            <div class="notification-card">

                <div class="notif-icon payment">

                    <i class="fa-solid fa-wallet"></i>

                </div>

                <div class="notif-content">

                    <div class="notif-top">

                        <h3>
                            Pembayaran Berhasil
                        </h3>

                        <span>
                            Kemarin
                        </span>

                    </div>

                    <p>
                        Pembayaran sebesar
                        Rp 420.000 berhasil diterima.
                    </p>

                </div>

            </div>

            <!-- ITEM -->
            <div class="notification-card">

                <div class="notif-icon promo">

                    <i class="fa-solid fa-gift"></i>

                </div>

                <div class="notif-content">

                    <div class="notif-top">

                        <h3>
                            Promo Baru
                        </h3>

                        <span>
                            2 hari lalu
                        </span>

                    </div>

                    <p>
                        Diskon 20% untuk semua
                        perlengkapan camping minggu ini.
                    </p>

                </div>

            </div>

        </div>

    </div>

    <script src="../js/notifikasi.js"></script>

</body>
</html>