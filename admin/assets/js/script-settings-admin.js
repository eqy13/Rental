// ==============================
// SETTINGS ADMIN
// ==============================

document.addEventListener(
    "DOMContentLoaded",
    () => {
        loadSystemStats();

    }
);

// ==============================
// ELEMENTS
// ==============================

const settingsForm =
document.getElementById(
    "settingsForm"
);

const maintenanceToggle =
document.getElementById(
    "maintenanceToggle"
);

const backupBtn =
document.getElementById(
    "backupBtn"
);

const logoutBtn =
document.getElementById(
    "logoutBtn"
);

const editProfileBtn =
document.getElementById(
    "editProfileBtn"
);



// ==============================
// LOAD SYSTEM STATS
// ==============================

async function loadSystemStats(){

    try{

        const response =
        await fetch(
            "./api/system-stats.php"
        );

        const data =
        await response.json();

        const totalUsers =
        document.getElementById(
            "totalUsers"
        );

        const totalProducts =
        document.getElementById(
            "totalProducts"
        );

        const totalRentals =
        document.getElementById(
            "totalRentals"
        );

        const totalCategories =
        document.getElementById(
            "totalCategories"
        );

        const totalRevenue =
        document.getElementById(
            "totalRevenue"
        );

        if(totalUsers){

            totalUsers.innerText =
            data.users || 0;

        }

        if(totalProducts){

            totalProducts.innerText =
            data.products || 0;

        }

        if(totalRentals){

            totalRentals.innerText =
            data.rentals || 0;

        }

        if(totalCategories){

            totalCategories.innerText =
            data.categories || 0;

        }

        if(totalRevenue){

            totalRevenue.innerText =
            formatRupiah(
                data.revenue || 0
            );

        }

    }

    catch(error){

        console.error(
            "Stats Error:",
            error
        );

    }

}

// ==============================
// BACKUP DATABASE
// ==============================

if(backupBtn){

    backupBtn.addEventListener(
        "click",
        async () => {

            try{

                backupBtn.disabled =
                true;

                backupBtn.innerText =
                "Membuat Backup...";

                const response =
                await fetch(
                    "./api/backup-db.php"
                );

                const result =
                await response.json();


                console.log(result);

                if(result.success){

                    alert(
                        "Backup berhasil dibuat"
                    );

                }

                else{

                    alert(
                        "Backup gagal"
                    );

                }

            }

            catch(error){

                console.error(
                    error
                );

                alert(
                    "Backup gagal"
                );

            }

            finally{

                backupBtn.disabled =
                false;

                backupBtn.innerText =
                "Backup Database";

            }

        }
    );

}

// ==============================
// LOGOUT
// ==============================

if(logoutBtn){

    console.log("Logout listener dipasang");

    if (logoutBtn) {

        logoutBtn.addEventListener("click", async (e) => {

            e.preventDefault();

            console.log("Logout diklik");

            await fetch("./api/logout.php");

            console.log("Logout selesai");

            window.location.href = "./login-admin.php";
        });

    }

    logoutBtn.addEventListener(
        "click",
        async () => {

            const confirmLogout =
            confirm(
                "Yakin ingin logout?"
            );

            if(!confirmLogout){
                return;
            }

            try{

                await fetch(
                    "./api/logout.php"
                );

                window.location.href =
                "login-admin.php";

            }

            catch(error){

                console.error(
                    error
                );

            }

        }
    );

}


async function loadActivity(){

const response =
await fetch(
'./api/activity-list.php'
);

const data =
await response.json();

const container =
document.getElementById(
'activityLog'
);

container.innerHTML='';

data.forEach(log=>{

container.innerHTML += `
<div class="activity-item">
<i class="fa-solid fa-clock"></i>
<span>
${log.aktivitas}
</span>
</div>
`;

});

}

loadActivity();

// ==============================
// FORMAT RUPIAH
// ==============================

function formatRupiah(
    number
){

    return new Intl.NumberFormat(
        "id-ID",
        {
            style:"currency",
            currency:"IDR",
            minimumFractionDigits:0
        }
    ).format(number);

}


const darkToggle =
document.getElementById(
    "darkToggle"
);

if(darkToggle){

    const savedTheme =
    localStorage.getItem(
        "theme"
    );

    if(savedTheme === "light"){

        document.body.classList.add(
            "light-mode"
        );

        darkToggle.checked =
        false;

    }
    else{

        darkToggle.checked =
        true;

    }

    darkToggle.addEventListener(
        "change",
        () => {

            if(darkToggle.checked){

                document.body.classList.remove(
                    "light-mode"
                );

                localStorage.setItem(
                    "theme",
                    "dark"
                );

            }
            else{

                document.body.classList.add(
                    "light-mode"
                );

                localStorage.setItem(
                    "theme",
                    "light"
                );

            }

        }
    );

}

const profileModal =
document.getElementById(
    "profileModal"
);

document
.getElementById(
    "editProfileBtn"
)
.addEventListener(
    "click",
    ()=>{

        profileModal.classList.add(
            "active"
        );

    }
);

document
.getElementById(
    "closeProfileModal"
)
.addEventListener(
    "click",
    ()=>{

        profileModal.classList.remove(
            "active"
        );

    }
);

document
.getElementById(
    "cancelProfile"
)
.addEventListener(
    "click",
    ()=>{

        profileModal.classList.remove(
            "active"
        );

    }
);

const fotoInput =
document.getElementById("foto");

if(fotoInput){

    fotoInput.addEventListener(
        "change",
        function(){

            if(!this.files.length){
                return;
            }

            const reader =
            new FileReader();

            reader.onload =
            e=>{

                document.getElementById(
                    "previewPhoto"
                ).src =
                e.target.result;

            };

            reader.readAsDataURL(
                this.files[0]
            );

        }
    );

}

profileModal.addEventListener(
    "click",
    e=>{

        if(
            e.target === profileModal
        ){

            profileModal.classList.remove(
                "active"
            );

        }

    }
);

document
.getElementById(
    "profileForm"
)
.addEventListener(
    "submit",
    async e=>{

        e.preventDefault();

        const formData =
        new FormData(
            e.target
        );

        try{

            const response =
            await fetch(

                "./api/admin-profile-update.php",

                {

                    method:"POST",

                    body:formData

                }

            );

            const result =
            await response.json();

            if(result.success){

                alert(
                    "Profil berhasil diperbarui"
                );

                location.reload();

            }
            else{

                alert(
                    result.message
                );

            }

        }

        catch(error){

            console.error(
                error
            );

        }

    }
);

/* =========================
   PASSWORD MODAL
========================= */

const passwordModal =
document.getElementById(
    "passwordModal"
);

const changePasswordBtn =
document.getElementById(
    "changePasswordBtn"
);

const closePasswordModal =
document.getElementById(
    "closePasswordModal"
);

const cancelPassword =
document.getElementById(
    "cancelPassword"
);

changePasswordBtn.addEventListener(
    "click",
    () => {

        passwordModal.classList.add(
            "active"
        );

    }
);

closePasswordModal.addEventListener(
    "click",
    () => {

        passwordModal.classList.remove(
            "active"
        );

    }
);

cancelPassword.addEventListener(
    "click",
    () => {

        passwordModal.classList.remove(
            "active"
        );

    }
);

passwordModal.addEventListener(
    "click",
    e=>{

        if(
            e.target===passwordModal
        ){

            passwordModal.classList.remove(
                "active"
            );

        }

    }
);

document
.getElementById(
    "passwordForm"
)
.addEventListener(
    "submit",
    async e=>{

        e.preventDefault();

        const password =
        document.getElementById(
            "password"
        ).value;

        const confirm =
        document.getElementById(
            "confirmPassword"
        ).value;

        if(password!==confirm){

            alert(
                "Konfirmasi password tidak sama."
            );

            return;

        }

        try{

            const response =
            await fetch(
                "./api/change-password-admin.php",
                {
                    method:"POST",

                    headers:{
                        "Content-Type":
                        "application/json"
                    },

                    body:JSON.stringify({
                        password
                    })
                }
            );

            const result =
            await response.json();

            if(result.success){

                alert(
                    "Password berhasil diubah"
                );

                passwordModal.classList.remove(
                    "active"
                );

                document
                .getElementById(
                    "passwordForm"
                )
                .reset();

            }
            else{

                alert(
                    result.message
                );

            }

        }

        catch(error){

            console.error(
                error
            );

            alert(
                "Terjadi kesalahan."
            );

        }

    }
);

// ==============================
// PAGE FADE IN
// ==============================

document.body.style.opacity =
"0";

document.body.style.transition =
"0.4s ease";

window.addEventListener(
    "load",
    () => {

        document.body.style.opacity =
        "1";

    }
);