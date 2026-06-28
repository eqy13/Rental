<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registrasi User</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style-register.css">

    <!-- Font Awesome -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >

</head>

<body>

    <!-- TOAST -->
    <div id="toastContainer"></div>

    <div class="container">

        <div class="register-card">

            <!-- LOGO -->
            <div class="logo-section">

                <img
                    src="../assets/logo/logo-rental.png"
                    alt="Logo Rental"
                    class="logo"
                >

                <h1>Rental</h1>

                <p>
                    Silakan isi form registrasi untuk membuat akun
                </p>

            </div>

            <!-- FORM -->
            <form
                id="registerForm"
                class="register-form"
                enctype="multipart/form-data"
                autocomplete="off"
            >

                <!-- NAMA -->
                <div class="input-group">

                    <i class="fa-solid fa-user input-icon"></i>

                    <p class="input-label">
                        Nama Lengkap
                    </p>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                </div>

                <!-- EMAIL -->
                <div class="input-group">

                    <i class="fa-solid fa-envelope input-icon"></i>

                    <p class="input-label">
                        Email
                    </p>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        placeholder="example@gmail.com"
                        required
                    >

                </div>

                <!-- PHONE -->
                <div class="input-group">

                    <i class="fa-solid fa-phone input-icon"></i>

                    <p class="input-label">
                        Nomor Telepon
                    </p>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        placeholder="081234567890"
                        pattern="[0-9]{10,15}"
                        required
                    >

                </div>

                <!-- ALAMAT -->
                <div class="input-group">

                    <i class="fa-solid fa-location-dot input-icon"></i>

                    <p class="input-label">
                        Alamat
                    </p>

                    <input
                        type="text"
                        id="address"
                        name="address"
                        placeholder="Masukkan alamat lengkap"
                        required
                    >

                </div>

                <!-- PASSWORD -->
                <div class="input-group">

                    <i class="fa-solid fa-lock input-icon"></i>

                    <p class="input-label">
                        Password
                    </p>

                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Minimal 8 karakter"
                        required
                    >

                    <i
                        class="fa-solid fa-eye eye-icon toggle-password"
                        data-target="password"
                    ></i>

                </div>

                <!-- PASSWORD STRENGTH -->
                <div class="password-strength">

                    <div
                        id="strengthBar"
                        class="strength-bar"
                    ></div>

                </div>

                <p id="strengthText"></p>

                <!-- CONFIRM PASSWORD -->
                <div class="input-group">

                    <i class="fa-solid fa-lock input-icon"></i>

                    <p class="input-label">
                        Konfirmasi Password
                    </p>

                    <input
                        type="password"
                        id="confirmPassword"
                        name="confirmPassword"
                        placeholder="Konfirmasi password"
                        required
                    >

                    <i
                        class="fa-solid fa-eye eye-icon toggle-password"
                        data-target="confirmPassword"
                    ></i>

                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="register-btn"
                    id="registerBtn"
                >

                    <img
                        src="../assets/images/regis.png"
                        alt="Register"
                        class="button-icon"
                    >

                    <span id="registerText">
                        Daftar Sekarang
                    </span>

                </button>

                <!-- DIVIDER -->
                <div class="divider">

                    <span>
                        Atau daftar dengan
                    </span>

                </div>

                <!-- GOOGLE -->
                <button
                    type="button"
                    class="google-btn"
                >

                    <img
                        src="../assets/images/google.jpg"
                        alt="Google"
                        class="google-icon"
                    >

                    <span>
                        Daftar dengan Google
                    </span>

                </button>

                <!-- LOGIN -->
                <p class="login-text">

                    Sudah punya akun?

                    <a href="login-user.php">
                        Masuk sekarang
                    </a>

                </p>

            </form>

        </div>

    </div>

    <!-- JS -->
    <script src="../js/registrasi-user.js"></script>

</body>

</html>