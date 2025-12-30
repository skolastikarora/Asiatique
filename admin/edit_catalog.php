<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';
$data = [];

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $type  = $_POST['type']; // Clothing atau Accessory
    $desc  = $_POST['description'];
    $image = $_POST['image'];

    $stmt = mysqli_prepare($conn, "UPDATE cultural_heritage SET title=?, type=?, description=?, image=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $type, $desc, $image, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Item berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
}

if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM cultural_heritage WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Catalog Item</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 flex justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Catalog Item</h2>
    <form method="POST">
        <div class="mb-4">
            <label class="block font-bold mb-1">Nama Item (Baju/Aksesoris)</label>
            <input type="text" name="title" value="<?= $data['title']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Tipe</label>
            <select name="type" class="w-full border p-2 rounded bg-white">
                <option value="Clothing" <?= $data['type'] == 'Clothing' ? 'selected' : ''; ?>>Clothing</option>
                <option value="Accessory" <?= $data['type'] == 'Accessory' ? 'selected' : ''; ?>>Accessory</option>
            </select>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" class="w-full border p-2 rounded"><?= $data['description']; ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">URL Gambar</label>
            <input type="text" name="image" value="<?= $data['image']; ?>" class="w-full border p-2 rounded">
            <img src="<?= $data['image']; ?>" class="h-24 mt-2 rounded border">
        </div>
        <div class="flex gap-2">
            <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Simpan</button>
            <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold">Batal</a>
        </div>
    </form>
</div>

</body>
</html>