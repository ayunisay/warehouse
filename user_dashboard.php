<?php
include('koneksi.php');

// Total Items
$queryTotalItems = "SELECT COUNT(*) AS total_items FROM stok_barang";
$resultTotalItems = $conn->query($queryTotalItems);
$totalItems = $resultTotalItems->fetch_assoc()['total_items'] ?? 0;

// Low Stock Items
$queryLowStockItems = "SELECT nama_barang AS name, jumlah AS stock, lokasi AS location FROM stok_barang WHERE jumlah < 10";
$resultLowStockItems = $conn->query($queryLowStockItems);
$lowStockItems = [];
if ($resultLowStockItems && $resultLowStockItems->num_rows > 0) {
    while ($row = $resultLowStockItems->fetch_assoc()) {
        $lowStockItems[] = $row;
    }
}

// Recent Activities
$queryRecentActivities = "SELECT COUNT(*) AS recent_activities FROM audit_trail WHERE tanggal = CURDATE()";
$resultRecentActivities = $conn->query($queryRecentActivities);
$recentActivities = $resultRecentActivities->fetch_assoc()['recent_activities'] ?? 0;

// Ambil data log aktivitas dari database
$query = "SELECT tanggal, waktu, nama_pengaju, aksi, detail FROM audit_trail ORDER BY tanggal DESC, waktu DESC";
$result = $conn->query($query);
$auditLogs = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $auditLogs[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <!-- Navbar -->
    <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
             <!-- Logo -->
             <a href="user_dashboard.php" class="text-2xl font-extrabold tracking-wide hover:text-yellow-400 transition duration-300">
                <span class="text-yellow-400">Warehouse</span> Management
            </a>
            <!-- Navigation Links -->
            <div class="flex items-center space-x-11">
                <ul class="flex space-x-6 text-sm font-medium">
                    <li>
                        <a href="user_dashboard.php" class="hover:text-yellow-400 transition duration-300">User Dashboard</a>
                    </li>
                    <li>
                        <a href="./user/lihat_stok.php" class="hover:text-yellow-400 transition duration-300">Lihat Stok</a>
                    </li>
                    <li>
                        <a href="./user/permintaan_barang.php" class="hover:text-yellow-400 transition duration-300">Permintaan Barang</a>
                    </li>
                    <li>
                        <a href="./user/riwayat_transaksi.php" class="hover:text-yellow-400 transition duration-300">Riwayat Transaksi</a>
                    </li>
                    <li>
                        <a href="./user/laporan_kerusakan.php" class="hover:text-yellow-400 transition duration-300">Laporan Kerusakan</a>
                    </li>
                </ul>

                <!-- Logout Button -->
                <a href="logout.php" class="flex items-center bg-red-500 px-3 py-2 rounded hover:bg-red-600 transition duration-300">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H3" />
                    </svg>
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Dashboard</h1>

        <!-- Stock Summary -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Items -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Total Items</h2>
                <p class="text-4xl font-semibold text-blue-600 mt-4"><?php echo $totalItems; ?></p>
                <p class="text-sm text-gray-500 mt-2">Total items available in stock.</p>
            </div>

            <!-- Low Stock Items -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Low Stock Items</h2>
                <p class="text-4xl font-semibold text-red-600 mt-4"><?php echo count($lowStockItems); ?></p>
                <p class="text-sm text-gray-500 mt-2">Items that are running low in stock.</p>
            </div>

            <!-- Recent Activities -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Recent Activities</h2>
                <p class="text-4xl font-semibold text-green-600 mt-4"><?php echo $recentActivities; ?></p>
                <p class="text-sm text-gray-500 mt-2">Recent transactions or updates.</p>
            </div>
        </div>

        <!-- Low Stock Items -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Low Stock Items</h2>
            <table class="min-w-full bg-white border border-gray-300">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Item Name</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Stock</th>
                        <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($lowStockItems)) {
                        foreach ($lowStockItems as $item) {
                            echo "<tr class='hover:bg-gray-50'>
                                    <td class='py-2 px-4 border-b'>" . htmlspecialchars($item['name']) . "</td>
                                    <td class='py-2 px-4 border-b'>" . htmlspecialchars($item['stock']) . "</td>
                                    <td class='py-2 px-4 border-b'>" . htmlspecialchars($item['location']) . "</td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='3' class='py-2 px-4 border-b text-center text-gray-500'>No low stock items found.</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Audit Trail Table -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Log Aktivitas Sistem</h2>
            <div class="overflow-x-auto">
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
    <footer class="bg-gray-900 text-white w-full mt-8 pb-5">
        <div class="mt-8 border-t border-gray-700 pt-5 text-center">
            <p class="text-sm text-gray-500">&copy; <?php echo date('Y'); ?> Warehouse Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>