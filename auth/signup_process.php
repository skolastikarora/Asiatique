<?php
session_start();

// --- KONEKSI DATABASE ---
$servername = "127.0.0.1";
$db_username = "root";
$db_password = ""; 
$dbname = "asiatique";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// --- PROSES REGISTRASI ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // 1. Ambil data (Gunakan email)
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // 2. Validasi Input
    if (empty($email) || empty($password) || empty($confirm_password)) {
        header("Location: signup.php?error=Semua kolom wajib diisi!");
        exit;
    }

    // Validasi Format Email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: signup.php?error=Format email tidak valid!");
        exit;
    }

    // 3. Cek Password Match
    if ($password !== $confirm_password) {
        header("Location: signup.php?error=Konfirmasi password tidak sesuai!");
        exit;
    }

    // 4. Cek apakah Email sudah terdaftar di tabel 'users'
    $check = $conn->prepare("SELECT email FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        header("Location: signup.php?error=Email sudah terdaftar, gunakan email lain!");
        $check->close();
        exit;
    }
    $check->close();

    // 5. Hash Password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $role = 'user';

    // 6. Insert ke tabel 'users'
    $sql = $conn->prepare("INSERT INTO users (email, password, role) VALUES (?, ?, ?)");
    $sql->bind_param("sss", $email, $hashed_password, $role);

    if ($sql->execute()) {
        // Berhasil -> Redirect ke Login
        echo "<script>
                alert('Akun berhasil dibuat! Silakan Login.');
                window.location.href = 'login.php';
              </script>";
    } else {
        // Gagal
        header("Location: signup.php?error=Terjadi kesalahan sistem!");
    }

    $sql->close();
    $conn->close();

} else {
    header("Location: signup.php");
    exit;
}
?>