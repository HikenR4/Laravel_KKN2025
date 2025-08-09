<style>
    /* Efek transisi submenu */
    #submenuNagari {
        transition: all 0.3s ease;
        overflow: hidden;
        max-height: 0;
        opacity: 0;
        padding-left: 1.5rem;
    }

    /* Menampilkan submenu */
    #submenuNagari.show {
        max-height: 200px;
        opacity: 1;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
    }

    /* Gradient background khusus sidebar - Formal Red Theme */
    .sidebar-gradient-bg {
        background: linear-gradient(135deg, #dc2626 0%, #991b1b 50%, #7f1d1d 100%);
    }

    /* Sidebar width states dengan rounded corners */
    .sidebar-collapsed {
        width: 80px;
        transition: width 0.3s ease;
        border-radius: 0 25px 25px 0;
    }

    .sidebar-expanded {
        width: 280px;
        transition: width 0.3s ease;
        border-radius: 0 25px 25px 0;
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

    /* Logo container styling dengan rounded */
    .sidebar-logo-container {
        transition: all 0.3s ease;
        border-radius: 20px !important;
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
        border-radius: 50%;
    }

    /* Navigation items dengan rounded borders */
    .sidebar-nav-item {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 15px !important;
        margin: 0.25rem 0;
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

    /* Toggle button dengan rounded */
    .sidebar-toggle-btn {
        transition: all 0.3s ease;
        border-radius: 15px !important;
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

    /* Active state dengan rounded */
    .sidebar-nav-item.active {
        background: rgba(255, 255, 255, 0.25) !important;
        border-left: 4px solid #ffffff;
        border-radius: 15px !important;
        color: white !important;
    }

    /* Arrow untuk submenu */
    .submenu-arrow {
        transition: transform 0.3s ease;
        margin-left: auto;
    }

    .submenu-arrow.rotated {
        transform: rotate(90deg);
    }

    /* Submenu item styling */
    .submenu-item {
        border-radius: 12px !important;
        margin: 0.125rem 0;
        background: rgba(255, 255, 255, 0.05);
        border-left: 2px solid rgba(255, 255, 255, 0.2);
    }

    .submenu-item:hover {
        background: rgba(255, 255, 255, 0.1) !important;
        border-left-color: rgba(255, 255, 255, 0.5);
    }

    .submenu-item.active {
        background: rgba(255, 255, 255, 0.2) !important;
        border-left: 3px solid #ffffff !important;
        color: white !important;
    }

    /* Responsive design */
    @media (max-width: 768px) {
        .sidebar-expanded {
            width: 100%;
            position: fixed;
            z-index: 9999;
            border-radius: 0;
        }

        .sidebar-collapsed {
            width: 0;
            overflow: hidden;
            border-radius: 0;
        }
    }

    /* Scrollbar untuk sidebar dengan rounded */
    .sidebar::-webkit-scrollbar {
        width: 6px;
    }

    .sidebar::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.1);
        border-radius: 3px;
    }

    .sidebar::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.3);
        border-radius: 3px;
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
        box-shadow:
            0 0 30px rgba(220, 38, 38, 0.3),
            0 20px 40px rgba(0, 0, 0, 0.1);
    }

    /* Menu parent active saat submenu terbuka */
    .sidebar-nav-item.submenu-active {
        background: rgba(255, 255, 255, 0.15) !important;
        color: white !important;
    }
</style>

{{-- Sidebar Component --}}
<div id="sidebar" class="sidebar sidebar-expanded sidebar-gradient-bg text-white shadow-2xl h-screen fixed left-0 top-0 z-50">
    <div class="p-6">
        {{-- Logo Section --}}
        <div class="sidebar-logo-container p-4 mb-8 text-center backdrop-blur-sm bg-white/10">
            <div class="w-16 h-16 mx-auto mb-3 bg-white rounded-full flex items-center justify-center shadow-lg">
                <img src="{{ asset('images/kab50kota.png') }}" alt="Logo" class="w-full h-auto">
            </div>
            <h2 class="text-lg font-bold text-white sidebar-menu-text">Nagari Mungo</h2>
            <p class="text-sm text-red-100 sidebar-menu-text">Admin</p>
        </div>

        {{-- Toggle Button --}}
        <button id="toggleSidebar" class="sidebar-toggle-btn w-full mb-6 p-2 bg-white/10 hover:bg-white/20 transition-colors">
            <i class="fas fa-bars text-white"></i>
        </button>

        {{-- Navigation --}}
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item flex items-center py-3 px-4 @if(request()->routeIs('admin.dashboard')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-home text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Dashboard</span>
            </a>

            <!-- Menu Pengelolaan Nagari -->
            <div>
                <a href="javascript:void(0)" class="sidebar-nav-item flex items-center py-3 px-4 text-red-100 transition-all duration-300 hover:bg-white/10 hover:text-white @if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) submenu-active @endif" id="toggleNagariMenu">
                    <i class="fas fa-building text-lg min-w-[20px]"></i>
                    <span class="sidebar-menu-text ml-4 font-medium flex-1">Pengelolaan Nagari</span>
                    <i class="fas fa-chevron-right submenu-arrow sidebar-menu-text text-xs @if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) rotated @endif"></i>
                </a>

                <!-- Submenu Profil Nagari -->
                <div id="submenuNagari" class="@if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) show @endif">
                    <a href="{{ route('admin.profil.index') }}" class="submenu-item sidebar-nav-item flex items-center py-2 px-4 @if(request()->routeIs('admin.profil*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300 ml-4">
                        <i class="fas fa-id-card text-sm min-w-[16px]"></i>
                        <span class="sidebar-menu-text ml-3 font-medium text-sm">Profil Nagari</span>
                    </a>

                <!-- Submenu Perangkat Nagari -->
                <a href="{{ route('admin.perangkat') }}" class="submenu-item sidebar-nav-item flex items-center py-2 px-4 @if(request()->routeIs('admin.perangkat*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300 ml-4">
                    <i class="fas fa-users text-sm min-w-[16px]"></i>
                    <span class="sidebar-menu-text ml-3 font-medium text-sm">Perangkat Nagari</span>
                </a>
                </div>
            </div>

            <a href="{{ route('admin.berita') }}" class="sidebar-nav-item flex items-center py-3 px-4 @if(request()->routeIs('admin.berita*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-newspaper text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Berita</span>
            </a>

            <a href="{{ route('admin.agenda') }}" class="sidebar-nav-item flex items-center py-3 px-4 @if(request()->routeIs('admin.agenda*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-calendar text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Agenda</span>
            </a>

            <a href="{{ route('admin.pengumuman') }}" class="sidebar-nav-item flex items-center py-3 px-4 @if(request()->routeIs('admin.pengumuman*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-bullhorn text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Pengumuman</span>
            </a>

            <a href="#" class="sidebar-nav-item flex items-center py-3 px-4 text-red-100 transition-all duration-300 hover:bg-white/10 hover:text-white">
                <i class="fas fa-users text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Data Penduduk</span>
            </a>

            <a href="{{ route('admin.layanan') }}" class="sidebar-nav-item flex items-center py-3 px-4 @if(request()->routeIs('admin.layanan*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-cogs text-lg min-w-[20px]"></i>
                <span class="sidebar-menu-text ml-4 font-medium">Layanan</span>
            </a>

            <div class="my-6 border-t border-white/20"></div>

            {{-- Logout Form --}}
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-nav-item w-full flex items-center py-3 px-4 text-red-200 transition-all duration-300 hover:bg-red-500/20 hover:text-red-100">
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

    // JavaScript untuk toggle submenu Pengelolaan Nagari
    const toggleNagariMenu = document.getElementById('toggleNagariMenu');
    const submenuNagari = document.getElementById('submenuNagari');
    const submenuArrow = toggleNagariMenu.querySelector('.submenu-arrow');

    if (toggleNagariMenu && submenuNagari) {
        toggleNagariMenu.addEventListener('click', () => {
            // Toggle visibility of submenu
            if (submenuNagari.classList.contains('show')) {
                submenuNagari.classList.remove('show');
                submenuArrow.classList.remove('rotated');
                toggleNagariMenu.classList.remove('submenu-active');
            } else {
                submenuNagari.classList.add('show');
                submenuArrow.classList.add('rotated');
                toggleNagariMenu.classList.add('submenu-active');
            }
        });
    }

    // Handle responsive behavior
    function handleSidebarResize() {
        const sidebar = document.getElementById('sidebar');

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

        // Auto-open submenu if current route is in submenu
        if (window.location.pathname.includes('/admin/profil') || window.location.pathname.includes('/admin/perangkat-nagari')) {
            if (submenuNagari && submenuArrow) {
                submenuNagari.classList.add('show');
                submenuArrow.classList.add('rotated');
                toggleNagariMenu.classList.add('submenu-active');
            }
        }
    });
</script>
