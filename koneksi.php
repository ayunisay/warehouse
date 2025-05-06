<?php
$host = "localhost";       // Alamat server database (biasanya "localhost" jika di server lokal)
$username = "root";        // Username untuk koneksi MySQL (default di XAMPP = "root")
$password = "";            // Password user MySQL (default di XAMPP = kosong)
$database = "warehouse";   // Nama database yang akan diakses

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $database);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>