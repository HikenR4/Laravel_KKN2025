<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'fade-in-up': 'fadeInUp 0.8s ease-out',
                        'slide-in-left': 'slideInLeft 0.6s ease-out',
                        'float': 'float 3s ease-in-out infinite',
                        'pulse-glow': 'pulseGlow 2s ease-in-out infinite',
                        'particle-float': 'particleFloat 6s infinite ease-in-out',
                    },
                    keyframes: {
                        fadeInUp: {
                            '0%': { opacity: '0', transform: 'translateY(30px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' }
                        },
                        slideInLeft: {
                            '0%': { opacity: '0', transform: 'translateX(-30px)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' }
                        },
                        float: {
                            '0%, 100%': { transform: 'translateY(0px)' },
                            '50%': { transform: 'translateY(-10px)' }
                        },
                        pulseGlow: {
                            '0%, 100%': { boxShadow: '0 0 20px rgba(59, 130, 246, 0.3)' },
                            '50%': { boxShadow: '0 0 30px rgba(59, 130, 246, 0.6)' }
                        },
                        particleFloat: {
                            '0%, 100%': { transform: 'translateY(0px) rotate(0deg)', opacity: '0.3' },
                            '33%': { transform: 'translateY(-20px) rotate(120deg)', opacity: '0.6' },
                            '66%': { transform: 'translateY(-10px) rotate(240deg)', opacity: '0.4' }
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative overflow-hidden"
      style="background-image: url('/images/kantor.jpeg');">

    <!-- Animated floating particles -->
    <div class="absolute top-1/4 left-1/12 w-2 h-2 bg-white/30 rounded-full animate-particle-float"></div>
    <div class="absolute top-3/5 right-1/6 w-3 h-3 bg-blue-300/40 rounded-full animate-particle-float" style="animation-delay: 2s;"></div>
    <div class="absolute bottom-1/3 left-1/5 w-1.5 h-1.5 bg-green-300/30 rounded-full animate-particle-float" style="animation-delay: 4s;"></div>
    <div class="absolute top-1/3 right-1/4 w-2.5 h-2.5 bg-yellow-300/25 rounded-full animate-particle-float" style="animation-delay: 1s;"></div>

    <!-- Background overlay with gradient -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 via-transparent to-green-900/20"></div>

    <!-- Main login container -->
    <div class="relative z-10 bg-white/20 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4 animate-fade-in-up">

        <!-- Logo/Title with glow effect -->
        <div class="text-center mb-8 animate-slide-in-left">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-green-500 rounded-full mx-auto mb-4 flex items-center justify-center animate-float shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2" style="text-shadow: 0 0 20px rgba(255, 255, 255, 0.8);">
                Login Admin
            </h2>
            <p class="text-gray-700 text-lg font-medium">Nagari Mungo</p>
        </div>

        <!-- Error messages -->
        <div class="animate-slide-in-left" style="animation-delay: 0.2s;">
            @if (session('error'))
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-300/30 text-red-800 px-4 py-3 rounded-lg mb-4">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-500/20 backdrop-blur-sm border border-red-300/30 text-red-800 px-4 py-3 rounded-lg mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Login form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
        @csrf
        <!-- Username field -->
        <div class="animate-slide-in-left" style="animation-delay: 0.4s;">
            <label for="username" class="block text-gray-800 font-semibold mb-2 text-sm uppercase tracking-wide">
                Username
            </label>
            <div class="relative group">
                <input type="text" name="username" id="username"
                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border border-gray-300 rounded-lg
                            text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400/50
                            focus:border-blue-400 focus:bg-white/80 transition-all duration-300
                            hover:bg-white/80 hover:border-gray-400 focus:-translate-y-1 focus:shadow-lg"
                    placeholder="Masukkan username"
                    required>
                <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-400/0 via-blue-400/5 to-blue-400/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            </div>
        </div>

        <!-- Password field -->
        <div class="animate-slide-in-left" style="animation-delay: 0.6s;">
            <label for="password" class="block text-gray-800 font-semibold mb-2 text-sm uppercase tracking-wide">
                Password
            </label>
            <div class="relative group">
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border border-gray-300 rounded-lg
                            text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400/50
                            focus:border-blue-400 focus:bg-white/80 transition-all duration-300
                            hover:bg-white/80 hover:border-gray-400 focus:-translate-y-1 focus:shadow-lg"
                    placeholder="Masukkan password"
                    required>
                <div class="absolute inset-0 rounded-lg bg-gradient-to-r from-blue-400/0 via-blue-400/5 to-blue-400/0 opacity-0 group-hover:opacity-100 transition-opacity duration-300 pointer-events-none"></div>
            </div>
        </div>

        <!-- Login button -->
        <div class="animate-slide-in-left" style="animation-delay: 0.8s;">
            <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600
                        text-white font-bold py-3 px-6 rounded-lg transition-all duration-300
                        hover:-translate-y-1 hover:shadow-xl active:translate-y-0 active:shadow-lg
                        focus:outline-none focus:ring-4 focus:ring-blue-300/50 relative overflow-hidden group">
                <span class="relative z-10 flex items-center justify-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                    </svg>
                    LOGIN
                </span>
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-full group-hover:translate-x-full transition-transform duration-700"></div>
            </button>
        </div>
    </form>

        <!-- Footer -->
        <div class="text-center mt-8 animate-slide-in-left" style="animation-delay: 1s;">
            <div class="w-full h-px bg-gradient-to-r from-transparent via-white/30 to-transparent mb-4"></div>
            <p class="text-gray-600 text-sm">
                &copy; 2024 Nagari Mungo
            </p>
            <p class="text-gray-500 text-xs mt-1">
                Sistem Informasi Desa
            </p>
        </div>
    </div>

    <script>
        // Add some interactive effects
        document.addEventListener('DOMContentLoaded', function() {
            // Add ripple effect to button
            const button = document.querySelector('button[type="submit"]');
            button.addEventListener('click', function(e) {
                const ripple = document.createElement('div');
                const rect = button.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.style.cssText = `
                    position: absolute;
                    width: ${size}px;
                    height: ${size}px;
                    left: ${x}px;
                    top: ${y}px;
                    background: rgba(255, 255, 255, 0.3);
                    border-radius: 50%;
                    transform: scale(0);
                    animation: ripple 0.6s ease-out;
                    pointer-events: none;
                `;

                button.appendChild(ripple);
                setTimeout(() => ripple.remove(), 600);
            });

            // Add CSS for ripple animation
            const style = document.createElement('style');
            style.textContent = `
                @keyframes ripple {
                    to {
                        transform: scale(2);
                        opacity: 0;
                    }
                }
            `;
            document.head.appendChild(style);
        });
    </script>
</body>
</html>
