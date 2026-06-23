'use strict';

/* =========================
   ELEMENTS
========================= */

const form =
document.querySelector('form');

const payBtn =
document.getElementById(
    'payBtn'
);

const modal =
document.getElementById(
    'paymentModal'
);

const closeModal =
document.getElementById(
    'closeModal'
);

const paymentMethod =
document.getElementById(
    'paymentMethod'
);

const qtySpan =
document.getElementById(
    'qtyCount'
);

const qtyInput =
document.getElementById(
    'qtyInput'
);

const daySpan =
document.getElementById(
    'dayCount'
);

const startDate =
document.getElementById(
    'startDate'
);

const endDate =
document.getElementById(
    'endDate'
);

const totalText =
document.getElementById(
    'totalText'
);

const priceText =
document.getElementById(
    'priceText'
);

const daysText =
document.getElementById(
    'daysText'
);

const qtyText =
document.getElementById(
    'qtyText'
);

const subtotalText =
document.getElementById(
    'subtotalText'
);

const depositText =
document.getElementById(
    'depositText'
);

/* =========================
   DATA DARI PHP
========================= */

const pricePerDay =
Number(
    document.body.dataset.price || 0
);

const deposit =
Number(
    document.body.dataset.deposit || 0
);

let qty = 1;
let days = 1;

/* =========================
   BACK BUTTON
========================= */

const backBtn =
document.getElementById(
    'backBtn'
);

if(backBtn){

    backBtn.addEventListener(
        'click',
        () => {

            history.back();

        }
    );

}

/* =========================
   MODAL PAYMENT
========================= */

payBtn.addEventListener(
    'click',
    () => {

        if(
            !startDate.value
        ){

            alert(
                'Pilih tanggal rental terlebih dahulu'
            );

            return;
        }

        modal.classList.remove(
            'hidden'
        );

    }
);

closeModal.addEventListener(
    'click',
    () => {

        modal.classList.add(
            'hidden'
        );

    }
);

/* =========================
   PILIH METODE
========================= */

const proofContainer =
document.getElementById(
    'proofContainer'
);

const paymentProof =
document.getElementById(
    'paymentProof'
);

const methodContainer =
document.getElementById(
    'methodContainer'
);

document
.querySelectorAll(
    '.method-btn'
)
.forEach(button => {

    button.addEventListener(
        'click',
        () => {

            const method =
            button.dataset.method;

            paymentMethod.value =
            method;
            if(method === 'cash'){

                form.submit();

                return;
            }

            methodContainer.style.display =
            'none';

            proofContainer.style.display =
            'block';

        }
    );

});

paymentProof.addEventListener(
    'change',
    () => {

        if(
            paymentProof.files.length > 0
        ){

            form.submit();

        }

    }
);

/* =========================
   QTY
========================= */

document
.getElementById(
    'plusQty'
)
.addEventListener(
    'click',
    () => {

        qty++;

        qtySpan.textContent =
        qty;

        qtyInput.value =
        qty;

        updateTotal();

    }
);

document
.getElementById(
    'minusQty'
)
.addEventListener(
    'click',
    () => {

        if(qty > 1){

            qty--;

        }

        qtySpan.textContent =
        qty;

        qtyInput.value =
        qty;

        updateTotal();

    }
);

/* =========================
   DAYS
========================= */

document
.getElementById(
    'plusDay'
)
.addEventListener(
    'click',
    () => {

        days++;

        daySpan.textContent =
        days;

        updateEndDate();

        updateTotal();

    }
);

document
.getElementById(
    'minusDay'
)
.addEventListener(
    'click',
    () => {

        if(days > 1){

            days--;

        }

        daySpan.textContent =
        days;

        updateEndDate();

        updateTotal();

    }
);

/* =========================
   START DATE
========================= */

startDate.addEventListener(
    'change',
    () => {

        updateEndDate();

        updateTotal();

    }
);

/* =========================
   UPDATE END DATE
========================= */

function updateEndDate(){

    if(
        !startDate.value
    ){
        return;
    }

    const start =
    new Date(
        startDate.value
    );

    const end =
    new Date(
        start
    );

    end.setDate(
        start.getDate() + days
    );

    endDate.value =
    end
    .toISOString()
    .split('T')[0];

}

/* =========================
   UPDATE TOTAL
========================= */

function updateTotal(){

    const subtotal =
    pricePerDay *
    qty *
    days;

    const grandTotal =
    subtotal +
    deposit;

    priceText.textContent =
    'Rp ' +
    pricePerDay.toLocaleString(
        'id-ID'
    );

    daysText.textContent =
    days + ' Hari';

    qtyText.textContent =
    qty;

    subtotalText.textContent =
    'Rp ' +
    subtotal.toLocaleString(
        'id-ID'
    );

    depositText.textContent =
    'Rp ' +
    deposit.toLocaleString(
        'id-ID'
    );

    totalText.textContent =
    'Rp ' +
    grandTotal.toLocaleString(
        'id-ID'
    );

}


/* =========================
   INIT
========================= */

updateTotal();