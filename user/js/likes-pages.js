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
                <div class="empty-state">
                    <i class="fa-solid fa-heart-crack"></i>
                    <p>Belum ada produk yang disukai</p>
                </div>
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

                <button class="remove-like" data-id="${item.id}">
                    <i class="fa-solid fa-xmark"></i>
                </button>

                <img src="${image}" alt="${item.nama_produk}">

                <div class="like-content">

                    <h3>${item.nama_produk}</h3>

                    <div class="tag">
                        Stock: ${item.stok}
                    </div>

                    <div class="price">
                        Rp ${Number(item.harga_sewa).toLocaleString('id-ID')}
                    </div>

                </div>

                <div class="card-actions">

                    <button class="detail-btn">
                        Detail
                    </button>

                </div>

            `;

            /* DETAIL CLICK */
            card.addEventListener("click", (e) => {

                if (e.target.closest(".remove-like") ||
                    e.target.closest(".remove-btn")) return;

                window.location.href = `detail.php?id=${item.id}`;
            });

            /* REMOVE LIKE */
            const removeBtn = card.querySelector(".remove-like");

            removeBtn.addEventListener("click", async (e) => {

                e.stopPropagation();

                const form = new FormData();
                form.append("product_id", item.id);

                await fetch("../php/toggle-like.php", {
                    method: "POST",
                    body: form
                });

                loadLikes();
            });

            likesGrid.appendChild(card);

        });

    }

    loadLikes();

});