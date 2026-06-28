'use strict';

/* =========================
   CONFIG
========================= */

const API_URL = './api';

/* =========================
   ELEMENT
========================= */

const categoryGrid =
document.getElementById(
    'categoryGrid'
);

const categoryModal =
document.getElementById(
    'categoryModal'
);

const categoryForm =
document.getElementById(
    'categoryForm'
);

const categoryId =
document.getElementById(
    'category_id'
);

const categoryName =
document.getElementById(
    'nama_kategori'
);

const categoryIcon =
document.getElementById(
    'icon'
);

const modalTitle =
document.getElementById(
    'categoryModalTitle'
);

const openModalBtn =
document.getElementById(
    'openCategoryModal'
);

const closeModalBtn =
document.getElementById(
    'closeCategoryModal'
);

const cancelModalBtn =
document.getElementById(
    'cancelCategoryModal'
);

/* =========================
   TOAST
========================= */

function showToast(
    message,
    type = 'success'
){

    const toast =
    document.createElement(
        'div'
    );

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

    }, 100);

    setTimeout(() => {

        toast.remove();

    }, 3000);
}

/* =========================
   MODAL
========================= */

function openModal(){

    categoryModal.classList.add(
        'active'
    );

}

function closeModal(){

    categoryModal.classList.remove(
        'active'
    );

    categoryForm.reset();

    categoryId.value = '';

    previewImage.src =
    '../uploads/categories/no-image.png';

}

openModalBtn.addEventListener(
    'click',
    () => {

        modalTitle.textContent =
        'Tambah Kategori';

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

categoryModal.addEventListener(
    'click',
    (e) => {

        if(
            e.target === categoryModal
        ){

            closeModal();

        }

    }
);

/* =========================
   LOAD CATEGORY
========================= */

async function loadCategories(){

    try{

        const response =
        await fetch(
            `${API_URL}/category-list.php`
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

        showToast(
            'Gagal memuat kategori',
            'error'
        );

    }

}

/* =========================
   RENDER CATEGORY
========================= */

function renderCategories(categories){

    categoryGrid.innerHTML = '';

    if(!categories.length){

        categoryGrid.innerHTML = `
            <div class="glass-card category-card">
                <h3>Tidak ada kategori</h3>
            </div>
        `;

        return;
    }

    categories.forEach(category => {

        const imagePath =
        category.icon
        ? `../uploads/categories/${category.icon}`
        : `../uploads/categories/no-image.png`;

        categoryGrid.innerHTML += `

        <div class="glass-card category-card">

            <div class="category-top">

                <div class="category-info">

                    <div class="category-image">

                        <img
                            src="${imagePath}"
                            alt="${category.nama_kategori}"
                            onerror="this.src='../uploads/categories/no-image.png'"
                        >

                    </div>

                    <div>

                        <h3>
                            ${category.nama_kategori}
                        </h3>

                    </div>

                </div>

                <div class="category-actions">

                    <button
                        class="category-btn edit"
                        data-id="${category.id}"
                    >
                        <i class="fa-solid fa-pen"></i>
                    </button>

                    <button
                        class="category-btn delete"
                        data-id="${category.id}"
                    >
                        <i class="fa-solid fa-trash"></i>
                    </button>

                </div>

            </div>

        </div>

        `;

    });

}

/* =========================
   CREATE / UPDATE
========================= */

categoryForm.addEventListener(
    'submit',
    async (e) => {

        e.preventDefault();

        const formData =
        new FormData(
            categoryForm
        );

        const isEdit =
        categoryId.value !== '';

        const endpoint =
        isEdit
        ? 'category-update.php'
        : 'category-create.php';

        try{

            const response =
            await fetch(
                `${API_URL}/${endpoint}`,
                {
                    method:'POST',
                    body:formData
                }
            );

            const result =
            await response.json();

            if(
                result.success
            ){

                showToast(
                    result.message
                );

                closeModal();

                loadCategories();

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
                error
            );

        }

    }
);

/* =========================
   EDIT
========================= */

document.addEventListener(
    'click',
    async (e) => {

        const editBtn =
        e.target.closest(
            '.edit'
        );

        if(!editBtn) return;

        const id =
        editBtn.dataset.id;

        try{

            const response =
            await fetch(
                `${API_URL}/category-detail.php?id=${id}`
            );

            const category =
            await response.json();

            categoryId.value =
            category.id;

            categoryName.value =
            category.nama_kategori;
            
            previewImage.src =
            category.icon
            ? `../uploads/categories/${category.icon}`
            : '../uploads/categories/no-image.png';

            modalTitle.textContent =
            'Edit Kategori';

            openModal();

        }

        catch(error){

            console.error(
                error
            );

        }

    }
);

/* =========================
   DELETE
========================= */

document.addEventListener(
    'click',
    async (e) => {

        const deleteBtn =
        e.target.closest(
            '.delete'
        );

        if(!deleteBtn) return;

        const id =
        deleteBtn.dataset.id;

        const confirmDelete =
        confirm(
            'Hapus kategori ini ?'
        );

        if(
            !confirmDelete
        ) return;

        try{

            const response =
            await fetch(
                `${API_URL}/category-delete.php`,
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

            if(
                result.success
            ){

                showToast(
                    result.message
                );

                loadCategories();

            }

        }

        catch(error){

            console.error(
                error
            );

        }

    }
);

const imageInput =
document.getElementById(
    'icon'
);

const previewImage =
document.getElementById(
    'previewImage'
);

if(imageInput){

    imageInput.addEventListener(
        'change',
        function(){

            const file =
            this.files[0];

            if(!file) return;

            const reader =
            new FileReader();

            reader.onload =
            function(e){

                previewImage.src =
                e.target.result;

            };

            reader.readAsDataURL(
                file
            );

        }
    );

}

/* =========================
   Detail
========================= */

async function detailCategory(id){

    try{

        const response =
        await fetch(
            `${API_URL}/category-detail.php?id=${id}`
        );

        if(!response.ok){

            throw new Error(
                'Gagal mengambil data kategori'
            );

        }

        const category =
        await response.json();

        if(category.success === false){

            throw new Error(
                category.message
            );

        }

        document.getElementById(
            'detailCategoryName'
        ).textContent =
        category.nama_kategori;

        document.getElementById(
            'detailCategoryImage'
        ).src =
        category.icon
        ? `../uploads/categories/${category.icon}`
        : '../uploads/categories/no-image.png';

        document.getElementById(
            'detailCategoryModal'
        ).classList.add(
            'active'
        );

    }

    catch(error){

        console.error(error);

        showToast(
            error.message,
            'error'
        );

    }

}

/* =========================
   START
========================= */

loadCategories();