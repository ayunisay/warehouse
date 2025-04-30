<?php
include('../koneksi.php');

if (isset($_GET['delete'])) {
    $id_req = intval($_GET['delete']); // Pastikan parameter adalah angka

    $stmt = $conn->prepare("DELETE FROM request WHERE id_req=?");
    $stmt->bind_param("i", $id_req);

    if ($stmt->execute()) {
        // Catat aktivitas ke tabel audit_trail
        $tanggal = date('Y-m-d');
        $waktu = date('H:i:s');
        $pengguna = $_SESSION['username'] ?? 'Unknown'; // Pastikan session menyimpan username pengguna
        $aksi = "Menghapus Riwayat Permintaan Barang";
        $detail = "Menghapus Riwayat Permintaan Barang ID: " . $id_req;

        $logStmt = $conn->prepare("INSERT INTO audit_trail (tanggal, waktu, nama_pengaju, aksi, detail) VALUES (?, ?, ?, ?, ?)");
        $logStmt->bind_param("sssss", $tanggal, $waktu, $pengguna, $aksi, $detail);
        $logStmt->execute();

        $success = "Riwayat Permintaan Barang berhasil dihapus!";
        header("Location: kelola_permintaan.php");
        exit();
    } else {
        $error = "Gagal menghapus riwayat permintaan barang!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Permintaan User</title>
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
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Kelola Permintaan User</h1>

        <!-- User Requests Table -->
        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Daftar Permintaan Barang</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Alasan</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Pengguna</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-6 border-b text-center text-gray-600 font-medium w-40">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel request
                        $sql = "SELECT id_req, nama_barang, jumlah, alasan, nama_pengaju, tanggal, status FROM request WHERE status = 'Pending'";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-6 border-b'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4 border-b text-center'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['alasan']) . "</td>
                                        <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['nama_pengaju']) . "</td>
                                        <td class='py-3 px-4 border-b'>" . htmlspecialchars($row['tanggal']) . "</td>
                                        <td class='py-3 px-6 border-b text-center w-40'>
                                            <div class='flex items-center justify-center space-x-4'>
                                                <a href='../request/approve_request.php?id_req=" . $row['id_req'] . "' class='text-green-500 hover:underline flex items-center'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 13l4 4L19 7' />
                                                    </svg>
                                                    Approve
                                                </a>
                                                <a href='../request/reject_request.php?id_req=" . $row['id_req'] . "' class='text-red-500 hover:underline flex items-center'>
                                                    <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 mr-1' fill='none' viewBox='0 0 24 24' stroke='currentColor'>
                                                        <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M6 18L18 6M6 6l12 12' />
                                                    </svg>
                                                    Reject
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
            </div>
        </div>

        <!-- Request History -->
        <div class="bg-white shadow-md rounded-lg p-6 mt-8">
            <h2 class="text-2xl font-bold text-gray-700 mb-4">Riwayat Permintaan Barang</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">No</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Pengguna</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Nama Barang</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Jumlah</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Status</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Tanggal</th>
                            <th class="py-3 px-4 border-b text-left text-gray-600 font-medium">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        <?php
                        // Ambil data dari tabel request
                        $sql = "SELECT id_req, nama_pengaju, nama_barang, jumlah, status, tanggal FROM request";
                        $result = $conn->query($sql);
                        $no = 1;

                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr class='hover:bg-gray-50'>
                                        <td class='py-3 px-4'>" . htmlspecialchars($no++) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_pengaju']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['nama_barang']) . "</td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['jumlah']) . "</td>
                                        <td class='py-3 px-4'>
                                            <span class='px-2 py-1 rounded-lg text-white " . 
                                            ($row['status'] === 'Approved' ? 'bg-green-500' : ($row['status'] === 'Rejected' ? 'bg-red-500' : 'bg-yellow-500')) . "'>
                                                " . htmlspecialchars($row['status']) . "
                                            </span>
                                        </td>
                                        <td class='py-3 px-4'>" . htmlspecialchars($row['tanggal']) . "</td>
                                        <td class='py-3 px-4'>
                                            <a href='?delete=" . $row['id_req'] . "' onclick=\"return confirm('Yakin ingin menghapus?')\" class='text-red-500 hover:underline'>Hapus</a>
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
    <footer class="bg-gray-900 text-white w-full mt-8 pb-5">
        <div class="mt-8 border-t border-gray-700 pt-5 text-center">
            <p class="text-sm text-gray-500">&copy; <?php echo date('Y'); ?> Warehouse Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>