<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");

// Cek Admin
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') { 
    header("Location: ../index.php"); exit; 
}

// Ambil list negara untuk dropdown
$countries = mysqli_query($conn, "SELECT id, name FROM countries ORDER BY name ASC");

// --- FUNGSI UPLOAD ---
function uploadImage($fileInfo) {
    if (empty($fileInfo['name'])) {
        return ""; 
    }

    $targetDir = "../assets/images/"; 
    if (!is_dir($targetDir)) { mkdir($targetDir, 0777, true); }

    $fileName = time() . '_' . basename($fileInfo['name']);
    $targetFilePath = $targetDir . $fileName;

    if (move_uploaded_file($fileInfo['tmp_name'], $targetFilePath)) {
        return "assets/images/" . $fileName; 
    } else {
        return ""; 
    }
}

if (isset($_POST['submit'])) {
    $country_id = $_POST['country_id'];
    $name       = $_POST['era_name'];
    $desc       = $_POST['description'];
    
    $img_top    = $_POST['image_top_url'];
    
    $img_btm    = uploadImage($_FILES['image_bottom_path']); 
    
    
    $shop       = $_POST['shop_link'];

    $stmt = mysqli_prepare($conn, "INSERT INTO country_eras (country_id, era_name, description, image_top_url, image_bottom_path, shop_link) VALUES (?, ?, ?, ?, ?, ?)");
    
      mysqli_stmt_bind_param($stmt, "isssss", $country_id, $name, $desc, $img_top, $img_btm, $shop);
    
    if (mysqli_stmt_execute($stmt)) { 
        echo "<script>alert('Era berhasil ditambahkan!'); window.location.href='dashboard.php';</script>";
    } else { 
        echo "<script>alert('Gagal menambah era: " . mysqli_error($conn) . "');</script>"; 
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Historical Era | Asiatique Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style> body { font-family: 'Quicksand', sans-serif; } </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-2xl border border-gray-100">
        
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-gray-800">Add New Era</h2>
            <a href="dashboard.php" class="text-sm text-gray-500 hover:text-red-500 font-bold transition">Cancel</a>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Pilih Negara</label>
                <div class="relative">
                    <select name="country_id" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none cursor-pointer focus:border-purple-500 transition">
                        <option value="">-- Pilih Negara --</option>
                        <?php while($c = mysqli_fetch_assoc($countries)): ?>
                            <option value="<?= $c['id']; ?>"><?= $c['name']; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama Era (Ancient/Modern/Dynastic)</label>
                <input type="text" name="era_name" required placeholder="Contoh: Edo Period"
                       class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500 transition">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi</label>
                <textarea name="description" rows="5" required placeholder="Jelaskan sejarah singkat era ini..."
                          class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500 transition"></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">URL Gambar Atas (Link)</label>
                <input type="text" name="image_top_url" required placeholder="https://..." 
                       class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500 transition">
                <p class="text-xs text-gray-400 mt-1">*Masukkan link URL gambar secara manual (Copy Image Address)</p>
            </div>

            <div class="p-4 bg-gray-50 rounded-xl border border-dashed border-gray-300">
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Bawah (Upload File)</label>
                
                <input type="file" name="image_bottom_path" accept="image/*" required
                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100 cursor-pointer">
                
                <p class="text-xs text-gray-400 mt-2">*Pilih file dari komputer (File akan otomatis di-upload ke folder project)</p>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Link Shop Now (External)</label>
                <input type="text" name="shop_link" placeholder="https://shopee.co.id/..." required
                       class="w-full px-4 py-3 rounded-lg bg-gray-50 border border-gray-200 outline-none focus:border-purple-500 transition">
                <p class="text-xs text-gray-400 mt-1">*Masukkan link marketplace tujuan</p>
            </div>

            <div class="pt-4">
                <button type="submit" name="submit" class="w-full bg-[#7e22ce] hover:bg-[#6b21a8] text-white font-bold py-3 px-4 rounded-lg shadow-lg shadow-purple-200 transition duration-300 transform hover:-translate-y-1">
                    Simpan Era Baru
                </button>
            </div>

        </form>
    </div>

</body>
</html>