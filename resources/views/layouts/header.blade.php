{{-- resources/views/layouts/header.blade.php --}}

<header class="header">
    <nav class="nav-container">
        <a href="{{ url('/') }}" class="logo">
            <div class="logo-icon">
                <i class="fas fa-mountain"></i>
            </div>
            <span>Nagari Mungo</span>
        </a>
        
        <!-- Navigation Menu di Tengah -->
        <div class="nav-links">
            <a href="{{ url('/') }}" class="{{ request()->is('/') || request()->is('landing') ? 'active' : '' }}">
                Beranda
            </a>
            <a href="{{ route('berita') }}" class="{{ request()->routeIs('berita*') ? 'active' : '' }}">
                Berita
            </a>
            <a href="{{ route('agenda') }}" class="{{ request()->routeIs('agenda*') ? 'active' : '' }}">
                Agenda
            </a>
            <a href="#pengumuman" class="{{ request()->routeIs('pengumuman*') ? 'active' : '' }}">
                Pengumuman
            </a>
            <a href="#layanan" class="{{ request()->routeIs('layanan*') ? 'active' : '' }}">
                Layanan
            </a>
            <a href="#tentang" class="{{ request()->routeIs('tentang*') ? 'active' : '' }}">
                Tentang
            </a>
        </div>
        
        <a href="#login" class="cta-nav">
            <i class="fas fa-sign-in-alt"></i>
            Login
        </a>

        <!-- Mobile Toggle -->
        <button class="mobile-toggle" onclick="toggleMobileMenu()" aria-label="Toggle Mobile Menu">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Mobile Menu -->
        <div class="mobile-menu" id="mobileMenu">
            <a href="{{ url('/') }}" class="{{ request()->is('/') || request()->is('landing') ? 'active' : '' }}">
                <i class="fas fa-home"></i> Beranda
            </a>
            <a href="{{ route('berita') }}" class="{{ request()->routeIs('berita*') ? 'active' : '' }}">
                <i class="fas fa-newspaper"></i> Berita
            </a>
            <a href="{{ route('agenda') }}" class="{{ request()->routeIs('agenda*') ? 'active' : '' }}">
                <i class="fas fa-calendar"></i> Agenda
            </a>
            <a href="#pengumuman" class="{{ request()->routeIs('pengumuman*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn"></i> Pengumuman
            </a>
            <a href="#layanan" class="{{ request()->routeIs('layanan*') ? 'active' : '' }}">
                <i class="fas fa-concierge-bell"></i> Layanan
            </a>
            <a href="#tentang" class="{{ request()->routeIs('tentang*') ? 'active' : '' }}">
                <i class="fas fa-info-circle"></i> Tentang
            </a>
        </div>
    </nav>
</header>

<!-- Header JavaScript - Enhanced -->
<script>
    // Mobile menu toggle with improved functionality
    function toggleMobileMenu() {
        const mobileMenu = document.getElementById('mobileMenu');
        const toggleIcon = document.querySelector('.mobile-toggle i');
        const body = document.body;
        
        if (mobileMenu.style.display === 'flex') {
            // Close menu
            mobileMenu.style.display = 'none';
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
            body.style.overflow = ''; // Re-enable scroll
        } else {
            // Open menu
            mobileMenu.style.display = 'flex';
            toggleIcon.classList.remove('fa-bars');
            toggleIcon.classList.add('fa-times');
            body.style.overflow = 'hidden'; // Disable scroll when menu open
        }
    }

    // Close mobile menu when clicking a link
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.mobile-menu a').forEach(link => {
            link.addEventListener('click', () => {
                const mobileMenu = document.getElementById('mobileMenu');
                const toggleIcon = document.querySelector('.mobile-toggle i');
                const body = document.body;
                
                mobileMenu.style.display = 'none';
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
                body.style.overflow = ''; // Re-enable scroll
            });
        });
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(event) {
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileToggle = document.querySelector('.mobile-toggle');
        const header = document.querySelector('.header');
        
        if (mobileMenu.style.display === 'flex' && 
            !header.contains(event.target) && 
            !mobileToggle.contains(event.target)) {
            
            const toggleIcon = document.querySelector('.mobile-toggle i');
            const body = document.body;
            
            mobileMenu.style.display = 'none';
            toggleIcon.classList.remove('fa-times');
            toggleIcon.classList.add('fa-bars');
            body.style.overflow = '';
        }
    });

    // Header scroll effect with throttling
    let scrollTimeout;
    window.addEventListener('scroll', () => {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(() => {
                const header = document.querySelector('.header');
                if (window.scrollY > 100) {
                    header.classList.add('scrolled');
                } else {
                    header.classList.remove('scrolled');
                }
                scrollTimeout = null;
            }, 10);
        }
    });

    // Smooth scroll untuk navigasi
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                
                // Skip if it's just "#" or empty
                if (href === '#' || !href) {
                    e.preventDefault();
                    return;
                }
                
                const target = document.querySelector(href);
                if (target) {
                    e.preventDefault();
                    
                    // Close mobile menu if open
                    const mobileMenu = document.getElementById('mobileMenu');
                    if (mobileMenu.style.display === 'flex') {
                        toggleMobileMenu();
                    }
                    
                    // Smooth scroll to target
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    });

    // Handle resize - close mobile menu if window becomes wide
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            const mobileMenu = document.getElementById('mobileMenu');
            const toggleIcon = document.querySelector('.mobile-toggle i');
            const body = document.body;
            
            if (mobileMenu.style.display === 'flex') {
                mobileMenu.style.display = 'none';
                toggleIcon.classList.remove('fa-times');
                toggleIcon.classList.add('fa-bars');
                body.style.overflow = '';
            }
        }
    });

    // Add loading state to navigation links
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.nav-links a, .mobile-menu a').forEach(link => {
            // Skip anchor links
            if (link.getAttribute('href').startsWith('#')) return;
            
            link.addEventListener('click', function(e) {
                // Add loading state
                const originalText = this.innerHTML;
                const isIcon = this.querySelector('i');
                
                if (!isIcon) {
                    this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> ' + this.textContent;
                } else {
                    const icon = this.querySelector('i');
                    icon.className = 'fas fa-spinner fa-spin';
                }
                
                // Reset after 3 seconds (fallback)
                setTimeout(() => {
                    this.innerHTML = originalText;
                }, 3000);
            });
        });
    });
</script>

<!-- Enhanced Mobile Menu CSS (if not in main CSS) -->
<style>
    /* Enhanced mobile menu styles */
    .mobile-menu.show {
        display: flex !important;
        animation: slideInFromTop 0.3s ease-out;
    }
    
    @keyframes slideInFromTop {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    /* Mobile menu icons */
    .mobile-menu a i {
        margin-right: 0.5rem;
        width: 16px;
        text-align: center;
    }
    
    /* Active state for mobile menu */
    .mobile-menu a.active {
        background: rgba(220, 20, 60, 0.1);
        color: #DC143C;
        font-weight: 600;
        border-left: 4px solid #DC143C;
    }
    
    /* Loading spinner for navigation */
    .nav-links a i.fa-spinner,
    .mobile-menu a i.fa-spinner {
        animation: spin 1s linear infinite;
    }
    
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    /* Improved mobile toggle button */
    .mobile-toggle {
        position: relative;
        overflow: hidden;
    }
    
    .mobile-toggle::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        width: 0;
        height: 0;
        background: rgba(220, 20, 60, 0.2);
        border-radius: 50%;
        transform: translate(-50%, -50%);
        transition: width 0.3s ease, height 0.3s ease;
    }
    
    .mobile-toggle:active::after {
        width: 40px;
        height: 40px;
    }
    
    /* Better scroll indicator */
    .header.scrolled {
        transform: translateY(0);
        animation: slideDown 0.3s ease;
    }
    
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
        }
        to {
            transform: translateY(0);
        }
    }
</style>