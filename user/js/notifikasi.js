'use strict';

/* =========================
   FILTER BUTTON
========================= */

const filterButtons =
document.querySelectorAll('.filter-btn');

filterButtons.forEach((btn) => {

    btn.addEventListener('click', () => {

        filterButtons.forEach((b) => {

            b.classList.remove('active');
        });

        btn.classList.add('active');
    });
});

/* =========================
   MARK AS READ
========================= */

const readAllBtn =
document.querySelector('.read-all-btn');

const unreadCards =
document.querySelectorAll('.notification-card.unread');

if (readAllBtn){

    readAllBtn.addEventListener(
        'click',
        () => {

            unreadCards.forEach((card) => {

                card.classList.remove('unread');

                const dot =
                card.querySelector('.notif-dot');

                if (dot){

                    dot.remove();
                }
            });
        }
    );
}

/* =========================
   ACTION BUTTON
========================= */

const notifButtons =
document.querySelectorAll('.notif-btn');

notifButtons.forEach((btn) => {

    btn.addEventListener('click', () => {

        window.location.href =
        'pesanan.html';
    });
});