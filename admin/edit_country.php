<?php
session_start();
// 1. KONEKSI & AUTH
$conn = mysqli_connect("localhost", "root", "", "asiatique");
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 2. AMBIL ID DARI URL
$id = $_GET['id'] ?? '';
if(!$id) { header("Location: dashboard.php"); exit; }

// 3. PROSES SIMPAN DATA (JIKA TOMBOL UPDATE DITEKAN)
if(isset($_POST['update'])) {
    $hero_title = $_POST['hero_title'];
    $hero_image = $_POST['hero_image'];
    $intro_desc = $_POST['intro_desc'];

    // Update Query
    $stmt = mysqli_prepare($conn, "UPDATE countries SET hero_title=?, hero_image=?, intro_desc=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $hero_title, $hero_image, $intro_desc, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
}

// 4. AMBIL DATA LAMA UNTUK DITAMPILKAN DI FORM
$stmt = mysqli_prepare($conn, "SELECT * FROM countries WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Country | Asiatique</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans flex items-center justify-center min-h-screen p-4">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Edit Negara: <?= $data['name']; ?></h2>
        <a href="dashboard.php" class="text-gray-500 hover:text-gray-800">Kembali</a>
    </div>

    <form method="POST">
        
        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Hero Title (H1)</label>
            <input type="text" name="hero_title" value="<?= $data['hero_title']; ?>" class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-bold text-gray-700 mb-2">Hero Image URL (Link Gambar)</label>
            <input type="text" name="hero_image" value="<?= $data['hero_image']; ?>" class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c9a227]">
            <p class="text-xs text-gray-400 mt-1">Preview gambar lama: <a href="<?= $data['hero_image']; ?>" target="_blank" class="text-blue-500 underline">Lihat</a></p>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-bold text-gray-700 mb-2">Intro Description (Paragraf Pembuka)</label>
            <textarea name="intro_desc" rows="5" class="w-full border p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-[#c9a227]"><?= $data['intro_desc']; ?></textarea>
        </div>

        <button type="submit" name="update" class="w-full bg-[#c9a227] text-white font-bold py-3 rounded-lg hover:bg-[#b3921f] transition">
            Simpan Perubahan
        </button>

    </form>
</div>

</body>
</html>