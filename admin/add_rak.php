<?php
include('../koneksi.php');

// Tambahkan kategori baru
if (isset($_POST['add_rak'])) {
    $lokasi = trim($_POST['lokasi']);

    if (!empty($lokasi)) {
        // Periksa apakah kategori sudah ada
        $stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM rak_barang WHERE lokasi = ?");
        $stmt_check->bind_param("s", $lokasi);
        $stmt_check->execute();
        $result_check = $stmt_check->get_result();
        $row_check = $result_check->fetch_assoc();

        if ($row_check['count'] > 0) {
            $error = "Rak '$lokasi' sudah ada!";
        } else {
            // Tambahkan kategori baru
            $stmt = $conn->prepare("INSERT INTO rak_barang (lokasi) VALUES (?)");
            $stmt->bind_param("s", $lokasi);

            if ($stmt->execute()) {
                // Dapatkan ID terakhir yang dimasukkan
                $id_kategori = $conn->insert_id;

                // Catat aktivitas ke tabel audit_trail
                $tanggal = date('Y-m-d');
                $waktu = date('H:i:s');
                $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
                $aksi = "Menambahkan Rak";
                $detail = "Menambahkan Rak ID: " . $id_kategori;

                $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
                $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
                $logStmt->execute();

                $success = "Rak berhasil ditambahkan!";
                header("Location: add_rak.php");
                exit();
            } else {
                $error = "Gagal menambahkan Rak!";
            }
        }
    } else {
        $error = "Nama rak tidak boleh kosong!";
    }
}

// Hapus kategori
if (isset($_GET['delete'])) {
    $id_rak = intval($_GET['delete']); // Pastikan parameter adalah angka

    // Periksa apakah kategori sedang digunakan di tabel stok_barang
    $stmt_check_usage = $conn->prepare("SELECT COUNT(*) AS count FROM rak_barang WHERE lokasi = (SELECT lokasi FROM rak_barang WHERE id_rak = ?)");
    $stmt_check_usage->bind_param("i", $id_kategori);
    $stmt_check_usage->execute();
    $result_check_usage = $stmt_check_usage->get_result();
    $row_check_usage = $result_check_usage->fetch_assoc();

    if ($row_check_usage['count'] > 0) {
        $error = "Rak tidak dapat dihapus karena sedang digunakan di tabel stok barang!";
    } else {
        // Hapus kategori berdasarkan ID
        $stmt = $conn->prepare("DELETE FROM rak_barang WHERE id_rak = ?");
        $stmt->bind_param("i", $id_rak);

        if ($stmt->execute()) {
            // Catat aktivitas ke tabel audit_trail
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
            $aksi = "Menghapus Rak";
            $detail = "Menghapus Rak ID: " . $id_rak;

            $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
            $logStmt->execute();

            $success = "Rak berhasil dihapus!";
            header("Location: add_rak.php");
            exit();
        } else {
            $error = "Gagal menghapus rak!";
        }
    }
}

// Ambil daftar kategori dari database
$sql_rak = "SELECT * FROM rak_barang";
$result_rak = $conn->query($sql_rak);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Kategori</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <!-- Logo -->
            <a href="../admin_dashboard.php" class="text-2xl font-extrabold tracking-wide hover:text-yellow-400 transition duration-300">
                <span class="text-yellow-400">Warehouse</span> Management
            </a>

            <!-- Navigation Links -->
            <div class="flex items-center space-x-11">
                <ul class="flex space-x-6 text-sm font-medium">
                    <li>
                        <a href="../admin_dashboard.php" class="hover:text-yellow-400 transition duration-300">Dashboard</a>
                    </li>
                    <li>
                        <a href="kelola_stok.php" class="hover:text-yellow-400 transition duration-300">Stok</a>
                    </li>
                    <li>
                        <a href="kelola_supplier.php" class="hover:text-yellow-400 transition duration-300">Supplier</a>
                    </li>
                    <li>
                        <a href="kelola_user.php" class="hover:text-yellow-400 transition duration-300">User</a>
                    </li>
                    <li>
                        <a href="kelola_transaksi.php" class="hover:text-yellow-400 transition duration-300">Transaksi</a>
                    </li>
                    <li>
                        <a href="kelola_permintaan.php" class="hover:text-yellow-400 transition duration-300">Permintaan Barang</a>
                    </li>
                </ul>

                <!-- Logout Button -->
                <a href="../logout.php" class="flex items-center bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h1 class="text-2xl font-bold text-gray-700 mb-4">Tambah Rak</h1>
            <form method="POST">
                <div class="mb-4">
                    <label for="lokasi" class="block text-gray-600 font-medium mb-2">Lokasi Penyimpanan</label>
                    <input type="text" id="lokasi" name="lokasi" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan lokasi penyimpanan" required>
                </div>
                <button type="submit" name="add_rak" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300">Tambah</button>
            </form>
        </div>

        <!-- Daftar Kategori -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Lokasi Penyimpanan</h2>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Lokasi</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php if ($result_rak && $result_rak->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result_rak->fetch_assoc()): ?>
                            <tr>
                                <td class="py-3 px-4"><?php echo $no++; ?></td>
                                <td class="py-3 px-4"><?php echo htmlspecialchars($row['lokasi']); ?></td>
                                <td class="py-3 px-4">
                                    <a href="?delete=<?php echo $row['id_rak']; ?>" onclick="return confirm('Yakin ingin menghapus rak ini?')" class="text-red-500 hover:underline">Hapus</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="py-3 px-4 text-center text-gray-500">Belum ada kategori yang ditambahkan.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>