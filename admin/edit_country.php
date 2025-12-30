<?php
session_start();
// 1. KONEKSI & AUTH
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Login Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 2. AMBIL ID DARI URL
$id = $_GET['id'] ?? '';
if(!$id) { header("Location: dashboard.php"); exit; }

// 3. PROSES SIMPAN DATA (JIKA TOMBOL UPDATE DITEKAN)
if(isset($_POST['update'])) {
    // Ambil data dari Form
    $name       = $_POST['name'];
    // Auto-generate slug baru jika nama berubah
    $slug       = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
    
    $hero_title = $_POST['hero_title'];
    $hero_image = $_POST['hero_image'];
    $desc       = $_POST['description'];
    $theme_color= $_POST['theme_color']; // <--- INI PENTING (Dulu ketinggalan)

    // Update Query Lengkap
    $query = "UPDATE countries SET 
              name = ?, 
              slug = ?, 
              hero_title = ?, 
              hero_image = ?, 
              description = ?, 
              theme_color = ? 
              WHERE id = ?";

    $stmt = mysqli_prepare($conn, $query);
    
    // Bind Parameter: "ssssssi" artinya 6 String, 1 Integer (ID)
    mysqli_stmt_bind_param($stmt, "ssssssi", $name, $slug, $hero_title, $hero_image, $desc, $theme_color, $id);
    
    if(mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update: " . mysqli_error($conn) . "');</script>";
    }
}

// 4. AMBIL DATA LAMA UNTUK DITAMPILKAN DI FORM
$stmt = mysqli_prepare($conn, "SELECT * FROM countries WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Jika ID tidak ditemukan
if(!$data) { echo "Data tidak ditemukan."; exit; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Country | Asiatique</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<script src="https://cdn.tailwindcss.com"></script>
<style> body { font-family: 'Quicksand', sans-serif; } </style>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen p-6">

<div class="bg-white p-8 rounded-xl shadow-xl w-full max-w-2xl border border-gray-200">
    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800">Edit Negara</h2>
        <a href="dashboard.php" class="text-sm text-gray-500 hover:text-gray-800 transition">Kembali ke Dashboard</a>
    </div>

    <form method="POST" class="space-y-5">
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Negara (System Name)</label>
            <input type="text" name="name" value="<?= htmlspecialchars($data['name']); ?>" required
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <p class="text-xs text-gray-400 mt-1">Mengubah nama ini akan mengubah URL link negara.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Hero Title (H1)</label>
                <input type="text" name="hero_title" value="<?= htmlspecialchars($data['hero_title']); ?>" required
                       class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Warna Tema</label>
                <div class="flex items-center gap-3 border border-gray-300 p-2 rounded-lg">
                    <input type="color" name="theme_color" value="<?= !empty($data['theme_color']) ? $data['theme_color'] : '#c9a227'; ?>" 
                           class="h-10 w-16 rounded cursor-pointer border-0 bg-transparent">
                    <span class="text-xs text-gray-500">Klik warna untuk mengganti</span>
                </div>
            </div>
        </div>
        
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Hero Image URL</label>
            <input type="text" name="hero_image" value="<?= htmlspecialchars($data['hero_image']); ?>" required
                   class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition">
            <div class="mt-2 h-24 w-full bg-gray-100 rounded overflow-hidden relative">
                 <img src="<?= htmlspecialchars($data['hero_image']); ?>" class="w-full h-full object-cover opacity-70">
                 <p class="absolute inset-0 flex items-center justify-center text-xs font-bold text-gray-600 bg-white/50">Current Image Preview</p>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Intro</label>
            <textarea name="description" rows="6" required
                      class="w-full border border-gray-300 p-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition"><?= htmlspecialchars($data['description']); ?></textarea>
        </div>

        <button type="submit" name="update" class="w-full bg-gray-900 text-white font-bold py-4 rounded-lg hover:bg-black transition shadow-lg transform active:scale-95">
            Update Data Negara
        </button>

    </form>
</div>

</body>
</html>