<?php
session_start();
include('koneksi.php');

$error = ''; // <- ini untuk menampung pesan error

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, trim($_POST['username']));
    $password = mysqli_real_escape_string($conn, trim($_POST['password']));

    if (!empty($username) && !empty($password)) {
        $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE username = ?");
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            // Cocokkan password (tanpa hashing, ganti kalau pakai password_hash)
            if ($password == $user['password']) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                // Arahkan sesuai role
                if ($user['role'] === 'admin') {
                    header("Location: admin_dashboard.php");
                } else {
                    header("Location: user_dashboard.php");
                }
                exit();
            } else {
                $error = 'Password salah!';
            }
        } else {
            $error = 'Username salah!';
        }
    } else {
        $error = 'Silakan isi semua kolom!';
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
<body class="bg-[url(./img/2.jpg)] bg-no-repeat bg-cover bg-center h-screen font-sans leading-normal tracking-normal">
    <?php if (!empty($error)) : ?>
        <div id="toast" class="fixed top-5 left-1/2 transform -translate-x-1/2 z-50 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg animate-slide-down flex items-center gap-2">
            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 9v2m0 4h.01m-.01-10a9 9 0 110 18 9 9 0 010-18z" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span><?= htmlspecialchars($error); ?></span>
        </div>
        <script>
            setTimeout(() => {
                const toast = document.getElementById('toast');
                if (toast) toast.classList.add('animate-slide-up');
            }, 3000);
        </script>
        <style>
            @keyframes slide-down {
                0% {
                    transform: translate(-50%, -100%);
                    opacity: 0;
                }
                100% {
                    transform: translate(-50%, 0);
                    opacity: 1;
                }
            }

            @keyframes slide-up {
                0% {
                    transform: translate(-50%, 0);
                    opacity: 1;
                }
                100% {
                    transform: translate(-50%, -100%);
                    opacity: 0;
                }
            }

            .animate-slide-down {
                animation: slide-down 0.5s ease-out forwards;
            }

            .animate-slide-up {
                animation: slide-up 0.5s ease-in forwards;
            }
        </style>
    <?php endif; ?>

    <div class="flex items-center justify-center min-h-screen">
        <div class="w-full max-w-md bg-white shadow-md rounded-2xl p-6 shadow-[0_10px_40px_rgba(0,0,0,0.3)]">
            <h1 class="text-2xl font-bold text-gray-700 mb-4 text-center">Login</h1>
            <form method="POST">
            <div class="mb-4">
                <label for="username" class="block text-gray-600 font-medium mb-2">Username</label>
                <input type="text" id="username" name="username"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-600 font-medium mb-2">Password</label>
                <input type="password" id="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" />
            </div>
            <button type="submit"
                    class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-300">
                Login
            </button>
            </form>
        </div>
    </div>

</body>
</html>