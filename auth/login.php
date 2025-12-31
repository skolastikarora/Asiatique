<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Asiatique</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Imperial+Script&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'imperial': ['"Imperial Script"', 'cursive'],
                        'sans': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { background: #f9e8c6ff; }
    </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6 py-12">

    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <div class="relative hidden md:block h-full">
            <div class="absolute inset-0 bg-black/10 z-10"></div> <img id="loginImage"
                 src="https://i.pinimg.com/1200x/8b/60/a2/8b60a273102c51427aedc78fb27b9ad7.jpg" 
                 class="w-full h-full object-cover transition-all duration-1000">

            <div class="absolute bottom-10 left-10 z-20 text-white">
                <h3 class="font-imperial text-5xl mb-2">Asiatique</h3>
                <p class="text-sm font-light tracking-widest uppercase opacity-90">Timeless Elegance</p>
            </div>
        </div>

        <div class="p-10 md:p-14 flex flex-col justify-center">

            <div class="mb-8">
                <h2 class="font-imperial text-7xl font-bold text-[#4F6815] mb-2">Welcome Back</h2>
                <p class="text-gray-500 font-light text-sm">
                    Enter your email and password to access your account
                </p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">error</span>
                    <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            <?php endif; ?>

            <form action="login_process.php" method="POST" class="space-y-5">

                <div>
                    <label class="text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="name@example.com"
                        class="w-full mt-2 px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#c9a227] focus:ring-1 focus:ring-[#c9a227] transition-all bg-gray-50 focus:bg-white">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="••••••••"
                        class="w-full mt-2 px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#c9a227] focus:ring-1 focus:ring-[#c9a227] transition-all bg-gray-50 focus:bg-white">
                </div>

                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600 hover:text-gray-800">
                        <input type="checkbox" class="accent-[#6E1203] w-4 h-4">
                        Remember me
                    </label>
                    <a href="#" class="text-[#6e1203] font-semibold hover:underline">Forgot password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-[#8f2210] text-white font-bold py-3.5 rounded-full hover:bg-[#6e1203] shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    Log In
                </button>

                <button type="button"
                    class="w-full border border-gray-300 py-3.5 rounded-full flex items-center justify-center gap-2 hover:bg-gray-50 transition text-gray-700 font-medium">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5">
                    Log in with Google
                </button>

            </form>

            <p class="text-center text-sm text-gray-500 mt-8">
                Don’t have an account?
                <a href="signup.php" class="text-[#c9a227] font-bold hover:underline">Sign Up</a>
            </p>

        </div>

    </div>



</body>
</html>