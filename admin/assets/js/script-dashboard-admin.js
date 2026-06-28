'use strict';

/* =========================
   ACTIVE SIDEBAR
========================= */

document.addEventListener('DOMContentLoaded', () => {

    const navLinks =
    document.querySelectorAll('.sidebar nav a');

    navLinks.forEach(link => {

        link.addEventListener('click', () => {

            navLinks.forEach(item => {
                item.classList.remove('active');
            });

            link.classList.add('active');

        });

    });

});

/* =========================
   SIDEBAR MOBILE
========================= */

const sidebarToggle =
document.getElementById('sidebarToggle');

const sidebar =
document.getElementById('sidebar');

if(sidebarToggle && sidebar){

    sidebarToggle.addEventListener('click', () => {

        sidebar.classList.toggle('show');

    });

}

/* =========================
   RIPPLE EFFECT
========================= */

document.querySelectorAll('.glass-btn')
.forEach(button => {

    button.addEventListener('click', function(e){

        const ripple =
        document.createElement('span');

        ripple.classList.add('ripple');

        const rect =
        this.getBoundingClientRect();

        ripple.style.left =
        `${e.clientX - rect.left}px`;

        ripple.style.top =
        `${e.clientY - rect.top}px`;

        this.appendChild(ripple);

        setTimeout(() => {

            ripple.remove();

        }, 600);

    });

});

/* =========================
   FORMAT
========================= */

function formatNumber(num){

    return Number(num)
    .toLocaleString('id-ID');

}

function formatCurrency(num){

    return 'Rp ' +
    Number(num)
    .toLocaleString('id-ID');

}

/* =========================
   COUNTER
========================= */

function animateCounter(element, target){

    let current = 0;

    const increment =
    Math.ceil(target / 40);

    const update = () => {

        current += increment;

        if(current >= target){

            element.textContent =
            formatNumber(target);

            return;
        }

        element.textContent =
        formatNumber(current);

        requestAnimationFrame(update);

    };

    update();

}

function animateCurrency(element, target){

    let current = 0;

    const increment =
    Math.ceil(target / 40);

    const update = () => {

        current += increment;

        if(current >= target){

            element.textContent =
            formatCurrency(target);

            return;
        }

        element.textContent =
        formatCurrency(current);

        requestAnimationFrame(update);

    };

    update();

}



/* =========================
   CHART ANIMATION
========================= */

const polyline =
document.querySelector(
    'incomeChartLine'
);

if(polyline){

    const length =
    polyline.getTotalLength();

    polyline.style.strokeDasharray =
    length;

    polyline.style.strokeDashoffset =
    length;

    setTimeout(() => {

        polyline.style.transition =
        '2s ease';

        polyline.style.strokeDashoffset =
        '0';

    }, 300);

}

/* =========================
   NOTIFICATION
========================= */

const notifBtn =
document.getElementById('notifBtn');

if(notifBtn){

    notifBtn.addEventListener('click', () => {

        window.location.href =
        'notifications-admin.php';

    });

}

/* =========================
   PAGE FADE
========================= */

document.body.style.opacity = '0';

document.body.style.transition =
'.4s ease';

window.addEventListener('load', () => {

    document.body.style.opacity = '1';

});


function renderRevenueChart(data){

    document.getElementById(
        "weeklyIncome"
    ).textContent =
    "Rp " +
    Number(
        data.total
    ).toLocaleString(
        "id-ID"
    );

    document.getElementById(
        "incomeGrowth"
    ).innerHTML =

    `<i class="fa-solid fa-arrow-trend-up"></i>

    ${data.growth}%`;

    const values =
    data.chart;

    const max =
    Math.max(
        ...values,1);
    const width = 600;
    const height = 300;

    const padding = 30;

    const step =
    width /
    (
        values.length-1
    );

    let points="";

    values.forEach(

        (value,index)=>{

            const x =
            index * step;
            
            const y =
                height -
                padding -
                (
                    value / max
                ) * (height - padding * 2);

            points +=
            `${x},${y} `;

        }

    );

    document
    .getElementById(
        "incomeChartLine"
    )
    .setAttribute(
        "points",
        points
    );

    const labels =
    document.getElementById(
        "chartLabels"
    );

    labels.innerHTML="";

    data.labels.forEach(

        label=>{

            labels.innerHTML +=

            `<span>

                ${label}

            </span>`;

        }

    );

}



/* =========================
   LOAD DASHBOARD
========================= */

async function loadDashboard(){

    try{

        const response =
        await fetch(
            './api/dashboard-stats.php'
        );

        const data =
        await response.json();

        if(!data.success){

            console.error(data);

            return;

        }

        animateCounter(
            document.getElementById('totalProducts'),
            Number(data.totalProducts)
        );

        animateCounter(
            document.getElementById('totalUsers'),
            Number(data.totalUsers)
        );

        animateCounter(
            document.getElementById('availableStock'),
            Number(data.availableStock)
        );

        animateCurrency(
            document.getElementById('totalIncome'),
            Number(data.totalIncome)
        );

        if(data.revenue){

    renderRevenueChart(
        data.revenue
    );
    renderCategoryChart(
    data.categoryChart
);

}

        /* =========================
           ORDERS
        ========================= */

const ordersTable =
document.getElementById('latestOrdersTable');

if(ordersTable){

    ordersTable.innerHTML = '';

    data.latestOrders.forEach(order => {

        const status =
        order.status
        .trim()
        .toLowerCase();

        const badgeMap = {
            pending: 'pending',
            disewa: 'success',
            selesai: 'success',
            dibatalkan: 'cancel'
        };

        const badgeClass =
        badgeMap[status] || 'pending';

        ordersTable.innerHTML += `
            <tr>
                <td>${order.customer}</td>
                <td>${order.product}</td>
                <td>
                    <span class="badge ${badgeClass}">
                        ${order.status}
                    </span>
                </td>
            </tr>
        `;

    });

}

        /* =========================
           REMINDER
        ========================= */

        const reminder =
        document.getElementById(
            'reminderContainer'
        );

        if(reminder){

            reminder.innerHTML = '';

            data.returnReminders.forEach(item => {

                reminder.innerHTML += `
                    <div class="reminder-item">

                        <h4>
                            ${item.customer}
                        </h4>

                        <p>
                            Kembali :
                            ${item.tanggal_kembali}
                        </p>

                    </div>
                `;

            });

        }

    }

    catch(error){

        console.error(
            'Dashboard Error:',
            error
        );

    }

}

function renderCategoryChart(data){

    if(!data.length) return;

    const total =
    data.reduce(
        (sum,item)=>
        sum+item.total,
        0
    );

    const colors=[
        "#4F46E5",
        "#06B6D4",
        "#10B981",
        "#F59E0B"
    ];

    let current=0;

    const gradients=[];

    const list=
    document.getElementById(
        "categoryList"
    );

    list.innerHTML="";

    data.forEach((item,index)=>{

        const percent=
        (
            item.total/
            total
        )*100;

        gradients.push(

            `${colors[index]}
            ${current}% 
            ${current+percent}%`

        );

        current+=percent;

        list.innerHTML+=`

        <div class="category-item">

            <div class="category-left">

                <span
                class="color-dot"
                style="
                background:${colors[index]}
                "></span>

                <p>${item.name}</p>

            </div>

            <strong>

                ${percent.toFixed(1)}%

            </strong>

        </div>

        `;

    });

    document.getElementById(
        "donutChart"
    ).style.background=

    `conic-gradient(

        ${gradients.join(",")}

    )`;

    document.getElementById(
        "donutPercent"
    ).innerText=

    Math.round(

        (
            data[0].total/
            total
        )*100

    )+"%";

}

loadDashboard();

/* =========================
   RIPPLE STYLE
========================= */

const style =
document.createElement('style');

style.innerHTML = `

button{
    position:relative;
    overflow:hidden;
}

.ripple{
    position:absolute;
    width:10px;
    height:10px;
    border-radius:50%;
    transform:translate(-50%, -50%);
    animation:rippleEffect .6s linear;
    background:rgba(255,255,255,.4);
}

@keyframes rippleEffect{

    from{
        width:0;
        height:0;
        opacity:1;
    }

    to{
        width:400px;
        height:400px;
        opacity:0;
    }

}
`;

document.head.appendChild(style);