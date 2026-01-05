<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; }

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    $hero_title = $_POST['hero_title'];
    $hero_image = $_POST['hero_image'];
    $desc       = $_POST['description'];
    $color      = $_POST['theme_color']; 

    $stmt = mysqli_prepare($conn, "INSERT INTO countries (name, slug, hero_title, hero_image, description, theme_color) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssssss", $name, $slug, $hero_title, $hero_image, $desc, $color);
    
    if (mysqli_stmt_execute($stmt)) { header("Location: dashboard.php"); }
    else { echo "<script>alert('Gagal!');</script>"; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Country</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<style>body{font-family:'Quicksand',sans-serif;}</style>
</head>
<body class="bg-gray-50 flex justify-center items-center min-h-screen p-6">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl border border-gray-200">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Negara Baru</h2>
    
    <form method="POST" class="space-y-4">
        <div>
            <label class="block font-bold mb-1 text-sm">Nama Negara</label>
            <input type="text" name="name" required class="w-full border p-3 rounded-lg">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block font-bold mb-1 text-sm">Hero Title (H1)</label>
                <input type="text" name="hero_title" required class="w-full border p-3 rounded-lg">
            </div>
            <div>
                <label class="block font-bold mb-1 text-sm">Warna Tema</label>
                <div class="flex items-center gap-2">
                    <input type="color" name="theme_color" value="#c9a227" class="h-12 w-12 cursor-pointer border-0 p-0 rounded-lg overflow-hidden">
                    <span class="text-xs text-gray-400">Klik kotak untuk pilih warna</span>
                </div>
            </div>
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm">Hero Image URL</label>
            <input type="text" name="hero_image" required class="w-full border p-3 rounded-lg">
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full border p-3 rounded-lg"></textarea>
        </div>

        <button type="submit" name="submit" class="w-full bg-gray-900 text-white py-3 rounded-lg font-bold hover:bg-black transition">Simpan Negara</button>
    </form>
</div>
</body>
</html>