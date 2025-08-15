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

    /* Sidebar width states dengan rounded corners dan overflow handling */
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

    /* Logo container styling - lebih kompak */
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
        max-width: 50px;
        margin: 0 auto;
        transition: all 0.3s ease;
        border-radius: 50%;
    }

    /* Navigation items dengan rounded borders - lebih kompak */
    .sidebar-nav-item {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
        border-radius: 12px !important;
        margin: 0.15rem 0;
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
        border-radius: 12px !important;
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
        border-radius: 12px !important;
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

    /* Submenu item styling - lebih kompak */
    .submenu-item {
        border-radius: 10px !important;
        margin: 0.1rem 0;
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

    /* Sidebar container dengan scroll */
    .sidebar {
        display: flex;
        flex-direction: column;
        height: 100vh;
        overflow: hidden;
        animation: slideInLeft 0.3s ease-out;
        box-shadow:
            0 0 30px rgba(220, 38, 38, 0.3),
            0 20px 40px rgba(0, 0, 0, 0.1);
    }

    /* Header sidebar (logo + toggle) - fixed */
    .sidebar-header {
        flex-shrink: 0;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    /* Navigation container dengan scroll */
    .sidebar-nav-container {
        flex: 1;
        overflow-y: auto;
        padding: 0.5rem 1.5rem 1rem;
    }

    /* Footer sidebar (logout) - fixed */
    .sidebar-footer {
        flex-shrink: 0;
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(255, 255, 255, 0.1);
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

    /* Custom scrollbar untuk sidebar */
    .sidebar-nav-container::-webkit-scrollbar {
        width: 4px;
    }

    .sidebar-nav-container::-webkit-scrollbar-track {
        background: rgba(255, 255, 255, 0.05);
        border-radius: 2px;
        margin: 0.5rem 0;
    }

    .sidebar-nav-container::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 2px;
    }

    .sidebar-nav-container::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    /* Firefox scrollbar */
    .sidebar-nav-container {
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) rgba(255, 255, 255, 0.05);
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

    /* Menu parent active saat submenu terbuka */
    .sidebar-nav-item.submenu-active {
        background: rgba(255, 255, 255, 0.15) !important;
        color: white !important;
    }

    /* Compact spacing */
    .sidebar-header .sidebar-logo-container {
        margin-bottom: 0.5rem;
        padding: 0.75rem;
    }

    .sidebar-header .sidebar-logo-container h2 {
        font-size: 1rem;
        margin-bottom: 0.25rem;
    }

    .sidebar-header .sidebar-logo-container p {
        font-size: 0.75rem;
    }

    /* Divider styling */
    .sidebar-divider {
        border-top: 1px solid rgba(255, 255, 255, 0.15);
        margin: 0.75rem 0;
    }
</style>

{{-- Sidebar Component --}}
<div id="sidebar" class="sidebar sidebar-expanded sidebar-gradient-bg text-white shadow-2xl fixed left-0 top-0 z-50">

    {{-- Header Sidebar (Logo + Toggle) --}}
    <div class="sidebar-header">
        {{-- Logo Section - Lebih Kompak --}}
        <div class="sidebar-logo-container backdrop-blur-sm bg-white/10 text-center">
            <div class="w-12 h-12 mx-auto mb-2 bg-white rounded-full flex items-center justify-center shadow-lg">
                <img src="{{ asset('images/kab50kota.png') }}" alt="Logo" class="w-full h-auto">
            </div>
            <h2 class="text-base font-bold text-white sidebar-menu-text">Nagari Mungo</h2>
            <p class="text-xs text-red-100 sidebar-menu-text">Admin</p>
        </div>

        {{-- Toggle Button --}}
        <button id="toggleSidebar" class="sidebar-toggle-btn w-full mt-3 p-2 bg-white/10 hover:bg-white/20 transition-colors">
            <i class="fas fa-bars text-white"></i>
        </button>
    </div>

    {{-- Navigation Container dengan Scroll --}}
    <div class="sidebar-nav-container">
        <nav class="space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.dashboard')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-home text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Dashboard</span>
            </a>

            <!-- Menu Pengelolaan Nagari -->
            <div>
                <a href="javascript:void(0)" class="sidebar-nav-item flex items-center py-2.5 px-3 text-red-100 transition-all duration-300 hover:bg-white/10 hover:text-white @if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) submenu-active @endif" id="toggleNagariMenu">
                    <i class="fas fa-building text-base min-w-[18px]"></i>
                    <span class="sidebar-menu-text ml-3 font-medium text-sm flex-1">Pengelolaan Nagari</span>
                    <i class="fas fa-chevron-right submenu-arrow sidebar-menu-text text-xs @if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) rotated @endif"></i>
                </a>

                <!-- Submenu -->
                <div id="submenuNagari" class="@if(request()->routeIs('admin.profil*') || request()->routeIs('admin.perangkat-nagari*')) show @endif">
                    <a href="{{ route('admin.profil.index') }}" class="submenu-item sidebar-nav-item flex items-center py-2 px-3 @if(request()->routeIs('admin.profil*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300 ml-3">
                        <i class="fas fa-id-card text-sm min-w-[14px]"></i>
                        <span class="sidebar-menu-text ml-2 font-medium text-xs">Profil Nagari</span>
                    </a>

                    <a href="{{ route('admin.perangkat') }}" class="submenu-item sidebar-nav-item flex items-center py-2 px-3 @if(request()->routeIs('admin.perangkat*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300 ml-3">
                        <i class="fas fa-users text-sm min-w-[14px]"></i>
                        <span class="sidebar-menu-text ml-2 font-medium text-xs">Perangkat Nagari</span>
                    </a>
                </div>
            </div>

            <a href="{{ route('admin.berita') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.berita*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-newspaper text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Berita</span>
            </a>

            <a href="{{ route('admin.agenda') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.agenda*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-calendar text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Agenda</span>
            </a>

            <a href="{{ route('admin.pengumuman') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.pengumuman*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-bullhorn text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Pengumuman</span>
            </a>

            <a href="{{ route('admin.datapenduduk') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.datapenduduk*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-users text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Data Penduduk</span>
            </a>

            <a href="{{ route('admin.komentar') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.komentar*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-comments text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Komentar</span>
            </a>

            <a href="{{ route('admin.layanan') }}" class="sidebar-nav-item flex items-center py-2.5 px-3 @if(request()->routeIs('admin.layanan*')) active @else text-red-100 hover:bg-white/10 hover:text-white @endif transition-all duration-300">
                <i class="fas fa-cogs text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Layanan</span>
            </a>

            <!-- Divider -->
            <div class="sidebar-divider"></div>
        </nav>
    </div>

    {{-- Footer Sidebar (Logout) --}}
    <div class="sidebar-footer">
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit" class="sidebar-nav-item w-full flex items-center py-2.5 px-3 text-red-200 transition-all duration-300 hover:bg-red-500/20 hover:text-red-100">
                <i class="fas fa-sign-out-alt text-base min-w-[18px]"></i>
                <span class="sidebar-menu-text ml-3 font-medium text-sm">Logout</span>
            </button>
        </form>
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
    const submenuArrow = toggleNagariMenu?.querySelector('.submenu-arrow');

    if (toggleNagariMenu && submenuNagari) {
        toggleNagariMenu.addEventListener('click', () => {
            // Toggle visibility of submenu
            if (submenuNagari.classList.contains('show')) {
                submenuNagari.classList.remove('show');
                submenuArrow?.classList.remove('rotated');
                toggleNagariMenu.classList.remove('submenu-active');
            } else {
                submenuNagari.classList.add('show');
                submenuArrow?.classList.add('rotated');
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
            if (submenuNagari && submenuArrow && toggleNagariMenu) {
                submenuNagari.classList.add('show');
                submenuArrow.classList.add('rotated');
                toggleNagariMenu.classList.add('submenu-active');
            }
        }
    });
</script>
