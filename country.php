<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "asiatique");
if (!$conn) { die("Koneksi Database Gagal"); }

$slug = $_GET['slug'] ?? '';
if (empty($slug)) { header("Location: index.php"); exit; }

// QUERY DATA NEGARA (Termasuk theme_color)
$stmt = mysqli_prepare($conn, "SELECT * FROM countries WHERE slug = ?");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$country = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$country) { header("Location: index.php"); exit; }

// Set Default Warna jika kosong
$themeColor = !empty($country['theme_color']) ? $country['theme_color'] : '#c9a227';

// Query Era & Catalog
$stmt_eras = mysqli_prepare($conn, "SELECT * FROM country_eras WHERE country_id = ? ORDER BY id ASC");
mysqli_stmt_bind_param($stmt_eras, "i", $country['id']);
mysqli_stmt_execute($stmt_eras);
$eras = mysqli_stmt_get_result($stmt_eras);

$stmt_catalog = mysqli_prepare($conn, "SELECT * FROM cultural_heritage WHERE country_id = ?");
mysqli_stmt_bind_param($stmt_catalog, "i", $country['id']);
mysqli_stmt_execute($stmt_catalog);
$catalog = mysqli_stmt_get_result($stmt_catalog);

$menu_countries = mysqli_query($conn, "SELECT name, slug FROM countries ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Asiatique | <?= htmlspecialchars($country['name']); ?></title>

<link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://cdn.tailwindcss.com"></script>

<style>
  body { font-family: 'Quicksand', sans-serif; background-color: #f5f2ee; }
  .font-imperial { font-family: 'Imperial Script', cursive; }
  .material-symbols-outlined { vertical-align: middle; }
  
  /* DINAMIS CSS VARIABLE DARI DATABASE */
  :root {
      --theme-color: <?= $themeColor; ?>;
  }
  
  /* Apply Theme Color */
  .text-theme { color: var(--theme-color) !important; }
  .bg-theme { background-color: var(--theme-color) !important; }
  .border-theme { border-color: var(--theme-color) !important; }
  .hover-text-theme:hover { color: var(--theme-color) !important; }
  .hover-bg-theme:hover { background-color: var(--theme-color) !important; }
  .hover-border-theme:hover { border-color: var(--theme-color) !important; }
</style>
</head>

<body>

<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur z-50 shadow-sm transition-all duration-300">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <a href="index.php"><img src="assets/images/asiatique_logo.png" class="h-10"></a>
    
    <nav class="hidden md:flex gap-8 text-sm font-semibold text-gray-700 items-center">
      <a href="index.php" class="hover-text-theme transition">Home</a>
      
      <div class="relative group">
        <button class="flex items-center gap-1 hover-text-theme transition py-2">
          Country <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
        </button>
        <div class="absolute top-full left-0 mt-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform translate-y-2 group-hover:translate-y-0">
           <?php 
           if(mysqli_num_rows($menu_countries) > 0):
             mysqli_data_seek($menu_countries, 0); 
             while($c = mysqli_fetch_assoc($menu_countries)): 
           ?>
             <a href="country.php?slug=<?= $c['slug']; ?>" class="block px-5 py-3 hover:bg-gray-50 text-gray-600 hover-text-theme transition"><?= $c['name']; ?></a>
           <?php endwhile; endif; ?>
        </div>
      </div>
    </nav>
    
    <div class="relative group">
       <?php if (!isset($_SESSION['login'])) : ?>
         <a href="auth/login.php" class="px-5 py-2 rounded-full bg-theme text-white text-xs font-bold hover:opacity-90 transition">Log in</a>
       <?php else: ?>
         <button class="flex items-center gap-2 px-3 py-1 rounded-full hover:bg-gray-100 transition"><span class="material-symbols-outlined text-3xl text-gray-600">account_circle</span></button>
       <?php endif; ?>
    </div>
  </div>
</header>
<div class="h-20"></div>

<section class="relative h-[60vh] w-full overflow-hidden">
  <img src="<?= htmlspecialchars($country['hero_image']); ?>" class="absolute inset-0 w-full h-full object-cover">
  <div class="absolute inset-0 bg-black/40"></div>
  <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
    <h1 class="font-imperial text-7xl md:text-9xl text-white drop-shadow-lg mb-4"><?= htmlspecialchars($country['hero_title']); ?></h1>
  </div>
</section>

<?php if(!empty($country['description'])): ?>
<section class="py-16 px-6 max-w-4xl mx-auto text-center">
  <div class="flex items-center justify-center gap-4 mb-6">
    <div class="w-16 h-[2px] bg-theme"></div>
    <span class="uppercase tracking-widest text-theme text-sm font-bold">Introduction</span>
    <div class="w-16 h-[2px] bg-theme"></div>
  </div>
  <p class="text-xl text-gray-700 leading-relaxed font-light"><?= nl2br(htmlspecialchars($country['description'])); ?></p>
</section>
<?php endif; ?>

<section class="py-10 px-6 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <?php if(mysqli_num_rows($eras) > 0): while($era = mysqli_fetch_assoc($eras)): ?>
      <div class="flex flex-col gap-4 text-center group">
        <div class="h-64 rounded-2xl overflow-hidden relative shadow-lg cursor-pointer">
           <img src="<?= $era['image_top_url']; ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
           <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition"></div>
           <h3 class="absolute bottom-6 left-1/2 -translate-x-1/2 font-imperial text-5xl text-white drop-shadow-md whitespace-nowrap"><?= $era['era_name']; ?></h3>
        </div>
        <p class="text-gray-600 text-sm leading-relaxed px-2 min-h-[60px]"><?= $era['description']; ?></p>
        <div class="h-40 rounded-xl overflow-hidden mt-2 shadow-sm">
            <img src="<?= $era['image_bottom_path']; ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
        </div>
        <a href="#" class="mt-2 inline-block border border-gray-300 px-6 py-2 rounded-full text-xs uppercase tracking-widest hover-bg-theme hover:text-white hover-border-theme transition">Shop Collection</a>
      </div>
      <?php endwhile; endif; ?>
    </div>
  </div>
</section>

<section class="py-20 px-6 bg-[#f5f2ee]">
    <div class="max-w-7xl mx-auto">
      <div class="flex items-center justify-center gap-6 mb-16">
        <div class="w-24 h-[1px] bg-theme"></div>
        <h2 class="font-imperial text-5xl text-theme text-center">Cultural Heritage</h2>
        <div class="w-24 h-[1px] bg-theme"></div>
      </div>
      
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php if(mysqli_num_rows($catalog) > 0): while ($row = mysqli_fetch_assoc($catalog)): ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md group relative h-[400px]">
                  <img src="<?= $row['image']; ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                  <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-8 text-center text-white">
                      <h3 class="font-imperial text-4xl mb-4 text-theme"><?= $row['title']; ?></h3>
                      <p class="text-sm mb-8 line-clamp-4 leading-relaxed opacity-90"><?= $row['description']; ?></p>
                      <a href="#" class="px-8 py-3 border border-theme text-theme rounded-full hover-bg-theme hover:text-white transition uppercase text-xs tracking-widest font-bold">Read More</a>
                  </div>
              </div>
          <?php endwhile; endif; ?>
      </div>
    </div>
</section>

<footer class="bg-white text-center py-10 text-gray-400 text-sm border-t border-gray-100">&copy; <?= date('Y'); ?> Asiatique. All rights reserved.</footer>
</body>
</html>