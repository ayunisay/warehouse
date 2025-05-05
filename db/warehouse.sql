-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 04, 2025 at 05:04 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `warehouse`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_trail`
--

CREATE TABLE `audit_trail` (
  `id_audit` int(15) NOT NULL,
  `tanggal` date NOT NULL,
  `waktu` time NOT NULL,
  `nama_pengaju` varchar(255) NOT NULL,
  `aksi` varchar(255) NOT NULL,
  `detail` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `audit_trail`
--

INSERT INTO `audit_trail` (`id_audit`, `tanggal`, `waktu`, `nama_pengaju`, `aksi`, `detail`) VALUES
(132, '2025-04-30', '04:51:04', 'Unknown', 'Menghapus Supplier', 'Menghapus Supplier ID: 5'),
(133, '2025-04-30', '04:51:40', 'Unknown', 'Menambahkan Supplier', 'Menambahkan Supplier wings kontak 08874657148'),
(134, '2025-04-30', '04:56:54', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 26'),
(135, '2025-04-30', '04:57:09', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 24'),
(136, '2025-05-04', '02:26:27', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 27'),
(137, '2025-05-04', '02:26:38', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 9'),
(138, '2025-05-04', '02:26:41', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 10'),
(139, '2025-05-04', '02:26:56', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 25'),
(140, '2025-05-04', '03:00:53', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 25'),
(141, '2025-05-04', '03:01:02', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 27'),
(142, '2025-05-04', '03:01:35', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 27'),
(143, '2025-05-04', '03:01:46', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 28'),
(144, '2025-05-04', '03:17:19', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 28');

-- --------------------------------------------------------

--
-- Table structure for table `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rsk` int(15) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pending','Resolved','Rejected','') NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rsk`, `nama_barang`, `jumlah`, `deskripsi`, `status`, `tanggal`) VALUES
(27, 'ac', 23, 'pecah', 'Resolved', '2025-04-30 02:35:53'),
(28, 'ac', 23, 'sdasd', 'Rejected', '2025-04-30 02:36:05');

-- --------------------------------------------------------

--
-- Table structure for table `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(15) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`) VALUES
(27, 'rumah tangga'),
(28, 'elektronik');

-- --------------------------------------------------------

--
-- Table structure for table `masuk`
--

CREATE TABLE `masuk` (
  `id_keluar` int(15) NOT NULL,
  `id_barang` int(15) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah` int(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rak_barang`
--

CREATE TABLE `rak_barang` (
  `id_rak` int(15) NOT NULL,
  `lokasi` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `rak_barang`
--

INSERT INTO `rak_barang` (`id_rak`, `lokasi`) VALUES
(9, 'Rak A1'),
(10, 'Rak A2');

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `id_req` int(15) NOT NULL,
  `nama_pengaju` varchar(35) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `alasan` text NOT NULL,
  `status` enum('Pending','Approved','Rejected','') NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request`
--

INSERT INTO `request` (`id_req`, `nama_pengaju`, `nama_barang`, `jumlah`, `alasan`, `status`, `tanggal`) VALUES
(22, 'user', 'tv', 34, 'karna mau aja', 'Approved', '2025-04-30 02:24:30'),
(23, 'user', 'kulkas', 200, 'laku brok', 'Approved', '2025-04-30 02:24:34'),
(24, 'user', 'ac', 30, 'udah abis', 'Rejected', '2025-04-30 02:25:26'),
(25, 'user', 'ac', 30, 'lakuu', 'Approved', '2025-04-30 02:25:24'),
(26, 'user', 'ac', 30, 'lakuu', 'Approved', '2025-04-30 02:25:27'),
(27, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:25:16'),
(28, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:25:53'),
(29, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:25:56'),
(30, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:26:02'),
(31, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:27:11'),
(32, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:27:14'),
(33, 'user', 'ac', 30, 'lakuu', 'Pending', '2025-04-30 02:27:22'),
(34, 'user', 'tv', 20, 'lakuu', 'Pending', '2025-04-30 02:27:53');

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id_barang` int(15) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `id_kategori` int(15) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `id_rak` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id_barang`, `nama_barang`, `id_kategori`, `jumlah`, `id_rak`) VALUES
(28, 'ac', 27, 34, 9);

-- --------------------------------------------------------

--
-- Table structure for table `supplier`
--

CREATE TABLE `supplier` (
  `id_supp` int(15) NOT NULL,
  `nama_supp` varchar(255) NOT NULL,
  `kontak` int(15) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `supplier`
--

INSERT INTO `supplier` (`id_supp`, `nama_supp`, `kontak`, `alamat`) VALUES
(6, 'wings', 2147483647, 'cikarang timur laut');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'user', '$2y$10$diJEkGYUCKzDzqQUDRaHn.EBKpsyMPA40FO25ZumrWTcsOHIaeVLG', 'user'),
(4, 'admin', '$2y$10$BG1tF04SFDYO7fJuiGXaOutM5UDYYoB9Pqzj.1T29ayFEkHZqIwgm', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indexes for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rsk`);

--
-- Indexes for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `masuk`
--
ALTER TABLE `masuk`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indexes for table `rak_barang`
--
ALTER TABLE `rak_barang`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_req`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD UNIQUE KEY `nama_kategori` (`id_kategori`),
  ADD UNIQUE KEY `lokasi` (`id_rak`),
  ADD UNIQUE KEY `lokasi_2` (`id_rak`);

--
-- Indexes for table `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supp`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id_audit` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=145;

--
-- AUTO_INCREMENT for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  MODIFY `id_barang_rsk` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `masuk`
--
ALTER TABLE `masuk`
  MODIFY `id_keluar` int(15) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rak_barang`
--
ALTER TABLE `rak_barang`
  MODIFY `id_rak` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id_req` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id_barang` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supp` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD CONSTRAINT `stok_barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_barang_ibfk_2` FOREIGN KEY (`id_rak`) REFERENCES `rak_barang` (`id_rak`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
