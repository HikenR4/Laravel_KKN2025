<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        @if(isset($agenda_detail))
            Detail Agenda - {{ $agenda_detail->judul }}
        @else
            Manajemen Agenda - Nagari Mungo
        @endif
    </title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Agenda */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, 
                @if(isset($agenda_detail)) #f0fdf4 0%, #dcfce7 100% @else #f3f4f6 0%, #e5e7eb 100% @endif
            );
        }

        .page-main-wrapper {
            margin-left: 280px;
            padding: 1rem;
            transition: margin-left 0.3s ease;
        }

        @media (max-width: 1024px) {
            .page-main-wrapper {
                margin-left: 0 !important;
            }
        }

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }

        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            @if(isset($agenda_detail)) margin-bottom: 1.5rem; @else padding: 1.5rem; @endif
        }

        .breadcrumb-custom {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: #10b981;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #059669;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: #6b7280;
        }

        .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title-custom {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .btn-tambah-agenda {
            background: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-tambah-agenda:hover {
            background: #059669;
            transform: translateY(-2px);
        }

        /* Hero Section for Detail */
        .hero-section {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            padding: 3rem 2rem;
            border-radius: 1rem 1rem 0 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="agenda-pattern" width="20" height="20" patternUnits="userSpaceOnUse"><circle cx="10" cy="10" r="1" fill="white" opacity="0.2"/></pattern></defs><rect width="100" height="100" fill="url(%23agenda-pattern)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title {
            font-size: 2.5rem;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 1rem;
        }

        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            background: rgba(255, 255, 255, 0.15);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            backdrop-filter: blur(10px);
        }

        .content-section {
            padding: 2rem;
        }

        .search-filter-section {
            margin-bottom: 1.5rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table th,
        .custom-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .kategori-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            background: #e5e7eb;
            color: #374151;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-planned {
            background: #3b82f6;
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

        .status-cancelled {
            background: #ef4444;
            color: white;
        }

        .agenda-date {
            font-weight: 600;
            color: #1f2937;
        }

        .agenda-time {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .agenda-location {
            font-size: 0.875rem;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        .gambar-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .agenda-image {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
        }

        .no-image {
            width: 60px;
            height: 60px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            color: #6b7280;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .action-btn {
            background: #f3f4f6;
            color: #374151;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #10b981;
            color: white;
        }

        .btn-custom {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, #10b981, #059669);
            color: white;
        }

        .btn-success-custom:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn-secondary-custom:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-warning-custom:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger-custom:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            color: white;
        }

        .sidebar-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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

        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 0.5rem;
            border-left: 4px solid #10b981;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            text-align: right;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            padding: 1.5rem;
            border-radius: 1rem;
            text-align: center;
            border: 1px solid #bbf7d0;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #10b981;
            display: block;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
        }

        .countdown-section {
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            margin-bottom: 2rem;
        }

        .countdown-timer {
            display: flex;
            justify-content: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        .countdown-item {
            background: rgba(255, 255, 255, 0.2);
            padding: 1rem;
            border-radius: 0.5rem;
            min-width: 80px;
        }

        .countdown-number {
            font-size: 2rem;
            font-weight: 800;
            display: block;
        }

        .countdown-label {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .schedule-section {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .schedule-title {
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .agenda-timeline {
            position: relative;
            padding-left: 2rem;
        }

        .agenda-timeline::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #10b981;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2rem;
            top: 0.25rem;
            width: 12px;
            height: 12px;
            background: #10b981;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #10b981;
        }

        .location-section {
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            border: 1px solid #f59e0b;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
        }

        .location-title {
            font-weight: 700;
            color: #92400e;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .participants-section {
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            border: 1px solid #ec4899;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .participants-title {
            font-weight: 700;
            color: #be185d;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .agenda-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #374151;
            margin-bottom: 2rem;
        }

        .card-footer {
            background: #f8fafc;
            padding: 1.25rem;
            border-radius: 0 0 1rem 1rem;
        }

        .pagination-links .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            padding: 0.5rem 1rem;
        }

        .pagination-links .page-item.active .page-link {
            background: #10b981;
            border-color: #10b981;
        }

        .modal-content {
            border-radius: 1rem;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
        }

        .btn-close-white {
            filter: invert(1);
        }

        .loading {
            border: 2px solid #fff;
            border-top: 2px solid transparent;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Animasi Fade In */
        .agenda-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: agendaFadeInUp 0.6s ease forwards;
        }

        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes agendaFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .agenda-upcoming {
            border-left: 4px solid #10b981;
        }

        .agenda-past {
            opacity: 0.7;
            border-left: 4px solid #6b7280;
        }

        .agenda-today {
            border-left: 4px solid #f59e0b;
            background: #fffbeb;
        }

        /* Print styles */
        @media print {
            .sidebar-card, .action-buttons, .breadcrumb-custom, .search-filter-section, .modal {
                display: none !important;
            }
            .page-main-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            
            @if(isset($agenda_detail))
                {{-- HALAMAN DETAIL AGENDA --}}
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="fade-in">
                    <ol class="breadcrumb breadcrumb-custom">
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.dashboard') }}">
                                <i class="fas fa-home me-1"></i>Dashboard
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ route('admin.agenda') }}">Manajemen Agenda</a>
                        </li>
                        <li class="breadcrumb-item active">Detail Agenda</li>
                    </ol>
                </nav>

                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <div class="row">
                    <!-- Main Content -->
                    <div class="col-xl-8 col-lg-7">
                        <!-- Hero Section -->
                        <div class="content-card fade-in" style="animation-delay: 0.2s;">
                            <div class="hero-section">
                                <div class="hero-content">
                                    <h1 class="hero-title">{{ $agenda_detail->judul }}</h1>
                                    
                                    <div class="hero-meta">
                                        <div class="meta-item">
                                            <i class="fas fa-calendar-alt"></i>
                                            <span>
                                                {{ $agenda_detail->tanggal_mulai->format('d F Y') }}
                                                @if($agenda_detail->tanggal_selesai && !$agenda_detail->tanggal_mulai->eq($agenda_detail->tanggal_selesai))
                                                    - {{ $agenda_detail->tanggal_selesai->format('d F Y') }}
                                                @endif
                                            </span>
                                        </div>
                                        @if($agenda_detail->waktu_mulai)
                                            <div class="meta-item">
                                                <i class="fas fa-clock"></i>
                                                <span>
                                                    {{ \Carbon\Carbon::parse($agenda_detail->waktu_mulai)->format('H:i') }}
                                                    @if($agenda_detail->waktu_selesai)
                                                        - {{ \Carbon\Carbon::parse($agenda_detail->waktu_selesai)->format('H:i') }}
                                                    @endif
                                                    WIB
                                                </span>
                                            </div>
                                        @endif
                                        @if($agenda_detail->lokasi)
                                            <div class="meta-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ $agenda_detail->lokasi }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="d-flex flex-wrap gap-2 align-items-center">
                                        <span class="kategori-badge">
                                            <i class="fas fa-tag me-1"></i>{{ ucfirst($agenda_detail->kategori) }}
                                        </span>
                                        <span class="status-badge status-{{ $agenda_detail->status }}">
                                            {{ ucfirst($agenda_detail->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Content Section -->
                            <div class="content-section">
                                <!-- Countdown Section -->
                                @if($agenda_detail->tanggal_mulai->isFuture() && $agenda_detail->status !== 'cancelled')
                                <div class="countdown-section">
                                    <h3 class="mb-3">Agenda akan dimulai dalam:</h3>
                                    <div class="countdown-timer" id="countdown">
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="days">0</span>
                                            <span class="countdown-label">Hari</span>
                                        </div>
                                        <div class="countdown-item">
                                            <span class="countdown-number" id="hours">0</span>
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
                                <div class="stats-grid">
                                    @if($agenda_detail->peserta_target)
                                    <div class="stat-card">
                                        <span class="stat-number">{{ number_format($agenda_detail->peserta_target) }}</span>
                                        <span class="stat-label">Target Peserta</span>
                                    </div>
                                    @endif
                                    @if($agenda_detail->biaya !== null)
                                    <div class="stat-card">
                                        <span class="stat-number">
                                            @if($agenda_detail->biaya == 0)
                                                GRATIS
                                            @else
                                                Rp {{ number_format($agenda_detail->biaya, 0, ',', '.') }}
                                            @endif
                                        </span>
                                        <span class="stat-label">Biaya</span>
                                    </div>
                                    @endif
                                    <div class="stat-card">
                                        <span class="stat-number">{{ $agenda_detail->tanggal_mulai->diffInDays($agenda_detail->tanggal_selesai ?? $agenda_detail->tanggal_mulai) + 1 }}</span>
                                        <span class="stat-label">Hari Kegiatan</span>
                                    </div>
                                    <div class="stat-card">
                                        <span class="stat-number">{{ $agenda_detail->tanggal_mulai->diffForHumans() }}</span>
                                        <span class="stat-label">Waktu Relatif</span>
                                    </div>
                                </div>

                                <!-- Schedule Section -->
                                <div class="schedule-section">
                                    <div class="schedule-title">
                                        <i class="fas fa-calendar-check"></i>
                                        Jadwal Kegiatan
                                    </div>
                                    <div class="agenda-timeline">
                                        <div class="timeline-item">
                                            <strong>Tanggal Mulai:</strong> {{ $agenda_detail->tanggal_mulai->format('l, d F Y') }}
                                            @if($agenda_detail->waktu_mulai)
                                                <br><small class="text-muted">Pukul {{ \Carbon\Carbon::parse($agenda_detail->waktu_mulai)->format('H:i') }} WIB</small>
                                            @endif
                                        </div>
                                        @if($agenda_detail->tanggal_selesai && !$agenda_detail->tanggal_mulai->eq($agenda_detail->tanggal_selesai))
                                        <div class="timeline-item">
                                            <strong>Tanggal Selesai:</strong> {{ $agenda_detail->tanggal_selesai->format('l, d F Y') }}
                                            @if($agenda_detail->waktu_selesai)
                                                <br><small class="text-muted">Pukul {{ \Carbon\Carbon::parse($agenda_detail->waktu_selesai)->format('H:i') }} WIB</small>
                                            @endif
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Image -->
                                @if($agenda_detail->gambar)
                                    <div class="text-center mb-4">
                                        <img src="{{ $agenda_detail->gambar }}" 
                                             alt="{{ $agenda_detail->alt_gambar ?? $agenda_detail->judul }}" 
                                             class="agenda-image">
                                        @if($agenda_detail->alt_gambar)
                                            <p class="text-muted mt-2" style="font-style: italic;">{{ $agenda_detail->alt_gambar }}</p>
                                        @endif
                                    </div>
                                @endif

                                <!-- Description -->
                                @if($agenda_detail->deskripsi)
                                    <div class="agenda-content">
                                        {!! nl2br(e($agenda_detail->deskripsi)) !!}
                                    </div>
                                @endif

                                <!-- Location Section -->
                                @if($agenda_detail->lokasi)
                                <div class="location-section">
                                    <div class="location-title">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Lokasi Kegiatan
                                    </div>
                                    <p class="mb-0" style="font-size: 1.1rem; font-weight: 500;">{{ $agenda_detail->lokasi }}</p>
                                </div>
                                @endif

                                <!-- Participants Section -->
                                @if($agenda_detail->peserta_target || $agenda_detail->penanggung_jawab || $agenda_detail->kontak_person)
                                <div class="participants-section">
                                    <div class="participants-title">
                                        <i class="fas fa-users"></i>
                                        Informasi Peserta & Penanggungjawab
                                    </div>
                                    @if($agenda_detail->peserta_target)
                                        <p><strong>Target Peserta:</strong> {{ number_format($agenda_detail->peserta_target) }} orang</p>
                                    @endif
                                    @if($agenda_detail->penanggung_jawab)
                                        <p><strong>Penanggung Jawab:</strong> {{ $agenda_detail->penanggung_jawab }}</p>
                                    @endif
                                    @if($agenda_detail->kontak_person)
                                        <p class="mb-0"><strong>Kontak Person:</strong> {{ $agenda_detail->kontak_person }}</p>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar -->
                    <div class="col-xl-4 col-lg-5">
                        <!-- Quick Actions -->
                        <div class="sidebar-card fade-in" style="animation-delay: 0.3s;">
                            <h5 class="sidebar-title">
                                <i class="fas fa-bolt text-warning"></i>
                                Quick Actions
                            </h5>
                            <div class="action-buttons">
                                <button class="btn-custom btn-warning-custom" onclick="editItem({{ $agenda_detail->id }})">
                                    <i class="fas fa-edit"></i>
                                    Edit Agenda
                                </button>
                                <a href="{{ route('admin.agenda') }}" class="btn-custom btn-secondary-custom">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                                <button class="btn-custom btn-success-custom" onclick="window.print()">
                                    <i class="fas fa-print"></i>
                                    Print
                                </button>
                                <button class="btn-custom btn-danger-custom" onclick="deleteAgenda({{ $agenda_detail->id }})">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>
                            </div>
                        </div>

                        <!-- Informasi Agenda -->
                        <div class="sidebar-card fade-in" style="animation-delay: 0.4s;">
                            <h5 class="sidebar-title">
                                <i class="fas fa-info-circle text-info"></i>
                                Informasi Agenda
                            </h5>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-hashtag"></i>
                                        ID Agenda
                                    </span>
                                    <span class="info-value">#{{ $agenda_detail->id }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-link"></i>
                                        Slug
                                    </span>
                                    <span class="info-value">{{ $agenda_detail->slug }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-toggle-on"></i>
                                        Status
                                    </span>
                                    <span class="status-badge status-{{ $agenda_detail->status }}">{{ ucfirst($agenda_detail->status) }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-tag"></i>
                                        Kategori
                                    </span>
                                    <span class="info-value">{{ ucfirst($agenda_detail->kategori) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Timeline & Admin -->
                        <div class="sidebar-card fade-in" style="animation-delay: 0.5s;">
                            <h5 class="sidebar-title">
                                <i class="fas fa-clock text-primary"></i>
                                Timeline & Admin
                            </h5>
                            <div class="info-grid">
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-calendar-plus"></i>
                                        Dibuat
                                    </span>
                                    <span class="info-value">{{ $agenda_detail->created_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-calendar-edit"></i>
                                        Diperbarui
                                    </span>
                                    <span class="info-value">{{ $agenda_detail->updated_at->format('d/m/Y H:i') }}</span>
                                </div>
                                <div class="info-item">
                                    <span class="info-label">
                                        <i class="fas fa-user-edit"></i>
                                        Admin
                                    </span>
                                    <span class="info-value">{{ $agenda_detail->admin->nama_lengkap ?? 'Admin' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            @else
                {{-- HALAMAN UTAMA AGENDA --}}
                <!-- Page Header -->
                <div class="page-header mb-6 agenda-fade-in">
                    <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Agenda</h1>
                </div>

                <!-- Page Content -->
                <div class="page-content">
                    <!-- Flash Messages -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show agenda-fade-in" role="alert" style="animation-delay: 0.1s;">
                            <i class="fas fa-check-circle me-2"></i>
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show agenda-fade-in" role="alert" style="animation-delay: 0.1s;">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show agenda-fade-in" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Ada kesalahan pada form:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Main Card -->
                    <div class="content-card agenda-fade-in" style="animation-delay: 0.2s;">
                        <!-- Card Header -->
                        <div class="card-header-custom">
                            <h2 class="card-title-custom">Agenda Kegiatan</h2>
                            <button class="btn-tambah-agenda" data-bs-toggle="modal" data-bs-target="#tambahAgendaModal">
                                <i class="fas fa-plus me-2"></i>Tambah Agenda
                            </button>
                        </div>

                        <!-- Search & Filter Section -->
                        <div class="search-filter-section mb-6">
                            <div class="row">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="searchInput" placeholder="Cari agenda berdasarkan judul atau lokasi...">
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3 mb-md-0">
                                    <select class="form-select" id="filterKategori">
                                        <option value="">Semua Kategori</option>
                                        <option value="rapat">Rapat</option>
                                        <option value="sosialisasi">Sosialisasi</option>
                                        <option value="pelatihan">Pelatihan</option>
                                        <option value="gotong-royong">Gotong Royong</option>
                                        <option value="keagamaan">Keagamaan</option>
                                        <option value="olahraga">Olahraga</option>
                                        <option value="budaya">Budaya</option>
                                        <option value="lainnya">Lainnya</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select class="form-select" id="filterStatus">
                                        <option value="">Semua Status</option>
                                        <option value="planned">Planned</option>
                                        <option value="ongoing">Ongoing</option>
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Table Section -->
                        <div class="table-container">
                            <table class="table custom-table">
                                <thead>
                                    <tr>
                                        <th style="width: 30%">Agenda</th>
                                        <th style="width: 15%">Kategori</th>
                                        <th style="width: 20%">Tanggal & Waktu</th>
                                        <th style="width: 20%">Lokasi</th>
                                        <th style="width: 15%">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($agenda ?? [] as $index => $item)
                                    @php
                                        $isToday = $item->tanggal_mulai && $item->tanggal_mulai->isToday();
                                        $isPast = $item->tanggal_mulai && $item->tanggal_mulai->isPast() && !$isToday;
                                        $rowClass = $isToday ? 'agenda-today' : ($isPast ? 'agenda-past' : 'agenda-upcoming');
                                    @endphp
                                    <tr class="agenda-fade-in {{ $rowClass }}" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                        <td>
                                            <div class="agenda-info">
                                                <div class="agenda-title fw-bold">
                                                    {{ $item->judul ?? 'Agenda Kegiatan' }}
                                                </div>
                                                @if($item->deskripsi)
                                                    <small class="text-muted d-block mt-1">{{ Str::limit($item->deskripsi, 80) }}</small>
                                                @endif
                                                <div class="mt-1">
                                                    <span class="status-badge status-{{ $item->status ?? 'planned' }}">
                                                        {{ ucfirst($item->status ?? 'Planned') }}
                                                    </span>
                                                    @if($item->peserta_target)
                                                        <small class="text-muted ms-2">
                                                            <i class="fas fa-users"></i> {{ $item->peserta_target }} peserta
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="kategori-badge">{{ ucfirst($item->kategori ?? 'Lainnya') }}</span>
                                        </td>
                                        <td>
                                            <div class="agenda-date">
                                                {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : date('d/m/Y') }}
                                                @if($item->tanggal_selesai && !$item->tanggal_mulai->eq($item->tanggal_selesai))
                                                    <br><small class="text-muted">s/d {{ $item->tanggal_selesai->format('d/m/Y') }}</small>
                                                @endif
                                            </div>
                                            @if($item->waktu_mulai)
                                                <div class="agenda-time">
                                                    <i class="fas fa-clock me-1"></i>
                                                    {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                                                    @if($item->waktu_selesai)
                                                        - {{ \Carbon\Carbon::parse($item->waktu_selesai)->format('H:i') }}
                                                    @endif
                                                    WIB
                                                </div>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->lokasi)
                                                <div class="agenda-location">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    {{ Str::limit($item->lokasi, 40) }}
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                            @if($item->biaya && $item->biaya > 0)
                                                <small class="text-success d-block">
                                                    <i class="fas fa-money-bill-wave"></i> Rp {{ number_format($item->biaya, 0, ',', '.') }}
                                                </small>
                                            @elseif($item->biaya == 0)
                                                <small class="text-info d-block">
                                                    <i class="fas fa-gift"></i> Gratis
                                                </small>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <button class="action-btn btn-delete" onclick="deleteItem({{ $item->id ?? ($index + 1) }})"
                                                        title="Hapus" data-bs-toggle="tooltip">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                                <button class="action-btn btn-edit" onclick="editItem({{ $item->id ?? ($index + 1) }})"
                                                        title="Edit" data-bs-toggle="tooltip">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="action-btn btn-view" onclick="viewItem({{ $item->id ?? ($index + 1) }})"
                                                        title="Lihat" data-bs-toggle="tooltip">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center py-4">
                                            <i class="fas fa-calendar-times fa-3x text-muted mb-3"></i>
                                            <p class="text-muted">Belum ada agenda yang ditambahkan</p>
                                            <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahAgendaModal">
                                                <i class="fas fa-plus me-1"></i>Tambah Agenda Pertama
                                            </button>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination Section -->
                        @if(isset($agenda) && $agenda->hasPages())
                        <div class="card-footer">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="pagination-info">
                                    <small class="text-muted">
                                        Menampilkan {{ $agenda->firstItem() }} - {{ $agenda->lastItem() }}
                                        dari {{ $agenda->total() }} agenda
                                    </small>
                                </div>
                                <div class="pagination-links">
                                    {{ $agenda->links() }}
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Modal Tambah Agenda -->
                <div class="modal fade" id="tambahAgendaModal" tabindex="-1" aria-labelledby="tambahAgendaModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-success">
                                <h5 class="modal-title text-white" id="tambahAgendaModalLabel">
                                    <i class="fas fa-calendar-plus me-2"></i>Tambah Agenda Baru
                                </h5>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formTambahAgenda" action="{{ route('admin.agenda.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="judul" class="form-label">Judul Agenda <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="judul" name="judul" required
                                                   placeholder="Masukkan judul agenda" value="{{ old('judul') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                            <select class="form-select" id="kategori" name="kategori" required>
                                                <option value="">Pilih Kategori</option>
                                                <option value="rapat" {{ old('kategori') == 'rapat' ? 'selected' : '' }}>Rapat</option>
                                                <option value="sosialisasi" {{ old('kategori') == 'sosialisasi' ? 'selected' : '' }}>Sosialisasi</option>
                                                <option value="pelatihan" {{ old('kategori') == 'pelatihan' ? 'selected' : '' }}>Pelatihan</option>
                                                <option value="gotong-royong" {{ old('kategori') == 'gotong-royong' ? 'selected' : '' }}>Gotong Royong</option>
                                                <option value="keagamaan" {{ old('kategori') == 'keagamaan' ? 'selected' : '' }}>Keagamaan</option>
                                                <option value="olahraga" {{ old('kategori') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                                                <option value="budaya" {{ old('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                                <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                            <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required
                                                   value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai"
                                                   value="{{ old('tanggal_selesai') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                            <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                                                   value="{{ old('waktu_mulai') }}">
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                                            <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai"
                                                   value="{{ old('waktu_selesai') }}">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="deskripsi" class="form-label">Deskripsi Agenda</label>
                                        <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4"
                                                  placeholder="Deskripsi lengkap agenda...">{{ old('deskripsi') }}</textarea>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="lokasi" class="form-label">Lokasi</label>
                                            <input type="text" class="form-control" id="lokasi" name="lokasi"
                                                   placeholder="Masukkan lokasi kegiatan" value="{{ old('lokasi') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select" id="status" name="status" required>
                                                <option value="planned" {{ old('status') == 'planned' ? 'selected' : '' }}>Planned</option>
                                                <option value="ongoing" {{ old('status') == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                                                <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                                                <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <label for="peserta_target" class="form-label">Target Peserta</label>
                                            <input type="number" class="form-control" id="peserta_target" name="peserta_target" min="0"
                                                   placeholder="Jumlah peserta" value="{{ old('peserta_target') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="biaya" class="form-label">Biaya (Rp)</label>
                                            <input type="number" class="form-control" id="biaya" name="biaya" min="0"
                                                   placeholder="0 untuk gratis" value="{{ old('biaya', 0) }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="kontak_person" class="form-label">Kontak Person</label>
                                            <input type="text" class="form-control" id="kontak_person" name="kontak_person"
                                                   placeholder="Nomor telepon" value="{{ old('kontak_person') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-8 mb-3">
                                            <label for="penanggung_jawab" class="form-label">Penanggung Jawab</label>
                                            <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab"
                                                   placeholder="Nama penanggung jawab" value="{{ old('penanggung_jawab') }}">
                                        </div>
                                        <div class="col-md-4 mb-3">
                                            <label for="gambar" class="form-label">Gambar Agenda</label>
                                            <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                            <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alt_gambar" class="form-label">Alt Text Gambar</label>
                                        <input type="text" class="form-control" id="alt_gambar" name="alt_gambar"
                                               placeholder="Deskripsi gambar untuk aksesibilitas" value="{{ old('alt_gambar') }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-1"></i>Simpan Agenda
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Modal Edit Agenda -->
                <div class="modal fade" id="editAgendaModal" tabindex="-1" aria-labelledby="editAgendaModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-xl">
                        <div class="modal-content">
                            <div class="modal-header bg-warning">
                                <h5 class="modal-title text-dark" id="editAgendaModalLabel">
                                    <i class="fas fa-edit me-2"></i>Edit Agenda
                                </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form id="formEditAgenda" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-body" id="editAgendaContent">
                                    <div class="text-center">
                                        <div class="loading"></div>
                                        <p class="mt-2">Memuat form edit...</p>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                        <i class="fas fa-times me-1"></i>Batal
                                    </button>
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-1"></i>Update Agenda
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                            <h5 class="mb-3">Apakah Anda yakin?</h5>
                            <p class="text-muted">Data agenda yang dihapus tidak dapat dikembalikan lagi.</p>
                            <div class="alert alert-warning mt-3">
                                <small><i class="fas fa-info-circle me-1"></i>Pastikan agenda ini sudah tidak diperlukan lagi</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i>Ya, Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add staggered animation to fade-in elements
            const fadeElements = document.querySelectorAll('.agenda-fade-in, .fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });

            // Countdown timer (only for detail page)
            @if(isset($agenda_detail) && $agenda_detail->tanggal_mulai->isFuture() && $agenda_detail->status !== 'cancelled')
            const targetDate = new Date('{{ $agenda_detail->tanggal_mulai->format('Y-m-d') }}T{{ $agenda_detail->waktu_mulai ?? '00:00' }}').getTime();
            
            const countdown = setInterval(function() {
                const now = new Date().getTime();
                const distance = targetDate - now;
                
                const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
                $('#days').text(days >= 0 ? days : 0);
                $('#hours').text(hours >= 0 ? hours : 0);
                $('#minutes').text(minutes >= 0 ? minutes : 0);
                $('#seconds').text(seconds >= 0 ? seconds : 0);
                
                if (distance < 0) {
                    clearInterval(countdown);
                    $('.countdown-section').html('<h3 class="text-center">Agenda sudah dimulai!</h3>');
                }
            }, 1000);
            @endif
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        @if(!isset($agenda_detail))
        // Search functionality (only for main page)
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Filter by kategori
        $('#filterKategori').on('change', function() {
            var kategori = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                if (kategori === '') {
                    $(this).show();
                } else {
                    $(this).toggle($(this).find('.kategori-badge').text().toLowerCase().indexOf(kategori) > -1);
                }
            });
        });

        // Filter by status
        $('#filterStatus').on('change', function() {
            var status = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                if (status === '') {
                    $(this).show();
                } else {
                    $(this).toggle($(this).find('.status-badge').text().toLowerCase().indexOf(status) > -1);
                }
            });
        });
        @endif

        // Action functions
        function deleteItem(id) {
            @if(isset($agenda_detail))
                deleteAgenda(id);
            @else
                $('#deleteForm').attr('action', '/admin/agenda/delete/' + id);
                $('#deleteModal').modal('show');
            @endif
        }

        function deleteAgenda(id) {
            $('#deleteForm').attr('action', '/admin/agenda/delete/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Redirect to detail page
            setTimeout(() => {
                window.location.href = '/admin/agenda/show/' + id;
            }, 500);
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Load edit form via AJAX
            $.ajax({
                url: '/admin/agenda/edit/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        
                        // Escape function
                        function escapeHtml(text) {
                            if (!text) return '';
                            return text.toString()
                                .replace(/&/g, "&amp;")
                                .replace(/</g, "&lt;")
                                .replace(/>/g, "&gt;")
                                .replace(/"/g, "&quot;")
                                .replace(/'/g, "&#039;");
                        }

                        // Build form content (same as previous implementation)
                        const kategoris = ['rapat', 'sosialisasi', 'pelatihan', 'gotong-royong', 'keagamaan', 'olahraga', 'budaya', 'lainnya'];
                        let kategoriOptions = '';
                        kategoris.forEach(function(kat) {
                            const selected = data.kategori === kat ? 'selected' : '';
                            const label = kat.charAt(0).toUpperCase() + kat.slice(1).replace('-', ' ');
                            kategoriOptions += '<option value="' + kat + '" ' + selected + '>' + label + '</option>';
                        });

                        const statusOptions = 
                            '<option value="planned" ' + (data.status === 'planned' ? 'selected' : '') + '>Planned</option>' +
                            '<option value="ongoing" ' + (data.status === 'ongoing' ? 'selected' : '') + '>Ongoing</option>' +
                            '<option value="completed" ' + (data.status === 'completed' ? 'selected' : '') + '>Completed</option>' +
                            '<option value="cancelled" ' + (data.status === 'cancelled' ? 'selected' : '') + '>Cancelled</option>';

                        let currentImageHtml = '';
                        if (data.gambar) {
                            currentImageHtml = 
                                '<div class="mt-2">' +
                                    '<label class="form-label">Gambar Saat Ini:</label><br>' +
                                    '<img src="' + data.gambar + '" alt="Current" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 0.25rem;">' +
                                '</div>';
                        }

                        const content = 
                            '<div class="row">' +
                                '<div class="col-md-8 mb-3">' +
                                    '<label for="edit_judul" class="form-label">Judul Agenda <span class="text-danger">*</span></label>' +
                                    '<input type="text" class="form-control" id="edit_judul" name="judul" required value="' + escapeHtml(data.judul) + '">' +
                                '</div>' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>' +
                                    '<select class="form-select" id="edit_kategori" name="kategori" required>' +
                                        kategoriOptions +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-md-6 mb-3">' +
                                    '<label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>' +
                                    '<input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai" required value="' + data.tanggal_mulai + '">' +
                                '</div>' +
                                '<div class="col-md-6 mb-3">' +
                                    '<label for="edit_tanggal_selesai" class="form-label">Tanggal Selesai</label>' +
                                    '<input type="date" class="form-control" id="edit_tanggal_selesai" name="tanggal_selesai" value="' + (data.tanggal_selesai || '') + '">' +
                                '</div>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-md-6 mb-3">' +
                                    '<label for="edit_waktu_mulai" class="form-label">Waktu Mulai</label>' +
                                    '<input type="time" class="form-control" id="edit_waktu_mulai" name="waktu_mulai" value="' + (data.waktu_mulai || '') + '">' +
                                '</div>' +
                                '<div class="col-md-6 mb-3">' +
                                    '<label for="edit_waktu_selesai" class="form-label">Waktu Selesai</label>' +
                                    '<input type="time" class="form-control" id="edit_waktu_selesai" name="waktu_selesai" value="' + (data.waktu_selesai || '') + '">' +
                                '</div>' +
                            '</div>' +
                            '<div class="mb-3">' +
                                '<label for="edit_deskripsi" class="form-label">Deskripsi Agenda</label>' +
                                '<textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="4">' + escapeHtml(data.deskripsi || '') + '</textarea>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-md-8 mb-3">' +
                                    '<label for="edit_lokasi" class="form-label">Lokasi</label>' +
                                    '<input type="text" class="form-control" id="edit_lokasi" name="lokasi" value="' + escapeHtml(data.lokasi || '') + '">' +
                                '</div>' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>' +
                                    '<select class="form-select" id="edit_status" name="status" required>' +
                                        statusOptions +
                                    '</select>' +
                                '</div>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_peserta_target" class="form-label">Target Peserta</label>' +
                                    '<input type="number" class="form-control" id="edit_peserta_target" name="peserta_target" min="0" value="' + (data.peserta_target || '') + '">' +
                                '</div>' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_biaya" class="form-label">Biaya (Rp)</label>' +
                                    '<input type="number" class="form-control" id="edit_biaya" name="biaya" min="0" value="' + (data.biaya || 0) + '">' +
                                '</div>' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_kontak_person" class="form-label">Kontak Person</label>' +
                                    '<input type="text" class="form-control" id="edit_kontak_person" name="kontak_person" value="' + escapeHtml(data.kontak_person || '') + '">' +
                                '</div>' +
                            '</div>' +
                            '<div class="row">' +
                                '<div class="col-md-8 mb-3">' +
                                    '<label for="edit_penanggung_jawab" class="form-label">Penanggung Jawab</label>' +
                                    '<input type="text" class="form-control" id="edit_penanggung_jawab" name="penanggung_jawab" value="' + escapeHtml(data.penanggung_jawab || '') + '">' +
                                '</div>' +
                                '<div class="col-md-4 mb-3">' +
                                    '<label for="edit_gambar" class="form-label">Gambar Agenda</label>' +
                                    '<input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">' +
                                    '<small class="text-muted">Kosongkan jika tidak ingin mengubah</small>' +
                                    currentImageHtml +
                                '</div>' +
                            '</div>' +
                            '<div class="mb-3">' +
                                '<label for="edit_alt_gambar" class="form-label">Alt Text Gambar</label>' +
                                '<input type="text" class="form-control" id="edit_alt_gambar" name="alt_gambar" value="' + escapeHtml(data.alt_gambar || '') + '">' +
                            '</div>';
                        
                        $('#editAgendaContent').html(content);
                        $('#formEditAgenda').attr('action', '/admin/agenda/update/' + id);
                        $('#editAgendaModal').modal('show');
                    } else {
                        alert('Gagal memuat data agenda: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    alert('Terjadi kesalahan saat memuat form edit.');
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        // Form submission handlers
        $('#formTambahAgenda').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditAgenda').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahAgendaModal').on('hidden.bs.modal', function() {
            $('#formTambahAgenda')[0].reset();
            $('#formTambahAgenda button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Agenda').prop('disabled', false);
        });

        $('#editAgendaModal').on('hidden.bs.modal', function() {
            $('#formEditAgenda button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Agenda').prop('disabled', false);
        });

        // Handle sidebar toggle and adjust layout
        function adjustPageLayout() {
            const mainContent = document.getElementById('pageMainContent');
            const sidebar = document.getElementById('sidebar');
            if (mainContent && sidebar) {
                if (window.innerWidth < 1024) {
                    mainContent.style.marginLeft = '0';
                } else if (sidebar.classList.contains('sidebar-collapsed')) {
                    mainContent.style.marginLeft = '80px';
                } else {
                    mainContent.style.marginLeft = '280px';
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtn = document.getElementById('toggleSidebar');
            if (toggleBtn) {
                toggleBtn.addEventListener('click', function() {
                    setTimeout(adjustPageLayout, 150);
                });
            }
            adjustPageLayout();
        });

        window.addEventListener('resize', adjustPageLayout);
        window.addEventListener('load', adjustPageLayout);
    </script>
</body>
</html>