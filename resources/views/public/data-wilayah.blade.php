<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Wilayah - Nagari Mungo</title>
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
        }

        /* Hero Section for Data Wilayah */
        .hero-wilayah {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 8rem 0 4rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-wilayah::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="180" cy="140" r="65" fill="white" opacity="0.04"/><circle cx="1020" cy="220" r="85" fill="white" opacity="0.03"/><polygon points="600,70 670,115 600,160 530,115" fill="white" opacity="0.05"/></svg>');
            animation: gentleFloat 18s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-35px) translateY(-20px); }
            50% { transform: translateX(30px) translateY(25px); }
            100% { transform: translateX(-35px) translateY(-20px); }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            padding: 0 2rem;
        }

        .hero-wilayah h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-wilayah p {
            font-size: 1.2rem;
            opacity: 0.95;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Breadcrumb */
        .breadcrumb {
            background: white;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
        }

        .breadcrumb-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .breadcrumb-nav {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.9rem;
        }

        .breadcrumb-nav a {
            color: #DC143C;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .breadcrumb-nav a:hover {
            color: #B22222;
        }

        .breadcrumb-nav span {
            color: #666;
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

        .content-section {
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
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

        /* Stats Cards Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .stat-card::before {
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

        .stat-card:hover::before {
            transform: scaleX(1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            color: #DC143C;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            font-size: 1rem;
            color: #666;
            font-weight: 500;
        }

        /* Info Sections */
        .info-sections {
            display: grid;
            gap: 2rem;
        }

        .info-section {
            background: white;
            border-radius: 20px;
            padding: 2.5rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .info-section h3 {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 700;
            position: relative;
        }

        .info-section h3::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 60px;
            height: 3px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 2px;
        }

        /* Geographical Info */
        .geo-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .geo-item {
            background: rgba(255, 245, 245, 0.5);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #DC143C;
            transition: all 0.3s ease;
        }

        .geo-item:hover {
            background: rgba(255, 245, 245, 0.8);
            transform: translateX(5px);
        }

        .geo-label {
            font-size: 0.9rem;
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .geo-value {
            font-size: 1.1rem;
            color: #333;
            font-weight: 500;
        }

        /* Boundaries */
        .boundaries-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
        }

        .boundary-item {
            background: rgba(255, 245, 245, 0.3);
            padding: 1.2rem;
            border-radius: 12px;
            text-align: center;
            border: 2px solid rgba(220, 20, 60, 0.1);
            transition: all 0.3s ease;
        }

        .boundary-item:hover {
            border-color: rgba(220, 20, 60, 0.3);
            background: rgba(255, 245, 245, 0.6);
        }

        .boundary-direction {
            font-size: 0.8rem;
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
        }

        .boundary-value {
            font-size: 0.95rem;
            color: #555;
            line-height: 1.4;
        }

        /* RT/RW Statistics */
        .rt-rw-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .rt-rw-section {
            background: rgba(255, 245, 245, 0.3);
            padding: 1.5rem;
            border-radius: 15px;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        .rt-rw-title {
            font-size: 1.1rem;
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 1rem;
            text-align: center;
        }

        .rt-rw-list {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(60px, 1fr));
            gap: 0.5rem;
        }

        .rt-rw-item {
            background: white;
            padding: 0.5rem;
            border-radius: 8px;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid rgba(220, 20, 60, 0.1);
            transition: all 0.3s ease;
        }

        .rt-rw-item:hover {
            background: #DC143C;
            color: white;
        }

        .rt-rw-number {
            font-weight: 600;
            color: #DC143C;
        }

        .rt-rw-item:hover .rt-rw-number {
            color: white;
        }

        .rt-rw-count {
            font-size: 0.8rem;
            color: #666;
        }

        .rt-rw-item:hover .rt-rw-count {
            color: rgba(255, 255, 255, 0.9);
        }

        /* Age Statistics */
        .age-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 1rem;
        }

        .age-item {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            text-align: center;
            border: 1px solid rgba(220, 20, 60, 0.1);
            transition: all 0.3s ease;
        }

        .age-item:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.15);
        }

        .age-range {
            font-size: 0.9rem;
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .age-count {
            font-size: 1.8rem;
            color: #333;
            font-weight: 700;
        }

        .age-label {
            font-size: 0.8rem;
            color: #666;
            margin-top: 0.3rem;
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
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        }

        .sidebar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
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

        .nav-menu {
            list-style: none;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            color: #666;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: block;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
        }

        .nav-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            transition: left 0.3s ease;
        }

        .nav-link:hover {
            color: #DC143C;
            transform: translateX(8px);
        }

        .nav-link:hover::before {
            left: 0;
        }

        .nav-link.active {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            color: #DC143C !important;
            transform: translateX(8px);
            border-left: 4px solid #DC143C;
            font-weight: 600;
        }

        .nav-link.active::before {
            left: 0;
        }

        /* Quick Stats Sidebar */
        .quick-stats {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .quick-stats-title {
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .quick-stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .quick-stat-label {
            color: #666;
        }

        .quick-stat-value {
            color: #DC143C;
            font-weight: 600;
        }

        /* Info Section Sidebar */
        .sidebar-info-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .sidebar-info-section h4 {
            color: #DC143C;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .sidebar-info-section p {
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-wilayah h1 {
                font-size: 2rem;
            }

            .hero-wilayah p {
                font-size: 1rem;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .rt-rw-grid {
                grid-template-columns: 1fr;
            }

            .geo-info {
                grid-template-columns: 1fr;
            }

            .boundaries-grid {
                grid-template-columns: 1fr 1fr;
            }

            .sidebar {
                position: static;
            }

            .info-section {
                padding: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-wilayah h1 {
                font-size: 1.8rem;
            }

            .stats-grid {
                gap: 1.5rem;
            }

            .stat-card {
                padding: 1.5rem;
            }

            .info-section {
                padding: 1.5rem;
            }

            .boundaries-grid {
                grid-template-columns: 1fr;
            }

            .age-stats {
                grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="hero-wilayah">
        <div class="hero-content">
            <h1>Data Wilayah Nagari Mungo</h1>
            <p>Informasi geografis, administratif, dan demografi wilayah nagari</p>
        </div>
    </section>

    <!-- Breadcrumb -->
    <section class="breadcrumb">
        <div class="breadcrumb-container">
            <nav class="breadcrumb-nav">
                <a href="{{ url('/') }}">
                    <i class="fas fa-home"></i> Beranda
                </a>
                <span><i class="fas fa-chevron-right"></i></span>
                <a href="#">Profil</a>
                <span><i class="fas fa-chevron-right"></i></span>
                <span>Data Wilayah</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <div class="content-section">
                <h2 class="section-title">Statistik Kependudukan</h2>

                <!-- Population Statistics -->
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number">{{ number_format($totalPenduduk) }}</div>
                        <div class="stat-label">Total Penduduk</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-male"></i>
                        </div>
                        <div class="stat-number">{{ number_format($pendudukPria) }}</div>
                        <div class="stat-label">Penduduk Pria</div>
                    </div>

                    <div class="stat-card">
                        <div class="stat-icon">
                            <i class="fas fa-female"></i>
                        </div>
                        <div class="stat-number">{{ number_format($pendudukWanita) }}</div>
                        <div class="stat-label">Penduduk Wanita</div>
                    </div>
                </div>

                <!-- Age Distribution -->
                <div class="info-section">
                    <h3>Distribusi Usia Penduduk</h3>
                    <div class="age-stats">
                        <div class="age-item">
                            <div class="age-range">0-17 Tahun</div>
                            <div class="age-count">{{ number_format($statistikUsia['0-17']) }}</div>
                            <div class="age-label">Anak & Remaja</div>
                        </div>
                        <div class="age-item">
                            <div class="age-range">18-59 Tahun</div>
                            <div class="age-count">{{ number_format($statistikUsia['18-59']) }}</div>
                            <div class="age-label">Usia Produktif</div>
                        </div>
                        <div class="age-item">
                            <div class="age-range">60+ Tahun</div>
                            <div class="age-count">{{ number_format($statistikUsia['60+']) }}</div>
                            <div class="age-label">Lansia</div>
                        </div>
                    </div>
                </div>

                <!-- Administrative Division -->
                <div class="info-section">
                    <h3>Pembagian Wilayah Administratif</h3>
                    <div class="rt-rw-grid">
                        <div class="rt-rw-section">
                            <div class="rt-rw-title">Rukun Tetangga (RT)</div>
                            <div class="rt-rw-list">
                                @if($jumlahRT > 0)
                                    @foreach($statistikRT as $rt => $jumlah)
                                        <div class="rt-rw-item">
                                            <div class="rt-rw-number">RT {{ $rt }}</div>
                                            <div class="rt-rw-count">{{ $jumlah }} jiwa</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="rt-rw-item">
                                        <div class="rt-rw-number">-</div>
                                        <div class="rt-rw-count">Belum ada data</div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="rt-rw-section">
                            <div class="rt-rw-title">Rukun Warga (RW)</div>
                            <div class="rt-rw-list">
                                @if($jumlahRW > 0)
                                    @foreach($statistikRW as $rw => $jumlah)
                                        <div class="rt-rw-item">
                                            <div class="rt-rw-number">RW {{ $rw }}</div>
                                            <div class="rt-rw-count">{{ $jumlah }} jiwa</div>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="rt-rw-item">
                                        <div class="rt-rw-number">-</div>
                                        <div class="rt-rw-count">Belum ada data</div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Geographical Information -->
                @if($profil)
                <div class="info-section">
                    <h3>Informasi Geografis</h3>
                    <div class="geo-info">
                        @if($profil->luas_wilayah)
                            <div class="geo-item">
                                <div class="geo-label">Luas Wilayah</div>
                                <div class="geo-value">{{ $profil->luas_wilayah }}</div>
                            </div>
                        @endif

                        @if($profil->koordinat_lat && $profil->koordinat_lng)
                            <div class="geo-item">
                                <div class="geo-label">Koordinat</div>
                                <div class="geo-value">{{ $profil->koordinat_lat }}, {{ $profil->koordinat_lng }}</div>
                            </div>
                        @endif

                        <div class="geo-item">
                            <div class="geo-label">Jumlah RT</div>
                            <div class="geo-value">{{ $jumlahRT }} RT</div>
                        </div>

                        <div class="geo-item">
                            <div class="geo-label">Jumlah RW</div>
                            <div class="geo-value">{{ $jumlahRW }} RW</div>
                        </div>
                    </div>
                </div>

                <!-- Boundaries -->
                <div class="info-section">
                    <h3>Batas Wilayah</h3>
                    <div class="boundaries-grid">
                        <div class="boundary-item">
                            <div class="boundary-direction">Utara</div>
                            <div class="boundary-value">{{ $profil->batas_utara ?? 'Belum tersedia' }}</div>
                        </div>
                        <div class="boundary-item">
                            <div class="boundary-direction">Selatan</div>
                            <div class="boundary-value">{{ $profil->batas_selatan ?? 'Belum tersedia' }}</div>
                        </div>
                        <div class="boundary-item">
                            <div class="boundary-direction">Timur</div>
                            <div class="boundary-value">{{ $profil->batas_timur ?? 'Belum tersedia' }}</div>
                        </div>
                        <div class="boundary-item">
                            <div class="boundary-direction">Barat</div>
                            <div class="boundary-value">{{ $profil->batas_barat ?? 'Belum tersedia' }}</div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Menu Profil</h3>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('profil.sejarah') }}" class="nav-link">
                        <i class="fas fa-history"></i> Sejarah
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.visi-misi') }}" class="nav-link">
                        <i class="fas fa-eye"></i> Visi Misi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.perangkat-nagari') }}" class="nav-link">
                        <i class="fas fa-users"></i> Perangkat Nagari
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.data-wilayah') }}" class="nav-link active">
                        <i class="fas fa-map"></i> Data Wilayah
                    </a>
                </li>
            </ul>

            <div class="quick-stats">
                <h4 class="quick-stats-title">Ringkasan Data</h4>
                <div class="quick-stat-item">
                    <span class="quick-stat-label">Total Penduduk:</span>
                    <span class="quick-stat-value">{{ number_format($totalPenduduk) }}</span>
                </div>
                <div class="quick-stat-item">
                    <span class="quick-stat-label">Jumlah RT:</span>
                    <span class="quick-stat-value">{{ $jumlahRT }}</span>
                </div>
                <div class="quick-stat-item">
                    <span class="quick-stat-label">Jumlah RW:</span>
                    <span class="quick-stat-value">{{ $jumlahRW }}</span>
                </div>
                @if($profil && $profil->luas_wilayah)
                <div class="quick-stat-item">
                    <span class="quick-stat-label">Luas Wilayah:</span>
                    <span class="quick-stat-value">{{ $profil->luas_wilayah }}</span>
                </div>
                @endif
            </div>

            <div class="sidebar-info-section">
                <h4>Informasi</h4>
                <p><strong>Nagari:</strong> {{ $profil->nama_nagari ?? 'Nagari Mungo' }}</p>
                @if($profil && $profil->alamat)
                    <p><strong>Alamat:</strong> {{ $profil->alamat }}</p>
                @endif
                @if($profil && $profil->telepon)
                    <p><strong>Telepon:</strong> {{ $profil->telepon }}</p>
                @endif
                @if($profil && $profil->email)
                    <p><strong>Email:</strong> {{ $profil->email }}</p>
                @endif
                <p><small><em>Data diperbarui secara berkala berdasarkan pendataan terbaru.</em></small></p>
            </div>
        </aside>
    </div>
    <!-- Include Footer -->
    @include('layouts.footer')
</body>
</html>
