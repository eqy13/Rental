document.addEventListener("DOMContentLoaded", () => {

    const likesGrid = document.getElementById("likesGrid");

    async function loadLikes() {

        try {

            const res = await fetch("../php/get-likes-products.php");
            const products = await res.json();

            render(products);

        } catch (err) {
            console.log("Error load likes:", err);
        }

    }

    function render(products) {

        likesGrid.innerHTML = "";

        if (!products.length) {

            likesGrid.innerHTML = `
                <p style="text-align:center; opacity:.6;">
                    Belum ada produk yang disukai
                </p>
            `;

            return;
        }

        products.forEach(item => {

            const card = document.createElement("div");
            card.className = "like-card";

            const image = item.gambar
                ? `../../uploads/products/${item.gambar}`
                : "../../uploads/products/no-image.png";

            card.innerHTML = `

                <img src="${image}" alt="${item.nama_produk}">

                <h3>${item.nama_produk}</h3>

                <p class="price">
                    Rp ${Number(item.harga_sewa).toLocaleString('id-ID')}
                </p>

                <p class="stock">
                    Stock: ${item.stok}
                </p>

                <button class="remove-like" data-id="${item.id}">
                    <i class="fa-solid fa-heart-crack"></i>
                </button>

            `;

            /* CLICK DETAIL */
            card.addEventListener("click", (e) => {

                if (e.target.closest(".remove-like")) return;

                window.location.href =
                    `detail.php?id=${item.id}`;

            });

            /* REMOVE LIKE */
            const btn = card.querySelector(".remove-like");

            btn.addEventListener("click", async (e) => {

                e.stopPropagation();

                const form = new FormData();
                form.append("product_id", item.id);

                await fetch("../php/toggle-like.php", {
                    method: "POST",
                    body: form
                });

                loadLikes(); // refresh

            });

            likesGrid.appendChild(card);

        });

    }

    loadLikes();

});