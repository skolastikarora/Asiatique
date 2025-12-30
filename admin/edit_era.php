<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';
$data = [];

if (isset($_POST['update'])) {
    $name  = $_POST['era_name'];
    $years = $_POST['era_years'];
    $desc  = $_POST['description'];
    $img_top = $_POST['image_top_url'];
    $img_btm = $_POST['image_bottom_path']; // Asumsi input URL text

    $stmt = mysqli_prepare($conn, "UPDATE country_eras SET era_name=?, era_years=?, description=?, image_top_url=?, image_bottom_path=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $name, $years, $desc, $img_top, $img_btm, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Era berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
}

if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM country_eras WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Era</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 flex justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Historical Era</h2>
    <form method="POST">
        <div class="mb-4">
            <label class="block font-bold mb-1">Nama Era</label>
            <input type="text" name="era_name" value="<?= $data['era_name']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Tahun Era</label>
            <input type="text" name="era_years" value="<?= $data['era_years']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded"><?= $data['description']; ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">URL Gambar Atas (Top)</label>
            <input type="text" name="image_top_url" value="<?= $data['image_top_url']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">URL Gambar Bawah (Bottom)</label>
            <input type="text" name="image_bottom_path" value="<?= $data['image_bottom_path']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="flex gap-2">
            <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Simpan</button>
            <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold">Batal</a>
        </div>
    </form>
</div>

</body>
</html>