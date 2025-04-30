<?php
include('../koneksi.php');

if (isset($_GET['id_req'])) {
    $id_req = intval($_GET['id_req']);

    // Update status menjadi Approved
    $stmt = $conn->prepare("UPDATE request SET status = 'Approved' WHERE id_req = ?");
    $stmt->bind_param("i", $id_req);

    if ($stmt->execute()) {
        $id_req = intval($_GET['id_req']);

        // Update status menjadi Approved
        $stmt = $conn->prepare("UPDATE request SET status = 'Approved' WHERE id_req = ?");
        $stmt->bind_param("i", $id_req);
    
        if ($stmt->execute()) {
            // Catat aktivitas ke tabel audit_trail
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username admin
            $aksi = "Menyetujui Permintaan";
            $detail = "Admin menyetujui permintaan ID: " . $id_req;
    
            $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
            $logStmt->execute();
    
            $success = "Permintaan berhasil disetujui!";
            header("Location: ../admin/kelola_permintaan.php");
            exit();
        } else {
            echo "Gagal menyetujui permintaan.";
        }
    } else {
        echo "Gagal menyetujui permintaan.";
    }
}
?>