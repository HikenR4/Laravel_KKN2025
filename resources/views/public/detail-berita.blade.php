{{-- resources/views/public/detail-berita.blade.php --}}

@extends('layouts.app')

@section('title', $berita->judul . ' - Nagari Mungo')
@section('meta_description', $berita->meta_description ?? $berita->excerpt)

@push('styles')
<style>
    /* Hero Section */
    .hero-detail {
        background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
        padding: 10rem 0 4rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-detail::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.05"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.03"/><polygon points="600,50 650,100 600,150 550,100" fill="white" opacity="0.04"/></svg>');
        animation: gentleFloat 20s infinite linear;
    }

    .hero-detail-content {
        max-width: 1000px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        padding: 0 2rem;
    }

    /* ===== BREADCRUMB - PERFECT ALIGNMENT ===== */
    .breadcrumb-nav {
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border-radius: 15px;
        padding: 1rem 2rem;
        margin-bottom: 2rem;
        border: 1px solid rgba(255, 255, 255, 0.2);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        text-align: left; /* LEFT-ALIGNED */
    }

    .breadcrumb {
        margin: 0;
        background: none;
        padding: 0;
        display: flex;
        flex-wrap: wrap;
        list-style: none;
        align-items: center; /* PERFECT VERTICAL ALIGNMENT */
        line-height: 1;
        min-height: 24px;
    }

    .breadcrumb-item {
        display: flex;
        align-items: center;
        line-height: 1;
        height: 24px; /* FIXED HEIGHT - NO MORE JUMPING */
    }

    .breadcrumb-item + .breadcrumb-item::before {
        content: "›";
        color: rgba(255, 255, 255, 0.7);
        font-size: 1.2rem;
        padding: 0 0.8rem;
        display: flex;
        align-items: center;
        justify-content: center;
        height: 24px; /* SAME HEIGHT */
        line-height: 1;
    }

    .breadcrumb-item a {
        color: rgba(255, 255, 255, 0.9);
        text-decoration: none;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        height: 24px; /* SAME HEIGHT */
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1;
    }

    .breadcrumb-item a i {
        margin-right: 0.5rem;
        font-size: 0.9rem;
        width: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .breadcrumb-item a:hover {
        color: white;
        transform: translateX(3px);
    }

    .breadcrumb-item.active {
        color: white;
        font-weight: 600;
        max-width: 300px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        height: 24px; /* SAME HEIGHT */
        display: flex;
        align-items: center;
        font-size: 0.95rem;
        line-height: 1;
    }

    /* Title & Meta - CENTER ALIGNED */
    .hero-detail h1 {
        font-size: 2.5rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        line-height: 1.3;
        text-align: center;
    }

    .hero-detail-meta {
        display: flex;
        justify-content: center;
        gap: 2rem;
        flex-wrap: wrap;
        margin-top: 1.5rem;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
    }

    /* ===== PERBAIKAN META ITEM (HERO) - ALIGNMENT SEMPURNA ===== */
    .meta-item {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        padding: 0.6rem 1.2rem;
        border-radius: 20px;
        border: 1px solid rgba(255, 255, 255, 0.2);
        transition: all 0.3s ease;
        min-height: 40px; /* PERBAIKAN: Consistent height */
    }

    .meta-item:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .meta-item i {
        opacity: 0.9;
        width: 18px; /* PERBAIKAN: Fixed width */
        height: 18px; /* PERBAIKAN: Fixed height */
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1rem; /* PERBAIKAN: Consistent size */
        flex-shrink: 0; /* PERBAIKAN: Prevent shrinking */
    }

    .meta-item span {
        font-size: 0.95rem;
        font-weight: 500;
        line-height: 1.2;
        white-space: nowrap;
    }

    /* Main Content */
    .main-content {
        max-width: 1200px;
        margin: 0 auto;
        padding: 4rem 2rem;
        display: grid;
        grid-template-columns: 1fr 300px;
        gap: 3rem;
    }

    /* Article Container */
    .article-container {
        background: white;
        border-radius: 25px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
        border: 1px solid rgba(220, 20, 60, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
    }

    .article-container::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    }

    /* ===== PERBAIKAN ARTICLE HEADER - GAMBAR TIDAK TERPOTONG ===== */
    .article-header {
        position: relative;
        overflow: hidden;
        width: 100%;
        height: 480px; /* PERBAIKAN: Diperbesar untuk full view */
        background: #f8f9fa; /* Background fallback */
    }

    .article-header-no-image {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        padding: 2rem;
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
    }

    .article-overlay-alt {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    /* ===== PERBAIKAN GAMBAR ARTIKEL - FULL SIZE ===== */
    .article-image {
        width: 100%;
        height: 480px; /* PERBAIKAN: Diperbesar untuk menampilkan lebih banyak */
        object-fit: cover;
        object-position: center center; /* PERBAIKAN: Pastikan gambar terpusat */
        transition: transform 0.5s ease;
        border-radius: 0; /* PERBAIKAN: Hilangkan border-radius */
    }

    .article-container:hover .article-image {
        transform: scale(1.02);
    }

    .article-overlay {
        position: absolute;
        top: 20px;
        left: 20px;
        right: 20px;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
    }

    .category-badge {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.5rem 1.2rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 6px 20px rgba(220, 20, 60, 0.4);
    }

    .featured-badge {
        background: linear-gradient(135deg, #FFD700, #FFA500);
        color: #333;
        padding: 0.5rem 1.2rem;
        border-radius: 25px;
        font-size: 0.9rem;
        font-weight: 600;
        box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
    }

    /* Article Content */
    .article-content {
        padding: 2.5rem;
    }

    .article-title {
        font-size: 2.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        line-height: 1.3;
    }

    /* ===== PERBAIKAN META DETAIL - ICON ALIGNMENT SEMPURNA ===== */
    .article-meta-detail {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        border-left: 4px solid #DC143C;
        padding: 2rem;
        border-radius: 0 15px 15px 0;
        margin-bottom: 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        align-items: center; /* PERBAIKAN: Center alignment */
    }

    .meta-detail-item {
        display: flex;
        align-items: center; /* PERBAIKAN: Perfect vertical alignment */
        gap: 1rem;
        color: #555;
        min-height: 44px; /* PERBAIKAN: Consistent height untuk semua item */
        padding: 0.6rem 0; /* PERBAIKAN: Consistent padding */
    }

    .meta-detail-item i {
        color: #DC143C;
        font-size: 1.3rem; /* PERBAIKAN: Consistent icon size */
        width: 26px; /* PERBAIKAN: Fixed width for perfect alignment */
        height: 26px; /* PERBAIKAN: Fixed height for perfect alignment */
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0; /* PERBAIKAN: Prevent icon shrinking */
        background: rgba(220, 20, 60, 0.1); /* PERBAIKAN: Background untuk konsistensi */
        border-radius: 50%; /* PERBAIKAN: Circular background */
    }

    .meta-detail-item span {
        display: flex;
        align-items: center;
        font-size: 1rem;
        line-height: 1.4;
    }

    .meta-detail-item strong {
        color: #333;
        font-weight: 600;
        margin-right: 0.5rem;
    }

    .article-body {
        line-height: 1.8;
        font-size: 1.1rem;
        color: #444;
        margin-bottom: 2rem;
    }

    .article-body p {
        margin-bottom: 1.5rem;
        text-align: justify;
    }

    .article-body img {
        max-width: 100%;
        height: auto;
        border-radius: 15px;
        margin: 2rem 0;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
    }

    /* Tags & Share */
    .tags-section {
        background: rgba(255, 245, 245, 0.7);
        border-radius: 15px;
        padding: 1.5rem;
        margin: 2rem 0;
        border: 1px solid rgba(220, 20, 60, 0.1);
    }

    .tags-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .tag-item {
        display: inline-block;
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        color: #DC143C;
        padding: 0.5rem 1rem;
        border-radius: 20px;
        text-decoration: none;
        font-size: 0.9rem;
        font-weight: 500;
        margin: 0.3rem 0.5rem 0.3rem 0;
        border: 1px solid rgba(220, 20, 60, 0.2);
        transition: all 0.3s ease;
    }

    .tag-item:hover {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(220, 20, 60, 0.3);
    }

    .share-section {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        border-radius: 15px;
        padding: 1.5rem;
        margin: 2rem 0;
        text-align: center;
        border: 1px solid rgba(220, 20, 60, 0.1);
    }

    .share-title {
        font-size: 1.2rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1rem;
    }

    .share-buttons {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .share-btn {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        text-decoration: none;
        transition: all 0.4s ease;
        font-size: 1.1rem;
    }

    .share-btn:hover {
        transform: translateY(-5px) scale(1.1);
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .share-facebook { background: linear-gradient(135deg, #3b5998, #2d4373); }
    .share-twitter { background: linear-gradient(135deg, #1da1f2, #0d8bd9); }
    .share-whatsapp { background: linear-gradient(135deg, #25d366, #20ba5a); }
    .share-email { background: linear-gradient(135deg, #ea4335, #d23430); }

    /* Navigation Buttons */
    .navigation-section {
        padding: 0 2.5rem 2.5rem;
        display: flex;
        justify-content: space-between;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .nav-btn {
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        color: white;
        padding: 1rem 2rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.4s ease;
        box-shadow: 0 6px 20px rgba(220, 20, 60, 0.3);
    }

    .nav-btn:hover {
        transform: translateY(-3px) scale(1.02);
        box-shadow: 0 10px 30px rgba(220, 20, 60, 0.4);
        color: white;
    }

    /* Related News */
    .related-section {
        margin-top: 3rem;
        animation: fadeInUp 0.8s ease 0.4s both;
    }

    .section-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 2rem;
        font-weight: 700;
        position: relative;
        text-align: center;
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        border-radius: 2px;
    }

    .related-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .related-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(220, 20, 60, 0.1);
        transition: all 0.4s ease;
        border: 1px solid rgba(220, 20, 60, 0.05);
        position: relative;
    }

    .related-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        transform: scaleX(0);
        transition: transform 0.4s ease;
        transform-origin: left;
    }

    .related-card:hover::before {
        transform: scaleX(1);
    }

    .related-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 20px 50px rgba(220, 20, 60, 0.2);
    }

    .related-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .related-card:hover img {
        transform: scale(1.05);
    }

    .related-content {
        padding: 1.5rem;
    }

    .related-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.8rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .related-card:hover .related-title {
        color: #DC143C;
    }

    .related-excerpt {
        color: #666;
        font-size: 0.9rem;
        line-height: 1.5;
        margin-bottom: 1rem;
    }

    .related-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #999;
    }

    /* Sidebar */
    .sidebar {
        animation: fadeInUp 0.8s ease 0.6s both;
    }

    .sidebar-widget {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-bottom: 2rem;
        box-shadow: 0 10px 30px rgba(220, 20, 60, 0.1);
        border: 1px solid rgba(220, 20, 60, 0.05);
        position: relative;
        overflow: hidden;
    }

    .sidebar-widget::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
    }

    .sidebar-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1.5rem;
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .sidebar-title i {
        color: #DC143C;
    }

    /* News Items */
    .news-item {
        display: flex;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
        transition: all 0.3s ease;
    }

    .news-item:last-child {
        border-bottom: none;
    }

    .news-item:hover {
        background: rgba(255, 245, 245, 0.5);
        border-radius: 10px;
        padding: 1rem;
        margin: 0 -1rem;
    }

    .news-image {
        width: 80px;
        height: 60px;
        border-radius: 10px;
        object-fit: cover;
        flex-shrink: 0;
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
    }

    .news-content h6 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .news-content a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .news-content a:hover {
        color: #DC143C;
    }

    .news-date {
        font-size: 0.8rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Popular Items */
    .popular-item {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid rgba(220, 20, 60, 0.1);
        transition: all 0.3s ease;
    }

    .popular-item:last-child {
        border-bottom: none;
    }

    .popular-item:hover {
        background: rgba(255, 245, 245, 0.5);
        border-radius: 10px;
        padding: 1rem;
        margin: 0 -1rem;
    }

    .popular-number {
        width: 35px;
        height: 35px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.9rem;
        flex-shrink: 0;
    }

    .popular-content h6 {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .popular-content a {
        color: #333;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .popular-content a:hover {
        color: #DC143C;
    }

    .popular-views {
        font-size: 0.8rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.3rem;
    }

    /* Categories */
    .category-list {
        list-style: none;
        padding: 0;
    }

    .category-item {
        margin-bottom: 0.8rem;
    }

    .category-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.8rem 1rem;
        color: #555;
        text-decoration: none;
        border-radius: 12px;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .category-link:hover,
    .category-link.active {
        color: #DC143C;
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        transform: translateX(8px);
        border-left: 4px solid #DC143C;
        font-weight: 600;
    }

    .category-count {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.2rem 0.6rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    /* Info Section */
    .info-section {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        padding: 1.5rem;
        border-radius: 15px;
        color: #555;
        line-height: 1.6;
    }

    .info-section p {
        margin-bottom: 0.8rem;
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
    }

    .info-section strong {
        color: #DC143C;
        flex-shrink: 0; /* PERBAIKAN: Prevent shrinking pada label */
        min-width: 80px; /* PERBAIKAN: Minimum width untuk konsistensi */
    }

    .info-section span {
        text-align: right; /* PERBAIKAN: Explicit right alignment */
        flex: 1; /* PERBAIKAN: Take remaining space */
        word-wrap: break-word; /* PERBAIKAN: Handle long text */
        line-height: 1.4; /* PERBAIKAN: Better line height untuk readability */
    }

    /* Animations */
    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    @keyframes gentleFloat {
        0% { transform: translateX(-50px) translateY(-30px); }
        50% { transform: translateX(30px) translateY(20px); }
        100% { transform: translateX(-50px) translateY(-30px); }
    }

    /* ===== RESPONSIVE - PERBAIKAN UNTUK MOBILE ===== */
    @media (max-width: 1024px) {
        .main-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 1rem;
        }

        .hero-detail h1 {
            font-size: 2rem;
        }

        .hero-detail-meta {
            gap: 1rem;
        }

        /* PERBAIKAN: Gambar responsive untuk tablet */
        .article-image {
            height: 400px;
        }

        .article-header {
            height: 400px;
        }
    }

    @media (max-width: 768px) {
        .hero-detail {
            padding: 6rem 0 3rem;
        }

        .hero-detail h1 {
            font-size: 1.8rem;
        }

        .hero-detail-meta {
            flex-direction: column;
            align-items: center;
            gap: 0.8rem;
        }

        .article-content {
            padding: 2rem 1.5rem;
        }

        .article-title {
            font-size: 1.8rem;
        }

        /* PERBAIKAN: Meta detail mobile responsive */
        .article-meta-detail {
            grid-template-columns: 1fr;
            padding: 1.5rem;
            gap: 1.2rem;
        }

        .meta-detail-item {
            min-height: 38px; /* Sedikit lebih kecil untuk mobile */
        }

        .meta-detail-item i {
            width: 24px;
            height: 24px;
            font-size: 1.2rem;
        }

        .navigation-section {
            flex-direction: column;
            padding: 0 1.5rem 2rem;
        }

        .nav-btn {
            justify-content: center;
            text-align: center;
        }

        .related-grid {
            grid-template-columns: 1fr;
        }

        .breadcrumb-nav {
            padding: 0.8rem 1.5rem;
        }

        .breadcrumb-item.active {
            max-width: 200px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            padding: 0 0.6rem;
            font-size: 1.1rem;
        }

        .breadcrumb-item a,
        .breadcrumb-item.active {
            font-size: 0.9rem;
            height: 22px;
        }

        /* PERBAIKAN: Gambar responsive untuk mobile */
        .article-image {
            height: 320px;
        }

        .article-header {
            height: 320px;
        }

        .info-section p {
            gap: 0.8rem; /* Reduce gap on mobile */
        }
    
        .info-section strong {
            min-width: 70px; /* Smaller min-width on mobile */
            font-size: 0.9rem;
        }
    
        .info-section span {
            font-size: 0.9rem;
        /* Tetap right aligned di mobile juga */
        }
    }

    @media (max-width: 480px) {
        .hero-detail {
            padding: 5rem 0 2rem;
        }

        .hero-detail h1 {
            font-size: 1.6rem;
        }

        .article-content {
            padding: 1.5rem 1rem;
        }

        .article-title {
            font-size: 1.6rem;
        }

        .sidebar-widget {
            padding: 1.5rem;
        }

        .meta-item {
            padding: 0.4rem 0.8rem;
            font-size: 0.9rem;
            min-height: 36px;
        }

        .meta-item i {
            width: 16px;
            height: 16px;
            font-size: 0.9rem;
        }

        /* PERBAIKAN: Meta detail untuk mobile kecil */
        .article-meta-detail {
            padding: 1.2rem;
            gap: 1rem;
        }

        .meta-detail-item {
            min-height: 36px;
            gap: 0.8rem;
        }

        .meta-detail-item i {
            width: 22px;
            height: 22px;
            font-size: 1.1rem;
        }

        .breadcrumb-nav {
            padding: 0.7rem 1rem;
        }

        .breadcrumb-item.active {
            max-width: 150px;
        }

        .breadcrumb-item + .breadcrumb-item::before {
            padding: 0 0.4rem;
            font-size: 1rem;
        }

        .breadcrumb-item a,
        .breadcrumb-item.active {
            font-size: 0.85rem;
            height: 20px;
        }

        .breadcrumb-item a i {
            font-size: 0.8rem;
            margin-right: 0.3rem;
            width: 14px;
        }

        /* PERBAIKAN: Gambar responsive untuk mobile kecil */
        .article-image {
            height: 280px;
        }

        .article-header {
            height: 280px;
        }

        .info-section {
            padding: 1.2rem;
        }
    
        .info-section p {
            margin-bottom: 0.6rem;
        }
    
        .info-section strong {
            min-width: 70px;
            font-size: 0.9rem;
        }
    
        .info-section span {
            font-size: 0.9rem;
        }

    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-detail">
        <div class="hero-detail-content">
            <!-- Breadcrumb - PERFECT ALIGNMENT -->
            <nav class="breadcrumb-nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fas fa-home"></i>
                            Beranda
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('berita') }}">Berita</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('berita') }}?kategori={{ $berita->kategori }}">
                            {{ ucfirst($berita->kategori) }}
                        </a>
                    </li>
                    <li class="breadcrumb-item active" title="{{ $berita->judul }}">
                        {{ Str::limit($berita->judul, 50) }}
                    </li>
                </ol>
            </nav>

            <h1>{{ $berita->judul }}</h1>
            
            <div class="hero-detail-meta">
                <div class="meta-item">
                    <i class="fas fa-user"></i>
                    <span>{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-calendar"></i>
                    <span>{{ $berita->tanggal->format('d F Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-eye"></i>
                    <span>{{ number_format($berita->views) }} views</span>
                </div>
                <div class="meta-item">
                    <i class="fas fa-clock"></i>
                    <span>{{ $berita->created_at->diffForHumans() }}</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <!-- Article Container -->
            <article class="article-container">
                <!-- Article Header -->
                @if($berita->gambar)
                    @php
                        $imagePaths = [
                            'storage/berita/gambar/' . $berita->gambar,
                            'uploads/berita/' . $berita->gambar,
                            'uploads/' . $berita->gambar,
                            'images/berita/' . $berita->gambar
                        ];
                        
                        $imageFound = false;
                        $imagePath = '';
                        
                        foreach($imagePaths as $path) {
                            if(file_exists(public_path($path))) {
                                $imagePath = asset($path);
                                $imageFound = true;
                                break;
                            }
                        }
                        
                        if(!$imageFound && $berita->gambar) {
                            $imagePath = $berita->gambar;
                            $imageFound = true;
                        }
                    @endphp

                    @if($imageFound)
                    <div class="article-header">
                        <img src="{{ $imagePath }}" 
                             alt="{{ $berita->alt_gambar ?? $berita->judul }}" 
                             class="article-image"
                             onerror="this.parentElement.style.display='none'; this.parentElement.nextElementSibling.style.display='block';">
                        
                        <div class="article-overlay">
                            <span class="category-badge">{{ ucfirst($berita->kategori) }}</span>
                            @if($berita->featured)
                                <span class="featured-badge">
                                    <i class="fas fa-star"></i> Featured
                                </span>
                            @endif
                        </div>
                    </div>
                    @endif
                @endif

                <!-- Header alternatif jika tidak ada gambar -->
                @if(!$berita->gambar || !($imageFound ?? false))
                <div class="article-header-no-image" @if($berita->gambar) style="display:none;" @endif>
                    <div class="article-overlay-alt">
                        <span class="category-badge">{{ ucfirst($berita->kategori) }}</span>
                        @if($berita->featured)
                            <span class="featured-badge">
                                <i class="fas fa-star"></i> Featured
                            </span>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Article Content -->
                <div class="article-content">
                    <h1 class="article-title">{{ $berita->judul }}</h1>

                    <!-- Article Meta Detail -->
                    <div class="article-meta-detail">
                        <div class="meta-detail-item">
                            <i class="fas fa-user"></i>
                            <span><strong>Penulis:</strong> {{ $berita->admin->nama_lengkap ?? 'Admin' }}</span>
                        </div>
                        <div class="meta-detail-item">
                            <i class="fas fa-calendar"></i>
                            <span><strong>Tanggal:</strong> {{ $berita->tanggal->format('d F Y') }}</span>
                        </div>
                        <div class="meta-detail-item">
                            <i class="fas fa-eye"></i>
                            <span><strong>Dibaca:</strong> {{ number_format($berita->views) }} kali</span>
                        </div>
                        <div class="meta-detail-item">
                            <i class="fas fa-tag"></i>
                            <span><strong>Kategori:</strong> {{ ucfirst($berita->kategori) }}</span>
                        </div>
                    </div>

                    <!-- Article Body -->
                    <div class="article-body">
                        {!! nl2br(e($berita->konten)) !!}
                    </div>

                    <!-- Tags Section -->
                    @if($berita->tags)
                        <div class="tags-section">
                            <h6 class="tags-title">
                                <i class="fas fa-tags"></i>
                                Tags:
                            </h6>
                            <div>
                                @foreach($berita->tagsArray as $tag)
                                    <a href="{{ route('berita', ['search' => trim($tag)]) }}" class="tag-item">
                                        {{ trim($tag) }}
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Share Section -->
                    <div class="share-section">
                        <h6 class="share-title">
                            <i class="fas fa-share-alt"></i>
                            Bagikan Artikel Ini:
                        </h6>
                        <div class="share-buttons">
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                               target="_blank" class="share-btn share-facebook" title="Share to Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?text={{ urlencode($berita->judul) }}&url={{ urlencode(url()->current()) }}" 
                               target="_blank" class="share-btn share-twitter" title="Share to Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . url()->current()) }}" 
                               target="_blank" class="share-btn share-whatsapp" title="Share to WhatsApp">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($berita->judul) }}&body={{ urlencode('Baca selengkapnya: ' . url()->current()) }}" 
                               class="share-btn share-email" title="Share via Email">
                                <i class="fas fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Navigation Section -->
                <div class="navigation-section">
                    <a href="{{ route('berita') }}" class="nav-btn">
                        <i class="fas fa-arrow-left"></i>
                        Kembali ke Berita
                    </a>
                    
                    <a href="{{ route('berita') }}?kategori={{ $berita->kategori }}" class="nav-btn">
                        Berita {{ ucfirst($berita->kategori) }}
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </article>

            <!-- Related News -->
            @if($relatedBerita->count() > 0)
                <section class="related-section">
                    <h2 class="section-title">
                        <i class="fas fa-newspaper"></i>
                        Berita Terkait
                    </h2>
                    
                    <div class="related-grid">
                        @foreach($relatedBerita as $related)
                            <article class="related-card">
                                @if($related->gambar)
                                    @php
                                        $relatedImagePaths = [
                                            'storage/berita/gambar/' . $related->gambar,
                                            'uploads/berita/' . $related->gambar,
                                            'uploads/' . $related->gambar
                                        ];
                                        
                                        $relatedImageFound = false;
                                        $relatedImagePath = '';
                                        
                                        foreach($relatedImagePaths as $path) {
                                            if(file_exists(public_path($path))) {
                                                $relatedImagePath = asset($path);
                                                $relatedImageFound = true;
                                                break;
                                            }
                                        }
                                        
                                        if(!$relatedImageFound) {
                                            $relatedImagePath = $related->gambar;
                                        }
                                    @endphp
                                    
                                    <img src="{{ $relatedImagePath }}" 
                                         alt="{{ $related->alt_gambar ?? $related->judul }}"
                                         onerror="this.style.display='none';">
                                @endif
                                
                                <div class="related-content">
                                    <h3 class="related-title">
                                        <a href="{{ route('berita.detail', $related->slug) }}">
                                            {{ Str::limit($related->judul, 80) }}
                                        </a>
                                    </h3>
                                    
                                    <p class="related-excerpt">
                                        {{ Str::limit($related->excerpt, 100) }}
                                    </p>
                                    
                                    <div class="related-meta">
                                        <div>
                                            <i class="fas fa-calendar"></i>
                                            {{ $related->tanggal->format('d M Y') }}
                                        </div>
                                        <div>
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($related->views) }}
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Latest News Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-title">
                    <i class="fas fa-clock"></i>
                    Berita Terbaru
                </h5>
                
                @forelse($latestBerita as $latest)
                    <div class="news-item">
                        @if($latest->gambar)
                            @php
                                $latestImageFound = false;
                                foreach(['storage/berita/gambar/', 'uploads/berita/', 'uploads/'] as $dir) {
                                    if(file_exists(public_path($dir . $latest->gambar))) {
                                        $latestImagePath = asset($dir . $latest->gambar);
                                        $latestImageFound = true;
                                        break;
                                    }
                                }
                                if(!$latestImageFound) $latestImagePath = $latest->gambar;
                            @endphp
                            <img src="{{ $latestImagePath }}" 
                                 alt="{{ $latest->judul }}" class="news-image"
                                 onerror="this.style.display='none';">
                        @else
                            <div class="news-image" style="display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-image" style="color: #ccc;"></i>
                            </div>
                        @endif
                        <div class="news-content">
                            <h6>
                                <a href="{{ route('berita.detail', $latest->slug) }}">
                                    {{ Str::limit($latest->judul, 60) }}
                                </a>
                            </h6>
                            <div class="news-date">
                                <i class="fas fa-calendar"></i>
                                {{ $latest->tanggal->format('d M Y') }}
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #999;">Tidak ada berita terbaru.</p>
                @endforelse
            </div>

            <!-- Popular News Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-title">
                    <i class="fas fa-fire"></i>
                    Berita Populer
                </h5>
                
                @forelse($popularBerita as $index => $popular)
                    <div class="popular-item">
                        <div class="popular-number">{{ $index + 1 }}</div>
                        <div class="popular-content">
                            <h6>
                                <a href="{{ route('berita.detail', $popular->slug) }}">
                                    {{ Str::limit($popular->judul, 70) }}
                                </a>
                            </h6>
                            <div class="popular-views">
                                <i class="fas fa-eye"></i>
                                {{ number_format($popular->views) }} views
                            </div>
                        </div>
                    </div>
                @empty
                    <p style="text-align: center; color: #999;">Tidak ada berita populer.</p>
                @endforelse
            </div>

            <!-- Categories Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-title">
                    <i class="fas fa-list"></i>
                    Kategori
                </h5>
                
                <ul class="category-list">
                    <li class="category-item">
                        <a href="{{ route('berita') }}" class="category-link">
                            <span>
                                <i class="fas fa-list"></i> Semua Kategori
                            </span>
                        </a>
                    </li>
                    @php
                        $availableCategories = [
                            'umum' => 'Umum',
                            'pemerintahan' => 'Pemerintahan',
                            'ekonomi' => 'Ekonomi',
                            'sosial' => 'Sosial',
                            'budaya' => 'Budaya',
                            'kesehatan' => 'Kesehatan',
                            'pendidikan' => 'Pendidikan',
                            'olahraga' => 'Olahraga'
                        ];
                        
                        $categoryCounts = \App\Models\Berita::where('status', 'published')
                            ->selectRaw('kategori, COUNT(*) as total')
                            ->groupBy('kategori')
                            ->pluck('total', 'kategori');
                    @endphp
                    
                    @foreach($availableCategories as $key => $label)
                    <li class="category-item">
                        <a href="{{ route('berita') }}?kategori={{ $key }}" 
                           class="category-link {{ $berita->kategori == $key ? 'active' : '' }}">
                            <span>
                                <i class="fas fa-tag"></i> {{ $label }}
                            </span>
                            @if($categoryCounts->get($key, 0) > 0)
                                <span class="category-count">{{ $categoryCounts->get($key, 0) }}</span>
                            @endif
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            <!-- Info Widget -->
            <div class="sidebar-widget">
                <h5 class="sidebar-title">
                    <i class="fas fa-info-circle"></i>
                    Info Artikel
                </h5>
                
                <div class="info-section">
                    <p><strong>Kategori:</strong> <span>{{ ucfirst($berita->kategori) }}</span></p>
                    <p><strong>Tanggal:</strong> <span>{{ $berita->tanggal->format('d F Y') }}</span></p>
                    <p><strong>Views:</strong> <span>{{ number_format($berita->views) }}</span></p>
                    <p><strong>Penulis:</strong> <span>{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span></p>
                    @if($berita->tags)
                        <p><strong>Tags:</strong> <span>{{ count($berita->tagsArray) }} tags</span></p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Reading progress bar
        let progressBar = document.createElement('div');
        progressBar.style.cssText = `
            position: fixed;
            top: 0;
            left: 0;
            width: 0%;
            height: 3px;
            background: linear-gradient(90deg, #FF6B6B, #DC143C);
            z-index: 9999;
            transition: width 0.1s ease;
        `;
        document.body.appendChild(progressBar);
        
        window.addEventListener('scroll', function() {
            const article = document.querySelector('.article-body');
            if (article) {
                const articleHeight = article.offsetHeight;
                const articleTop = article.offsetTop;
                const scrollTop = window.pageYOffset;
                const windowHeight = window.innerHeight;
                
                const scrolled = Math.min(
                    Math.max((scrollTop - articleTop + windowHeight/2) / articleHeight, 0), 
                    1
                );
                
                progressBar.style.width = (scrolled * 100) + '%';
            }
        });

        // Share buttons
        document.querySelectorAll('.share-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const platform = this.classList.contains('share-facebook') ? 'Facebook' :
                               this.classList.contains('share-twitter') ? 'Twitter' :
                               this.classList.contains('share-whatsapp') ? 'WhatsApp' : 'Email';
                
                console.log(`Shared to ${platform}: {{ $berita->judul }}`);
            });
        });
    });
</script>
@endpush