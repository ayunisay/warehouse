<?php
include('../../koneksi.php'); //koneksi.php

// Ambil data transaksi dari database
$query = "SELECT keluar.id_keluar, stok_barang.id_barang, stok_barang.nama_barang, keluar.tanggal, keluar.jumlah, keluar.keterangan FROM keluar JOIN stok_barang ON keluar.id_barang = stok_barang.id_barang;";
$result = $conn->query($query);

// Header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_transaksi.csv');

// Buat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['ID Keluar', 'ID Barang', 'Nama Barang', 'Tanggal', 'Jumlah', 'Keterangan']);

// Catat aktivitas ke tabel audit_trail
$tanggal = date('Y-m-d');
$waktu = date('H:i:s');
$pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
$aksi = "Export Laporan Transaksi";
$detail = "Export Laporan Transaksi";

$logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
$logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
$logStmt->execute();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        fputcsv($output, $row);
    }
}
fclose($output);
exit();
?>