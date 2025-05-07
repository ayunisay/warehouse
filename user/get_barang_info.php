<?php
include '../koneksi.php';

if (isset($_GET['id_barang'])) {
    $id = $_GET['id_barang'];

    $query = "SELECT stok_barang.id_barang, kategori_barang.id_kategori, kategori_barang.nama_kategori, rak_barang.nama_lokasi 
              FROM stok_barang 
              JOIN kategori_barang ON stok_barang.id_kategori = kategori_barang.id_kategori 
              JOIN rak_barang ON stok_barang.id_rak = rak_barang.id_rak 
              WHERE stok_barang.id_barang = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();

    echo json_encode($data);
}
?>
