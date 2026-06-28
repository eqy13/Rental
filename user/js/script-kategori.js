'use strict';

document.addEventListener(
    'DOMContentLoaded',
    async () => {

        const grid =
        document.getElementById(
            'equipmentGrid'
        );

        const searchInput =
        document.getElementById(
            'searchInput'
        );

        const productCount =
        document.querySelector(
            '.product-count-tag'
        );

        const filterToggle = document.querySelector('.filter-toggle');
        const filterPanel = document.querySelector('.filter-panel');

        const minPrice = document.querySelector('.min-price');
        const maxPrice = document.querySelector('.max-price');

        const applyBtn = document.querySelector('.apply-btn');
        const resetBtn = document.querySelector('.reset-btn');

        let allProducts = [];
        

        const categoryGrid =
        document.getElementById(
            'categoryGrid'
        );

        let currentCategory =
        'all';

        async function loadCategories(){

    try{

        const response =
        await fetch(
            '../php/categories.php'
        );

        const categories =
        await response.json();

        renderCategories(
            categories
        );

    }

    catch(error){

        console.error(
            error
        );

    }

}

filterToggle.addEventListener('click', () => {

    filterPanel.classList.toggle('show');

});

function filterProducts(){

    const keyword = searchInput.value.toLowerCase();

    const min = Number(minPrice.value) || 0;
    const max = Number(maxPrice.value) || Number.MAX_SAFE_INTEGER;

    const filtered = allProducts.filter(item => {

        const matchSearch =
            item.nama_produk
            .toLowerCase()
            .includes(keyword);

        const matchCategory =
            currentCategory === 'all'
            ||
            Number(item.category_id) === Number(currentCategory);

        const harga =
            Number(item.harga_sewa);

        const matchPrice =
            harga >= min &&
            harga <= max;

        return (
            matchSearch &&
            matchCategory &&
            matchPrice
        );

    });

    renderProducts(filtered);

}

applyBtn.addEventListener('click', () => {

    filterProducts();

    filterPanel.classList.remove('show');

});

resetBtn.addEventListener('click', () => {

    minPrice.value = '';
    maxPrice.value = '';

    filterProducts();

    filterPanel.classList.remove('show');

});

function renderCategories(
    categories
){

    categoryGrid.innerHTML = `

        <button
            class="category-card active"
            data-id="all"
        >
            All
        </button>

    `;

    categories.forEach(
        cat => {

            categoryGrid.innerHTML += `

                <button
                    class="category-card"
                    data-id="${cat.id}"
                >
                    ${cat.nama_kategori}
                </button>

            `;

        }
    );

    bindCategoryEvents();

}

function bindCategoryEvents(){

    document
    .querySelectorAll(
        '.category-card'
    )
    .forEach(
        card => {

            card.addEventListener(
                'click',
                () => {

                    document
                    .querySelectorAll(
                        '.category-card'
                    )
                    .forEach(
                        c => c.classList.remove(
                            'active'
                        )
                    );

                    card.classList.add(
                        'active'
                    );

                    currentCategory =
                    card.dataset.id;

                    filterProducts();

                }
            );

        }
    );

}


        async function loadProducts(){

            try{

                const response =
                await fetch(
                    '../php/get-products.php'
                );

                const products =
                await response.json();

                allProducts =
                products;

                renderProducts(
                    products
                );

            }

            catch(error){

                console.error(
                    error
                );

            }

        }

        function renderProducts(
            products
        ){

            grid.innerHTML = '';

            if(
                productCount
            ){

                productCount.textContent =
                products.length +
                ' Products';

            }

            if(
                products.length < 1
            ){

                grid.innerHTML = `

                <div class="empty-product">

                <i class="fa-regular fa-folder-open"></i>

                <h3>Tidak ada produk</h3>

                <p>Produk yang kamu cari belum tersedia.</p>

                </div>

                `;

                return;
            }

            products.forEach(
                item => {

                    const card =
                    document.createElement(
                        'div'
                    );

                    card.className =
                    'product-card';

                    const image =
                    item.gambar
                    ?
                    `../../uploads/products/${item.gambar}`
                    :
                    '../../uploads/products/no-image.png';

                    const liked =
                    Number(
                        item.liked || 0
                    ) === 1;

                    card.innerHTML = `

                        <div class="product-image">

                            <img
                                src="${image}"
                                alt="${item.nama_produk}"
                            >

                            <button
                                class="like-btn"
                            >

                                <i class="${
                                    liked
                                    ?
                                    'fa-solid fa-heart'
                                    :
                                    'fa-regular fa-heart'
                                }"></i>

                            </button>

                        </div>

                        <div class="product-body">

                            <h3>
                                ${item.nama_produk}
                            </h3>

                            <p class="category">
                                ${
                                    item.nama_kategori ??
                                    '-'
                                }
                            </p>

                            <p class="condition">
                                ${
                                    item.kondisi ??
                                    '-'
                                }
                            </p>

                            <p class="price">
                                Rp ${
                                    Number(
                                        item.harga_sewa
                                    )
                                    .toLocaleString(
                                        'id-ID'
                                    )
                                }
                            </p>

                        </div>

                    `;

                    card.addEventListener(
                        'click',
                        () => {

                            window.location.href =
                            `detail.php?id=${item.id}`;

                        }
                    );

                    const likeBtn =
                    card.querySelector(
                        '.like-btn'
                    );

                    likeBtn.addEventListener(
                        'click',
                        async (e) => {

                            e.stopPropagation();

                            try{

                                const response =
                                await fetch(
                                    '../php/toggle-like.php',
                                    {
                                        method:'POST',
                                        body:new URLSearchParams({
                                            product_id:item.id
                                        })
                                    }
                                );

                                const data =
                                await response.json();

                                const icon =
                                likeBtn.querySelector(
                                    'i'
                                );

                                if(
                                    data.liked
                                ){

                                    icon.className =
                                    'fa-solid fa-heart';

                                }

                                else{

                                    icon.className =
                                    'fa-regular fa-heart';

                                }

                            }

                            catch(error){

                                console.error(
                                    error
                                );

                            }

                        }
                    );

                    grid.appendChild(
                        card
                    );

                }
            );

        }

        if(
            searchInput
        ){

            searchInput.addEventListener(
                'keyup',
                filterProducts
            );

        }

        loadProducts();
        loadCategories();

    }
);