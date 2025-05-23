<?php
include('../koneksi.php');

// Inisialisasi default untuk $edit_data
$edit_data = null;

// insert
if (isset($_POST['insert'])) {
    $nama_pengaju = $_POST['nama_pengaju'];
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $alasan = $_POST['alasan'];

    // Query untuk menambahkan data ke tabel request
    $stmt = $conn->prepare("INSERT INTO request (nama_pengaju, nama_barang, jumlah, alasan) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nama_pengaju, $nama_barang, $jumlah, $alasan);

    if ($stmt->execute()) {
         // Dapatkan ID terakhir yang dimasukkan
        $id_barang = $conn->insert_id;
        
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Mengajukan Permintaan";
        $detail = "User mengajukan permintaan untuk " . $nama_barang . " jumlah " . $jumlah;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Permintaan barang berhasil ditambahkan!";
        header("Location: permintaan_barang.php");
        exit();
    } else {
        $error = "Gagal request barang!";
    }
}

if (isset($_GET['delete'])) {
    $id_req = intval($_GET['delete']); // Pastikan parameter adalah angka

    $stmt = $conn->prepare("DELETE FROM request WHERE id_req=?");
    $stmt->bind_param("i", $id_req);

    if ($stmt->execute()) {
        $success = "Request barang berhasil dihapus!";
        header("Location: permintaan_barang.php"); // Redirect setelah delete
        exit();
    } else {
        $error = "Gagal menghapus request barang!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permintaan Barang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
             <!-- Logo -->
             <a href="../user_dashboard.php" class="text-2xl font-extrabold tracking-wide hover:text-yellow-400 transition duration-300">
                <span class="text-yellow-400">Warehouse</span> Management
            </a>
            <!-- Navigation Links -->
            <div class="flex items-center space-x-11">
                <ul class="flex space-x-6 text-sm font-medium">
                    <li>
                        <a href="../user_dashboard.php" class="hover:text-yellow-400 transition duration-300">Dashboard</a>
                    </li>
                    <li>
                        <a href="lihat_stok.php" class="hover:text-yellow-400 transition duration-300">Daftar Stok</a>
                    </li>
                    <li>
                        <a href="permintaan_barang.php" class="hover:text-yellow-400 transition duration-300">Permintaan Barang</a>
                    </li>
                    <li>
                        <a href="barang_keluar.php" class="hover:text-yellow-400 transition duration-300">Barang Keluar</a>
                    </li>
                    <li>
                        <a href="laporan_kerusakan.php" class="hover:text-yellow-400 transition duration-300">Laporan Kerusakan</a>
                    </li>
                </ul>

                <!-- Logout Button -->
                <a href="../logout.php" class="flex items-center bg-red-500 px-3 py-2 rounded hover:bg-red-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 flex-grow">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Permintaan Barang</h1>

        <!-- Request Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Form Permintaan Barang</h2>
            <form method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_pengaju" class="block text-gray-600 font-medium mb-2">Nama Pengguna</label>
                        <input type="text" id="nama_pengaju" name="nama_pengaju" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama yang mengajukan" required>
                    </div>
                    <div>
                        <label for="nama_barang" class="block text-gray-600 font-medium mb-2">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama barang" required>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-gray-600 font-medium mb-2">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan jumlah barang" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="alasan" class="block text-gray-600 font-medium mb-2">Alasan Permintaan</label>
                    <textarea id="alasan" name="alasan" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Jelaskan alasan permintaan barang" required></textarea>
                </div>
                <button type="submit" name="insert" class="mt-4 bg-yellow-600 text-white px-6 py-2 rounded-lg hover:bg-yellow-700 transition duration-300">Kirim Permintaan</button>
            </form>
        </div>

        <!-- Request History -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8 flex-grow">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Riwayat Permintaan Barang</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Pengguna</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel request
                        $sql = "SELECT id_req, nama_pengaju, nama_barang, jumlah, status, tanggal FROM request";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = ($row['status'] === 'Approved') ? 'bg-green-500' :
                                            (($row['status'] === 'Rejected') ? 'bg-red-500' : 'bg-yellow-500');

                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_pengaju']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4'>
                                            <span class='px-2 py-1 rounded-lg text-white $statusClass'>
                                                " . htmlspecialchars($row['status']) . "
                                            </span>
                                        </td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['tanggal']) . "</td>
                                        <td class='py-3 px-4'>
                                            " . ($row['status'] === 'Pending' ? "
                                            <a href='?delete=" . $row['id_req'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
                                            " : "-") . "
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='7' class='py-3 px-4 text-center text-gray-500'>Belum ada data permintaan barang.</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white w-full pb-5 mt-8">
        <div class="mt-5 text-center">
            <p class="text-sm text-gray-500">
                &copy; <?php echo date('Y'); ?> Warehouse Management System. All rights reserved.
            </p>
        </div>
    </footer>
</body>
</html>