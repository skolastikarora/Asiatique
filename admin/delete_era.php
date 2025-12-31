<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// 1. Cek Admin (Security)
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

// 2. Cek apakah ada ID yang dikirim
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // --- LANGKAH 1: AMBIL DATA DULU (Untuk cari lokasi gambar) ---
    // Kita harus tahu nama file gambarnya sebelum menghapus datanya
    $stmt = mysqli_prepare($conn, "SELECT image_bottom_path FROM country_eras WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    // --- LANGKAH 2: HAPUS FILE FISIK DI FOLDER ---
    // Cek apakah data ditemukan dan kolom gambar tidak kosong
    if ($data && !empty($data['image_bottom_path'])) {
        // Tambahkan "../" karena file ini ada di folder admin, sedangkan gambar di luar
        $filePath = "../" . $data['image_bottom_path'];

        // Hapus file jika ada di komputer
        if (file_exists($filePath)) {
            unlink($filePath); // Fungsi PHP untuk menghapus file
        }
    }

    // --- LANGKAH 3: HAPUS DATA DARI DATABASE ---
    $deleteStmt = mysqli_prepare($conn, "DELETE FROM country_eras WHERE id = ?");
    mysqli_stmt_bind_param($deleteStmt, "i", $id);

    if (mysqli_stmt_execute($deleteStmt)) {
        // Berhasil hapus
        echo "<script>
                alert('Data dan gambar berhasil dihapus!'); 
                window.location.href='dashboard.php';
              </script>";
    } else {
        // Gagal hapus
        echo "<script>
                alert('Gagal menghapus data dari database.'); 
                window.location.href='dashboard.php';
              </script>";
    }

} else {
    // Jika tidak ada ID, kembalikan ke dashboard
    header("Location: dashboard.php");
}
?>