<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - SIAKAD Modern</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .animate-float {
            animation: float 6s ease-in-out infinite;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        .glass-effect {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="gradient-bg min-h-screen flex items-center justify-center p-4">

    <!-- Decorative Elements -->
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-40 -right-40 w-80 h-80 bg-white rounded-full opacity-10 animate-float"></div>
        <div class="absolute -bottom-40 -left-40 w-96 h-96 bg-white rounded-full opacity-10 animate-float" style="animation-delay: 2s;"></div>
    </div>

    <!-- Login Container -->
    <div class="relative w-full max-w-md">
        
        <!-- Logo & Title -->
        <div class="text-center mb-8 animate-float">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white rounded-2xl shadow-2xl mb-4">
                <i class="fas fa-graduation-cap text-4xl text-primary-600" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;"></i>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">SIAK</h1>
            <p class="text-white/80 text-sm">Sistem Informasi Akademik Terintegrasi</p>
        </div>

        <!-- Login Card -->
        <div class="glass-effect rounded-3xl shadow-2xl p-8 transform transition-all duration-300 hover:scale-[1.02]">
            
            <!-- Alert Messages -->
            <?php if(isset($error)): ?>
                <div class="mb-6 bg-red-50 border-l-4 border-red-500 p-4 rounded-lg animate-pulse">
                    <div class="flex items-start">
                        <i class="fas fa-exclamation-circle text-red-500 text-xl mt-0.5"></i>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-red-800">Login Gagal</p>
                            <p class="text-sm text-red-700 mt-1"><?= htmlspecialchars($error) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if(isset($success)): ?>
                <div class="mb-6 bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
                    <div class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 text-xl mt-0.5"></i>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">Berhasil!</p>
                            <p class="text-sm text-green-700 mt-1"><?= htmlspecialchars($success) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="post" action="index.php?page=login&aksi=login_process" class="space-y-6">
                
                <!-- Username Field -->
                <div class="space-y-2">
                    <label for="username" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-user mr-2 text-primary-600"></i>Username
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="username"
                            name="username" 
                            placeholder="Masukkan username Anda"
                            required
                            autocomplete="username"
                            class="w-full px-4 py-3 pl-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                        <i class="fas fa-user absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="space-y-2">
                    <label for="password" class="block text-sm font-semibold text-gray-700">
                        <i class="fas fa-lock mr-2 text-primary-600"></i>Password
                    </label>
                    <div class="relative">
                        <input 
                            type="password" 
                            id="password"
                            name="password" 
                            placeholder="Masukkan password Anda"
                            required
                            autocomplete="current-password"
                            class="w-full px-4 py-3 pl-12 pr-12 bg-gray-50 border-2 border-gray-200 rounded-xl focus:bg-white focus:border-primary-500 focus:ring-4 focus:ring-primary-100 transition duration-200 outline-none"
                        >
                        <i class="fas fa-lock absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        <button 
                            type="button" 
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                        >
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center cursor-pointer">
                        <input type="checkbox" class="w-4 h-4 text-primary-600 border-gray-300 rounded focus:ring-primary-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm font-medium text-primary-600 hover:text-primary-700">
                        Lupa password?
                    </a>
                </div>

                <!-- Login Button -->
                <button 
                    type="submit" 
                    name="login"
                    class="w-full gradient-bg text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition duration-200 flex items-center justify-center space-x-2"
                >
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk ke Sistem</span>
                </button>
            </form>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-200"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-4 bg-white text-gray-500">Atau</span>
                </div>
            </div>

            <!-- Register Link -->
            <div class="text-center space-y-3">
                <p class="text-sm text-gray-600">Belum punya akun?</p>
                <a 
                    href="index.php?page=login&aksi=register" 
                    class="block w-full bg-gray-100 text-gray-700 font-semibold py-3 px-6 rounded-xl hover:bg-gray-200 transition duration-200 flex items-center justify-center space-x-2"
                >
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar Sekarang</span>
                </a>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center text-white/70 text-sm">
            <p>&copy; <?= date('Y') ?> SIAKAD Modern. All rights reserved.</p>
            <p class="mt-1">Powered by Modern Technology</p>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts
        setTimeout(() => {
            const alerts = document.querySelectorAll('.animate-pulse');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s ease';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>

</body>
</html>