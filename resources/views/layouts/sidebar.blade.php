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
</script>

<style>
    .sidebar-collapsed {
        width: 80px;
    }

    .sidebar-expanded {
        width: 280px;
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

    .sidebar-collapsed .logo-container {
        display: none;
    }

    .sidebar-collapsed .logo-container img {
        max-width: 40px;
        opacity: 0;
    }

    .sidebar-expanded .logo-container img {
        opacity: 1;
    }

    .logo-container img {
        width: 100%;
        height: auto;
        max-width: 60px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }
</style>
