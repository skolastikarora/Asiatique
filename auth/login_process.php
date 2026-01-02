<?php
session_start();

// 1. Hubungkan ke Database
// Menggunakan __DIR__ agar path mendeteksi folder saat ini lalu naik satu level (..)
require_once __DIR__ . "/../config/database.php"; 

$email    = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

// 2. Ambil data user berdasarkan email
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
$user   = mysqli_fetch_assoc($result);

// 3. VERIFIKASI: Cek user ada DAN password cocok
if ($user && password_verify($password, $user['password'])) {

    // --- Login Sukses ---
    $_SESSION['login']   = true;
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['role']    = $user['role'];
    $_SESSION['email']   = $user['email'];

    // 4. Redirect sesuai Role
    if ($user['role'] === 'admin') {
        // Jika admin, masuk ke folder admin
        header("Location: ../admin/dashboard.php");
    } else {
        // Jika user biasa, KELUAR folder auth menuju country.php di root
        header("Location: ../country.php"); 
    }
    exit;

} else {
    // --- Login Gagal ---
    $pesan = "Email atau Password salah!";
    
    // PERBAIKAN PENTING DI SINI:
    // Jangan tulis "auth/login.php", cukup "login.php" 
    // karena file ini (login_process.php) SUDAH ADA di dalam folder auth.
    header("Location: login.php?error=" . urlencode($pesan));
    exit;
}
?>