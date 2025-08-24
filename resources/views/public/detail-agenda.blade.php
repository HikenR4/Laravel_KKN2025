{{-- resources/views/public/detail-agenda.blade.php --}}
@extends('layouts.app')
@section('title', $agenda->judul . ' - Agenda Nagari Mungo')
@section('meta_description', Str::limit($agenda->deskripsi ?? 'Detail agenda kegiatan ' . $agenda->judul, 160))

@push('styles')
<style>
/* Detail Agenda Public Page Styles - RED THEME */
.agenda-detail-hero {
    background: linear-gradient(135deg, #DC143C 0%, #B22222 100%);
    color: white;
    padding: 3rem 0;
    position: relative;
    overflow: hidden;
}
.agenda-detail-hero::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="detail-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23detail-pattern)"/></svg>');
    opacity: 0.3;
}
.hero-content {
    position: relative;
    z-index: 2;
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
}
.breadcrumb-nav {
    margin-bottom: 2rem;
}
.breadcrumb {
    display: flex;
    gap: 0.5rem;
    align-items: center;
    font-size: 0.9rem;
    flex-wrap: wrap; /* Tambahkan ini */
}
.breadcrumb a {
    color: rgba(255, 255, 255, 0.8);
    text-decoration: none;
    transition: color 0.3s ease;
}
.breadcrumb a:hover {
    color: white;
}
.breadcrumb-separator {
    color: rgba(255, 255, 255, 0.6);
}
.agenda-title {
    font-size: 3rem;
    font-weight: 800;
    line-height: 1.2;
    margin-bottom: 1.5rem;
    text-shadow: 0 2px 10px rgba(0,0,0,0.3);
    word-wrap: break-word; /* Tambahkan ini */
    overflow-wrap: break-word; /* Tambahkan ini */
    hyphens: auto; /* Tambahkan ini */
    white-space: normal; /* Pastikan tidak nowrap */
}
.agenda-meta-row {
    display: flex;
    flex-wrap: wrap;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
    align-items: center;
}

.meta-badge {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    color: white;
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 0.5rem;
    border: 1px solid rgba(255, 255, 255, 0.3);
}

/* STATUS BADGE - CENTERED TEXT FIX */
.status-badge {
    padding: 0.75rem 1.25rem;
    border-radius: 25px;
    font-size: 0.875rem;
    font-weight: 700;
    text-transform: uppercase;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    min-height: 40px;
    line-height: 1;
}
.status-planned {
    background: #FF6B6B;
    color: white;
}
.status-ongoing {
    background: #f59e0b;
    color: white;
}
.status-completed {
    background: #10b981;
    color: white;
}
.main-content {
    max-width: 1200px;
    margin: 0 auto;
    padding: 3rem 2rem 0;
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 3rem;
}
.content-section {
    background: white;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    margin-bottom: 2rem;
    border: 1px solid #e5e7eb;
}
.countdown-section {
    background: linear-gradient(135deg, #f59e0b, #d97706);
    color: white;
    padding: 2rem;
    border-radius: 20px;
    text-align: center;
    margin-bottom: 2rem;
    position: relative;
    overflow: hidden;
}
.countdown-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="20" fill="none" stroke="white" stroke-width="1" opacity="0.1"/></svg>');
    opacity: 0.3;
}
.countdown-title {
    font-size: 1.25rem;
    font-weight: 600;
    margin-bottom: 1.5rem;
    position: relative;
    z-index: 2;
}
.countdown-timer {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    position: relative;
    z-index: 2;
}
.countdown-item {
    background: rgba(255, 255, 255, 0.2);
    backdrop-filter: blur(10px);
    padding: 1rem;
    border-radius: 15px;
    text-align: center;
    border: 1px solid rgba(255, 255, 255, 0.3);
}
.countdown-number {
    font-size: 2rem;
    font-weight: 800;
    display: block;
    line-height: 1;
}
.countdown-label {
    font-size: 0.875rem;
    opacity: 0.9;
    margin-top: 0.5rem;
}
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-bottom: 2rem;
}
.stat-card {
    background: linear-gradient(135deg, #f8fafc, #e2e8f0);
    padding: 1.5rem;
    border-radius: 15px;
    text-align: center;
    border: 1px solid #cbd5e1;
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.stat-number {
    font-size: 2rem;
    font-weight: 800;
    color: #DC143C;
    display: block;
    line-height: 1;
}
.stat-label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    margin-top: 0.5rem;
}
.agenda-image {
    width: 100%;
    max-height: 400px;
    object-fit: cover;
    border-radius: 15px;
    margin-bottom: 2rem;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
}
.content-text {
    font-size: 1.125rem;
    line-height: 1.8;
    color: #374151;
    margin-bottom: 2rem;
}
.info-section {
    background: linear-gradient(135deg, #f1f5f9, #e2e8f0);
    border: 1px solid #cbd5e1;
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
}
.info-title {
    font-size: 1.25rem;
    font-weight: 700;
    color: #DC143C;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1rem;
}
.info-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem;
    background: white;
    border-radius: 10px;
    border: 1px solid #e2e8f0;
}
.info-icon {
    width: 20px;
    color: #DC143C;
    text-align: center;
}
.info-label {
    font-weight: 600;
    color: #64748b;
    min-width: 120px;
}
.info-value {
    color: #1f2937;
    font-weight: 600;
}

/* Sidebar - RED THEME */
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
    font-size: 1.125rem;
    font-weight: 700;
    color: #1f2937;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}
.action-buttons {
    display: grid;
    gap: 0.75rem;
}

.action-btn {
    padding: 0.75rem 1.25rem;
    border-radius: 10px;
    font-weight: 600;
    text-decoration: none;
    text-align: center;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}
.btn-primary {
    background: linear-gradient(135deg, #DC143C, #B22222);
    color: white;
}
.btn-primary:hover {
    background: linear-gradient(135deg, #B22222, #8B0000);
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
    color: white;
}
.btn-secondary {
    background: #f8fafc;
    color: #64748b;
    border: 2px solid #e2e8f0;
}
.btn-secondary:hover {
    background: #64748b;
    color: white;
    border-color: #64748b;
}
.related-item {
    padding: 1rem;
    border-left: 4px solid #DC143C;
    background: #f8fafc;
    border-radius: 0 10px 10px 0;
    margin-bottom: 1rem;
    transition: all 0.3s ease;
}
.related-item:hover {
    background: #f1f5f9;
    transform: translateX(5px);
}
.related-title {
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
    line-height: 1.3;
}
.related-title a {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s ease;
}
.related-title a:hover {
    color: #DC143C;
}
.related-meta {
    color: #64748b;
    font-size: 0.8rem;
    display: flex;
    gap: 1rem;
}

/* RED THEME ICON COLORS */
.text-blue-600 {
    color: #DC143C !important;
}
.text-orange-500 {
    color: #f59e0b !important;
}
.text-green-600 {
    color: #16a34a !important;
}

/* Responsive */
@media (max-width: 1024px) {
    .main-content {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    .sidebar {
        position: static;
        top: auto;
    }
}
@media (max-width: 768px) {
    .agenda-title {
        font-size: 2.5rem; /* Kurangi ukuran font */
        line-height: 1.1; /* Rapihkan line height */
    }   
    .main-content {
        padding: 2rem 1rem 0;
    }
    .hero-content {
        padding: 0 1rem;
    }
    .agenda-meta-row {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    .countdown-timer {
        grid-template-columns: repeat(2, 1fr);
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .info-grid {
        grid-template-columns: 1fr;
    }
    .breadcrumb {
        font-size: 0.8rem;
        gap: 0.3rem;
    }
}
@media (max-width: 480px) {
    .agenda-title {
        font-size: 1.8rem; /* Lebih kecil untuk mobile kecil */
        line-height: 1.1;
        margin-bottom: 1rem;
    }
    .countdown-timer {
        grid-template-columns: repeat(4, 1fr);
        gap: 0.5rem;
    }
    .countdown-item {
        padding: 0.75rem 0.5rem;
    }
    .countdown-number {
        font-size: 1.5rem;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .meta-badge {
        width: 100%;
        justify-content: center;
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
<section class="agenda-detail-hero">
    <div class="hero-content fade-in">
        <!-- Breadcrumb -->
        <nav class="breadcrumb-nav">
            <div class="breadcrumb">
                <a href="{{ url('/') }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <span class="breadcrumb-separator">
                    <i class="fas fa-chevron-right"></i>
                </span>
                <a href="{{ route('agenda') }}">Agenda</a>
                <span class="breadcrumb-separator">
                    <i class="fas fa-chevron-right"></i>
                </span>
                <span>{{ Str::limit($agenda->judul, 30) }}</span>
            </div>
        </nav>

        <!-- Title -->
        <h1 class="agenda-title">{{ $agenda->judul }}</h1>

        <!-- Meta Information -->
        <div class="agenda-meta-row">
            <div class="meta-badge">
                <i class="fas fa-calendar-alt"></i>
                <span>
                    {{ $agenda->tanggal_mulai->format('d F Y') }}
                    @if($agenda->tanggal_selesai && !$agenda->tanggal_mulai->eq($agenda->tanggal_selesai))
                        - {{ $agenda->tanggal_selesai->format('d F Y') }}
                    @endif
                </span>
            </div>

            @if($agenda->waktu_mulai)
                <div class="meta-badge">
                    <i class="fas fa-clock"></i>
                    <span>
                        {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}
                        @if($agenda->waktu_selesai)
                            - {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }}
                        @endif
                        WIB
                    </span>
                </div>
            @endif

            @if($agenda->lokasi)
                <div class="meta-badge">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>{{ $agenda->lokasi }}</span>
                </div>
            @endif

            <div class="meta-badge">
                <i class="fas fa-tag"></i>
                <span>{{ ucfirst($agenda->kategori) }}</span>
            </div>

            <div class="status-badge status-{{ $agenda->status }}">
                {{ ucfirst($agenda->status) }}
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<div class="main-content">
    <!-- Content Area -->
    <main class="content-area">
        <!-- Flash Messages -->
        @if(session('error'))
            <div class="alert alert-danger fade-in">
                <i class="fas fa-exclamation-circle me-2"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Countdown Section (if upcoming) -->
        @if($agenda->tanggal_mulai->isFuture() && $agenda->status !== 'cancelled')
            <div class="countdown-section fade-in" style="animation-delay: 0.2s;">
                <h3 class="countdown-title">Agenda akan dimulai dalam:</h3>
                <div class="countdown-timer" id="countdown">
                    <div class="countdown-item">
                        <span class="countdown-number" id="days">0</span>
                        <span class="countdown-label">Hari</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="jam">0</span>
                        <span class="countdown-label">Jam</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="minutes">0</span>
                        <span class="countdown-label">Menit</span>
                    </div>
                    <div class="countdown-item">
                        <span class="countdown-number" id="seconds">0</span>
                        <span class="countdown-label">Detik</span>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistics -->
        <div class="content-section fade-in" style="animation-delay: 0.3s;">
            <div class="stats-grid">
                @if($agenda->peserta_target)
                    <div class="stat-card">
                        <span class="stat-number">{{ number_format($agenda->peserta_target) }}</span>
                        <span class="stat-label">Target Peserta</span>
                    </div>
                @endif

                @if($agenda->biaya !== null)
                    <div class="stat-card">
                        <span class="stat-number">
                            @if($agenda->biaya == 0)
                                GRATIS
                            @else
                                Rp {{ number_format($agenda->biaya, 0, ',', '.') }}
                            @endif
                        </span>
                        <span class="stat-label">Biaya</span>
                    </div>
                @endif

                <div class="stat-card">
                    <span class="stat-number">
                        {{ $agenda->tanggal_mulai->diffInDays($agenda->tanggal_selesai ?? $agenda->tanggal_mulai) + 1 }}
                    </span>
                    <span class="stat-label">Hari Kegiatan</span>
                </div>

                <div class="stat-card">
                    <span class="stat-number">{{ $agenda->tanggal_mulai->diffForHumans() }}</span>
                    <span class="stat-label">Waktu Relatif</span>
                </div>
            </div>
        </div>

        <!-- Image -->
        @if($agenda->gambar)
            <div class="content-section fade-in" style="animation-delay: 0.4s;">
                <img src="{{ $agenda->gambar }}" 
                     alt="{{ $agenda->alt_gambar ?? $agenda->judul }}" 
                     class="agenda-image">
                @if($agenda->alt_gambar)
                    <p class="text-center text-muted mt-2" style="font-style: italic;">
                        {{ $agenda->alt_gambar }}
                    </p>
                @endif
            </div>
        @endif

        <!-- Description -->
        @if($agenda->deskripsi)
            <div class="content-section fade-in" style="animation-delay: 0.5s;">
                <div class="content-text">
                    {!! nl2br(e($agenda->deskripsi)) !!}
                </div>
            </div>
        @endif

        <!-- Schedule Information -->
        <div class="info-section fade-in" style="animation-delay: 0.6s;">
            <h3 class="info-title">
                <i class="fas fa-calendar-check"></i>
                Jadwal & Informasi Kegiatan
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-calendar-alt info-icon"></i>
                    <span class="info-label">Tanggal Mulai:</span>
                    <span class="info-value">{{ $agenda->tanggal_mulai->format('l, d F Y') }}</span>
                </div>

                @if($agenda->tanggal_selesai && !$agenda->tanggal_mulai->eq($agenda->tanggal_selesai))
                    <div class="info-item">
                        <i class="fas fa-calendar-alt info-icon"></i>
                        <span class="info-label">Tanggal Selesai:</span>
                        <span class="info-value">{{ $agenda->tanggal_selesai->format('l, d F Y') }}</span>
                    </div>
                @endif

                @if($agenda->waktu_mulai)
                    <div class="info-item">
                        <i class="fas fa-clock info-icon"></i>
                        <span class="info-label">Waktu:</span>
                        <span class="info-value">
                            {{ \Carbon\Carbon::parse($agenda->waktu_mulai)->format('H:i') }}
                            @if($agenda->waktu_selesai)
                                - {{ \Carbon\Carbon::parse($agenda->waktu_selesai)->format('H:i') }}
                            @endif
                            WIB
                        </span>
                    </div>
                @endif

                @if($agenda->lokasi)
                    <div class="info-item">
                        <i class="fas fa-map-marker-alt info-icon"></i>
                        <span class="info-label">Lokasi:</span>
                        <span class="info-value">{{ $agenda->lokasi }}</span>
                    </div>
                @endif

                @if($agenda->penanggung_jawab)
                    <div class="info-item">
                        <i class="fas fa-user-tie info-icon"></i>
                        <span class="info-label">Penanggung Jawab:</span>
                        <span class="info-value">{{ $agenda->penanggung_jawab }}</span>
                    </div>
                @endif

                @if($agenda->kontak_person)
                    <div class="info-item">
                        <i class="fas fa-phone info-icon"></i>
                        <span class="info-label">Kontak Person:</span>
                        <span class="info-value">{{ $agenda->kontak_person }}</span>
                    </div>
                @endif

                <div class="info-item">
                    <i class="fas fa-tag info-icon"></i>
                    <span class="info-label">Kategori:</span>
                    <span class="info-value">{{ ucfirst($agenda->kategori) }}</span>
                </div>

                <div class="info-item">
                    <i class="fas fa-toggle-on info-icon"></i>
                    <span class="info-label">Status:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $agenda->status }}">
                            {{ ucfirst($agenda->status) }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
    </main>

    <!-- Sidebar -->
    <aside class="sidebar">
        <!-- Quick Actions -->
        <div class="sidebar-card fade-in" style="animation-delay: 0.7s;">
            <h3 class="sidebar-title">
                <i class="fas fa-bolt text-orange-500"></i>
                Quick Actions
            </h3>
            <div class="action-buttons">
                <a href="{{ route('agenda') }}" class="action-btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Agenda
                </a>
                <button onclick="window.print()" class="action-btn btn-primary">
                    <i class="fas fa-print"></i>
                    Print Agenda
                </button>
                <button onclick="shareAgenda()" class="action-btn btn-secondary">
                    <i class="fas fa-share-alt"></i>
                    Bagikan
                </button>
            </div>
        </div>

        <!-- Agenda Information -->
        <div class="sidebar-card fade-in" style="animation-delay: 0.8s;">
            <h3 class="sidebar-title">
                <i class="fas fa-info-circle text-blue-600"></i>
                Informasi Agenda
            </h3>
            <div class="info-grid">
                <div class="info-item">
                    <i class="fas fa-hashtag info-icon"></i>
                    <span class="info-label">ID Agenda:</span>
                    <span class="info-value">#{{ $agenda->id }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-calendar-plus info-icon"></i>
                    <span class="info-label">Dibuat:</span>
                    <span class="info-value">{{ $agenda->created_at->format('d/m/Y') }}</span>
                </div>
                <div class="info-item">
                    <i class="fas fa-user-edit info-icon"></i>
                    <span class="info-label">Admin:</span>
                    <span class="info-value">{{ $agenda->admin->nama_lengkap ?? 'Admin' }}</span>
                </div>
            </div>
        </div>

        <!-- Related Agenda -->
        @if($relatedAgenda ?? false)
            <div class="sidebar-card fade-in" style="animation-delay: 0.9s;">
                <h3 class="sidebar-title">
                    <i class="fas fa-calendar text-green-600"></i>
                    Agenda Terkait
                </h3>
                @forelse($relatedAgenda as $related)
                    <div class="related-item">
                        <div class="related-title">
                            <a href="{{ route('agenda.detail', $related->slug) }}">
                                {{ Str::limit($related->judul, 60) }}
                            </a>
                        </div>
                        <div class="related-meta">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $related->tanggal_mulai->format('d M Y') }}
                            </span>
                            @if($related->waktu_mulai)
                                <span>
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($related->waktu_mulai)->format('H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Tidak ada agenda terkait</p>
                @endforelse
            </div>
        @endif

        <!-- Upcoming Agenda -->
        @if($upcomingAgenda ?? false)
            <div class="sidebar-card fade-in" style="animation-delay: 1.0s;">
                <h3 class="sidebar-title">
                    <i class="fas fa-clock text-orange-500"></i>
                    Agenda Mendatang
                </h3>
                @forelse($upcomingAgenda as $upcoming)
                    <div class="related-item" style="border-left-color: #f59e0b;">
                        <div class="related-title">
                            <a href="{{ route('agenda.detail', $upcoming->slug) }}">
                                {{ Str::limit($upcoming->judul, 60) }}
                            </a>
                        </div>
                        <div class="related-meta">
                            <span>
                                <i class="fas fa-calendar-alt"></i>
                                {{ $upcoming->tanggal_mulai->format('d M Y') }}
                            </span>
                            @if($upcoming->waktu_mulai)
                                <span>
                                    <i class="fas fa-clock"></i>
                                    {{ \Carbon\Carbon::parse($upcoming->waktu_mulai)->format('H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center">Tidak ada agenda mendatang</p>
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

    // Countdown timer (only if agenda is upcoming)
    @if($agenda->tanggal_mulai->isFuture() && $agenda->status !== 'cancelled')
        const targetDate = new Date('{{ $agenda->tanggal_mulai->format('Y-m-d') }}T{{ $agenda->waktu_mulai ?? '00:00' }}').getTime();
        
        const countdown = setInterval(function() {
            const now = new Date().getTime();
            const distance = targetDate - now;
            
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);
            
            document.getElementById('days').textContent = days >= 0 ? days : 0;
            document.getElementById('hours').textContent = hours >= 0 ? hours : 0;
            document.getElementById('minutes').textContent = minutes >= 0 ? minutes : 0;
            document.getElementById('seconds').textContent = seconds >= 0 ? seconds : 0;
            
            if (distance < 0) {
                clearInterval(countdown);
                document.querySelector('.countdown-section').innerHTML =
                    '<h3 class="countdown-title">Agenda sudah dimulai!</h3>';
            }
        }, 1000);
    @endif
});

// Share function
function shareAgenda() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $agenda->judul }}',
            text: '{{ Str::limit($agenda->deskripsi ?? 'Agenda kegiatan ' . $agenda->judul, 100) }}',
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link agenda telah disalin ke clipboard!');
        }).catch(() => {
            // Manual fallback
            const textArea = document.createElement('textarea');
            textArea.value = window.location.href;
            document.body.appendChild(textArea);
            textArea.select();
            document.execCommand('copy');
            document.body.removeChild(textArea);
            alert('Link agenda telah disalin ke clipboard!');
        });
    }
}

// Print styles
const printStyles = `
<style media="print">
.sidebar, .action-buttons, .breadcrumb-nav { display: none !important; }
.main-content { grid-template-columns: 1fr !important; }
.agenda-detail-hero { background: #DC143C !important; -webkit-print-color-adjust: exact; }
.countdown-section { background: #f59e0b !important; -webkit-print-color-adjust: exact; }
.fade-in { opacity: 1 !important; transform: none !important; }
</style>
`;
document.head.insertAdjacentHTML('beforeend', printStyles);
</script>
@endpush
