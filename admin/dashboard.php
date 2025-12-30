<?php
session_start();

// 1. KONEKSI DATABASE
$host = "localhost";
$user = "root";
$pass = "";
$db   = "asiatique";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { die("Koneksi Gagal: " . mysqli_connect_error()); }

// 2. CEK SESI ADMIN
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../index.php");
    exit;
}

// 3. AMBIL DATA
$slides = mysqli_query($conn, "SELECT * FROM home_slides ORDER BY display_order ASC");
$countries = mysqli_query($conn, "SELECT * FROM countries ORDER BY name ASC");
$eras = mysqli_query($conn, "SELECT country_eras.*, countries.name as country_name FROM country_eras JOIN countries ON country_eras.country_id = countries.id ORDER BY country_name ASC");
$catalog = mysqli_query($conn, "SELECT cultural_heritage.*, countries.name as country_name FROM cultural_heritage JOIN countries ON cultural_heritage.country_id = countries.id ORDER BY country_name ASC");

// Hitung Stats
$count_slides = mysqli_num_rows($slides);
$count_countries = mysqli_num_rows($countries);
$count_eras = mysqli_num_rows($eras);
$count_catalog = mysqli_num_rows($catalog);

// Reset pointer data
mysqli_data_seek($slides, 0);
mysqli_data_seek($countries, 0);
mysqli_data_seek($eras, 0);
mysqli_data_seek($catalog, 0);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard | Asiatique Admin</title>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://cdn.tailwindcss.com"></script>
<style>
    body { font-family: 'Quicksand', sans-serif; }
    .material-symbols-outlined { font-size: 20px; vertical-align: middle; margin-right: 8px; }
    ::-webkit-scrollbar { width: 6px; }
    ::-webkit-scrollbar-track { background: #f1f1f1; }
    ::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }
</style>
</head>
<body class="bg-gray-50 text-gray-800">

<div class="flex h-screen overflow-hidden">

    <aside class="w-64 bg-slate-800 text-slate-300 flex flex-col shadow-2xl z-10">
        <div class="h-20 flex items-center justify-center px-8 border-b border-slate-900 bg-slate-900">
            <img src="../assets/images/asiatique_logo.png" alt="Asiatique Logo" class="h-8">
        </div>
        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <p class="px-4 text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Main Menu</p>
            <a href="#overview" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg bg-[#c9a227]/20 text-[#c9a227]">
                <span class="material-symbols-outlined">dashboard</span> Overview
            </a>
            <a href="#slides" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition">
                <span class="material-symbols-outlined">view_carousel</span> Home Slides
            </a>
            <a href="#countries" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition">
                <span class="material-symbols-outlined">public</span> Countries
            </a>
            <a href="#eras" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition">
                <span class="material-symbols-outlined">history</span> Historical Eras
            </a>
            <a href="#catalog" class="flex items-center px-4 py-3 text-sm font-medium rounded-lg hover:bg-slate-700 transition">
                <span class="material-symbols-outlined">styler</span> Catalog
            </a>
        </nav>
        <div class="p-4 border-t border-slate-900 bg-slate-900">
            <a href="../index.php" target="_blank" class="flex items-center px-4 py-2 text-sm text-gray-400 hover:text-white transition">
                <span class="material-symbols-outlined">open_in_new</span> Visit Website
            </a>
            <a href="../auth/logout.php" class="flex items-center px-4 py-2 text-sm text-red-400 hover:text-red-300 transition mt-1">
                <span class="material-symbols-outlined">logout</span> Logout
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="h-20 bg-white border-b border-gray-200 flex items-center justify-between px-8 shadow-sm shrink-0">
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Overview</h1>
            <div class="flex items-center gap-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-700">Admin</p>
                    <p class="text-xs text-gray-500"><?= $_SESSION['email']; ?></p>
                </div>
                <div class="h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center text-gray-500"><span class="material-symbols-outlined !m-0">person</span></div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-12 pb-24" id="overview">
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-bold text-gray-400 uppercase">Active Slides</p><p class="text-3xl font-bold text-gray-800"><?= $count_slides; ?></p></div>
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg"><span class="material-symbols-outlined !m-0">view_carousel</span></div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-bold text-gray-400 uppercase">Countries</p><p class="text-3xl font-bold text-gray-800"><?= $count_countries; ?></p></div>
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg"><span class="material-symbols-outlined !m-0">public</span></div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-bold text-gray-400 uppercase">Catalog Items</p><p class="text-3xl font-bold text-gray-800"><?= $count_catalog; ?></p></div>
                    <div class="p-3 bg-amber-50 text-amber-600 rounded-lg"><span class="material-symbols-outlined !m-0">styler</span></div>
                </div>
                <div class="bg-white p-6 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                    <div><p class="text-xs font-bold text-gray-400 uppercase">Total Eras</p><p class="text-3xl font-bold text-gray-800"><?= $count_eras; ?></p></div>
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-lg"><span class="material-symbols-outlined !m-0">history</span></div>
                </div>
            </div>

            <section id="slides" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center"><span class="material-symbols-outlined">view_carousel</span> Home Slides</h3>
                    <a href="add_slide.php" class="px-4 py-2 bg-[#c9a227] hover:bg-[#b3921f] text-white text-xs font-bold uppercase rounded-lg shadow-sm transition flex items-center">
                        <span class="material-symbols-outlined text-sm">add</span> Add New
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="p-4 border-b">Preview</th>
                                <th class="p-4 border-b">Content</th>
                                <th class="p-4 border-b">Target Link</th>
                                <th class="p-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php while($row = mysqli_fetch_assoc($slides)): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4"><img src="../<?= $row['image']; ?>" class="h-16 w-24 object-cover rounded-lg shadow-sm border border-gray-200"></td>
                                <td class="p-4">
                                    <p class="font-bold text-gray-900 mb-1"><?= $row['title']; ?></p>
                                    <p class="text-gray-500 text-xs line-clamp-2"><?= $row['description']; ?></p>
                                </td>
                                <td class="p-4"><span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-mono"><?= $row['link_url']; ?></span></td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="edit_slide.php?id=<?= $row['id']; ?>" class="text-gray-400 hover:text-blue-600 transition"><span class="material-symbols-outlined">edit_square</span></a>
                                        <a href="delete_slide.php?id=<?= $row['id']; ?>" class="text-gray-400 hover:text-red-600 transition" onclick="return confirm('Delete?');"><span class="material-symbols-outlined">delete</span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="countries" class="space-y-4">
                <h3 class="font-bold text-gray-800 flex items-center text-lg"><span class="material-symbols-outlined">public</span> Managed Countries</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <?php while($row = mysqli_fetch_assoc($countries)): ?>
                    <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition">
                        <div class="h-32 bg-gray-200 relative">
                            <img src="<?= $row['hero_image']; ?>" class="w-full h-full object-cover">
                            <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                                <h4 class="text-white font-bold text-xl tracking-wide"><?= $row['name']; ?></h4>
                            </div>
                        </div>
                        <div class="p-4">
                            <p class="text-xs text-gray-400 uppercase font-bold mb-1">Hero Title</p>
                            <p class="text-sm text-gray-700 mb-4 line-clamp-1"><?= $row['hero_title']; ?></p>
                            <a href="edit_country.php?id=<?= $row['id']; ?>" class="block text-center w-full py-2 border border-gray-300 rounded text-sm font-bold text-gray-600 hover:bg-gray-50 transition">
                                Edit Details
                            </a>
                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="eras" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center"><span class="material-symbols-outlined">history</span> Historical Eras</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="p-4 border-b">Country</th>
                                <th class="p-4 border-b">Era</th>
                                <th class="p-4 border-b">Images</th>
                                <th class="p-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php while($row = mysqli_fetch_assoc($eras)): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4 font-bold text-gray-700"><?= $row['country_name']; ?></td>
                                <td class="p-4">
                                    <div class="text-[#c9a227] font-bold"><?= $row['era_name']; ?></div>
                                    <div class="text-xs text-gray-400"><?= $row['era_years']; ?></div>
                                </td>
                                <td class="p-4 flex -space-x-2">
                                    <img src="<?= $row['image_top_url']; ?>" class="w-8 h-8 rounded-full border-2 border-white object-cover">
                                    <img src="../<?= $row['image_bottom_path']; ?>" class="w-8 h-8 rounded-full border-2 border-white object-cover bg-gray-100">
                                </td>
                                <td class="p-4 text-center">
                                    <a href="edit_era.php?id=<?= $row['id']; ?>" class="text-blue-600 hover:underline font-semibold text-xs">Update</a>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="catalog" class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 flex items-center"><span class="material-symbols-outlined">styler</span> Cultural Catalog</h3>
                    <a href="add_catalog.php" class="px-4 py-2 bg-gray-800 hover:bg-gray-700 text-white text-xs font-bold uppercase rounded-lg shadow-sm transition flex items-center">
                        <span class="material-symbols-outlined text-sm">add</span> Add Item
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-semibold">
                            <tr>
                                <th class="p-4 border-b">Image</th>
                                <th class="p-4 border-b">Item Name</th>
                                <th class="p-4 border-b">Country</th>
                                <th class="p-4 border-b">Type</th>
                                <th class="p-4 border-b text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 text-sm">
                            <?php while($row = mysqli_fetch_assoc($catalog)): ?>
                            <tr class="hover:bg-gray-50/50 transition">
                                <td class="p-4"><img src="<?= $row['image']; ?>" class="h-12 w-12 object-cover rounded-md border border-gray-200"></td>
                                <td class="p-4 font-bold text-gray-800"><?= $row['title']; ?></td>
                                <td class="p-4 text-gray-600"><?= $row['country_name']; ?></td>
                                <td class="p-4"><span class="px-2 py-1 rounded text-xs font-semibold <?= ($row['type'] == 'Clothing') ? 'bg-blue-50 text-blue-700' : 'bg-purple-50 text-purple-700'; ?>"><?= $row['type']; ?></span></td>
                                <td class="p-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="edit_catalog.php?id=<?= $row['id']; ?>" class="text-gray-400 hover:text-blue-600 transition"><span class="material-symbols-outlined">edit_square</span></a>
                                        <a href="delete_catalog.php?id=<?= $row['id']; ?>" class="text-gray-400 hover:text-red-600 transition" onclick="return confirm('Delete?');"><span class="material-symbols-outlined">delete</span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

        </div>
    </main>
</div>
</body>
</html>