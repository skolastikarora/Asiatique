<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';
$data = [];

// Proses Update
if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $image = $_POST['image'];
    $link  = $_POST['link_url'];
    $order = $_POST['display_order'];

    $stmt = mysqli_prepare($conn, "UPDATE home_slides SET title=?, description=?, image=?, link_url=?, display_order=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssii", $title, $desc, $image, $link, $order, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Slide berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
}

// Ambil Data Lama
if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM home_slides WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Slide</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 flex justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Edit Home Slide</h2>
    <form method="POST">
        <div class="mb-4">
            <label class="block font-bold mb-1">Judul Slide</label>
            <input type="text" name="title" value="<?= $data['title']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Deskripsi</label>
            <textarea name="description" rows="3" class="w-full border p-2 rounded"><?= $data['description']; ?></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Link URL Gambar</label>
            <input type="text" name="image" value="<?= $data['image']; ?>" class="w-full border p-2 rounded">
            <img src="<?= $data['image']; ?>" class="h-20 mt-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Link Tujuan (Tombol Discover)</label>
            <input type="text" name="link_url" value="<?= $data['link_url']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1">Urutan Tampil (Angka)</label>
            <input type="number" name="display_order" value="<?= $data['display_order']; ?>" class="w-full border p-2 rounded">
        </div>
        <div class="flex gap-2">
            <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Simpan</button>
            <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold">Batal</a>
        </div>
    </form>
</div>

</body>
</html>