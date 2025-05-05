<?php
include('../koneksi.php');

// Inisialisasi default untuk $edit_data
$edit_data = null;

if (isset($_POST['insert'])) {
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $jumlah = $_POST['jumlah'];
    $id_rak = $_POST['id_rak'];

    if (!empty($nama_barang) && !empty($id_kategori) && !empty($jumlah) && !empty($id_rak)) {
        $stmt = $conn->prepare("INSERT INTO stok_barang (nama_barang, id_kategori, jumlah, id_rak) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $nama_barang, $id_kategori, $jumlah, $id_rak);

        if ($stmt->execute()) {
            // Dapatkan ID terakhir yang dimasukkan
            $id_barang = $conn->insert_id;

            // Catat aktivitas ke tabel audit_trail
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
            $aksi = "Menambahkan barang";
            $detail = "Menambahkan barang ID: " . $id_barang;

            $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
            $logStmt->execute();

            $success = "Barang berhasil ditambahkan!";
            header("Location: kelola_stok.php");
            exit();
        } else {
            $error = "Gagal menambahkan barang!";
        }
    } else {
        $error = "Semua field harus diisi!";
    }
}

if (isset($_POST['update'])) {
    $id_barang = $_POST['id_barang'];
    $nama_barang = $_POST['nama_barang'];
    $id_kategori = $_POST['id_kategori'];
    $jumlah = $_POST['jumlah'];
    $id_rak = $_POST['id_rak'];

    $stmt = $conn->prepare("UPDATE stok_barang SET nama_barang=?, id_kategori=?, jumlah=?, id_rak=? WHERE id_barang=?");
    $stmt->bind_param("ssisi", $nama_barang, $id_kategori, $jumlah, $id_rak, $id_barang);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Memperbarui barang";
        $detail = "Memperbarui barang " . $nama_barang . " jumlah " . $jumlah;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Barang berhasil diperbarui!";
        header("Location: kelola_stok.php");
        exit();
    } else {
        $error = "Gagal update barang!";
    }
} else {
    $error = "Semua field harus diisi!";
}


if (isset($_GET['delete'])) {
    $id_barang = intval($_GET['delete']); // Pastikan parameter adalah angka

    // Periksa apakah data barang ada di tabel
    $stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM stok_barang WHERE id_barang = ?");
    $stmt_check->bind_param("i", $id_barang);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();
    $row_check = $result_check->fetch_assoc();

    if ($row_check['count'] > 0) {
        // Hapus barang berdasarkan ID
        $stmt_delete = $conn->prepare("DELETE FROM stok_barang WHERE id_barang = ?");
        $stmt_delete->bind_param("i", $id_barang);

        if ($stmt_delete->execute()) {
            // Catat aktivitas ke tabel audit_trail
            $tanggal = date('Y-m-d');
            $waktu = date('H:i:s');
            $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
            $aksi = "Menghapus barang";
            $detail = "Menghapus barang ID: " . $id_barang;

            $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
            $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
            $logStmt->execute();

            $success = "Barang berhasil dihapus!";
            header("Location: kelola_stok.php");
            exit();
        } else {
            $error = "Gagal menghapus barang!";
        }
    } else {
        $error = "Barang tidak ditemukan!";
    }
}

// Melakukan Get Data
if (isset($_GET['edit'])) {
    $id_barang = $_GET['edit'];
    $result = $conn->query("SELECT * FROM stok_barang WHERE id_barang = $id_barang");

    if ($result && $result->num_rows > 0) {
        $edit_data = $result->fetch_assoc();
    } else {
        $edit_data = null; // Jika data tidak ditemukan
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
                        <a href="riwayat.php" class="hover:text-yellow-400 transition duration-300">Riwayat Keluar</a>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Kelola Stok</h1>


        <div class="mt-8 bg-white shadow-md rounded-lg p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Add Kategori -->
                <a href="add.kategori.php" class="group block bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <!-- Ikon Baru: Ikon Folder -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Add Kategori</h3>
                            <p class="text-sm text-white text-opacity-80">Tambah kategori barang baru.</p>
                        </div>
                    </div>
                </a>

                <!-- Add Rak -->
                <a href="add_rak.php" class="group block bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <!-- Ikon Baru: Ikon Rak -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Add New Rak</h3>
                            <p class="text-sm text-white text-opacity-80">Tambah lokasi penyimpanan baru.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <!-- Add Item Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">
                <?php echo $edit_data ? "Edit Barang" : "Tambah Barang"; ?>
            </h2>
            <form method="POST">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id_barang" value="<?php echo htmlspecialchars($edit_data['id_barang']); ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_barang" class="block text-gray-600 font-medium mb-2">Nama Barang</label>
                        <input type="text" id="nama_barang" name="nama_barang" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan nama barang" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_barang']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="id_kategori" class="block text-gray-600 font-medium mb-2">Kategori</label>
                        <select id="id_kategori" name="id_kategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="" disabled selected>Pilih kategori</option>
                            <?php
                            $kategoriResult = $conn->query("SELECT * FROM kategori_barang");
                            if ($kategoriResult && $kategoriResult->num_rows > 0) {
                                while ($kategori = $kategoriResult->fetch_assoc()) {
                                    $selected = ($edit_data && $edit_data['id_kategori'] === $kategori['id_kategori']) ? 'selected' : '';
                                    echo "<option value='" . htmlspecialchars($kategori['id_kategori']) . "' $selected>" . htmlspecialchars($kategori['nama_kategori']) . "</option>";
                                }
                            } else {
                                echo "<option value='' disabled>Tidak ada kategori tersedia</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div>
                        <label for="jumlah" class="block text-gray-600 font-medium mb-2">Jumlah</label>
                        <input type="number" id="jumlah" name="jumlah" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" placeholder="Masukkan jumlah barang" value="<?php echo $edit_data ? htmlspecialchars($edit_data['jumlah']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="id_rak" class="block text-gray-600 font-medium mb-2">Lokasi Penyimpanan</label>
                        <select id="id_rak" name="id_rak" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500" required>
                            <option value="" disabled selected>Pilih lokasi</option>
                            <?php
                                $rakResult = $conn->query("SELECT * FROM rak_barang");

                                $rakBarangResult = $conn->query("SELECT id_rak FROM stok_barang");
                                $usedRak = [];
                                if ($rakBarangResult && $rakBarangResult->num_rows > 0) {
                                    while ($row = $rakBarangResult->fetch_assoc()) {
                                        $usedRak[] = $row['id_rak'];
                                    }
                                }

                                if ($rakResult && $rakResult->num_rows > 0) {
                                    while ($rak = $rakResult->fetch_assoc()) {
                                        if (!in_array($rak['id_rak'], $usedRak)) {
                                            $selected = ($edit_data && $edit_data['id_rak'] === $rak['id_rak']) ? 'selected' : '';
                                            echo "<option value='" . htmlspecialchars($rak['id_rak']) . "' $selected>" . htmlspecialchars($rak['lokasi']) . "</option>";
                                        }
                                    }
                                } else {
                                    echo "<option value='' disabled>Tidak ada lokasi tersedia</option>";
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" name="<?php echo $edit_data ? 'update' : 'insert'; ?>" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    <?php echo $edit_data ? "Edit Barang" : "Tambah Barang"; ?>
                </button>
                <?php if ($edit_data): ?>
                    <a href="kelola_stok.php" class="mt-4 bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">Batal</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Stock Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Barang</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Kategori</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Lokasi</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                            $sql = "SELECT id_barang, nama_barang, id_kategori, jumlah, id_rak FROM stok_barang";
                            $result = $conn->query($sql);

                            $no = 1; // Inisialisasi nomor urut

                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr class='hover:bg-gray-50'>
                                            <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                            <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                            <td class='py-3 px-4'>" . htmlspecialchars($row['id_kategori']) . "</td>
                                            <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                            <td class='py-3 px-4'>" . htmlspecialchars($row['id_rak']) . "</td>
                                            <td class='py-3 px-4'>
                                                <a href='?edit=" . $row['id_barang'] . "' class='text-blue-500 hover:underline'>Edit</a> |
                                                <a href='?delete=" . $row['id_barang'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
                                            </td>
                                        </tr>";
                                }
                            } else {
                                echo "<tr>
                                        <td colspan='6' class='py-3 px-4 text-center text-gray-500'>Belum ada data barang.</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
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