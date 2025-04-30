<?php
include('../../koneksi.php'); //koneksi.php

// Ambil data permintaan barang dari database
$query = "SELECT id_req, nama_barang, jumlah, alasan, nama_pengaju, status, tanggal FROM request";
$result = $conn->query($query);

// Header untuk file CSV
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=laporan_permintaan.csv');

// Buat file CSV
$output = fopen('php://output', 'w');
fputcsv($output, ['ID Permintaan', 'Nama Barang', 'Jumlah', 'Alasan', 'Penanggung Jawab', 'Status', 'Tanggal']);

// Catat aktivitas ke tabel audit_trail
$tanggal = date('Y-m-d');
$waktu = date('H:i:s');
$pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
$aksi = "Export Laporan Permintaan";
$detail = "Export Laporan Permintaan";

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