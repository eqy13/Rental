'use strict';

document.addEventListener(
    "DOMContentLoaded",
    async () => {

        const params =
        new URLSearchParams(
            window.location.search
        );

        const productId =
        params.get("id");

        if(!productId){

            alert(
                "Produk tidak ditemukan"
            );

            window.location.href =
            "dashboard.php";

            return;
        }

        const productName =
        document.getElementById(
            "productName"
        );

        const productCategory =
        document.getElementById(
            "productCategory"
        );

        const productTag =
        document.getElementById(
            "productTag"
        );

        const productPrice =
        document.getElementById(
            "productPrice"
        );

        const productDescription =
        document.getElementById(
            "productDescription"
        );

        const productSpecification =
        document.getElementById(
            "productSpecification"
        );

        const productInclude =
        document.getElementById(
            "productInclude"
        );

        const paymentTotal =
        document.getElementById(
            "paymentTotal"
        );

        const thumbList =
        document.getElementById(
            "thumbList"
        );

        const mainImage =
        document.getElementById(
            "mainImage"
        );

        const payBtn =
        document.getElementById(
            "payBtn"
        );

        const likeBtn =
        document.getElementById(
            "likeBtn"
        );

        const backBtn =
        document.getElementById(
            "backBtn"
        );

        const shareBtn =
        document.getElementById(
            "shareBtn"
        );

        let product = null;
        let images = [];
        let currentIndex = 0;

        async function loadProduct(){

            try{

                const response =
                await fetch(
                    `../php/get-product-detail.php?id=${productId}`
                );

                const data =
                await response.json();

                if(!data.success){

                    alert(
                        data.message
                    );

                    return;
                }

                product =
                data.product;

                images =
                data.images || [];

                renderProduct();

            }

            catch(error){

                console.error(
                    error
                );

            }

        }

        function renderProduct(){

            productName.textContent =
            product.nama_produk;

            productCategory.textContent =
            product.nama_kategori ||
            "-";

            productTag.textContent =
            product.kondisi ||
            "-";

            productPrice.textContent =
            "Rp " +
            Number(
                product.harga_sewa
            ).toLocaleString(
                "id-ID"
            ) +
            "/hari";

            paymentTotal.textContent =
            "Rp " +
            Number(
                product.harga_sewa
            ).toLocaleString(
                "id-ID"
            );

            productDescription.textContent =
            product.deskripsi ||
            "Tidak ada deskripsi";

            renderSpecification();

            renderInclude();

            renderImages();

        }

        function renderSpecification(){

            productSpecification.innerHTML =
            "";

            if(
                !product.spesifikasi
            ){

                productSpecification.innerHTML =
                `
                <li>
                    Tidak ada spesifikasi
                </li>
                `;

                return;
            }

            product.spesifikasi
            .split("\n")
            .forEach(item => {

                if(item.trim()){

                    productSpecification.innerHTML +=
                    `
                    <li>
                        ${item}
                    </li>
                    `;

                }

            });

        }

        function renderInclude(){

            productInclude.innerHTML =
            "";

            if(
                !product.include_item
            ){

                productInclude.innerHTML =
                `
                <span class="include-item">
                    Tidak ada
                </span>
                `;

                return;
            }

            product.include_item
            .split(",")
            .forEach(item => {

                productInclude.innerHTML +=
                `
                <span class="include-item">
                    ${item.trim()}
                </span>
                `;

            });

        }

        function renderImages(){

            thumbList.innerHTML =
            "";

            if(images.length < 1){

                mainImage.src =
                "../../uploads/products/no-image.png";

                return;
            }

            if(
                images.length > 0 &&
                images[0]
            ){

                mainImage.src =
                `../../uploads/products/${images[0]}`;

            }

            else{

                mainImage.src =
                "../../uploads/products/no-image.png";

            }

            images.forEach(
                (
                    image,
                    index
                ) => {

                    const thumb =
                    document.createElement(
                        "img"
                    );

                    thumb.src =
                    `../../uploads/products/${image}`;

                    thumb.className =
                    "thumb";

                    thumb.addEventListener(
                        "click",
                        () => {

                            currentIndex =
                            index;

                            mainImage.src =
                            thumb.src;

                        }
                    );

                    thumbList.appendChild(
                        thumb
                    );

                }
            );

        }

        window.nextImage =
        function(){

            if(
                images.length < 1
            ){
                return;
            }

            currentIndex++;

            if(
                currentIndex >=
                images.length
            ){

                currentIndex = 0;

            }

            mainImage.src =
            `../../uploads/products/${images[currentIndex]}`;

        };

        window.prevImage =
        function(){

            if(
                images.length < 1
            ){
                return;
            }

            currentIndex--;

            if(
                currentIndex < 0
            ){

                currentIndex =
                images.length - 1;

            }

            mainImage.src =
            `../../uploads/products/${images[currentIndex]}`;

        };

        if(backBtn){

            backBtn.addEventListener(
                "click",
                () => {

                    history.back();

                }
            );

        }

        if(payBtn){

            payBtn.addEventListener(
                "click",
                () => {

                    window.location.href =
                    `pembayaran.php?id=${productId}`;

                }
            );

        }

        if(likeBtn){

            likeBtn.addEventListener(
                "click",
                async () => {

                    try{

                        const response =
                        await fetch(
                            "../php/toggle-like.php",
                            {
                                method:"POST",
                                body:new URLSearchParams({
                                    product_id:
                                    productId
                                })
                            }
                        );

                        const data =
                        await response.json();

                        const icon =
                        likeBtn.querySelector(
                            "i"
                        );

                        if(data.liked){

                            icon.className =
                            "fa-solid fa-heart";

                        }

                        else{

                            icon.className =
                            "fa-regular fa-heart";

                        }

                    }

                    catch(error){

                        console.error(
                            error
                        );

                    }

                }
            );

        }

        if(shareBtn){

    shareBtn.addEventListener(
        "click",
        async () => {

            const shareData = {

                title:
                product.nama_produk,

                text:
                `${product.nama_produk} - Rental Outdoor`,

                url:
                window.location.href

            };

            try{

                if(navigator.share){

                    await navigator.share(
                        shareData
                    );

                }

                else{

                    await navigator.clipboard.writeText(
                        window.location.href
                    );

                    alert(
                        "Link berhasil disalin."
                    );

                }

            }

            catch(error){

                console.log(
                    error
                );

            }

        }
    );

}

        async function loadLikeStatus(){

    try{

        const response =
        await fetch(
            `../php/check-like.php?product_id=${productId}`
        );

        const data =
        await response.json();

        const icon =
        likeBtn.querySelector(
            "i"
        );

        if(data.liked){

            icon.className =
            "fa-solid fa-heart";

        }

        else{

            icon.className =
            "fa-regular fa-heart";

        }

    }

    catch(error){

        console.error(
            "Load Like Error:",
            error
        );

    }

}

        await loadProduct();

        await loadLikeStatus();

    }
);