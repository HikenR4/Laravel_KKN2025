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

        .sidebar {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-collapsed {
            width: 80px;
        }

        .sidebar-expanded {
            width: 280px;
        }

        .nav-item {
            position: relative;
            overflow: hidden;
        }

        .nav-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
            transition: left 0.5s;
        }

        .nav-item:hover::before {
            left: 100%;
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

        /* Logo Section */
        .logo-container {
            background: linear-gradient(135deg, #ffffff20, #ffffff10);
            border: 1px solid rgba(255,255,255,0.2);
            text-align: center;
            padding: 1rem;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
        }

        /* Responsif logo */
        .logo-container img {
            width: 100%;
            height: auto;
            max-width: 60px; /* Atur lebar maksimal logo */
            margin: 0 auto;
            transition: all 0.3s ease;
        }

        .sidebar-collapsed .logo-container img {
            max-width: 40px; /* Sesuaikan ukuran logo saat sidebar terlipat */
            opacity: 0; /* Menyembunyikan logo saat sidebar terlipat */
            transition: opacity 0.3s ease;
        }

        .sidebar-expanded .logo-container img {
            opacity: 1; /* Logo muncul kembali saat sidebar dibuka */
        }

        .sidebar-collapsed .logo-container {
            display: none; /* Menyembunyikan logo container saat sidebar dilipat */
        }

        .stat-card {
            background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
        }

        .menu-text {
            transition: opacity 0.3s ease;
        }

        .sidebar-collapsed .menu-text {
            opacity: 0;
        }

        .sidebar-expanded .menu-text {
            opacity: 1;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <div id="sidebar" class="sidebar sidebar-expanded gradient-bg text-white shadow-2xl">
            <div class="p-6">
                <!-- Logo Section -->
                <div class="logo-container rounded-2xl p-4 mb-8 text-center backdrop-blur-sm">
                    <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full flex items-center justify-center shadow-lg">
                        <img src="/images/kab50kota.png" alt="Logo" class="w-full h-auto">
                    </div>
                    <h2 class="text-lg font-bold text-white menu-text">Nagari Mungo</h2>
                    <p class="text-sm text-blue-100 menu-text">Admin Panel</p>
                </div>

                <!-- Toggle Button -->
                <button id="toggleSidebar" class="w-full mb-6 p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
                    <i class="fas fa-bars text-white"></i>
                </button>

                <!-- Navigation -->
                <nav class="space-y-2">
                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl bg-white/20 text-white transition-all duration-300 hover:bg-white/30">
                        <i class="fas fa-home text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Dashboard</span>
                    </a>

                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-newspaper text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Berita</span>
                    </a>

                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-calendar-alt text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Agenda</span>
                    </a>

                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-bullhorn text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Pengumuman</span>
                    </a>

                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-users text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Data Penduduk</span>
                    </a>

                    <a href="#" class="nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                        <i class="fas fa-cogs text-lg min-w-[20px]"></i>
                        <span class="menu-text ml-4 font-medium">Layanan</span>
                    </a>

                    <div class="my-6 border-t border-white/20"></div>

                    <!-- Logout Form -->
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-item w-full flex items-center py-3 px-4 rounded-xl text-red-200 transition-all duration-300 hover:bg-red-500/20 hover:text-red-100">
                            <i class="fas fa-sign-out-alt text-lg min-w-[20px]"></i>
                            <span class="menu-text ml-4 font-medium">Logout</span>
                        </button>
                    </form>

                </nav>
            </div>
        </div>

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
        // Toggle sidebar
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleSidebar');
        const mainContent = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
            }
        });

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
</body>
</html>
