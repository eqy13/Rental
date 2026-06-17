// ==============================
// ELEMENT
// ==============================

const rentalSelect =
document.getElementById("rental_id");

const conditionSelect =
document.getElementById("condition");

const penaltyText =
document.getElementById("penalty");

const lateDaysText =
document.getElementById("lateDays");

const form =
document.getElementById("returnForm");

// ==============================
// DATA
// ==============================

let rentals = [];
let currentPenalty = 0;
let currentLateDays = 0;

// ==============================
// LOAD RENTALS
// ==============================

async function loadRentals(){

    try{

        const response =
        await fetch("./api/rental-active.php");

        rentals =
        await response.json();

        rentalSelect.innerHTML = `
            <option value="">
                Pilih Rental
            </option>
        `;

        rentals.forEach(rental=>{

            rentalSelect.innerHTML += `
                <option
                    value="${rental.id}"
                >
                    #${rental.id} -
                    ${rental.nama_lengkap}
                </option>
            `;

        });

    }

    catch(error){

        console.error(error);

    }

}

// ==============================
// HITUNG DENDA
// ==============================

function calculatePenalty(){

    const rental =
    rentals.find(
        r=>r.id==rentalSelect.value
    );

    if(!rental){

        currentPenalty = 0;
        currentLateDays = 0;

        lateDaysText.innerText =
        "0 Hari";

        penaltyText.innerText =
        "Rp 0";

        return;
    }

    const today =
    new Date();

    const dueDate =
    new Date(rental.tanggal_kembali);

    let late =
    Math.floor(
        (today-dueDate)
        /
        (1000*60*60*24)
    );

    if(late<0){

        late=0;

    }

    let penalty =
    late*50000;

    switch(conditionSelect.value){

        case "rusak_ringan":

            penalty += 100000;
            break;

        case "rusak_berat":

            penalty += 300000;
            break;

        case "hilang":

            penalty += 1000000;
            break;

    }

    currentPenalty =
    penalty;

    currentLateDays =
    late;

    lateDaysText.innerText =
    late+" Hari";

    penaltyText.innerText =
    "Rp "+
    penalty.toLocaleString("id-ID");

}

// ==============================
// EVENT
// ==============================

rentalSelect.addEventListener(
    "change",
    calculatePenalty
);

conditionSelect.addEventListener(
    "change",
    calculatePenalty
);

// ==============================
// SUBMIT
// ==============================

form.addEventListener(
    "submit",
    async function(e){

        e.preventDefault();

        if(!rentalSelect.value){

            alert("Pilih rental");

            return;

        }

        try{

            const response =
            await fetch(
                "./api/return-create.php",
                {

                    method:"POST",

                    headers:{
                        "Content-Type":
                        "application/json"
                    },

                    body:JSON.stringify({

                        rental_id:
                        rentalSelect.value,

                        condition:
                        conditionSelect.value,

                        penalty:
                        currentPenalty,

                        late_days:
                        currentLateDays

                    })

                }
            );

            const result =
            await response.json();

            if(result.success){

                alert("Pengembalian berhasil");

                form.reset();

                currentPenalty=0;
                currentLateDays=0;

                lateDaysText.innerText =
                "0 Hari";

                penaltyText.innerText =
                "Rp 0";

                loadRentals();

            }

            else{

                alert(result.message);

            }

        }

        catch(error){

            console.error(error);

        }

    }
);

// ==============================
// INIT
// ==============================

loadRentals();