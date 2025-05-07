-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Bulan Mei 2025 pada 05.32
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

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
-- Struktur dari tabel `audit_trail`
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
-- Dumping data untuk tabel `audit_trail`
--

INSERT INTO `audit_trail` (`id_audit`, `tanggal`, `waktu`, `nama_pengaju`, `aksi`, `detail`) VALUES
(178, '2025-05-06', '15:56:29', 'user', 'Melaporkan Kerusakan', 'Melaporkan kerusakan untuk 28 dengan jumlah 2 dan deskripsi: rusak'),
(179, '2025-05-06', '18:36:08', 'Unknown', 'Menolak Laporan Kerusakan', 'Admin menolak laporan kerusakan ID: 31'),
(180, '2025-05-06', '18:36:13', 'admin', 'Menghapus Riwayat Laporan Kerusakan Barang', 'Menghapus Riwayat Laporan Kerusakan Barang ID: '),
(181, '2025-05-06', '18:36:17', 'admin', 'Menghapus Riwayat Laporan Kerusakan Barang', 'Menghapus Riwayat Laporan Kerusakan Barang ID: '),
(182, '2025-05-06', '18:43:00', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 28'),
(183, '2025-05-06', '18:50:22', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 29'),
(184, '2025-05-06', '18:50:39', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 30'),
(185, '2025-05-06', '18:50:45', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 31'),
(186, '2025-05-06', '18:51:01', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 32'),
(187, '2025-05-06', '18:51:16', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 33'),
(188, '2025-05-06', '18:51:24', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 34'),
(189, '2025-05-06', '18:51:32', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 35'),
(190, '2025-05-06', '18:52:19', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 36'),
(191, '2025-05-06', '18:52:33', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 37'),
(192, '2025-05-06', '18:52:43', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 38'),
(193, '2025-05-06', '18:52:49', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 39'),
(194, '2025-05-06', '18:52:58', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 40'),
(195, '2025-05-06', '18:53:13', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 41'),
(196, '2025-05-06', '18:53:47', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 42'),
(197, '2025-05-06', '18:53:51', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 43'),
(198, '2025-05-06', '18:54:11', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 44'),
(199, '2025-05-06', '18:54:18', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 45'),
(200, '2025-05-06', '18:54:30', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 46'),
(201, '2025-05-06', '18:54:44', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 47'),
(202, '2025-05-06', '18:54:52', 'Unknown', 'Menambahkan Kategori', 'Menambahkan Kategori ID: 48'),
(203, '2025-05-06', '18:55:15', 'Unknown', 'Menghapus Rak', 'Menghapus Rak ID: 9'),
(204, '2025-05-06', '18:55:23', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 12'),
(205, '2025-05-06', '18:55:50', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 13'),
(206, '2025-05-06', '18:55:56', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 14'),
(207, '2025-05-06', '18:56:02', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 15'),
(208, '2025-05-06', '18:56:26', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 16'),
(209, '2025-05-06', '18:56:30', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 17'),
(210, '2025-05-06', '18:56:33', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 18'),
(211, '2025-05-06', '18:56:38', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 19'),
(212, '2025-05-06', '18:56:47', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 20'),
(213, '2025-05-06', '18:56:51', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 21'),
(214, '2025-05-06', '18:56:54', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 22'),
(215, '2025-05-06', '18:59:23', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 33'),
(216, '2025-05-06', '18:59:55', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 34'),
(217, '2025-05-06', '19:00:13', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 35'),
(218, '2025-05-06', '19:02:58', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 23'),
(219, '2025-05-06', '19:03:02', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 24'),
(220, '2025-05-06', '19:03:27', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 36'),
(221, '2025-05-06', '19:03:49', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 37'),
(222, '2025-05-06', '19:04:38', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 34'),
(223, '2025-05-06', '19:04:42', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 35'),
(224, '2025-05-06', '19:04:45', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 36'),
(225, '2025-05-06', '19:04:48', 'Unknown', 'Menghapus barang', 'Menghapus barang ID: 37'),
(226, '2025-05-06', '19:05:12', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 38'),
(227, '2025-05-06', '19:05:40', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 39'),
(228, '2025-05-06', '19:05:59', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 40'),
(229, '2025-05-06', '19:06:31', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 41'),
(230, '2025-05-06', '19:06:46', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 25'),
(231, '2025-05-06', '19:07:07', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 42'),
(232, '2025-05-06', '19:08:06', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 43'),
(233, '2025-05-06', '19:08:32', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 44'),
(234, '2025-05-06', '19:09:06', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 45'),
(235, '2025-05-06', '19:09:32', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 26'),
(236, '2025-05-06', '19:09:40', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 27'),
(237, '2025-05-06', '19:09:43', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 28'),
(238, '2025-05-06', '19:10:07', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 46'),
(239, '2025-05-06', '19:10:36', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 47'),
(240, '2025-05-06', '19:10:59', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 48'),
(241, '2025-05-06', '19:11:20', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 49'),
(242, '2025-05-06', '19:11:38', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 50'),
(243, '2025-05-06', '19:12:30', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 51'),
(244, '2025-05-06', '19:12:44', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 52'),
(245, '2025-05-06', '19:13:03', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 53'),
(246, '2025-05-06', '19:13:23', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 54'),
(247, '2025-05-06', '19:13:45', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 55'),
(248, '2025-05-06', '19:14:13', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 29'),
(249, '2025-05-06', '19:14:16', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 30'),
(250, '2025-05-06', '19:14:20', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 31'),
(251, '2025-05-06', '19:14:43', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 56'),
(252, '2025-05-06', '19:15:00', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 57'),
(253, '2025-05-06', '19:15:16', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 58'),
(254, '2025-05-06', '19:15:49', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 32'),
(255, '2025-05-06', '19:15:52', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 33'),
(256, '2025-05-06', '19:15:55', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 34'),
(257, '2025-05-06', '19:15:58', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 35'),
(258, '2025-05-06', '19:16:01', 'Unknown', 'Menambahkan Rak', 'Menambahkan Rak ID: 36'),
(259, '2025-05-06', '19:16:25', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 59'),
(260, '2025-05-06', '19:16:42', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 60'),
(261, '2025-05-06', '19:17:06', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 61'),
(262, '2025-05-06', '19:17:39', 'Unknown', 'Menambahkan barang', 'Menambahkan barang ID: 62'),
(263, '2025-05-06', '19:18:03', 'Unknown', 'Memperbarui Supplier', 'Memperbarui Supplier toko laris kontak 08854637182'),
(264, '2025-05-06', '19:18:20', 'Unknown', 'Memperbarui Supplier', 'Memperbarui Supplier veldora kontak 08623645372'),
(265, '2025-05-06', '19:18:31', 'Unknown', 'Memperbarui Supplier', 'Memperbarui Supplier wings kontak 0662837491'),
(266, '2025-05-06', '19:22:29', 'Unknown', 'Mengajukan Permintaan', 'User mengajukan permintaan untuk Benang Nilon jumlah 30'),
(267, '2025-05-06', '19:22:51', 'Unknown', 'Mengajukan Permintaan', 'User mengajukan permintaan untuk Rivet Logam jumlah 30'),
(268, '2025-05-06', '19:23:10', 'Unknown', 'Menyetujui Permintaan', 'Admin menyetujui permintaan ID: 36'),
(269, '2025-05-06', '19:23:13', 'Unknown', 'Menolak Permintaan', 'Admin Menolak permintaan ID: 37'),
(270, '2025-05-06', '19:24:06', 'admin', 'Menambahkan barang', 'Menambahkan barang ID: 5'),
(271, '2025-05-06', '19:26:46', 'admin', 'Melaporkan Kerusakan', 'Melaporkan kerusakan untuk 33 dengan jumlah 12 dan deskripsi:   bengkok\r\n'),
(272, '2025-05-06', '19:30:59', 'Unknown', 'Export Laporan Stok', 'Export Laporan Stok'),
(273, '2025-05-06', '19:31:02', 'Unknown', 'Export Laporan Transaksi', 'Export Laporan Transaksi'),
(274, '2025-05-06', '19:31:04', 'Unknown', 'Export Laporan Permintaan', 'Export Laporan Permintaan'),
(275, '2025-05-06', '19:42:22', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 27'),
(276, '2025-05-06', '19:43:26', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 28'),
(277, '2025-05-06', '19:43:29', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 30'),
(278, '2025-05-06', '19:43:32', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 33'),
(279, '2025-05-06', '19:43:33', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 34'),
(280, '2025-05-06', '19:43:36', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 35'),
(281, '2025-05-06', '19:43:41', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 38'),
(282, '2025-05-06', '19:43:46', 'Unknown', 'Menghapus Kategori', 'Menghapus Kategori ID: 39'),
(283, '2025-05-07', '02:41:13', 'Unknown', 'Menghapus Supplier', 'Menghapus Supplier ID: 6'),
(284, '2025-05-07', '02:41:42', 'Unknown', 'Menambahkan Supplier', 'Menambahkan Supplier Sayap kontak 08854367238'),
(285, '2025-05-07', '02:42:13', 'Unknown', 'Menambah User', 'Menambahkan user dengan username: satu'),
(286, '2025-05-07', '02:42:51', 'Unknown', 'Menghapus User', 'Menghapus user dengan ID: 6'),
(287, '2025-05-07', '02:44:15', 'satu', 'Menambahkan barang', 'Menambahkan barang ID: 6'),
(288, '2025-05-07', '05:26:19', 'admin', 'Menambahkan barang', 'Menambahkan barang ID: 7');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang_rusak`
--

CREATE TABLE `barang_rusak` (
  `id_barang_rsk` int(15) NOT NULL,
  `id_barang` int(15) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `status` enum('Pending','Resolved','Rejected','') NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang_rusak`
--

INSERT INTO `barang_rusak` (`id_barang_rsk`, `id_barang`, `jumlah`, `deskripsi`, `status`, `tanggal`) VALUES
(32, 33, 12, '  bengkok\r\n', 'Pending', '2025-05-06 17:26:46');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_barang`
--

CREATE TABLE `kategori_barang` (
  `id_kategori` int(15) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_barang`
--

INSERT INTO `kategori_barang` (`id_kategori`, `nama_kategori`) VALUES
(29, 'Kain dan Serat Sintesis'),
(31, 'Slider'),
(32, 'Stopper(pengunci)'),
(36, 'perekat'),
(37, 'Karet'),
(40, 'Snap Fasteners'),
(41, 'Rivet'),
(42, 'Kancing'),
(43, 'Gigi'),
(44, 'Pita'),
(45, 'Benang'),
(46, 'Kotak Karton'),
(47, 'Bubble Wrap'),
(48, 'Label dan Sticker');

-- --------------------------------------------------------

--
-- Struktur dari tabel `keluar`
--

CREATE TABLE `keluar` (
  `id_keluar` int(15) NOT NULL,
  `id_barang` int(15) NOT NULL,
  `tanggal` timestamp NOT NULL DEFAULT current_timestamp(),
  `jumlah` int(255) NOT NULL,
  `keterangan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `keluar`
--

INSERT INTO `keluar` (`id_keluar`, `id_barang`, `tanggal`, `jumlah`, `keterangan`) VALUES
(3, 28, '2025-05-05 09:50:50', 2, 'sdadsdsa'),
(4, 28, '2025-05-05 16:55:40', 1, 'gatau'),
(5, 39, '2025-05-06 17:24:06', 10, 'butuh'),
(6, 38, '2025-05-07 00:44:15', 5, 'butuh'),
(7, 33, '2025-05-07 03:26:19', 3, 'ssad');

-- --------------------------------------------------------

--
-- Struktur dari tabel `rak_barang`
--

CREATE TABLE `rak_barang` (
  `id_rak` int(15) NOT NULL,
  `lokasi` varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `rak_barang`
--

INSERT INTO `rak_barang` (`id_rak`, `lokasi`) VALUES
(10, 'Rak A2'),
(11, 'Rak A3'),
(12, 'Rak A1'),
(13, 'Rak B1'),
(14, 'Rak B2'),
(15, 'Rak B3'),
(16, 'Rak C1'),
(17, 'Rak C2'),
(18, 'Rak C3'),
(19, 'Rak C4'),
(20, 'Rak D1'),
(21, 'Rak D2'),
(22, 'Rak D3'),
(23, 'Rak A4'),
(24, 'Rak A5'),
(25, 'Rak A6'),
(26, 'Rak B4'),
(27, 'Rak B5'),
(28, 'Rak B6'),
(29, 'Rak D4'),
(30, 'Rak D5'),
(31, 'Rak D6'),
(32, 'Rak E1'),
(33, 'Rak E2'),
(34, 'Rak E3'),
(35, 'Rak E4'),
(36, 'Rak E5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `request`
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
-- Dumping data untuk tabel `request`
--

INSERT INTO `request` (`id_req`, `nama_pengaju`, `nama_barang`, `jumlah`, `alasan`, `status`, `tanggal`) VALUES
(36, 'Andri', 'Benang Nilon', 30, 'sudah mau habis', 'Approved', '2025-05-06 17:23:10'),
(37, 'Andri', 'Rivet Logam', 30, 'Habis', 'Rejected', '2025-05-06 17:23:13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id_barang` int(15) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `id_kategori` int(15) NOT NULL,
  `jumlah` int(255) NOT NULL,
  `id_rak` int(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `stok_barang`
--

INSERT INTO `stok_barang` (`id_barang`, `nama_barang`, `id_kategori`, `jumlah`, `id_rak`) VALUES
(33, 'Gigi Metal', 43, 15, 12),
(38, 'Gigi Platik', 43, 15, 10),
(39, 'Slider Logam', 31, 29, 11),
(40, 'Slider Plastik', 31, 27, 23),
(41, 'Stopper Logam', 32, 34, 24),
(42, 'Stopper Plastik', 32, 35, 25),
(43, 'Serat Nylon', 29, 40, 13),
(44, 'Serat Polyester', 29, 36, 14),
(45, 'Perekat Pati', 36, 20, 15),
(46, 'Perekat Plastik', 36, 30, 26),
(47, 'Perekat Karet', 36, 30, 27),
(48, 'Karet Fleksiibel', 37, 40, 28),
(49, 'Kancing Metal', 42, 30, 16),
(50, 'Kancing Plastik', 42, 20, 17),
(51, 'Snap buttons logam', 40, 22, 18),
(52, 'Snap buttons plastik', 40, 43, 19),
(53, 'Rivet Metal', 41, 30, 20),
(54, 'Rivet Plastik', 41, 54, 21),
(55, 'Pita Kain', 44, 30, 22),
(56, 'Benang Nilon', 45, 20, 29),
(57, 'Benang Polyester', 45, 30, 30),
(58, 'Benang Katun', 45, 45, 31),
(59, 'Karton Berlapis', 46, 20, 32),
(60, 'Karton Ringan', 46, 64, 33),
(61, 'Bubble Wrap', 47, 45, 34),
(62, 'Label Produk', 48, 34, 35);

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supp` int(15) NOT NULL,
  `nama_supp` varchar(255) NOT NULL,
  `kontak` varchar(13) NOT NULL,
  `alamat` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supp`, `nama_supp`, `kontak`, `alamat`) VALUES
(7, 'toko laris', '08854637182', 'cibitung'),
(8, 'veldora', '08623645372', 'gt'),
(9, 'rimuru', '081211112222', 'resinda'),
(10, 'Sayap', '08854367238', 'Cikarang timur laut');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`) VALUES
(3, 'user', 'user123', 'user'),
(4, 'admin', 'admin123', 'admin');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `audit_trail`
--
ALTER TABLE `audit_trail`
  ADD PRIMARY KEY (`id_audit`);

--
-- Indeks untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  ADD PRIMARY KEY (`id_barang_rsk`);

--
-- Indeks untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `keluar`
--
ALTER TABLE `keluar`
  ADD PRIMARY KEY (`id_keluar`);

--
-- Indeks untuk tabel `rak_barang`
--
ALTER TABLE `rak_barang`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indeks untuk tabel `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`id_req`);

--
-- Indeks untuk tabel `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `nama_kategori` (`id_kategori`) USING BTREE,
  ADD KEY `lokasi` (`id_rak`) USING BTREE;

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supp`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `audit_trail`
--
ALTER TABLE `audit_trail`
  MODIFY `id_audit` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=289;

--
-- AUTO_INCREMENT untuk tabel `barang_rusak`
--
ALTER TABLE `barang_rusak`
  MODIFY `id_barang_rsk` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT untuk tabel `kategori_barang`
--
ALTER TABLE `kategori_barang`
  MODIFY `id_kategori` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT untuk tabel `keluar`
--
ALTER TABLE `keluar`
  MODIFY `id_keluar` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `rak_barang`
--
ALTER TABLE `rak_barang`
  MODIFY `id_rak` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT untuk tabel `request`
--
ALTER TABLE `request`
  MODIFY `id_req` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT untuk tabel `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id_barang` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=63;

--
-- AUTO_INCREMENT untuk tabel `supplier`
--
ALTER TABLE `supplier`
  MODIFY `id_supp` int(15) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD CONSTRAINT `stok_barang_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_barang` (`id_kategori`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `stok_barang_ibfk_2` FOREIGN KEY (`id_rak`) REFERENCES `rak_barang` (`id_rak`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
