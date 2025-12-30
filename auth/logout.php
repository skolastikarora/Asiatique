<?php
session_start();

// 1. Kosongkan semua data session
$_SESSION = [];

// 2. Hapus session dari memori
session_unset();

// 3. Hancurkan session sepenuhnya
session_destroy();

// 4. Redirect kembali ke halaman utama (index.php)
// Menggunakan "../" karena file ini ada di dalam folder 'auth', jadi harus keluar satu folder dulu.
header("Location: ../index.php");
exit;
?>