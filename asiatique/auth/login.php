
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login | Asiatique</title>

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

<!-- Tailwind -->
<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
  font-family: 'Quicksand', sans-serif;
  background: #f5f2ee;
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center px-6">

<!-- CARD -->
<div class="w-full max-w-6xl bg-white rounded-[32px] overflow-hidden shadow-lg grid grid-cols-1 lg:grid-cols-2">

  <!-- ===== LEFT IMAGE SLIDER ===== -->
  <div class="relative hidden lg:block">

    <?php foreach ($images as $index => $img): ?>
      <img
        src="<?= $img ?>"
        class="login-slide absolute inset-0 w-full h-full object-cover transition-opacity duration-1000 <?= $index === 0 ? 'opacity-100' : 'opacity-0' ?>"
      >
    <?php endforeach; ?>

    <!-- overlay biar soft -->
    <div class="absolute inset-0 bg-black/10"></div>
  </div>

  <!-- ===== RIGHT FORM ===== -->
  <div class="p-10 lg:p-14 flex flex-col justify-center">

    <h2 class="text-2xl font-semibold mb-2">Welcome Back</h2>
    <p class="text-gray-500 mb-8 text-sm">
      Enter your email and password to access your account
    </p>

    <form action="login_process.php" method="POST" class="space-y-5">

      <div>
        <label class="text-sm block mb-1">Email</label>
        <input type="email" name="email" required
          class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black">
      </div>

      <div>
        <label class="text-sm block mb-1">Password</label>
        <input type="password" name="password" required
          class="w-full border rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-black">
      </div>

      <div class="flex items-center justify-between text-sm">
        <label class="flex items-center gap-2">
          <input type="checkbox">
          Remember me
        </label>
        <a href="#" class="hover:underline">Forgot password</a>
      </div>

      <button
        type="submit"
        class="w-full bg-black text-white py-3 rounded-lg hover:bg-gray-800 transition">
        Log In
      </button>

      <button
        type="button"
        class="w-full border py-3 rounded-lg flex items-center justify-center gap-2 hover:bg-gray-100 transition">
        <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5">
        Log in with Google
      </button>

      <p class="text-center text-sm text-gray-500 mt-6">
        Don’t have an account?
        <a href="signup.php" class="underline font-medium">Sign Up</a>
      </p>

    </form>
  </div>

</div>

<!-- ===== SLIDER SCRIPT ===== -->
<script>
const slides = document.querySelectorAll('.login-slide');
let current = 0;

setInterval(() => {
  slides[current].classList.remove('opacity-100');
  slides[current].classList.add('opacity-0');

  current = (current + 1) % slides.length;

  slides[current].classList.remove('opacity-0');
  slides[current].classList.add('opacity-100');
}, 4000); // ganti gambar tiap 4 detik
</script>

</body>
</html>
