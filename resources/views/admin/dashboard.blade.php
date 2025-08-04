<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .stat-card {
            background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 p-8 transition-all duration-300" id="mainContent">
            <!-- Header -->
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-800 mb-2">
                            Selamat Datang, Admin
                        </h1>
                        <p class="text-gray-600">
                            Dashboard untuk mengelola website Nagari Mungo
                        </p>
                    </div>
                    <div class="text-right">
                        <div class="text-sm text-gray-500">Hari ini</div>
                        <div class="text-lg font-semibold text-gray-800" id="currentDate"></div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="stat-card card-hover from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Total Berita</h3>
                            <p class="text-3xl font-bold">42</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-newspaper text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+12% dari bulan lalu</span>
                    </div>
                </div>

                <div class="stat-card card-hover from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Total Agenda</h3>
                            <p class="text-3xl font-bold">28</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-calendar-alt text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+8% dari bulan lalu</span>
                    </div>
                </div>

                <div class="stat-card card-hover from-yellow-500 to-orange-500 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Pengumuman Aktif</h3>
                            <p class="text-3xl font-bold">15</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-bullhorn text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-down mr-1"></i>
                        <span>-3% dari bulan lalu</span>
                    </div>
                </div>

                <div class="stat-card card-hover from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Total Penduduk</h3>
                            <p class="text-3xl font-bold">2,847</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>+5% dari bulan lalu</span>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <button class="w-full flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Tambah Berita Baru</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </button>

                        <button class="w-full flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-plus text-green-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Buat Agenda Baru</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </button>

                        <button class="w-full flex items-center justify-between p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-megaphone text-yellow-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Publikasi Pengumuman</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Berita "Gotong Royong Desa" dipublikasikan</p>
                                <p class="text-xs text-gray-500">2 jam yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-green-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Agenda "Rapat RT" ditambahkan</p>
                                <p class="text-xs text-gray-500">5 jam yang lalu</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3">
                            <div class="w-2 h-2 bg-purple-500 rounded-full mt-2"></div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">Data penduduk diperbarui</p>
                                <p class="text-xs text-gray-500">1 hari yang lalu</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Update current date
        const dateElement = document.getElementById('currentDate');
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        dateElement.textContent = now.toLocaleDateString('id-ID', options);

        // Add smooth scrolling and animations
        document.addEventListener('DOMContentLoaded', function() {
            // Animate cards on load
            const cards = document.querySelectorAll('.card-hover');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => {
                    card.style.transition = 'all 0.5s ease';
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });
    </script>
