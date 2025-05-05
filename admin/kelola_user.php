<?php
include('../koneksi.php'); // Pastikan file koneksi sudah ada dan benar

$usersQuery = "SELECT id, username, role FROM users";
$usersResult = $conn->query($usersQuery);
$users = [];
if ($usersResult && $usersResult->num_rows > 0) {
    while ($row = $usersResult->fetch_assoc()) {
        $users[] = $row;
    }
}

// insert user
if (isset($_POST['insert'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $password, $role);
    
    // Update user password in DB
    $new_hash = password_hash($password, PASSWORD_DEFAULT);
    $update = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
    $update->bind_param("ss", $new_hash, $user['username']);
    $update->execute();

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Menambah User";
        $detail = "Menambahkan user dengan username: " . $username;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "User berhasil ditambahkan!";
        header("Location: kelola_user.php");
        exit();
    } else {
        $error = "Gagal menambahkan barang!";
    }
}

if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE user SET username=?, password=?, role=? WHERE id=?");
    $stmt->bind_param("sssi", $username, $password, $role, $id);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown';
        $aksi = "Mengedit User";
        $detail = "Mengedit user dengan ID: " . $id;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "User berhasil diperbarui!";
        header("Location: kelola_user.php");
        exit();
    } else {
        $error = "Gagal memperbarui barang!";
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    
    $stmt = $conn->prepare("DELETE FROM user WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown';
        $aksi = "Menghapus User";
        $detail = "Menghapus user dengan ID: " . $id;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "User berhasil dihapus!";
        header("Location: kelola_user.php");
        exit();
    } else {
        $error = "Gagal menghapus barang!";
    }
}

// Inisialisasi default untuk $edit_data
$edit_data = null;
// Melakukan Get Data
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $result = $conn->query("SELECT * FROM user WHERE id=$id");

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
    <title>Kelola User</title>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Kelola User</h1>

        <!-- Add User Form -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">
                <?php echo $edit_data ? "Edit User" : "Tambah User"; ?> 
            </h2>
            <form method="POST">
                <?php if ($edit_data): ?>
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($edit_data['id']); ?>">
                <?php endif; ?>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="username" class="block text-gray-600 font-medium mb-2">Username</label>
                        <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan username" value="<?php echo $edit_data ? htmlspecialchars($edit_data['username']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" placeholder="Masukkan password" value="<?php echo $edit_data ? htmlspecialchars($edit_data['password']) : ''; ?>" required>
                    </div>
                    <div>
                        <label for="role" class="block text-gray-600 font-medium mb-2">Role</label>
                        <select id="role" name="role" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500" required>
                            <option value="user" <?php echo ($edit_data && $edit_data['role'] === 'user') ? 'selected' : ''; ?>>User</option>
                            <option value="admin" <?php echo ($edit_data && $edit_data['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                        </select>
                    </div>
                </div>
                <button type="submit" name="<?php echo $edit_data ? 'update' : 'insert'; ?>" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition duration-300">
                    <?php echo $edit_data ? "Edit User" : "Tambah User"; ?>
                </button>
                <?php if ($edit_data): ?>
                    <a href="kelola_user.php" class="mt-4 bg-gray-600 text-white px-6 py-2 rounded-lg hover:bg-gray-700 transition duration-300">Batal</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- User Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Users</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Username</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Role</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    <?php
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($user['username']) . "</td>
                                        <td class='py-3 px-4 capitalize'>" . htmlspecialchars($user['role']) . "</td>
                                        <td class='py-3 px-4'>
                                            <a href='?edit=" . htmlspecialchars($user['id']) . "' class='text-blue-500 hover:underline'>Edit</a> |
                                            <a href='?delete=" . htmlspecialchars($user['id']) . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='3' class='py-3 px-4 text-center text-gray-500'>Belum ada data user.</td>
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