<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div class="bg-blue-800 text-white w-64 p-4">
            <h2 class="text-xl font-bold mb-6">Nagari Mungo Admin</h2>
            <nav>
                <a href="{{ route('admin.dashboard') }}"
                   class="block py-2 px-4 rounded bg-blue-900">Dashboard</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Berita</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Agenda</a>
                <a href="#" class="block py-2 px-4 rounded hover:bg-blue-700">Pengumuman</a>
                <a href="{{ route('admin.logout') }}"
                   class="block py-2 px-4 rounded hover:bg-blue-700">Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="flex-1 p-8">
            <div class="bg-white rounded-lg shadow-lg p-6">
                <h1 class="text-2xl font-bold mb-4">Selamat Datang, {{ Auth::guard('admin')->user()->nama_lengkap }}</h1>
                <p class="text-gray-600">Ini adalah panel admin untuk mengelola website Nagari Mungo.</p>
            </div>
        </div>
    </div>
</body>
</html>
