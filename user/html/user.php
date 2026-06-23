<?php

session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login-user.php');
    exit;
}

require '../config/koneksi.php';

/* AMBIL DATA USER DARI DB (SOURCE UTAMA) */
$stmt = $pdo->prepare("
    SELECT *
    FROM users
    WHERE id = ?
    LIMIT 1
");

$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    session_destroy();
    header('Location: login-user.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $nama = trim($_POST['nama_lengkap']);
    $email = trim($_POST['email']);
    $hp = trim($_POST['nomor_hp']);
    $alamat = trim($_POST['alamat']);

    /* VALIDASI SEDERHANA */
    if (empty($nama) || empty($email) || empty($hp)) {
        die("Data wajib diisi");
    }

    /* CEK EMAIL DIPAKAI USER LAIN */
    $cek = $pdo->prepare("
        SELECT id FROM users
        WHERE email = ? AND id != ?
    ");

    $cek->execute([$email, $_SESSION['user_id']]);

    if ($cek->rowCount() > 0) {
        die("Email sudah digunakan");
    }

    /* UPDATE DATA */
    $update = $pdo->prepare("
        UPDATE users
        SET
            nama_lengkap = ?,
            email = ?,
            nomor_hp = ?,
            alamat = ?,
            updated_at = NOW()
        WHERE id = ?
    ");

    $update->execute([
        $nama,
        $email,
        $hp,
        $alamat,
        $_SESSION['user_id']
    ]);

    /* UPDATE SESSION */
    $_SESSION['nama_lengkap'] = $nama;

    header("Location: user.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>User Profile</title>

    <!-- CSS -->
    <link rel="stylesheet" href="../css/style-user.css">

    <!-- FONT AWESOME -->
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >
</head>

<body>

    <div class="profile-page">

        <!-- HEADER -->
        <header class="profile-header">

            <div class="header-left">

                <a href="dashboard-user.php" class="back-btn">
                    <i class="fa-solid fa-arrow-left"></i>
                </a>

                <div>
                    <h1>Profil Saya</h1>
                    <p>
                        Kelola informasi dan pengaturan akun Anda
                    </p>
                </div>

            </div>

        </header>

        <!-- PROFILE CARD -->
        <section class="profile-card glass">

            <form
                action="../php/update-profile.php"
                method="POST"
                enctype="multipart/form-data"
            >

                <div class="profile-top">

                    <!-- FOTO -->
                    <div class="profile-image-wrapper">

                        <img
                            src="<?=
                                !empty($user['foto_profil'])
                                ? '../../uploads/user/' . htmlspecialchars($user['foto_profil'])
                                : '../../uploads/user/default-user.png';
                            ?>"
                            alt="Profile"
                            id="profileImage"
                        >

                        <label
                            for="uploadPhoto"
                            class="change-photo-btn"
                        >
                            <i class="fa-solid fa-camera"></i>
                        </label>

                        <input
                            type="file"
                            id="uploadPhoto"
                            name="foto_profil"
                            accept="image/*"
                            hidden
                        >

                    </div>

                    <!-- USER INFO -->
                    <div class="profile-user-info">

                        <h2 id="displayName">
                            <?= htmlspecialchars($user['nama_lengkap']); ?>
                        </h2>

                        <p id="displayEmail">
                            <?= htmlspecialchars($user['email']); ?>
                        </p>

                    </div>

                </div>

                <!-- FORM -->
                <div class="profile-form">

                    <div class="input-group">

                        <label>Nama Lengkap</label>

                        <input
                            type="text"
                            id="nameInput"
                            name="nama_lengkap"
                            value="<?= htmlspecialchars($user['nama_lengkap']); ?>"
                            disabled
                        >

                    </div>

                    <div class="input-group">

                        <label>Email</label>

                        <input
                            type="email"
                            id="emailInput"
                            name="email"
                            value="<?= htmlspecialchars($user['email']); ?>"
                            disabled
                        >

                    </div>

                    <div class="input-group">

                        <label>Nomor HP</label>

                        <input
                            type="text"
                            id="phoneInput"
                            name="nomor_hp"
                            value="<?= htmlspecialchars($user['nomor_hp']); ?>"
                            disabled
                        >

                    </div>

                    <div class="input-group">

                        <label>Alamat</label>

                        <textarea
                            id="addressInput"
                            name="alamat"
                            disabled
                        ><?= htmlspecialchars($user['alamat'] ?? ''); ?></textarea>

                    </div>

                    <!-- ACTION -->
                    <div class="profile-actions">

                        <button
                            type="button"
                            class="edit-btn"
                            id="editProfileBtn"
                        >
                            <i class="fa-solid fa-pen"></i>
                            Edit Profil
                        </button>

                        <div
                            class="save-actions"
                            id="saveActions"
                        >

                            <button
                                type="button"
                                class="cancel-btn"
                                id="cancelBtn"
                            >
                                Batal
                            </button>

                            <button
                                type="submit"
                                class="save-btn"
                                id="saveBtn"
                            >
                                Simpan
                            </button>

                        </div>

                    </div>

                </div>

            </form>

        </section>

        <!-- SECURITY -->
        <section class="settings-card glass">

            <div class="card-title">

                <i class="fa-solid fa-shield-halved"></i>

                <h2>Keamanan</h2>

            </div>

            <div class="security-item">

                <div>

                    <h3>Ganti Password</h3>

                    <p>
                        Gunakan password yang kuat agar akun lebih aman
                    </p>

                </div>

                <button
                    type="button"
                    class="security-btn"
                    id="changePasswordBtn"
                >
                    Ubah
                </button>

            </div>

            <!-- PASSWORD FORM -->

            <form
                action="../php/change-password.php"
                method="POST"
                class="password-form"
                id="passwordForm"
            >

                <div class="input-group">

                    <label>Password Lama</label>

                    <input
                        type="password"
                        name="password_lama"
                        placeholder="Masukkan password lama"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Password Baru</label>

                    <input
                        type="password"
                        name="password_baru"
                        placeholder="Masukkan password baru"
                        required
                    >

                </div>

                <div class="input-group">

                    <label>Konfirmasi Password</label>

                    <input
                        type="password"
                        name="konfirmasi_password"
                        placeholder="Ulangi password baru"
                        required
                    >

                </div>

                <button
                    type="submit"
                    class="save-btn"
                >
                    Simpan Password
                </button>

            </form>

        </section>

         <!-- =========================

        <!-- PREFERENCES -->
        <section class="settings-card glass">

            <div class="card-title">
                <i class="fa-solid fa-sliders"></i>
                <h2>Preferensi</h2>
            </div>

            <!-- DARK MODE -->
            <div class="preference-item">

                <div>
                    <h3>Dark Mode</h3>

                    <p>
                        Aktifkan mode gelap untuk tampilan lebih nyaman
                    </p>
                </div>

                <label class="switch">

                    <input type="checkbox" id="darkModeToggle">

                    <span class="slider"></span>

                </label>

            </div>

            <!-- NOTIFICATION -->
            <div class="preference-item">

                <div>
                    <h3>Notifikasi</h3>

                    <p>
                        Dapatkan notifikasi promo, pengingat rental,
                        dan update terbaru
                    </p>
                </div>

                <label class="switch">

                    <input type="checkbox" checked>

                    <span class="slider"></span>

                </label>

            </div>

        </section>

        <!-- =========================
     PESANAN SAYA
========================= -->

<section class="settings-card glass">

    <div class="card-title">

        <i class="fa-solid fa-box"></i>

        <h2>Pesanan Saya</h2>

    </div>

    <div class="menu-list">

        <!-- PESANAN -->
        <a
            href="pesanan.php"
            class="menu-item"
        >

            <div class="menu-left">

                <div class="menu-icon">

                    <i class="fa-solid fa-receipt"></i>

                </div>

                <div>

                    <h3>Riwayat Pesanan</h3>

                    <p>
                        Lihat status dan detail
                        semua pesanan rental Anda
                    </p>

                </div>

            </div>

            <i class="fa-solid fa-chevron-right"></i>

        </a>

    </div>

</section>


     <!-- FAVORITE / LIKES -->


    <section class="settings-card glass">

        <div class="card-title">

            <i class="fa-solid fa-heart"></i>

            <h2>Favorite</h2>

        </div>

        <div class="menu-list">

            <!-- LIKES -->
            <a
                href="likes.php"
                class="menu-item"
            >

                <div class="menu-left">

                    <div class="menu-icon favorite-icon">

                        <i class="fa-solid fa-heart"></i>

                    </div>

                    <div>

                        <h3>Produk Disukai</h3>

                        <p>
                            Kelola produk yang Anda
                            simpan dan sukai
                        </p>

                    </div>

                </div>

                <i class="fa-solid fa-chevron-right"></i>

            </a>

        </div>

    </section>

        <!-- HELP -->
        <section class="settings-card glass">

            <div class="card-title">
                <i class="fa-solid fa-circle-question"></i>
                <h2>Bantuan & Dukungan</h2>
            </div>

            <a href="#" class="help-item">
                <span>Pusat Bantuan</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>

            <a href="#" class="help-item">
                <span>Syarat & Ketentuan</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>

            <a href="#" class="help-item">
                <span>Kebijakan Privasi</span>
                <i class="fa-solid fa-chevron-right"></i>
            </a>

        </section>

        <!-- LOGOUT -->
        <a href="../php/logout.php" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </a>

    </div>

    <!-- JS -->
    <script src="../js/user.js"></script>

</body>
</html>
