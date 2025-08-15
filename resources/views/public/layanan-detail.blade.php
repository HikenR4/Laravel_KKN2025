<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $layanan->nama_layanan }} - Detail Layanan - Nagari Mungo</title>
    <meta name="description" content="{{ Str::limit(strip_tags($layanan->deskripsi), 155) }}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFFAFA 50%, #FFF5F5 100%);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Hero Section */
        .hero-detail {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 12rem 0 4rem;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.1"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.08"/></svg>');
            animation: gentleFloat 20s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-50px) translateY(-30px); }
            50% { transform: translateX(30px) translateY(20px); }
            100% { transform: translateX(-50px) translateY(-30px); }
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            margin-bottom: 2rem;
            opacity: 0.9;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            opacity: 0.8;
        }

        .breadcrumb a:hover {
            opacity: 1;
        }

        .breadcrumb span {
            margin: 0 0.5rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .hero-meta {
            display: flex;
            gap: 2rem;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 2rem;
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.2);
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .hero-badge.gratis {
            background: rgba(34, 197, 94, 0.2);
            border-color: rgba(34, 197, 94, 0.3);
        }

        .hero-badge.berbayar {
            background: rgba(249, 115, 22, 0.2);
            border-color: rgba(249, 115, 22, 0.3);
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Main Content */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 3rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .content-section {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            word-wrap: break-word;
            overflow-wrap: break-word;
            margin-bottom: 2rem;
        }

        .section-header {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            padding: 2rem;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #DC143C;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .section-content {
            padding: 2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            hyphens: auto;
        }

        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .info-card {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.05), rgba(255, 107, 107, 0.02));
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(220, 20, 60, 0.1);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-card h4 {
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 0.8rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .info-card p {
            color: #666;
            line-height: 1.6;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .list-styled {
            list-style: none;
            padding: 0;
        }

        .list-styled li {
            position: relative;
            padding: 0.8rem 0 0.8rem 2.5rem;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            hyphens: auto;
            line-height: 1.7;
        }

        .list-styled li:last-child {
            border-bottom: none;
        }

        .list-styled li::before {
            content: '\f00c';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            left: 0;
            top: 0.8rem;
            color: #DC143C;
            font-size: 0.9rem;
        }

        /* URL dan teks panjang handling */
        .long-text, .url-text {
            word-wrap: break-word;
            overflow-wrap: break-word;
            word-break: break-word;
            hyphens: auto;
            max-width: 100%;
        }

        .url-text {
            color: #DC143C;
            font-family: monospace;
            background: rgba(220, 20, 60, 0.05);
            padding: 0.2rem 0.4rem;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .sidebar-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .sidebar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid rgba(220, 20, 60, 0.1);
            position: relative;
            word-wrap: break-word;
            overflow-wrap: break-word;
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

        .action-btn {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.8rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
            margin-bottom: 1rem;
            width: 100%;
            justify-content: center;
            word-wrap: break-word;
            overflow-wrap: break-word;
            text-align: center;
        }

        .action-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
            color: white;
        }

        .action-btn.secondary {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            color: #DC143C;
            border: 2px solid rgba(220, 20, 60, 0.2);
            box-shadow: none;
        }

        .action-btn.secondary:hover {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
        }

        /* Related Services */
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .related-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            border: 1px solid rgba(220, 20, 60, 0.1);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .related-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
            border-color: rgba(220, 20, 60, 0.2);
        }

        .related-card h4 {
            color: #333;
            font-weight: 600;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .related-card p {
            color: #666;
            font-size: 0.9rem;
            line-height: 1.5;
            margin-bottom: 1rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .related-card a {
            color: #DC143C;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .related-card a:hover {
            gap: 0.8rem;
        }

        /* Quick Info */
        .quick-info {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .quick-info h4 {
            color: #DC143C;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .quick-info-grid {
            display: grid;
            gap: 0.8rem;
        }

        .quick-info-item {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
            gap: 1rem;
        }

        .quick-info-item:last-child {
            border-bottom: none;
        }

        .quick-info-label {
            color: #666;
            font-weight: 500;
            flex-shrink: 0;
            min-width: 60px;
        }

        .quick-info-value {
            color: #333;
            font-weight: 600;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            text-align: right;
            flex: 1;
        }

        /* Text wrapping improvements */
        h1, h2, h3, h4, h5, h6 {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        p, span, div, li {
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        /* Full content display */
        .full-content {
            max-width: 100%;
            overflow: visible;
        }

        .full-content * {
            max-width: 100%;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        /* Contact info enhancement */
        .contact-info {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.05), rgba(255, 107, 107, 0.02));
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 1rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-item i {
            color: #DC143C;
            width: 20px;
            text-align: center;
        }

        .contact-item strong {
            color: #DC143C;
            min-width: 80px;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .main-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .hero-meta {
                gap: 1rem;
            }

            .info-grid {
                grid-template-columns: 1fr;
            }

            .related-grid {
                grid-template-columns: 1fr;
            }

            .quick-info-item {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }

            .quick-info-value {
                text-align: left;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .section-header,
            .section-content {
                padding: 1.5rem;
            }

            .hero-badge {
                font-size: 0.9rem;
                padding: 0.6rem 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="hero-detail">
        <div class="hero-content">
            <nav class="breadcrumb">
                <a href="{{ route('landing') }}">Beranda</a>
                <span>/</span>
                <a href="{{ route('layanan') }}">Layanan</a>
                <span>/</span>
                <span>{{ $layanan->nama_layanan }}</span>
            </nav>

            <h1 class="hero-title">{{ $layanan->nama_layanan }}</h1>

            <div class="hero-meta">
                <div class="hero-badge {{
                    (stripos($layanan->biaya, 'gratis') !== false ||
                     stripos($layanan->biaya, 'tidak ada') !== false ||
                     empty($layanan->biaya)) ? 'gratis' : 'berbayar'
                }}">
                    @if(stripos($layanan->biaya, 'gratis') !== false ||
                        stripos($layanan->biaya, 'tidak ada') !== false ||
                        empty($layanan->biaya))
                        <i class="fas fa-check-circle"></i>
                        Gratis
                    @else
                        <i class="fas fa-money-bill"></i>
                        Berbayar
                    @endif
                </div>

                @if($layanan->waktu_penyelesaian)
                <div class="hero-badge">
                    <i class="fas fa-clock"></i>
                    {{ $layanan->waktu_penyelesaian }}
                </div>
                @endif

                <div class="hero-badge">
                    <i class="fas fa-tag"></i>
                    @if(stripos($layanan->nama_layanan, 'surat') !== false)
                        Surat
                    @elseif(stripos($layanan->nama_layanan, 'izin') !== false)
                        Izin
                    @elseif(stripos($layanan->nama_layanan, 'keterangan') !== false)
                        Keterangan
                    @elseif(stripos($layanan->nama_layanan, 'ktp') !== false || stripos($layanan->nama_layanan, 'kk') !== false)
                        Kependudukan
                    @else
                        Layanan
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-container">
        <main class="full-content">
            <!-- Deskripsi -->
            @if($layanan->deskripsi)
            <section class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-info-circle"></i>
                        Deskripsi Layanan
                    </h2>
                </div>
                <div class="section-content">
                    <div class="description long-text">
                        {!! nl2br(e($layanan->deskripsi)) !!}
                    </div>
                </div>
            </section>
            @endif

            <!-- Persyaratan -->
            @if($layanan->persyaratan)
            <section class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-list-check"></i>
                        Persyaratan
                    </h2>
                </div>
                <div class="section-content">
                    <ul class="list-styled">
                        @foreach(explode("\n", $layanan->persyaratan) as $persyaratan)
                            @if(trim($persyaratan))
                                <li class="long-text">{{ trim($persyaratan) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </section>
            @endif

            <!-- Prosedur -->
            @if($layanan->prosedur)
            <section class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-route"></i>
                        Prosedur Pengajuan
                    </h2>
                </div>
                <div class="section-content">
                    <ul class="list-styled">
                        @foreach(explode("\n", $layanan->prosedur) as $index => $prosedur)
                            @if(trim($prosedur))
                                <li class="long-text">{{ trim($prosedur) }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </section>
            @endif

            <!-- Informasi Tambahan -->
            @if($layanan->dasar_hukum || $layanan->output_layanan || $layanan->formulir_url)
            <section class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-file-alt"></i>
                        Informasi Tambahan
                    </h2>
                </div>
                <div class="section-content">
                    <div class="info-grid">
                        @if($layanan->dasar_hukum)
                        <div class="info-card">
                            <h4>
                                <i class="fas fa-gavel"></i>
                                Dasar Hukum
                            </h4>
                            <p class="long-text">{!! nl2br(e($layanan->dasar_hukum)) !!}</p>
                        </div>
                        @endif

                        @if($layanan->output_layanan)
                        <div class="info-card">
                            <h4>
                                <i class="fas fa-file-contract"></i>
                                Output Layanan
                            </h4>
                            <p class="long-text">{{ $layanan->output_layanan }}</p>
                        </div>
                        @endif

                        @if($layanan->formulir_url)
                        <div class="info-card">
                            <h4>
                                <i class="fas fa-download"></i>
                                Formulir Download
                            </h4>
                            <p>
                                <a href="{{ $layanan->formulir_url }}"
                                   target="_blank"
                                   class="url-text long-text"
                                   rel="noopener noreferrer">
                                    {{ $layanan->formulir_url }}
                                </a>
                            </p>
                        </div>
                        @endif
                    </div>
                </div>
            </section>
            @endif

            <!-- Layanan Terkait -->
            @if($layananTerkait->count() > 0)
            <section class="content-section">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-link"></i>
                        Layanan Terkait
                    </h2>
                </div>
                <div class="section-content">
                    <div class="related-grid">
                        @foreach($layananTerkait as $related)
                        <div class="related-card">
                            <h4 class="long-text">{{ $related->nama_layanan }}</h4>
                            <p class="long-text">{{ Str::limit(strip_tags($related->deskripsi), 100) }}</p>
                            <a href="{{ route('layanan.detail', $related->slug) }}">
                                Lihat Detail
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </section>
            @endif
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Quick Info -->
            <div class="sidebar-card">
                <h3 class="sidebar-title">Informasi Cepat</h3>
                <div class="quick-info">
                    <h4>
                        <i class="fas fa-info-circle"></i>
                        Detail Layanan
                    </h4>
                    <div class="quick-info-grid">
                        @if($layanan->biaya)
                        <div class="quick-info-item">
                            <span class="quick-info-label">Biaya</span>
                            <span class="quick-info-value long-text">{{ $layanan->biaya }}</span>
                        </div>
                        @endif

                        @if($layanan->waktu_penyelesaian)
                        <div class="quick-info-item">
                            <span class="quick-info-label">Waktu</span>
                            <span class="quick-info-value long-text">{{ $layanan->waktu_penyelesaian }}</span>
                        </div>
                        @endif

                        <div class="quick-info-item">
                            <span class="quick-info-label">Status</span>
                            <span class="quick-info-value">{{ ucfirst($layanan->status) }}</span>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <a href="#" class="action-btn" onclick="window.print()">
                    <i class="fas fa-print"></i>
                    Cetak Halaman
                </a>


                @if($layanan->formulir_url)
                <a href="{{ $layanan->formulir_url }}" target="_blank" class="action-btn" rel="noopener noreferrer">
                    <i class="fas fa-download"></i>
                    Download Formulir
                </a>
                @endif

                <a href="{{ route('layanan') }}" class="action-btn secondary">
                    <i class="fas fa-arrow-left"></i>
                    Kembali ke Layanan
                </a>
            </div>

            <!-- Contact Info -->
            <div class="sidebar-card">
                <h3 class="sidebar-title">Butuh Bantuan?</h3>
                <div class="contact-info">
                    @if($layanan->penanggung_jawab)
                    <div class="contact-item">
                        <i class="fas fa-user"></i>
                        <div>
                            <strong>Penanggung Jawab:</strong><br>
                            <span class="long-text">{{ $layanan->penanggung_jawab }}</span>
                        </div>
                    </div>
                    @endif

                    @if($layanan->kontak)
                    <div class="contact-item">
                        <i class="fas fa-phone"></i>
                        <div>
                            <strong>Kontak:</strong><br>
                            <span class="long-text">{{ $layanan->kontak }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="contact-item">
                        <i class="fas fa-clock"></i>
                        <div>
                            <strong>Jam Pelayanan:</strong><br>
                            Senin - Jumat: 08:00 - 16:00 WIB
                        </div>
                    </div>

                    <div class="contact-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <strong>Lokasi:</strong><br>
                            Kantor Nagari Mungo
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

    <script>
        // Add smooth scrolling for anchor links
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

        // Add animation on scroll
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

        document.querySelectorAll('.content-section, .sidebar-card').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
            observer.observe(el);
        });

        // Handle long URLs and text
        document.addEventListener('DOMContentLoaded', function() {
            // Add copy functionality for URLs
            const urlElements = document.querySelectorAll('.url-text');
            urlElements.forEach(element => {
                element.addEventListener('click', function(e) {
                    if (e.ctrlKey || e.metaKey) {
                        e.preventDefault();
                        navigator.clipboard.writeText(this.textContent).then(() => {
                            // Show temporary feedback
                            const originalText = this.textContent;
                            this.textContent = 'Disalin!';
                            setTimeout(() => {
                                this.textContent = originalText;
                            }, 1000);
                        });
                    }
                });

                element.setAttribute('title', 'Ctrl+Click untuk menyalin URL');
            });
        });
    </script>
</body>
</html>
