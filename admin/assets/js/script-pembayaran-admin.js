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
                    <strong>
                        ${payment.nama_pelanggan || '-'}
                    </strong>
                    <br>
                    <small>
                        ${payment.nomor_hp || '-'}
                    </small>
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

                        ${payment.bukti_pembayaran ? `
                        <button
                            class="btn-view"
                            onclick="showPaymentProof('${payment.bukti_pembayaran}')"
                        >
                            Lihat Bukti
                        </button>
                        ` : ''}

                        
                    </div>
                </td>

                <td>
                    <button
                        class="detail-btn"
                        onclick="showOrderDetail(${payment.id})"
                    >
                        <i class="fa-solid fa-eye"></i>
                        Detail
                    </button>
                </td>

            </tr>
            `;

        });

}

function showPaymentProof(fileName) {

    document.getElementById("paymentProofImage").src =
        "../uploads/payments/" + fileName;

    document.getElementById("paymentModal").style.display = "flex";

}

function closePaymentModal() {

    document.getElementById("paymentModal").style.display = "none";

    document.getElementById("paymentProofImage").src = "";

}

window.onclick = function(e){

    const modal = document.getElementById("paymentModal");

    if(e.target === modal){

        closePaymentModal();

    }

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

                        (payment.nama_pelanggan || '')
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

async function showOrderDetail(paymentId){

    try{

        const response =
        await fetch(
            `./api/payment-detail.php?id=${paymentId}`
        );

        const result =
        await response.json();

        if(!result.success){

            alert(result.message);

            return;

        }

        const data =
        result.data;

        document.getElementById("detailContent").innerHTML = `

<div class="detail-grid">

    <div class="detail-item">
        <span>Pelanggan</span>
        <strong>${data.nama_lengkap}</strong>
    </div>

    <div class="detail-item">
        <span>Email</span>
        <strong>${data.email}</strong>
    </div>

    <div class="detail-item">
        <span>Produk</span>
        <strong>${data.nama_produk}</strong>
    </div>

    <div class="detail-item">
        <span>Jumlah</span>
        <strong>${data.qty} Unit</strong>
    </div>

    <div class="detail-item">
        <span>Harga / Hari</span>
        <strong>Rp ${Number(data.harga).toLocaleString('id-ID')}</strong>
    </div>

    <div class="detail-item">
        <span>Total</span>
        <strong>Rp ${Number(data.total_harga).toLocaleString('id-ID')}</strong>
    </div>

    <div class="detail-item">
        <span>Tanggal Rental</span>
        <strong>${data.tanggal_sewa}</strong>
    </div>

    <div class="detail-item">
        <span>Tanggal Kembali</span>
        <strong>${data.tanggal_kembali}</strong>
    </div>

    <div class="detail-item">
        <span>Metode Pembayaran</span>
        <strong>${data.metode_pembayaran.toUpperCase()}</strong>
    </div>

    <div class="detail-item">
        <span>Status Pembayaran</span>

        <span class="status payment ${data.payment_status}">
            ${data.payment_status}
        </span>

    </div>

    <div class="detail-item">
        <span>Status Rental</span>

        <span class="status rental ${data.rental_status}">
            ${data.rental_status}
        </span>

    </div>

</div>

`;

        document
        .getElementById(
            "detailModal"
        )
        .style.display =
        "block";

    }

    catch(error){

        console.error(error);

        alert(
            "Gagal mengambil detail pembayaran."
        );

    }

}

function closeDetailModal(){

    document
        .getElementById("detailModal")
        .style.display = "none";

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