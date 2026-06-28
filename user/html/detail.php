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

    <title>Detail Produk</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style-detail.css">

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

</head>

<body>

    <div class="detail-page">

        <!-- =========================
             HEADER
        ========================== -->

        <header class="detail-header glass">

            <!-- LEFT -->
            <button class="back-btn" id="backBtn">

                <i class="fa-solid fa-arrow-left"></i>

            </button>

            <!-- RIGHT -->
            <div class="header-actions">

                <button class="icon-btn" id="likeBtn">

                    <i class="fa-regular fa-heart"></i>

                </button>

                <button class="icon-btn" id="shareBtn">

                    <i class="fa-solid fa-share-nodes"></i>

                </button>

            </div>

        </header>


        <!-- =========================
            DETAIL CONTENT
        ========================= -->

        <div class="detail-content">

            <!-- =========================
                IMAGE
            ========================== -->

            <section class="detail-gallery glass">

                <!-- FOTO -->
                <div class="foto-wrapper">

                    <button
                        class="arrow left"
                        onclick="prevImage()"
                    >
                        ❮
                    </button>

                    <img
                        id="mainImage"
                        src=""
                        alt="Produk"
                    >

                    <button
                        class="arrow right"
                        onclick="nextImage()"
                    >
                        ❯
                    </button>

                </div>

                <!-- THUMB -->
                <div
                    class="thumb-list"
                    id="thumbList"
                ></div>

            </section>

        <!-- =========================
            INFO
        ========================== -->

        <section class="detail-info">

            <!-- PRODUCT -->
            <div class="product-info glass">

                <h1 id="productName"></h1>

                <div class="product-meta">

                    <p id="productCategory"></p>

                    <span></span>

                    <p id="productTag"></p>
                    

                </div>

                <h2
                    id="productPrice"
                    class="product-price"
                ></h2>

            </div>

           

            <!-- =========================
                DESCRIPTION
            ========================== -->

            <div class="description-box glass">

                <div class="card-title">

                    <i class="fa-solid fa-align-left"></i>

                    <h3>Deskripsi</h3>

                </div>

                <p id="productDescription"></p>

            </div>

            <!-- =========================
                SPECIFICATION
            ========================== -->

            <div class="spec-box glass">

                <div class="card-title">

                    <i class="fa-solid fa-list-check"></i>

                    <h3>Spesifikasi</h3>

                </div>

                <ul id="productSpecification"></ul>

            </div>

            <!-- =========================
                INCLUDE
            ========================== -->

            <div class="include-box glass">

                <div class="card-title">

                    <i class="fa-solid fa-box-open"></i>

                    <h3>Include</h3>

                </div>

                <div
                    class="include-list"
                    id="productInclude"
                ></div>

            </div>

        </section>

    </div>

    <!-- =========================
        PAYMENT BAR
    ========================= -->

    <div class="payment-bar glass">

        <!-- LEFT -->
        <div class="payment-total">

            <p>Total Pembayaran</p>

            <h2 id="paymentTotal">
                Rp0
            </h2>

        </div>

        <!-- RIGHT -->
        <button
            class="pay-btn"
            id="payBtn"
        >
            Bayar Sekarang
        </button>

    </div>

    <!-- JS -->
    <script src="../js/script-detail.js"></script>

</body>
</html>