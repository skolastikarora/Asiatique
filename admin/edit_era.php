<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php"); exit;
}

$id = $_GET['id'] ?? '';
$data = [];

// 1. Ambil Data Lama
if ($id) {
    $stmt = mysqli_prepare($conn, "SELECT * FROM country_eras WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $data = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if(!$data) { die("Data Era tidak ditemukan."); }
}

$countries = mysqli_query($conn, "SELECT id, name FROM countries ORDER BY name ASC");

// --- FUNGSI KHUSUS UPLOAD ---
function uploadImage($fileInfo, $currentPath) {
    if (empty($fileInfo['name'])) {
        return $currentPath;
    }

    $targetDir = "../assets/images/"; 
    if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

    $fileName = time() . '_' . basename($fileInfo['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($fileInfo['tmp_name'], $targetFilePath)) {
        return "assets/images/" . $fileName;
    } else {
        return $currentPath;
    }
}

// 2. Proses Update
if (isset($_POST['update'])) {
    $country_id = $_POST['country_id'];
    $name       = $_POST['era_name'];
    $desc       = $_POST['description'];
    
    // A. GAMBAR ATAS
    $img_top = $_POST['image_top_url']; 

    // B. GAMBAR BAWAH
    $img_btm = uploadImage($_FILES['image_bottom_path'], $data['image_bottom_path']);

    // C. LINK SHOP (BARU)
    $shop_link = $_POST['shop_link'];

    // Update Database (Ditambahkan shop_link=?)
    $stmt = mysqli_prepare($conn, "UPDATE country_eras SET country_id=?, era_name=?, description=?, image_top_url=?, image_bottom_path=?, shop_link=? WHERE id=?");
    
    // Bind Param: isssssi (integer, string, string, string, string, string, integer)
    mysqli_stmt_bind_param($stmt, "isssssi", $country_id, $name, $desc, $img_top, $img_btm, $shop_link, $id);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Era berhasil diperbarui!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "<script>alert('Gagal update database: " . mysqli_error($conn) . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Historical Era | Asiatique Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Quicksand', sans-serif; } </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-2xl border border-gray-100">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Edit Historical Era</h2>
            <a href="dashboard.php" class="text-sm text-gray-500 hover:text-red-500 font-bold transition">Cancel</a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Negara</label>
                <div class="relative">
                    <select name="country_id" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none cursor-pointer">
                        <?php while($c = mysqli_fetch_assoc($countries)): ?>
                            <option value="<?= $c['id']; ?>" <?= ($c['id'] == $data['country_id']) ? 'selected' : ''; ?>>
                                <?= $c['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Era</label>
                <input type="text" name="era_name" value="<?= htmlspecialchars($data['era_name']); ?>" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="5" class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500"><?= htmlspecialchars($data['description']); ?></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">URL Gambar Atas (Link)</label>
                <input type="text" name="image_top_url" value="<?= htmlspecialchars($data['image_top_url']); ?>" placeholder="https://..." 
                       class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 focus:border-purple-500 outline-none">
                <p class="text-xs text-gray-400 mt-1">*Masukkan link URL gambar secara manual</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Bawah (Upload File)</label>
                
                <?php if(!empty($data['image_bottom_path'])): ?>
                    <div class="mb-2">
                        <img src="../<?= $data['image_bottom_path']; ?>" class="h-20 w-auto rounded border shadow-sm object-cover">
                        <span class="text-xs text-gray-500">File saat ini</span>
                    </div>
                <?php endif; ?>

                <input type="file" name="image_bottom_path" accept="image/*" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                <p class="text-xs text-gray-400 mt-1">*Pilih file dari komputer (C:/...)</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Link Shop Now (External)</label>
                <input type="text" name="shop_link" value="<?= htmlspecialchars($data['shop_link'] ?? ''); ?>" 
                       placeholder="https://shopee.co.id/..." 
                       class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500">
                <p class="text-xs text-gray-400 mt-1">*Masukkan link marketplace tujuan</p>
            </div>

            <div class="pt-4">
                <button type="submit" name="update" class="w-full bg-[#7e22ce] hover:bg-[#6b21a8] text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-purple-200 transition duration-300 transform hover:-translate-y-1">
                    Update Era Data
                </button>
            </div>

        </form>
    </div>

</body>
</html>