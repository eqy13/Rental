'use strict';

/* ====================================
   ELEMENT
==================================== */

const registerForm =
document.getElementById('registerForm');

const passwordInput =
document.getElementById('password');

const confirmPasswordInput =
document.getElementById('confirmPassword');

const strengthBar =
document.getElementById('strengthBar');

const strengthText =
document.getElementById('strengthText');

const registerBtn =
document.getElementById('registerBtn');

const registerText =
document.getElementById('registerText');

const togglePasswords =
document.querySelectorAll('.toggle-password');

/* ====================================
   TOGGLE PASSWORD
==================================== */

togglePasswords.forEach(icon => {

    icon.addEventListener('click', () => {

        const targetId =
        icon.dataset.target;

        const input =
        document.getElementById(targetId);

        if(input.type === 'password'){

            input.type = 'text';

            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');

        }else{

            input.type = 'password';

            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');

        }

    });

});

/* ====================================
   PASSWORD STRENGTH
==================================== */

passwordInput.addEventListener(
    'input',
    () => {

        const password =
        passwordInput.value;

        let score = 0;

        if(password.length >= 8){
            score++;
        }

        if(/[A-Z]/.test(password)){
            score++;
        }

        if(/[0-9]/.test(password)){
            score++;
        }

        if(/[!@#$%^&*]/.test(password)){
            score++;
        }

        switch(score){

            case 1:

                strengthBar.style.width = '25%';
                strengthBar.style.background = '#ef4444';

                strengthText.textContent =
                'Password Lemah';

                break;

            case 2:

                strengthBar.style.width = '50%';
                strengthBar.style.background = '#f59e0b';

                strengthText.textContent =
                'Password Sedang';

                break;

            case 3:

                strengthBar.style.width = '75%';
                strengthBar.style.background = '#3b82f6';

                strengthText.textContent =
                'Password Kuat';

                break;

            case 4:

                strengthBar.style.width = '100%';
                strengthBar.style.background = '#10b981';

                strengthText.textContent =
                'Password Sangat Kuat';

                break;

            default:

                strengthBar.style.width = '0%';

                strengthText.textContent =
                '';

        }

    }
);

/* ====================================
   TOAST
==================================== */

function showToast(
    message,
    type = 'success'
){

    const container =
    document.getElementById(
        'toastContainer'
    );

    const toast =
    document.createElement('div');

    toast.className =
    `toast ${type}`;

    toast.textContent =
    message;

    container.appendChild(
        toast
    );

    setTimeout(() => {

        toast.remove();

    }, 3000);

}

/* ====================================
   VALIDASI EMAIL
==================================== */

function isValidEmail(email){

    const regex =
    /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    return regex.test(email);

}

/* ====================================
   VALIDASI PHONE
==================================== */

function isValidPhone(phone){

    const regex =
    /^[0-9]{10,15}$/;

    return regex.test(phone);

}

/* ====================================
   REGISTER
==================================== */

registerForm.addEventListener(
    'submit',
    async (e) => {

        e.preventDefault();

        const name =
        document.getElementById('name')
        .value.trim();

        const email =
        document.getElementById('email')
        .value.trim();

        const phone =
        document.getElementById('phone')
        .value.trim();

        const address =
        document.getElementById('address')
        .value.trim();

        const password =
        passwordInput.value;

        const confirmPassword =
        confirmPasswordInput.value;


        /* VALIDASI */

        if(!name){

            showToast(
                'Nama wajib diisi',
                'error'
            );

            return;
        }

        if(!isValidEmail(email)){

            showToast(
                'Format email tidak valid',
                'error'
            );

            return;
        }

        if(!isValidPhone(phone)){

            showToast(
                'Nomor HP tidak valid',
                'error'
            );

            return;
        }

        if(password.length < 8){

            showToast(
                'Password minimal 8 karakter',
                'error'
            );

            return;
        }

        if(password !== confirmPassword){

            showToast(
                'Konfirmasi password tidak cocok',
                'error'
            );

            return;
        }

        /* LOADING */

        registerBtn.classList.add(
            'loading'
        );

        registerText.textContent =
        'Mendaftarkan...';

        try{

            const formData =
            new FormData();

            formData.append(
                'name',
                name
            );

            formData.append(
                'email',
                email
            );

            formData.append(
                'phone',
                phone
            );

            formData.append(
                'address',
                address
            );

            formData.append(
                'password',
                password
            );


            const response =
            await fetch(
                '../php/proses-register.php',
                {
                    method: 'POST',
                    body: formData
                }
            );

            const data =
            await response.json();

            if(data.success){

                showToast(
                    data.message
                );

                setTimeout(() => {

                    window.location.href =
                    'login-user.php';

                }, 1500);

            }else{

                showToast(
                    data.message,
                    'error'
                );

            }

        }

        catch(error){

            console.error(
                error
            );

            showToast(
                'Terjadi kesalahan server',
                'error'
            );

        }

        finally{

            registerBtn.classList.remove(
                'loading'
            );

            registerText.textContent =
            'Daftar Sekarang';

        }

    }
);