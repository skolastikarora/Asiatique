<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';

if ($id) {
    $stmt = mysqli_prepare($conn, "DELETE FROM home_slides WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    if(mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php"); // Balik langsung kalau sukses
    } else {
        echo "Gagal menghapus.";
    }
} else {
    header("Location: dashboard.php");
}
?>