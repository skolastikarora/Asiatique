<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

// Ambil data negara untuk dropdown
$countries = mysqli_query($conn, "SELECT id, name FROM countries");

if (isset($_POST['submit'])) {
    $country_id = $_POST['country_id'];
    $title      = $_POST['title'];
    $desc       = $_POST['description'];
    $image      = $_POST['image'];
    
    // Ambil Link dari form. Jika kosong, isi dengan '#'
    $link       = !empty($_POST['link']) ? $_POST['link'] : '#'; 

    // QUERY INSERT: Pastikan kolom 'link' ada di sini
    $stmt = mysqli_prepare($conn, "INSERT INTO cultural_heritage (country_id, title, description, image, link) VALUES (?, ?, ?, ?, ?)");
    
    // Bind: i (int), s (string) -> urutan: country_id, title, description, image, link
    mysqli_stmt_bind_param($stmt, "issss", $country_id, $title, $desc, $image, $link);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Item berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal menambah data.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Add Catalog Item</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8 flex justify-center">

<div class="bg-white p-8 rounded-xl shadow-lg w-full max-w-2xl">
    <h2 class="text-2xl font-bold mb-6">Add New Catalog Item</h2>
    <form method="POST">
        
        <div class="mb-4">
            <label class="block font-bold mb-1">Negara Asal</label>
            <select name="country_id" required class="w-full border p-2 rounded bg-white">
                <option value="">-- Pilih Negara --</option>
                <?php while($row = mysqli_fetch_assoc($countries)): ?>
                    <option value="<?= $row['id']; ?>"><?= $row['name']; ?></option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Nama Item</label>
            <input type="text" name="title" required class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Deskripsi</label>
            <textarea name="description" rows="4" required class="w-full border p-2 rounded"></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">URL Gambar</label>
            <input type="text" name="image" required class="w-full border p-2 rounded">
        </div>


        <div class="flex gap-2">
            <button type="submit" name="submit" class="bg-green-600 text-white px-6 py-2 rounded font-bold hover:bg-green-700">Tambah Item</button>
            <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold">Batal</a>
        </div>
    </form>
</div>

</body>
</html>