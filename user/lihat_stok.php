<?php
include('../koneksi.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Stok</title>
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
                        <a href="../user_dashboard.php" class="hover:text-yellow-400 transition duration-300">User Dashboard</a>                    </li>
                    <li>
                        <a href="lihat_stok.php" class="hover:text-yellow-400 transition duration-300">Lihat Stok</a>
                    </li>
                    <li>
                        <a href="permintaan_barang.php" class="hover:text-yellow-400 transition duration-300">Permintaan Barang</a>
                    </li>
                    <li>
                        <a href="riwayat_transaksi.php" class="hover:text-yellow-400 transition duration-300">Riwayat Transaksi</a>
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
    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Lihat Stok</h1>

        <!-- Stock Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Barang</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Lokasi</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Kategori</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel stok_barang
                        $sql = "SELECT id_barang, nama_barang, jumlah, id_rak, id_kategori FROM stok_barang";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['id_rak']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['id_kategori']) . "</td>
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