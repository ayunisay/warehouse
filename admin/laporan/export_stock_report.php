<?php
include('../../koneksi.php'); //koneksi.php

// Ambil data stok barang dari database
$query = "SELECT stok_barang.nama_barang, kategori_barang.nama_kategori, stok_barang.jumlah, rak_barang.lokasi FROM stok_barang JOIN kategori_barang ON stok_barang.id_kategori = kategori_barang.id_kategori JOIN rak_barang ON stok_barang.id_rak = rak_barang.id_rak";
$result = $conn->query($query);

// Header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_stok.csv');

// Buat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['Nama Barang', 'Kategori', 'Jumlah', 'Lokasi']);

// Catat aktivitas ke tabel audit_trail
$tanggal = date('Y-m-d');
$waktu = date('H:i:s');
$pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
$aksi = "Export Laporan Stok";
$detail = "Export Laporan Stok";

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