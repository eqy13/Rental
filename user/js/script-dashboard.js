'use strict';

/* =========================
   ELEMENTS
========================= */

const searchInput = document.querySelector('.search-box input');
const notificationBtn = document.querySelector('#notificationBtn');

const weatherText = document.querySelector('.weather-info h2');
const activityText = document.querySelector('.weather-right h3');

const categoryCards = document.querySelectorAll('.category-card');
const popularGrid = document.querySelector('.popular-grid');

const categoriesGrid =
document.getElementById(
    'categoriesGrid'
);

/* =========================
   WEATHER SIMULATION
========================= */

function formatWeatherText({ temperature, condition }) {
    return `${temperature} • ${condition}`;
}

function updateWeatherUI() {

    const now = new Date();
    const minutes = now.getMinutes();

    const base = 22;
    const delta = (Math.floor(minutes / 10) % 3) - 1;

    const temperature = `${base + delta}°C`;

    const conditionOptions = [
        'Partly Cloudy',
        'Clear Skies',
        'Light Rain'
    ];

    const condition =
        conditionOptions[Math.floor(minutes / 15) % conditionOptions.length];

    if (weatherText) {
        weatherText.textContent =
            formatWeatherText({ temperature, condition });
    }
}

updateWeatherUI();
setInterval(updateWeatherUI, 10000);

if (activityText) {
    activityText.textContent = 'Outdoor Adventure';
}

/* =========================
   SEARCH
========================= */

if (searchInput) {

    const placeholderBackup =
        searchInput.getAttribute('placeholder') || '';

    let t;

    searchInput.addEventListener('keyup', (e) => {

        clearTimeout(t);

        t = setTimeout(() => {

            const val = e.target.value.trim();

            if (!val) {
                searchInput.setAttribute('placeholder', placeholderBackup);
                return;
            }

            searchInput.setAttribute(
                'placeholder',
                `Searching "${val}"...`
            );

        }, 200);
    });
}

/* =========================
   NOTIFICATION TOGGLE
========================= */

if (notificationBtn) {

    notificationBtn.addEventListener('click', () => {

        const dot = notificationBtn.querySelector('.dot');

        if (dot) {
            dot.style.display =
                dot.style.display === 'none' ? 'block' : 'none';
        }

        // redirect ke halaman notifikasi
        window.location.href = 'notifikasi.php';
    });
}

/* =========================
   CATEGORY ACTIVE UI
========================= */

categoryCards.forEach(card => {

    card.addEventListener('click', () => {

        categoryCards.forEach(c =>
            c.classList.remove('is-active')
        );

        card.classList.add('is-active');

    });
});

/* =========================
   FETCH PRODUCTS (PHP BACKEND READY)
========================= */

async function getProducts(){

    try{

        const res =
        await fetch(
            '../php/get-products.php'
        );

        const products =
        await res.json();

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

/* =========================
   RENDER PRODUCTS
========================= */

function renderProducts(products){

    if(!popularGrid){
        return;
    }

    popularGrid.innerHTML = '';

    products.forEach(item => {

        const card =
        document.createElement('div');

        card.className =
        'popular-card';

        const image =
        item.gambar
        ?
        `../../uploads/products/${item.gambar}`
        :
        '../../uploads/user/no-image.png';

        const liked =
        Number(item.liked || 0) === 1;

        card.innerHTML = `

            <img
                src="${image}"
                alt="${item.nama_produk}"
            >

            <h3>
                ${item.nama_produk}
            </h3>

            <p class="product-tag">
                ${item.kondisi || 'baik'}
            </p>

            <div class="popular-meta">

                <div class="stock">
                    Stock:
                    <strong>
                        ${item.stok}
                    </strong>
                </div>

                <button
                    class="likes-btn"
                    data-id="${item.id}"
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

            <p class="price">
                Rp ${Number(
                    item.harga_sewa
                ).toLocaleString(
                    'id-ID'
                )}
            </p>

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
            '.likes-btn'
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

                    if(data.liked){

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

        popularGrid.appendChild(
            card
        );

    });

}


async function getCategories(){

    try{

        const res =
        await fetch(
            '../php/categories.php'
        );

        const categories =
        await res.json();

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

function renderCategories(categories){

    if(!categoriesGrid){
        return;
    }

    categoriesGrid.innerHTML = '';

    categories.forEach(cat => {

        const image =
        cat.icon
        ? `../../uploads/categories/${cat.icon}`
        : `../../uploads/categories/no-image.png`;

        categoriesGrid.innerHTML += `
        <a
            class="category-card"
            href="halaman-kategori.php?id=${cat.id}"
        >

            <div class="category-image">

                <img
                    src="${image}"
                    alt="${cat.nama_kategori}"
                    onerror="this.src='../../uploads/categories/no-image.png'"
                >

            </div>

            <p>
                ${cat.nama_kategori}
            </p>

        </a>
        `;

    });

}

/* =========================
   INIT
========================= */

getProducts();
getCategories();