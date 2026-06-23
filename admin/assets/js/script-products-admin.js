'use strict';


/* =====================================
   ELEMENT
===================================== */

const productTable =
document.getElementById('productTable');

const productForm =
document.getElementById('productForm');

const modal =
document.getElementById('productModal');

const modalTitle =
document.getElementById('modalTitle');

const openModalBtn =
document.getElementById('openProductModal');

const closeModalBtn =
document.getElementById('closeModal');

const cancelModalBtn =
document.getElementById('cancelModal');

const searchInput =
document.getElementById('searchProduct');

const categoryFilter =
document.getElementById('filterCategory');

let allProducts = [];

/* =====================================
   MODAL
===================================== */

function openModal() {

    modal.classList.add('active');

}

function closeModal() {

    modal.classList.remove('active');

    productForm.reset();

    document.getElementById(
        'product_id'
    ).value = '';

}

openModalBtn.addEventListener(
    'click',
    () => {

        modalTitle.textContent =
        'Tambah Produk';

        openModal();

    }
);

closeModalBtn.addEventListener(
    'click',
    closeModal
);

cancelModalBtn.addEventListener(
    'click',
    closeModal
);

categoryFilter.addEventListener(
    'change',
    filterProducts
);

modal.addEventListener(
    'click',
    (e) => {

        if(e.target === modal){

            closeModal();

        }

    }
);

/* =====================================
   TOAST
===================================== */

function showToast(
    message,
    type = 'success'
){

    const toast =
    document.createElement('div');

    toast.className =
    `toast ${type}`;

    toast.textContent =
    message;

    document.body.appendChild(
        toast
    );

    setTimeout(() => {

        toast.classList.add(
            'show'
        );

    },100);

    setTimeout(() => {

        toast.remove();

    },3000);
}

/* =====================================
   LOAD CATEGORY
===================================== */

async function loadCategories(){

    try{

        const response =
        await fetch(
            './api/category-list.php'
        );

        const categories =
        await response.json();

        const categorySelect =
        document.getElementById(
            'category_id'
        );

        categorySelect.innerHTML =
        '<option value="">Pilih Kategori</option>';

        categoryFilter.innerHTML =
        '<option value="">Semua Kategori</option>';

        categories.forEach(cat => {

            categorySelect.innerHTML += `
                <option value="${cat.id}">
                    ${cat.nama_kategori}
                </option>
            `;

            categoryFilter.innerHTML += `
                <option value="${cat.id}">
                    ${cat.nama_kategori}
                </option>
            `;

        });

    }

    catch(error){

        console.error(error);

    }

}
/* =====================================
   LOAD PRODUCTS
===================================== */

async function loadProducts(){

    try{

        const response =
        await fetch(
            './api/product-list.php'
        );

        const products =
        await response.json();

        allProducts = products;

        renderProducts(
            products
        );

    }

    catch(error){

        console.error(error);

    }

}

/* =====================================
   RENDER PRODUCT
===================================== */

function renderProducts(
    products
){

    productTable.innerHTML = '';

    products.forEach(product => {

        productTable.innerHTML += `

        <tr>

            <td class="product-cell">

                <img
                    src="../uploads/products/${product.gambar}"
                    onerror="this.src='./assets/no-image.png'"
                >

                ${product.nama_produk}

            </td>

            <td>
                ${product.nama_kategori}
            </td>

            <td>
                Rp ${Number(product.harga_sewa)
                    .toLocaleString('id-ID')}
            </td>

            <td>
                Rp ${Number(product.deposit)
                    .toLocaleString('id-ID')}
            </td>

            <td>
                ${product.stok}
            </td>

            <td>

    ${
        product.status === 'maintenance'

        ?

        `
        <span class="status maintenance">
            Maintenance
        </span>
        `

        :

        Number(product.stok) > 0

        ?

        `
        <span class="status tersedia">
            Tersedia
        </span>
        `

        :

        `
        <span class="status habis">
            Habis
        </span>
        `
    }

</td>

            <td>

                <button
                    class="table-btn edit"
                    data-id="${product.id}"
                >
                    <i class="fa-solid fa-pen"></i>
                </button>

                <button
                    class="table-btn detail"
                    data-id="${product.id}"
                >

                    <i class="fa-solid fa-eye"></i>
                </button>

                <button
                    class="table-btn delete"
                    data-id="${product.id}"
                >
                    <i class="fa-solid fa-trash"></i>
                </button>

            </td>

        </tr>

        `;
    });

    attachTableEvents();


}

function filterProducts(){

    const keyword =
    searchInput.value
    .toLowerCase();

    const category =
    categoryFilter.value;

    const filtered =
    allProducts.filter(product=>{

        const matchSearch =
        product.nama_produk
        .toLowerCase()
        .includes(keyword);

        const matchCategory =

            category === ''

            ||

            Number(product.category_id)
            ===
            Number(category);

        return (
            matchSearch &&
            matchCategory
        );

    });

    renderProducts(filtered);

}


/* =====================================
   CREATE PRODUCT
===================================== */

productForm.addEventListener(
    'submit',
    async (e) => {

        e.preventDefault();

        const formData =
        new FormData(productForm);

        const productId =
        document.getElementById(
            'product_id'
        ).value;

        const url =
        productId
        ? './api/product-update.php'
        : './api/product-create.php';

        try{

            const response =
            await fetch(url,{
                method:'POST',
                body:formData
            });

            const result =
            await response.json();

            console.log(result);

            if(result.success){

                showToast(
                    result.message
                );

                closeModal();

                await loadProducts();

            }
            else{

                showToast(
                    result.message,
                    'error'
                );

            }

        }

        catch(error){

            console.error(
                'Submit Error:',
                error
            );

        }

    }
);

/* =====================================
   DELETE
===================================== */

async function deleteProduct(id){

    const confirmDelete =
    confirm(
        'Hapus produk ini?'
    );

    if(!confirmDelete){

        return;

    }

    try{

        const response =
        await fetch(
            './api/product-delete.php',
            {
                method:'POST',
                headers:{
                    'Content-Type':
                    'application/json'
                },
                body:JSON.stringify({
                    id:id
                })
            }
        );

        const result =
        await response.json();

        if(result.success){

            showToast(
                result.message
            );

            loadProducts();

        }

    }

    catch(error){

        console.error(error);

    }

}

/* =====================================
   EDIT
===================================== */

async function editProduct(id){

    try{

        const response =
        await fetch(
            `./api/product-detail.php?id=${id}`
        );

        const product =
        await response.json();

        

        document.getElementById(
            'product_id'
        ).value =
        product.id;

        document.getElementById(
            'nama_produk'
        ).value =
        product.nama_produk;

        document.getElementById(
            'category_id'
        ).value =
        product.category_id;

        document.getElementById(
            'harga_sewa'
        ).value =
        product.harga_sewa;

        document.getElementById(
            'deposit'
        ).value =
        product.deposit;

        document.getElementById(
            'stok'
        ).value =
        product.stok;

        document.getElementById(
            'kondisi'
        ).value =
        product.kondisi;

        document.getElementById(
            'status'
        ).value =
        product.status;

        document.getElementById(
            'deskripsi'
        ).value =
        product.deskripsi;

        document.getElementById(
            'spesifikasi'
        ).value =
        product.spesifikasi || '';

        document.getElementById(
            'include_item'
        ).value =
        product.include_item || '';

        modalTitle.textContent =
        'Edit Produk';

        openModal();

    }

    catch(error){

        console.error(error);

    }

}

/* ====================================
    Details
===================================== */

async function detailProduct(id){

    try{

        const response =
        await fetch(
            `./api/product-detail.php?id=${id}`
        );

        if(!response.ok){

            throw new Error(
                "Gagal mengambil data produk."
            );

        }

        const product =
        await response.json();

        if(product.success === false){

            throw new Error(
                product.message
            );

        }

        const gallery =
        document.getElementById(
            "detailGallery"
        );

        const detailImage =
        document.getElementById(
            "detailImage"
        );

        gallery.innerHTML = "";

        if (
            product.images &&
            product.images.length > 0
        ) {

            // gambar utama
            detailImage.src =
            `../uploads/products/${product.images[0]}`;

            product.images.forEach(image => {

                const img =
                document.createElement(
                    "img"
                );

                img.src =
                `../uploads/products/${image}`;

                img.className =
                "detail-gallery-image";

                img.addEventListener(
                    "click",
                    () => {

                        detailImage.src =
                        img.src;

                    }
                );

                gallery.appendChild(
                    img
                );

            });

        }
        else {

            detailImage.src =
            "../uploads/products/no-image.png";

            gallery.innerHTML = `
                <img
                    src="../uploads/products/no-image.png"
                    class="detail-gallery-image"
                    alt="No Image"
                >
            `;

        }

        document.getElementById("detailId").textContent =
        product.id;

        document.getElementById("detailName").textContent =
        product.nama_produk;

        document.getElementById("detailCategory").textContent =
        product.nama_kategori;

        document.getElementById("detailPrice").textContent =
        "Rp " +
        Number(product.harga_sewa)
        .toLocaleString("id-ID");

        document.getElementById("detailDeposit").textContent =
        "Rp " +
        Number(product.deposit)
        .toLocaleString("id-ID");

        document.getElementById("detailStock").textContent =
        product.stok;

        document.getElementById("detailCondition").textContent =
        product.kondisi;

        document.getElementById("detailStatus").textContent =
        product.status;

        document.getElementById("detailDescription").textContent =
        product.deskripsi || "-";

        document.getElementById("detailSpec").textContent =
        product.spesifikasi || "-";

        document.getElementById("detailInclude").textContent =
        product.include_item || "-";

        document
        .getElementById("detailModal")
        .classList.add("active");

    }

    catch(error){

        console.error(error);

        showToast(
            error.message,
            "error"
        );

    }

}


/* =====================================
   TABLE EVENTS
===================================== */

function attachTableEvents(){

    document
    .querySelectorAll('.delete')
    .forEach(btn => {

        btn.addEventListener(
            'click',
            () => {

                deleteProduct(
                    btn.dataset.id
                );

            }
        );

    });

    document
    .querySelectorAll('.edit')
    .forEach(btn => {

        btn.addEventListener(
            'click',
            () => {

                editProduct(
                    btn.dataset.id
                );

            }
        );

    });

    document
    .querySelectorAll('.detail')
    .forEach(btn=>{

        btn.addEventListener(
            'click',
            ()=>{

                detailProduct(
                    btn.dataset.id
                );
            }
        );
    });

}

/* =====================================
   SEARCH
===================================== */

searchInput.addEventListener(
    'keyup',
    () => {

        const keyword =
        searchInput.value
        .toLowerCase();

        document
        .querySelectorAll(
            '#productTable tr'
        )
        .forEach(row => {

            row.style.display =
            row.innerText
            .toLowerCase()
            .includes(keyword)
            ? ''
            : 'none';

        });

    }
);

document
.getElementById('harga_sewa')
.addEventListener('input', function(){

    if(this.value < 0){

        this.value = 0;

    }

});

/* =====================================
   INIT
===================================== */

loadCategories();

loadProducts();