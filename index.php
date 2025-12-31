<?php
session_start();

// ==========================================================
// 1. KONEKSI DATABASE
// ==========================================================
$host = "localhost";
$user = "root";
$pass = "";
$db   = "asiatique";

$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) { die("Koneksi Gagal: " . mysqli_connect_error()); }

// ==========================================================
// 2. AMBIL DATA
// ==========================================================
$slides = mysqli_query($conn, "SELECT * FROM home_slides ORDER BY display_order ASC");
$menu_countries = mysqli_query($conn, "SELECT name, slug FROM countries ORDER BY name ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Asiatique | Home</title>

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
      <a href="index.php" class="text-[#c9a227]">Home</a>
      <a href="#about" class="hover:text-[#c9a227] transition">About Us</a>
      <a href="#feature" class="hover:text-[#c9a227] transition">Feature</a>

      <div class="relative group">
        <button class="flex items-center gap-1 hover:text-[#c9a227] transition py-2">
          Country <span class="material-symbols-outlined text-[20px]">keyboard_arrow_down</span>
        </button>
        <div class="absolute top-full left-0 mt-0 w-48 bg-white rounded-xl shadow-lg border border-gray-100 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition duration-300 transform translate-y-2 group-hover:translate-y-0">
           <?php 
           if(mysqli_num_rows($menu_countries) > 0):
             mysqli_data_seek($menu_countries, 0); 
             while($c = mysqli_fetch_assoc($menu_countries)): 
           ?>
             <a href="country.php?slug=<?= $c['slug']; ?>" class="block px-5 py-3 hover:bg-gray-50 text-gray-600 hover:text-[#c9a227] transition">
                <?= $c['name']; ?>
             </a>
           <?php endwhile; endif; ?>
        </div>
      </div>
    </nav>

    <div class="relative group">
      <?php if (!isset($_SESSION['login'])) : ?>
         <div class="flex gap-3">
           <a href="auth/login.php" class="px-5 py-2 rounded-full bg-[#c9a227] text-white text-xs font-bold hover:bg-[#b3921f] transition shadow-md">Log in</a>
           <a href="auth/signup.php" class="px-5 py-2 rounded-full bg-gray-200 text-gray-600 text-xs font-bold hover:bg-gray-300 transition">Sign Up</a>
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

<section id="home" class="px-6 py-4">
  <div class="w-full relative h-[85vh] rounded-[32px] overflow-hidden group bg-gray-200 shadow-xl">
    
    <div id="slides" class="flex h-full transition-transform duration-700 ease-in-out">
      <?php if(mysqli_num_rows($slides) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($slides)) : ?>
          <?php 
            // === LOGIKA PERBAIKAN LINK ===
            // Kita ABAIKAN link dari database yang mungkin kotor.
            // Kita buat link baru berdasarkan JUDUL SLIDE.
            
            $judul = strtolower($row['title']); // misal: "The Grandeur of China"
            $linkBaru = "#";

            if (strpos($judul, 'china') !== false) {
                $linkBaru = "country.php?slug=china";
            } elseif (strpos($judul, 'thailand') !== false) {
                $linkBaru = "country.php?slug=thailand";
            } elseif (strpos($judul, 'india') !== false) {
                $linkBaru = "country.php?slug=india";
            } else {
                // Fallback: coba bersihkan link database
                $linkBaru = str_replace(['Asiatique/', '/Asiatique/'], '', $row['link_url']);
                $linkBaru = ltrim($linkBaru, '/');
            }
          ?>
          <div class="min-w-full relative h-full">
            <img src="<?= $row['image']; ?>" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
            
            <div class="absolute top-20 left-10 md:left-20 max-w-xl text-white">
              <h2 class="font-imperial text-6xl md:text-9xl text-white whitespace-nowrap drop-shadow-sm mb-4">
                <?= $row['title']; ?>
              </h2>
              <p class="text-justify text-lg leading-relaxed drop-shadow-md opacity-90">
                <?= $row['description']; ?>
              </p>
            </div>

            <div class="absolute bottom-12 right-12">
              <a href="<?= $linkBaru; ?>" class="inline-block bg-white px-8 py-3 rounded-full shadow hover:bg-[#6E1203] hover:text-white transition font-bold text-sm tracking-wide uppercase">
                Discover more
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
         <div class="min-w-full flex items-center justify-center bg-gray-300">
            <p>Slide belum diisi di database.</p>
         </div>
      <?php endif; ?>
    </div>

    <button onclick="prevSlide()" class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur hover:bg-white text-white hover:text-black p-4 rounded-full transition opacity-0 group-hover:opacity-100"><span class="material-symbols-outlined">chevron_left</span></button>
    <button onclick="nextSlide()" class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/20 backdrop-blur hover:bg-white text-white hover:text-black p-4 rounded-full transition opacity-0 group-hover:opacity-100"><span class="material-symbols-outlined">chevron_right</span></button>
  </div>
</section>


<section id="about" class="relative w-full py-24 bg-[#f5f2ee] overflow-hidden">
    <div class="relative z-10 container mx-auto px-4 mb-12">
        <div class="max-w-4xl mx-auto mb-6">
            <div class="flex items-center gap-6">
                <div class="flex-1 h-[2px] bg-gradient-to-r from-transparent to-gray-400"></div>
                <h2 class="font-imperial text-7xl md:text-9xl text-[#4F6815] whitespace-nowrap drop-shadow-sm">About Us</h2>
                <div class="flex-1 h-[1px] bg-gradient-to-l from-transparent to-gray-400"></div>
            </div>
        </div>
        <div class="max-w-5xl mx-auto text-center space-y-6">
            <p class="text-gray-600 text-sm md:text-lg leading-relaxed font-medium">
                Our website is dedicated to exploring the rich diversity of traditional clothing across Asia.
            </p>
        </div>
    </div>

    <div class="max-w-[95%] mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="country.php?slug=china" class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer block">
            <img src="https://i.pinimg.com/1200x/57/83/4f/57834f5432765bec8454c06aaf82d5cc.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">China</span>
            </div>
        </a>
        <a href="country.php?slug=thailand" class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer block">
            <img src="https://i.pinimg.com/1200x/14/3f/e0/143fe04f2df742bd1344262ce2d5c684.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">Thailand</span>
            </div>
        </a>
        <a href="country.php?slug=india" class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer block">
            <img src="https://i.pinimg.com/736x/e6/db/22/e6db22d8dc84cd25b5977292bc5ac2a0.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">India</span>
            </div>
        </a>
        <div class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer">
            <img src="https://i.pinimg.com/1200x/47/55/ca/4755ca0523caf299505ae160c2a2ca8b.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">Japan</span>
            </div>
        </div>
        <div class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer">
            <img src="https://i.pinimg.com/736x/4c/b6/37/4cb637ac8908e9015ead4b2f225678d1.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">Korea</span>
            </div>
        </div>
        <div class="relative h-64 col-span-2 rounded-xl overflow-hidden group shadow-md cursor-pointer">
            <img src="https://i.pinimg.com/1200x/21/33/ab/2133abd1703314b77d479772d9780feb.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-6xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">Asia</span>
            </div>
        </div>
        <div class="relative h-64 rounded-xl overflow-hidden group shadow-md cursor-pointer">
            <img src="https://i.pinimg.com/736x/dc/51/be/dc51bef4776669d4bad9edfb56ad14f5.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
            <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition flex items-center justify-center">
                <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0">Indonesia</span>
            </div>
        </div>
    </div>
</section>

<section id="feature" class="py-20 px-6 bg-white">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
    
    <div class="space-y-12">
      
      <div class="flex gap-6 group">
        <span class="text-8xl text-[#c9a227]/30 font-bold group-hover:text-[#c9a227] transition">01</span>
        <div>
           <h3 class="text-xl font-bold mb-2 text-[#c9a227]">Historical Era</h3>
           <p class="text-gray-600 leading-relaxed">The platform showcases traditional clothing from across Asia, highlighting garments worn in different historical eras.</p>
           <div class="mt-6 h-[2px] bg-[#c9a227]/40 w-full group-hover:w-full transition-all duration-500 origin-left"></div>
         </div>
      </div>

      <div class="flex gap-6 group">
        <span class="text-8xl text-[#c9a227]/30 font-bold group-hover:text-[#c9a227] transition">02</span>
        <div>
           <h3 class="text-xl font-bold mb-2 text-[#c9a227]">Curated Collection</h3>
           <p class="text-gray-600 leading-relaxed">Clothing is carefully organized by country, era, and garment type to create a clear browsing experience.</p>
           <div class="mt-6 h-[2px] bg-[#c9a227]/40 w-full group-hover:w-full transition-all duration-500 origin-left"></div>
         </div>
      </div>

      <div class="flex gap-6 group">
        <span class="text-8xl text-[#c9a227]/30 font-bold group-hover:text-[#c9a227] transition">03</span>
        <div>
           <h3 class="text-xl font-bold mb-2 text-[#c9a227]">Living Heritage</h3>
           <p class="text-gray-600 leading-relaxed">We focus on garments not just as artifacts, but as a living form of heritage that tells the story of its people.</p>
           <div class="mt-6 h-[2px] bg-[#c9a227]/40 w-full group-hover:w-full transition-all duration-500 origin-left"></div>
         </div>
      </div>

      </div>

    <div class="relative h-[500px] rounded-3xl overflow-hidden shadow-2xl group">
      <img src="https://i.pinimg.com/1200x/12/85/f9/1285f9ad2c74b34b5c441893cc64471d.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-105">
      
      <a href="country.php" 
         class="absolute bottom-8 right-8 inline-flex items-center gap-2 px-8 py-3 bg-[#c9a227] text-white rounded-full font-bold uppercase tracking-wider text-sm shadow-lg hover:bg-[#b08d21] hover:scale-105 transition-all duration-300 z-10">
          Explore Country
          <span class="material-symbols-outlined text-lg">arrow_right_alt</span>
      </a>
    </div>

  </div>
</section>

<footer class="bg-gray-50 text-center py-12 text-gray-500 text-sm border-t border-gray-200">
  <p>&copy; <?= date('Y'); ?> Asiatique. All rights reserved.</p>
</footer>

<script>
let index = 0;
const slides = document.getElementById('slides');
const total = slides ? slides.children.length : 0;

function updateSlide() {
  if (slides && total > 0) {
     if (index < 0) index = total - 1;
     if (index >= total) index = 0;
     slides.style.transform = `translateX(-${index * 100}%)`;
  }
}
function nextSlide(){ index++; updateSlide(); }
function prevSlide(){ index--; updateSlide(); }
</script>

</body>
</html>