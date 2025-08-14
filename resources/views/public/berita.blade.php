@extends('layouts.app')

@section('title', 'Berita Terkini - Nagari Mungo')
@section('meta_description', 'Informasi terbaru dan terupdate seputar Nagari Mungo dan sekitarnya')

@push('styles')
<style>
    /* Hero Section for Berita */
    .hero-berita {
        background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
        padding: 12rem 0 6rem;
        text-align: center;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .hero-berita::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.05"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.03"/><polygon points="600,50 650,100 600,150 550,100" fill="white" opacity="0.04"/></svg>');
        animation: gentleFloat 20s infinite linear;
    }

    @keyframes gentleFloat {
        0% { transform: translateX(-50px) translateY(-30px); }
        50% { transform: translateX(30px) translateY(20px); }
        100% { transform: translateX(-50px) translateY(-30px); }
    }

    .hero-content {
        max-width: 800px;
        margin: 0 auto;
        position: relative;
        z-index: 2;
        padding: 0 2rem;
    }

    .hero-berita h1 {
        font-size: 3rem;
        font-weight: 700;
        margin-bottom: 1rem;
        text-shadow: 0 4px 20px rgba(0,0,0,0.3);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-berita p {
        font-size: 1.3rem;
        opacity: 0.95;
        margin-bottom: 2rem;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }

    @keyframes fadeInUp {
        0% { opacity: 0; transform: translateY(30px); }
        100% { opacity: 1; transform: translateY(0); }
    }

    /* Search & Filter Section */
    .search-filter {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        margin-top: 3rem;
        box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
        border: 1px solid rgba(220, 20, 60, 0.1);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        position: relative;
    }

    .search-filter.has-filter {
        border: 2px solid rgba(220, 20, 60, 0.2);
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.02), rgba(220, 20, 60, 0.01));
    }

    .search-filter.has-filter::before {
        content: 'Filter aktif';
        position: absolute;
        top: -10px;
        left: 20px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.2rem 0.8rem;
        border-radius: 10px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .search-form {
        display: grid;
        grid-template-columns: 1fr auto auto;
        gap: 1rem;
        align-items: center;
    }

    .search-input {
        padding: 1rem 1.5rem;
        border: 2px solid rgba(220, 20, 60, 0.2);
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        background: rgba(255, 245, 245, 0.5);
    }

    .search-input:focus {
        outline: none;
        border-color: #DC143C;
        background: white;
        box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.1);
    }

    .category-select {
        padding: 1rem 1.5rem;
        border: 2px solid rgba(220, 20, 60, 0.2);
        border-radius: 50px;
        background: rgba(255, 245, 245, 0.5);
        font-size: 1rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-select:focus {
        outline: none;
        border-color: #DC143C;
        background: white;
    }

    .search-btn {
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        color: white;
        border: none;
        padding: 1rem 2rem;
        border-radius: 50px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
    }

    .search-btn:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
    }

    .clear-filter-btn {
        color: #DC143C !important;
        text-decoration: none;
        font-size: 0.9rem;
        transition: all 0.3s ease;
    }

    .clear-filter-btn:hover {
        color: #FF6B6B !important;
        transform: scale(1.05);
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

    /* Featured Berita */
    .featured-section {
        margin-bottom: 3rem;
    }

    .section-title {
        font-size: 2rem;
        color: #333;
        margin-bottom: 2rem;
        font-weight: 700;
        position: relative;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .section-title::after {
        content: '';
        position: absolute;
        bottom: -8px;
        left: 0;
        width: 80px;
        height: 4px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        border-radius: 2px;
    }

    .featured-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr;
        gap: 2rem;
        margin-bottom: 3rem;
    }

    .featured-main {
        position: relative;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
    }

    .featured-main:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 25px 60px rgba(220, 20, 60, 0.2);
    }

    .featured-main img {
        width: 100%;
        height: 300px;
        object-fit: cover;
    }

    .featured-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(transparent, rgba(0,0,0,0.8));
        color: white;
        padding: 2rem;
    }

    .featured-category {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 0.8rem;
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
    }

    .featured-title {
        font-size: 1.3rem;
        font-weight: 700;
        margin-bottom: 0.8rem;
        line-height: 1.3;
    }

    .featured-meta {
        font-size: 0.9rem;
        opacity: 0.9;
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .featured-side {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .featured-small {
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(220, 20, 60, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
    }

    .featured-small:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(220, 20, 60, 0.15);
    }

    .featured-small img {
        width: 100%;
        height: 120px;
        object-fit: cover;
    }

    .featured-small-content {
        padding: 1rem;
    }

    .featured-small-title {
        font-size: 0.95rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.5rem;
        line-height: 1.3;
    }

    .featured-small-meta {
        font-size: 0.8rem;
        color: #DC143C;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* Berita Grid */
    .berita-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    .berita-card {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        position: relative;
        border: 1px solid rgba(220, 20, 60, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .berita-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        transform: scaleX(0);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        transform-origin: left;
    }

    .berita-card:hover::before {
        transform: scaleX(1);
    }

    .berita-card:hover {
        transform: translateY(-10px) scale(1.02);
        box-shadow: 0 20px 50px rgba(220, 20, 60, 0.2);
    }

    .berita-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .berita-card:hover img {
        transform: scale(1.05);
    }

    .berita-content {
        padding: 1.5rem;
    }

    .berita-category {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 600;
        display: inline-block;
        margin-bottom: 1rem;
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
    }

    .berita-title {
        font-size: 1.2rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 0.8rem;
        line-height: 1.4;
        transition: color 0.3s ease;
    }

    .berita-card:hover .berita-title {
        color: #DC143C;
    }

    .berita-excerpt {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .berita-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
        color: #999;
        margin-bottom: 1rem;
    }

    .berita-author {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #DC143C;
    }

    .berita-read-more {
        background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        color: white;
        padding: 0.8rem 1.5rem;
        border-radius: 50px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
    }

    .berita-read-more:hover {
        transform: translateY(-3px) scale(1.05);
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
        color: white;
    }

    /* Sidebar */
    .sidebar {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
        height: fit-content;
        position: sticky;
        top: 120px;
        border: 1px solid rgba(220, 20, 60, 0.05);
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
    }

    .sidebar-section {
        margin-bottom: 2rem;
    }

    .sidebar-title {
        font-size: 1.3rem;
        font-weight: 700;
        color: #333;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid rgba(220, 20, 60, 0.1);
        position: relative;
    }

    .sidebar-title::after {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 40px;
        height: 2px;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
    }

    .category-list {
        list-style: none;
    }

    .category-item {
        margin-bottom: 0.5rem;
    }

    .category-link {
        color: #666;
        text-decoration: none;
        padding: 0.8rem 1rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 10px;
        position: relative;
        overflow: hidden;
    }

    .category-link::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        transition: left 0.3s ease;
    }

    .category-link:hover {
        color: #DC143C;
        transform: translateX(8px);
    }

    .category-link:hover::before {
        left: 0;
    }

    .category-link.active {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        color: #DC143C !important;
        transform: translateX(8px);
        border-left: 4px solid #DC143C;
        font-weight: 600;
    }

    .category-link.active::before {
        left: 0;
    }

    .category-count {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        padding: 0.2rem 0.5rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 600;
        margin-left: auto;
    }

    .info-section {
        background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
        padding: 1.5rem;
        border-radius: 15px;
        color: #666;
        font-size: 0.9rem;
        line-height: 1.6;
    }

    .info-section p {
        margin-bottom: 0.5rem;
    }

    .info-section strong {
        color: #DC143C;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        list-style: none;
    }

    .pagination a, .pagination span {
        padding: 0.8rem 1.2rem;
        border-radius: 10px;
        text-decoration: none;
        color: #666;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(220, 20, 60, 0.1);
    }

    .pagination a:hover {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
    }

    .pagination .active span {
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        color: white;
        box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
        animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .empty-state i {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.3;
        color: #DC143C;
    }

    .empty-state h3 {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
        color: #333;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-berita h1 {
            font-size: 2rem;
        }

        .hero-berita p {
            font-size: 1.1rem;
        }

        .search-form {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .main-content {
            grid-template-columns: 1fr;
            gap: 2rem;
            padding: 2rem 1rem;
        }

        .featured-grid {
            grid-template-columns: 1fr;
        }

        .featured-side {
            grid-template-columns: 1fr 1fr;
            display: grid;
        }

        .berita-grid {
            grid-template-columns: 1fr;
        }

        .sidebar {
            position: static;
        }
    }

    @media (max-width: 480px) {
        .hero-content {
            padding: 0 1rem;
        }

        .search-filter {
            margin: 2rem 1rem;
            padding: 1.5rem;
        }

        .featured-side {
            grid-template-columns: 1fr;
        }

        .hero-berita h1 {
            font-size: 1.8rem;
        }

        .category-link.active {
            transform: translateX(5px);
        }
    }

    @media (max-width: 360px) {
        .hero-berita h1 {
            font-size: 1.6rem;
        }
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="hero-berita">
        <div class="hero-content">
            <h1>Berita Terkini</h1>
            <p>Informasi terbaru dan terupdate seputar Nagari Mungo dan sekitarnya</p>
            
            <!-- Search & Filter -->
            <div class="search-filter {{ (request('search') || request('kategori')) ? 'has-filter' : '' }}">
                <form class="search-form" method="GET" action="{{ route('berita') }}">
                    <input 
                        type="text" 
                        name="search" 
                        class="search-input" 
                        placeholder="Cari berita..." 
                        value="{{ request('search') }}"
                    >
                    <select name="kategori" class="category-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </form>
                
                @if(request('search') || request('kategori'))
                <div style="margin-top: 1rem; text-align: center;">
                    <a href="{{ route('berita') }}" class="clear-filter-btn">
                        <i class="fas fa-times"></i> Hapus Filter
                    </a>
                </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <!-- Featured Berita -->
            @if($featuredBerita->count() > 0 && !request('search') && !request('kategori'))
            <section class="featured-section">
                <h2 class="section-title">Berita Unggulan</h2>
                <div class="featured-grid">
                    <article class="featured-main">
                        <img src="{{ $featuredBerita->first()->gambar }}" alt="{{ $featuredBerita->first()->alt_gambar }}">
                        <div class="featured-overlay">
                            <span class="featured-category">{{ ucfirst($featuredBerita->first()->kategori) }}</span>
                            <h3 class="featured-title">{{ $featuredBerita->first()->judul }}</h3>
                            <div class="featured-meta">
                                <span><i class="fas fa-calendar"></i> {{ $featuredBerita->first()->tanggal->format('d F Y') }}</span>
                                <span><i class="fas fa-user"></i> {{ $featuredBerita->first()->admin->nama_lengkap }}</span>
                                <span><i class="fas fa-eye"></i> {{ $featuredBerita->first()->views }} views</span>
                            </div>
                        </div>
                    </article>
                    
                    <div class="featured-side">
                        @foreach($featuredBerita->skip(1)->take(2) as $featured)
                        <article class="featured-small">
                            <img src="{{ $featured->gambar }}" alt="{{ $featured->alt_gambar }}">
                            <div class="featured-small-content">
                                <h4 class="featured-small-title">{{ Str::limit($featured->judul, 60) }}</h4>
                                <div class="featured-small-meta">
                                    <i class="fas fa-calendar"></i> {{ $featured->tanggal->format('d M Y') }}
                                </div>
                            </div>
                        </article>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif

            <!-- Berita List -->
            <section>
                <h2 class="section-title">
                    @if(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @elseif(request('kategori'))
                        Kategori: {{ ucfirst(request('kategori')) }}
                    @else
                        Semua Berita
                    @endif
                </h2>

                @if($berita->count() > 0)
                    <div class="berita-grid">
                        @foreach($berita as $item)
                        <article class="berita-card">
                            <img src="{{ $item->gambar }}" alt="{{ $item->alt_gambar }}">
                            <div class="berita-content">
                                <span class="berita-category">{{ ucfirst($item->kategori) }}</span>
                                <h3 class="berita-title">{{ $item->judul }}</h3>
                                <p class="berita-excerpt">{{ $item->excerpt }}</p>
                                <div class="berita-meta">
                                    <div class="berita-author">
                                        <i class="fas fa-user"></i>
                                        {{ $item->admin->nama_lengkap }}
                                    </div>
                                    <div>
                                        <i class="fas fa-calendar"></i>
                                        {{ $item->tanggal->format('d M Y') }}
                                    </div>
                                </div>
                                <a href="{{ route('berita.detail', $item->slug) }}" class="berita-read-more">
                                    Baca Selengkapnya
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $berita->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-newspaper"></i>
                        <h3>Tidak ada berita yang ditemukan</h3>
                        <p>Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                    </div>
                @endif
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Kategori</h3>
                <ul class="category-list">
                    <li class="category-item">
                        <a href="{{ route('berita') }}" class="category-link {{ !request('kategori') ? 'active' : '' }}">
                            <span>
                                <i class="fas fa-list"></i> Semua Kategori
                            </span>
                            <span class="category-count">{{ $totalBerita ?? $berita->total() }}</span>
                        </a>
                    </li>
                    @if(isset($categoriesWithCounts))
                        @foreach($categoriesWithCounts as $key => $data)
                        <li class="category-item">
                            <a href="{{ route('berita.kategori', $key) }}" 
                               class="category-link {{ request('kategori') == $key ? 'active' : '' }}">
                                <span>
                                    <i class="fas fa-tag"></i> {{ $data['label'] }}
                                </span>
                                @if($data['count'] > 0)
                                    <span class="category-count">{{ $data['count'] }}</span>
                                @endif
                            </a>
                        </li>
                        @endforeach
                    @else
                        @foreach($categories as $key => $label)
                        <li class="category-item">
                            <a href="{{ route('berita.kategori', $key) }}" 
                               class="category-link {{ request('kategori') == $key ? 'active' : '' }}">
                                <span>
                                    <i class="fas fa-tag"></i> {{ $label }}
                                </span>
                            </a>
                        </li>
                        @endforeach
                    @endif
                </ul>
            </div>

            <div class="sidebar-section">
                <h3 class="sidebar-title">Info</h3>
                <div class="info-section">
                    <p><strong>Total Berita:</strong> {{ $berita->total() }}</p>
                    <p><strong>Halaman:</strong> {{ $berita->currentPage() }} dari {{ $berita->lastPage() }}</p>
                    <p><strong>Kategori:</strong> {{ $categories->count() }} kategori tersedia</p>
                    @if(request('kategori'))
                        <p><strong>Kategori Aktif:</strong> {{ $categories[request('kategori')] ?? 'Tidak diketahui' }}</p>
                    @endif
                    @if(request('search'))
                        <p><strong>Pencarian:</strong> "{{ request('search') }}"</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>
@endsection

@push('scripts')
<script>
    // Search form enhancement
    document.querySelector('.search-form').addEventListener('submit', function(e) {
        const submitBtn = e.target.querySelector('.search-btn');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.innerHTML = '<div class="loading"></div> Mencari...';
        submitBtn.disabled = true;
        
        // Reset button setelah 3 detik jika masih loading
        setTimeout(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        }, 3000);
    });
</script>
@endpush