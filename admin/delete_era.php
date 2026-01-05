<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = mysqli_prepare($conn, "SELECT image_bottom_path FROM country_eras WHERE id = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $data = mysqli_fetch_assoc($result);

    
    if ($data && !empty($data['image_bottom_path'])) {
       
        $filePath = "../" . $data['image_bottom_path'];

        if (file_exists($filePath)) {
            unlink($filePath); 
        }
    }

    $deleteStmt = mysqli_prepare($conn, "DELETE FROM country_eras WHERE id = ?");
    mysqli_stmt_bind_param($deleteStmt, "i", $id);

    if (mysqli_stmt_execute($deleteStmt)) {
        echo "<script>
                alert('Data dan gambar berhasil dihapus!'); 
                window.location.href='dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Gagal menghapus data dari database.'); 
                window.location.href='dashboard.php';
              </script>";
    }

} else {
    header("Location: dashboard.php");
}
?>