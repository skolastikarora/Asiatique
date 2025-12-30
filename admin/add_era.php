<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { header("Location: ../index.php"); exit; }

// Ambil list negara untuk dropdown
$countries = mysqli_query($conn, "SELECT id, name FROM countries ORDER BY name ASC");

if (isset($_POST['submit'])) {
    $country_id = $_POST['country_id'];
    $name  = $_POST['era_name'];
    $desc  = $_POST['description'];
    $img_top = $_POST['image_top_url'];
    $img_btm = $_POST['image_bottom_path']; 
    // Default link shop dummy
    $shop = "#";

    $stmt = mysqli_prepare($conn, "INSERT INTO country_eras (country_id, era_name, description, image_top_url, image_bottom_path, shop_link) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "isssss", $country_id, $name, $desc, $img_top, $img_btm, $shop);
    
    if (mysqli_stmt_execute($stmt)) { header("Location: dashboard.php"); } 
    else { echo "<script>alert('Gagal menambah era.');</script>"; }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<title>Add Era</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<style>body{font-family:'Quicksand',sans-serif;}</style>
</head>
<body class="bg-gray-100 p-8 flex justify-center items-center min-h-screen">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-lg border border-gray-200">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Add Historical Era</h2>
    <form method="POST" class="space-y-4">
        
        <div>
            <label class="block font-bold mb-1 text-sm text-gray-600">Pilih Negara</label>
            <select name="country_id" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
                <option value="">-- Pilih --</option>
                <?php while($c = mysqli_fetch_assoc($countries)): ?>
                    <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm text-gray-600">Nama Era (Ancient/Modern/Dynastic)</label>
            <input type="text" name="era_name" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm text-gray-600">Deskripsi</label>
            <textarea name="description" rows="3" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500"></textarea>
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm text-gray-600">URL Gambar Atas (Utama)</label>
            <input type="text" name="image_top_url" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
        </div>

        <div>
            <label class="block font-bold mb-1 text-sm text-gray-600">URL Gambar Bawah (Kecil/Detail)</label>
            <input type="text" name="image_bottom_path" required class="w-full border p-2 rounded focus:ring-2 focus:ring-purple-500">
        </div>

        <button type="submit" name="submit" class="w-full bg-purple-700 text-white py-3 rounded font-bold hover:bg-purple-800 transition">Simpan Era</button>
    </form>
</div>

</body>
</html>