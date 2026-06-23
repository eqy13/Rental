<?php

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once '../config/db.php';

try {

    /*
    |--------------------------------------------------------------------------
    | TOTAL PRODUK
    |--------------------------------------------------------------------------
    */

    $stmtProducts = $pdo->query("
        SELECT COUNT(*) AS total
        FROM products
    ");

    $totalProducts = (int) $stmtProducts->fetch()['total'];

    /*
    |--------------------------------------------------------------------------
    | TOTAL USER
    |--------------------------------------------------------------------------
    */

    $stmtUsers = $pdo->query("
        SELECT COUNT(*) AS total
        FROM users
        WHERE role = 'user'
    ");

    $totalUsers = (int) $stmtUsers->fetch()['total'];

    /*
    |--------------------------------------------------------------------------
    | TOTAL STOK TERSEDIA
    |--------------------------------------------------------------------------
    */

    $stmtStock = $pdo->query("
        SELECT COALESCE(SUM(stok),0) AS total
        FROM products
        WHERE status = 'tersedia'
    ");

    $availableStock = (int) $stmtStock->fetch()['total'];

    /*
    |--------------------------------------------------------------------------
    | TOTAL PENDAPATAN
    |--------------------------------------------------------------------------
    */

        $stmtIncome = $pdo->query("
            SELECT
                COALESCE(SUM(r.total_harga),0)
                +
                COALESCE(SUM(rt.denda),0) AS total
            FROM rentals r
            LEFT JOIN returns rt
                ON rt.rental_id = r.id
            WHERE r.status = 'selesai'
        ");

    $totalIncome = (float) $stmtIncome->fetch()['total'];

    /*
    |--------------------------------------------------------------------------
    | PESANAN TERBARU
    |--------------------------------------------------------------------------
    */

    $stmtOrders = $pdo->query("
        SELECT

            COALESCE(
                r.nama_pelanggan,
                u.nama_lengkap
            ) AS customer,

            p.nama_produk AS product_name,

            r.status

        FROM rentals r

        LEFT JOIN users u
            ON u.id = r.user_id

        INNER JOIN rental_details rd
            ON rd.rental_id = r.id

        INNER JOIN products p
            ON p.id = rd.product_id

        ORDER BY r.created_at DESC
        LIMIT 10
    ");

    $latestOrders = [];

    while ($row = $stmtOrders->fetch()) {

        $latestOrders[] = [
            'customer' => $row['customer'],
            'product'  => $row['product_name'],
            'status'   => $row['status']
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | REMINDER PENGEMBALIAN
    |--------------------------------------------------------------------------
    */

    $stmtReminder = $pdo->query("
        SELECT

            COALESCE(
                r.nama_pelanggan,
                u.nama_lengkap
            ) AS customer,

            r.tanggal_kembali

        FROM rentals r

        LEFT JOIN users u
            ON u.id = r.user_id

        WHERE r.status IN (
            'disewa'
        )

        ORDER BY r.tanggal_kembali ASC
        LIMIT 10
    ");

    $returnReminders = [];

    while ($row = $stmtReminder->fetch()) {

        $returnReminders[] = [
            'customer' => $row['customer'],
            'tanggal_kembali' => date(
                'd-m-Y',
                strtotime($row['tanggal_kembali'])
            )
        ];
    }

    /*


/*
|--------------------------------------------------------------------------
| REVENUE 7 HARI TERAKHIR
|--------------------------------------------------------------------------
*/

$labels = [];
$chart = [];

for($i = 6; $i >= 0; $i--){

    $tanggal = date(
        'Y-m-d',
        strtotime("-$i days")
    );

    $labels[] = date(
        'd M',
        strtotime($tanggal)
    );

    $stmt = $pdo->prepare("
    SELECT
        COALESCE(SUM(r.total_harga),0)
        +
        COALESCE(SUM(rt.denda),0) AS total
    FROM rentals r
    LEFT JOIN returns rt
        ON rt.rental_id = r.id
    WHERE DATE(r.created_at)=?
    AND r.status IN(
        'disewa',
        'selesai'
    )
    ");

    $stmt->execute([
        $tanggal
    ]);

    $chart[] =
    (float)$stmt->fetch()['total'];

}


$stmt = $pdo->query("
SELECT
COALESCE(SUM(total_harga),0) total
FROM rentals
WHERE status IN(
'disewa',
'selesai'
)
AND created_at >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
");

$thisWeek =
$stmt->fetch()['total'];

$stmt = $pdo->query("
SELECT
COALESCE(SUM(total_harga),0) total
FROM rentals
WHERE status IN(
'disewa',
'selesai'
)
AND created_at BETWEEN
DATE_SUB(CURDATE(),INTERVAL 14 DAY)
AND DATE_SUB(CURDATE(),INTERVAL 7 DAY)
");

$lastWeek =
$stmt->fetch()['total'];

$growth = 0;

if($lastWeek > 0){

    $growth =
    round(
        (
            (
                $thisWeek -
                $lastWeek
            )
            /
            $lastWeek
        ) * 100,
        1
    );

}

$stmt = $pdo->query("
SELECT
COALESCE(SUM(total_harga),0) total
FROM rentals
WHERE status IN(
'disewa',
'selesai'
)
AND created_at >= DATE_SUB(CURDATE(),INTERVAL 7 DAY)
");

$thisWeek =
$stmt->fetch()['total'];

$stmt = $pdo->query("
SELECT
COALESCE(SUM(total_harga),0) total
FROM rentals
WHERE status IN(
'disewa',
'selesai'
)
AND created_at BETWEEN
DATE_SUB(CURDATE(),INTERVAL 14 DAY)
AND DATE_SUB(CURDATE(),INTERVAL 7 DAY)
");

$lastWeek =
$stmt->fetch()['total'];

$growth = 0;

if($lastWeek > 0){

    $growth =
    round(
        (
            (
                $thisWeek -
                $lastWeek
            )
            /
            $lastWeek
        ) * 100,
        1
    );

}

$stmt = $pdo->query("

SELECT

categories.nama_kategori,

SUM(rental_details.qty) total

FROM rental_details

JOIN products
ON products.id=rental_details.product_id

JOIN categories
ON categories.id=products.category_id

GROUP BY categories.id

ORDER BY total DESC

LIMIT 4

");

$categoriesChart=[];

while($row=$stmt->fetch()){

    $categoriesChart[]=[

        "name"=>$row['nama_kategori'],

        "total"=>(int)$row['total']

    ];

}

$revenue = [

    "total" => $totalIncome,

    "growth" => $growth,

    "labels" => $labels,

    "chart" => $chart

];


    /*
    |--------------------------------------------------------------------------
    | RESPONSE
    |--------------------------------------------------------------------------
    */

echo json_encode([

    'success'=>true,

    'totalProducts'=>$totalProducts,

    'totalUsers'=>$totalUsers,

    'availableStock'=>$availableStock,

    'totalIncome'=>$totalIncome,

    'revenue'=>$revenue,

    'latestOrders'=>$latestOrders,

    'returnReminders'=>$returnReminders,

    'categoryChart'=>$categoriesChart

]);



} catch (PDOException $e) {

    http_response_code(500);

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);

}