<?php
session_start();
include('koneksi.php'); // Pastikan file koneksi tersedia

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $username = trim($_POST['username']);
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    // $password = trim($_POST['password']);
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    // Validasi input
    if (!empty($username) && !empty($password)) {
    // Untuk mencegah SQL Injection
    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            // put data to array association
            $user = $result->fetch_assoc();
            
            // Verifikasi password
            if ($password === $user['password']) {
                // Simpan data pengguna ke session
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Redirect berdasarkan role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    } else {
        $error = "Harap isi semua kolom!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">
    <div class="container mx-auto mt-20">
        <div class="max-w-md mx-auto bg-white shadow-md rounded-lg p-6">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Login</h1>
            <?php if (isset($error)): ?>
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            <form method="POST">
                <div class="mb-4">
                    <label for="username" class="block text-gray-600 font-medium mb-2">Username</label>
                    <input type="text" id="username" name="username" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan username" required>
                </div>
                <div class="mb-4">
                    <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                    <input type="password" id="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Masukkan password" required>
                </div>
                <button type="submit" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">Login</button>
            </form>
        </div>
    </div>
</body>
</html>