document.addEventListener("DOMContentLoaded", () => {

    // ==========================
    // ELEMENTS
    // ==========================

    const editBtn = document.getElementById("editProfileBtn");
    const cancelBtn = document.getElementById("cancelBtn");
    const saveActions = document.getElementById("saveActions");

    const inputs = [
        document.getElementById("nameInput"),
        document.getElementById("emailInput"),
        document.getElementById("phoneInput"),
        document.getElementById("addressInput")
    ];

    const uploadPhoto = document.getElementById("uploadPhoto");
    const profileImage = document.getElementById("profileImage");

    const passwordBtn = document.getElementById("changePasswordBtn");
    const passwordForm = document.getElementById("passwordForm");

    const darkModeToggle = document.getElementById("darkModeToggle");

    // ==========================
    // EDIT PROFILE
    // ==========================

    const enableEditMode = () => {

        inputs.forEach(input => {
            input.disabled = false;
            input.classList.add("editing");
        });

        editBtn.style.display = "none";

        saveActions.classList.add("show");
    };

    const disableEditMode = () => {

        inputs.forEach(input => {
            input.disabled = true;
            input.classList.remove("editing");
        });

        editBtn.style.display = "flex";

        saveActions.classList.remove("show");
    };

    editBtn?.addEventListener("click", enableEditMode);

    cancelBtn?.addEventListener("click", disableEditMode);

    // ==========================
    // PROFILE IMAGE PREVIEW
    // ==========================

    uploadPhoto?.addEventListener("change", e => {

        const file = e.target.files[0];

        if (!file) return;

        const reader = new FileReader();

        reader.onload = event => {

            profileImage.style.opacity = "0";

            setTimeout(() => {

                profileImage.src = event.target.result;
                profileImage.style.opacity = "1";

            }, 200);

        };

        reader.readAsDataURL(file);

    });

    // ==========================
    // PASSWORD ACCORDION
    // ==========================

    passwordBtn?.addEventListener("click", () => {

        passwordForm.classList.toggle("active");

    });

    // ==========================
    // DARK MODE
    // ==========================

    const applyTheme = theme => {

        document.body.classList.toggle(
            "dark-mode",
            theme === "dark"
        );

        localStorage.setItem("theme", theme);
    };

    const savedTheme =
        localStorage.getItem("theme") || "light";

    applyTheme(savedTheme);

    darkModeToggle.checked =
        savedTheme === "dark";

    darkModeToggle.addEventListener("change", () => {

        applyTheme(
            darkModeToggle.checked
                ? "dark"
                : "light"
        );

    });

    // ==========================
    // RIPPLE EFFECT
    // ==========================

    document.addEventListener("click", e => {

        const btn = e.target.closest("button");

        if (!btn) return;

        const ripple =
            document.createElement("span");

        ripple.classList.add("ripple");

        const rect =
            btn.getBoundingClientRect();

        ripple.style.left =
            e.clientX - rect.left + "px";

        ripple.style.top =
            e.clientY - rect.top + "px";

        btn.appendChild(ripple);

        setTimeout(() => {
            ripple.remove();
        }, 600);

    });

    // ==========================
    // SCROLL REVEAL
    // ==========================

    const observer =
        new IntersectionObserver(entries => {

            entries.forEach(entry => {

                if (entry.isIntersecting) {

                    entry.target.classList.add(
                        "revealed"
                    );

                }

            });

        }, {
            threshold: 0.15
        });

    document
        .querySelectorAll(".glass")
        .forEach(card => {

            observer.observe(card);

        });

    // ==========================
    // TOAST
    // ==========================

    const showToast = (
        message,
        type = "success"
    ) => {

        const toast =
            document.createElement("div");

        toast.className =
            `toast ${type}`;

        toast.innerHTML = `
            <span>${message}</span>
        `;

        document.body.appendChild(toast);

        setTimeout(() => {

            toast.classList.add("show");

        }, 50);

        setTimeout(() => {

            toast.classList.remove("show");

            setTimeout(() => {

                toast.remove();

            }, 300);

        }, 3000);

    };

    // contoh

    window.showToast = showToast;

    // ==========================
    // MENU HOVER EFFECT
    // ==========================

    document
        .querySelectorAll(
            ".menu-item, .help-item"
        )
        .forEach(item => {

            item.addEventListener(
                "mouseenter",
                () => {

                    item.style.transform =
                        "translateX(6px)";

                }
            );

            item.addEventListener(
                "mouseleave",
                () => {

                    item.style.transform =
                        "translateX(0)";

                }
            );

        });

});