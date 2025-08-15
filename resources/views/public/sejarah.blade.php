<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejarah - Nagari Mungo</title>
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

        /* Hero Section for Sejarah */
        .hero-sejarah {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 8rem 0 4rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
            min-height: 400px;
            display: flex;
            align-items: center;
        }

        /* Banner Background */
        .hero-sejarah.has-banner {
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-sejarah.has-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.85) 0%, rgba(220, 20, 60, 0.85) 25%, rgba(178, 34, 34, 0.85) 50%, rgba(139, 0, 0, 0.85) 75%, rgba(102, 0, 0, 0.85) 100%);
            z-index: 1;
        }

        .hero-sejarah::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.05"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.03"/><polygon points="600,50 650,100 600,150 550,100" fill="white" opacity="0.04"/></svg>');
            animation: gentleFloat 20s infinite linear;
            z-index: 1;
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
            width: 100%;
        }

        .hero-sejarah h1 {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.5);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-sejarah p {
            font-size: 1.2rem;
            opacity: 0.95;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Banner Info */
        .banner-info {
            position: absolute;
            bottom: 10px;
            right: 15px;
            z-index: 3;
            background: rgba(0, 0, 0, 0.6);
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            font-size: 0.8rem;
            opacity: 0.8;
            transition: opacity 0.3s ease;
        }

        .banner-info:hover {
            opacity: 1;
        }

        .banner-info i {
            margin-right: 5px;
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
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
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

        /* Banner Preview Section */
        .banner-preview {
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.1s both;
        }

        .banner-preview-title {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .banner-preview-title i {
            color: #DC143C;
        }

        .banner-container {
            position: relative;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.15);
            margin-bottom: 1rem;
        }

        .banner-image {
            width: 100%;
            height: auto;
            object-fit: contain;
            display: block;
            transition: transform 0.3s ease;
        }

        .banner-container:hover .banner-image {
            transform: scale(1.05);
        }

        .banner-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(220, 20, 60, 0.1));
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .banner-container:hover .banner-overlay {
            opacity: 1;
        }

        .banner-overlay-text {
            color: white;
            font-weight: 600;
            text-shadow: 0 2px 10px rgba(0,0,0,0.5);
            text-align: center;
            padding: 1rem;
        }

        .banner-info-box {
            background: rgba(255, 245, 245, 0.5);
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid #DC143C;
            font-size: 0.9rem;
            color: #666;
        }

        .banner-placeholder {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            border: 2px dashed rgba(220, 20, 60, 0.3);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            color: #666;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .banner-placeholder i {
            font-size: 3rem;
            color: rgba(220, 20, 60, 0.3);
            margin-bottom: 1rem;
        }

        /* Video Section */
        .video-section {
            margin-bottom: 3rem;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        .video-title {
            font-size: 1.5rem;
            color: #333;
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .video-title i {
            color: #DC143C;
        }

        .video-container {
            position: relative;
            width: 100%;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.15);
            background: #000;
            margin-bottom: 1rem;
        }

        .video-wrapper {
            position: relative;
            width: 100%;
            height: 0;
            padding-bottom: 56.25%; /* 16:9 aspect ratio */
        }

        .video-wrapper video,
        .video-wrapper iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        .video-controls {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            padding: 1rem;
            transform: translateY(100%);
            transition: transform 0.3s ease;
        }

        .video-container:hover .video-controls {
            transform: translateY(0);
        }

        .video-info {
            background: rgba(255, 245, 245, 0.5);
            padding: 1rem;
            border-radius: 10px;
            border-left: 4px solid #DC143C;
            margin-top: 1rem;
        }

        .video-description {
            color: #666;
            line-height: 1.6;
            margin-bottom: 0.5rem;
        }

        .video-meta {
            display: flex;
            gap: 1rem;
            font-size: 0.9rem;
            color: #888;
            flex-wrap: wrap;
        }

        .video-meta span {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .video-meta i {
            color: #DC143C;
        }

        .video-placeholder {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.05));
            border: 2px dashed rgba(220, 20, 60, 0.3);
            border-radius: 15px;
            padding: 3rem;
            text-align: center;
            color: #666;
        }

        .video-placeholder i {
            font-size: 3rem;
            color: rgba(220, 20, 60, 0.3);
            margin-bottom: 1rem;
        }

        .sejarah-content {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
            text-align: justify;
            text-justify: inter-word;
        }

        .sejarah-content p {
            margin-bottom: 1.5rem;
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
            word-wrap: break-word;
        }

        .sejarah-content h3 {
            color: #DC143C;
            font-size: 1.3rem;
            margin: 2rem 0 1rem;
            font-weight: 600;
        }

        .timeline {
            position: relative;
            margin: 2rem 0;
            padding-left: 2rem;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 15px;
            top: 0;
            height: 100%;
            width: 3px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 2px;
        }

        .timeline-item {
            position: relative;
            margin-bottom: 2rem;
            background: rgba(255, 245, 245, 0.5);
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #DC143C;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: -2.2rem;
            top: 1.5rem;
            width: 12px;
            height: 12px;
            background: #DC143C;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.2);
        }

        .timeline-year {
            font-weight: 700;
            color: #DC143C;
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .timeline-content {
            color: #666;
            line-height: 1.6;
            text-align: justify;
            text-justify: inter-word;
            hyphens: auto;
            -webkit-hyphens: auto;
            -ms-hyphens: auto;
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
            .hero-sejarah h1 {
                font-size: 2rem;
            }

            .hero-sejarah p {
                font-size: 1rem;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .content-section {
                padding: 2rem;
            }

            .sidebar {
                position: static;
            }

            .timeline {
                padding-left: 1.5rem;
            }

            .timeline-item {
                padding: 1rem;
            }

            .timeline-item::before {
                left: -1.7rem;
            }

            .video-meta {
                flex-direction: column;
                gap: 0.5rem;
            }

            .banner-image {
                height: 150px;
            }

            .banner-info {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-sejarah h1 {
                font-size: 1.8rem;
            }

            .content-section {
                padding: 1.5rem;
            }

            .sejarah-content,
            .sejarah-content p,
            .timeline-content {
                text-align: left;
            }

            .video-wrapper {
                padding-bottom: 75%; /* More mobile-friendly aspect ratio */
            }

            .banner-image {
                height: 120px;
            }

            .banner-placeholder {
                height: 120px;
                padding: 1.5rem;
            }

            .banner-placeholder i {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <section class="hero-sejarah">
    <div class="hero-content">
        <h1>Sejarah Nagari Mungo</h1>
        <p>Mengenal jejak panjang perjalanan dan perkembangan Nagari Mungo dari masa ke masa</p>
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
                <span>Sejarah</span>
            </nav>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <article class="content-section">
                <h2 class="section-title">Sejarah Nagari Mungo</h2>

                <!-- Video Section -->
                @if($profil && ($profil->hasVideoFile() || $profil->hasExternalVideo()))
                <div class="video-section">
                    <h3 class="video-title">
                        <i class="fas fa-video"></i>
                        Video Profil Nagari
                    </h3>

                    <div class="video-container">
                        <div class="video-wrapper">
                            @if($profil->hasExternalVideo())
                                <!-- External Video (YouTube, Vimeo, etc.) -->
                                <iframe
                                    src="{{ $profil->video_embed_url }}"
                                    allowfullscreen
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture">
                                </iframe>
                            @elseif($profil->hasVideoFile())
                                <!-- Local Video File -->
                                <video controls preload="metadata">
                                    <source src="{{ $profil->video_url }}" type="video/mp4">
                                    <source src="{{ $profil->video_url }}" type="video/webm">
                                    <source src="{{ $profil->video_url }}" type="video/ogg">
                                    Browser Anda tidak mendukung tag video.
                                </video>
                            @endif
                        </div>
                    </div>

                    @if($profil->video_deskripsi || $profil->video_durasi || $profil->video_size)
                    <div class="video-info">
                        @if($profil->video_deskripsi)
                        <div class="video-description">
                            {{ $profil->video_deskripsi }}
                        </div>
                        @endif

                        <div class="video-meta">
                            @if($profil->video_durasi)
                            <span>
                                <i class="fas fa-clock"></i>
                                {{ $profil->video_durasi_formatted }}
                            </span>
                            @endif

                            @if($profil->video_size && !$profil->hasExternalVideo())
                            <span>
                                <i class="fas fa-file-video"></i>
                                {{ $profil->video_size_formatted }}
                            </span>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @endif

                <!-- Banner Preview Section -->
                @if($profil && $profil->hasBannerFile())
                <div class="banner-preview">
                    <h3 class="banner-preview-title">
                        <i class="fas fa-image"></i>
                        Peta Nagari
                    </h3>

                    <div class="banner-container">
                        <img src="{{ $profil->getBannerUrl() }}" alt="Banner Nagari Mungo" class="banner-image">

                    </div>
                </div>
                @endif

                <div class="sejarah-content">
                    @if($profil && $profil->sejarah)
                        {!! nl2br(e($profil->sejarah)) !!}
                    @else
                        <p>Nagari Mungo merupakan salah satu nagari yang memiliki sejarah panjang dalam perkembangan peradaban di wilayah Sumatera Barat. Nama "Mungo" sendiri memiliki makna historis yang dalam, yang terkait erat dengan kondisi geografis dan budaya masyarakat setempat.</p>

                        <h3>Asal Usul Nama</h3>
                        <p>Kata "Mungo" berasal dari bahasa lokal yang memiliki arti khusus dalam konteks sejarah daerah ini. Menurut cerita turun temurun dari para tetua adat, nama ini pertama kali digunakan oleh para pendiri nagari yang datang pada masa lalu.</p>

                        <h3>Perkembangan Sejarah</h3>
                        <div class="timeline">
                            <div class="timeline-item">
                                <div class="timeline-year">Abad ke-16</div>
                                <div class="timeline-content">
                                    Periode awal pendirian nagari dengan sistem pemerintahan tradisional Minangkabau. Wilayah ini mulai dihuni oleh suku-suku yang berasal dari berbagai daerah di Sumatera Barat.
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-year">Abad ke-18</div>
                                <div class="timeline-content">
                                    Masa perkembangan sistem adat dan budaya Minangkabau yang semakin menguat. Pembentukan struktur ninik mamak dan penerapan hukum adat yang berlaku hingga saat ini.
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-year">Abad ke-19</div>
                                <div class="timeline-content">
                                    Periode masuknya pengaruh Islam yang semakin kuat dan pembangunan surau-surau sebagai pusat pendidikan dan keagamaan masyarakat.
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-year">Abad ke-20</div>
                                <div class="timeline-content">
                                    Era modernisasi dengan pembangunan infrastruktur, pendidikan formal, dan sistem pemerintahan modern yang terintegrasi dengan sistem adat tradisional.
                                </div>
                            </div>

                            <div class="timeline-item">
                                <div class="timeline-year">Abad ke-21</div>
                                <div class="timeline-content">
                                    Masa kini dengan pengembangan teknologi informasi, pelayanan publik modern, dan upaya pelestarian budaya tradisional dalam era globalisasi.
                                </div>
                            </div>
                        </div>

                        <h3>Warisan Budaya</h3>
                        <p>Nagari Mungo memiliki berbagai warisan budaya yang masih terjaga hingga saat ini, termasuk rumah gadang, tradisi adat istiadat, dan berbagai upacara tradisional yang mencerminkan kekayaan budaya Minangkabau.</p>

                        <p>Keberadaan Nagari Mungo tidak hanya sebagai sebuah wilayah administratif, tetapi juga sebagai penjaga nilai-nilai luhur budaya Minangkabau yang tetap relevan di era modern ini.</p>
                    @endif
                </div>
            </article>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <h3 class="sidebar-title">Menu Profil</h3>
            <ul class="nav-menu">
                <li class="nav-item">
                    <a href="{{ route('profil.sejarah') }}" class="nav-link active">
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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle video error
            const videos = document.querySelectorAll('video');
            videos.forEach(video => {
                video.addEventListener('error', function() {
                    console.error('Error loading video:', this.src);
                    const container = this.closest('.video-container');
                    if (container) {
                        container.innerHTML = `
                            <div class="video-placeholder">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Video tidak dapat dimuat</p>
                            </div>
                        `;
                    }
                });
            });

            // Handle iframe error
            const iframes = document.querySelectorAll('iframe');
            iframes.forEach(iframe => {
                iframe.addEventListener('error', function() {
                    console.error('Error loading iframe:', this.src);
                    const container = this.closest('.video-container');
                    if (container) {
                        container.innerHTML = `
                            <div class="video-placeholder">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Video eksternal tidak dapat dimuat</p>
                            </div>
                        `;
                    }
                });
            });

            // Banner image click handler
            const bannerImage = document.querySelector('.banner-image');
            if (bannerImage) {
                bannerImage.addEventListener('click', function() {
                    // Create modal or lightbox to view full banner
                    const modal = document.createElement('div');
                    modal.style.cssText = `
                        position: fixed;
                        top: 0;
                        left: 0;
                        width: 100%;
                        height: 100%;
                        background: rgba(0,0,0,0.9);
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        z-index: 9999;
                        cursor: pointer;
                    `;

                    const img = document.createElement('img');
                    img.src = this.src;
                    img.style.cssText = `
                        max-width: 90%;
                        max-height: 90%;
                        object-fit: contain;
                        border-radius: 10px;
                        box-shadow: 0 20px 60px rgba(0,0,0,0.5);
                    `;

                    modal.appendChild(img);
                    document.body.appendChild(modal);

                    modal.addEventListener('click', function() {
                        document.body.removeChild(modal);
                    });
                });
            }
        });
    </script>
</body>
</html>
