<?php
include('../koneksi.php')

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Transaksi</title>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Kelola Transaksi</h1>

        <!-- Borrowing Transactions -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Pengiriman Barang</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Kode Barang</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Penanggung Jawab</th>
                        <th class="py-2 px-4 border-b">Tanggal Pengiriman</th>
                        <th class="py-2 px-4 border-b">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contoh data peminjaman barang
                    $borrowTransactions = [
                        ['item' => 'Item A', 'quantity' => 10, 'borrower' => 'John Doe', 'date' => '2025-04-01'],
                        ['item' => 'Item B', 'quantity' => 5, 'borrower' => 'Jane Smith', 'date' => '2025-04-02'],
                    ];

                    if (!empty($borrowTransactions)) {
                        foreach ($borrowTransactions as $transaction) {
                            echo "<tr>
                                    <td class='py-2 px-4 border-b'>{$transaction['item']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['quantity']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['borrower']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['date']}</td>
                                    <td class='py-2 px-4 border-b'>
                                        <a href='return_item.php?item={$transaction['item']}' class='text-green-500 hover:underline'>Pengembalian</a>
                                    </td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='5' class='py-2 px-4 border-b text-center text-gray-500'>Belum ada data peminjaman.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Return Transactions -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Pengembalian Barang</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Kode Barang</th>
                        <th class="py-2 px-4 border-b">Jumlah</th>
                        <th class="py-2 px-4 border-b">Penanggung Jawab</th>
                        <th class="py-2 px-4 border-b">Tanggal Pengembalian</th>
                        <th class="py-2 px-4 border-b">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    // Contoh data pengembalian barang
                    $returnTransactions = [
                        ['item' => 'Item A', 'quantity' => 10, 'borrower' => 'John Doe', 'date' => '2025-04-05', 'status' => 'Selesai'],
                        ['item' => 'Item B', 'quantity' => 5, 'borrower' => 'Jane Smith', 'date' => '2025-04-06', 'status' => 'Pending'],
                    ];

                    if (!empty($returnTransactions)) {
                        foreach ($returnTransactions as $transaction) {
                            echo "<tr>
                                    <td class='py-2 px-4 border-b'>{$transaction['item']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['quantity']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['borrower']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['date']}</td>
                                    <td class='py-2 px-4 border-b'>{$transaction['status']}</td>
                                  </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='5' class='py-2 px-4 border-b text-center text-gray-500'>Belum ada data pengembalian.</td>
                              </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Generate Invoice -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Generate Invoice</h2>
            <form action="generate_invoice.php" method="POST">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="borrower_name" class="block text-gray-600 font-medium mb-2">Nama Peminjam</label>
                        <input type="text" id="borrower_name" name="borrower_name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" placeholder="Masukkan nama peminjam" required>
                    </div>
                    <div>
                        <label for="transaction_date" class="block text-gray-600 font-medium mb-2">Tanggal Transaksi</label>
                        <input type="date" id="transaction_date" name="transaction_date" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-red-500" required>
                    </div>
                </div>
                <button type="submit" class="mt-4 bg-red-600 text-white px-6 py-2 rounded-lg hover:bg-red-700 transition duration-300">Generate Invoice</button>
            </form>
        </div>
    </div>
</body>
</html>