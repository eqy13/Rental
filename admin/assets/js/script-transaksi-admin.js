'use strict';

/* =========================
   ELEMENT
========================= */

const customerName =
document.getElementById(
    'customer_name'
);

const customerPhone =
document.getElementById(
    'customer_phone'
);

const productSelect =
document.getElementById(
    'product_id'
);

const qtyInput =
document.getElementById(
    'qty'
);

const startDate =
document.getElementById(
    'start_date'
);

const endDate =
document.getElementById(
    'end_date'
);

const totalDaysEl =
document.getElementById(
    'totalDays'
);

const rentalPriceEl =
document.getElementById(
    'rentalPrice'
);

const depositPriceEl =
document.getElementById(
    'depositPrice'
);

const grandTotalEl =
document.getElementById(
    'grandTotal'
);

const transactionForm =
document.getElementById(
    'transactionForm'
);

/* =========================
   FORMAT RUPIAH
========================= */

function formatRupiah(number){

    return 'Rp ' +
    Number(number).toLocaleString(
        'id-ID'
    );

}

/* =========================
   LOAD PRODUCT
========================= */

async function loadProducts(){

    try{

        const response =
        await fetch(
            './api/product-dropdown.php'
        );

        const data =
        await response.json();

        productSelect.innerHTML =
        `
        <option value="">
            Pilih Produk
        </option>
        `;

        data.forEach(product => {

            productSelect.innerHTML +=
            `
            <option
                value="${product.id}"
                data-price="${product.harga_sewa}"
                data-deposit="${product.deposit}"
                data-stock="${product.stok}"
            >
                ${product.nama_produk}
            </option>
            `;

        });

    }

    catch(error){

        console.error(
            'Product Error:',
            error
        );

    }

}

/* =========================
   HITUNG INVOICE
========================= */

function calculateInvoice(){

    const selectedOption =
    productSelect.options[
        productSelect.selectedIndex
    ];

    if(
        !selectedOption ||
        !selectedOption.dataset.price
    ){

        totalDaysEl.textContent =
        '0 Hari';

        rentalPriceEl.textContent =
        'Rp 0';

        depositPriceEl.textContent =
        'Rp 0';

        grandTotalEl.textContent =
        'Rp 0';

        return;
    }

    const price =
    Number(
        selectedOption.dataset.price
    );

    const deposit =
    Number(
        selectedOption.dataset.deposit
    );

    const qty =
    Number(
        qtyInput.value || 1
    );

    if(
        !startDate.value ||
        !endDate.value
    ){

        return;
    }

    const start =
    new Date(
        startDate.value
    );

    const end =
    new Date(
        endDate.value
    );

    const diff =
    end - start;

    let days =
    Math.ceil(
        diff /
        (1000 * 60 * 60 * 24)
    );

    if(days < 1){

        days = 1;

    }

    const subtotal =
    price *
    qty *
    days;

    const total =
    subtotal +
    deposit;

    totalDaysEl.textContent =
    days + ' Hari';

    rentalPriceEl.textContent =
    formatRupiah(
        subtotal
    );

    depositPriceEl.textContent =
    formatRupiah(
        deposit
    );

    grandTotalEl.textContent =
    formatRupiah(
        total
    );

}

/* =========================
   EVENT LISTENER
========================= */

productSelect.addEventListener(
    'change',
    calculateInvoice
);

qtyInput.addEventListener(
    'input',
    calculateInvoice
);

startDate.addEventListener(
    'change',
    calculateInvoice
);

endDate.addEventListener(
    'change',
    calculateInvoice
);

/* =========================
   SIMPAN TRANSAKSI
========================= */

transactionForm.addEventListener(
    'submit',
    async function(e){

        e.preventDefault();

        try{

            const payload = {

                nama_pelanggan:
                customerName.value,

                nomor_hp:
                customerPhone.value,

                product_id:
                productSelect.value,

                qty:
                qtyInput.value,

                start_date:
                startDate.value,

                end_date:
                endDate.value,

                payment_method:
                document.getElementById(
                    'payment_method'
                ).value

            };

            const response =
            await fetch(
                './api/rental-create.php',
                {
                    method:'POST',

                    headers:{
                        'Content-Type':
                        'application/json'
                    },

                    body:
                    JSON.stringify(
                        payload
                    )
                }
            );

            const result =
            await response.json();

            if(result.success){
               loadTransactions();

                alert(
                    'Transaksi berhasil disimpan'
                );

                transactionForm.reset();

                calculateInvoice();

            }

            else{

                alert(
                    result.message ||
                    'Gagal menyimpan transaksi'
                );

            }

        }

        catch(error){

            console.error(
                'Save Transaction Error:',
                error
            );

            alert(
                'Terjadi kesalahan server'
            );

        }

    }
);

/* =========================
   LOAD TRANSAKSI
========================= */

async function loadTransactions(){

    try{

        const response =
        await fetch(
            './api/rental-list.php'
        );

        const data =
        await response.json();

        const table =
        document.getElementById(
            'transactionTable'
        );

        table.innerHTML = '';

        data.forEach(item => {

            table.innerHTML += `
            <tr>

                <td>#${item.id}</td>

            <td>
                <strong>${item.nama_pelanggan}</strong>
                <br>
                <small>${item.nomor_hp}</small>
            </td>

                <td>
                    ${formatRupiah(item.total_harga)}
                </td>

                <td>
                    ${item.status}
                </td>

            </tr>
            `;

        });

    }

    catch(error){

        console.error(error);

    }

}



/* =========================
   INIT
========================= */
loadProducts();
loadTransactions();