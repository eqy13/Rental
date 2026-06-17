<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>

    <link rel="stylesheet" href="./assets/css/pages/style-login-admin.css">

    <!-- ICON -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

    <div class="login-container">

        <!-- LOGO -->
        <div class="logo-section">
            <img src="./assets/logo/logo-rental4.png" alt="Logo Rental" class="logo">
            <h1>Admin Panel</h1>
            <p>Silakan login sebagai administrator</p>
        </div>

        <!-- FORM -->
        <form id="loginForm" class="login-form">

            <!-- EMAIL -->
            <div class="input-group">
                <i class="fa-solid fa-envelope input-icon"></i>
                <p class="input-label">Email</p>

                <input 
                    type="email" 
                    id="email" 
                    name="email" 
                    placeholder="example@gmail.com"
                    required
                >
            </div>

            <!-- PASSWORD -->
            <div class="input-group">
                <i class="fa-solid fa-lock input-icon"></i>
                <p class="input-label">Password</p>

                <input 
                    type="password" 
                    id="password" 
                    name="password"
                    placeholder="Masukkan password"
                    required
                >

                <i class="fa-solid fa-eye eye-icon" id="togglePassword"></i>
            </div>

            <!-- REMEMBER -->
            <div class="remember-section">
                <label>
                    <input type="checkbox" id="rememberMe">
                    Ingat saya
                </label>

                <a href="forgot-password-admin.php" class="forgot-link">
                    Lupa Password?
                </a>
            </div>

            <!-- LOGIN BUTTON -->
            <button type="submit" class="login-btn">
                Login
            </button>



        </form>

    </div>

    <script src="./assets/js/script-login-admin.js"></script>

</body>
</html>