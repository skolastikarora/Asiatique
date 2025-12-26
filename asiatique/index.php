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

<body class="bg-[#f5f2ee] scroll-smooth">

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
<section id="home" class="max-w-8xl mx-auto px-6">
  <div class="relative rounded-[32px] overflow-hidden bg-[#e9e2d9] touch-pan-y">

    <!-- SLIDES -->
    <div id="slides" class="flex transition-transform duration-700">

      <!-- CHINA -->
      <div class="min-w-full relative">
        <img src="https://64.media.tumblr.com/a60e79fae59c91fc103df83c9199237b/75695a62bba71767-e7/s1280x1920/78bb8656dc961c83bef1d3e1b95037e7c73608a7.jpg"
             class="w-full h-[520px] object-cover object-[center_25%]">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="absolute top-12 left-20 max-w-xl text-white">
          <h1 class="font-imperial text-9xl">China</h1> 
          <p>China’s traditional clothing spans millennia and reflects deep cultural meaning.</p>
        </div>

        <div class="absolute bottom-8 right-8">
        <a href="china.php">
            <button class="bg-white px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
            Discover more
            </button>
        </a>
        </div>

      </div>

      <!-- THAILAND -->
      <div class="min-w-full relative">
        <img src="https://images.unsplash.com/photo-1549693578-d683be217e58"
             class="w-full h-[520px] object-cover">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="absolute top-12 left-20 max-w-xl text-white">
          <h1 class="font-imperial text-9xl mb-4">Thailand</h1>
          <p>Traditional Thai clothing reflects grace and heritage.</p>
        </div>

        <div class="absolute bottom-8 right-8">
        <a href="thailand.php">
            <button class="bg-white px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
            Discover more
            </button>
        </a>
        </div>
      </div>

      <!-- INDIA -->
      <div class="min-w-full relative">
        <img src="https://images.unsplash.com/photo-1600180758890-6b94519a8ba6"
             class="w-full h-[520px] object-cover">
        <div class="absolute inset-0 bg-black/30"></div>

        <div class="absolute top-12 left-20 max-w-xl text-white">
          <h1 class="font-imperial text-9xl mb-4">India</h1>
          <p>Indian traditional attire is rich in symbolism and artistry.</p>
        </div>

        <div class="absolute bottom-8 right-8">
        <a href="india.php">
            <button class="bg-white px-6 py-3 rounded-full shadow hover:bg-gray-100 transition">
            Discover more
            </button>
        </a>
        </div>
      </div>

    </div>

    <!-- ARROWS -->
    <button onclick="prevSlide()"
      class="absolute left-6 top-1/2 -translate-y-1/2 bg-white/80 p-3 rounded-full">‹</button>

    <button onclick="nextSlide()"
      class="absolute right-6 top-1/2 -translate-y-1/2 bg-white/80 p-3 rounded-full">›</button>

    <!-- DOTS INSIDE IMAGE -->
    <div id="dots" class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-3 z-20">
      <span class="w-2.5 h-2.5 rounded-full bg-white cursor-pointer" onclick="goToSlide(0)"></span>
      <span class="w-2.5 h-2.5 rounded-full bg-white/50 cursor-pointer" onclick="goToSlide(1)"></span>
      <span class="w-2.5 h-2.5 rounded-full bg-white/50 cursor-pointer" onclick="goToSlide(2)"></span>
    </div>

  </div>
</section>

<!-- ================= ABOUT US ================= -->
<section id="about" class="bg-[#f5f2ee] py-20 px-6">

  <!-- TITLE -->
  <div class="max-w-8xl mx-auto mb-16">
    <div class="flex items-center gap-6">
      <div class="flex-1 h-[1px] bg-gray-300"></div>
      <h2 class="font-imperial text-8xl text-gray-800 whitespace-nowrap">
        About Us
      </h2>
      <div class="flex-1 h-[1px] bg-gray-300"></div>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="max-w-8xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

    <!-- LEFT : AUTO SLIDER -->
    <div class="relative overflow-hidden rounded-[32px] bg-white">

      <!-- SLIDES -->
      <div id="aboutSlides" class="flex transition-transform duration-1000">

        <!-- SLIDE 1 -->
        <div class="rounded-[32px] overflow-hidden">
          <img 
            src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
            class="w-full h-full object-cover"
            alt="Cabin"
          >
        </div>

        <!-- SLIDE 2 -->
        <div class="rounded-[32px] overflow-hidden">
            <img 
              src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
              class="w-full h-full object-cover"
              alt="Cabin"
            >
          </div>

        <!-- SLIDE 3 -->
        <div class="min-w-full h-[260px] flex items-end bg-gradient-to-t from-emerald-200 to-teal-200 rounded-[32px]">
          <div class="p-8">
           <img 
           src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee" 
           class="w-full h-full object-cover"
           >
          </div>
        </div>

      </div>

      <!-- DOTS -->
      <div id="aboutDots" class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
        <span class="w-2.5 h-2.5 rounded-full bg-gray-800"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>
        <span class="w-2.5 h-2.5 rounded-full bg-gray-400"></span>
      </div>

    </div>

    <!-- RIGHT : TEXT -->
    <div>
      <p class="text-gray-600 text-lg leading-relaxed text-justify">
        Our website is dedicated to exploring the rich diversity of traditional
        clothing across Asia. We aim to provide clear, well-researched, and visually
        engaging information about the ancient, royal, and modern garments of China,
        Thailand, and India.
        <br><br>
        Through this platform, we hope to help learners, students, and culture
        enthusiasts understand the history, symbolism, and evolution of traditional
        attire in a simple and accessible way.
      </p>
    </div>

  </div>
</section>


<!-- ================= FEATURES ================= -->
<section id="feature" class="bg-[#f5f2ee] py-28 px-6">

  <div class="max-w-8xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-10 items-stretch">

    <!-- LEFT IMAGE -->
    <div class="rounded-[32px] overflow-hidden">
      <img 
        src="https://images.unsplash.com/photo-1501785888041-af3ef285b470"
        class="w-full h-full object-cover"
        alt="Nature"
      >
    </div>

    <!-- CENTER CARD -->
    <div class="rounded-[32px] bg-[#6b733f] p-10 flex flex-col justify-between text-white">
      <div>
        <h3 class="text-sm uppercase tracking-widest mb-4 opacity-80">
          Feature
        </h3>

        <h2 class="font-imperial text-5xl mb-6 leading-none">
          Cultural Exploration
        </h2>

        <p class="text-sm leading-relaxed opacity-90 text-justify">
          This section highlights how users can explore traditional clothing
          across different Asian cultures. Each region is presented visually
          and descriptively to provide cultural insight and inspiration.
        </p>
      </div>

      <p class="text-xs opacity-70 mt-10">
        Discover traditions from China, Thailand, and India through curated visuals.
      </p>
    </div>

    <!-- RIGHT IMAGE -->
    <div class="rounded-[32px] overflow-hidden">
      <img 
        src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee"
        class="w-full h-full object-cover"
        alt="Cabin"
      >
    </div>

  </div>
</section>


<!-- ================= FOOTER ================= -->
<footer class="bg-[#1c1c1c] text-gray-300 py-20 px-6">

  <div class="max-w-7xl mx-auto text-center">

    <!-- SOCIAL ICONS -->
    <div class="flex justify-center gap-6 mb-10 text-xl">
      <a href="#" class="hover:text-white transition">f</a>
      <a href="#" class="hover:text-white transition">x</a>
      <a href="#" class="hover:text-white transition">i</a>
      <a href="#" class="hover:text-white transition">▶</a>
      <a href="#" class="hover:text-white transition">p</a>
    </div>

    <!-- DESCRIPTION -->
    <p class="max-w-3xl mx-auto text-sm leading-relaxed text-gray-400 mb-16">
      Asiatique is a cultural information platform dedicated to exploring traditional
      clothing across Asia. The content of this site is intended for educational purposes
      and cultural appreciation.
    </p>

    <!-- LOGO -->
    <div class="mb-6">
      <img src="assets/images/logo.png" alt="Asiatique Logo" class="h-12 mx-auto invert">
    </div>

    <!-- LOCATION -->
    <p class="text-sm text-gray-400">
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
