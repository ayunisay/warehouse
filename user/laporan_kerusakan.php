<?php
include('../koneksi.php');

// insert
if (isset($_POST['insert'])) {
    $nama_barang = $_POST['nama_barang'];
    $jumlah = $_POST['jumlah'];
    $deskripsi = $_POST['deskripsi'];

    if (!empty($nama_barang) && !empty($jumlah) && !empty($deskripsi)) {
        $stmt = $conn->prepare("INSERT INTO barang_rusak (nama_barang, jumlah, deskripsi) VALUES (?, ?, ?)");
        $stmt->bind_param("sis", $nama_barang, $jumlah, $deskripsi);

            // Cek stok cukup
        $stok = $conn->query("SELECT jumlah FROM stok_barang WHERE id_barang = $id_barang")->fetch_assoc()['jumlah'];
        if ($stok >= $jumlah) {
        // Update stok
        $conn->query("UPDATE stok_barang SET jumlah = jumlah - $jumlah WHERE id_barang = $id_barang");

            if ($stmt->execute()) {
                // Catat aktivitas ke tabel audit_trail
                $tanggal = date('Y-m-d');
                $waktu = date('H:i:s');
                $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
                $aksi = "Melaporkan Kerusakan";
                $detail = "Melaporkan kerusakan untuk " . $nama_barang . " jumlah " . $jumlah;

                $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
                $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
                $logStmt->execute();

                $success = "Laporan kerusakan berhasil ditambahkan!";
                header("Location: laporan_kerusakan.php");
                exit();
            } else {
                $error = "Gagal menambahkan laporan kerusakan!";
            }
        } else {
            $error = "Semua field harus diisi!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id_barang_rsk = intval($_GET['delete']); // Pastikan parameter adalah angka

    // Periksa status laporan
    $stmt = $conn->prepare("SELECT status FROM barang_rusak WHERE id_barang_rsk = ?");
    $stmt->bind_param("i", $id_barang_rsk);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($row['status'] === 'Pending') {
            // Hapus laporan jika statusnya Pending
            $deleteStmt = $conn->prepare("DELETE FROM barang_rusak WHERE id_barang_rsk = ?");
            $deleteStmt->bind_param("i", $id_barang_rsk);

            if ($deleteStmt->execute()) {
                $success = "Laporan berhasil dihapus!";
                header("Location: laporan_kerusakan.php"); // Redirect setelah delete
                exit();
            } else {
                $error = "Gagal menghapus laporan!";
            }
        } else {
            $error = "Laporan tidak dapat dihapus karena statusnya bukan Pending.";
        }
    } else {
        $error = "Laporan tidak ditemukan.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Kerusakan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
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
                        <a href="../user_dashboard.php" class="hover:text-yellow-400 transition duration-300">User Dashboard</a>
                    </li>
                    <li>
                        <a href="lihat_stok.php" class="hover:text-yellow-400 transition duration-300">Lihat Stok</a>
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

    <!-- Main Content -->
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Laporan Kerusakan</h1>

        <!-- Damage Report Form -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Laporan Kerusakan</h2>
            <form method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                        <label for="id_barang" class="block text-gray-600 font-medium mb-2">Nama Barang</label>
                        <select id="id_barang" name="id_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="" disabled selected>Pilih Barang</option>
                            <?php
                            $barangResult = $conn->query("SELECT * FROM stok_barang");
                            if ($barangResult && $barangResult->num_rows > 0) {
                                while ($id_barang = $barangResult->fetch_assoc()) {
                                    $selected = ($edit_data && $edit_data['id_rak'] === $id_barang['id_barang']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($id_barang['id_barang']) . "' $selected>" . htmlspecialchars($id_barang['nama_barang']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Tidak ada kategori tersedia</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-gray-600 font-medium mb-2">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan jumlah barang" required>
                    </div>
                </div>
                <div class="mt-4">
                    <label for="deskripsi" class="block text-gray-600 font-medium mb-2">Deskripsi Kerusakan</label>
                    <textarea id="deskripsi" name="deskripsi" rows="4" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Jelaskan kerusakan atau kehilangan barang" required></textarea>
                </div>
                <button type="submit" name="insert" class="mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Kirim Laporan</button>
            </form>
        </div>

        <!-- Damage Report History -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Riwayat Laporan Kerusakan</h2>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Deskripsi</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel request
                        $sql = "SELECT id_barang_rsk, nama_barang, jumlah, deskripsi, status, tanggal FROM barang_rusak"; 
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['deskripsi']) . "</td>
                                        <td class='py-3 px-4'>
                                            <span class='px-2 py-1 rounded-lg text-white " .  
                                            ($row['status'] === 'Resolved' ? 'bg-green-500' : ($row['status'] === 'Rejected' ? 'bg-red-500' : 'bg-yellow-500')) . "'>
                                                " . htmlspecialchars($row['status']) . "
                                            </span>
                                        </td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['tanggal']) . "</td>
                                        <td class='py-3 px-4'>";
                                if ($row['status'] === 'Pending') {
                                    echo "<a href='?delete=" . $row['id_barang_rsk'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>";
                                } else {
                                    echo "<span class='text-gray-400'>-</span>";
                                }
                                echo "</td>
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

    <!-- Footer -->
    <footer class="bg-gray-900 text-white w-full mt-8 pb-5">
        <div class="mt-8 border-t border-gray-700 pt-5 text-center">
            <p class="text-sm text-gray-500">&copy; <?php echo date('Y'); ?> Warehouse Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>