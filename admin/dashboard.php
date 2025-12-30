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
<html lang="en" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Admin | Asiatique</title>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://cdn.tailwindcss.com"></script>
<script>
    tailwind.config = {
        theme: {
            extend: {
                fontFamily: {
                    sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                },
                colors: {
                    primary: '#c9a227',
                    secondary: '#1e293b',
                }
            }
        }
    }
</script>
<style>
    /* Custom Scrollbar */
    ::-webkit-scrollbar { width: 6px; height: 6px; }
    ::-webkit-scrollbar-track { background: transparent; }
    ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    
    .material-symbols-rounded { font-size: 20px; vertical-align: sub; }
    .glass-effect { background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); }
</style>
</head>
<body class="bg-gray-50 text-slate-800 font-sans antialiased selection:bg-primary selection:text-white">

<div class="flex h-screen overflow-hidden">

    <aside class="w-72 bg-slate-900 text-slate-400 flex flex-col shadow-2xl z-20 transition-all duration-300">
        <div class="h-20 flex items-center px-8 border-b border-slate-800/50 bg-slate-900">
            <div class="flex items-center gap-3">
                <img src="../assets/images/asiatique_logo.png" alt="Logo" class="h-8 w-auto brightness-150"> <span class="text-white font-bold text-lg tracking-wide">Asiatique<span class="text-primary">.</span></span>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mb-3">Dashboard</p>
            
            <a href="#overview" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl text-white bg-primary shadow-lg shadow-primary/20 transition-all hover:scale-[1.02]">
                <span class="material-symbols-rounded">dashboard</span> Overview
            </a>

            <p class="px-4 text-[10px] font-bold text-slate-500 uppercase tracking-widest mt-6 mb-3">Management</p>
            
            <a href="#slides" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:text-primary transition-colors">view_carousel</span> Home Slides
            </a>
            <a href="#countries" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:text-green-400 transition-colors">public</span> Countries
            </a>
            <a href="#eras" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:text-purple-400 transition-colors">history_edu</span> Historical Eras
            </a>
            <a href="#catalog" class="flex items-center gap-3 px-4 py-3 text-sm font-medium rounded-xl hover:bg-slate-800 hover:text-white transition-all group">
                <span class="material-symbols-rounded group-hover:text-amber-400 transition-colors">styler</span> Cultural Catalog
            </a>
        </nav>

        <div class="p-4 border-t border-slate-800 bg-slate-900/50">
            <a href="../index.php" target="_blank" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg border border-slate-700 text-xs font-semibold text-slate-300 hover:bg-slate-800 hover:text-white transition mb-3">
                <span class="material-symbols-rounded text-sm">open_in_new</span> Visit Live Site
            </a>
            <a href="../auth/logout.php" class="flex items-center justify-center gap-2 w-full py-2.5 rounded-lg bg-red-500/10 text-red-400 hover:bg-red-500 hover:text-white text-xs font-bold transition">
                <span class="material-symbols-rounded text-sm">logout</span> Sign Out
            </a>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        
        <header class="h-20 glass-effect border-b border-gray-200 flex items-center justify-between px-8 z-10 sticky top-0">
            <div>
                <h1 class="text-xl font-bold text-slate-800">Welcome back, Admin!</h1>
                <p class="text-xs text-gray-500 mt-0.5">Here is what’s happening with your content today.</p>
            </div>
            
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-slate-700">Administrator</p>
                    <p class="text-[10px] text-gray-400 font-mono bg-gray-100 px-2 py-0.5 rounded-full inline-block"><?= $_SESSION['email']; ?></p>
                </div>
                <div class="h-10 w-10 rounded-full bg-gradient-to-tr from-primary to-amber-300 p-0.5 shadow-md">
                    <div class="h-full w-full rounded-full bg-white flex items-center justify-center text-primary">
                        <span class="material-symbols-rounded">person</span>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-8 space-y-10 pb-32 scroll-smooth">
            
            <section id="overview" class="scroll-mt-24">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Slides</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-2"><?= $count_slides; ?></h3>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-50 text-blue-600 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-rounded text-2xl">view_carousel</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Countries</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-2"><?= $count_countries; ?></h3>
                            </div>
                            <div class="p-3 rounded-xl bg-green-50 text-green-600 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-rounded text-2xl">public</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Catalog Items</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-2"><?= $count_catalog; ?></h3>
                            </div>
                            <div class="p-3 rounded-xl bg-amber-50 text-amber-600 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-rounded text-2xl">styler</span>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md transition-shadow group">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Eras</p>
                                <h3 class="text-3xl font-bold text-slate-800 mt-2"><?= $count_eras; ?></h3>
                            </div>
                            <div class="p-3 rounded-xl bg-purple-50 text-purple-600 group-hover:scale-110 transition-transform">
                                <span class="material-symbols-rounded text-2xl">history</span>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            

            <section id="slides" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-24">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-gray-50/30">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800">Home Slides</h3>
                        <p class="text-xs text-gray-500">Manage the hero carousel images and links.</p>
                    </div>
                    <a href="add_slide.php" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase rounded-lg shadow-lg shadow-slate-200 transition flex items-center gap-2">
                        <span class="material-symbols-rounded">add</span> Add New
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase tracking-wider font-bold">
                            <tr>
                                <th class="px-8 py-4">Preview</th>
                                <th class="px-8 py-4">Details</th>
                                <th class="px-8 py-4">Target Link</th>
                                <th class="px-8 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <?php while($row = mysqli_fetch_assoc($slides)): ?>
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-8 py-4 w-48">
                                    <div class="relative h-20 w-32 rounded-lg overflow-hidden shadow-sm">
                                        <img src="../<?= $row['image']; ?>" class="h-full w-full object-cover">
                                    </div>
                                </td>
                                <td class="px-8 py-4">
                                    <p class="font-bold text-slate-800 text-base mb-1"><?= $row['title']; ?></p>
                                    <p class="text-gray-500 text-xs line-clamp-2 leading-relaxed"><?= $row['description']; ?></p>
                                </td>
                                <td class="px-8 py-4">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-gray-100 text-gray-600 rounded-md text-xs font-mono border border-gray-200">
                                        <span class="material-symbols-rounded text-[14px]">link</span> <?= $row['link_url']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-center w-32">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="edit_slide.php?id=<?= $row['id']; ?>" class="h-8 w-8 flex items-center justify-center rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition"><span class="material-symbols-rounded text-base">edit</span></a>
                                        <a href="delete_slide.php?id=<?= $row['id']; ?>" class="h-8 w-8 flex items-center justify-center rounded-lg bg-red-50 text-red-600 hover:bg-red-600 hover:text-white transition" onclick="return confirm('Delete this slide?');"><span class="material-symbols-rounded text-base">delete</span></a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="countries" class="scroll-mt-24">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h3 class="font-bold text-xl text-slate-800 flex items-center gap-2"><span class="text-green-600 material-symbols-rounded">public</span> Managed Countries</h3>
                        <p class="text-sm text-gray-500">Countries displayed on the main page.</p>
                    </div>
                    <a href="add_country.php" class="px-5 py-2.5 bg-green-600 hover:bg-green-700 text-white text-xs font-bold uppercase rounded-lg shadow-lg shadow-green-200 transition flex items-center gap-2">
                        <span class="material-symbols-rounded">add_location_alt</span> Add Country
                    </a>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <?php while($row = mysqli_fetch_assoc($countries)): ?>
                        <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300 group">
                        <div class="h-40 bg-gray-200 relative overflow-hidden">
                            <img src="<?= $row['hero_image']; ?>" class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent flex items-end p-5">
                                <h4 class="text-white font-bold text-2xl tracking-wide"><?= $row['name']; ?></h4>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex justify-between items-center mb-4">
                                <p class="text-xs text-gray-400 font-bold uppercase">Slug Identifier</p>
                                <span class="text-xs text-blue-600 font-mono bg-blue-50 px-2 py-1 rounded">/<?= $row['slug']; ?></span>
                            </div>
                        <div class="flex gap-2">
                        <a href="edit_country.php?id=<?= $row['id']; ?>" class="flex-1 py-2 rounded-lg border border-gray-200 text-sm font-semibold text-gray-600 hover:bg-gray-50 hover:text-blue-600 transition text-center">
                            Edit
                        </a>
                        <a href="delete_country.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin hapus Negara ini? \n\nPERINGATAN: Jika ada data Era atau Katalog yang terhubung ke negara ini, penghapusan mungkin gagal atau data terkait ikut terhapus.');" class="flex-none w-10 py-2 rounded-lg border border-red-100 bg-red-50 text-red-500 hover:bg-red-600 hover:text-white transition flex items-center justify-center">
                            <span class="material-symbols-rounded text-lg">delete</span>
                        </a>
                    </div>

                        </div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </section>

            <section id="eras" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-24">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-purple-50/20">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2"><span class="text-purple-600 material-symbols-rounded">history_edu</span> Historical Eras</h3>
                    </div>
                    <a href="add_era.php" class="px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-xs font-bold uppercase rounded-lg shadow-lg shadow-purple-200 transition flex items-center gap-2">
                        <span class="material-symbols-rounded">add_circle</span> Add Era
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-bold">
                            <tr>
                                <th class="px-8 py-4">Country</th>
                                <th class="px-8 py-4">Era Name</th>
                                <th class="px-8 py-4">Visuals</th>
                                <th class="px-8 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <?php while($row = mysqli_fetch_assoc($eras)): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-8 py-4 font-bold text-slate-700"><?= $row['country_name']; ?></td>
                                <td class="px-8 py-4">
                                    <div class="text-primary font-bold text-base"><?= $row['era_name']; ?></div>
                                    <div class="text-xs text-gray-400">Historic Timeline</div> 
                                </td>
                                <td class="px-8 py-4">
                                    <div class="flex -space-x-3">
                                        <img src="<?= $row['image_top_url']; ?>" class="w-10 h-10 rounded-full border-2 border-white object-cover shadow-sm" title="Top Image">
                                        <img src="../<?= $row['image_bottom_path']; ?>" class="w-10 h-10 rounded-full border-2 border-white object-cover bg-gray-100 shadow-sm" title="Bottom Image">
                                    </div>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex justify-center gap-3">
                                        <a href="edit_era.php?id=<?= $row['id']; ?>" class="text-sm font-semibold text-blue-600 hover:underline">Edit</a>
                                        <span class="text-gray-300">|</span>
                                        <a href="delete_era.php?id=<?= $row['id']; ?>" class="text-sm font-semibold text-red-600 hover:underline" onclick="return confirm('Remove this era?');">Remove</a>
                                    </div>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </section>

            <section id="catalog" class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden scroll-mt-24">
                <div class="px-8 py-6 border-b border-gray-100 flex justify-between items-center bg-amber-50/20">
                    <div>
                        <h3 class="font-bold text-lg text-slate-800 flex items-center gap-2"><span class="text-amber-500 material-symbols-rounded">styler</span> Cultural Catalog</h3>
                    </div>
                    <a href="add_catalog.php" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 text-white text-xs font-bold uppercase rounded-lg shadow-lg shadow-slate-200 transition flex items-center gap-2">
                        <span class="material-symbols-rounded">add</span> Add Item
                    </a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wider font-bold">
                            <tr>
                                <th class="px-8 py-4">Image</th>
                                <th class="px-8 py-4">Item Name</th>
                                <th class="px-8 py-4">Origin</th>
                                <th class="px-8 py-4">Category</th>
                                <th class="px-8 py-4 text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50 text-sm">
                            <?php while($row = mysqli_fetch_assoc($catalog)): ?>
                            <tr class="hover:bg-gray-50 transition group">
                                <td class="px-8 py-4">
                                    <img src="<?= $row['image']; ?>" class="h-12 w-12 object-cover rounded-lg border border-gray-200 shadow-sm">
                                </td>
                                <td class="px-8 py-4 font-bold text-slate-800"><?= $row['title']; ?></td>
                                <td class="px-8 py-4 text-gray-600"><?= $row['country_name']; ?></td>
                                <td class="px-8 py-4">
                                    <span class="px-3 py-1 rounded-full text-xs font-bold border <?= ($row['type'] == 'Clothing') ? 'bg-blue-50 text-blue-600 border-blue-100' : 'bg-purple-50 text-purple-600 border-purple-100'; ?>">
                                        <?= $row['type']; ?>
                                    </span>
                                </td>
                                <td class="px-8 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="edit_catalog.php?id=<?= $row['id']; ?>" class="h-8 w-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-blue-600 hover:text-white transition"><span class="material-symbols-rounded text-base">edit</span></a>
                                        <a href="delete_catalog.php?id=<?= $row['id']; ?>" class="h-8 w-8 flex items-center justify-center rounded-lg bg-gray-100 text-gray-500 hover:bg-red-600 hover:text-white transition" onclick="return confirm('Delete item?');"><span class="material-symbols-rounded text-base">delete</span></a>
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