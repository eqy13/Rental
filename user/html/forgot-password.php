<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Reset Password</title>

    <!-- CSS -->
    <link
        rel="stylesheet"
        href="../css/style-forgot.css"
    >

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

</head>

<body>

    <div class="container">

        <div class="forgot-card">

            <!-- LOGO -->
            <div class="logo-section">

                <img
                    src="../assets/logo/logo-rental.png"
                    alt="Logo Rental"
                    class="logo"
                >

                <h1>Rental</h1>

                <p>
                    Silakan masukkan email untuk
                    mereset password Anda
                </p>

            </div>

            <!-- FORM -->
            <form
                id="resetPasswordForm"
                class="forgot-form"
            >

                <!-- EMAIL -->
                <div class="input-group">

                    <i class="fa-solid fa-envelope input-icon"></i>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@gmail.com"
                        autocomplete="email"
                        required
                    >

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="submit-btn"
                >
                    Kirim Link Reset Password
                </button>

                <!-- BACK -->
                <p class="back-login">

                    <a href="login-user.php">

                        <img
                            src="../assets/icons/panah.png"
                            alt="Kembali"
                        >

                        <span>
                            Kembali ke Login
                        </span>

                    </a>

                </p>

            </form>

        </div>

    </div>

    <!-- JS -->
    <script src="../js/forgot-user.js"></script>

</body>
</html>