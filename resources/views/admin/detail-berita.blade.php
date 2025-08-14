<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita - {{ $berita->judul ?? 'Berita' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
        }

        /* Global text wrapping for all elements */
        * {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
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

        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            margin-bottom: 1.5rem;
            overflow: hidden; /* Prevent content overflow */
        }

        .breadcrumb-custom {
            background: none;
            padding: 0;
            margin-bottom: 1.5rem;
        }

        .breadcrumb-custom .breadcrumb-item a {
            color: #3b82f6;
            text-decoration: none;
            transition: color 0.3s ease;
            word-break: break-all;
        }

        .breadcrumb-custom .breadcrumb-item a:hover {
            color: #2563eb;
        }

        .breadcrumb-custom .breadcrumb-item.active {
            color: #6b7280;
            word-break: break-all;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="1" fill="white" opacity="0.1"/><circle cx="20" cy="80" r="1" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
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
            /* Enhanced text wrapping for title */
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
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
            background: rgba(255, 255, 255, 0.1);
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            backdrop-filter: blur(10px);
            /* Ensure meta items wrap properly */
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .kategori-badge {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .status-published {
            background: #10b981;
            color: white;
        }

        .status-draft {
            background: #f59e0b;
            color: white;
        }

        .featured-badge {
            background: linear-gradient(45deg, #ff6b6b, #ffd93d);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 2rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .content-section {
            padding: 2rem;
            overflow: hidden; /* Prevent horizontal overflow */
        }

        .article-image {
            width: 100%;
            max-width: 100%; /* Ensure image doesn't overflow */
            max-height: 500px;
            object-fit: cover;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            margin-bottom: 2rem;
        }

        .article-content {
            font-size: 1.125rem;
            line-height: 1.8;
            color: #374151;
            margin-bottom: 2rem;
            /* Enhanced text wrapping for content */
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            white-space: pre-wrap; /* Preserve line breaks but allow wrapping */
            max-width: 100%;
            overflow: hidden;
        }

        .article-content h1, .article-content h2, .article-content h3 {
            margin-top: 2rem;
            margin-bottom: 1rem;
            font-weight: 700;
            color: #1f2937;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .article-content ul, .article-content ol {
            margin-bottom: 1.5rem;
            padding-left: 2rem;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .article-content blockquote {
            border-left: 4px solid #3b82f6;
            padding-left: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            background: #f8fafc;
            padding: 1.5rem;
            border-radius: 0.5rem;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .sidebar-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            margin-bottom: 1.5rem;
            border: 1px solid #e5e7eb;
            overflow: hidden; /* Prevent overflow */
        }

        .sidebar-title {
            font-size: 1.125rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-grid {
            display: grid;
            gap: 1rem;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start; /* Changed from center to flex-start */
            padding: 0.75rem;
            background: #f8fafc;
            border-radius: 0.5rem;
            border-left: 4px solid #3b82f6;
            /* Allow items to wrap */
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #6b7280;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            flex: 1;
            min-width: 120px;
        }

        .info-value {
            color: #1f2937;
            font-weight: 600;
            text-align: right;
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
            max-width: 50%;
            flex-shrink: 0;
        }

        /* Special handling for long values like slugs */
        .info-item .info-value.long-text {
            text-align: left;
            max-width: 100%;
            width: 100%;
            margin-top: 0.5rem;
            font-size: 0.9rem;
            background: #e2e8f0;
            padding: 0.5rem;
            border-radius: 0.25rem;
            word-break: break-all;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
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
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            color: white;
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, #2563eb, #1e40af);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            color: white;
        }

        .btn-secondary-custom:hover {
            background: linear-gradient(135deg, #4b5563, #374151);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(107, 114, 128, 0.3);
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #f59e0b, #d97706);
            color: white;
        }

        .btn-warning-custom:hover {
            background: linear-gradient(135deg, #d97706, #b45309);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(245, 158, 11, 0.3);
            color: white;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, #ef4444, #dc2626);
            color: white;
        }

        .btn-danger-custom:hover {
            background: linear-gradient(135deg, #dc2626, #b91c1c);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .tags-container {
            display: flex;
            flex-wrap: wrap;
            gap: 0.5rem;
            margin-top: 1rem;
        }

        .tag {
            background: linear-gradient(135deg, #e5e7eb, #d1d5db);
            color: #374151;
            padding: 0.5rem 1rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 0.3s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .tag:hover {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            color: white;
            transform: translateY(-2px);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: linear-gradient(135deg, #f8fafc, #e2e8f0);
            padding: 1.5rem;
            border-radius: 1rem;
            text-align: center;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
            overflow: hidden;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 800;
            color: #3b82f6;
            display: block;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .stat-label {
            font-size: 0.875rem;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .excerpt-section {
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            border: 1px solid #bfdbfe;
            border-radius: 1rem;
            padding: 1.5rem;
            margin-bottom: 2rem;
            overflow: hidden;
        }

        .excerpt-title {
            font-weight: 700;
            color: #1e40af;
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .excerpt-section p {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

        .seo-section {
            background: linear-gradient(135deg, #f0fdf4, #dcfce7);
            border: 1px solid #bbf7d0;
            border-radius: 1rem;
            padding: 1.5rem;
            overflow: hidden;
        }

        .seo-section p {
            word-wrap: break-word;
            word-break: break-word;
            overflow-wrap: break-word;
        }

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

        .loading {
            border: 2px solid #f3f4f6;
            border-top: 2px solid #3b82f6;
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

        /* Mobile responsive improvements */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-meta {
                gap: 1rem;
            }

            .info-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-value {
                text-align: left;
                max-width: 100%;
                margin-top: 0.25rem;
            }

            .content-section {
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 480px) {
            .hero-title {
                font-size: 1.5rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-custom {
                width: 100%;
                justify-content: center;
            }
        }

        /* Print styles */
        @media print {
            .sidebar-card, .action-buttons, .breadcrumb-custom {
                display: none !important;
            }
            .page-main-wrapper {
                margin-left: 0 !important;
            }

            * {
                word-wrap: break-word;
                word-break: break-word;
                overflow-wrap: break-word;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="fade-in">
                <ol class="breadcrumb breadcrumb-custom">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.berita') }}">Manajemen Berita</a>
                    </li>
                    <li class="breadcrumb-item active">Detail Berita</li>
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
                                <h1 class="hero-title">{{ $berita->judul }}</h1>

                                <div class="hero-meta">
                                    <div class="meta-item">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span>{{ $berita->tanggal->format('d F Y') }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span>
                                    </div>
                                    <div class="meta-item">
                                        <i class="fas fa-eye"></i>
                                        <span>{{ number_format($berita->views) }} views</span>
                                    </div>
                                </div>

                                <div class="d-flex flex-wrap gap-2 align-items-center">
                                    <span class="kategori-badge">
                                        <i class="fas fa-tag me-1"></i>{{ ucfirst($berita->kategori) }}
                                    </span>
                                    <span class="status-badge status-{{ $berita->status }}">
                                        {{ ucfirst($berita->status) }}
                                    </span>
                                    @if($berita->featured)
                                        <span class="featured-badge">
                                            <i class="fas fa-star"></i>Featured
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Content Section -->
                        <div class="content-section">
                            <!-- Statistics -->
                            <div class="stats-grid">
                                <div class="stat-card">
                                    <span class="stat-number">{{ number_format($berita->views) }}</span>
                                    <span class="stat-label">Total Views</span>
                                </div>
                                <div class="stat-card">
                                    <span class="stat-number">{{ str_word_count($berita->konten) }}</span>
                                    <span class="stat-label">Kata</span>
                                </div>
                                <div class="stat-card">
                                    <span class="stat-number">{{ ceil(str_word_count($berita->konten) / 200) }}</span>
                                    <span class="stat-label">Menit Baca</span>
                                </div>
                                <div class="stat-card">
                                    <span class="stat-number">{{ strlen($berita->konten) }}</span>
                                    <span class="stat-label">Karakter</span>
                                </div>
                            </div>

                            <!-- Excerpt -->
                            @if($berita->excerpt)
                                <div class="excerpt-section">
                                    <div class="excerpt-title">
                                        <i class="fas fa-quote-left"></i>
                                        Ringkasan
                                    </div>
                                    <p class="mb-0" style="font-size: 1.1rem; line-height: 1.6;">{{ $berita->excerpt }}</p>
                                </div>
                            @endif

                            <!-- Image -->
                            @if($berita->gambar)
                                <div class="text-center mb-4">
                                    <img src="{{ $berita->gambar }}"
                                         alt="{{ $berita->alt_gambar ?? $berita->judul }}"
                                         class="article-image">
                                    @if($berita->alt_gambar)
                                        <p class="text-muted mt-2" style="font-style: italic;">{{ $berita->alt_gambar }}</p>
                                    @endif
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="article-content">
                                {!! nl2br(e($berita->konten)) !!}
                            </div>

                            <!-- Tags -->
                            @if($berita->tags)
                                <div class="border-top pt-4">
                                    <h5 class="mb-3">
                                        <i class="fas fa-tags me-2 text-primary"></i>Tags Terkait:
                                    </h5>
                                    <div class="tags-container">
                                        @foreach(explode(',', $berita->tags) as $tag)
                                            <span class="tag">{{ trim($tag) }}</span>
                                        @endforeach
                                    </div>
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
                            <a href="{{ route('admin.berita') }}" class="btn-custom btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i>
                                Kembali
                            </a>
                            <button class="btn-custom btn-primary-custom" onclick="window.print()">
                                <i class="fas fa-print"></i>
                                Print
                            </button>
                            <button class="btn-custom btn-danger-custom" onclick="deleteBerita({{ $berita->id }})">
                                <i class="fas fa-trash"></i>
                                Hapus
                            </button>
                        </div>
                    </div>

                    <!-- Informasi Berita -->
                    <div class="sidebar-card fade-in" style="animation-delay: 0.4s;">
                        <h5 class="sidebar-title">
                            <i class="fas fa-info-circle text-info"></i>
                            Informasi Berita
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-hashtag"></i>
                                    ID Berita
                                </span>
                                <span class="info-value">#{{ $berita->id }}</span>
                            </div>
                            <div class="info-item" style="flex-direction: column; align-items: flex-start;">
                                <span class="info-label">
                                    <i class="fas fa-link"></i>
                                    Slug
                                </span>
                                <span class="info-value long-text">{{ $berita->slug }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-toggle-on"></i>
                                    Status
                                </span>
                                <span class="status-badge status-{{ $berita->status }}">{{ ucfirst($berita->status) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-star"></i>
                                    Featured
                                </span>
                                <span class="info-value">
                                    @if($berita->featured)
                                        <i class="fas fa-check text-success"></i> Ya
                                    @else
                                        <i class="fas fa-times text-danger"></i> Tidak
                                    @endif
                                </span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-eye"></i>
                                    Total Views
                                </span>
                                <span class="info-value">{{ number_format($berita->views) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Waktu & Penulis -->
                    <div class="sidebar-card fade-in" style="animation-delay: 0.5s;">
                        <h5 class="sidebar-title">
                            <i class="fas fa-clock text-primary"></i>
                            Timeline & Penulis
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-calendar-plus"></i>
                                    Dibuat
                                </span>
                                <span class="info-value">{{ $berita->created_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-calendar-edit"></i>
                                    Diperbarui
                                </span>
                                <span class="info-value">{{ $berita->updated_at->format('d/m/Y H:i') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-calendar-day"></i>
                                    Tanggal Berita
                                </span>
                                <span class="info-value">{{ $berita->tanggal->format('d/m/Y') }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-user-edit"></i>
                                    Penulis
                                </span>
                                <span class="info-value">{{ $berita->admin->nama_lengkap ?? 'Admin' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-history"></i>
                                    Terakhir Update
                                </span>
                                <span class="info-value">{{ $berita->updated_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- SEO Information -->
                    @if($berita->meta_description || $berita->tags)
                    <div class="sidebar-card fade-in" style="animation-delay: 0.6s;">
                        <h5 class="sidebar-title">
                            <i class="fas fa-search text-success"></i>
                            Informasi SEO
                        </h5>
                        @if($berita->meta_description)
                            <div class="seo-section">
                                <h6 class="text-success mb-2">
                                    <i class="fas fa-file-alt me-1"></i>
                                    Meta Description
                                </h6>
                                <p class="mb-0 small">{{ $berita->meta_description }}</p>
                                <small class="text-muted">
                                    {{ strlen($berita->meta_description) }}/160 karakter
                                </small>
                            </div>
                        @endif

                        @if($berita->tags)
                            <div class="mt-3">
                                <h6 class="text-success mb-2">
                                    <i class="fas fa-tags me-1"></i>
                                    SEO Tags
                                </h6>
                                <div class="tags-container">
                                    @foreach(explode(',', $berita->tags) as $tag)
                                        <span class="tag">{{ trim($tag) }}</span>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                    @endif

                    <!-- Analisa Konten -->
                    <div class="sidebar-card fade-in" style="animation-delay: 0.7s;">
                        <h5 class="sidebar-title">
                            <i class="fas fa-chart-bar text-info"></i>
                            Analisa Konten
                        </h5>
                        <div class="info-grid">
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-font"></i>
                                    Jumlah Kata
                                </span>
                                <span class="info-value">{{ str_word_count($berita->konten) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-paragraph"></i>
                                    Jumlah Paragraf
                                </span>
                                <span class="info-value">{{ substr_count($berita->konten, "\n\n") + 1 }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-clock"></i>
                                    Estimasi Baca
                                </span>
                                <span class="info-value">{{ ceil(str_word_count($berita->konten) / 200) }} menit</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-text-width"></i>
                                    Total Karakter
                                </span>
                                <span class="info-value">{{ number_format(strlen($berita->konten)) }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">
                                    <i class="fas fa-percentage"></i>
                                    Kualitas SEO
                                </span>
                                <span class="info-value">
                                    @php
                                        $seoScore = 0;
                                        if($berita->meta_description) $seoScore += 25;
                                        if($berita->tags) $seoScore += 25;
                                        if($berita->alt_gambar) $seoScore += 25;
                                        if(str_word_count($berita->konten) > 300) $seoScore += 25;
                                    @endphp
                                    <span class="badge bg-{{ $seoScore >= 75 ? 'success' : ($seoScore >= 50 ? 'warning' : 'danger') }}">
                                        {{ $seoScore }}%
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">
                        <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                    <h5 class="mb-3">Apakah Anda yakin?</h5>
                    <p class="text-muted">Berita <strong>"{{ $berita->judul }}"</strong> akan dihapus permanen dan tidak dapat dikembalikan.</p>
                    <div class="alert alert-warning mt-3">
                        <small><i class="fas fa-info-circle me-1"></i>Data yang sudah dihapus tidak dapat dipulihkan</small>
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
                            <i class="fas fa-trash me-1"></i>Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add staggered animation to fade-in elements
            const fadeElements = document.querySelectorAll('.fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });

            // Smooth scroll for internal links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 100
                    }, 1000);
                }
            });
        });

        function deleteBerita(id) {
            $('#deleteForm').attr('action', '{{ url("admin/berita/delete") }}/' + id);
            $('#deleteModal').modal('show');
        }

        // Copy link functionality
        function copyLink() {
            navigator.clipboard.writeText(window.location.href).then(function() {
                alert('Link berhasil disalin!');
            });
        }

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
