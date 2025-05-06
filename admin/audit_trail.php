<?php
include('../koneksi.php'); // Pastikan file koneksi sudah ada dan benar

// Ambil data log aktivitas dari database
$query = "SELECT tanggal, waktu, nama_pengaju, aksi, detail FROM audit_trail ORDER BY tanggal DESC, waktu DESC";
$result = $conn->query($query);
$auditLogs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $auditLogs[] = $row;
    }
}

if (isset($_POST['delete_all_logs'])) {
    // Hapus semua data dari tabel audit_trail
    $deleteQuery = "DELETE FROM audit_trail";
    if ($conn->query($deleteQuery)) {
        echo "<script>alert('Semua log aktivitas berhasil dihapus!'); window.location.href = 'audit_trail.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus log aktivitas!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audit Trail</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">
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
                    <a href="logout.php" class="flex items-center bg-red-500 px-4 py-2 rounded hover:bg-red-600 transition duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </nav>

    <div class="container mx-auto mt-8 flex-grow">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Audit Trail</h1>

        <!-- Audit Trail Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Log Aktivitas Sistem</h2>
                <div class="mt-8">
                    <form method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus semua log aktivitas?');">
                        <button type="submit" name="delete_all_logs" class="bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">
                            Hapus Semua Log
                        </button>
                    </form>
                </div>
            <div class="overflow-x-auto mt-2">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Waktu</th>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Pengguna</th>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Aksi</th>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Detail</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        if (!empty($auditLogs)) {
                            foreach ($auditLogs as $log) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($log['tanggal']) . "</td>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($log['waktu']) . "</td>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($log['nama_pengaju']) . "</td>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($log['aksi']) . "</td>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($log['detail']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='5' class='py-3 px-6 border-b text-center text-gray-500'>Belum ada log aktivitas.</td>
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