<?php
include('../koneksi.php');

// Inisialisasi default untuk $edit_data
$edit_data = null;

// Melakukan CRUD
if (isset($_POST['insert'])) {
    $nama_supp = $_POST['nama_supp'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    $stmt = $conn->prepare("INSERT INTO supplier (nama_supp, kontak, alamat) VALUES (?, ?, ?)");
    $stmt->bind_param("sis", $nama_supp, $kontak, $alamat);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Menambahkan Supplier";
        $detail = "Menambahkan Supplier " . $nama_supp . " kontak " . $kontak;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Supplier berhasil ditambahkan!";
        header("Location: kelola_supplier.php");
        exit();
    } else {
        $error = "Gagal menambahkan supplier!";
    }
} else {
    $error = "Semua field harus diisi!";
}

//update
if (isset($_POST['update'])) {
    $id_supp = intval($_POST['id_supp']); // Ambil id_supp dari input tersembunyi
    $nama_supp = $_POST['nama_supp'];
    $kontak = $_POST['kontak'];
    $alamat = $_POST['alamat'];

    $stmt = $conn->prepare("UPDATE supplier SET nama_supp=?, kontak=?, alamat=? WHERE id_supp=?");
    $stmt->bind_param("sisi", $nama_supp, $kontak, $alamat, $id_supp);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Memperbarui Supplier";
        $detail = "Memperbarui Supplier " . $nama_supp . " kontak " . $kontak;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Supplier berhasil diperbarui!";
        header("Location: kelola_supplier.php");
        exit();
    } else {
        $error = "Gagal update supplier!";
    }
} else {
    $error = "Semua field harus diisi!";
}


if (isset($_GET['delete'])) {
    $id_supp = $_GET['delete'];    

    
    $stmt = $conn->prepare("DELETE FROM supplier WHERE id_supp=?");
    $stmt->bind_param("i", $id_supp);
    
    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Menghapus Supplier";
        $detail = "Menghapus Supplier ID: " . $id_supp;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Supplier berhasil dihapus!";
        header("Location: kelola_supplier.php");
        exit();
    } else {
        $error = "Gagal menghapus supplier!";
    }
}

// Melakukan Get Data
if (isset($_GET['edit'])) {
    $id_supp = $_GET['edit']; // Ambil parameter edit dari URL
    $result = $conn->query("SELECT * FROM supplier WHERE id_supp=$id_supp");

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
    <title>Kelola Supplier</title>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Kelola Supplier</h1>

        <!-- Add Supplier Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
        <h2 class="text-2xl font-bold text-gray-700 mb-4">
            <?php echo $edit_data ? "Edit Supplier" : "Tambah Supplier"; ?>
        </h2>
            <form method="POST">
                <?php if ($edit_data): ?>
                        <input type="hidden" name="id_supp" value="<?php echo htmlspecialchars($edit_data['id_supp']); ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="nama_supp" class="block text-gray-600 font-medium mb-2">Nama Supplier</label>
                        <input type="text" id="nama_supp" name="nama_supp" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan nama supplier" value="<?php echo $edit_data ? htmlspecialchars($edit_data['nama_supp']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="kontak" class="block text-gray-600 font-medium mb-2">Kontak</label>
                        <input type="text" id="kontak" name="kontak" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan kontak supplier" value="<?php echo $edit_data ? htmlspecialchars($edit_data['kontak']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="alamat" class="block text-gray-600 font-medium mb-2">Alamat</label>
                        <input type="text" id="alamat" name="alamat" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-500" placeholder="Masukkan alamat supplier" value="<?php echo $edit_data ? htmlspecialchars($edit_data['alamat']) : ''; ?>" required>
                    </div>
                </div>
                <button type="submit" name="<?php echo $edit_data ? 'update' : 'insert'; ?>" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    <?php echo $edit_data ? "Edit supplier" : "Tambah supplier"; ?>
                </button>
                <?php if ($edit_data): ?>
                    <a href="kelola_supplier.php" class="mt-4 bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">Batal</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Supplier Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Supplier</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Supplier</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Kontak</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Alamat</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel supplier
                        $sql = "SELECT id_supp, nama_supp, kontak, alamat FROM supplier";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_supp']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['kontak']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['alamat']) . "</td>
                                        <td class='py-3 px-4'>
                                            <a href='?edit=" . $row['id_supp'] . "' class='text-blue-500 hover:underline'>Edit</a> |
                                            <a href='?delete=" . $row['id_supp'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='5' class='py-3 px-4 text-center text-gray-500'>Belum ada data supplier.</td>
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