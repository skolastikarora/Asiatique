<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $desc  = $_POST['description'];
    $image = $_POST['image'];
    $link  = $_POST['link_url'];
    $order = $_POST['display_order'];

    // QUERY INSERT (Menambah Data Baru)
    $stmt = mysqli_prepare($conn, "INSERT INTO home_slides (title, description, image, link_url, display_order) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssi", $title, $desc, $image, $link, $order);
    
    if (mysqli_stmt_execute($stmt)) {
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add New Slide</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style>body{font-family:'Quicksand',sans-serif;}</style>
</head>
<body class="bg-gray-100 p-8 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add New Slide</h2>
    <form method="POST">
        <div class="mb-4">
            <label class="block font-bold mb-1 text-sm text-gray-600">Judul Slide</label>
            <input type="text" name="title" required class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1 text-sm text-gray-600">Deskripsi</label>
            <textarea name="description" required rows="3" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#c9a227]"></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1 text-sm text-gray-600">URL Gambar</label>
            <input type="text" name="image" required class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
        </div>
        <div class="mb-4">
            <label class="block font-bold mb-1 text-sm text-gray-600">Link Tujuan (opsional)</label>
            <input type="text" name="link_url" placeholder="country.php?slug=..." class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
        </div>
        <div class="mb-6">
            <label class="block font-bold mb-1 text-sm text-gray-600">Urutan Tampil</label>
            <input type="number" name="display_order" value="0" class="w-full border p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
        </div>
        <div class="flex gap-2">
            <button type="submit" name="submit" class="w-full bg-[#c9a227] text-white py-2 rounded font-bold hover:bg-[#b3921f] transition">Tambah Slide</button>
            <a href="dashboard.php" class="w-full text-center border border-gray-300 text-gray-600 py-2 rounded font-bold hover:bg-gray-50 transition">Batal</a>
        </div>
    </form>
</div>

</body>
</html>