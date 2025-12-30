<?php
session_start();

// 1. Path yang benar (naik satu folder dari auth, lalu masuk config)
require_once __DIR__ . "/../config/database.php";

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// 2. Ambil data user berdasarkan email
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user   = mysqli_fetch_assoc($result);

// 3. VERIFIKASI: Gunakan password_verify karena password di DB terenkripsi
if ($user && password_verify($password, $user['password'])) {

    // Set session jika login sukses
    $_SESSION['login']   = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];
    $_SESSION['email']   = $user['email'];

    // 4. Redirect ke halaman yang benar (gunakan ../ untuk keluar dari folder auth)
    if ($user['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../index.php");
    }
    exit;

} else {
    // Jika login gagal (password salah atau email tidak ada)
    echo "<script>
            alert('Email atau Password salah!');
            window.location.href='login.php';
          </script>";
}
?>