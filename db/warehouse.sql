-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 30, 2025 at 05:06 AM
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
(135, '2025-04-30', '04:57:09', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 24');

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
(25, 'rumah tangga'),
(26, 'rumah tangga2');

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
(8, 'Rak A1'),
(7, 'Rak A2');

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
  `id_stok` int(15) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `lokasi` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id_stok`, `nama_barang`, `nama_kategori`, `jumlah`, `lokasi`) VALUES
(22, 'tv', 'rumah tangga', 23, 'Rak A1'),
(24, 'ac', 'rumah tangga2', 22, 'Rak A2');

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
(3, 'user', 'user123', 'user'),
(4, 'admin', 'admin123', 'admin');

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
  ADD PRIMARY KEY (`id_kategori`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `rak_barang`
--
ALTER TABLE `rak_barang`
  ADD PRIMARY KEY (`id_rak`),
  ADD UNIQUE KEY `lokasi` (`lokasi`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_req`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id_stok`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`),
  ADD UNIQUE KEY `lokasi` (`lokasi`),
  ADD UNIQUE KEY `lokasi_2` (`lokasi`);

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
  MODIFY `id_audit` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=136;

--
-- AUTO_INCREMENT for table `barang_rusak`
--
ALTER TABLE `barang_rusak`
  MODIFY `id_barang_rsk` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `rak_barang`
--
ALTER TABLE `rak_barang`
  MODIFY `id_rak` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `id_req` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id_stok` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

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
  ADD CONSTRAINT `stok_barang_ibfk_3` FOREIGN KEY (`nama_kategori`) REFERENCES `kategori_barang` (`nama_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_barang_ibfk_4` FOREIGN KEY (`lokasi`) REFERENCES `rak_barang` (`lokasi`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
