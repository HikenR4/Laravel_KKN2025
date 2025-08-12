// ===== EXISTING FUNCTIONALITY (DIPERTAHANKAN) =====

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            // Enhanced smooth scrolling with offset for fixed header
            const headerHeight = document.querySelector('.header').offsetHeight;
            const alertHeight = document.querySelector('.alert-banner')?.offsetHeight || 0;
            const offset = headerHeight + alertHeight + 20;
            
            const targetPosition = target.offsetTop - offset;
            
            window.scrollTo({
                top: targetPosition,
                behavior: 'smooth'
            });
        }
    });
});

// Scroll animations
const observerOptions = {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
};

const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('visible');
        }
    });
}, observerOptions);

document.querySelectorAll('.fade-in').forEach(el => {
    observer.observe(el);
});

// Enhanced Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.98)';
        header.style.boxShadow = '0 2px 30px rgba(220, 20, 60, 0.15)';
        header.style.backdropFilter = 'blur(20px)';
        header.classList.add('scrolled');
    } else {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.boxShadow = '0 2px 20px rgba(220, 20, 60, 0.1)';
        header.style.backdropFilter = 'blur(15px)';
        header.classList.remove('scrolled');
    }

    // Hide/show header on mobile scroll
    if (window.innerWidth <= 768) {
        const lastScrollTop = header.dataset.lastScrollTop || 0;
        if (scrollTop > lastScrollTop && scrollTop > 200) {
            // Scrolling down
            header.style.transform = 'translateY(-100%)';
        } else {
            // Scrolling up
            header.style.transform = 'translateY(0)';
        }
        header.dataset.lastScrollTop = scrollTop;
    }
});

// Enhanced Mobile menu toggle
const mobileToggle = document.querySelector('.mobile-toggle');
const navLinks = document.querySelector('.nav-links');

if (mobileToggle && navLinks) {
    mobileToggle.addEventListener('click', () => {
        const isActive = navLinks.classList.contains('mobile-active');
        
        if (isActive) {
            // Close menu
            navLinks.classList.remove('mobile-active');
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            document.body.style.overflow = '';
        } else {
            // Open menu
            navLinks.classList.add('mobile-active');
            mobileToggle.innerHTML = '<i class="fas fa-times"></i>';
            document.body.style.overflow = 'hidden';
        }
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (!mobileToggle.contains(e.target) && !navLinks.contains(e.target)) {
            navLinks.classList.remove('mobile-active');
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            document.body.style.overflow = '';
        }
    });

    // Close menu when clicking on a link
    navLinks.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', () => {
            navLinks.classList.remove('mobile-active');
            mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
            document.body.style.overflow = '';
        });
    });
}

// Enhanced Video player function
function playVideo() {
    // Create modal or redirect to video
    const modal = createVideoModal();
    document.body.appendChild(modal);
    
    // Animation saat diklik
    const videoPlayer = document.querySelector('.video-player');
    const playButton = document.querySelector('.play-button');
    
    if (playButton) {
        playButton.style.transform = 'scale(0.9)';
        setTimeout(() => {
            playButton.style.transform = 'scale(1.1)';
        }, 150);
    }
}

function createVideoModal() {
    const modal = document.createElement('div');
    modal.className = 'video-modal';
    modal.innerHTML = `
        <div class="video-modal-content">
            <div class="video-modal-header">
                <h3>Profil Nagari</h3>
                <button class="video-modal-close" onclick="closeVideoModal()">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="video-modal-body">
                <div class="video-placeholder">
                    <i class="fas fa-play-circle"></i>
                    <p>Video akan tersedia segera</p>
                    <small>Konten ini dapat berupa embed YouTube, Vimeo, atau video lokal</small>
                </div>
            </div>
        </div>
    `;
    return modal;
}

window.closeVideoModal = function() {
    const modal = document.querySelector('.video-modal');
    if (modal) {
        modal.style.opacity = '0';
        setTimeout(() => {
            modal.remove();
        }, 300);
    }
};

// Enhanced Dynamic counter animation untuk video stats
function animateVideoStats() {
    const counters = document.querySelectorAll('.video-stat-number');
    counters.forEach(counter => {
        const text = counter.innerText;
        if (text.includes('K') || text.includes('.')) {
            // Animate numbers with K suffix
            const target = parseFloat(text) * (text.includes('K') ? 1000 : 1);
            const increment = target / 100;
            let current = 0;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    counter.innerText = text; // Reset to original
                    clearInterval(timer);
                } else {
                    if (text.includes('K')) {
                        counter.innerText = (current / 1000).toFixed(1) + 'K';
                    } else {
                        counter.innerText = Math.floor(current);
                    }
                }
            }, 30);
        }
    });
}

// Trigger animation when video container is visible
const videoContainer = document.querySelector('.video-container');
if (videoContainer) {
    const videoObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                setTimeout(animateVideoStats, 500);
                videoObserver.unobserve(entry.target);
            }
        });
    });
    videoObserver.observe(videoContainer);
}

// ===== NEW ADVANCED FUNCTIONALITY =====

// Tab Switching Functionality
class TabSwitcher {
    constructor() {
        this.init();
    }

    init() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        if (tabButtons.length === 0) return;

        tabButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                e.preventDefault();
                this.switchTab(button, tabButtons, tabContents);
            });
        });
    }

    switchTab(activeButton, allButtons, allContents) {
        const targetTab = activeButton.getAttribute('data-tab');
        
        // Remove active class from all buttons and contents
        allButtons.forEach(btn => {
            btn.classList.remove('active');
            btn.style.transform = 'scale(1)';
        });
        allContents.forEach(content => {
            content.classList.remove('active');
        });

        // Add active class to clicked button and corresponding content
        activeButton.classList.add('active');
        activeButton.style.transform = 'scale(1.05)';
        
        const targetContent = document.getElementById(targetTab + '-tab');
        if (targetContent) {
            targetContent.classList.add('active');
            
            // Animate content entrance
            targetContent.style.opacity = '0';
            targetContent.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                targetContent.style.transition = 'all 0.5s ease';
                targetContent.style.opacity = '1';
                targetContent.style.transform = 'translateY(0)';
            }, 50);
        }

        // Update URL hash without scrolling
        if (history.replaceState) {
            history.replaceState(null, null, '#' + targetTab);
        }
    }
}

// Alert Banner Management
class AlertBanner {
    constructor() {
        this.banner = document.getElementById('important-announcements');
        this.init();
    }

    init() {
        if (!this.banner) return;

        // Auto-hide after 30 seconds
        setTimeout(() => {
            this.hideBanner();
        }, 30000);

        // Adjust page layout
        this.adjustPageLayout();
    }

    hideBanner() {
        if (this.banner) {
            this.banner.style.transform = 'translateY(-100%)';
            setTimeout(() => {
                this.banner.style.display = 'none';
                this.resetPageLayout();
            }, 300);
        }
    }

    adjustPageLayout() {
        const header = document.querySelector('.header');
        const hero = document.querySelector('.hero');
        
        if (header) header.style.top = '60px';
        if (hero) hero.style.paddingTop = '140px';
    }

    resetPageLayout() {
        const header = document.querySelector('.header');
        const hero = document.querySelector('.hero');
        
        if (header) header.style.top = '0';
        if (hero) hero.style.paddingTop = '100px';
    }
}

// Global close alert function
window.closeAlert = function() {
    const alertBanner = new AlertBanner();
    alertBanner.hideBanner();
};

// Data Refresh Manager
class DataRefreshManager {
    constructor() {
        this.refreshInterval = 5 * 60 * 1000; // 5 minutes
        this.init();
    }

    init() {
        // Initial load indicator
        this.showLoadingIndicator();
        
        // Set up auto-refresh
        setInterval(() => {
            this.refreshData();
        }, this.refreshInterval);

        // Refresh on visibility change (when user comes back to tab)
        document.addEventListener('visibilitychange', () => {
            if (!document.hidden) {
                this.refreshData();
            }
        });
    }

    async refreshData() {
        try {
            // Check if we have the API route available
            const apiRoute = document.querySelector('meta[name="api-latest-data"]')?.content || '/api/latest-data';
            const response = await fetch(apiRoute);
            const data = await response.json();
            
            if (data.success) {
                console.log('Data refreshed successfully:', new Date().toLocaleTimeString());
                this.updateDataIndicator();
            }
        } catch (error) {
            console.log('Data refresh not available or failed:', error.message);
        }
    }

    showLoadingIndicator() {
        // Create loading indicator if it doesn't exist
        if (!document.querySelector('.data-status')) {
            const indicator = document.createElement('div');
            indicator.className = 'data-status';
            indicator.innerHTML = '<i class="fas fa-sync-alt"></i> Data terkini';
            document.body.appendChild(indicator);
        }
    }

    updateDataIndicator() {
        const indicator = document.querySelector('.data-status');
        if (indicator) {
            indicator.innerHTML = '<i class="fas fa-check"></i> Data diperbarui';
            indicator.style.background = 'rgba(40, 167, 69, 0.9)';
            
            setTimeout(() => {
                indicator.style.background = 'rgba(220, 20, 60, 0.9)';
                indicator.innerHTML = '<i class="fas fa-sync-alt"></i> Data terkini';
            }, 2000);
        }
    }
}

// Enhanced Scroll Animations
class ScrollAnimations {
    constructor() {
        this.observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };
        this.init();
    }

    init() {
        this.observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    this.animateElement(entry.target);
                }
            });
        }, this.observerOptions);

        // Observe all fade-in elements
        document.querySelectorAll('.fade-in').forEach(el => {
            this.observer.observe(el);
        });

        // Observe cards for staggered animation
        this.observeCards();
    }

    animateElement(element) {
        element.classList.add('visible');
        
        // Add special animations for specific elements
        if (element.classList.contains('news-card') || 
            element.classList.contains('agenda-card') || 
            element.classList.contains('announcement-card')) {
            this.animateCard(element);
        }
    }

    animateCard(card) {
        const delay = Array.from(card.parentNode.children).indexOf(card) * 100;
        
        setTimeout(() => {
            card.style.transform = 'translateY(0) scale(1)';
            card.style.opacity = '1';
        }, delay);
    }

    observeCards() {
        const cardContainers = ['.news-grid', '.agenda-grid', '.announcements-list'];
        
        cardContainers.forEach(selector => {
            const container = document.querySelector(selector);
            if (container) {
                const cards = container.querySelectorAll('.news-card, .agenda-card, .announcement-card');
                cards.forEach((card, index) => {
                    card.style.opacity = '0';
                    card.style.transform = 'translateY(30px) scale(0.95)';
                    card.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
                });
            }
        });
    }
}

// Performance Optimization
class PerformanceOptimizer {
    constructor() {
        this.init();
    }

    init() {
        // Lazy load images
        this.lazyLoadImages();
        
        // Preload critical resources
        this.preloadResources();
    }

    lazyLoadImages() {
        const images = document.querySelectorAll('img[loading="lazy"]');
        
        if ('IntersectionObserver' in window) {
            const imageObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const img = entry.target;
                        img.src = img.src;
                        img.classList.remove('lazy');
                        img.classList.add('loaded');
                        imageObserver.unobserve(img);
                    }
                });
            });

            images.forEach(img => {
                img.classList.add('lazy');
                imageObserver.observe(img);
            });
        }
    }

    preloadResources() {
        // Preload important images
        const importantImages = [
            '/images/default-news.jpg',
            '/images/default-event.jpg',
            '/images/default-logo.png'
        ];

        importantImages.forEach(src => {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.as = 'image';
            link.href = src;
            document.head.appendChild(link);
        });
    }
}

// Advanced UI Interactions
class UIInteractions {
    constructor() {
        this.init();
    }

    init() {
        this.initCardHoverEffects();
        this.initParallaxEffects();
        this.initTouchGestures();
    }

    initCardHoverEffects() {
        const cards = document.querySelectorAll('.news-card, .agenda-card, .feature-card, .announcement-card');
        
        cards.forEach(card => {
            card.addEventListener('mouseenter', (e) => {
                this.onCardHover(e.target, true);
            });
            
            card.addEventListener('mouseleave', (e) => {
                this.onCardHover(e.target, false);
            });
        });
    }

    onCardHover(card, isHovering) {
        const siblings = Array.from(card.parentNode.children).filter(child => child !== card);
        
        if (isHovering) {
            siblings.forEach(sibling => {
                sibling.style.opacity = '0.7';
                sibling.style.transform = 'scale(0.98)';
            });
        } else {
            siblings.forEach(sibling => {
                sibling.style.opacity = '1';
                sibling.style.transform = 'scale(1)';
            });
        }
    }

    initParallaxEffects() {
        const parallaxElements = document.querySelectorAll('.hero::before, .features::before');
        
        window.addEventListener('scroll', () => {
            const scrollTop = window.pageYOffset;
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrollTop * speed}px)`;
            });
        });
    }

    initTouchGestures() {
        // Add touch support for mobile users
        const newsGrid = document.querySelector('.news-grid');
        const agendaGrid = document.querySelector('.agenda-grid');
        
        [newsGrid, agendaGrid].forEach(grid => {
            if (grid) {
                let startX = 0;
                let startY = 0;
                
                grid.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    startY = e.touches[0].clientY;
                });
                
                grid.addEventListener('touchend', (e) => {
                    const endX = e.changedTouches[0].clientX;
                    const endY = e.changedTouches[0].clientY;
                    
                    const diffX = startX - endX;
                    const diffY = startY - endY;
                    
                    // Detect swipe gestures
                    if (Math.abs(diffX) > Math.abs(diffY)) {
                        if (diffX > 50) {
                            // Swipe left - could trigger next page
                            this.triggerSwipeLeft(grid);
                        } else if (diffX < -50) {
                            // Swipe right - could trigger previous page
                            this.triggerSwipeRight(grid);
                        }
                    }
                });
            }
        });
    }

    triggerSwipeLeft(grid) {
        // Add visual feedback for swipe
        grid.style.transform = 'translateX(-10px)';
        setTimeout(() => {
            grid.style.transform = 'translateX(0)';
        }, 200);
    }

    triggerSwipeRight(grid) {
        // Add visual feedback for swipe
        grid.style.transform = 'translateX(10px)';
        setTimeout(() => {
            grid.style.transform = 'translateX(0)';
        }, 200);
    }
}

// Initialize all components when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    // Initialize enhanced components
    new TabSwitcher();
    new AlertBanner();
    new DataRefreshManager();
    new ScrollAnimations();
    new PerformanceOptimizer();
    new UIInteractions();
    
    // Add loading states
    document.body.classList.add('loaded');
    
    console.log('🚀 Landing page components initialized successfully!');

    // Additional event listeners for enhanced functionality
    
    // Enhanced search functionality (if search exists)
    const searchInputs = document.querySelectorAll('input[type="search"], .search-input');
    searchInputs.forEach(input => {
        let searchTimeout;
        input.addEventListener('input', (e) => {
            clearTimeout(searchTimeout);
            searchTimeout = setTimeout(() => {
                console.log('Search query:', e.target.value);
                // Add search functionality here
            }, 300);
        });
    });

    // Keyboard navigation
    document.addEventListener('keydown', (e) => {
        // ESC key to close modals
        if (e.key === 'Escape') {
            const modal = document.querySelector('.video-modal');
            if (modal) {
                closeVideoModal();
            }
            
            // Close mobile menu
            const navLinks = document.querySelector('.nav-links');
            const mobileToggle = document.querySelector('.mobile-toggle');
            if (navLinks?.classList.contains('mobile-active')) {
                navLinks.classList.remove('mobile-active');
                mobileToggle.innerHTML = '<i class="fas fa-bars"></i>';
                document.body.style.overflow = '';
            }
        }
    });

    // Print support
    window.addEventListener('beforeprint', () => {
        document.body.classList.add('printing');
    });

    window.addEventListener('afterprint', () => {
        document.body.classList.remove('printing');
    });

    // Online/offline detection
    window.addEventListener('online', () => {
        const indicator = document.querySelector('.data-status');
        if (indicator) {
            indicator.innerHTML = '<i class="fas fa-wifi"></i> Online';
            indicator.style.background = 'rgba(40, 167, 69, 0.9)';
        }
    });

    window.addEventListener('offline', () => {
        const indicator = document.querySelector('.data-status');
        if (indicator) {
            indicator.innerHTML = '<i class="fas fa-wifi-slash"></i> Offline';
            indicator.style.background = 'rgba(220, 53, 69, 0.9)';
        }
    });

    // Service Worker registration (if available)
    if ('serviceWorker' in navigator) {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('SW registered:', registration);
            })
            .catch(registrationError => {
                console.log('SW registration failed:', registrationError);
            });
    }
});

// Global utility functions
window.utils = {
    // Format numbers with K, M suffixes
    formatNumber: (num) => {
        if (num >= 1000000) {
            return (num / 1000000).toFixed(1) + 'M';
        } else if (num >= 1000) {
            return (num / 1000).toFixed(1) + 'K';
        }
        return num.toString();
    },

    // Format dates in Indonesian
    formatDate: (date) => {
        const months = [
            'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun',
            'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'
        ];
        const d = new Date(date);
        return `${d.getDate()} ${months[d.getMonth()]} ${d.getFullYear()}`;
    },

    // Debounce function
    debounce: (func, wait) => {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    },

    // Throttle function
    throttle: (func, limit) => {
        let inThrottle;
        return function() {
            const args = arguments;
            const context = this;
            if (!inThrottle) {
                func.apply(context, args);
                inThrottle = true;
                setTimeout(() => inThrottle = false, limit);
            }
        }
    }
};

// Error handling
window.addEventListener('error', (e) => {
    console.error('Global error:', e.error);
    // Could send error reports to analytics
});

window.addEventListener('unhandledrejection', (e) => {
    console.error('Unhandled promise rejection:', e.reason);
    // Could send error reports to analytics
});