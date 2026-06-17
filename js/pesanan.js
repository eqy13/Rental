'use strict';

document.addEventListener(
    'DOMContentLoaded',
    async () => {

        const container =
        document.querySelector(
            '.orders-container'
        );

        if(!container){
            return;
        }

        try{

            const res =
            await fetch(
                '../php/get-orders.php'
            );

            const rentals =
            await res.json();

            container.innerHTML = '';

            if(
                !rentals ||
                rentals.length === 0
            ){

                container.innerHTML = `
                    <p
                        style="
                            text-align:center;
                            color:#999;
                        "
                    >
                        Belum ada pesanan
                    </p>
                `;

                return;
            }

            let html = '';

            rentals.forEach(
                rental => {

                    html += `

                    <div class="order-card glass">

                        <div class="order-top">

                            <div>

                                <span class="order-id">
                                    #RNT${String(rental.id).padStart(6,'0')}
                                </span>

                                <h2>
                                    ${rental.nama_produk}
                                </h2>

                            </div>

                            <span
                                class="status ${rental.status.toLowerCase()}"
                            >
                                ${rental.status}
                            </span>

                        </div>

                        <div class="order-info">

                            <div class="info-box">

                                <p>Tanggal Ambil</p>

                                <h3>
                                    ${rental.tanggal_sewa}
                                </h3>

                            </div>

                            <div class="info-box">

                                <p>Tanggal Kembali</p>

                                <h3>
                                    ${rental.tanggal_kembali}
                                </h3>

                            </div>

                            <div class="info-box">

                                <p>Jumlah</p>

                                <h3>
                                    ${rental.qty}
                                </h3>

                            </div>

                            <div class="info-box">

                                <p>Pembayaran</p>

                                <h3>
                                    ${rental.metode_pembayaran || '-'}
                                </h3>

                            </div>

                        </div>

                        <div class="payment-box">

                            <div>

                                <p>Total Pembayaran</p>

                                <h2>
                                    Rp ${Number(
                                        rental.total_harga
                                    ).toLocaleString(
                                        'id-ID'
                                    )}
                                </h2>

                            </div>

                            <button
                                class="download-btn"
                                data-id="${rental.id}"
                            >

                                <i class="fa-solid fa-eye"></i>

                                Detail

                            </button>

                        </div>

                    </div>

                    `;
                }
            );

            container.innerHTML =
            html;

        }

        catch(error){

            console.error(
                error
            );

            container.innerHTML = `
                <p
                    style="
                        text-align:center;
                        color:red;
                    "
                >
                    Gagal memuat pesanan
                </p>
            `;

        }

    }
);

/* =========================
   DETAIL RENTAL
========================= */

document.addEventListener(
    'click',
    e => {

        const btn =
        e.target.closest(
            '.download-btn'
        );

        if(!btn){
            return;
        }

        const id =
        btn.dataset.id;

        window.location.href =
        `detail-rental.php?id=${id}`;

    }
);