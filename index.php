<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Asiatique</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- Material Symbols -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" />
<style>
.material-symbols-outlined {
  font-variation-settings:
    'FILL' 0,
    'wght' 100,
    'GRAD' 0,
    'opsz' 20;
}
</style>

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
  body {
    font-family: 'Quicksand', sans-serif;
  }
  .font-imperial {
    font-family: 'Imperial Script', cursive;
  }
</style>
</head>

<body class="bg-[] scroll-smooth">

<!-- ================= HEADER ================= -->
<header class="fixed top-0 left-0 w-full bg-white/80 backdrop-blur z-50">
  <div class="max-w-8xl mx-auto px-7 py-4 flex items-center justify-between">

    <!-- LOGO -->
    <a href="index.php">
      <img src="assets/images/asiatique_logo.png" class="h-10">
    </a>

    <!-- NAV -->
    <nav class="hidden md:flex gap-8 text-sm items-center">

      <a href="#home" class="hover:underline">Home</a>
      <a href="#about" class="hover:underline">About Us</a>
      <a href="#feature" class="hover:underline">Feature</a>

      <!-- COUNTRY -->
      <div class="relative">
        <button id="countryBtn" class="flex items-center gap-1 hover:underline">
          Country
          <span id="countryArrow" class="material-symbols-outlined transition">
            keyboard_arrow_down
          </span>
        </button>

        <div id="countryMenu"
          class="absolute top-full left-0 mt-4 w-56 bg-white rounded-xl shadow-lg
                 opacity-0 invisible transition pointer-events-none">

          <a href="china.php" class="block px-6 py-3 hover:bg-gray-100 rounded-t-xl">China</a>
          <a href="thailand.php" class="block px-6 py-3 hover:bg-gray-100">Thailand</a>
          <a href="india.php" class="block px-6 py-3 hover:bg-gray-100 rounded-b-xl">India</a>
        </div>
      </div>
    </nav>


    <!-- ACCOUNT -->
    <div class="relative">

      <!-- GUEST -->
      <div id="authGuest" class="flex gap-3">
        <a href="auth/login.php"
           class="px-5 py-2 rounded-full bg-[#c9a227] text-white text-sm hover:bg-[#b3921f]">
          Log in
        </a>
        <a href="auth/signup.php"
           class="px-5 py-2 rounded-full bg-[#f1f1f1] text-sm hover:bg-gray-200">
          Sign up
        </a>
      </div>

      <!-- USER -->
      <div id="authUser" class="hidden">
        <button id="userBtn" class="flex items-center gap-2 px-3 py-2 rounded-full hover:bg-gray-100">
          <img src="assets/images/avatar.png" class="w-8 h-8 rounded-full">
          <span class="material-symbols-outlined">expand_more</span>
        </button>

        <div id="userMenu"
          class="absolute right-0 mt-4 w-64 bg-white rounded-xl shadow-lg
                 opacity-0 invisible transition pointer-events-none">

          <div class="px-5 py-4 border-b">
            <p class="text-sm font-medium">Saat ini menggunakan</p>
            <p class="text-sm text-gray-500 truncate">user@email.com</p>
          </div>

          <a href="profile.php" class="block px-5 py-3 hover:bg-gray-100">Akun Anda</a>
          <a href="logout.php"
             class="block px-5 py-3 text-red-600 hover:bg-gray-100 rounded-b-xl">
            Keluar
          </a>
        </div>
      </div>

    </div>
  </div>
</header>

<!-- SPACER HEADER -->
<div class="h-24"></div>

<!-- ================= HERO ================= -->
<section id="home" class="bg-[#f5f2ee] pt-4">
  <div class="w-full px-6">
    <div class="relative h-[85vh] rounded-[32px] overflow-hidden">

      <!-- SLIDES -->
      <div id="slides" class="flex h-full transition-transform duration-700">

        <!-- CHINA -->
        <div class="min-w-full relative h-full">
          <img src="https://64.media.tumblr.com/a60e79fae59c91fc103df83c9199237b/75695a62bba71767-e7/s1280x1920/78bb8656dc961c83bef1d3e1b95037e7c73608a7.jpg"
               class="w-full h-full object-cover object-[center_27%]">
          <div class="absolute inset-0 bg-black/30"></div>

          <div class="absolute top-20 left-20 max-w-xl text-white">
            <h2 class="font-imperial md:text-9xl text-white-900 whitespace-nowrap drop-shadow-sm">China</h2>
            <p class="text-justify">
              China’s traditional clothing emphasizes harmony, symbolism, and refined craftsmanship. 
              From the flowing elegance of Hanfu to the structured styles of the Qing Dynasty, Chinese attire reflects social hierarchy and cultural values through intricate embroidery and meaningful colors such as red, gold, and deep blue.
            </p>
          </div>

          <div class="absolute bottom-12 right-12">
            <a href="china.php"
               class="inline-block bg-white px-7 py-3 rounded-full shadow hover:bg-gray-100 transition">
              Discover more
            </a>
          </div>
        </div>

        <!-- THAILAND -->
        <div class="min-w-full relative h-full">
          <img src="assets/images/hero_thailand.png"
               class="w-full h-full object-cover object-[center_27%]">
          <div class="absolute inset-0 bg-black/30"></div>

          <div class="absolute top-20 left-20 max-w-xl text-white">
            <h2 class="font-imperial md:text-9xl text-white-900 whitespace-nowrap drop-shadow-sm">Thailand</h2>
            <p class="text-justify">
              Thailand’s traditional clothing showcases a graceful blend of royal elegance and regional identity. 
              From the refined draping of the Chut Thai Chakkri worn in historical palaces to the simple yet intricate Pha Sin found in northern communities, Thai attire reflects social status, cultural harmony, and spiritual values. 
              Gold, pink, and jewel-toned fabrics remain signature choices, symbolizing prosperity, femininity, and the country’s deep connection to ceremonial traditions.
            </p>
          </div>

          <div class="absolute bottom-12 right-12">
            <a href="thailand.php"
               class="inline-block bg-white px-7 py-3 rounded-full shadow hover:bg-gray-100 transition">
              Discover more
            </a>
          </div>
        </div>

        <!-- INDIA -->
        <div class="min-w-full relative h-full">
          <img src="https://i.pinimg.com/1200x/ba/6d/fb/ba6dfbc582fc14e8930028e5691a211e.jpg"
               class="w-full h-full object-cover object-[center_27%]">
          <div class="absolute inset-0 bg-black/30"></div>

          <div class="absolute top-20 left-20 max-w-xl text-white">
            <h2 class="font-imperial md:text-9xl text-white-900 whitespace-nowrap drop-shadow-sm">India</h2>
            <p class="text-justify">
              India’s traditional clothing is a vibrant tapestry of colors, craftsmanship, and centuries-old symbolism. 
              From the endlessly versatile draping of the sari worn across diverse regions to the regal structure of the sherwani seen in courts and celebrations, Indian attire embodies spirituality, artistry, and regional heritage. 
              Bright hues like red, saffron, and emerald dominate traditional garments, representing purity, power, and auspicious beginnings that remain central to Indian culture.
            </p>
          </div>

          <div class="absolute bottom-12 right-12">
            <a href="india.php"
               class="inline-block bg-white px-7 py-3 rounded-full shadow hover:bg-gray-100 transition">
              Discover more
            </a>
          </div>
        </div>

      </div>

      <!-- ARROWS -->
      <button onclick="prevSlide()"
        class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/80 p-3 rounded-full">
        ‹
      </button>

      <button onclick="nextSlide()"
        class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/80 p-3 rounded-full">
        ›
      </button>

      <!-- DOTS -->
      <div id="dots"
           class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3">
        <span class="w-2.5 h-2.5 rounded-full bg-white cursor-pointer" onclick="goToSlide(0)"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-white/50 cursor-pointer" onclick="goToSlide(1)"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-white/50 cursor-pointer" onclick="goToSlide(2)"></span>
      </div>

    </div>
  </div>
</section>


<!-- ================= ABOUT US ================= -->
<section id="about" class="relative w-full min-h-screen py-24 bg-[#f5f2ee] overflow-hidden">
        
        <div class="relative z-10 container mx-auto px-4 mb-12">
            
            <div class="max-w-4xl mx-auto mb-6">
                <div class="flex items-center gap-6">
                    <div class="flex-1 h-[1px] bg-gradient-to-r from-transparent to-gray-400"></div>
                    <h2 class="font-imperial text-7xl md:text-9xl text-[#4F6815] whitespace-nowrap drop-shadow-sm">
                        About Us
                    </h2>
                    <div class="flex-1 h-[1px] bg-gradient-to-l from-transparent to-gray-400"></div>
                </div>
            </div>

            <div class="max-w-5xl mx-auto text-center space-y-6">
                <p class="text-gray-600 text-sm md:text-lg leading-relaxed font-medium">
                    Our website is dedicated to exploring the rich diversity of traditional clothing across Asia. 
                    We aim to provide clear, well-researched, and visually engaging information about the ancient, royal, and modern garments of China, Thailand, and India. 
                    Through this platform, we hope to help learners, students, and culture enthusiasts understand the history, symbolism, and evolution of traditional attire in a simple and accessible way.
                </p>
            </div>
        </div>

        <div class="max-w-[95%] mx-auto grid grid-cols-2 md:grid-cols-4 gap-4">

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/1200x/57/83/4f/57834f5432765bec8454c06aaf82d5cc.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        China
                    </span>
                </div>
            </div>

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/1200x/14/3f/e0/143fe04f2df742bd1344262ce2d5c684.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Thailand
                    </span>
                </div>
            </div>

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/736x/e6/db/22/e6db22d8dc84cd25b5977292bc5ac2a0.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        India
                    </span>
                </div>
            </div>

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/1200x/47/55/ca/4755ca0523caf299505ae160c2a2ca8b.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Japan
                    </span>
                </div>
            </div>

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/736x/4c/b6/37/4cb637ac8908e9015ead4b2f225678d1.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Korea
                    </span>
                </div>
            </div>

            <div class="relative col-span-2 h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://www.firsty.app/_next/image?url=https%3A%2F%2Fa.storyblok.com%2Ff%2F320520%2F1000x667%2F007bfca9f5%2Fthailand.jpg%3Fquality%3D100&w=3840&q=75" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-5xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300 text-center">
                        Southeast Asia
                    </span>
                </div>
            </div>

            <div class="relative h-64 rounded-xl overflow-hidden group shadow-md border border-gray-200 cursor-pointer">
                <img src="https://i.pinimg.com/736x/dc/51/be/dc51bef4776669d4bad9edfb56ad14f5.jpg" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/60 transition duration-300 flex items-center justify-center">
                    <span class="text-white text-4xl font-imperial opacity-0 group-hover:opacity-100 transition transform translate-y-4 group-hover:translate-y-0 duration-300">
                        Indonesia
                    </span>
                </div>
            </div> 

        </div>
    </section>

<!-- ================= FEATURES ================= -->
<section id="feature" class="bg-[#f5f2ee] py-16 px-6">
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-2 gap-20 items-start">

    <!-- LEFT : FEATURE LIST -->
    <div class="space-y-16">

      <!-- ITEM 01 -->
      <div class="flex gap-8 items-start">
        <div class="w-[120px] text-[#c9a227] text-8xl font-light leading-none">
          01
        </div>

        <div class="flex-1">
          <p class="text-gray-700 leading-relaxed text-justify">
            The platform showcases traditional clothing from across Asia, highlighting garments worn in different historical eras. 
            Each piece is presented as part of a broader story of fashion evolution and cultural identity.
          </p>

          <div class="mt-6 h-[2px] bg-[#c9a227]/40"></div>
        </div>
      </div>

      <!-- ITEM 02 -->
      <div class="flex gap-8 items-start">
        <div class="w-[120px] text-[#c9a227] text-8xl font-light leading-none">
          02
        </div>

        <div class="flex-1">
          <p class="text-gray-700 leading-relaxed text-justify">
            Clothing is carefully organized by country, era, and garment type to create a clear and intuitive browsing experience. 
            This structure allows users to easily compare styles, silhouettes, and cultural influences.
          </p>

          <div class="mt-6 h-[2px] bg-[#c9a227]/40"></div>
        </div>
      </div>

      <!-- ITEM 03 -->
      <div class="flex gap-8 items-start">
        <div class="w-[120px] text-[#c9a227] text-8xl font-light leading-none">
          03
        </div>

        <div class="flex-1">
          <p class="text-gray-700 leading-relaxed text-justify">
            By focusing on garments rather than artifacts alone, the platform emphasizes clothing as a living form of heritage. 
            Historical designs are connected with modern interpretations to inspire contemporary fashion appreciation.
          </p>

          <div class="mt-6 h-[2px] bg-[#c9a227]/40"></div>
        </div>
      </div>

    </div>

    <!-- RIGHT : IMAGE -->
    <div class="relative">
      <img
        src="https://i.pinimg.com/736x/c5/07/83/c507830fbfee1c0806d390611c530a10.jpg"
        alt="Feature Image"
        class="w-full h-[520px] object-cover rounded-[28px]"
      >
    </div>

  </div>
</section>


<!-- ================= FOOTER ================= -->
<footer class="bg-[#fFFFff] text-gray-600 py-20 px-6 border-t border-gray-100">

  <div class="max-w-7xl mx-auto text-center">

    <div class="flex justify-center items-center gap-8 mb-10">
      
      <a href="#" class="hover:scale-110 transition-transform duration-300">
        <img src="assets/images/instagram.png" alt="Instagram" class="h-8 w-auto">
      </a>

      <a href="#" class="hover:scale-110 transition-transform duration-300">
        <img src="assets/images/facebook.png" alt="Facebook" class="h-8 w-auto">
      </a>

      <a href="#" class="hover:scale-110 transition-transform duration-300">
        <img src="assets/images/tik-tok.png" alt="TikTok" class="h-8 w-auto">
      </a>

    </div>

    <p class="max-w-3xl mx-auto text-sm leading-relaxed text-gray-500 mb-16 font-medium">
      Asiatique is a cultural information platform dedicated to exploring traditional clothing across Asia, 
      presented for educational and cultural appreciation.
    </p>

    <div class="mb-6">
      <img src="assets/images/asiatique_logo.png" class="h-12 mx-auto opacity-90 hover:opacity-100 transition">
    </div>

    <p class="text-sm text-gray-500">
      Indonesia | ID
    </p>

  </div>

</footer>

<!-- ================= JS ================= -->
<script>
/* HERO SLIDER */
let index = 0;
const slides = document.getElementById('slides');
const total = slides.children.length;

function updateSlide() {
  if (index < 0) index = total - 1;
  if (index >= total) index = 0;
  slides.style.transform = `translateX(-${index * 100}%)`;
}
function nextSlide(){ index++; updateSlide(); }
function prevSlide(){ index--; updateSlide(); }
updateSlide();

/* COUNTRY DROPDOWN */
const countryBtn = document.getElementById('countryBtn');
const countryMenu = document.getElementById('countryMenu');
const countryArrow = document.getElementById('countryArrow');

countryBtn.onclick = e => {
  e.stopPropagation();
  countryMenu.classList.toggle('opacity-100');
  countryMenu.classList.toggle('visible');
  countryMenu.classList.toggle('pointer-events-auto');
  countryMenu.classList.toggle('opacity-0');
  countryMenu.classList.toggle('invisible');
  countryArrow.classList.toggle('rotate-180');
};

/* USER DROPDOWN */
const isLoggedIn = false; // nanti ganti PHP session
const authGuest = document.getElementById('authGuest');
const authUser = document.getElementById('authUser');

if (isLoggedIn) {
  authGuest.classList.add('hidden');
  authUser.classList.remove('hidden');
}

const userBtn = document.getElementById('userBtn');
const userMenu = document.getElementById('userMenu');

if (userBtn) {
  userBtn.onclick = e => {
    e.stopPropagation();
    userMenu.classList.toggle('opacity-100');
    userMenu.classList.toggle('visible');
    userMenu.classList.toggle('pointer-events-auto');
    userMenu.classList.toggle('opacity-0');
    userMenu.classList.toggle('invisible');
  };
}

document.onclick = () => {
  countryMenu.classList.add('opacity-0','invisible','pointer-events-none');
  userMenu?.classList.add('opacity-0','invisible','pointer-events-none');
  countryArrow.classList.remove('rotate-180');
};
</script>

</body>
</html>
