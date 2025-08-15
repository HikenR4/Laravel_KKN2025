<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }} - Portal Digital Masyarakat</title>
    <meta name="description" content="{{ $profilNagari && $profilNagari->sejarah ? Str::limit(strip_tags($profilNagari->sejarah), 160) : 'Portal digital resmi untuk layanan masyarakat' }}">
    <meta name="keywords" content="nagari, {{ $profilNagari->nama_nagari ?? 'mungo' }}, layanan digital, pemerintahan">


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
            overflow-x: hidden;
        }


        /* Hero Section */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFF5F5 40%, #FFE4E1 70%, #FF9999 100%);
            display: flex;
            align-items: center;
            position: relative;
            padding-top: 70px;
        }


        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }


        .hero-content {
            color: #333;
        }


        .hero-badge {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            color: #DC143C;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            border: 1px solid rgba(220, 20, 60, 0.2);
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.1);
        }


        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: #333;
        }


        .hero-highlight {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }


        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.6;
        }


        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }


        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }


        .btn-primary {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }


        .btn-secondary {
            background: white;
            color: #DC143C;
            border: 2px solid #DC143C;
        }


        .btn:hover {
            transform: translateY(-2px);
        }


        .btn-primary:hover {
            box-shadow: 0 12px 35px rgba(220, 20, 60, 0.4);
        }


        .btn-secondary:hover {
            background: #DC143C;
            color: white;
        }


        /* Video Section - Enhanced */
        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        .video-container {
            background: white;
            border-radius: 25px;
            padding: 1.2rem;
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
            max-width: 500px;
            width: 100%;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }


        .video-player {
            width: 100%;
            height: 280px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            background: #f8f9fa;
        }


        .video-player video {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            opacity: 1;
        }


        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0,0,0,0.1), rgba(0,0,0,0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            transition: all 0.3s ease;
        }


        .video-player img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 20px;
            /* Memastikan gambar langsung terlihat */
            opacity: 1;
        }


        .play-button {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC143C;
            font-size: 2rem;
            transition: all 0.3s ease;
            backdrop-filter: blur(15px);
            border: 3px solid rgba(255,255,255,0.3);
            cursor: pointer;


        }


        .video-player:hover .play-button {
            background: white;
            transform: scale(1.1);
        }


        .video-player.playing .video-overlay {
            opacity: 0;
            pointer-events: none;
        }


        /* Video embed styles */
        .video-embed {
            width: 100%;
            height: 100%;
            border: none;
            border-radius: 20px;
        }


        .video-info {
            padding: 1.5rem;
            text-align: center;
        }


        .video-title {
            color: #DC143C;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }


        .video-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }


        .video-stats {
            display: flex;
            justify-content: space-around;
            padding-top: 1rem;
            border-top: 1px solid rgba(220, 20, 60, 0.1);
        }


        .video-stat {
            text-align: center;
        }


        .video-stat-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: #DC143C;
            margin-bottom: 0.2rem;
        }


        .video-stat-label {
            font-size: 0.8rem;
            color: #666;
        }


        /* Statistics Section */
        .statistics {
            padding: 3rem 0;
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(10px);
        }


        .statistics-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }


        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 2rem;
            text-align: center;
        }


        .stat-item {
            background: white;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.08);
            transition: all 0.3s ease;
            border: 1px solid rgba(220, 20, 60, 0.05);
        }


        .stat-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
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


        /* Features Section */
        .features {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFFAFA 50%, #FFF5F5 100%);
        }


        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }


        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }


        .section-badge {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }


        .section-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 700;
        }


        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }


        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }


        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 25px;
            text-align: center;
            transition: all 0.3s ease;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.08);
            border: 1px solid rgba(220, 20, 60, 0.05);
        }


        .feature-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.15);
        }


        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: all 0.3s ease;
        }


        .feature-card:hover .feature-icon {
            transform: scale(1.05);
        }


        .feature-card h3 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
        }


        .feature-card:hover h3 {
            color: #DC143C;
        }


        .feature-card p {
            color: #666;
            line-height: 1.6;
        }


        /* Process Section */
        .process {
            padding: 5rem 0;
            background: white;
        }


        .process-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }


        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }


        .process-step {
            text-align: center;
            position: relative;
        }


        .step-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }


        .process-step h3 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 600;
        }


        .process-step p {
            color: #666;
            line-height: 1.6;
        }


        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 50%, #B22222 100%);
            color: white;
            text-align: center;
        }


        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
        }


        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
        }


        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }


        .cta-button {
            background: white;
            color: #DC143C;
            padding: 1.2rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
        }


        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(255, 255, 255, 0.3);
            background: #DC143C;
            color: white;
        }


        /* Error states */
        .error-message {
            text-align: center;
            padding: 2rem;
            color: #666;
            background: rgba(220, 20, 60, 0.05);
            border-radius: 10px;
            margin: 1rem 0;
        }


        /* Loading states */
        .loading {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 200px;
        }


        .spinner {
            width: 50px;
            height: 50px;
            border: 3px solid rgba(220, 20, 60, 0.2);
            border-top: 3px solid #DC143C;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }


        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }


        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }


            .hero h1 {
                font-size: 2.5rem;
            }


            .section-title {
                font-size: 2rem;
            }


            .cta-section h2 {
                font-size: 2rem;
            }


            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
        }


        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }


            .features-grid {
                grid-template-columns: 1fr;
            }


            .feature-card {
                padding: 2rem;
            }


            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')


    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-star"></i> Portal Digital Terpercaya
                </div>
                <h1>
                    Layanan Digital
                    <span class="hero-highlight">{{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }}</span>
                    untuk Masa Depan
                </h1>
                <p>
                    @if($profilNagari && $profilNagari->sejarah)
                        {{ Str::limit(strip_tags($profilNagari->sejarah), 200) }}
                    @else
                        Akses semua layanan administrasi, informasi terkini, dan berpartisipasi dalam pembangunan nagari melalui platform digital yang mudah dan cepat.
                    @endif
                </p>
                <div class="hero-buttons">
                    <!-- Login Button - Update href untuk mengarah ke halaman login admin -->
                    <a href="{{ route('admin.login') }}" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Login Admin
                    </a>
                    <a href="{{ route('berita') }}" class="btn btn-secondary">
                        <i class="fas fa-newspaper"></i>
                        Lihat Berita
                    </a>
                </div>
            </div>


            <div class="hero-visual">
                <div class="video-container">
                    <div class="video-player" id="videoPlayer">
                        @if($profilNagari && $profilNagari->hasVideoFile())
                            <!-- Local Video File -->
                            <video id="localVideo" preload="metadata" poster="{{ $profilNagari->getBannerUrl() }}">
                                <source src="{{ $profilNagari->getVideoUrl() }}" type="video/mp4">
                                Browser Anda tidak mendukung video HTML5.
                            </video>
                        @elseif($profilNagari && $profilNagari->hasExternalVideo())
                            <!-- External Video (YouTube/Vimeo) -->
                            <iframe id="externalVideo"
                                    class="video-embed"
                                    data-src="{{ $profilNagari->video_embed_url }}"
                                    frameborder="0"
                                    allowfullscreen>
                            </iframe>
                        @else
                            <!-- Placeholder when no video is available -->
                            <div class="video-placeholder">
                                <img src="{{ $profilNagari ? $profilNagari->getBannerUrl() : asset('images/default-banner.jpg') }}"
                                     alt="Profil {{ $profilNagari->nama_nagari ?? 'Nagari' }}"
                                     style="width: 100%; height: 100%; object-fit: cover; border-radius: 20px;">
                            </div>
                        @endif


                        <div class="video-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>


                    <div class="video-info">
                        <h3 class="video-title">
                            Profil {{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }}
                        </h3>
                        <p class="video-subtitle">
                            {{ $profilNagari->video_deskripsi ?? 'Kenali lebih dekat nagari dan layanan digitalnya' }}
                        </p>
                        <div class="video-stats">
                            <div class="video-stat">
                                <div class="video-stat-number" id="videoViews">{{ $videoViews ?? '1.9K' }}</div>
                                <div class="video-stat-label">Views</div>
                            </div>
                            <div class="video-stat">
                                <div class="video-stat-number">
                                    {{ $profilNagari && $profilNagari->video_durasi_formatted ? $profilNagari->video_durasi_formatted : '5:42' }}
                                </div>
                                <div class="video-stat-label">Duration</div>
                            </div>
                            <div class="video-stat">
                                <div class="video-stat-number">
                                    @if($profilNagari && $profilNagari->video_size_formatted)
                                        {{ $profilNagari->video_size_formatted }}
                                    @else
                                        HD
                                    @endif
                                </div>
                                <div class="video-stat-label">
                                    @if($profilNagari && $profilNagari->video_size_formatted)
                                        Size
                                    @else
                                        Quality
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>


    <!-- Features Section -->
    <section id="layanan" class="features">
        <div class="features-container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-gem"></i> Layanan Unggulan
                </div>
                <h2 class="section-title">Semua yang Anda Butuhkan dalam Satu Platform</h2>
                <p class="section-subtitle">
                    Platform digital terintegrasi untuk memudahkan akses layanan publik dan informasi nagari
                </p>
            </div>


            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Permohonan Surat Online</h3>
                    <p>Ajukan surat keterangan, domisili, dan dokumen lainnya secara online tanpa perlu datang ke kantor nagari</p>
                </div>


                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Data Kependudukan Real-time</h3>
                    <p>Akses informasi statistik dan data kependudukan nagari yang selalu update dan akurat</p>
                </div>


                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Agenda & Kegiatan</h3>
                    <p>Pantau jadwal kegiatan, rapat, dan acara nagari agar tidak ketinggalan informasi penting</p>
                </div>


                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Pengumuman Resmi</h3>
                    <p>Dapatkan informasi dan pengumuman resmi dari pemerintah nagari secara langsung</p>
                </div>


                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Profil Nagari Lengkap</h3>
                    <p>Informasi komprehensif tentang sejarah, visi misi, dan struktur pemerintahan nagari</p>
                </div>


                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Layanan Bantuan 24/7</h3>
                    <p>Tim support siap membantu Anda kapan saja untuk pertanyaan dan kendala teknis</p>
                </div>
            </div>
        </div>
    </section>


    <!-- Process Section -->
    <section id="tentang" class="process">
        <div class="process-container">
            <div class="section-header">
                <div class="section-badge">
                    <i class="fas fa-cogs"></i> Cara Kerja
                </div>
                <h2 class="section-title">Mudah Digunakan dalam 3 Langkah</h2>
                <p class="section-subtitle">
                    Sistem yang dirancang untuk kemudahan masyarakat dengan proses yang simple dan efisien
                </p>
            </div>


            <div class="process-steps">
                <div class="process-step">
                    <div class="step-number">1</div>
                    <h3>Daftar & Verifikasi</h3>
                    <p>Daftarkan diri dengan NIK dan data personal untuk verifikasi identitas sebagai warga nagari</p>
                </div>


                <div class="process-step">
                    <div class="step-number">2</div>
                    <h3>Pilih Layanan</h3>
                    <p>Pilih layanan yang dibutuhkan dari dashboard dan lengkapi formulir sesuai persyaratan</p>
                </div>


                <div class="process-step">
                    <div class="step-number">3</div>
                    <h3>Terima Hasil</h3>
                    <p>Pantau status permohonan dan terima hasil layanan melalui email atau download langsung</p>
                </div>
            </div>
        </div>
    </section>


    <!-- CTA Section -->
    <section id="login" class="cta-section">
        <div class="cta-container">
            <h2>Siap Merasakan Kemudahan Layanan Digital?</h2>
            <p>Bergabunglah dengan ribuan warga {{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }} yang sudah merasakan kemudahan layanan digital kami</p>
            <a href="{{ route('admin.login') }}" class="cta-button">
                <i class="fas fa-sign-in-alt"></i>
                Login Sekarang
            </a>
        </div>
    </section>


    <!-- Include Footer -->
    @include('layouts.footer')


    <script>
        // Video player functionality
        // Video player functionality - Updated for the new structure
        document.addEventListener('DOMContentLoaded', function() {
            const videoPlayer = document.getElementById('videoPlayer');
            const localVideo = document.getElementById('localVideo');
            const externalVideo = document.getElementById('externalVideo');
            const videoPlaceholder = document.querySelector('.video-placeholder');
            const playButton = document.querySelector('.play-button');
            const videoOverlay = document.querySelector('.video-overlay');


            if (videoPlayer && playButton) {
                videoPlayer.addEventListener('click', function() {
                    playVideo();
                });
            }


            function playVideo() {
                // Animate play button
                if (playButton) {
                    playButton.style.transform = 'scale(0.9)';
                    setTimeout(() => {
                        playButton.style.transform = 'scale(1.1)';
                    }, 150);
                }


                // Handle local video
                if (localVideo) {
                    if (localVideo.paused) {
                        localVideo.play().then(() => {
                            videoPlayer.classList.add('playing');
                            incrementVideoViews('local');
                        }).catch(error => {
                            console.error('Error playing video:', error);
                            showVideoError();
                        });
                    } else {
                        localVideo.pause();
                        videoPlayer.classList.remove('playing');
                    }
                }


                // Handle external video (iframe)
                else if (externalVideo) {
                    const src = externalVideo.getAttribute('data-src');
                    if (src && !externalVideo.getAttribute('src')) {
                        externalVideo.setAttribute('src', src);
                        videoPlayer.classList.add('playing');
                        incrementVideoViews('external');
                    }
                }


                // Handle placeholder (no video available)
                else if (videoPlaceholder) {
                    showNoVideoMessage();
                }
            }


            // Handle video end
            if (localVideo) {
                localVideo.addEventListener('ended', function() {
                    videoPlayer.classList.remove('playing');
                });


                // Handle video error
                localVideo.addEventListener('error', function() {
                    console.error('Video loading error');
                    showVideoError();
                });
            }


            function incrementVideoViews(videoType) {
                fetch('/api/profil-video/increment-views', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '',
                    },
                    body: JSON.stringify({
                        video_type: videoType
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        updateVideoViews(data.formatted_views || data.views);
                    }
                })
                .catch(error => {
                    console.error('Error incrementing views:', error);
                });
            }


            function updateVideoViews(newViews) {
                const viewsElement = document.getElementById('videoViews');
                if (viewsElement && newViews) {
                    viewsElement.textContent = newViews;
                }
            }


            function showVideoError() {
                const videoInfo = document.querySelector('.video-info');
                if (videoInfo) {
                    const errorMessage = document.createElement('div');
                    errorMessage.style.cssText = 'text-align: center; padding: 1rem; color: #666; background: #f8f9fa; border-radius: 10px; margin-top: 1rem;';
                    errorMessage.innerHTML = `
                        <i class="fas fa-exclamation-triangle" style="font-size: 1.5rem; color: #DC143C; margin-bottom: 0.5rem;"></i>
                        <p style="margin: 0; font-size: 0.9rem;">Video tidak dapat dimuat. Silakan coba lagi nanti.</p>
                    `;
                    videoInfo.appendChild(errorMessage);
                }
            }


            function showNoVideoMessage() {
                // Create a more user-friendly notification
                const notification = document.createElement('div');
                notification.style.cssText = `
                    position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);
                    background: white; padding: 2rem; border-radius: 15px;
                    box-shadow: 0 10px 30px rgba(0,0,0,0.3); z-index: 1000;
                    text-align: center; max-width: 400px; width: 90%;
                `;
                notification.innerHTML = `
                    <i class="fas fa-video" style="font-size: 3rem; color: #DC143C; margin-bottom: 1rem;"></i>
                    <h3 style="color: #333; margin-bottom: 1rem;">Video Profil Segera Hadir</h3>
                    <p style="color: #666; line-height: 1.6; margin-bottom: 1.5rem;">
                        Video profil ${document.querySelector('.hero-highlight')?.textContent || 'Nagari'} sedang dalam proses pembuatan dan akan segera tersedia untuk memberikan informasi lengkap tentang nagari.
                    </p>
                    <button onclick="this.parentElement.remove()" style="
                        background: #DC143C; color: white; border: none; padding: 0.75rem 2rem;
                        border-radius: 25px; cursor: pointer; font-weight: 600;
                    ">Tutup</button>
                `;
                document.body.appendChild(notification);


                // Auto close after 5 seconds
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 5000);
            }
        });


        // Smooth scroll for navigation
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


        // Animation on scroll
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


        // Observe elements for animation
        document.querySelectorAll('.feature-card, .process-step, .stat-item').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(20px)';
            el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
            observer.observe(el);
        });


        // Counter animation for statistics
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-number');
            counters.forEach(counter => {
                const target = parseInt(counter.textContent.replace(/[^0-9]/g, ''));
                if (isNaN(target) || target === 0) return;


                let current = 0;
                const increment = target / 100;
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }


                    // Format number with commas
                    if (target >= 1000) {
                        counter.textContent = Math.floor(current).toLocaleString();
                    } else {
                        counter.textContent = Math.floor(current);
                    }
                }, 20);
            });
        }


        // Trigger counter animation when statistics section is visible
        const statsObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.5 });


        const statsSection = document.querySelector('.statistics');
        if (statsSection) {
            statsObserver.observe(statsSection);
        }


        // Loading states and error handling
        window.addEventListener('load', function() {
            // Hide any loading spinners
            document.querySelectorAll('.loading').forEach(el => {
                el.style.display = 'none';
            });


            // Fade in content
            document.body.style.opacity = '1';
        });


        // Handle image loading errors
        document.querySelectorAll('img').forEach(img => {
            img.addEventListener('error', function() {
                this.style.display = 'none';
            });
        });


        // Error handling for missing elements
        window.addEventListener('error', function(e) {
            console.error('JavaScript error:', e.error);
            // Don't show errors to users, just log them
        });
    </script>
</body>
</html>