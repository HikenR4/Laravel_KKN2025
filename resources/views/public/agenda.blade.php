{{-- resources/views/public/agenda.blade.php --}}
@extends('layouts.app')

@section('title', 'Agenda Kegiatan - Nagari Mungo')
@section('meta_description', 'Lihat jadwal kegiatan dan agenda terbaru Nagari Mungo. Ikuti berbagai kegiatan masyarakat, rapat, sosialisasi, dan acara penting lainnya.')

@push('styles')
<style>
    /* Agenda Public Page Styles */
    .agenda-hero {
        background: linear-gradient(135deg, #1e40af 0%, #1e3a8a 100%);
        color: white;
        padding: 4rem 0 2rem;
        position: relative;
        overflow: hidden;
    }

    .agenda-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="calendar-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><rect width="20" height="20" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/><circle cx="10" cy="10" r="2" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23calendar-pattern)"/></svg>');
        opacity: 0.3;
    }

    .agenda-hero-content {
        position: relative;
        z-index: 2;
        text-align: center;
    }

    .agenda-hero h1 {
        font-size: 3rem;
        font-weight: 800;
        margin-bottom: 1rem;
        text-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }

    .agenda-hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 600px;
        margin: 0 auto 2rem;
    }

    .agenda-filters {
        background: white;
        padding: 2rem;
        border-radius: 15px;
        box-shadow: 0 8px 30px rgba(30, 64, 175, 0.15);
        margin: -2rem 2rem 3rem;
        position: relative;
        z-index: 3;
    }

    .filter-section {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr auto;
        gap: 1rem;
        align-items: end;
    }

    .filter-group {
        display: flex;
        flex-direction: column;
    }

    .filter-label {
        font-weight: 600;
        color: #374151;
        margin-bottom: 0.5rem;
        font-size: 0.875rem;
    }

    .filter-input {
        padding: 0.75rem 1rem;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .filter-input:focus {
        outline: none;
        border-color: #1e40af;
        box-shadow: 0 0 0 3px rgba(30, 64, 175, 0.1);
    }

    .search-btn {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        color: white;
        border: none;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        height: fit-content;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(30, 64, 175, 0.3);
    }

    .agenda-grid {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: 2rem;
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
    }

    .agenda-main {
        min-height: 400px;
    }

    .agenda-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }

    .agenda-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
    }

    .agenda-card-header {
        padding: 1.5rem 1.5rem 0;
    }

    .agenda-meta {
        display: flex;
        gap: 1rem;
        margin-bottom: 1rem;
        flex-wrap: wrap;
    }

    .agenda-date {
        background: linear-gradient(135deg, #1e40af, #1e3a8a);
        color: white;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .agenda-category {
        background: #f1f5f9;
        color: #64748b;
        padding: 0.5rem 1rem;
        border-radius: 25px;
        font-size: 0.875rem;
        font-weight: 600;
    }

    .agenda-status {
        padding: 0.25rem 0.75rem;
        border-radius: 15px;
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
    }

    .status-planned {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-ongoing {
        background: #fed7aa;
        color: #ea580c;
    }

    .status-completed {
        background: #dcfce7;
        color: #16a34a;
    }

    .agenda-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }

    .agenda-title a {
        text-decoration: none;
        color: inherit;
        transition: color 0.3s ease;
    }

    .agenda-title a:hover {
        color: #1e40af;
    }

    .agenda-description {
        color: #6b7280;
        line-height: 1.6;
        margin-bottom: 1rem;
    }

    .agenda-details {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding: 1rem 1.5rem;
        background: #f8fafc;
    }

    .detail-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #64748b;
        font-size: 0.875rem;
    }

    .detail-icon {
        color: #1e40af;
        width: 16px;
    }

    .agenda-card-footer {
        padding: 1rem 1.5rem;
        background: #f8fafc;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .read-more-btn {
        background: #1e40af;
        color: white;
        padding: 0.5rem 1.25rem;
        border-radius: 25px;
        text-decoration: none;
        font-weight: 600;
        font-size: 0.875rem;
        transition: all 0.3s ease;
        margin-left: auto;
    }

    .read-more-btn:hover {
        background: #1e3a8a;
        color: white;
        transform: translateY(-2px);
    }

    /* Sidebar Styles */
    .sidebar {
        position: sticky;
        top: 100px;
        height: fit-content;
    }

    .sidebar-card {
        background: white;
        border-radius: 15px;
        padding: 1.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
        margin-bottom: 1.5rem;
        border: 1px solid #e5e7eb;
    }

    .sidebar-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 1rem;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .category-list {
        list-style: none;
        padding: 0;
    }

    .category-item {
        margin-bottom: 0.5rem;
    }

    .category-link {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem;
        background: #f8fafc;
        border-radius: 8px;
        text-decoration: none;
        color: #64748b;
        transition: all 0.3s ease;
        border: 1px solid transparent;
    }

    .category-link:hover,
    .category-link.active {
        background: #1e40af;
        color: white;
        transform: translateX(5px);
    }

    .category-count {
        background: rgba(100, 116, 139, 0.2);
        color: #64748b;
        padding: 0.25rem 0.5rem;
        border-radius: 12px;
        font-size: 0.75rem;
        font-weight: 600;
    }

    .category-link:hover .category-count,
    .category-link.active .category-count {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .upcoming-item {
        padding: 1rem;
        border-left: 4px solid #1e40af;
        background: #f8fafc;
        border-radius: 0 8px 8px 0;
        margin-bottom: 1rem;
        transition: all 0.3s ease;
    }

    .upcoming-item:hover {
        background: #f1f5f9;
        transform: translateX(5px);
    }

    .upcoming-title {
        font-weight: 600;
        color: #1f2937;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        line-height: 1.3;
    }

    .upcoming-date {
        color: #1e40af;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .empty-state {
        text-align: center;
        padding: 4rem 2rem;
        color: #6b7280;
    }

    .empty-icon {
        font-size: 4rem;
        color: #d1d5db;
        margin-bottom: 1rem;
    }

    .pagination-wrapper {
        display: flex;
        justify-content: center;
        margin-top: 3rem;
    }

    .pagination {
        display: flex;
        gap: 0.5rem;
        align-items: center;
    }

    .page-link {
        padding: 0.75rem 1rem;
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        text-decoration: none;
        color: #64748b;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .page-link:hover,
    .page-link.active {
        background: #1e40af;
        border-color: #1e40af;
        color: white;
        transform: translateY(-2px);
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .agenda-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .sidebar {
            position: static;
            top: auto;
        }
    }

    @media (max-width: 768px) {
        .agenda-hero h1 {
            font-size: 2.5rem;
        }

        .agenda-filters {
            margin: -1rem 1rem 2rem;
            padding: 1.5rem;
        }

        .filter-section {
            grid-template-columns: 1fr;
            gap: 1rem;
        }

        .agenda-grid {
            padding: 0 1rem;
        }

        .agenda-details {
            grid-template-columns: 1fr;
        }

        .agenda-meta {
            flex-direction: column;
            gap: 0.5rem;
        }
    }

    /* Animation */
    .fade-in {
        opacity: 0;
        transform: translateY(30px);
        animation: fadeInUp 0.8s ease forwards;
    }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
@endpush

@section('content')
<!-- Hero Section -->
<section class="agenda-hero">
    <div class="agenda-hero-content fade-in">
        <h1>
            @if(isset($selectedKategoriLabel))
                Agenda {{ $selectedKategoriLabel }}
            @else
                Agenda Kegiatan
            @endif
        </h1>
        <p>
            @if(isset($selectedKategoriLabel))
                Lihat semua agenda kategori {{ strtolower($selectedKategoriLabel) }} yang akan datang
            @else
                Ikuti berbagai kegiatan dan acara penting di Nagari Mungo
            @endif
        </p>
    </div>
</section>

<!-- Filter Section -->
<div class="agenda-filters fade-in" style="animation-delay: 0.2s;">
    <form method="GET" action="{{ route('agenda') }}">
        <div class="filter-section">
            <div class="filter-group">
                <label class="filter-label">Cari Agenda</label>
                <input type="text" name="search" class="filter-input"
                       placeholder="Cari berdasarkan judul, deskripsi, atau lokasi..."
                       value="{{ request('search') }}">
            </div>
            <div class="filter-group">
                <label class="filter-label">Kategori</label>
                <select name="kategori" class="filter-input">
                    <option value="">Semua Kategori</option>
                    @foreach($categoriesWithCounts ?? [] as $key => $category)
                        <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                            {{ $category['label'] }} ({{ $category['count'] }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select name="status" class="filter-input">
                    <option value="">Semua Status</option>
                    <option value="planned" {{ request('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                    <option value="ongoing" {{ request('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                    <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Waktu</label>
                <select name="tanggal" class="filter-input">
                    <option value="">Semua Waktu</option>
                    <option value="upcoming" {{ request('tanggal') == 'upcoming' ? 'selected' : '' }}>Akan Datang</option>
                    <option value="today" {{ request('tanggal') == 'today' ? 'selected' : '' }}>Hari Ini</option>
                    <option value="past" {{ request('tanggal') == 'past' ? 'selected' : '' }}>Sudah Berlalu</option>
                </select>
            </div>
            <button type="submit" class="search-btn">
                <i class="fas fa-search"></i>
                Cari
            </button>
        </div>
    </form>
</div>

<!-- Main Content -->
<div class="agenda-grid">
    <!-- Main Agenda List -->
    <main class="agenda-main">
        @if(session('error'))
            <div class="alert alert-danger fade-in">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        @forelse($agenda ?? [] as $index => $item)
            <article class="agenda-card fade-in" style="animation-delay: {{ 0.1 * ($index + 1) }}s;">
                <div class="agenda-card-header">
                    <div class="agenda-meta">
                        <div class="agenda-date">
                            <i class="fas fa-calendar-alt"></i>
                            {{ $item->tanggal_mulai->format('d M Y') }}
                            @if($item->tanggal_selesai && !$item->tanggal_mulai->eq($item->tanggal_selesai))
                                - {{ $item->tanggal_selesai->format('d M Y') }}
                            @endif
                        </div>
                        <div class="agenda-category">
                            <i class="fas fa-tag"></i>
                            {{ ucfirst($item->kategori) }}
                        </div>
                        <div class="agenda-status status-{{ $item->status }}">
                            {{ ucfirst($item->status) }}
                        </div>
                    </div>

                    <h2 class="agenda-title">
                        <a href="{{ route('agenda.detail', $item->slug) }}">
                            {{ $item->judul }}
                        </a>
                    </h2>

                    @if($item->deskripsi)
                        <p class="agenda-description">
                            {{ Str::limit($item->deskripsi, 150) }}
                        </p>
                    @endif
                </div>

                <div class="agenda-details">
                    @if($item->waktu_mulai)
                        <div class="detail-item">
                            <i class="fas fa-clock detail-icon"></i>
                            <span>
                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                                @if($item->waktu_selesai)
                                    - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                                @endif
                                WIB
                            </span>
                        </div>
                    @endif

                    @if($item->lokasi)
                        <div class="detail-item">
                            <i class="fas fa-map-marker-alt detail-icon"></i>
                            <span>{{ Str::limit($item->lokasi, 30) }}</span>
                        </div>
                    @endif

                    @if($item->peserta_target)
                        <div class="detail-item">
                            <i class="fas fa-users detail-icon"></i>
                            <span>{{ number_format($item->peserta_target) }} peserta</span>
                        </div>
                    @endif

                    @if($item->biaya !== null)
                        <div class="detail-item">
                            <i class="fas fa-money-bill-wave detail-icon"></i>
                            <span>
                                @if($item->biaya == 0)
                                    Gratis
                                @else
                                    Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                @endif
                            </span>
                        </div>
                    @endif
                </div>

                <div class="agenda-card-footer">
                    <a href="{{ route('agenda.detail', $item->slug) }}" class="read-more-btn">
                        <i class="fas fa-arrow-right me-1"></i>
                        Lihat Detail
                    </a>
                </div>
            </article>
        @empty
            <div class="empty-state fade-in">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>Tidak Ada Agenda</h3>
                <p>
                    @if(request()->hasAny(['search', 'kategori', 'status', 'tanggal']))
                        Tidak ada agenda yang sesuai dengan filter yang dipilih.
                    @else
                        Belum ada agenda yang tersedia saat ini.
                    @endif
                </p>
                @if(request()->hasAny(['search', 'kategori', 'status', 'tanggal']))
                    <a href="{{ route('agenda') }}" class="read-more-btn" style="margin-top: 1rem;">
                        <i class="fas fa-refresh me-1"></i>
                        Lihat Semua Agenda
                    </a>
                @endif
            </div>
        @endforelse

        <!-- Pagination -->
        @if(isset($agenda) && $agenda->hasPages())
            <div class="pagination-wrapper fade-in">
                <div class="pagination">
                    @if($agenda->onFirstPage())
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-left"></i>
                        </span>
                    @else
                        <a href="{{ $agenda->previousPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-left"></i>
                        </a>
                    @endif

                    @foreach($agenda->getUrlRange(1, $agenda->lastPage()) as $page => $url)
                        @if($page == $agenda->currentPage())
                            <span class="page-link active">{{ $page }}</span>
                        @else
                            <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                        @endif
                    @endforeach

                    @if($agenda->hasMorePages())
                        <a href="{{ $agenda->nextPageUrl() }}" class="page-link">
                            <i class="fas fa-chevron-right"></i>
                        </a>
                    @else
                        <span class="page-link disabled">
                            <i class="fas fa-chevron-right"></i>
                        </span>
                    @endif
                </div>
            </div>
        @endif
    </main>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Categories -->
        @if($categoriesWithCounts ?? false)
            <div class="sidebar-card fade-in" style="animation-delay: 0.4s;">
                <h3 class="sidebar-title">
                    <i class="fas fa-tags text-blue-600"></i>
                    Kategori Agenda
                </h3>
                <ul class="category-list">
                    <li class="category-item">
                        <a href="{{ route('agenda') }}" class="category-link {{ !request('kategori') ? 'active' : '' }}">
                            <span>Semua Kategori</span>
                            <span class="category-count">{{ $agenda->total() ?? 0 }}</span>
                        </a>
                    </li>
                    @foreach($categoriesWithCounts as $key => $category)
                        @if($category['count'] > 0)
                            <li class="category-item">
                                <a href="{{ route('agenda.kategori', $key) }}"
                                   class="category-link {{ request('kategori') == $key ? 'active' : '' }}">
                                    <span>{{ $category['label'] }}</span>
                                    <span class="category-count">{{ $category['count'] }}</span>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Upcoming Agenda -->
        @if($upcomingAgenda ?? false)
            <div class="sidebar-card fade-in" style="animation-delay: 0.6s;">
                <h3 class="sidebar-title">
                    <i class="fas fa-clock text-orange-500"></i>
                    Agenda Mendatang
                </h3>
                @forelse($upcomingAgenda as $upcoming)
                    <div class="upcoming-item">
                        <div class="upcoming-title">
                            <a href="{{ route('agenda.detail', $upcoming->slug) }}" style="text-decoration: none; color: inherit;">
                                {{ Str::limit($upcoming->judul, 50) }}
                            </a>
                        </div>
                        <div class="upcoming-date">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $upcoming->tanggal_mulai->format('d M Y') }}
                            @if($upcoming->waktu_mulai)
                                • {{ \Carbon\Carbon::parse($upcoming->waktu_mulai)->format('H:i') }} WIB
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Tidak ada agenda mendatang</p>
                @endforelse
            </div>
        @endif

        <!-- Featured Agenda -->
        @if($featuredAgenda ?? false)
            <div class="sidebar-card fade-in" style="animation-delay: 0.8s;">
                <h3 class="sidebar-title">
                    <i class="fas fa-star text-yellow-500"></i>
                    Agenda Unggulan
                </h3>
                @forelse($featuredAgenda as $featured)
                    <div class="upcoming-item" style="border-left-color: #f59e0b;">
                        <div class="upcoming-title">
                            <a href="{{ route('agenda.detail', $featured->slug) }}" style="text-decoration: none; color: inherit;">
                                {{ Str::limit($featured->judul, 50) }}
                            </a>
                        </div>
                        <div class="upcoming-date">
                            <i class="fas fa-calendar-alt me-1"></i>
                            {{ $featured->tanggal_mulai->format('d M Y') }}
                            @if($featured->peserta_target)
                                • {{ number_format($featured->peserta_target) }} peserta
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Tidak ada agenda unggulan</p>
                @endforelse
            </div>
        @endif
    </aside>
</div>
<!-- Include Footer -->
    @include('layouts.footer')
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Fade in animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Auto-submit form on filter change
        const filterSelects = document.querySelectorAll('select[name="kategori"], select[name="status"], select[name="tanggal"]');
        filterSelects.forEach(select => {
            select.addEventListener('change', function() {
                this.closest('form').submit();
            });
        });
    });
</script>
@endpush
