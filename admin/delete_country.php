<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';

if ($id) {
    // Hapus Negara (Data Era & Catalog terkait idealnya dihapus juga, 
    // tapi ini hapus negaranya saja dulu)
    $stmt = mysqli_prepare($conn, "DELETE FROM countries WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Negara berhasil dihapus!'); window.location='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menghapus.'); window.location='dashboard.php';</script>";
    }
} else {
    header("Location: dashboard.php");
}
?>