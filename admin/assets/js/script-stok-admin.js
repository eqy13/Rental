"use strict";

const stockTable =
document.getElementById(
    "stockTable"
);

async function loadStock() {

    try {

        const response =
        await fetch(
            "api/stock-list.php"
        );

        const result =
        await response.json();

        if(!result.success){

            return;

        }

        stockTable.innerHTML = "";

        let tersedia = 0;
        let disewa = 0;
        let maintenance = 0;

        result.data.forEach(item => {

            if(item.status === "tersedia"){
                tersedia++;
            }


            if(item.status === "disewa"){
                disewa++;
            }

            if(item.status === "maintenance"){
                maintenance++;
            }

            stockTable.innerHTML += `

                <tr>

                    <td>
                        ${item.nama_produk}
                    </td>

                    <td>
                        ${item.nama_kategori}
                    </td>

                    <td>
                        ${item.stok}
                    </td>

                    <td>
                        ${item.kondisi}
                    </td>

                    <td>

                        <span class="badge ${item.status}">

                            ${item.status}

                        </span>

                    </td>

                </tr>

            `;

        });

        document.getElementById(
            "totalProducts"
        ).textContent =
        result.data.length;

        document.getElementById(
            "availableProducts"
        ).textContent =
        tersedia;
        

        document.getElementById(
        "maintenanceProducts"
        ).textContent=maintenance;

    }

    catch(error){

        console.error(error);

    }

}

loadStock();

/* SEARCH */

document
.getElementById(
    "searchProduct"
)
.addEventListener(
    "keyup",
    function(){

        const value =
        this.value.toLowerCase();

        document
        .querySelectorAll(
            "#stockTable tr"
        )
        .forEach(row => {

            row.style.display =
            row.innerText
            .toLowerCase()
            .includes(value)
            ? ""
            : "none";

        });

    }
);