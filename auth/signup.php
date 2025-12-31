<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | Asiatique</title>
    
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
    <style> body { background: #f9e8c6ff; } </style>
</head>

<body class="min-h-screen flex items-center justify-center px-6 py-12">

    <div class="max-w-5xl w-full bg-white rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-2">

        <div class="relative hidden md:block h-full">
            <div class="absolute inset-0 bg-black/10 z-10"></div>
            <img id="signupImage"
                 src="https://i.pinimg.com/1200x/91/5f/e4/915fe45b58cf73a5eba02f34167f9f24.jpg" 
                 class="w-full h-full object-cover transition-all duration-1000">
            
            <div class="absolute bottom-10 left-10 z-20 text-white">
                <h3 class="font-imperial text-5xl mb-2">Asiatique</h3>
                <p class="text-sm font-light tracking-widest uppercase opacity-90">Heritage & History</p>
            </div>
        </div>

        <div class="p-10 md:p-14 flex flex-col justify-center">
            
            <div class="mb-8">
                <h2 class="font-imperial text-7xl font-bold text-[#4F6815] mb-2">Create Account</h2>
                <p class="text-gray-500 font-light">Join us to explore the tapestry of Asian culture.</p>
            </div>

            <?php if (isset($_GET['error'])): ?>
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 text-sm">
                    <p><?php echo htmlspecialchars($_GET['error']); ?></p>
                </div>
            <?php endif; ?>

            <form action="signup_process.php" method="POST" class="space-y-5">

                <div>
                    <label class="text-sm font-semibold text-gray-700 ml-1">Email Address</label>
                    <input type="email" name="email" required placeholder="name@example.com"
                           class="w-full mt-2 px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#c9a227] focus:ring-1 focus:ring-[#c9a227] transition-all bg-gray-50 focus:bg-white">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700 ml-1">Password</label>
                    <input type="password" name="password" required placeholder="Minimum 6 characters"
                           class="w-full mt-2 px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#c9a227] focus:ring-1 focus:ring-[#c9a227] transition-all bg-gray-50 focus:bg-white">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700 ml-1">Confirm Password</label>
                    <input type="password" name="confirm_password" required placeholder="Retype password"
                           class="w-full mt-2 px-5 py-3 border border-gray-200 rounded-xl focus:outline-none focus:border-[#c9a227] focus:ring-1 focus:ring-[#c9a227] transition-all bg-gray-50 focus:bg-white">
                </div>

                <button type="submit"
                        class="w-full bg-[#8f2210] text-white font-bold py-3.5 rounded-full mt-6 hover:bg-[#6E1203] shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300">
                    Sign Up
                </button>

            </form>

            <p class="text-sm text-center mt-8 text-gray-500">
                Already have an account?
                <a href="login.php" class="text-[#c9a227] font-bold hover:underline">Log In</a>
            </p>
        </div>
    </div>
</body>
</html>