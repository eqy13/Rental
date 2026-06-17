-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jun 17, 2026 at 04:40 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rental`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `foto` varchar(255) DEFAULT 'default-admin.png',
  `last_login` datetime DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`id`, `nama_lengkap`, `email`, `password`, `foto`, `last_login`, `created_at`) VALUES
(1, 'kelompok 6 kece', 'kelompok6@gmail.com', '$2y$10$Cy2lOPqViloiteAbrC2Z2ufasAhq8tJav52txeGym7WV7il9j9qsi', '1781624652_1781419349_kategori-drone.jpeg', '2026-06-17 09:33:32', '2026-06-08 04:37:22');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `icon` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`, `icon`, `created_at`) VALUES
(2, 'Carrier', 'cat_6a2975db89a75.jpeg', '2026-06-07 13:14:45'),
(3, 'Sleeping', 'cat_6a2975fc7f9b1.jpeg', '2026-06-07 13:14:45'),
(4, 'DSLR', 'cat_6a29790820f5e.jpeg', '2026-06-07 13:14:45'),
(5, 'Mirrorless', 'cat_6a29791bd6f05.png', '2026-06-07 13:14:45'),
(6, 'Drone', 'cat_6a2975e589e3f.jpeg', '2026-06-07 13:14:45'),
(7, 'Lensa', 'cat_6a2979104aac8.jpeg', '2026-06-07 13:14:45'),
(8, 'Lighting', 'cat_6a2975ef99513.jpeg', '2026-06-07 13:14:45'),
(10, 'Tripod', 'cat_6a29760b3b3b7.png', '2026-06-09 08:11:36'),
(11, 'Tenda', 'cat_6a29761edf7b8.jpeg', '2026-06-10 14:35:10'),
(12, 'kursi', 'cat_6a2e3be53f412.png', '2026-06-14 05:28:05');

-- --------------------------------------------------------

--
-- Table structure for table `likes`
--

CREATE TABLE `likes` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `product_id` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `likes`
--

INSERT INTO `likes` (`id`, `user_id`, `product_id`, `created_at`) VALUES
(3, 5, 3, '2026-06-16 13:25:27'),
(4, 5, 2, '2026-06-16 13:25:32'),
(5, 5, 1, '2026-06-16 13:25:33');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int NOT NULL,
  `rental_id` int NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `bukti_pembayaran` varchar(255) DEFAULT NULL,
  `status` enum('menunggu','diterima','ditolak') DEFAULT 'menunggu',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `rental_id`, `metode_pembayaran`, `bukti_pembayaran`, `status`, `created_at`) VALUES
(1, 1, 'cash', NULL, 'diterima', '2026-06-15 04:12:11'),
(2, 2, 'bank', NULL, 'ditolak', '2026-06-15 04:23:56'),
(3, 3, 'cash', NULL, 'diterima', '2026-06-16 11:45:34'),
(4, 4, 'bank', NULL, 'diterima', '2026-06-16 11:46:32'),
(5, 5, 'cash', NULL, 'ditolak', '2026-06-16 11:52:14'),
(6, 6, 'cash', NULL, 'diterima', '2026-06-16 12:11:52'),
(7, 7, 'bank', '1781615444_1781528345_1781419506_1781419349_kategori-drone.jpeg', 'diterima', '2026-06-16 13:10:44'),
(8, 8, 'cash', NULL, 'diterima', '2026-06-16 13:23:02'),
(9, 9, 'cash', NULL, 'diterima', '2026-06-16 13:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int NOT NULL,
  `category_id` int NOT NULL,
  `nama_produk` varchar(150) NOT NULL,
  `deskripsi` text,
  `spesifikasi` text,
  `include_item` text,
  `harga_sewa` decimal(12,2) NOT NULL,
  `stok` int DEFAULT '0',
  `kondisi` enum('baik','rusak_ringan','rusak_berat') DEFAULT 'baik',
  `status` enum('tersedia','maintenance') DEFAULT 'tersedia',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `deposit` decimal(12,2) DEFAULT '0.00'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `deskripsi`, `spesifikasi`, `include_item`, `harga_sewa`, `stok`, `kondisi`, `status`, `created_at`, `deposit`) VALUES
(1, 2, 'tas', 'alus pokokna', 'geede\r\ntahan lama', 'apa aja', '100000.00', 1, 'baik', 'tersedia', '2026-06-07 13:30:38', '200000.00'),
(2, 4, 'kamera', 'apa lah', '1 aja', 'dasdasd, sadasd', '150000.00', 4, 'baik', 'maintenance', '2026-06-07 13:46:34', '100000.00'),
(3, 11, 'Tenda', 'bagus banget, saya sampaikan hari ini saya akan lawan', 'gacor\r\nbagus\r\nmantap\r\nkeren\r\napalagi', 'apa, aja, yang, kalian, mau', '200000.00', 6, 'rusak_ringan', 'tersedia', '2026-06-10 15:19:03', '150000.00'),
(5, 2, 'asdasd', '', '', '', '100.00', 0, 'baik', 'tersedia', '2026-06-16 14:08:53', '123123.00');

-- --------------------------------------------------------

--
-- Table structure for table `product_images`
--

CREATE TABLE `product_images` (
  `id` int NOT NULL,
  `product_id` int NOT NULL,
  `gambar` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `product_images`
--

INSERT INTO `product_images` (`id`, `product_id`, `gambar`) VALUES
(1, 2, '1780839994_6a25763ae76be.jpg'),
(2, 1, '1781092324_6a294fe43d5e3.jpg'),
(3, 3, '1781104743_6a298067cbddb.jpeg'),
(4, 3, '1781104743_6a298067ce509.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `rentals`
--

CREATE TABLE `rentals` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `tanggal_sewa` date NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `total_harga` decimal(12,2) DEFAULT NULL,
  `status` enum('pending','disewa','selesai','dibatalkan') NOT NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rentals`
--

INSERT INTO `rentals` (`id`, `user_id`, `tanggal_sewa`, `tanggal_kembali`, `total_harga`, `status`, `created_at`) VALUES
(1, 2, '2026-06-14', '2026-06-16', '950000.00', 'selesai', '2026-06-15 04:12:11'),
(2, 2, '2026-06-14', '2026-06-15', '200000.00', 'dibatalkan', '2026-06-15 04:23:56'),
(3, 3, '2026-06-16', '2026-06-17', '200000.00', 'selesai', '2026-06-16 11:45:34'),
(4, 3, '2026-06-17', '2026-06-17', '200000.00', 'selesai', '2026-06-16 11:46:32'),
(5, 3, '2026-06-16', '2026-06-16', '200000.00', 'dibatalkan', '2026-06-16 11:52:14'),
(6, 3, '2026-06-17', '2026-06-18', '200000.00', 'selesai', '2026-06-16 12:11:52'),
(7, 3, '2026-06-16', '2026-06-17', '100000.00', 'selesai', '2026-06-16 13:10:44'),
(8, 5, '2026-06-16', '2026-06-17', '200000.00', 'selesai', '2026-06-16 13:23:02'),
(9, 5, '2026-06-16', '2026-06-17', '150000.00', 'disewa', '2026-06-16 13:58:10');

-- --------------------------------------------------------

--
-- Table structure for table `rental_details`
--

CREATE TABLE `rental_details` (
  `id` int NOT NULL,
  `rental_id` int NOT NULL,
  `product_id` int NOT NULL,
  `qty` int NOT NULL,
  `harga` decimal(12,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `rental_details`
--

INSERT INTO `rental_details` (`id`, `rental_id`, `product_id`, `qty`, `harga`) VALUES
(1, 1, 3, 2, '200000.00'),
(2, 2, 3, 1, '200000.00'),
(3, 3, 3, 1, '200000.00'),
(4, 4, 3, 1, '200000.00'),
(5, 5, 3, 1, '200000.00'),
(6, 6, 3, 1, '200000.00'),
(7, 7, 1, 1, '100000.00'),
(8, 8, 3, 1, '200000.00'),
(9, 9, 2, 1, '150000.00');

-- --------------------------------------------------------

--
-- Table structure for table `returns`
--

CREATE TABLE `returns` (
  `id` int NOT NULL,
  `rental_id` int NOT NULL,
  `kondisi_barang` varchar(50) DEFAULT NULL,
  `hari_terlambat` int DEFAULT '0',
  `denda` decimal(12,2) DEFAULT '0.00',
  `tanggal_pengembalian` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `returns`
--

INSERT INTO `returns` (`id`, `rental_id`, `kondisi_barang`, `hari_terlambat`, `denda`, `tanggal_pengembalian`) VALUES
(1, 1, 'hilang', 0, '1000000.00', '2026-06-15 11:17:24'),
(2, 3, 'hilang', 0, '1000000.00', '2026-06-16 18:45:59'),
(3, 4, 'rusak_berat', 0, '300000.00', '2026-06-16 18:47:13'),
(4, 4, 'rusak_berat', 0, '300000.00', '2026-06-16 20:14:40'),
(5, 7, 'baik', 0, '0.00', '2026-06-16 20:15:07'),
(6, 6, 'baik', 0, '0.00', '2026-06-16 20:43:10'),
(7, 8, 'baik', 0, '0.00', '2026-06-16 20:43:38');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `nomor_hp` varchar(20) NOT NULL,
  `alamat` text,
  `password` varchar(255) NOT NULL,
  `foto_profil` varchar(255) DEFAULT 'default-user.png',
  `role` enum('admin','user') DEFAULT 'user',
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama_lengkap`, `email`, `nomor_hp`, `alamat`, `password`, `foto_profil`, `role`, `status`, `created_at`, `updated_at`) VALUES
(1, 'eqy', 'eqy@gmail.com', '23425345242', 'asddfgfdfgergdf', '$2y$10$HXEFB1hQAFAI8yFDcWAWRueZMbWD7PVst7uuBDmiDsKaeWr7m6tuq', '1780813880_6a2510388c3d8.jpg', 'user', 'aktif', '2026-06-03 11:19:45', '2026-06-14 07:48:06'),
(2, 'syaputra', 'syaputra@gmail.com', '089857834234', 'cimanuk', '$2y$10$Uk96qx0UHWc4TPIJ37aYKeD5r4/4PuZjWe7nnk/EqHRvzy2rrC7Ne', '1781499784_6a2f8788773f0.png', 'user', 'aktif', '2026-06-14 12:43:57', '2026-06-15 05:03:04'),
(3, 'putri', 'putri@gmail.com', '0239840956', 'wanaraja', '$2y$10$8AzhvqilMhMrSxWt/WVTCOQEpDAb5v.LAnfS18m7FwoRW9Izw66lK', '1781499751_6a2f87673744c.png', 'user', 'aktif', '2026-06-15 04:30:02', '2026-06-15 05:02:31'),
(5, 'elqy', 'elqy@gmail.com', '08679584723', 'pajajaran', '$2y$10$1GM./j6JC8GG2WzHXpO8ueOyTC8O7OrZ63k1U66MJn90ZrC9En4X.', 'default-user.png', 'user', 'aktif', '2026-06-16 13:18:08', '2026-06-16 13:18:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `likes`
--
ALTER TABLE `likes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_like` (`user_id`,`product_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_images`
--
ALTER TABLE `product_images`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `rentals`
--
ALTER TABLE `rentals`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rental_details`
--
ALTER TABLE `rental_details`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_id` (`rental_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `returns`
--
ALTER TABLE `returns`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rental_id` (`rental_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `likes`
--
ALTER TABLE `likes`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `product_images`
--
ALTER TABLE `product_images`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `rentals`
--
ALTER TABLE `rentals`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `rental_details`
--
ALTER TABLE `rental_details`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `returns`
--
ALTER TABLE `returns`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `likes`
--
ALTER TABLE `likes`
  ADD CONSTRAINT `likes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `likes_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`);

--
-- Constraints for table `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `product_images`
--
ALTER TABLE `product_images`
  ADD CONSTRAINT `product_images_ibfk_1` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `rentals`
--
ALTER TABLE `rentals`
  ADD CONSTRAINT `rentals_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `rental_details`
--
ALTER TABLE `rental_details`
  ADD CONSTRAINT `rental_details_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rental_details_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`);

--
-- Constraints for table `returns`
--
ALTER TABLE `returns`
  ADD CONSTRAINT `returns_ibfk_1` FOREIGN KEY (`rental_id`) REFERENCES `rentals` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
