<?php 
session_start();
include('koneksi.php'); // Pastikan file koneksi tersedia

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Aktifkan mode debug untuk troubleshooting (pastikan ini false di production)
$debug_mode = true; 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan data valid
    $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $password = isset($_POST['password']) ? trim($_POST['password']) : '';

    if (empty($username) || empty($password)) {
        $error = "Harap isi semua kolom!";
    } else {
        try {
            // Gunakan prepared statement untuk mencegah SQL injection
            $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
            
            if (!$stmt) {
                throw new Exception("Database error: " . $conn->error);
            }
            
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $user = $result->fetch_assoc();
                
                // Debugging mode untuk pengujian
                if ($debug_mode) {
                    // Menyimpan informasi debugging
                    $debug_info['username'] = $username;
                    $debug_info['stored_password'] = $user['password'];
                }

                // Verifikasi dengan berbagai metode password
                $login_success = false;
                
                // Cek menggunakan password_verify (bcrypt/PHP modern hash)
                if (password_verify($password, $user['password'])) {
                    $login_success = true;
                    if ($debug_mode) $debug_info['method'] = 'password_verify';
                } 
                // Cek MD5 hash (tidak aman, hanya untuk diagnosis)
                else if (md5($password) === $user['password']) {
                    $login_success = true;
                    if ($debug_mode) $debug_info['method'] = 'md5';
                        
                    // Update password ke hash yang aman
                    $new_hash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update->bind_param("si", $new_hash, $user['id']);
                    $update->execute();
                }
                // Cek SHA1 hash (tidak aman, hanya untuk diagnosis)
                else if (sha1($password) === $user['password']) {
                    $login_success = true;
                    if ($debug_mode) $debug_info['method'] = 'sha1';
                        
                    // Update password ke hash yang aman
                    $new_hash = password_hash($password, PASSWORD_DEFAULT);
                    $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                    $update->bind_param("si", $new_hash, $user['id']);
                    $update->execute();
                }

                if ($login_success) {
                    // Login berhasil
                    session_regenerate_id(true);
                    
                    // Simpan data pengguna ke session
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['last_activity'] = time();
                    
                    // Redirect berdasarkan role
                    if ($user['role'] === 'admin') {
                        header("Location: admin/admin_dashboard.php");
                    } else {
                        header("Location: user/user_dashboard.php");
                    }
                    exit();
                } else {
                    $error = "Username atau password salah!";
                    if ($debug_mode) $debug_info['error'] = 'Password verification failed';
                }
            } else {
                $error = "Username atau password salah!";
                if ($debug_mode) $debug_info['error'] = 'Username not found';
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            $error = "Terjadi kesalahan. Silakan coba lagi nanti.";
            if ($debug_mode) $debug_info['exception'] = $e->getMessage();
        }
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