'use strict';

/* =========================
   TOGGLE PASSWORD
========================= */

const togglePassword =
document.getElementById('togglePassword');

const passwordInput =
document.getElementById('password');

togglePassword.addEventListener('click', () => {

    const type =
    passwordInput.type === 'password'
    ? 'text'
    : 'password';

    passwordInput.type = type;

    togglePassword.classList.toggle('fa-eye');
    togglePassword.classList.toggle('fa-eye-slash');
});

/* =========================
   LOGIN
========================= */

const loginForm =
document.getElementById('loginForm');

loginForm.addEventListener(
    'submit',
    async (e) => {

        e.preventDefault();

        const email =
        document.getElementById('email')
        .value.trim();

        const password =
        document.getElementById('password')
        .value.trim();

        const formData =
        new FormData();

        formData.append(
            'email',
            email
        );

        formData.append(
            'password',
            password
        );

        try {

            const response =
            await fetch(
                './api/proses-login-admin.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const data =
            await response.json();
            if (data.success) {

                alert(data.message);

                    window.location.href =
                    'dashboard-admin.php';
            }

        } catch (error) {

            console.error(error);

            alert(
                'Terjadi kesalahan server'
            );

        }

    }
);