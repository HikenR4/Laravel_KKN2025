<style>

    /* Efek transisi submenu */
#submenuNagari {
    transition: all 0.3s ease;
    display: block;
    padding-left: 1.5rem;
}

/* Menyembunyikan submenu secara default */
#submenuNagari.hidden {
    display: none;
}

/* Gradient background khusus sidebar */
    .sidebar-gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Sidebar width states */
    .sidebar-collapsed {
        width: 80px;
        transition: width 0.3s ease;
    }

    .sidebar-expanded {
        width: 280px;
        transition: width 0.3s ease;
    }

    /* Menu text transitions */
    .sidebar-menu-text {
        transition: opacity 0.3s ease;
        white-space: nowrap;
    }

    .sidebar-collapsed .sidebar-menu-text {
        opacity: 0;
        pointer-events: none;
    }

    .sidebar-expanded .sidebar-menu-text {
        opacity: 1;
        pointer-events: auto;
    }

    /* Logo container styling */
    .sidebar-logo-container {
        transition: all 0.3s ease;
    }

    .sidebar-collapsed .sidebar-logo-container {
        display: none;
    }

    .sidebar-collapsed .sidebar-logo-container img {
        max-width: 40px;
        opacity: 0;
    }

    .sidebar-expanded .sidebar-logo-container img {
        opacity: 1;
    }

    .sidebar-logo-container img {
        width: 100%;
        height: auto;
        max-width: 60px;
        margin: 0 auto;
        transition: all 0.3s ease;
    }

    /* Navigation items */
    .sidebar-nav-item {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .sidebar-nav-item:hover {
        transform: translateX(2px);
    }

    .sidebar-nav-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.1), transparent);
        transition: left 0.5s ease;
    }

    .sidebar-nav-item:hover::before {
        left: 100%;
    }

    /* Toggle button */
    .sidebar-toggle-btn {
        transition: all 0.3s ease;
    }

    .sidebar-toggle-btn:hover {
        transform: scale(1.05);
        background: rgba(255, 255, 255, 0.15) !important;
    }

    /* Icon styling */
    .sidebar-nav-item i {
        transition: transform 0.3s ease;
    }

    .sidebar-nav-item:hover i {
        transform: scale(1.1);
    }

    /* Active state */
    .sidebar-nav-item.active {
        background: rgba(255, 255, 255, 0.25) !important;
        border-left: 4px solid #ffffff;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .sidebar-expanded {
            width: 100%;
            position: fixed;
            z-index: 9999;
        }

        .sidebar-collapsed {
            width: 0;
            overflow: hidden;
        }
    }

    /* Scrollbar untuk sidebar */
    .sidebar::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 2px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 2px;
    }

    .sidebar::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.5);
    }

    /* Animation untuk sidebar muncul */
    @keyframes slideInLeft {
        from {
            transform: translateX(-100%);
        }
        to {
            transform: translateX(0);
        }
    }

    .sidebar {
        animation: slideInLeft 0.3s ease-out;
    }
</style>

{{-- Sidebar Component --}}
<div id="sidebar" class="sidebar sidebar-expanded sidebar-gradient-bg text-white shadow-2xl h-screen fixed left-0 top-0 z-50">
    <div class="p-6">
        {{-- Logo Section --}}
        <div class="sidebar-logo-container rounded-2xl p-4 mb-8 text-center backdrop-blur-sm">
            <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full flex items-center justify-center shadow-lg">
                <img src="{{ asset('images/kab50kota.png') }}" alt="Logo" class="w-full h-auto">
            </div>
            <h2 class="text-lg font-bold text-white sidebar-menu-text">Nagari Mungo</h2>
            <p class="text-sm text-blue-100 sidebar-menu-text">Admin Panel</p>
        </div>

        {{-- Toggle Button --}}
        <button id="toggleSidebar" class="sidebar-toggle-btn w-full mb-6 p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-colors">
            <i class="fas fa-bars text-white"></i>
        </button>

        {{-- Navigation --}}
        <nav class="space-y-2">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl @if(request()->routeIs('admin.dashboard')) bg-white/20 text-white @else text-blue-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-home text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Dashboard</span>
            </a>

<!-- Menu Pengelolaan Nagari -->
<a href="javascript:void(0)" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white" id="toggleNagariMenu">
    <i class="fas fa-building text-lg min-w-[20px]"></i>
    <span class="sidebar-menu-text ml-4 font-medium">Pengelolaan Nagari</span>
</a>

<!-- Submenu Profil Nagari -->
<div id="submenuNagari" class="hidden">
    <a href="{{ route('admin.profil.index') }}" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl @if(request()->routeIs('admin.profil-nagari')) bg-white/20 text-white @else text-blue-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
        <i class="fas fa-home text-lg min-w-[20px]"></i>
        <span class="sidebar-menu-text ml-4 font-medium">Profil Nagari</span>
    </a>

    <!-- Submenu Perangkat Nagari -->
    <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl @if(request()->routeIs('admin.perangkat-nagari')) bg-white/20 text-white @else text-blue-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
        <i class="fas fa-users text-lg min-w-[20px]"></i>
        <span class="sidebar-menu-text ml-4 font-medium">Perangkat Nagari</span>
    </a>
</div>



            <a href="{{ route('admin.berita') }}" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl @if(request()->routeIs('admin.berita*')) bg-white/20 text-white @else text-blue-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-newspaper text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Berita</span>
            </a>

            <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                <i class="fas fa-calendar-alt text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Agenda</span>
            </a>

            <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                <i class="fas fa-bullhorn text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Pengumuman</span>
            </a>

            <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                <i class="fas fa-users text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Data Penduduk</span>
            </a>

            <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 rounded-xl text-blue-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                <i class="fas fa-cogs text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Layanan</span>
            </a>

            <div class="my-6 border-t border-white/20"></div>

            {{-- Logout Form --}}
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-nav-item w-full flex items-center py-3 px-4 rounded-xl text-red-200 transition-all duration-300 hover:bg-red-500/20 hover:text-red-100">
                    <i class="fas fa-sign-out-alt text-lg min-w-[20px]"></i>
                    <span class="sidebar-menu-text ml-4 font-medium">Logout</span>
                </button>
            </form>
        </nav>
    </div>
</div>

{{-- JavaScript Sidebar --}}
<script>
    // Toggle sidebar functionality
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.getElementById('toggleSidebar');

    if (toggleBtn && sidebar) {
        toggleBtn.addEventListener('click', () => {
            if (sidebar.classList.contains('sidebar-expanded')) {
                sidebar.classList.remove('sidebar-expanded');
                sidebar.classList.add('sidebar-collapsed');
            } else {
                sidebar.classList.remove('sidebar-collapsed');
                sidebar.classList.add('sidebar-expanded');
            }
        });
    }

    // Handle responsive behavior
    function handleSidebarResize() {
        const sidebar = document.getElementById('sidebar');

        // JavaScript untuk toggle submenu Pengelolaan Nagari
const toggleNagariMenu = document.getElementById('toggleNagariMenu');
const submenuNagari = document.getElementById('submenuNagari');

if (toggleNagariMenu && submenuNagari) {
    toggleNagariMenu.addEventListener('click', () => {
        // Toggle visibility of submenu
        submenuNagari.classList.toggle('hidden');
    });
}


        if (window.innerWidth < 1024) {
            // Mobile: sidebar bisa di-toggle
            if (sidebar) {
                sidebar.style.position = 'fixed';
                sidebar.style.zIndex = '9999';
            }
        } else {
            // Desktop: sidebar selalu terlihat
            if (sidebar) {
                sidebar.style.position = 'fixed';
                sidebar.style.zIndex = '50';
            }
        }
    }

    window.addEventListener('resize', handleSidebarResize);
    window.addEventListener('load', handleSidebarResize);

    // Set active navigation
    document.addEventListener('DOMContentLoaded', function() {
        const navItems = document.querySelectorAll('.sidebar-nav-item');
        const currentPath = window.location.pathname;

        navItems.forEach(item => {
            const href = item.getAttribute('href');

            if (href && href !== '#' && currentPath.includes(href)) {
                item.classList.add('active');
            }
        });
    });
</script>
