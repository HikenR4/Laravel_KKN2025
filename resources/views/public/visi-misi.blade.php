<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visi Misi - Nagari Mungo</title>
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

        /* Hero Section for Visi Misi */
        .hero-visi-misi {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 8rem 0 4rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-visi-misi::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="200" cy="150" r="60" fill="white" opacity="0.04"/><circle cx="1000" cy="200" r="100" fill="white" opacity="0.03"/><polygon points="600,80 680,120 600,160 520,120" fill="white" opacity="0.05"/></svg>');
            animation: gentleFloat 25s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-40px) translateY(-20px); }
            50% { transform: translateX(40px) translateY(25px); }
            100% { transform: translateX(-40px) translateY(-20px); }
        }

        .hero-content {
            max-width: 800px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
            padding: 0 2rem;
        }

        .hero-visi-misi h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-visi-misi p {
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

        /* Visi Section */
        .visi-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            margin-bottom: 2rem;
            position: relative;
            overflow: hidden;
        }

        .visi-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        }

        .visi-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }

        .section-title {
            font-size: 2rem;
            color: #333;
            margin-bottom: 2rem;
            font-weight: 700;
            position: relative;
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

        .visi-content {
            font-size: 1.2rem;
            line-height: 1.8;
            color: #444;
            background: rgba(255, 245, 245, 0.5);
            padding: 2rem;
            border-radius: 15px;
            border-left: 5px solid #DC143C;
            font-style: italic;
            position: relative;
        }

        .visi-content::before {
            content: '"';
            font-size: 4rem;
            color: rgba(220, 20, 60, 0.2);
            position: absolute;
            top: -10px;
            left: 10px;
            font-family: serif;
        }

        /* Misi Section */
        .misi-section {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            position: relative;
            overflow: hidden;
        }

        .misi-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 6px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        }

        .misi-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }

        .misi-list {
            list-style: none;
        }

        .misi-item {
            display: flex;
            align-items: flex-start;
            margin-bottom: 1.5rem;
            padding: 1.5rem;
            background: rgba(255, 245, 245, 0.3);
            border-radius: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-left: 4px solid transparent;
        }

        .misi-item:hover {
            background: rgba(255, 245, 245, 0.6);
            border-left-color: #DC143C;
            transform: translateX(5px);
            box-shadow: 0 5px 20px rgba(220, 20, 60, 0.1);
        }

        .misi-number {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            margin-right: 1.5rem;
            flex-shrink: 0;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .misi-text {
            font-size: 1.1rem;
            line-height: 1.7;
            color: #555;
            flex: 1;
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

        /* Info Section */
        .info-section {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
            margin-top: 2rem;
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
            .hero-visi-misi h1 {
                font-size: 2rem;
            }

            .hero-visi-misi p {
                font-size: 1rem;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .visi-section,
            .misi-section {
                padding: 2rem;
            }

            .sidebar {
                position: static;
            }

            .misi-item {
                flex-direction: column;
                text-align: center;
            }

            .misi-number {
                margin-right: 0;
                margin-bottom: 1rem;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-visi-misi h1 {
                font-size: 1.8rem;
            }

            .visi-section,
            .misi-section {
                padding: 1.5rem;
            }

            .visi-content {
                padding: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section class="hero-visi-misi">
        <div class="hero-content">
            <h1>Visi & Misi Nagari Mungo</h1>
            <p>Arah dan tujuan pembangunan nagari untuk menciptakan masyarakat yang sejahtera dan berkarakter</p>
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
                <span>Visi Misi</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <div class="content-section">
                <!-- Visi Section -->
                <article class="visi-section">
                    <div class="visi-icon">
                        <i class="fas fa-eye"></i>
                    </div>
                    <h2 class="section-title">Visi Nagari Mungo</h2>

                    <div class="visi-content">
                        @if($profil && $profil->visi)
                            {{ $profil->visi }}
                        @else
                            Terwujudnya Nagari Mungo yang maju, mandiri, sejahtera, dan berkarakter berdasarkan nilai-nilai adat Minangkabau dan agama Islam
                        @endif
                    </div>
                </article>

                <!-- Misi Section -->
                <article class="misi-section">
                    <div class="misi-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                    <h2 class="section-title">Misi Nagari Mungo</h2>

                    <ul class="misi-list">
                        @if($profil && $profil->misi)
                            @php
                                $misiArray = explode("\n", $profil->misi);
                                $misiArray = array_filter(array_map('trim', $misiArray));
                            @endphp
                            @foreach($misiArray as $index => $misi)
                                @if(!empty($misi))
                                    <li class="misi-item">
                                        <div class="misi-number">{{ $index + 1 }}</div>
                                        <div class="misi-text">{{ $misi }}</div>
                                    </li>
                                @endif
                            @endforeach
                        @else
                            <li class="misi-item">
                                <div class="misi-number">1</div>
                                <div class="misi-text">Meningkatkan kualitas pelayanan publik yang prima, transparan, dan akuntabel untuk kesejahteraan masyarakat</div>
                            </li>
                            <li class="misi-item">
                                <div class="misi-number">2</div>
                                <div class="misi-text">Mengembangkan potensi ekonomi lokal berbasis sumber daya alam dan budaya untuk meningkatkan kesejahteraan masyarakat</div>
                            </li>
                            <li class="misi-item">
                                <div class="misi-number">3</div>
                                <div class="misi-text">Membangun infrastruktur yang mendukung peningkatan kualitas hidup dan aksesibilitas masyarakat</div>
                            </li>
                            <li class="misi-item">
                                <div class="misi-number">4</div>
                                <div class="misi-text">Melestarikan dan mengembangkan nilai-nilai budaya Minangkabau serta memperkuat keharmonisan sosial</div>
                            </li>
                            <li class="misi-item">
                                <div class="misi-number">5</div>
                                <div class="misi-text">Meningkatkan kualitas pendidikan dan kesehatan masyarakat sebagai investasi masa depan</div>
                            </li>
                            <li class="misi-item">
                                <div class="misi-number">6</div>
                                <div class="misi-text">Mewujudkan tata kelola pemerintahan yang bersih, partisipatif, dan berorientasi pada kepentingan masyarakat</div>
                            </li>
                        @endif
                    </ul>
                </article>
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
                    <a href="{{ route('profil.visi-misi') }}" class="nav-link active">
                        <i class="fas fa-eye"></i> Visi Misi
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.perangkat-nagari') }}" class="nav-link">
                        <i class="fas fa-users"></i> Perangkat Nagari
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profil.data-wilayah') }}" class="nav-link">
                        <i class="fas fa-map"></i> Data Wilayah
                    </a>
                </li>
            </ul>

            <div class="info-section">
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
            </div>
        </aside>
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

</body>
</html>
