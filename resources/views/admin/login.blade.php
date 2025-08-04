<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen flex items-center justify-center bg-cover bg-center relative overflow-hidden"
      style="background-image: url('/images/kantor.jpeg');">

    <!-- Background overlay -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900/20 via-transparent to-green-900/20"></div>

    <!-- Main login container -->
    <div class="relative z-10 bg-white/20 backdrop-blur-lg border border-white/20 p-8 rounded-2xl shadow-2xl w-full max-w-md mx-4">

        <!-- Logo/Title -->
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-green-500 rounded-full mx-auto mb-4 flex items-center justify-center">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold text-gray-800 mb-2">Login Admin</h2>
            <p class="text-gray-700 text-lg font-medium">Nagari Mungo</p>
        </div>

        <!-- Error messages -->
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

        <!-- Login form -->
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Username field -->
            <div>
                <label for="username" class="block text-gray-800 font-semibold mb-2 text-sm uppercase tracking-wide">
                    Username
                </label>
                <input type="text" name="username" id="username"
                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border border-gray-300 rounded-lg
                            text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400/50
                            focus:border-blue-400 focus:bg-white/80 transition-all duration-300"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}"
                    required>
            </div>

            <!-- Password field -->
            <div>
                <label for="password" class="block text-gray-800 font-semibold mb-2 text-sm uppercase tracking-wide">
                    Password
                </label>
                <input type="password" name="password" id="password"
                    class="w-full px-4 py-3 bg-white/70 backdrop-blur-sm border border-gray-300 rounded-lg
                            text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-blue-400/50
                            focus:border-blue-400 focus:bg-white/80 transition-all duration-300"
                    placeholder="Masukkan password"
                    required>
            </div>

            <!-- Login button -->
            <div>
                <button type="submit"
                        class="w-full bg-gradient-to-r from-blue-500 to-green-500 hover:from-blue-600 hover:to-green-600
                            text-white font-bold py-3 px-6 rounded-lg transition-all duration-300
                            hover:-translate-y-1 hover:shadow-xl focus:outline-none focus:ring-4 focus:ring-blue-300/50">
                    <span class="flex items-center justify-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                        LOGIN
                    </span>
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="text-center mt-8">
            <div class="w-full h-px bg-gradient-to-r from-transparent via-white/30 to-transparent mb-4"></div>
            <p class="text-gray-600 text-sm">&copy; 2024 Nagari Mungo</p>
            <p class="text-gray-500 text-xs mt-1">Sistem Informasi Desa</p>
        </div>
    </div>
</body>
</html>
