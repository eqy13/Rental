'use strict';

/* =========================
   LOAD ORDERS
========================= */

document.addEventListener('DOMContentLoaded', async () => {

    const container = document.querySelector('.orders-container');

    if (!container) return;

    try {

        const res = await fetch('../php/get-orders.php');
        const rentals = await res.json();

        container.innerHTML = '';

        if (!rentals || rentals.length === 0) {

            container.innerHTML = `
                <p style="text-align:center;color:#999;">
                    Belum ada pesanan
                </p>
            `;
            return;
        }

        let html = '';

        rentals.forEach(rental => {

            html += `
                <div class="order-card glass">

                    <div class="order-top">

                        <div>

                            <span class="order-id">
                                #RNT${String(rental.id).padStart(6, '0')}
                            </span>

                            <h2>
                                ${rental.nama_produk ?? '-'}
                            </h2>

                        </div>

                        <span class="status ${rental.status?.toLowerCase() ?? ''}">
                            ${rental.status ?? '-'}
                        </span>

                    </div>

                    <div class="order-info">

                        <div class="info-box">
                            <p>Tanggal Ambil</p>
                            <h3>${rental.tanggal_sewa ?? '-'}</h3>
                        </div>

                        <div class="info-box">
                            <p>Tanggal Kembali</p>
                            <h3>${rental.tanggal_kembali ?? '-'}</h3>
                        </div>

                        <div class="info-box">
                            <p>Jumlah</p>
                            <h3>${rental.qty ?? 0}</h3>
                        </div>

                        <div class="info-box">
                            <p>Pembayaran</p>
                            <h3>${rental.metode_pembayaran ?? '-'}</h3>
                        </div>

                    </div>

                    <div class="payment-box">

                        <div>

                            <p>Total Pembayaran</p>

                            <h2>
                                Rp ${Number(rental.total_harga ?? 0).toLocaleString('id-ID')}
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
        });

        container.innerHTML = html;

    } catch (error) {

        console.error(error);

        container.innerHTML = `
            <p style="text-align:center;color:red;">
                Gagal memuat pesanan
            </p>
        `;
    }
});


/* =========================
   MODAL DETAIL
========================= */

const detailModal = document.getElementById('detailModal');
const detailContent = document.getElementById('detailContent');

/* CLOSE MODAL */
function closeDetailModal() {
    detailModal.classList.remove('show');
}

/* CLICK DETAIL BUTTON */
document.addEventListener('click', async (e) => {

    const btn = e.target.closest('.download-btn');

    if (!btn) return;

    const id = btn.dataset.id;

    try {

        const response = await fetch(`../php/get-rental-detail.php?id=${id}`);
        const result = await response.json();

        if (!result.success) {
            alert(result.message);
            return;
        }

        const rental = result.data;

        detailContent.innerHTML = `
            <div class="detail-grid">

                <div>
                    <strong>ID Rental</strong>
                    <p>#RNT${String(rental.id).padStart(6, '0')}</p>
                </div>

                <div>
                    <strong>Produk</strong>
                    <p>${rental.nama_produk ?? '-'}</p>
                </div>

                <div>
                    <strong>Jumlah</strong>
                    <p>${rental.qty ?? 0}</p>
                </div>

                <div>
                    <strong>Tanggal Sewa</strong>
                    <p>${rental.tanggal_sewa ?? '-'}</p>
                </div>

                <div>
                    <strong>Tanggal Kembali</strong>
                    <p>${rental.tanggal_kembali ?? '-'}</p>
                </div>

                <div>
                    <strong>Status</strong>
                    <p>${rental.status ?? '-'}</p>
                </div>

                <div>
                    <strong>Pembayaran</strong>
                    <p>${rental.metode_pembayaran ?? '-'}</p>
                </div>

                <div>
                    <strong>Total</strong>
                    <p>Rp ${Number(rental.total_harga ?? 0).toLocaleString('id-ID')}</p>
                </div>

                <div>
                    <strong>Deposit</strong>
                    <p>Rp ${Number(rental.deposit ?? 0).toLocaleString('id-ID')}</p>
                </div>

            </div>
        `;

        detailModal.classList.add('show');

    } catch (error) {

        console.error(error);
        alert('Gagal memuat detail rental');
    }
});