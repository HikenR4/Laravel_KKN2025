{{-- resources/views/public/detail-berita.blade.php --}}
@extends('layouts.app')
@section('title', $berita->judul . ' - Nagari Mungo')
@section('meta_description', $berita->meta_description ?? $berita->excerpt)
@push('styles')
<style>
/* ===== PERBAIKAN UTAMA UNTUK JUDUL BERITA PANJANG DAN HORIZONTAL OVERFLOW ===== */

/* RESET DAN SETUP DASAR */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    overflow-x: hidden !important; /* PENTING: Hilangkan horizontal scroll */
    width: 100%;
    max-width: 100vw !important; /* Pastikan tidak lebih lebar dari viewport */
}

/* UTILITY CLASSES UNTUK MENCEGAH OVERFLOW */
.no-overflow {
    overflow: hidden;
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.text-wrap {
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    hyphens: auto !important;
    white-space: normal !important;
}

.container-safe {
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;
}

/* Hero Section - PERBAIKAN LAYOUT */
.hero-detail {
    background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
    padding: 10rem 0 4rem;
    color: white;
    position: relative;
    overflow: hidden;
    width: 100%;
    max-width: 100vw;
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
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    padding: 0 2rem;
    width: 100%;
    box-sizing: border-box;
    min-width: 0; /* Allow shrinking */
}

/* ===== BREADCRUMB - PERBAIKAN OVERFLOW ===== */
.breadcrumb-nav {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(10px);
    border-radius: 15px;
    padding: 1rem 2rem;
    margin-bottom: 2rem;
    border: 1px solid rgba(255, 255, 255, 0.2);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    text-align: left;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;
}

.breadcrumb {
    margin: 0;
    background: none;
    padding: 0;
    display: flex;
    flex-wrap: wrap;
    list-style: none;
    align-items: center;
    line-height: 1;
    min-height: 24px;
    width: 100%;
    max-width: 100%;
    overflow: hidden;
}

.breadcrumb-item {
    display: flex;
    align-items: center;
    line-height: 1;
    height: 24px;
    max-width: 100%;
    flex-shrink: 1;
    min-width: 0;
}

.breadcrumb-item + .breadcrumb-item::before {
    content: "›";
    color: rgba(255, 255, 255, 0.7);
    font-size: 1.2rem;
    padding: 0 0.8rem;
    display: flex;
    align-items: center;
    justify-content: center;
    height: 24px;
    line-height: 1;
}

.breadcrumb-item a {
    color: rgba(255, 255, 255, 0.9);
    text-decoration: none;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    height: 24px;
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
    height: 24px;
    display: flex;
    align-items: center;
    font-size: 0.95rem;
    line-height: 1;
    flex-shrink: 1;
    min-width: 0;
}

/* ===== HERO TITLE - PERBAIKAN TEXT WRAPPING ===== */
.hero-detail h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 1rem;
    text-shadow: 0 4px 20px rgba(0,0,0,0.3);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
    line-height: 1.3;
    text-align: center;

    /* PERBAIKAN UTAMA: Text wrapping untuk judul panjang */
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    hyphens: auto !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    white-space: normal !important;
    overflow: hidden !important;
}

.hero-detail-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
    margin-top: 1.5rem;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

/* ===== META ITEM - PERBAIKAN RESPONSIF ===== */
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
    min-height: 40px;
    flex-shrink: 1;
    min-width: 0;
    max-width: 100%;
}

.meta-item:hover {
    background: rgba(255, 255, 255, 0.2);
    transform: translateY(-2px);
}

.meta-item i {
    opacity: 0.9;
    width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1rem;
    flex-shrink: 0;
}

.meta-item span {
    font-size: 0.95rem;
    font-weight: 500;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

/* Main Content */
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 4rem 2rem;
    display: grid;
    grid-template-columns: 65% 33%;
    gap: 2%;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;
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
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
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

/* ===== ARTICLE HEADER - GAMBAR RESPONSIF ===== */
.article-header {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: 400px;
    background: #f8f9fa;
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

.article-image {
    width: 100%;
    height: 400px;
    object-fit: cover;
    object-position: center center;
    transition: transform 0.5s ease;
    border-radius: 0;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    overflow: hidden;
    word-wrap: break-word;
}

/* ===== ARTICLE TITLE - PERBAIKAN TEXT WRAPPING ===== */
.article-title {
    font-size: 2.2rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1.5rem;
    line-height: 1.3;

    /* PERBAIKAN UTAMA: Text wrapping untuk artikel title */
    word-wrap: break-word !important;
    overflow-wrap: break-word !important;
    word-break: break-word !important;
    hyphens: auto !important;
    width: 100% !important;
    max-width: 100% !important;
    box-sizing: border-box !important;
    white-space: normal !important;
    overflow: hidden !important;
}

/* ===== ARTICLE META DETAIL - ICON ALIGNMENT SEMPURNA ===== */
.article-meta-detail {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
    border-left: 4px solid #DC143C;
    padding: 2rem;
    border-radius: 0 15px 15px 0;
    margin-bottom: 2rem;
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    align-items: center;
}

.meta-detail-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: #555;
    min-height: 44px;
    padding: 0.6rem 0;
}

.meta-detail-item i {
    color: #DC143C;
    font-size: 1.3rem;
    width: 26px;
    height: 26px;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    background: rgba(220, 20, 60, 0.1);
    border-radius: 50%;
}

.meta-detail-item span {
    display: flex;
    align-items: center;
    font-size: 1rem;
    line-height: 1.4;
    word-wrap: break-word;
    overflow-wrap: break-word;
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
    word-wrap: break-word;
    overflow-wrap: break-word;
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.article-body p {
    margin-bottom: 1.5rem;
    text-align: justify;
    word-wrap: break-word;
    overflow-wrap: break-word;
    width: 100%;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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
    word-wrap: break-word;
    overflow-wrap: break-word;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
}

.related-title {
    font-size: 1.1rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.8rem;
    line-height: 1.4;
    transition: color 0.3s ease;
    word-wrap: break-word;
    overflow-wrap: break-word;
    width: 100%;
    max-width: 100%;
}

.related-card:hover .related-title {
    color: #DC143C;
}

.related-excerpt {
    color: #666;
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1rem;
    word-wrap: break-word;
    overflow-wrap: break-word;
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
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
    word-wrap: break-word;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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

.news-content {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.news-content h6 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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

.popular-content {
    width: 100%;
    max-width: 100%;
    min-width: 0;
    box-sizing: border-box;
}

.popular-content h6 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    line-height: 1.3;
    word-wrap: break-word;
    overflow-wrap: break-word;
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
    width: 100%;
    max-width: 100%;
    box-sizing: border-box;
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
    flex-shrink: 0;
    min-width: 80px;
}

.info-section span {
    text-align: right;
    flex: 1;
    word-wrap: break-word;
    line-height: 1.4;
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

/* ===== RESPONSIVE DESIGN YANG LEBIH BAIK ===== */
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

    .article-image {
        height: 350px;
    }

    .article-header {
        height: 350px;
    }
}

@media (max-width: 768px) {
    .hero-detail {
        padding: 6rem 0 3rem;
    }

    .hero-detail h1 {
        font-size: 1.8rem;
    }

    .hero-detail-content {
        padding: 0 1rem;
    }

    .hero-detail-meta {
        flex-direction: column;
        align-items: center;
        gap: 0.8rem;
    }

    .meta-item {
        min-width: 200px;
        justify-content: center;
    }

    .meta-item span {
        white-space: normal;
        text-align: center;
    }

    .article-content {
        padding: 2rem 1.5rem;
    }

    .article-title {
        font-size: 1.8rem;
    }

    .article-meta-detail {
        grid-template-columns: 1fr;
        padding: 1.5rem;
        gap: 1.2rem;
    }

    .meta-detail-item {
        min-height: 38px;
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

    .article-image {
        height: 300px;
    }

    .article-header {
        height: 300px;
    }

    .info-section p {
        gap: 0.8rem;
    }

    .info-section strong {
        min-width: 70px;
        font-size: 0.9rem;
    }

    .info-section span {
        font-size: 0.9rem;
    }
}

@media (max-width: 480px) {
    .hero-detail {
        padding: 5rem 0 2rem;
    }

    .hero-detail h1 {
        font-size: 1.6rem;
        line-height: 1.2;
        padding: 0 0.5rem;
    }

    .hero-detail-content {
        padding: 0 0.5rem;
    }

    .article-content {
        padding: 1.5rem 1rem;
    }

    .article-title {
        font-size: 1.6rem;
        line-height: 1.2;
    }

    .sidebar-widget {
        padding: 1.5rem;
    }

    .meta-item {
        padding: 0.4rem 0.8rem;
        font-size: 0.9rem;
        min-height: 36px;
        min-width: 150px;
    }

    .meta-item i {
        width: 16px;
        height: 16px;
        font-size: 0.9rem;
    }

    .meta-item span {
        font-size: 0.85rem;
        white-space: normal;
        text-align: center;
    }

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
/* ===== COMMENT SECTION STYLES ===== */
/* Tambahkan CSS ini ke dalam tag <style> di detail-berita.blade.php */

.comments-section {
    background: white;
    border-radius: 25px;
    padding: 2.5rem;
    margin-top: 3rem;
    box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
    border: 1px solid rgba(220, 20, 60, 0.05);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.comments-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
}

.comments-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
    padding-bottom: 1rem;
    border-bottom: 2px solid rgba(220, 20, 60, 0.1);
}

.comment-stats {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.stat-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #666;
    font-size: 0.9rem;
}

.stat-item i {
    color: #DC143C;
}

/* Comment Form */
.comment-form-section {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.05), rgba(220, 20, 60, 0.03));
    border-radius: 20px;
    padding: 2rem;
    margin-bottom: 2.5rem;
    border: 1px solid rgba(220, 20, 60, 0.1);
}

.form-title {
    font-size: 1.3rem;
    font-weight: 700;
    color: #333;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.form-title i {
    color: #DC143C;
}

.comment-form {
    width: 100%;
    max-width: 100%;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    margin-bottom: 1.5rem;
}

.form-group label {
    font-weight: 600;
    color: #333;
    margin-bottom: 0.5rem;
    font-size: 0.95rem;
}

.form-group input,
.form-group textarea {
    padding: 0.8rem 1.2rem;
    border: 2px solid rgba(220, 20, 60, 0.2);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
    font-family: inherit;
}

.form-group input:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #DC143C;
    box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.1);
    transform: translateY(-2px);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.char-counter {
    font-size: 0.85rem;
    color: #666;
    margin-top: 0.5rem;
    text-align: right;
}

.error-message {
    color: #dc3545;
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: none;
}

/* Rating Input */
.rating-input {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.stars {
    display: flex;
    gap: 0.3rem;
    cursor: pointer;
}

.stars span {
    font-size: 1.5rem;
    color: #ddd;
    transition: all 0.2s ease;
    cursor: pointer;
}

.stars span:hover,
.stars span.active {
    color: #FFD700;
    transform: scale(1.1);
}

.stars span i {
    pointer-events: none;
}

.rating-text {
    color: #666;
    font-size: 0.85rem;
}

/* Form Actions */
.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
    align-items: center;
}

.btn-cancel,
.btn-submit {
    padding: 0.8rem 2rem;
    border: none;
    border-radius: 25px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    cursor: pointer;
    font-size: 0.95rem;
}

.btn-cancel {
    background: #6c757d;
    color: white;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-submit {
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    color: white;
    box-shadow: 0 6px 20px rgba(220, 20, 60, 0.3);
}

.btn-submit:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 30px rgba(220, 20, 60, 0.4);
}

.btn-submit:disabled {
    opacity: 0.7;
    cursor: not-allowed;
    transform: none;
}

/* Comments List */
.comments-list {
    margin-top: 2rem;
}

.comment-item {
    display: flex;
    gap: 1rem;
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: rgba(255, 245, 245, 0.3);
    border-radius: 15px;
    border: 1px solid rgba(220, 20, 60, 0.1);
    transition: all 0.3s ease;
}

.comment-item:hover {
    background: rgba(255, 245, 245, 0.5);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.1);
}

.comment-avatar {
    flex-shrink: 0;
}

.avatar-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 1.1rem;
}

.reply-avatar {
    width: 40px;
    height: 40px;
    font-size: 1rem;
    background: linear-gradient(135deg, #6c757d, #495057);
}

.comment-content {
    flex: 1;
    min-width: 0;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.8rem;
}

.commenter-name {
    font-weight: 700;
    color: #333;
    margin: 0;
    font-size: 1.1rem;
}

.comment-meta {
    display: flex;
    align-items: center;
    gap: 1rem;
    color: #666;
    font-size: 0.9rem;
}

.comment-rating {
    display: flex;
    gap: 0.2rem;
}

.comment-rating i {
    color: #ddd;
    font-size: 0.9rem;
}

.comment-rating i.active {
    color: #FFD700;
}

.comment-date {
    display: flex;
    align-items: center;
    gap: 0.3rem;
}

.comment-text {
    color: #444;
    line-height: 1.6;
    margin-bottom: 1rem;
    word-wrap: break-word;
    font-size: 1rem;
}

.comment-actions {
    display: flex;
    gap: 1rem;
}

.btn-reply {
    background: none;
    border: none;
    color: #DC143C;
    font-weight: 600;
    cursor: pointer;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.4rem 0.8rem;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-reply:hover {
    background: rgba(220, 20, 60, 0.1);
    transform: translateX(3px);
}

/* Comment Replies */
.comment-replies {
    margin-top: 1.5rem;
    padding-left: 2rem;
    border-left: 3px solid rgba(220, 20, 60, 0.2);
}

.comment-reply {
    display: flex;
    gap: 0.8rem;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(255, 255, 255, 0.7);
    border-radius: 12px;
    border: 1px solid rgba(220, 20, 60, 0.05);
}

.comment-reply:last-child {
    margin-bottom: 0;
}

/* No Comments */
.no-comments {
    text-align: center;
    padding: 3rem 2rem;
    color: #666;
}

.no-comments-icon {
    font-size: 4rem;
    color: #ddd;
    margin-bottom: 1rem;
}

.no-comments h5 {
    font-size: 1.4rem;
    color: #333;
    margin-bottom: 0.5rem;
}

.no-comments p {
    font-size: 1rem;
    margin: 0;
}

/* Load More Button */
.btn-load-more {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.1));
    color: #DC143C;
    border: 2px solid rgba(220, 20, 60, 0.2);
    padding: 1rem 2rem;
    border-radius: 25px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-load-more:hover {
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
}

/* Reply Form State */
.replying .comment-form-section {
    border: 2px solid #DC143C;
    box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.1);
}

.reply-info {
    background: rgba(220, 20, 60, 0.1);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    color: #333;
    font-size: 0.95rem;
}

.reply-info strong {
    color: #DC143C;
}

/* Loading State */
.loading-spinner {
    display: inline-block;
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top-color: white;
    animation: spin 1s ease-in-out infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Success/Error Messages */
.message {
    padding: 1rem 1.5rem;
    border-radius: 12px;
    margin-bottom: 1rem;
    font-weight: 500;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.message.success {
    background: rgba(40, 167, 69, 0.1);
    color: #155724;
    border: 1px solid rgba(40, 167, 69, 0.2);
}

.message.error {
    background: rgba(220, 53, 69, 0.1);
    color: #721c24;
    border: 1px solid rgba(220, 53, 69, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .comments-section {
        padding: 1.5rem;
    }

    .comment-form-section {
        padding: 1.5rem;
    }

    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }

    .comments-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }

    .comment-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }

    .form-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .btn-cancel,
    .btn-submit {
        justify-content: center;
    }

    .comment-replies {
        padding-left: 1rem;
    }
}

@media (max-width: 480px) {
    .comment-item {
        flex-direction: column;
        gap: 1rem;
    }

    .comment-reply {
        flex-direction: column;
        gap: 0.8rem;
    }

    .avatar-circle {
        width: 60px;
        height: 60px;
        align-self: center;
    }

    .reply-avatar {
        width: 50px;
        height: 50px;
    }
}

/* ===== PERBAIKAN UNTUK FOTO TIDAK TERPOTONG ===== */

/* 1. Article Header - Ubah dari fixed height ke auto */
.article-header {
    position: relative;
    overflow: hidden;
    width: 100%;
    height: auto; /* Ubah dari height: 400px ke auto */
    min-height: 300px; /* Tambahkan min-height untuk konsistensi */
    max-height: 500px; /* Tambahkan max-height untuk kontrol */
    background: #f8f9fa;
}

/* 2. Article Image - Ubah object-fit untuk menampilkan foto lengkap */
.article-image {
    width: 100%;
    height: auto; /* Ubah dari height: 400px ke auto */
    min-height: 300px; /* Minimum height untuk konsistensi */
    max-height: 500px; /* Maximum height untuk kontrol */
    object-fit: contain; /* Ubah dari cover ke contain agar foto tidak terpotong */
    object-position: center center;
    transition: transform 0.5s ease;
    border-radius: 0;
    background: #f8f9fa; /* Background jika ada area kosong */
}

/* 3. Alternatif: Jika ingin foto memenuhi area tapi tidak terpotong drastis */
.article-image-alt {
    width: 100%;
    height: 400px;
    object-fit: scale-down; /* Alternatif lain: scale down tanpa crop */
    object-position: center center;
    transition: transform 0.5s ease;
    border-radius: 0;
    background: #f8f9fa;
}

/* 4. Responsive adjustments */
@media (max-width: 1024px) {
    .article-header {
        min-height: 280px;
        max-height: 450px;
    }

    .article-image {
        min-height: 280px;
        max-height: 450px;
    }
}

@media (max-width: 768px) {
    .article-header {
        min-height: 250px;
        max-height: 400px;
    }

    .article-image {
        min-height: 250px;
        max-height: 400px;
    }
}

@media (max-width: 480px) {
    .article-header {
        min-height: 220px;
        max-height: 350px;
    }

    .article-image {
        min-height: 220px;
        max-height: 350px;
    }
}

@media (max-width: 360px) {
    .article-header {
        min-height: 200px;
        max-height: 300px;
    }

    .article-image {
        min-height: 200px;
        max-height: 300px;
    }
}

/* ===== PERBAIKAN UNTUK RELATED CARD IMAGES ===== */
.related-card img {
    width: 100%;
    height: 180px; /* Sedikit kurangi dari 200px */
    object-fit: contain; /* Ubah dari cover ke contain */
    background: #f8f9fa;
    transition: transform 0.4s ease;
}

/* ===== PERBAIKAN UNTUK SIDEBAR NEWS IMAGES ===== */
.news-image {
    width: 80px;
    height: 60px;
    border-radius: 10px;
    object-fit: contain; /* Ubah dari cover ke contain */
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
    flex-shrink: 0;
}

/* ===== OPSI TAMBAHAN: Jika ingin foto dengan aspect ratio tetap ===== */
.article-image-ratio {
    width: 100%;
    aspect-ratio: 16/9; /* Rasio 16:9 */
    object-fit: contain;
    object-position: center center;
    background: #f8f9fa;
    transition: transform 0.5s ease;
}

/* ===== FALLBACK: Jika gambar error atau tidak ada ===== */
.article-image[src=""],
.article-image:not([src]) {
    display: none;
}

.article-header-no-image {
    display: flex !important;
    align-items: center;
    justify-content: center;
    min-height: 200px;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
    border: 2px dashed rgba(220, 20, 60, 0.3);
}

/* ===== HOVER EFFECTS YANG DISESUAIKAN ===== */
.article-container:hover .article-image {
    transform: scale(1.01); /* Kurangi scale dari 1.02 ke 1.01 */
}

.related-card:hover img {
    transform: scale(1.02); /* Kurangi scale dari 1.05 ke 1.02 */
}

@media (max-width: 360px) {
    .hero-detail h1 {
        font-size: 1.4rem;
        line-height: 1.2;
        padding: 0 0.25rem;
    }

    .article-title {
        font-size: 1.4rem;
        line-height: 1.2;
    }

    .hero-detail-content {
        padding: 0 0.25rem;
    }

    .article-content {
        padding: 1.2rem 0.8rem;
    }

    .meta-item {
        min-width: 120px;
        padding: 0.3rem 0.6rem;
    }

    .meta-item span {
        font-size: 0.8rem;
    }

    .breadcrumb-item.active {
        max-width: 120px;
        font-size: 0.8rem;
    }
}
</style>
@endpush

@section('content')
<!-- Hero Section dengan Perbaikan -->
<section class="hero-detail">
    <div class="hero-detail-content container-safe">
        <!-- Breadcrumb dengan Perbaikan Overflow -->
        <nav class="breadcrumb-nav no-overflow">
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

        <!-- Title dengan Perbaikan Text Wrapping -->
        <h1 class="text-wrap container-safe">{{ $berita->judul }}</h1>

        <!-- Meta Information dengan Layout Responsif -->
        <div class="hero-detail-meta container-safe">
            <div class="meta-item">
                <i class="fas fa-user"></i>
                <span title="{{ $berita->admin->nama_lengkap ?? 'Admin' }}">
                    {{ Str::limit($berita->admin->nama_lengkap ?? 'Admin', 20) }}
                </span>
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

<!-- Main Content dengan Container yang Aman -->
<div class="main-content container-safe">
    <main>
        <!-- Article Container dengan Perbaikan -->
        <article class="article-container container-safe">
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

            <!-- Article Content dengan Perbaikan Text Wrapping -->
            <div class="article-content container-safe">
                <!-- Article Title dengan Text Wrapping -->
                <h1 class="article-title text-wrap container-safe">{{ $berita->judul }}</h1>

                <!-- Article Meta Detail -->
                <div class="article-meta-detail">
                    <div class="meta-detail-item">
                        <i class="fas fa-user"></i>
                        <span>
                            <strong>Penulis:</strong>
                            <span class="text-wrap">{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span>
                        </span>
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

                <!-- Article Body dengan Text Wrapping -->
                <div class="article-body text-wrap container-safe">
                    {!! nl2br(e($berita->konten)) !!}
                </div>

                <!-- Tags Section dengan Perbaikan -->
                @if($berita->tags)
                <div class="tags-section container-safe">
                    <h6 class="tags-title">
                        <i class="fas fa-tags"></i>
                        Tags:
                    </h6>
                    <div class="text-wrap">
                        @foreach($berita->tagsArray as $tag)
                        <a href="{{ route('berita', ['search' => trim($tag)]) }}" class="tag-item text-wrap">
                            {{ trim($tag) }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Share Section -->
                <div class="share-section container-safe">
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
            <div class="navigation-section container-safe">
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

        <!-- Related News Section dengan Perbaikan -->
        @if($relatedBerita->count() > 0)
        <section class="related-section container-safe">
            <h2 class="section-title">
                <i class="fas fa-newspaper"></i>
                Berita Terkait
            </h2>
            <div class="related-grid">
                @foreach($relatedBerita as $related)
                <article class="related-card container-safe">
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
                    <div class="related-content container-safe">
                        <h3 class="related-title text-wrap">
                            <a href="{{ route('berita.detail', $related->slug) }}">
                                {{ $related->judul }}
                            </a>
                        </h3>
                        <p class="related-excerpt text-wrap">
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

    <!-- Sidebar dengan Perbaikan -->
    <aside class="sidebar container-safe">
        <!-- Latest News Widget -->
        <div class="sidebar-widget container-safe">
            <h5 class="sidebar-title">
                <i class="fas fa-clock"></i>
                Berita Terbaru
            </h5>
            @forelse($latestBerita as $latest)
            <div class="news-item container-safe">
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
                <div class="news-content container-safe">
                    <h6 class="text-wrap">
                        <a href="{{ route('berita.detail', $latest->slug) }}">
                            {{ $latest->judul }}
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
        <div class="sidebar-widget container-safe">
            <h5 class="sidebar-title">
                <i class="fas fa-fire"></i>
                Berita Populer
            </h5>
            @forelse($popularBerita as $index => $popular)
            <div class="popular-item container-safe">
                <div class="popular-number">{{ $index + 1 }}</div>
                <div class="popular-content container-safe">
                    <h6 class="text-wrap">
                        <a href="{{ route('berita.detail', $popular->slug) }}">
                            {{ $popular->judul }}
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
        <div class="sidebar-widget container-safe">
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
        <div class="sidebar-widget container-safe">
            <h5 class="sidebar-title">
                <i class="fas fa-info-circle"></i>
                Info Artikel
            </h5>
            <div class="info-section container-safe">
                <p><strong>Kategori:</strong> <span>{{ ucfirst($berita->kategori) }}</span></p>
                <p><strong>Tanggal:</strong> <span>{{ $berita->tanggal->format('d F Y') }}</span></p>
                <p><strong>Views:</strong> <span>{{ number_format($berita->views) }}</span></p>
                <p><strong>Penulis:</strong> <span class="text-wrap">{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span></p>
                @if($berita->tags)
                <p><strong>Tags:</strong> <span>{{ count($berita->tagsArray) }} tags</span></p>
                @endif
            </div>
        </div>
    </aside>
</div>

<!-- Tambahkan section ini setelah related-section di detail-berita.blade.php -->

<!-- Comments Section -->
<section class="comments-section container-safe" style="margin-top: 3rem;">
    <div class="comments-container">
        <!-- Comments Header -->
        <div class="comments-header">
            <h2 class="section-title">
                <i class="fas fa-comments"></i>
                Komentar (<span id="comment-count">{{ $berita->komentarAktif->count() }}</span>)
            </h2>
            <div class="comment-stats">
                <div class="stat-item">
                    <i class="fas fa-star"></i>
                    <span>Rating:
                        <strong id="average-rating">
                            @php
                                $avgRating = $berita->komentarAktif->where('rating', '!=', null)->avg('rating');
                                echo $avgRating ? number_format($avgRating, 1) : 'N/A';
                            @endphp
                        </strong>
                    </span>
                </div>
            </div>
        </div>

        <!-- Comment Form -->
        <div class="comment-form-section">
            <h4 class="form-title">
                <i class="fas fa-edit"></i>
                Tulis Komentar
            </h4>
            <form id="comment-form" class="comment-form">
                @csrf
                <input type="hidden" id="parent_id" name="parent_id" value="">

                <div class="form-row">
                    <div class="form-group">
                        <label for="nama">Nama Lengkap *</label>
                        <input type="text" id="nama" name="nama" required maxlength="100"
                               placeholder="Masukkan nama lengkap Anda">
                        <div class="error-message" id="error-nama"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" id="email" name="email" required maxlength="100"
                               placeholder="contoh@email.com">
                        <div class="error-message" id="error-email"></div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telepon">No. Telepon (Opsional)</label>
                    <input type="tel" id="telepon" name="telepon" maxlength="20"
                           placeholder="08xxxxxxxxxx">
                    <div class="error-message" id="error-telepon"></div>
                </div>

                <div class="form-group">
                    <label for="rating">Rating Artikel (Opsional)</label>
                    <div class="rating-input">
                        <input type="hidden" id="rating" name="rating" value="">
                        <div class="stars" id="rating-stars">
                            <span data-rating="1"><i class="far fa-star"></i></span>
                            <span data-rating="2"><i class="far fa-star"></i></span>
                            <span data-rating="3"><i class="far fa-star"></i></span>
                            <span data-rating="4"><i class="far fa-star"></i></span>
                            <span data-rating="5"><i class="far fa-star"></i></span>
                        </div>
                        <small class="rating-text">Klik bintang untuk memberikan rating</small>
                    </div>
                </div>

                <div class="form-group">
                    <label for="komentar">Komentar *</label>
                    <textarea id="komentar" name="komentar" required maxlength="1000" rows="5"
                              placeholder="Tulis komentar Anda tentang artikel ini..."></textarea>
                    <div class="char-counter">
                        <span id="char-count">0</span>/1000 karakter
                    </div>
                    <div class="error-message" id="error-komentar"></div>
                </div>

                <div class="form-actions">
                    <button type="button" id="cancel-reply" class="btn-cancel" style="display: none;">
                        <i class="fas fa-times"></i>
                        Batal Balas
                    </button>
                    <button type="submit" id="submit-comment" class="btn-submit">
                        <i class="fas fa-paper-plane"></i>
                        <span class="button-text">Kirim Komentar</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Comments List -->
        <div class="comments-list" id="comments-list">
            @forelse($berita->komentarAktif->whereNull('parent_id')->sortByDesc('created_at') as $komentar)
                <div class="comment-item" data-comment-id="{{ $komentar->id }}">
                    <div class="comment-avatar">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($komentar->nama, 0, 2)) }}
                        </div>
                    </div>

                    <div class="comment-content">
                        <div class="comment-header">
                            <h6 class="commenter-name">{{ $komentar->nama }}</h6>
                            <div class="comment-meta">
                                @if($komentar->rating)
                                    <div class="comment-rating">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="fas fa-star {{ $i <= $komentar->rating ? 'active' : '' }}"></i>
                                        @endfor
                                    </div>
                                @endif
                                <span class="comment-date">
                                    <i class="far fa-clock"></i>
                                    {{ $komentar->created_at->diffForHumans() }}
                                </span>
                            </div>
                        </div>

                        <div class="comment-text">
                            {{ $komentar->komentar }}
                        </div>

                        <div class="comment-actions">
                            <button type="button" class="btn-reply" data-parent-id="{{ $komentar->id }}"
                                    data-parent-name="{{ $komentar->nama }}">
                                <i class="fas fa-reply"></i>
                                Balas
                            </button>
                        </div>

                        <!-- Replies -->
                        @if($komentar->replies->where('status', 'approved')->count() > 0)
                            <div class="comment-replies">
                                @foreach($komentar->replies->where('status', 'approved')->sortBy('created_at') as $reply)
                                    <div class="comment-reply" data-comment-id="{{ $reply->id }}">
                                        <div class="comment-avatar">
                                            <div class="avatar-circle reply-avatar">
                                                {{ strtoupper(substr($reply->nama, 0, 2)) }}
                                            </div>
                                        </div>

                                        <div class="comment-content">
                                            <div class="comment-header">
                                                <h6 class="commenter-name">{{ $reply->nama }}</h6>
                                                <span class="comment-date">
                                                    <i class="far fa-clock"></i>
                                                    {{ $reply->created_at->diffForHumans() }}
                                                </span>
                                            </div>

                                            <div class="comment-text">
                                                {{ $reply->komentar }}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="no-comments" id="no-comments">
                    <div class="no-comments-icon">
                        <i class="fas fa-comments"></i>
                    </div>
                    <h5>Belum ada komentar</h5>
                    <p>Jadilah yang pertama memberikan komentar untuk artikel ini!</p>
                </div>
            @endforelse
        </div>

        <!-- Load More Comments -->
        @if($berita->komentarAktif->whereNull('parent_id')->count() > 10)
            <div class="load-more-section" style="text-align: center; margin-top: 2rem;">
                <button type="button" id="load-more-comments" class="btn-load-more">
                    <i class="fas fa-chevron-down"></i>
                    Muat Komentar Lainnya
                </button>
            </div>
        @endif
    </div>
</section>

<!-- Include Footer -->
    @include('layouts.footer')
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    // ===== FUNGSI UTAMA: PREVENT HORIZONTAL OVERFLOW =====
    function preventHorizontalOverflow() {
        // 1. Pastikan body tidak overflow horizontal
        document.body.style.overflowX = 'hidden';
        document.documentElement.style.overflowX = 'hidden';
        const commentForm = document.getElementById('comment-form');
        const ratingStars = document.querySelectorAll('#rating-stars span');
        const ratingInput = document.getElementById('rating');
        const charCount = document.getElementById('char-count');
        const komentarTextarea = document.getElementById('komentar');
        const cancelReplyBtn = document.getElementById('cancel-reply');
        const parentIdInput = document.getElementById('parent_id');
        const submitButton = document.getElementById('submit-comment');
        const buttonText = submitButton.querySelector('.button-text');

    let isReplying = false;
    let currentRating = 0;

    // ===== RATING SYSTEM =====
    ratingStars.forEach((star, index) => {
        star.addEventListener('click', function() {
            const rating = parseInt(this.dataset.rating);
            setRating(rating);
        });

        star.addEventListener('mouseenter', function() {
            const rating = parseInt(this.dataset.rating);
            highlightStars(rating);
        });
    });

    document.getElementById('rating-stars').addEventListener('mouseleave', function() {
        highlightStars(currentRating);
    });

    function setRating(rating) {
        currentRating = rating;
        ratingInput.value = rating;
        highlightStars(rating);

        // Update rating text
        const ratingText = document.querySelector('.rating-text');
        const ratingLabels = ['', 'Sangat Buruk', 'Buruk', 'Cukup', 'Baik', 'Sangat Baik'];
        ratingText.textContent = `Rating: ${ratingLabels[rating]} (${rating}/5)`;
    }

    function highlightStars(rating) {
        ratingStars.forEach((star, index) => {
            const starIcon = star.querySelector('i');
            if (index < rating) {
                starIcon.className = 'fas fa-star';
                star.classList.add('active');
            } else {
                starIcon.className = 'far fa-star';
                star.classList.remove('active');
            }
        });
    }

    // ===== CHARACTER COUNTER =====
    komentarTextarea.addEventListener('input', function() {
        const currentLength = this.value.length;
        charCount.textContent = currentLength;

        if (currentLength > 900) {
            charCount.style.color = '#dc3545';
        } else if (currentLength > 700) {
            charCount.style.color = '#ffc107';
        } else {
            charCount.style.color = '#666';
        }
    });

    // ===== REPLY FUNCTIONALITY =====
    document.addEventListener('click', function(e) {
        if (e.target.closest('.btn-reply')) {
            const replyBtn = e.target.closest('.btn-reply');
            const parentId = replyBtn.dataset.parentId;
            const parentName = replyBtn.dataset.parentName;
            startReply(parentId, parentName);
        }
    });

    cancelReplyBtn.addEventListener('click', function() {
        cancelReply();
    });

    function startReply(parentId, parentName) {
        isReplying = true;
        parentIdInput.value = parentId;
        cancelReplyBtn.style.display = 'inline-flex';
        buttonText.textContent = 'Kirim Balasan';

        // Add reply info
        let replyInfo = document.querySelector('.reply-info');
        if (!replyInfo) {
            replyInfo = document.createElement('div');
            replyInfo.className = 'reply-info';
            commentForm.insertBefore(replyInfo, commentForm.firstChild);
        }

        replyInfo.innerHTML = `
            <i class="fas fa-reply"></i>
            Membalas komentar dari <strong>${parentName}</strong>
        `;

        document.querySelector('.comment-form-section').classList.add('replying');

        // Scroll to form
        document.querySelector('.comment-form-section').scrollIntoView({
            behavior: 'smooth',
            block: 'start'
        });

        // Focus on comment textarea
        komentarTextarea.focus();
    }

    function cancelReply() {
        isReplying = false;
        parentIdInput.value = '';
        cancelReplyBtn.style.display = 'none';
        buttonText.textContent = 'Kirim Komentar';

        // Remove reply info
        const replyInfo = document.querySelector('.reply-info');
        if (replyInfo) {
            replyInfo.remove();
        }

        document.querySelector('.comment-form-section').classList.remove('replying');
    }

    // ===== FORM SUBMISSION =====
    commentForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate form
        if (!validateForm()) {
            return;
        }

        // Show loading state
        setLoadingState(true);

        // Prepare form data
        const formData = new FormData(commentForm);

        // Submit comment
        fetch(`/berita/{{ $berita->slug }}/komentar`, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            setLoadingState(false);

            if (data.success) {
                showMessage('success', data.message);
                resetForm();

                // If it's a reply, we might want to refresh the page or add the comment dynamically
                if (isReplying) {
                    setTimeout(() => {
                        window.location.reload(); 
                    }, 2000);
                } else {
                    // Add success message
                    const successHtml = `
                        <div class="comment-pending">
                            <div class="pending-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <h6>Komentar Anda telah dikirim</h6>
                            <p>Komentar sedang menunggu moderasi admin dan akan ditampilkan setelah disetujui.</p>
                        </div>
                    `;

                    const commentsList = document.getElementById('comments-list');
                    const noComments = document.getElementById('no-comments');

                    if (noComments) {
                        commentsList.innerHTML = successHtml;
                    } else {
                        commentsList.insertAdjacentHTML('afterbegin', successHtml);
                    }
                }

            } else {
                showMessage('error', data.message);

                // Show validation errors
                if (data.errors) {
                    showValidationErrors(data.errors);
                }
            }
        })
        .catch(error => {
            setLoadingState(false);
            console.error('Error:', error);
            showMessage('error', 'Terjadi kesalahan saat mengirim komentar. Silakan coba lagi.');
        });
    });

    // ===== VALIDATION =====
    function validateForm() {
        clearErrors();
        let isValid = true;

        const nama = document.getElementById('nama').value.trim();
        const email = document.getElementById('email').value.trim();
        const komentar = document.getElementById('komentar').value.trim();

        if (!nama) {
            showFieldError('nama', 'Nama wajib diisi');
            isValid = false;
        } else if (nama.length > 100) {
            showFieldError('nama', 'Nama maksimal 100 karakter');
            isValid = false;
        }

        if (!email) {
            showFieldError('email', 'Email wajib diisi');
            isValid = false;
        } else if (!isValidEmail(email)) {
            showFieldError('email', 'Format email tidak valid');
            isValid = false;
        } else if (email.length > 100) {
            showFieldError('email', 'Email maksimal 100 karakter');
            isValid = false;
        }

        if (!komentar) {
            showFieldError('komentar', 'Komentar wajib diisi');
            isValid = false;
        } else if (komentar.length > 1000) {
            showFieldError('komentar', 'Komentar maksimal 1000 karakter');
            isValid = false;
        }

        const telepon = document.getElementById('telepon').value.trim();
        if (telepon && telepon.length > 20) {
            showFieldError('telepon', 'Telepon maksimal 20 karakter');
            isValid = false;
        }

        return isValid;
    }

    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    function showFieldError(fieldName, message) {
        const errorElement = document.getElementById(`error-${fieldName}`);
        if (errorElement) {
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        const field = document.getElementById(fieldName);
        if (field) {
            field.style.borderColor = '#dc3545';
        }
    }

    function showValidationErrors(errors) {
        Object.keys(errors).forEach(fieldName => {
            const messages = errors[fieldName];
            if (messages.length > 0) {
                showFieldError(fieldName, messages[0]);
            }
        });
    }

    function clearErrors() {
        document.querySelectorAll('.error-message').forEach(errorElement => {
            errorElement.style.display = 'none';
            errorElement.textContent = '';
        });

        document.querySelectorAll('.form-group input, .form-group textarea').forEach(field => {
            field.style.borderColor = 'rgba(220, 20, 60, 0.2)';
        });
    }

    // ===== UTILITY FUNCTIONS =====
    function setLoadingState(loading) {
        if (loading) {
            submitButton.disabled = true;
            buttonText.innerHTML = '<span class="loading-spinner"></span> Mengirim...';
        } else {
            submitButton.disabled = false;
            buttonText.textContent = isReplying ? 'Kirim Balasan' : 'Kirim Komentar';
        }
    }

    function showMessage(type, message) {
        // Remove existing messages
        document.querySelectorAll('.message').forEach(msg => msg.remove());

        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${type}`;

        const icon = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-triangle';
        messageDiv.innerHTML = `
            <i class="${icon}"></i>
            ${message}
        `;

        commentForm.insertBefore(messageDiv, commentForm.firstChild);

        // Auto remove after 5 seconds
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);

        // Scroll to message
        messageDiv.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    function resetForm() {
        commentForm.reset();
        currentRating = 0;
        ratingInput.value = '';
        charCount.textContent = '0';
        charCount.style.color = '#666';

        // Reset stars
        highlightStars(0);
        document.querySelector('.rating-text').textContent = 'Klik bintang untuk memberikan rating';

        // Reset reply state
        if (isReplying) {
            cancelReply();
        }

        // Clear errors
        clearErrors();
    }

    // ===== LOAD MORE COMMENTS (if needed) =====
    const loadMoreBtn = document.getElementById('load-more-comments');
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function() {
            // Implementation for loading more comments
            // This would require additional backend endpoint
            console.log('Load more comments clicked');
        });
    }

    // ===== AUTO-SAVE DRAFT (Optional Enhancement) =====
    let draftTimer;
    const draftKey = `comment_draft_{{ $berita->id }}`;

    // Load saved draft
    const savedDraft = localStorage.getItem(draftKey);
    if (savedDraft) {
        try {
            const draft = JSON.parse(savedDraft);
            if (draft.nama) document.getElementById('nama').value = draft.nama;
            if (draft.email) document.getElementById('email').value = draft.email;
            if (draft.telepon) document.getElementById('telepon').value = draft.telepon;
            if (draft.komentar) {
                document.getElementById('komentar').value = draft.komentar;
                charCount.textContent = draft.komentar.length;
            }
            if (draft.rating) {
                setRating(draft.rating);
            }
        } catch (e) {
            console.log('Error loading draft:', e);
        }
    }

    // Save draft on input
    ['nama', 'email', 'telepon', 'komentar'].forEach(fieldName => {
        document.getElementById(fieldName).addEventListener('input', function() {
            clearTimeout(draftTimer);
            draftTimer = setTimeout(saveDraft, 1000);
        });
    });

    function saveDraft() {
        const draft = {
            nama: document.getElementById('nama').value,
            email: document.getElementById('email').value,
            telepon: document.getElementById('telepon').value,
            komentar: document.getElementById('komentar').value,
            rating: currentRating
        };

        localStorage.setItem(draftKey, JSON.stringify(draft));
    }

    // Clear draft on successful submission
    function clearDraft() {
        localStorage.removeItem(draftKey);
    }

    // Add clearDraft call to successful submission
    const originalResetForm = resetForm;
    resetForm = function() {
        originalResetForm();
        clearDraft();
    };

    console.log('✅ Comment system loaded successfully');
});

        // 2. Set max-width untuk semua elemen yang potensial bermasalah
        const problematicElements = [
            '.hero-detail h1',
            '.article-title',
            '.breadcrumb-item.active',
            '.article-body',
            '.article-content',
            '.meta-item span'
        ];

        problematicElements.forEach(selector => {
            const elements = document.querySelectorAll(selector);
            elements.forEach(element => {
                element.style.wordWrap = 'break-word';
                element.style.overflowWrap = 'break-word';
                element.style.wordBreak = 'break-word';
                element.style.maxWidth = '100%';
                element.style.boxSizing = 'border-box';
            });
        });
    }

    // ===== FUNGSI: DETECT DAN FIX OVERFLOW ELEMENTS =====
    function detectAndFixOverflow() {
        const allElements = document.querySelectorAll('*');
        const windowWidth = window.innerWidth;

        allElements.forEach(element => {
            const rect = element.getBoundingClientRect();

            if (rect.width > windowWidth) {
                console.warn('Element causing overflow:', element);

                element.style.maxWidth = '100%';
                element.style.wordWrap = 'break-word';
                element.style.overflowWrap = 'break-word';
                element.style.boxSizing = 'border-box';

                if (element.tagName === 'H1' || element.tagName === 'H2' ||
                    element.tagName === 'H3' || element.tagName === 'P') {
                    element.style.wordBreak = 'break-word';
                    element.style.hyphens = 'auto';
                }
            }
        });
    }

    // ===== FUNGSI: RESPONSIVE TEXT SIZING =====
    function responsiveTextSizing() {
        const heroTitle = document.querySelector('.hero-detail h1');
        const articleTitle = document.querySelector('.article-title');

        if (heroTitle) {
            const titleLength = heroTitle.textContent.length;

            if (window.innerWidth <= 480) {
                if (titleLength > 50) {
                    heroTitle.style.fontSize = '1.4rem';
                    heroTitle.style.lineHeight = '1.2';
                } else if (titleLength > 30) {
                    heroTitle.style.fontSize = '1.5rem';
                    heroTitle.style.lineHeight = '1.2';
                }
            } else if (window.innerWidth <= 768) {
                if (titleLength > 50) {
                    heroTitle.style.fontSize = '1.6rem';
                    heroTitle.style.lineHeight = '1.3';
                } else if (titleLength > 30) {
                    heroTitle.style.fontSize = '1.7rem';
                    heroTitle.style.lineHeight = '1.3';
                }
            }
        }

        if (articleTitle) {
            const titleLength = articleTitle.textContent.length;

            if (window.innerWidth <= 480) {
                if (titleLength > 50) {
                    articleTitle.style.fontSize = '1.4rem';
                    articleTitle.style.lineHeight = '1.2';
                } else if (titleLength > 30) {
                    articleTitle.style.fontSize = '1.5rem';
                    articleTitle.style.lineHeight = '1.2';
                }
            } else if (window.innerWidth <= 768) {
                if (titleLength > 50) {
                    articleTitle.style.fontSize = '1.6rem';
                    articleTitle.style.lineHeight = '1.3';
                } else if (titleLength > 30) {
                    articleTitle.style.fontSize = '1.7rem';
                    articleTitle.style.lineHeight = '1.3';
                }
            }
        }
    }

    // ===== FUNGSI: FIX BREADCRUMB OVERFLOW =====
    function fixBreadcrumbOverflow() {
        const activeBreadcrumb = document.querySelector('.breadcrumb-item.active');
        if (activeBreadcrumb) {
            const containerWidth = activeBreadcrumb.closest('.breadcrumb-nav').clientWidth;
            const availableWidth = containerWidth * 0.4;

            activeBreadcrumb.style.maxWidth = availableWidth + 'px';
            activeBreadcrumb.style.overflow = 'hidden';
            activeBreadcrumb.style.textOverflow = 'ellipsis';
            activeBreadcrumb.style.whiteSpace = 'nowrap';
        }
    }

    // ===== FUNGSI: FIX META ITEMS OVERFLOW =====
    function fixMetaItemsOverflow() {
        const metaItems = document.querySelectorAll('.meta-item span');
        metaItems.forEach(item => {
            if (window.innerWidth <= 480) {
                item.style.whiteSpace = 'normal';
                item.style.textAlign = 'center';
                item.style.maxWidth = '120px';
                item.style.fontSize = '0.8rem';
                item.style.wordWrap = 'break-word';
            }
        });
    }

    // ===== FUNGSI: EMERGENCY OVERFLOW FIX =====
    function emergencyOverflowFix() {
        setTimeout(() => {
            if (document.body.scrollWidth > document.body.clientWidth) {
                console.warn('Horizontal overflow detected, applying emergency fix');

                const style = document.createElement('style');
                style.textContent = `
                    * {
                        max-width: 100% !important;
                        box-sizing: border-box !important;
                        word-wrap: break-word !important;
                        overflow-wrap: break-word !important;
                    }
                    body, html {
                        overflow-x: hidden !important;
                    }
                    .hero-detail h1, .article-title {
                        word-break: break-word !important;
                        hyphens: auto !important;
                        white-space: normal !important;
                    }
                `;
                document.head.appendChild(style);
            }
        }, 1000);
    }

    // ===== JALANKAN SEMUA FUNGSI =====
    preventHorizontalOverflow();
    detectAndFixOverflow();
    responsiveTextSizing();
    fixBreadcrumbOverflow();
    fixMetaItemsOverflow();
    emergencyOverflowFix();

    // ===== EVENT LISTENERS =====
    let resizeTimer;
    window.addEventListener('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function() {
            preventHorizontalOverflow();
            responsiveTextSizing();
            fixBreadcrumbOverflow();
            fixMetaItemsOverflow();
        }, 250);
    });

    window.addEventListener('orientationchange', function() {
        setTimeout(function() {
            preventHorizontalOverflow();
            responsiveTextSizing();
            fixBreadcrumbOverflow();
            fixMetaItemsOverflow();
        }, 500);
    });

    // ===== READING PROGRESS BAR =====
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

    // ===== SHARE BUTTONS =====
    document.querySelectorAll('.share-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const platform = this.classList.contains('share-facebook') ? 'Facebook' :
                            this.classList.contains('share-twitter') ? 'Twitter' :
                            this.classList.contains('share-whatsapp') ? 'WhatsApp' : 'Email';
            console.log(`Shared to ${platform}: {{ $berita->judul ?? "Article" }}`);
        });
    });

    console.log('✅ Overflow prevention script loaded successfully');
});
</script>
@endpush
