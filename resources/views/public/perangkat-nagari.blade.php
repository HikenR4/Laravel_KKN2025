<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perangkat Nagari - Nagari Mungo</title>
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

        /* Hero Section for Perangkat */
        .hero-perangkat {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 8rem 0 4rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-perangkat::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="150" cy="120" r="70" fill="white" opacity="0.04"/><circle cx="1050" cy="250" r="90" fill="white" opacity="0.03"/><polygon points="600,60 660,110 600,160 540,110" fill="white" opacity="0.05"/></svg>');
            animation: gentleFloat 22s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-30px) translateY(-25px); }
            50% { transform: translateX(35px) translateY(20px); }
            100% { transform: translateX(-30px) translateY(-25px); }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            padding: 0 2rem;
        }

        .hero-perangkat h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-perangkat p {
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

        /* Perangkat Grid */
        .perangkat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            margin-bottom: 3rem;
        }

        .perangkat-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(220, 20, 60, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .perangkat-card::before {
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

        .perangkat-card:hover::before {
            transform: scaleX(1);
        }

        .perangkat-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(220, 20, 60, 0.2);
        }

        .perangkat-photo {
            position: relative;
            height: 250px;
            overflow: hidden;
        }

        .perangkat-photo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .perangkat-card:hover .perangkat-photo img {
            transform: scale(1.05);
        }

        .perangkat-status {
            position: absolute;
            top: 15px;
            right: 15px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .perangkat-content {
            padding: 2rem;
        }

        .perangkat-jabatan {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            color: #DC143C;
            padding: 0.5rem 1rem;
            border-radius: 15px;
            font-size: 0.9rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1rem;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        .perangkat-nama {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.5rem;
            line-height: 1.3;
        }

        .perangkat-nip {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .perangkat-info {
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
            color: #666;
        }

        .info-item i {
            color: #DC143C;
            width: 16px;
        }

        .perangkat-masa-jabatan {
            background: rgba(255, 245, 245, 0.7);
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid #DC143C;
            margin-top: 1rem;
        }

        .masa-jabatan-label {
            font-size: 0.8rem;
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 0.2rem;
        }

        .masa-jabatan-value {
            font-size: 0.9rem;
            color: #555;
            font-weight: 500;
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

        /* Stats Section */
        .stats-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            margin-bottom: 2rem;
        }

        .stats-title {
            color: #DC143C;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .stat-label {
            color: #666;
        }

        .stat-value {
            color: #DC143C;
            font-weight: 600;
        }

        /* Info Section */
        .info-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .info-section h4 {
            color: #DC143C;
            margin-bottom: 1rem;
            font-size: 1rem;
        }

        .info-section p {
            margin-bottom: 0.5rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-perangkat h1 {
                font-size: 2rem;
            }

            .hero-perangkat p {
                font-size: 1rem;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .perangkat-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .perangkat-content {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-perangkat h1 {
                font-size: 1.8rem;
            }

            .perangkat-grid {
                gap: 1.5rem;
            }

            .perangkat-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="hero-perangkat">
        <div class="hero-content">
            <h1>Perangkat Nagari Mungo</h1>
            <p>Mengenal sosok-sosok yang berperan dalam penyelenggaraan pemerintahan nagari</p>
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
                <span>Perangkat Nagari</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <div class="content-section">
                <h2 class="section-title">Struktur Perangkat Nagari</h2>

                @if($perangkat->count() > 0)
                    <div class="perangkat-grid">
                        @foreach($perangkat as $person)
                            <article class="perangkat-card">
                                <div class="perangkat-photo">
                                    <img src="{{ $person->foto }}" alt="Foto {{ $person->nama }}">
                                    @if($person->is_active)
                                        <span class="perangkat-status">Aktif</span>
                                    @endif
                                </div>

                                <div class="perangkat-content">
                                    <div class="perangkat-jabatan">{{ $person->jabatan }}</div>
                                    <h3 class="perangkat-nama">{{ $person->nama }}</h3>

                                    @if($person->nip)
                                        <div class="perangkat-nip">
                                            <i class="fas fa-id-card"></i>
                                            NIP: {{ $person->nip }}
                                        </div>
                                    @endif

                                    <div class="perangkat-info">
                                        @if($person->pendidikan)
                                            <div class="info-item">
                                                <i class="fas fa-graduation-cap"></i>
                                                <span>{{ $person->pendidikan }}</span>
                                            </div>
                                        @endif

                                        @if($person->telepon)
                                            <div class="info-item">
                                                <i class="fas fa-phone"></i>
                                                <span>{{ $person->telepon }}</span>
                                            </div>
                                        @endif

                                        @if($person->email)
                                            <div class="info-item">
                                                <i class="fas fa-envelope"></i>
                                                <span>{{ $person->email }}</span>
                                            </div>
                                        @endif

                                        @if($person->alamat)
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt"></i>
                                                <span>{{ Str::limit($person->alamat, 50) }}</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="perangkat-masa-jabatan">
                                        <div class="masa-jabatan-label">Masa Jabatan</div>
                                        <div class="masa-jabatan-value">{{ $person->masa_jabatan }}</div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-users"></i>
                        <h3>Belum Ada Data Perangkat</h3>
                        <p>Data perangkat nagari belum tersedia atau sedang dalam proses pemutakhiran.</p>
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
                    <a href="{{ route('profil.perangkat-nagari') }}" class="nav-link active">
                        <i class="fas fa-users"></i> Perangkat Nagari
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.data-wilayah') }}" class="nav-link">
                        <i class="fas fa-map"></i> Data Wilayah
                    </a>
                </li>
            </ul>

            @if($perangkat->count() > 0)
                <div class="stats-section">
                    <h4 class="stats-title">Statistik Perangkat</h4>
                    <div class="stat-item">
                        <span class="stat-label">Total Perangkat:</span>
                        <span class="stat-value">{{ $perangkat->count() }} orang</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-label">Status Aktif:</span>
                        <span class="stat-value">{{ $perangkat->where('is_active', true)->count() }} orang</span>
                    </div>
                </div>
            @endif

            <div class="info-section">
                <h4>Informasi Kontak</h4>
                <p>Untuk keperluan resmi dan komunikasi dengan perangkat nagari, silahkan hubungi kantor nagari.</p>
                <p><strong>Jam Kerja:</strong><br>Senin - Jumat: 08:00 - 16:00 WIB</p>
            </div>
        </aside>
    </div>
<!-- Include Footer -->
    @include('layouts.footer')
</body>
</html>
