<?php
session_start();

// 1. Koneksi Database
$conn = mysqli_connect("localhost", "root", "", "asiatique");
if (!$conn) { die("Koneksi Database Gagal: " . mysqli_connect_error()); }

// 2. Ambil ID dari URL
$id = $_GET['id'] ?? '';
if (empty($id)) { header("Location: index.php"); exit; }

// 3. Query Detail Heritage
$query = "SELECT h.*, c.name as country_name, c.slug as country_slug, c.theme_color 
          FROM cultural_heritage h 
          JOIN countries c ON h.country_id = c.id 
          WHERE h.id = ?";

$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) { header("Location: index.php"); exit; }

$themeColor = !empty($data['theme_color']) ? $data['theme_color'] : '#c9a227';
$menu_countries = mysqli_query($conn, "SELECT name, slug FROM countries ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asiatique | <?= htmlspecialchars($data['title']); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #f9f9f9; }
        .font-imperial { font-family: 'Imperial Script', cursive; }
        .material-symbols-outlined { vertical-align: middle; }
        
        :root { --theme-color: <?= $themeColor; ?>; }
        
        .text-theme { color: var(--theme-color) !important; }
        .bg-theme { background-color: var(--theme-color) !important; }
        .border-theme { border-color: var(--theme-color) !important; }
        .hover-bg-theme:hover { background-color: var(--theme-color) !important; }
        .hover-text-theme:hover { color: var(--theme-color) !important; }
    </style>
</head>

<body class="pt-24 pb-10">

    <header class="fixed top-0 left-0 w-full bg-white/95 backdrop-blur z-50 shadow-sm transition-all">
        <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
            <a href="index.php"><img src="assets/images/asiatique_logo.png" class="h-10"></a>
            
            <nav class="hidden md:flex gap-8 text-sm font-semibold text-gray-700 items-center">
                <a href="index.php" class="hover-text-theme transition">Home</a>
                <div class="relative group">
                    <button class="flex items-center gap-1 hover-text-theme transition py-2">
                        Country <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
                    </button>
                    <div class="absolute top-full left-0 mt-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform translate-y-2 group-hover:translate-y-0">
                        <?php if(mysqli_num_rows($menu_countries) > 0): 
                            mysqli_data_seek($menu_countries, 0);
                            while($c = mysqli_fetch_assoc($menu_countries)): ?>
                            <a href="country.php?slug=<?= $c['slug']; ?>" class="block px-5 py-3 hover:bg-gray-50 text-gray-600 hover-text-theme transition"><?= $c['name']; ?></a>
                        <?php endwhile; endif; ?>
                    </div>
                </div>
            </nav>

            <div class="relative">
                <?php if (!isset($_SESSION['login'])) : ?>
                    <a href="auth/login.php" class="px-5 py-2 rounded-full bg-theme text-white text-xs font-bold hover:opacity-90 transition">Log in</a>
                <?php else: ?>
                    <button class="flex items-center gap-2 px-3 py-1 rounded-full hover:bg-gray-100 transition"><span class="material-symbols-outlined text-3xl text-gray-600">account_circle</span></button>
                <?php endif; ?>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-6">
        
        <div class="mb-8">
            <a href="country.php?slug=<?= $data['country_slug']; ?>" class="inline-flex items-center gap-2 text-gray-500 hover-text-theme transition text-sm font-bold uppercase tracking-wider">
                <span class="material-symbols-outlined">arrow_back</span>
                Back to <?= $data['country_name']; ?>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
            
            <div class="lg:col-span-5 sticky top-28">
                <div class="rounded-2xl overflow-hidden shadow-2xl relative bg-white p-2">
                    <div class="relative h-[500px] w-full rounded-xl overflow-hidden">
                        <img src="<?= $data['image']; ?>" class="w-full h-full object-cover transform hover:scale-105 transition duration-700" alt="<?= $data['title']; ?>">
                    </div>
                </div>
                
                <div class="mt-6 flex flex-wrap gap-2">
                    <span class="px-4 py-1 rounded-full bg-white border border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-widest">Cultural Heritage</span>
                    <span class="px-4 py-1 rounded-full border border-theme text-theme text-xs font-bold uppercase tracking-widest"><?= $data['country_name']; ?></span>
                </div>
            </div>

<div class="lg:col-span-7 bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 min-w-0"> <h1 class="font-imperial text-5xl md:text-7xl text-gray-800 mb-6 leading-tight">
        <?= $data['title']; ?>
    </h1>

    <div class="w-24 h-1 bg-theme mb-8"></div>

    <div class="prose prose-lg prose-gray max-w-none w-full break-words font-light leading-loose text-justify text-gray-600">
        <?= nl2br(htmlspecialchars($data['description'])); ?>
    </div>

    <div class="mt-12 pt-8 border-t border-gray-100 grid grid-cols-2 gap-6">
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Era / Period</p>
            <p class="text-gray-800 font-medium">Traditional History</p>
        </div>
        <div>
            <p class="text-xs text-gray-400 uppercase tracking-wider font-bold mb-1">Preservation</p>
            <p class="text-gray-800 font-medium">Cultural Asset</p>
        </div>
    </div>
</div>


        </div>

    </main>

    <footer class="text-center py-10 mt-10 text-gray-400 text-sm border-t border-gray-200">
        &copy; <?= date('Y'); ?> Asiatique. Preserving Culture.
    </footer>

</body>
</html>