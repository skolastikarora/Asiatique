<?php
session_start();

// --- 1. KONEKSI DATABASE (AUTO FINDER) ---
// Kode ini mencari posisi file database.php secara otomatis
$paths = [
    __DIR__ . "/config/database.php",           
    __DIR__ . "/Asiatique/config/database.php", 
    __DIR__ . "/../config/database.php"
];

$found = false;
foreach ($paths as $path) {
    if (file_exists($path)) {
        require_once $path;
        $found = true;
        break;
    }
}

if (!$found) {
    die("Error Critical: File database.php tidak ditemukan. Pastikan folder config ada.");
}

// --- 2. LOGIKA UTAMA ---

// Ambil Slug dari URL
$slug = $_GET['slug'] ?? '';

// Jika slug kosong, kembalikan user ke index (Home)
if (empty($slug)) {
    header("Location: index.php");
    exit;
}

// A. Ambil Data Negara (Hero, Title, Intro)
$stmt = mysqli_prepare($conn, "SELECT * FROM countries WHERE slug = ?");
mysqli_stmt_bind_param($stmt, "s", $slug);
mysqli_stmt_execute($stmt);
$country = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

// Jika data negara tidak ditemukan di database, kembalikan ke index
if (!$country) {
    header("Location: index.php");
    exit;
}

// B. Ambil Data Era (Ancient, Modern, Dynastic)
$stmt_eras = mysqli_prepare($conn, "SELECT * FROM country_eras WHERE country_id = ? ORDER BY id ASC");
mysqli_stmt_bind_param($stmt_eras, "i", $country['id']);
mysqli_stmt_execute($stmt_eras);
$eras = mysqli_stmt_get_result($stmt_eras);

// C. Ambil Data Catalog (Cultural Heritage)
$stmt_catalog = mysqli_prepare($conn, "SELECT * FROM cultural_heritage WHERE country_id = ?");
mysqli_stmt_bind_param($stmt_catalog, "i", $country['id']);
mysqli_stmt_execute($stmt_catalog);
$catalog = mysqli_stmt_get_result($stmt_catalog);

// D. Ambil Menu Negara untuk Header
$menu_countries = mysqli_query($conn, "SELECT name, slug FROM countries ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Asiatique | <?= htmlspecialchars($country['name']); ?></title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
<script src="https://cdn.tailwindcss.com"></script>

<style>
  body { font-family: 'Quicksand', sans-serif; background-color: #f5f2ee; }
  .font-imperial { font-family: 'Imperial Script', cursive; }
  .material-symbols-outlined { vertical-align: middle; }
</style>
</head>

<body>

<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur z-50 shadow-sm transition-all duration-300">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    
    <a href="index.php">
      <img src="assets/images/asiatique_logo.png" class="h-10" alt="Asiatique">
    </a>

    <nav class="hidden md:flex gap-8 text-sm font-semibold text-gray-700 items-center">
      <a href="index.php" class="hover:text-[#c9a227] transition">Home</a>
      <a href="index.php#about" class="hover:text-[#c9a227] transition">About Us</a>
      
      <div class="relative group">
        <button id="countryBtn" class="flex items-center gap-1 hover:text-[#c9a227] transition py-2">
          Country <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
        </button>
        <div id="countryMenu" class="absolute top-full left-0 mt-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform translate-y-2 group-hover:translate-y-0">
           <?php 
           if(mysqli_num_rows($menu_countries) > 0):
             mysqli_data_seek($menu_countries, 0); 
             while($c = mysqli_fetch_assoc($menu_countries)): 
           ?>
             <a href="country.php?slug=<?= $c['slug']; ?>" class="block px-5 py-3 hover:bg-gray-50 text-gray-600 hover:text-[#c9a227] transition"><?= $c['name']; ?></a>
           <?php endwhile; endif; ?>
        </div>
      </div>
    </nav>

    <div class="relative group">
      <?php if (!isset($_SESSION['login'])) : ?>
         <div class="flex gap-3">
           <a href="auth/login.php" class="px-5 py-2 rounded-full bg-[#c9a227] text-white text-xs font-bold hover:bg-[#b3921f] transition shadow-md">Log in</a>
         </div>
      <?php else : ?>
         <button class="flex items-center gap-2 px-3 py-1 rounded-full hover:bg-gray-100 transition border border-transparent hover:border-gray-200">
            <span class="material-symbols-outlined text-3xl text-gray-600">account_circle</span>
            <div class="text-left hidden sm:block">
               <p class="text-[10px] text-gray-400">Welcome,</p>
               <p class="text-xs font-bold text-gray-700"><?= explode('@', $_SESSION['email'])[0]; ?></p>
            </div>
         </button>
         <div class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform translate-y-2 group-hover:translate-y-0 p-1">
            <a href="profile.php" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm">
                <span class="material-symbols-outlined text-[18px]">person</span> Profile
            </a>
            <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
                <a href="admin/dashboard.php" class="flex items-center gap-2 px-4 py-2 text-gray-700 hover:bg-gray-50 rounded-lg text-sm">
                    <span class="material-symbols-outlined text-[18px]">dashboard</span> Dashboard
                </a>
            <?php endif; ?>
            <div class="h-px bg-gray-100 my-1"></div>
            <a href="auth/logout.php" class="flex items-center gap-2 px-4 py-2 text-red-600 hover:bg-red-50 rounded-lg text-sm">
                <span class="material-symbols-outlined text-[18px]">logout</span> Logout
            </a>
         </div>
      <?php endif; ?>
    </div>

  </div>
</header>
<div class="h-20"></div>

<section class="relative h-[60vh] w-full overflow-hidden">
  <?php 
    // Fallback image jika kosong
    $heroImg = !empty($country['hero_image']) ? $country['hero_image'] : 'https://placehold.co/1920x1080?text=No+Image'; 
  ?>
  <img src="<?= htmlspecialchars($heroImg); ?>" class="absolute inset-0 w-full h-full object-cover">
  <div class="absolute inset-0 bg-black/40"></div>
  
  <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
    <h1 class="font-imperial text-7xl md:text-9xl text-white drop-shadow-lg mb-4">
      <?= htmlspecialchars($country['hero_title']); ?>
    </h1>
  </div>
</section>

<?php if(!empty($country['intro_desc'])): ?>
<section class="py-16 px-6 max-w-4xl mx-auto text-center">
  <div class="flex items-center justify-center gap-4 mb-6">
    <div class="w-16 h-[2px] bg-[#c9a227]"></div>
    <span class="uppercase tracking-widest text-[#c9a227] text-sm font-bold">Introduction</span>
    <div class="w-16 h-[2px] bg-[#c9a227]"></div>
  </div>
  <p class="text-xl text-gray-700 leading-relaxed font-light">
    <?= nl2br(htmlspecialchars($country['intro_desc'])); ?>
  </p>
</section>
<?php endif; ?>

<section class="py-10 px-6 bg-white">
  <div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      
      <?php 
      if(mysqli_num_rows($eras) > 0): 
        while($era = mysqli_fetch_assoc($eras)): 
      ?>
      <div class="flex flex-col gap-4 text-center group">
        <div class="h-64 rounded-2xl overflow-hidden relative shadow-lg cursor-pointer">
           <?php $eraImgTop = !empty($era['image_top_url']) ? $era['image_top_url'] : 'https://placehold.co/400x600?text=Era+Image'; ?>
           <img src="<?= $eraImgTop; ?>" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
           <div class="absolute inset-0 bg-black/20 group-hover:bg-black/40 transition"></div>
           <h3 class="absolute bottom-6 left-1/2 -translate-x-1/2 font-imperial text-5xl text-white drop-shadow-md whitespace-nowrap">
             <?= $era['era_name']; ?>
           </h3>
        </div>

        <p class="text-gray-600 text-sm leading-relaxed px-2 min-h-[60px]">
          <?= $era['description']; ?>
        </p>

        <?php if(!empty($era['image_bottom_path'])): ?>
          <div class="h-40 rounded-xl overflow-hidden mt-2 shadow-sm">
            <img src="<?= $era['image_bottom_path']; ?>" class="w-full h-full object-cover grayscale group-hover:grayscale-0 transition duration-500">
          </div>
        <?php endif; ?>

        <?php if(!empty($era['shop_link']) && $era['shop_link'] !== '#'): ?>
          <a href="<?= $era['shop_link']; ?>" target="_blank" class="mt-2 inline-block border border-gray-300 px-6 py-2 rounded-full text-xs uppercase tracking-widest hover:bg-[#c9a227] hover:text-white hover:border-[#c9a227] transition">
            Shop Collection
          </a>
        <?php endif; ?>
      </div>
      <?php endwhile; ?>
      <?php endif; ?>

    </div>
  </div>
</section>

<section class="py-20 px-6 bg-[#f5f2ee]">
    <div class="max-w-7xl mx-auto">
      
      <div class="flex items-center justify-center gap-6 mb-16">
        <div class="w-24 h-[1px] bg-[#8b1d1d]"></div>
        <h2 class="font-imperial text-5xl text-[#8b1d1d] text-center">
          Cultural Heritage
        </h2>
        <div class="w-24 h-[1px] bg-[#8b1d1d]"></div>
      </div>

      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
          <?php 
          if(mysqli_num_rows($catalog) > 0): 
            while ($row = mysqli_fetch_assoc($catalog)): 
            $catImg = !empty($row['image']) ? $row['image'] : 'https://placehold.co/600x400?text=No+Image';
          ?>
              <div class="bg-white rounded-xl overflow-hidden shadow-md group relative h-[400px]">
                  <img src="<?= $catImg; ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-110">
                  
                  <div class="absolute inset-0 bg-black/80 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-8 text-center text-white">
                      <h3 class="font-imperial text-4xl mb-4 text-[#c9a227]"><?= $row['title']; ?></h3>
                      <p class="text-sm mb-8 line-clamp-4 leading-relaxed opacity-90"><?= $row['description']; ?></p>
                      
                      <?php if(!empty($row['link']) && $row['link'] !== '#'): ?>
                          <a href="<?= $row['link']; ?>" target="_blank" class="px-8 py-3 border border-[#c9a227] text-[#c9a227] rounded-full hover:bg-[#c9a227] hover:text-white transition uppercase text-xs tracking-widest font-bold">
                              Read More
                          </a>
                      <?php endif; ?>
                  </div>
              </div>
          <?php endwhile; ?>
          <?php else: ?>
              <div class="col-span-3 text-center py-10 text-gray-500 flex flex-col items-center gap-3">
                  <span class="material-symbols-outlined text-4xl">inventory_2</span>
                  <p>Catalog belum tersedia saat ini.</p>
              </div>
          <?php endif; ?>
      </div>

    </div>
</section>

<footer class="bg-white text-center py-10 text-gray-400 text-sm border-t border-gray-100">
    &copy; <?= date('Y'); ?> Asiatique. All rights reserved.
</footer>

<script>
// Logic ini hanya untuk mobile/touchscreen, karena di desktop sudah pakai CSS Hover
const countryBtn = document.getElementById('countryBtn');
const countryMenu = document.getElementById('countryMenu');

if(countryBtn && window.innerWidth < 768) {
  countryBtn.onclick = () => {
    countryMenu.classList.toggle('invisible');
    countryMenu.classList.toggle('opacity-0');
  }
}
</script>

</body>
</html>