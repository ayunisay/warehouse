<?php
include('../koneksi.php');

if (isset($_GET['id_barang_rsk'])) {
    $id_barang_rsk = intval($_GET['id_barang_rsk']);

    // Update status menjadi Rejected
    $stmt = $conn->prepare("UPDATE barang_rusak SET status = 'Rejected' WHERE id_barang_rsk = ?");
    $stmt->bind_param("i", $id_barang_rsk);

    if ($stmt->execute()) {
        $id_barang_rsk = intval($_GET['id_barang_rsk']);

        // Update status menjadi Approved
        $stmt = $conn->prepare("UPDATE barang_rusak SET status = 'Rejected' WHERE id_barang_rsk = ?");
        $stmt->bind_param("i", $id_barang_rsk);
    
        if ($stmt->execute()) {
            // Catat aktivitas ke tabel audit_trail
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username admin
            $aksi = "Menolak Laporan Kerusakan";
            $detail = "Admin menolak laporan kerusakan ID: " . $id_barang_rsk;
    
            $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
            $logStmt->execute();
    
            $success = "Permintaan tidak disetujui!";
            header("Location: ../admin_dashboard.php");
            exit();
        } else {
            echo "Gagal menyetujui.";
        }
    } else {
        echo "Gagal menyetujui.";
    }
}
?>