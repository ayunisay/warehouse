<?php
include('../koneksi.php');

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
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
                        <a href="../user_dashboard.php" class="hover:text-yellow-400 transition duration-300">Dashboard</a>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Riwayat Transaksi</h1>

        <!-- Transaction History Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Riwayat Transaksi</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Tanggal</th>
                        <th class="py-2 px-4 border-b">Nama Barang</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Jenis Transaksi</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contoh data riwayat transaksi
                    $transactionHistory = [
                        ['date' => '2025-04-01', 'item' => 'Item A', 'quantity' => 10, 'type' => 'Peminjaman', 'status' => 'Completed'],
                        ['date' => '2025-04-02', 'item' => 'Item B', 'quantity' => 5, 'type' => 'Penggunaan', 'status' => 'Pending'],
                        ['date' => '2025-04-03', 'item' => 'Item C', 'quantity' => 7, 'type' => 'Pengembalian', 'status' => 'Rejected'],
                    ];

                    if (!empty($transactionHistory)) {
                        foreach ($transactionHistory as $transaction) {
                            echo "<tr>
                                    <td class='py-2 px-4 border-b'>{$transaction['date']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['item']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['quantity']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['type']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['status']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='5' class='py-2 px-4 border-b text-center text-gray-500'>Belum ada riwayat transaksi.</td>
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