<?php
session_start();
include('koneksi.php'); 

if (!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header('Location: login.php'); // atau redirect ke halaman error/403
    exit();
}

if (isset($_GET['delete'])) {
    $id_barang_rsk = intval($_GET['delete']); // Pastikan parameter adalah angka

    $stmt = $conn->prepare("DELETE FROM barang_rusak WHERE id_barang_rsk=?");
    $stmt->bind_param("i", $id_barang_rsk);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Menghapus Riwayat Laporan Kerusakan Barang";
        $detail = "Menghapus Riwayat Laporan Kerusakan Barang ID: " . $id_supp;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Riwayat Laporan Kerusakan Barang berhasil dihapus!";
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error = "Gagal menghapus Riwayat Laporan Kerusakan Barang!";
    }
}

// Total Items
$queryTotalItems = "SELECT COUNT(*) AS total_items FROM stok_barang";
$resultTotalItems = $conn->query($queryTotalItems);
$totalItems = $resultTotalItems->fetch_assoc()['total_items'] ?? 0;

// Pending Requests
$queryPendingRequests = "SELECT COUNT(*) AS pending_requests FROM request WHERE status = 'Pending'";
$resultPendingRequests = $conn->query($queryPendingRequests);
$pendingRequests = $resultPendingRequests->fetch_assoc()['pending_requests'] ?? 0;

// Barang kelaur
$queryCompletedTransactions = "SELECT COUNT(*) AS completed_transactions FROM keluar WHERE jumlah";
$resultCompletedTransactions = $conn->query($queryCompletedTransactions);
$completedTransactions = $resultCompletedTransactions->fetch_assoc()['completed_transactions'] ?? 0;

// Tren Permintaan Barang
$sqlTrends = "SELECT nama_barang, COUNT(*) AS jumlah_permintaan, 
              CASE 
                  WHEN COUNT(*) > 10 THEN 'High Demand'
                  WHEN COUNT(*) BETWEEN 3 AND 5 THEN 'Moderate Demand'
                  ELSE 'Low Demand'
              END AS status
              FROM request
              GROUP BY nama_barang
              ORDER BY jumlah_permintaan DESC";
$resultTrends = $conn->query($sqlTrends);

if (!$resultTrends) {
    error_log("Error pada query Tren Permintaan Barang: " . $conn->error);
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal min-h-screen flex flex-col">
        <!-- Navbar -->
        <nav class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
            <div class="container mx-auto px-6 py-4 flex justify-between items-center">
                <!-- Logo -->
                <a href="admin_dashboard.php" class="text-2xl font-extrabold tracking-wide hover:text-yellow-400 transition duration-300">
                    <span class="text-yellow-400">Warehouse</span> Management
                </a>

                <!-- Navigation Links -->
                <div class="flex items-center space-x-11">
                    <ul class="flex space-x-6 text-sm font-medium">
                        <li>
                            <a href="admin_dashboard.php" class="hover:text-yellow-400 transition duration-300">Dashboard</a>
                        </li>
                        <li>
                            <a href="./admin/kelola_stok.php" class="hover:text-yellow-400 transition duration-300">Stok</a>
                        </li>
                        <li>
                            <a href="./admin/kelola_supplier.php" class="hover:text-yellow-400 transition duration-300">Supplier</a>
                        </li>
                        <li>
                            <a href="./admin/kelola_user.php" class="hover:text-yellow-400 transition duration-300">User</a>
                        </li>
                        <li>
                            <a href="./admin/riwayat.php" class="hover:text-yellow-400 transition duration-300">Riwayat Keluar</a>
                        </li>
                        <li>
                            <a href="./admin/kelola_permintaan.php" class="hover:text-yellow-400 transition duration-300">Permintaan Barang</a>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Admin Dashboard</h1>

        <!-- Statistics Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Items -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Total Items</h2>
                <p class="text-4xl font-semibold text-blue-600 mt-4"><?php echo $totalItems; ?></p>
                <p class="text-sm text-gray-500 mt-2">Total items available in stock.</p>
            </div>

            <!-- Pending Requests -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Pending Requests</h2>
                <p class="text-4xl font-semibold text-yellow-600 mt-4"><?php echo $pendingRequests; ?></p>
                <p class="text-sm text-gray-500 mt-2">User requests awaiting approval.</p>
            </div>

            <!-- Completed Transactions -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-bold text-gray-700">Completed Transactions</h2>
                <p class="text-4xl font-semibold text-green-600 mt-4"><?php echo $completedTransactions; ?></p>
                <p class="text-sm text-gray-500 mt-2">Transactions successfully completed.</p>
            </div>
        </div>

        <!-- Menu2 -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8 flex-grow">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Generate Laporan -->
                <a href="./admin/generate_laporan.php" class="group block bg-gradient-to-r from-blue-500 to-blue-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <!-- Ikon Baru: Ikon Dokumen -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 4H7a2 2 0 01-2-2V6a2 2 0 012-2h7l5 5v11a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Generate Laporan</h3>
                            <p class="text-sm text-white text-opacity-80">Export laporan stok, laporan transaksi, dan laporan permintaan barang.</p>
                        </div>
                    </div>
                </a>

                <!-- Audit Trail -->
                <a href="./admin/audit_trail.php" class="group block bg-gradient-to-r from-green-500 to-green-600 text-white p-6 rounded-lg shadow-lg hover:shadow-xl transition duration-300">
                    <div class="flex items-center space-x-4">
                        <div class="bg-white bg-opacity-20 p-3 rounded-full">
                            <!-- Ikon Baru: Ikon Jejak -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c1.657 0 3-1.343 3-3S13.657 2 12 2 9 3.343 9 5s1.343 3 3 3zm0 0v13m0-13c-1.657 0-3 1.343-3 3s1.343 3 3 3 3-1.343 3-3-1.343-3-3-3z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Audit Trail</h3>
                            <p class="text-sm text-white text-opacity-80">View system activity logs.</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>


            <!-- Tren Permintaan Barang -->
            <div class="bg-white shadow-md rounded-lg p-6 mt-8 flex-grow">
                <h2 class="text-2xl font-bold text-gray-700 mb-4">Tren Permintaan Barang</h2>
                <table class="min-w-full bg-white border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Jumlah Permintaan</th>
                            <th class="py-2 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($resultTrends && $resultTrends->num_rows > 0) {
                            while ($trend = $resultTrends->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-2 px-4 border-b'>" . htmlspecialchars($trend['nama_barang']) . "</td>
                                        <td class='py-2 px-4 border-b'>" . htmlspecialchars($trend['jumlah_permintaan']) . "</td>
                                        <td class='py-2 px-4 border-b'>" . htmlspecialchars($trend['status']) . "</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='3' class='py-2 px-4 border-b text-center text-gray-500'>Belum ada data tren permintaan barang.</td>
                                </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

        <!-- User Laporan Table -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8 flex-grow">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Laporan Kerusakan Barang</h2>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Deskripsi</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                        <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                        <th class="py-3 px-4 border-b text-center text-gray-600 font-medium">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php

                    // Ambil data dari tabel barang_rusak
                    $sql = "SELECT barang_rusak.id_barang_rsk, stok_barang.id_barang, stok_barang.nama_barang, barang_rusak.jumlah, barang_rusak.deskripsi, barang_rusak.status, barang_rusak.tanggal FROM barang_rusak JOIN stok_barang ON barang_rusak.id_barang = stok_barang.id_barang WHERE status = 'Pending'";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='hover:bg-gray-50'>
                                    <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                    <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['jumlah']) . "</td>
                                    <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['deskripsi']) . "</td>
                                    <td class='py-3 px-4 border-b'>
                                        <span class='px-2 py-1 rounded-lg text-white " . 
                                        ($row['status'] === 'Resolved' ? 'bg-green-500' : ($row['status'] === 'Rejected' ? 'bg-red-500' : 'bg-yellow-500')) . "'>
                                            " . htmlspecialchars($row['status']) . "
                                        </span>
                                    </td>
                                    <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['tanggal']) . "</td>
                                    <td class='py-3 px-4 border-b text-center'>
                                        <div class='flex items-center justify-center space-x-4'>
                                            <a href='/warehouse/barang_rusak/resolved.php?id_barang_rsk=" . $row['id_barang_rsk'] . "' class='text-green-500 hover:underline flex items-center'>
                                                <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7' />
                                                </svg>
                                                Resolved
                                            </a>
                                            <a href='/warehouse/barang_rusak/rejected_laporan.php?id_barang_rsk=" . $row['id_barang_rsk'] . "' class='text-red-500 hover:underline flex items-center'>
                                                <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                    <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                                                </svg>
                                                Rejected
                                            </a>
                                        </div>
                                    </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr>
                                <td colspan='6' class='py-3 px-4 border-b text-center text-gray-500'>Belum ada permintaan barang.</td>
                            </tr>";
                    }
                    ?>
                </tbody>
            </table>

            <div class="overflow-x-auto mt-5">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Deskripsi</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel request
                        $sql = "SELECT barang_rusak.id_barang_rsk, stok_barang.id_barang, stok_barang.nama_barang, barang_rusak.jumlah, barang_rusak.deskripsi, barang_rusak.status, barang_rusak.tanggal FROM barang_rusak JOIN stok_barang ON barang_rusak.id_barang = stok_barang.id_barang ORDER BY barang_rusak.tanggal DESC";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['deskripsi']) . "</td>
                                        <td class='py-3 px-4'>
                                            <span class='px-2 py-1 rounded-lg text-white " . 
                                            ($row['status'] === 'Resolved' ? 'bg-green-500' : ($row['status'] === 'Rejected' ? 'bg-red-500' : 'bg-yellow-500')) . "'>
                                                " . htmlspecialchars($row['status']) . "
                                            </span>
                                        </td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['tanggal']) . "</td>
                                        <td class='py-3 px-4'>
                                            <a href='?delete=" . $row['id_barang_rsk'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
                                        </td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr>
                                    <td colspan='7' class='py-3 px-4 text-center text-gray-500'>Belum ada data permintaan barang.</td>
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