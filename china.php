<?php
require_once "config/database.php";

/* ======================
   AMBIL DATA COUNTRY
====================== */
$countryQuery = mysqli_query(
  $conn,
  "SELECT * FROM countries WHERE slug='china' LIMIT 1"
);

$country = mysqli_fetch_assoc($countryQuery);

/* ======================
   AMBIL DATA CATALOG
====================== */
$catalogsQuery = mysqli_query(
  $conn,
  "SELECT * FROM cultural_heritage WHERE country_slug='china'"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Asiatique | China</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
  body {
    font-family: 'Quicksand', sans-serif;
    background-color: #f5f2ee;
  }
  .font-imperial {
    font-family: 'Imperial Script', cursive;
  }
</style>
</head>

<body>

<!-- ================= HERO CHINA ================= -->
<section class="relative h-[520px] overflow-hidden">
<?php if ($country): ?>
  <img src="<?= htmlspecialchars($country['hero_image']) ?>"
       class="absolute inset-0 w-full h-full object-cover">

  <div class="absolute inset-0 bg-black/40"></div>

  <div class="absolute top-24 left-16 text-white max-w-2xl">
    <h1 class="font-imperial text-8xl mb-4">
      <?= htmlspecialchars($country['hero_title']) ?>
    </h1>
    <p class="text-lg leading-relaxed">
      <?= htmlspecialchars($country['hero_desc']) ?>
    </p>
  </div>
<?php else: ?>
  <div class="flex items-center justify-center h-full text-gray-600">
    Data China belum tersedia di database
  </div>
<?php endif; ?>
</section>

<!-- ================= CULTURAL HERITAGE ================= -->
<section class="py-20 px-6">

  <div class="max-w-7xl mx-auto mb-16">
    <div class="flex items-center">
      <div class="flex-1 h-px bg-[#8b1d1d]"></div>
      <h2 class="mx-6 font-imperial text-5xl text-[#8b1d1d]">
        Cultural Heritage China
      </h2>
      <div class="flex-1 h-px bg-[#8b1d1d]"></div>
    </div>
  </div>

  <div class="max-w-7xl mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">

  <?php if (mysqli_num_rows($catalogsQuery) > 0): ?>
    <?php while ($c = mysqli_fetch_assoc($catalogsQuery)): ?>
      <div class="bg-white rounded-xl overflow-hidden shadow group relative">

        <img src="<?= htmlspecialchars($c['image']) ?>"
             class="w-full h-[200px] object-cover">

        <div class="absolute inset-0 bg-black/70 opacity-0
                    group-hover:opacity-100 transition
                    flex items-center justify-center p-6 text-white">

          <div class="text-center">
            <h3 class="text-xl mb-2">
              <?= htmlspecialchars($c['title']) ?>
            </h3>

            <p class="text-sm mb-4">
              <?= htmlspecialchars($c['description']) ?>
            </p>

            <a href="<?= htmlspecialchars($c['link']) ?>"
               target="_blank"
               class="underline text-sm">
              Read more
            </a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  <?php else: ?>
    <p class="text-center col-span-3 text-gray-500">
      Belum ada catalog untuk China
    </p>
  <?php endif; ?>

  </div>
</section>

</body>
</html>
