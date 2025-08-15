<!-- Header dengan Navigation -->
<header class="header">
    <nav class="nav-container">
        <!-- Logo di Kiri -->
        <a href="{{ url('/') }}" class="logo">
            <div class="logo-icon">
                <i class="fas fa-mountain"></i>
            </div>
            <span>Nagari Mungo</span>
        </a>

        <!-- Navigation Menu di Tengah -->
        <div class="nav-links">
            <a href="{{ url('/') }}" class="{{ request()->routeIs('home') || request()->is('/') ? 'active' : '' }}">Beranda</a>

            <!-- Menu Profil dengan Dropdown -->
            <div class="dropdown">
                <a href="#" class="{{ request()->routeIs('profil*') ? 'active' : '' }} dropdown-toggle">
                    Profil <i class="fas fa-chevron-down"></i>
                </a>
                <div class="dropdown-menu">
                    <a href="{{ route('profil.sejarah') }}">Sejarah</a>
                    <a href="{{ route('profil.visi-misi') }}">Visi Misi</a>
                    <a href="{{ route('profil.perangkat-nagari') }}">Perangkat Nagari</a>
                    <a href="{{ route('profil.data-wilayah') }}">Data Wilayah</a>
                </div>
            </div>

            <a href="{{ route('berita') }}" class="{{ request()->routeIs('berita*') ? 'active' : '' }}">Berita</a>
            <a href="{{ route('agenda') }}" class="{{ request()->routeIs('agenda*') ? 'active' : '' }}">Agenda</a>
            <a href="{{ route('pengumuman') }}" class="{{ request()->routeIs('pengumuman*') ? 'active' : '' }}">Pengumuman</a>
            <a href="{{ route('layanan') }}" class="{{ request()->routeIs('layanan*') ? 'active' : '' }}">Layanan</a>
            <a href="#tentang" class="{{ request()->routeIs('tentang*') ? 'active' : '' }}">Tentang</a>
        </div>

        <!-- Login Button di Kanan -->
        <a href="{{ route('admin.login') }}" class="cta-nav">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </a>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" onclick="toggleMobileMenu()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ url('/') }}">Beranda</a>

            <!-- Mobile Profil Menu -->
            <div class="mobile-dropdown">
                <a href="#" class="mobile-dropdown-toggle" onclick="toggleMobileDropdown(event)">
                    Profil <i class="fas fa-chevron-down"></i>
                </a>
                <div class="mobile-dropdown-menu">
                    <a href="{{ route('sejarah') }}">Sejarah</a>
                    <a href="{{ route('visi-misi') }}">Visi Misi</a>
                    <a href="{{ route('perangkat-nagari') }}">Perangkat Nagari</a>
                    <a href="{{ route('data-wilayah') }}">Data Wilayah</a>
                </div>
            </div>

            <a href="{{ route('berita') }}">Berita</a>
            <a href="{{ route('agenda') }}">Agenda</a>
            <a href="{{ route('pengumuman') }}">Pengumuman</a>
            <a href="{{ route('layanan') }}">Layanan</a>
            <a href="#tentang">Tentang</a>
        </div>
    </nav>
</header>

<!-- CSS untuk Header -->
<style>
    /* Header - WHITE & RED GRADIENT THEME */
    .header {
        position: fixed;
        top: 0;
        width: 100%;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        padding: 1rem 0;
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 30px rgba(220, 20, 60, 0.1);
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
    }

    .header.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 8px 40px rgba(220, 20, 60, 0.15);
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: grid;
        grid-template-columns: 1fr 2fr 1fr;
        align-items: center;
        padding: 0 2rem;
        gap: 2rem;
    }

    /* Logo - Enhanced with red gradient */
    .logo {
        display: flex;
        align-items: center;
        gap: 1rem;
        font-weight: 700;
        color: #DC143C;
        font-size: 1.3rem;
        justify-self: start;
        z-index: 3;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        text-decoration: none;
    }

    .logo:hover {
        transform: translateX(5px);
        color: #DC143C;
    }

    .logo-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        position: relative;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo-icon::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
        transform: rotate(45deg);
        transition: all 0.6s ease;
        opacity: 0;
    }

    .logo:hover .logo-icon::before {
        animation: shine 0.6s ease-in-out;
    }

    @keyframes shine {
        0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
        50% { opacity: 1; }
        100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
    }

    /* Navigation Links */
    .nav-links {
        display: flex;
        gap: 2rem;
        justify-content: center;
        align-items: center;
        z-index: 2;
    }

    .nav-links a {
        color: #555;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        white-space: nowrap;
        padding: 0.5rem 0;
    }

    .nav-links a::before {
        content: '';
        position: absolute;
        bottom: 0;
        left: 50%;
        width: 0;
        height: 2px;
        background: linear-gradient(90deg, #FF6B6B, #DC143C);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(-50%);
    }

    .nav-links a:hover,
    .nav-links a.active {
        color: #DC143C;
        transform: translateY(-2px);
    }

    .nav-links a:hover::before,
    .nav-links a.active::before {
        width: 100%;
    }

    /* Dropdown Styles */
    .dropdown {
        position: relative;
    }

    .dropdown-toggle {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        cursor: pointer;
    }

    .dropdown-toggle i {
        font-size: 0.8rem;
        transition: transform 0.3s ease;
    }

    .dropdown:hover .dropdown-toggle i {
        transform: rotate(180deg);
    }

    .dropdown-menu {
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        border-radius: 12px;
        padding: 1rem 0;
        min-width: 200px;
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.15);
        border: 1px solid rgba(220, 20, 60, 0.1);
        opacity: 0;
        visibility: hidden;
        transform: translateX(-50%) translateY(-10px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1001;
    }

    .dropdown:hover .dropdown-menu {
        opacity: 1;
        visibility: visible;
        transform: translateX(-50%) translateY(0);
    }

    .dropdown-menu a {
        display: block;
        padding: 0.8rem 1.5rem;
        color: #555;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border-bottom: none;
        position: relative;
        overflow: hidden;
    }

    .dropdown-menu a::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 0;
        height: 100%;
        background: linear-gradient(90deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.1));
        transition: width 0.3s ease;
    }

    .dropdown-menu a:hover {
        color: #DC143C;
        background: rgba(220, 20, 60, 0.05);
        transform: translateX(5px);
    }

    .dropdown-menu a:hover::before {
        width: 100%;
    }

    /* Mobile Dropdown */
    .mobile-dropdown {
        position: relative;
    }

    .mobile-dropdown-toggle {
        display: flex;
        align-items: center;
        justify-content: space-between;
        cursor: pointer;
    }

    .mobile-dropdown-toggle i {
        transition: transform 0.3s ease;
    }

    .mobile-dropdown-toggle.active i {
        transform: rotate(180deg);
    }

    .mobile-dropdown-menu {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease;
        background: rgba(220, 20, 60, 0.05);
        margin: 0.5rem 0;
        border-radius: 8px;
    }

    .mobile-dropdown-menu.active {
        max-height: 300px;
    }

    .mobile-dropdown-menu a {
        padding: 0.8rem 3rem;
        font-size: 0.9rem;
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
    }

    .mobile-dropdown-menu a:last-child {
        border-bottom: none;
    }

    /* CTA Button */
    .cta-nav {
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
        justify-self: end;
        z-index: 3;
        position: relative;
        overflow: hidden;
    }

    .cta-nav::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: all 0.6s ease;
    }

    .cta-nav:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
        color: white;
    }

    .cta-nav:hover::before {
        left: 100%;
    }

    /* Mobile Toggle */
    .mobile-toggle {
        display: none;
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #DC143C;
        cursor: pointer;
        z-index: 3;
        justify-self: center;
        transition: all 0.3s ease;
    }

    .mobile-toggle:hover {
        color: #FF6B6B;
        transform: scale(1.1);
    }

    /* Mobile Menu */
    .mobile-menu {
        display: none;
        position: fixed;
        top: 80px;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.98);
        backdrop-filter: blur(15px);
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.15);
        border-radius: 0 0 20px 20px;
        padding: 2rem 1rem;
        z-index: 999;
    }

    .mobile-menu a {
        display: block;
        padding: 1rem 2rem;
        color: #555;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
        text-align: center;
    }

    .mobile-menu a:hover {
        background: rgba(220, 20, 60, 0.05);
        color: #DC143C;
        transform: translateX(5px);
    }

    .mobile-menu a:last-child {
        border-bottom: none;
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .nav-links {
            gap: 1.5rem;
        }

        .nav-links a {
            font-size: 0.9rem;
        }
    }

    @media (max-width: 900px) {
        .nav-links {
            gap: 1rem;
        }

        .nav-links a {
            font-size: 0.85rem;
        }

        .cta-nav {
            padding: 0.7rem 1.2rem;
            font-size: 0.9rem;
        }
    }

    @media (max-width: 768px) {
        .nav-container {
            display: grid;
            grid-template-columns: auto 1fr auto;
            padding: 0 1rem;
            gap: 1rem;
        }

        .logo {
            justify-self: start;
            font-size: 1.1rem;
        }

        .logo-icon {
            width: 35px;
            height: 35px;
        }

        .mobile-toggle {
            display: block;
            justify-self: center;
        }

        .cta-nav {
            justify-self: end;
            padding: 0.6rem 1rem;
            font-size: 0.85rem;
        }

        .nav-links {
            display: none;
        }

        .nav-links.mobile-active {
            display: flex;
            flex-direction: column;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    }

    @media (max-width: 480px) {
        .nav-container {
            padding: 0 0.5rem;
        }

        .logo {
            font-size: 1rem;
            gap: 0.5rem;
        }

        .logo span {
            font-size: 0.9rem;
        }

        .logo-icon {
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }

        .cta-nav {
            padding: 0.5rem 0.8rem;
            font-size: 0.8rem;
        }
    }

    @media (max-width: 360px) {
        .logo span {
            display: none;
        }

        .cta-nav {
            padding: 0.4rem 0.6rem;
            font-size: 0.75rem;
        }
    }
</style>

<!-- JavaScript untuk Header -->
<script>
    // Mobile menu toggle
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const toggleIcon = document.querySelector('.mobile-toggle i');

        if (mobileMenu.style.display === 'flex') {
            mobileMenu.style.display = 'none';
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
        } else {
            mobileMenu.style.display = 'flex';
            toggleIcon.classList.remove('fa-bars');
            toggleIcon.classList.add('fa-times');
        }
    }

    // Mobile dropdown toggle
    function toggleMobileDropdown(event) {
        event.preventDefault();
        const dropdownToggle = event.currentTarget;
        const dropdownMenu = dropdownToggle.nextElementSibling;
        const icon = dropdownToggle.querySelector('i');

        // Toggle active class
        dropdownToggle.classList.toggle('active');
        dropdownMenu.classList.toggle('active');
    }

    // Close mobile menu when clicking a link
    document.querySelectorAll('.mobile-menu a:not(.mobile-dropdown-toggle)').forEach(link => {
        link.addEventListener('click', () => {
            document.getElementById('mobileMenu').style.display = 'none';
            document.querySelector('.mobile-toggle i').classList.remove('fa-times');
            document.querySelector('.mobile-toggle i').classList.add('fa-bars');
        });
    });

    // Header scroll effect
    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header');
        if (window.scrollY > 100) {
            header.classList.add('scrolled');
        } else {
            header.classList.remove('scrolled');
        }
    });

    // Smooth scroll untuk navigasi
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const dropdowns = document.querySelectorAll('.dropdown');
        dropdowns.forEach(dropdown => {
            if (!dropdown.contains(event.target)) {
                // Dropdown will close automatically with CSS :hover
            }
        });
    });
</script>
