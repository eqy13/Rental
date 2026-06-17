// ==============================
// ACTIVE SIDEBAR
// ==============================

const navLinks =
document.querySelectorAll(
    '.sidebar nav a'
);

navLinks.forEach(link => {

    link.addEventListener(
        'click',
        () => {

            navLinks.forEach(item => {

                item.classList.remove(
                    'active'
                );

            });

            link.classList.add(
                'active'
            );

        }
    );

});

// ==============================
// ELEMENT
// ==============================

const paymentTable =
document.getElementById(
    'paymentTable'
);

const searchInput =
document.getElementById(
    'searchPayment'
);

let paymentData = [];

// ==============================
// FORMAT RUPIAH
// ==============================

function formatRupiah(value){

    return new Intl.NumberFormat(
        'id-ID'
    ).format(value || 0);

}

// ==============================
// LOAD PAYMENTS
// ==============================

async function loadPayments(){

    try{

        const response =
        await fetch(
            './api/payment-list.php'
        );

        if(!response.ok){

            throw new Error(
                'Gagal memuat data pembayaran'
            );

        }

        paymentData =
        await response.json();

        renderPayments(
            paymentData
        );

    }

    catch(error){

        console.error(
            'Payment Error:',
            error
        );

        paymentTable.innerHTML =
        `
        <tr>
            <td colspan="5">
                Gagal memuat data pembayaran
            </td>
        </tr>
        `;

    }

}

// ==============================
// RENDER TABLE
// ==============================

function renderPayments(data){

    paymentTable.innerHTML = '';

    if(data.length === 0){

        paymentTable.innerHTML =
        `
        <tr>
            <td colspan="5">
                Belum ada data pembayaran
            </td>
        </tr>
        `;

        return;
    }

        data.forEach(payment => {

            let badgeClass = 'pending';

            let badgeText =
            payment.payment_status;

            if(
                payment.payment_status === 'diterima'
            ){
                badgeClass = 'success';
            }

            if(
                payment.payment_status === 'ditolak'
            ){
                badgeClass = 'danger';
            }

            paymentTable.innerHTML += `
            <tr>

                <td>
                    #INV${payment.id}
                </td>

                <td>
                    ${payment.nama_lengkap || '-'}
                </td>

                <td>

                    <span
                        class="badge ${badgeClass}"
                    >
                        ${badgeText}
                    </span>

                </td>

                <td>
                    Rp ${formatRupiah(
                        payment.total_harga
                    )}
                </td>

                <td>
                    <div class="action-buttons">
                        <button
                            class="
                                ${payment.payment_status === 'diterima'
                                    ? 'active-accept'
                                    : ''
                                }
                            "
                            onclick="
                                updatePaymentStatus(
                                    ${payment.id},
                                    'diterima'
                                )
                            "
                        >
                            Terima
                        </button>

                        <button
                            class="
                                ${payment.payment_status === 'ditolak'
                                    ? 'active-reject'
                                    : ''
                                }
                            "
                            onclick="
                                updatePaymentStatus(
                                    ${payment.id},
                                    'ditolak'
                                )
                            "
                        >
                            Tolak
                        </button>
                    </div>
                </td>

            </tr>
            `;

        });

}

// ==============================
// SEARCH PAYMENT
// ==============================

if(searchInput){

    searchInput.addEventListener(
        'keyup',
        () => {

            const keyword =
            searchInput.value
            .toLowerCase();

            const filtered =
            paymentData.filter(
                payment => {

                    return (

                        (payment.nama_lengkap || '')
                        .toLowerCase()
                        .includes(keyword)

                        ||

                        payment.id
                        .toString()
                        .includes(keyword)

                    );

                }
            );

            renderPayments(
                filtered
            );

        }
    );

}

// ==============================
// TABLE ANIMATION
// ==============================

function animateRows(){

    const rows =
    document.querySelectorAll(
        '#paymentTable tr'
    );

    rows.forEach((row,index) => {

        row.style.opacity = '0';

        row.style.transform =
        'translateY(20px)';

        setTimeout(() => {

            row.style.transition =
            '0.4s ease';

            row.style.opacity =
            '1';

            row.style.transform =
            'translateY(0px)';

        }, index * 100);

    });

}

async function updatePaymentStatus(
    paymentId,
    status
){

    try{

        const response =
        await fetch(
            './api/payment-status-update.php',
            {
                method:'POST',

                headers:{
                    'Content-Type':
                    'application/json'
                },

                body:
                JSON.stringify({
                    payment_id: paymentId,
                    status: status
                })
            }
        );

        const result =
        await response.json();

        if(result.success){

            loadPayments();

        }

        else{

            alert(
                result.message
            );

        }

    }

    catch(error){

        console.error(error);

    }

}

// ==============================
// PAGE FADE IN
// ==============================

document.body.style.opacity =
'0';

document.body.style.transition =
'0.4s ease';

window.addEventListener(
    'load',
    () => {

        document.body.style.opacity =
        '1';

    }
);

// ==============================
// INIT
// ==============================

loadPayments().then(() => {

    setTimeout(() => {

        animateRows();

    }, 200);

});