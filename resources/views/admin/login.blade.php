<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .glass-effect {
            background: rgba(220, 20, 60, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .input-focus {
            transition: all 0.3s ease;
        }

        .input-focus:focus {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .btn-hover {
            transition: all 0.3s ease;
        }

        .btn-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(220, 20, 60, 0.3);
        }

        .floating-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(180deg); }
        }

        .slide-in {
            animation: slideIn 0.8s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .white-bg {
            background: linear-gradient(135deg, #ffffff 0%, #f8f9fa 50%, #ffffff 100%);
        }

        .back-btn {
            position: absolute;
            top: 2rem;
            left: 2rem;
            z-index: 20;
            background: linear-gradient(135deg, #DC143C 0%, #B22222 100%);
        }

        .red-circles {
            background: radial-gradient(circle, rgba(220, 20, 60, 0.8) 0%, rgba(220, 20, 60, 0.4) 40%, transparent 70%);
        }

        .pulse-animation {
            animation: pulse 4s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.7; }
            50% { transform: scale(1.1); opacity: 0.9; }
        }

        @media (max-width: 640px) {
            .back-btn {
                top: 1rem;
                left: 1rem;
            }
        }

        /* Custom scrollbar for webkit browsers */
        ::-webkit-scrollbar {
            width: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        ::-webkit-scrollbar-thumb {
            background: #DC143C;
            border-radius: 3px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #B22222;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative overflow-hidden white-bg">

    <!-- Background overlay with subtle pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-gray-50/30 via-transparent to-gray-100/20"></div>

    <!-- Floating red circles for decoration -->
    <div class="absolute top-10 left-10 w-24 h-24 red-circles rounded-full floating-animation opacity-60" style="animation-delay: 0s;"></div>
    <div class="absolute top-32 right-20 w-20 h-20 red-circles rounded-full floating-animation opacity-50 pulse-animation" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-20 left-32 w-16 h-16 red-circles rounded-full floating-animation opacity-70" style="animation-delay: 4s;"></div>
    <div class="absolute bottom-32 right-10 w-28 h-28 red-circles rounded-full floating-animation opacity-40 pulse-animation" style="animation-delay: 1s;"></div>
    <div class="absolute top-1/2 left-5 w-12 h-12 red-circles rounded-full floating-animation opacity-60" style="animation-delay: 3s;"></div>
    <div class="absolute top-20 right-1/4 w-14 h-14 red-circles rounded-full floating-animation opacity-50" style="animation-delay: 5s;"></div>

    <!-- Back to Home Button -->
    <a href="/" class="back-btn text-white px-6 py-3 rounded-full hover:shadow-lg transition-all duration-300 flex items-center gap-2 text-sm font-medium shadow-md">
        <i class="fas fa-arrow-left"></i>
        <span class="hidden sm:inline">Kembali ke Beranda</span>
        <span class="sm:hidden">Kembali</span>
    </a>

    <!-- Main login container -->
    <div class="relative z-10 glass-effect p-6 rounded-2xl shadow-2xl w-full max-w-sm mx-4 slide-in">

        <!-- Logo/Title -->
       <div class="text-center mb-4">
            <div class="w-12 h-12 bg-white rounded-lg mx-auto mb-3 flex items-center justify-center shadow-lg">
                <img src="{{ url('images/kab50kota.png') }}" alt="Logo Nagari Mungo" class="w-10 h-10">
            </div>
            <h2 class="text-xl font-bold text-white mb-1">Login Admin</h2>
            <p class="text-white/90 text-sm font-medium">Nagari Mungo</p>
            <div class="w-12 h-0.5 bg-gradient-to-r from-transparent via-white/50 to-transparent mx-auto mt-2"></div>
        </div>


        <!-- Error messages -->
        <div id="errorContainer">
            @if (session('error'))
                <div class="bg-red-200/30 backdrop-blur-sm border border-red-300/50 text-white px-4 py-3 rounded-xl mb-6 slide-in">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-200/30 backdrop-blur-sm border border-red-300/50 text-white px-4 py-3 rounded-xl mb-6 slide-in">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 mt-0.5 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li class="font-medium">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
        </div>

        <!-- Login form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-3" id="loginForm">
            @csrf

            <!-- Username field -->
            <div>
                <label for="username" class="block text-white/90 font-semibold mb-2 text-xs uppercase tracking-wide flex items-center gap-2">
                    <i class="fas fa-user text-white/70 text-xs"></i>
                    Username
                </label>
                <input type="text" name="username" id="username"
                    class="input-focus w-full px-3 py-2.5 bg-white/95 backdrop-blur-sm border border-white/50 rounded-lg
                            text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/70
                            focus:border-white focus:bg-white transition-all duration-300 font-medium text-sm"
                    placeholder="Masukkan username admin"
                    value="{{ old('username') }}"
                    required>
            </div>

            <!-- Password field -->
            <div>
                <label for="password" class="block text-white/90 font-semibold mb-2 text-xs uppercase tracking-wide flex items-center gap-2">
                    <i class="fas fa-lock text-white/70 text-xs"></i>
                    Password
                </label>
                <div class="relative">
                    <input type="password" name="password" id="password"
                        class="input-focus w-full px-3 py-2.5 bg-white/95 backdrop-blur-sm border border-white/50 rounded-lg
                                text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-white/70
                                focus:border-white focus:bg-white transition-all duration-300 font-medium pr-10 text-sm"
                        placeholder="Masukkan password"
                        required>
                    <button type="button" onclick="togglePassword()" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors">
                        <i class="fas fa-eye text-sm" id="toggleIcon"></i>
                    </button>
                </div>
            </div>

            <!-- Remember me -->
            <div class="flex items-center">
                <input type="checkbox" name="remember" id="remember" class="w-3 h-3 text-white bg-white/80 border-white/50 rounded focus:ring-white/70 focus:ring-2">
                <label for="remember" class="ml-2 text-white/90 text-xs font-medium">Ingat saya</label>
            </div>

            <!-- Login button -->
            <div class="pt-1">
                <button type="submit"
                        class="btn-hover w-full bg-white text-red-600 font-bold py-3 px-4 rounded-lg transition-all duration-300
                            hover:bg-red-50 focus:outline-none focus:ring-4 focus:ring-white/50 shadow-lg">
                    <span class="flex items-center justify-center gap-2 text-base">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        MASUK ADMIN
                    </span>
                </button>
            </div>
        </form>

        <!-- Additional info -->
        <div class="text-center mt-4">
            <div class="w-full h-px bg-gradient-to-r from-transparent via-white/30 to-transparent mb-3"></div>
            <p class="text-white/80 text-xs mb-1">&copy; 2025 Nagari Mungo</p>
            <p class="text-white/60 text-xs">Sistem Informasi Digital Nagari</p>

            <!-- Help text -->
            <div class="mt-2 p-2 bg-white/20 rounded-lg backdrop-blur-sm">
                <p class="text-white/80 text-xs">
                    <i class="fas fa-info-circle mr-1"></i>
                    Hubungi administrator jika mengalami kesulitan login
                </p>
            </div>
        </div>
    </div>

    <script>
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

        // Auto-hide error messages after 5 seconds
        setTimeout(() => {
            const errorContainer = document.getElementById('errorContainer');
            if (errorContainer && errorContainer.children.length > 0) {
                Array.from(errorContainer.children).forEach(error => {
                    error.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                    error.style.opacity = '0';
                    error.style.transform = 'translateY(-10px)';
                    setTimeout(() => error.remove(), 500);
                });
            }
        }, 5000);

        // Form validation
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            const username = document.getElementById('username').value.trim();
            const password = document.getElementById('password').value;

            if (!username || !password) {
                e.preventDefault();
                showError('Username dan password harus diisi');
                return;
            }

            if (username.length < 3) {
                e.preventDefault();
                showError('Username minimal 3 karakter');
                return;
            }

            if (password.length < 6) {
                e.preventDefault();
                showError('Password minimal 6 karakter');
                return;
            }

            // If validation passes, allow form to submit normally
            // Remove the e.preventDefault() for demo - in real app, form will submit to server
        });

        function showError(message) {
            const errorContainer = document.getElementById('errorContainer');
            const errorDiv = document.createElement('div');
            errorDiv.className = 'bg-red-200/30 backdrop-blur-sm border border-red-300/50 text-white px-4 py-3 rounded-xl mb-6 slide-in';
            errorDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            errorContainer.appendChild(errorDiv);

            // Auto remove after 3 seconds
            setTimeout(() => {
                errorDiv.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                errorDiv.style.opacity = '0';
                errorDiv.style.transform = 'translateY(-10px)';
                setTimeout(() => errorDiv.remove(), 500);
            }, 3000);
        }

        function showSuccess(message) {
            const errorContainer = document.getElementById('errorContainer');
            const successDiv = document.createElement('div');
            successDiv.className = 'bg-green-200/30 backdrop-blur-sm border border-green-300/50 text-white px-4 py-3 rounded-xl mb-6 slide-in';
            successDiv.innerHTML = `
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    <span class="font-medium">${message}</span>
                </div>
            `;
            errorContainer.appendChild(successDiv);

            // Auto remove after 2 seconds
            setTimeout(() => {
                successDiv.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
                successDiv.style.opacity = '0';
                successDiv.style.transform = 'translateY(-10px)';
                setTimeout(() => successDiv.remove(), 500);
            }, 2000);
        }

        // Smooth focus animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.01)';
            });

            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // Add more dynamic red circles randomly
        function createFloatingCircle() {
            const circle = document.createElement('div');
            const size = Math.random() * 40 + 10; // Random size between 10-50px
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * window.innerHeight;
            const delay = Math.random() * 6;

            circle.className = 'absolute red-circles rounded-full floating-animation opacity-30';
            circle.style.width = size + 'px';
            circle.style.height = size + 'px';
            circle.style.left = x + 'px';
            circle.style.top = y + 'px';
            circle.style.animationDelay = delay + 's';
            circle.style.zIndex = '1';

            document.body.appendChild(circle);

            // Remove after animation completes
            setTimeout(() => {
                circle.remove();
            }, 12000);
        }

        // Create new floating circles periodically
        setInterval(createFloatingCircle, 3000);
    </script>
</body>
</html>
