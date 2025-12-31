<?php
session_start();

// 1. Koneksi ke Database
$conn = mysqli_connect("localhost", "root", "", "asiatique");
if (!$conn) { 
    die("Koneksi Database Gagal: " . mysqli_connect_error()); 
}

// 2. Logika Penentuan Halaman (Landing atau Detail)
$slug = $_GET['slug'] ?? '';
$is_landing_page = empty($slug); // True jika tidak ada slug

// Variabel untuk menampung data
$country = null;
$eras = null;
$catalog = null;
$themeColor = '#c9a227'; // Default Gold

if (!$is_landing_page) {
    // --- LOGIC HALAMAN DETAIL NEGARA ---

    // Query Data Negara (Utama)
    $stmt = mysqli_prepare($conn, "SELECT * FROM countries WHERE slug = ?");
    mysqli_stmt_bind_param($stmt, "s", $slug);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $country = mysqli_fetch_assoc($result);

    // Jika negara tidak ditemukan, kembali ke mode landing
    if (!$country) { 
        header("Location: index.php"); 
        exit; 
    }

    // Set Warna Tema
    $themeColor = !empty($country['theme_color']) ? $country['theme_color'] : '#c9a227';

    // Query Era
    $stmt_eras = mysqli_prepare($conn, "SELECT * FROM country_eras WHERE country_id = ? ORDER BY id ASC");
    mysqli_stmt_bind_param($stmt_eras, "i", $country['id']);
    mysqli_stmt_execute($stmt_eras);
    $eras = mysqli_stmt_get_result($stmt_eras);

    // Query Katalog Budaya
    $stmt_catalog = mysqli_prepare($conn, "SELECT * FROM cultural_heritage WHERE country_id = ?");
    mysqli_stmt_bind_param($stmt_catalog, "i", $country['id']);
    mysqli_stmt_execute($stmt_catalog);
    $catalog = mysqli_stmt_get_result($stmt_catalog);

} else {
    // --- LOGIC HALAMAN UTAMA (LANDING) ---
    // Ambil semua negara untuk ditampilkan di menu utama
    $all_countries_query = mysqli_query($conn, "SELECT * FROM countries ORDER BY name ASC");
}

// Query Menu Dropdown (Untuk Header)
$menu_countries = mysqli_query($conn, "SELECT name, slug FROM countries ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asiatique | <?= $is_landing_page ? 'Home' : htmlspecialchars($country['name']); ?></title>

    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        body { font-family: 'Quicksand', sans-serif; background-color: #f5f2ee; scroll-behavior: smooth; }
        .font-imperial { font-family: 'Imperial Script', cursive; }
        .material-symbols-outlined { vertical-align: middle; }
        
        /* CSS VARIABLE DINAMIS */
        :root {
            --theme-color: <?= $themeColor; ?>;
        }
        
        /* Utility Classes */
        .text-theme { color: var(--theme-color) !important; }
        .bg-theme { background-color: var(--theme-color) !important; }
        .border-theme { border-color: var(--theme-color) !important; }
        .hover-text-theme:hover { color: var(--theme-color) !important; }
        .hover-bg-theme:hover { background-color: var(--theme-color) !important; }
        .hover-border-theme:hover { border-color: var(--theme-color) !important; }

        /* Custom Gap Class agar presisi 8px */
        .gap-separator { height: 8px; width: 100%; }
    </style>
</head>

<body>

<header class="fixed top-0 left-0 w-full bg-white/90 backdrop-blur z-50 shadow-sm transition-all duration-300">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    <a href="index.php">
        <img src="assets/images/asiatique_logo.png" alt="Asiatique Logo" class="h-10">
    </a>
    
    <nav class="hidden md:flex gap-8 text-sm font-semibold text-gray-700 items-center">
      <a href="index.php" class="hover-text-theme transition">Home</a>

      <?php if (!$is_landing_page): ?>
          <a href="#eras" class="hover-text-theme transition">Eras</a>
          <a href="#heritage" class="hover-text-theme transition">Heritage</a>
      <?php endif; ?>
      
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
             <a href="index.php?slug=<?= $c['slug']; ?>" class="block px-5 py-3 hover:bg-gray-50 text-gray-600 hover-text-theme transition">
                <?= $c['name']; ?>
             </a>
           <?php endwhile; endif; ?>
        </div>
      </div>
    </nav>
    
    <div class="relative group">
       <?php if (!isset($_SESSION['login'])) : ?>
         <a href="auth/login.php" class="px-5 py-2 rounded-full bg-black text-white text-xs font-bold hover:opacity-90 transition">
            Log in
         </a>
       <?php else: ?>
         <button class="flex items-center gap-2 px-3 py-1 rounded-full hover:bg-gray-100 transition">
            <span class="material-symbols-outlined text-3xl text-gray-600">account_circle</span>
         </button>
       <?php endif; ?>
    </div>
  </div>
</header>

<div class="h-20"></div>

<?php if ($is_landing_page): ?>

    <section class="min-h-[80vh] flex flex-col justify-center items-center px-6 py-20">
        <div class="text-center mb-16">
            <h1 class="font-imperial text-6xl md:text-8xl text-[#6E1203] mb-4">Welcome to Asiatique</h1>
            <p class="text-xl text-gray-500 tracking-wide">Explore the timeless beauty of Asian fashion & culture.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto w-full">
            <?php while($row = mysqli_fetch_assoc($all_countries_query)): ?>
            <a href="index.php?slug=<?= $row['slug']; ?>" class="group block relative overflow-hidden rounded-2xl h-80 shadow-lg">
                <img src="<?= $row['hero_image']; ?>" alt="<?= $row['name']; ?>" class="absolute inset-0 w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/30 group-hover:bg-black/50 transition duration-300"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <h2 class="font-imperial text-5xl text-white drop-shadow-md group-hover:scale-110 transition duration-500"><?= $row['name']; ?></h2>
                </div>
            </a>
            <?php endwhile; ?>
        </div>
    </section>

<?php else: ?>

    <section class="relative h-[60vh] w-full overflow-hidden">
      <img src="<?= htmlspecialchars($country['hero_image']); ?>" class="absolute inset-0 w-full h-full object-cover" alt="<?= htmlspecialchars($country['name']); ?> Landscape">
      <div class="absolute inset-0 bg-black/40"></div>
      <div class="absolute inset-0 flex flex-col items-center justify-center text-center px-4">
        <h1 class="font-imperial text-7xl md:text-9xl text-white drop-shadow-lg mb-4">
            <?= htmlspecialchars($country['hero_title']); ?>
        </h1>
      </div>
    </section>

    <?php if(!empty($country['description'])): ?>
    <section class="py-16 px-6 max-w-4xl mx-auto text-center">
      
      <div class="flex items-center justify-center gap-4 mb-6">

      </div>
      <p class="uppercase tracking-widest text-theme text-sm font-bold leading-8 max-w-3xl mx-auto">
        <?= nl2br(htmlspecialchars($country['description'])); ?>
      </p>

    </section>
    <?php endif; ?>

    <section id="eras" class="py-16 px-6 bg-white">
      <div class="max-w-7xl mx-auto">
        <div class="flex items-center justify-center gap-6 mb-16">
            <div class="w-24 h-[1px] bg-theme"></div>
            <h2 class="font-imperial text-5xl text-theme text-center">Fashion Eras</h2>
            <div class="w-24 h-[1px] bg-theme"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5"> 
          <?php if(mysqli_num_rows($eras) > 0): while($era = mysqli_fetch_assoc($eras)): ?>
          
          <?php
            // LOGIKA LINK EKSTERNAL
            $shopLink = $era['shop_link'];
            
            if (empty($shopLink)) {
                $finalLink = "#"; 
                $target = "_self";
            } else {
                if (!preg_match("~^(?:f|ht)tps?://~i", $shopLink)) {
                    $finalLink = "https://" . $shopLink;
                } else {
                    $finalLink = $shopLink;
                }
                $target = "_blank";
            }
          ?>

          <div class="flex flex-col bg-white p-4 rounded-xl shadow-[0_4px_10px_rgba(0,0,0,0.05)] border border-gray-50">
            
            <div class="w-full h-72 rounded-lg overflow-hidden relative group cursor-pointer">
                <img src="<?= $era['image_top_url']; ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" alt="<?= $era['era_name']; ?>">
                
                <div class="absolute inset-0 bg-black/60 opacity-0 group-hover:opacity-100 transition duration-300 flex items-center justify-center">
                    <h3 class="font-imperial text-5xl text-white drop-shadow-md tracking-wider text-center px-2">
                        <?= $era['era_name']; ?>
                    </h3>
                </div>
            </div>

            <div class="gap-separator"></div>

            <div class="w-full h-48 rounded-lg overflow-hidden">
                <img src="<?= $era['image_bottom_path']; ?>" class="w-full h-full object-cover" alt="Context Image">
            </div>

            <div class="text-center py-6 px-2">
                <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                    <?= $era['description']; ?>
                </p>
            </div>

            <div class="mt-auto pt-2">
                <a href="<?= $finalLink; ?>" 
                   target="<?= $target; ?>" 
                   rel="noopener noreferrer"
                   class="block w-full py-4 rounded-full bg-theme text-white text-center font-bold uppercase tracking-widest text-sm hover:opacity-90 transition shadow-md hover:shadow-lg">
                    Shop Now
                </a>
            </div>

          </div>
          <?php endwhile; endif; ?>
        </div>
      </div>
    </section>

    <section id="heritage" class="py-20 px-6 bg-[#f5f2ee]">
        <div class="max-w-7xl mx-auto">
          <div class="flex items-center justify-center gap-6 mb-16">
            <div class="w-24 h-[1px] bg-theme"></div>
            <h2 class="font-imperial text-5xl text-theme text-center">Cultural Heritage</h2>
            <div class="w-24 h-[1px] bg-theme"></div>
          </div>
          
          <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
              <?php if(mysqli_num_rows($catalog) > 0): while ($row = mysqli_fetch_assoc($catalog)): ?>
                  <div class="bg-white rounded-xl overflow-hidden shadow-md group relative h-[400px]">
                      <img src="<?= $row['image']; ?>" class="w-full h-full object-cover transition duration-500 group-hover:scale-110" alt="<?= htmlspecialchars($row['title']); ?>">
                      <div class="absolute inset-0 bg-black/90 opacity-0 group-hover:opacity-100 transition duration-300 flex flex-col items-center justify-center p-8 text-center text-white">
                          <h3 class="font-imperial text-4xl mb-4 text-theme drop-shadow-md">
                              <?= htmlspecialchars($row['title']); ?>
                          </h3>
                          <p class="text-sm mb-8 line-clamp-4 leading-relaxed opacity-90 w-full break-words px-2">
                              <?= htmlspecialchars($row['description']); ?>
                          </p>
                          <a href="heritage_detail.php?id=<?= $row['id']; ?>" class="px-8 py-3 border border-theme text-theme rounded-full hover-bg-theme hover:text-white transition uppercase text-xs tracking-widest font-bold">
                              Read More
                          </a>
                      </div>
                  </div>
              <?php endwhile; endif; ?>
          </div>
        </div>
    </section>

<?php endif; ?>

<footer class="bg-white pt-16 pb-8 border-t border-gray-100">
    <div class="max-w-7xl mx-auto px-6 flex flex-col items-center text-center">
        <a href="index.php" class="mb-6 opacity-80 hover:opacity-100 transition">
             <img src="assets/images/asiatique_logo.png" alt="Asiatique Logo" class="h-8 grayscale hover:grayscale-0 transition">
        </a>
        <ul class="flex flex-wrap justify-center gap-8 mb-8 text-sm font-semibold text-gray-500 uppercase tracking-wider">
            <li><a href="index.php" class="hover-text-theme transition">Home</a></li>
            <?php if (!$is_landing_page): ?>
                <li><a href="#eras" class="hover-text-theme transition">Fashion Eras</a></li>
                <li><a href="#heritage" class="hover-text-theme transition">Cultural Heritage</a></li>
            <?php endif; ?>
        </ul>
        <p class="text-gray-400 text-xs font-light">
           &copy; <?= date('Y'); ?> Asiatique. Celebrating Asian Culture & History. All rights reserved.
        </p>
    </div>
</footer>

</body>
</html>