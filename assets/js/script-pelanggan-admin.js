"use strict";
/* ==========================
   LOAD CUSTOMER
========================== */

const customerTable =
document.getElementById(
    "customerTable"
);

async function loadCustomers() {

    try {

        const response =
        await fetch(
            "./api/customer-list.php"
        );

        const result =
        await response.json();

        if(!result.success){

            throw new Error(
                result.message
            );

        }

        customerTable.innerHTML = "";

        result.data.forEach(customer => {

            customerTable.innerHTML += `

                <tr>

                    <td>

                        <div class="customer-info">

                            <span>
                                ${customer.nama_lengkap}
                            </span>

                        </div>

                    </td>

                    <td>
                        ${customer.email}
                    </td>

                    <td>
                        ${customer.nomor_hp}
                    </td>

                    <td>
                        ${new Date(
                            customer.created_at
                        ).toLocaleDateString(
                            "id-ID"
                        )}
                    </td>

                    <td>

                        <span
                            class="badge ${
                                customer.status === "aktif"
                                ? "success"
                                : "danger"
                            }"
                        >

                            ${customer.status.toUpperCase()}

                        </span>

                    </td>

                </tr>

            `;

        });

    }

    catch(error){

        console.error(error);

    }

}

loadCustomers();

/* ==========================
   SEARCH
========================== */

const searchInput =
document.getElementById(
    "searchCustomer"
);

searchInput.addEventListener(
    "keyup",
    () => {

        const value =
        searchInput.value
        .toLowerCase();

        const rows =
        document.querySelectorAll(
            "#customerTable tr"
        );

        rows.forEach(row => {

            row.style.display =
            row.innerText
            .toLowerCase()
            .includes(value)
            ? ""
            : "none";

        });

    }
);

const addCustomerBtn =
document.getElementById(
    'addCustomerBtn'
);

const customerModal =
document.getElementById(
    'customerModal'
);

addCustomerBtn.addEventListener(
    'click',
    () => {

        customerModal.style.display =
        'flex';

    }
);

async function saveCustomer(){

    try{

        const response =
        await fetch(
            './api/customer-create.php',
            {
                method:'POST',

                headers:{
                    'Content-Type':
                    'application/json'
                },

                body:
                JSON.stringify({

                    nama_lengkap:
                    document.getElementById(
                        'nama'
                    ).value,

                    email:
                    document.getElementById(
                        'email'
                    ).value,

                    no_hp:
                    document.getElementById(
                        'no_hp'
                    ).value,

                    password:
                    document.getElementById(
                        'password'
                    ).value

                })

            }
        );

        const result =
        await response.json();

        if(result.success){

            alert(
                'Pelanggan berhasil ditambahkan'
            );

            customerModal.style.display =
            'none';

            loadCustomers();

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

/* ==========================
   FADE PAGE
========================== */

document.body.style.opacity = "0";

window.addEventListener(
    "load",
    () => {

        document.body.style.transition =
        ".4s ease";

        document.body.style.opacity = "1";

    }
);