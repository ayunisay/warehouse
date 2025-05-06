<?php
include('../koneksi.php'); // Pastikan file koneksi sudah ada dan benar
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate Laporan</title>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Generate Laporan</h1>

        <!-- Export Stock Report -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Laporan Stok</h2>
            <p class="text-gray-600 mb-4">Ekspor laporan stok barang yang tersedia di gudang.</p>
            <form action="/warehouse/admin/laporan/export_stock_report.php" method="POST">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition duration-300">Ekspor Laporan Stok</button>
            </form>
        </div>

        <!-- Export Transaction Report -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Laporan Transaksi</h2>
            <p class="text-gray-600 mb-4">Ekspor laporan transaksi peminjaman dan pengembalian barang.</p>
            <form action="/warehouse/admin/laporan/export_transaction_report.php" method="POST">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition duration-300">Ekspor Laporan Transaksi</button>
            </form>
        </div>

        <!-- Export Request Report -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Laporan Permintaan Barang</h2>
            <p class="text-gray-600 mb-4">Ekspor laporan permintaan barang dari pengguna.</p>
            <form action="/warehouse/admin/laporan/export_request_report.php" method="POST">
                <button type="submit" class="bg-teal-600 text-white px-6 py-2 rounded-lg hover:bg-teal-700 transition duration-300">Ekspor Laporan Permintaan</button>
            </form>
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