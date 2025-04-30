<?php
include('../koneksi.php');

if (isset($_GET['id_barang_rsk'])) {
    $id_barang_rsk = intval($_GET['id_barang_rsk']);
    $nama_barang = htmlspecialchars($_GET['nama_barang']); // Sanitasi input untuk keamanan
    $jumlah = intval($_GET['jumlah']); // Pastikan jumlah adalah angka

    // Update status menjadi Resolved
    $stmt = $conn->prepare("UPDATE barang_rusak SET status = 'Resolved' WHERE id_barang_rsk = ?");
    $stmt->bind_param("i", $id_barang_rsk);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username admin
        $aksi = "Menerima Laporan Kerusakan";
        $detail = "Admin Menerima Laporan Kerusakan ID: " . $id_barang_rsk;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Permintaan berhasil disetujui!";
        header("Location: ../admin_dashboard.php");
        exit();
    } else {
        echo "Gagal menyetujui.";
    }
}
?>