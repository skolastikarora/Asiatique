<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';
$data = [];

// AMBIL DATA LAMA
if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM cultural_heritage WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if(!$data) { echo "Data tidak ditemukan"; exit; }
}

$countries = mysqli_query($conn, "SELECT id, name FROM countries");

// PROSES UPDATE
if (isset($_POST['update'])) {
    $country_id = $_POST['country_id'];
    $title      = $_POST['title'];
    $desc       = $_POST['description'];
    $image      = $_POST['image'];
    
    // Ambil Link baru
    $link       = !empty($_POST['link']) ? $_POST['link'] : '#';

    // QUERY UPDATE: Pastikan kolom 'link=?' ada
    $stmt = mysqli_prepare($conn, "UPDATE cultural_heritage SET country_id=?, title=?, description=?, image=?, link=? WHERE id=?");
    
    // Bind: issssi (urutan: country_id, title, description, image, link, id)
    mysqli_stmt_bind_param($stmt, "issssi", $country_id, $title, $desc, $image, $link, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Item berhasil diupdate!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update.');</script>";
    }
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
            <label class="block font-bold mb-1">Negara Asal</label>
            <select name="country_id" required class="w-full border p-2 rounded bg-white">
                <option value="">-- Pilih Negara --</option>
                <?php while($c = mysqli_fetch_assoc($countries)): ?>
                    <option value="<?= $c['id']; ?>" <?= ($c['id'] == $data['country_id']) ? 'selected' : ''; ?>>
                        <?= $c['name']; ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Nama Item</label>
            <input type="text" name="title" value="<?= htmlspecialchars($data['title']); ?>" class="w-full border p-2 rounded">
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">Deskripsi</label>
            <textarea name="description" rows="5" class="w-full border p-2 rounded"><?= htmlspecialchars($data['description']); ?></textarea>
        </div>

        <div class="mb-4">
            <label class="block font-bold mb-1">URL Gambar</label>
            <input type="text" name="image" value="<?= htmlspecialchars($data['image']); ?>" class="w-full border p-2 rounded">
            <?php if (!empty($data['image'])): ?>
                <img src="<?= htmlspecialchars($data['image']); ?>" class="h-24 mt-2 rounded border object-cover">
            <?php endif; ?>
        </div>

        <div class="flex gap-2">
            <button type="submit" name="update" class="bg-blue-600 text-white px-6 py-2 rounded font-bold hover:bg-blue-700">Simpan Perubahan</button>
            <a href="dashboard.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded font-bold">Batal</a>
        </div>
    </form>
</div>

</body>
</html>