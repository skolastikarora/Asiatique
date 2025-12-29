<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up | Asiatique</title>

<script src="https://cdn.tailwindcss.com"></script>

<style>
body {
  background:#f5f2ee;
}
</style>
</head>

<body class="min-h-screen flex items-center justify-center px-6">

<div class="max-w-5xl w-full bg-white rounded-3xl shadow-lg overflow-hidden grid grid-cols-1 md:grid-cols-2">

  <!-- LEFT IMAGE -->
  <div class="relative hidden md:block">
    <img id="signupImage"
         src="../assets/images/login1.jpg"
         class="w-full h-full object-cover">
  </div>

  <!-- RIGHT FORM -->
  <div class="p-10 flex flex-col justify-center">
    <h2 class="text-2xl font-semibold mb-2">Create Account</h2>
    <p class="text-sm text-gray-500 mb-6">
      Join Asiatique and explore Asian culture
    </p>

    <?php if (isset($_GET['error'])): ?>
      <p class="text-red-600 text-sm mb-4">
        Email sudah terdaftar
      </p>
    <?php endif; ?>

    <form action="signup_process.php" method="POST" class="space-y-4">

      <div>
        <label class="text-sm">Full Name</label>
        <input type="text" name="name" required
               class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none">
      </div>

      <div>
        <label class="text-sm">Email</label>
        <input type="email" name="email" required
               class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none">
      </div>

      <div>
        <label class="text-sm">Password</label>
        <input type="password" name="password" required
               class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none">
      </div>

      <div>
        <label class="text-sm">Confirm Password</label>
        <input type="password" name="confirm_password" required
               class="w-full mt-1 px-4 py-2 border rounded-lg focus:outline-none">
      </div>

      <button type="submit"
              class="w-full bg-black text-white py-2.5 rounded-full mt-4 hover:bg-gray-900 transition">
        Sign Up
      </button>

    </form>

    <p class="text-sm text-center mt-6">
      Already have an account?
      <a href="login.php" class="underline">Sign In</a>
    </p>
  </div>

</div>

<script>
const images = [
  "../assets/images/login1.jpg",
  "../assets/images/login2.jpg",
  "../assets/images/login3.jpg"
];

let i = 0;
setInterval(() => {
  i = (i + 1) % images.length;
  document.getElementById("signupImage").src = images[i];
}, 4000);
</script>

</body>
</html>
