<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }} - Portal Digital Masyarakat</title>
    @if(isset($profilNagari) && $profilNagari && $profilNagari->hasLogoFile())
        <link rel="icon" type="image/png" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="shortcut icon" type="image/png" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="apple-touch-icon" href="{{ $profilNagari->getLogoUrl() }}">
        <!-- untuk berbagai ukuran device -->
        <link rel="icon" type="image/png" sizes="16x16" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="apple-touch-icon" sizes="72x72" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="apple-touch-icon" sizes="114x114" href="{{ $profilNagari->getLogoUrl() }}">
        <link rel="apple-touch-icon" sizes="152x152" href="{{ $profilNagari->getLogoUrl() }}">
    @else
        <link rel="icon" type="image/png" href="{{ asset('images/default-logo.png') }}">
        <link rel="shortcut icon" type="image/png" href="{{ asset('images/default-logo.png') }}">
    @endif

    <meta name="description" content="{{ isset($profilNagari) && $profilNagari && $profilNagari->sejarah ? Str::limit(strip_tags($profilNagari->sejarah), 160) : 'Portal digital resmi untuk layanan masyarakat' }}">
    <meta name="keywords" content="nagari, {{ isset($profilNagari) && $profilNagari ? $profilNagari->nama_nagari : 'mungo' }}, layanan digital, pemerintahan">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ isset($profilNagari) && $profilNagari ? $profilNagari->nama_nagari : 'Nagari Mungo' }} - Portal Digital">
    <meta property="og:description" content="{{ isset($profilNagari) && $profilNagari && $profilNagari->sejarah ? Str::limit(strip_tags($profilNagari->sejarah), 160) : 'Portal digital resmi untuk layanan masyarakat' }}">
    @if(isset($profilNagari) && $profilNagari && $profilNagari->hasLogoFile())
        <meta property="og:image" content="{{ $profilNagari->getLogoUrl() }}">
    @endif
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($profilNagari) && $profilNagari ? $profilNagari->nama_nagari : 'Nagari Mungo' }} - Portal Digital">
    <meta name="twitter:description" content="{{ isset($profilNagari) && $profilNagari && $profilNagari->sejarah ? Str::limit(strip_tags($profilNagari->sejarah), 160) : 'Portal digital resmi untuk layanan masyarakat' }}">
    @if(isset($profilNagari) && $profilNagari && $profilNagari->hasLogoFile())
        <meta name="twitter:image" content="{{ $profilNagari->getLogoUrl() }}">
    @endif

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

        /* Perangkat Nagari Section */
        .perangkat-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFFAFA 50%, #FFF5F5 100%);
            position: relative;
            overflow: hidden;
        }

        .perangkat-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .perangkat-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .perangkat-badge {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .perangkat-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 700;
        }

        .perangkat-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
        }

        /* Slider Container */
        .perangkat-slider {
            position: relative;
            overflow: hidden;
            border-radius: 25px;
            background: white;
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.1);
            padding: 2rem;
        }

        .slider-wrapper {
            position: relative;
            overflow: hidden;
        }

        .slider-track {
            display: flex;
            transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .slide {
            min-width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .perangkat-card-slide {
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.05), rgba(220, 20, 60, 0.02));
            border-radius: 25px;
            padding: 3rem;
            text-align: center;
            max-width: 600px;
            width: 100%;
            border: 1px solid rgba(220, 20, 60, 0.1);
            position: relative;
            overflow: hidden;
        }

        .perangkat-card-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        }

        .perangkat-photo-slide {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            margin: 0 auto 2rem;
            overflow: hidden;
            position: relative;
            border: 5px solid white;
            box-shadow: 0 10px 30px rgba(220, 20, 60, 0.2);
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
        }

        .perangkat-photo-slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .perangkat-photo-slide img.error {
            display: none;
        }

        .perangkat-photo-slide .placeholder {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: #adb5bd;
            font-size: 3rem;
            text-align: center;
        }

        .perangkat-photo-slide img.error + .placeholder {
            display: block;
        }

        .perangkat-jabatan-slide {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.8rem 2rem;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 1.5rem;
            box-shadow: 0 6px 20px rgba(220, 20, 60, 0.3);
        }

        .perangkat-nama-slide {
            font-size: 2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .perangkat-nip-slide {
            color: #666;
            font-size: 1rem;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
        }

        .perangkat-info-slide {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 2rem;
        }

        .info-item-slide {
            background: rgba(255, 255, 255, 0.7);
            padding: 1rem;
            border-radius: 15px;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            font-size: 0.95rem;
            color: #555;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        .info-item-slide i {
            color: #DC143C;
            width: 20px;
            font-size: 1.1rem;
        }

        /* Slider Controls */
        .slider-controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 2rem;
        }

        .slider-btn {
            width: 50px;
            height: 50px;
            border: none;
            border-radius: 50%;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .slider-btn:hover {
            transform: translateY(-2px) scale(1.05);
            box-shadow: 0 6px 20px rgba(220, 20, 60, 0.4);
        }

        .slider-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
            transform: none;
        }

        /* Slider Indicators */
        .slider-indicators {
            display: flex;
            justify-content: center;
            gap: 0.5rem;
        }

        .indicator {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background: rgba(220, 20, 60, 0.3);
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .indicator.active {
            background: #DC143C;
            transform: scale(1.2);
        }

        /* Auto-play indicator */
        .auto-play-indicator {
            position: absolute;
            bottom: 1rem;
            right: 1rem;
            background: rgba(255, 255, 255, 0.9);
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            color: #DC143C;
            border: 1px solid rgba(220, 20, 60, 0.2);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .auto-play-indicator.paused {
            opacity: 0.6;
        }

        /* Progress bar for auto-play */
        .progress-bar {
            position: absolute;
            bottom: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            transition: width 0.1s ease;
            border-radius: 0 0 25px 25px;
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

        /* Empty state for perangkat */
        .perangkat-empty {
            text-align: center;
            padding: 4rem 2rem;
            color: #666;
        }

        .perangkat-empty i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.3;
            color: #DC143C;
        }

        .perangkat-empty h3 {
            font-size: 1.5rem;
            margin-bottom: 0.5rem;
            color: #333;
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

            .perangkat-title {
                font-size: 2rem;
            }

            .cta-section h2 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }

            .perangkat-card-slide {
                padding: 2rem;
            }

            .perangkat-nama-slide {
                font-size: 1.5rem;
            }

            .perangkat-photo-slide {
                width: 120px;
                height: 120px;
            }

            .slider-controls {
                gap: 0.5rem;
            }

            .slider-btn {
                width: 45px;
                height: 45px;
                font-size: 1rem;
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

            .perangkat-card-slide {
                padding: 1.5rem;
            }

            .perangkat-info-slide {
                grid-template-columns: 1fr;
            }

            .slider-controls {
                flex-direction: column;
                gap: 1rem;
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
                    <span class="hero-highlight">{{  'Nagari Mungo' }}</span>
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
                            {{ $profilNagari->video_deskripsi ?? 'Mengenal lebih dekat Nagari Mungo melalui potret kehidupan, budaya, dan aktivitas masyarakatnya' }}
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
        </div>
    </section>

    <!-- Perangkat Nagari Section -->
    <section class="perangkat-section">
        <div class="perangkat-container">
            <div class="perangkat-header">
                <div class="perangkat-badge">
                    <i class="fas fa-users"></i> Perangkat Nagari
                </div>
                <h2 class="perangkat-title">Kepemimpinan {{ $profilNagari->nama_nagari ?? 'Nagari Mungo' }}</h2>
                <p class="perangkat-subtitle">
                    Kenali sosok-sosok yang berperan dalam penyelenggaraan pemerintahan dan pelayanan masyarakat nagari
                </p>
            </div>

            @if(isset($perangkatNagari) && $perangkatNagari->count() > 0)
                <div class="perangkat-slider">
                    <div class="slider-wrapper">
                        <div class="slider-track" id="sliderTrack">
                            @foreach($perangkatNagari as $perangkat)
                                <div class="slide">
                                    <div class="perangkat-card-slide">
                                        <div class="perangkat-photo-slide">
                                            <img src="{{ asset('uploads/perangkat/' . $perangkat->foto) }}"
                                                 alt="Foto {{ $perangkat->nama }}"
                                                 onerror="this.classList.add('error')">
                                            <div class="placeholder">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>

                                        <div class="perangkat-jabatan-slide">{{ $perangkat->jabatan }}</div>
                                        <h3 class="perangkat-nama-slide">{{ $perangkat->nama }}</h3>

                                        @if($perangkat->nip)
                                            <div class="perangkat-nip-slide">
                                                <i class="fas fa-id-card"></i>
                                                NIP: {{ $perangkat->nip }}
                                            </div>
                                        @endif

                                        <div class="perangkat-info-slide">
                                            @if($perangkat->pendidikan)
                                                <div class="info-item-slide">
                                                    <i class="fas fa-graduation-cap"></i>
                                                    <span>{{ $perangkat->pendidikan }}</span>
                                                </div>
                                            @endif

                                            @if($perangkat->telepon)
                                                <div class="info-item-slide">
                                                    <i class="fas fa-phone"></i>
                                                    <span>{{ $perangkat->telepon }}</span>
                                                </div>
                                            @endif

                                            @if($perangkat->email)
                                                <div class="info-item-slide">
                                                    <i class="fas fa-envelope"></i>
                                                    <span>{{ $perangkat->email }}</span>
                                                </div>
                                            @endif

                                            @if($perangkat->alamat)
                                                <div class="info-item-slide">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                    <span>{{ Str::limit($perangkat->alamat, 50) }}</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="slider-controls">
                        <button class="slider-btn" id="prevBtn">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        <div class="slider-indicators" id="sliderIndicators">
                            @for($i = 0; $i < $perangkatNagari->count(); $i++)
                                <div class="indicator {{ $i === 0 ? 'active' : '' }}" data-slide="{{ $i }}"></div>
                            @endfor
                        </div>

                        <button class="slider-btn" id="nextBtn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>

                    <div class="auto-play-indicator" id="autoPlayIndicator">
                        <i class="fas fa-play"></i>
                        <span>Auto Play</span>
                    </div>

                    <div class="progress-bar" id="progressBar"></div>
                </div>
            @else
                <div class="perangkat-empty">
                    <i class="fas fa-users"></i>
                    <h3>Data Perangkat Belum Tersedia</h3>
                    <p>Informasi perangkat nagari sedang dalam proses pemutakhiran dan akan segera hadir.</p>
                </div>
            @endif
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
        // Perangkat Nagari Slider functionality
        document.addEventListener('DOMContentLoaded', function() {
            const sliderTrack = document.getElementById('sliderTrack');
            const prevBtn = document.getElementById('prevBtn');
            const nextBtn = document.getElementById('nextBtn');
            const indicators = document.querySelectorAll('.indicator');
            const autoPlayIndicator = document.getElementById('autoPlayIndicator');
            const progressBar = document.getElementById('progressBar');

            if (!sliderTrack) return; // Exit if no slider exists

            let currentSlide = 0;
            const totalSlides = indicators.length;
            let isAutoPlaying = true;
            let autoPlayInterval;
            let progressInterval;
            const autoPlayDuration = 5000; // 5 seconds

            // Initialize slider
            function initSlider() {
                updateSliderPosition();
                updateIndicators();
                updateButtons();

                if (totalSlides > 1) {
                    startAutoPlay();
                }
            }

            // Update slider position
            function updateSliderPosition() {
                const translateX = -currentSlide * 100;
                sliderTrack.style.transform = `translateX(${translateX}%)`;
            }

            // Update active indicator
            function updateIndicators() {
                indicators.forEach((indicator, index) => {
                    indicator.classList.toggle('active', index === currentSlide);
                });
            }

            // Update button states
            function updateButtons() {
                if (prevBtn && nextBtn) {
                    prevBtn.disabled = totalSlides <= 1;
                    nextBtn.disabled = totalSlides <= 1;
                }
            }

            // Go to specific slide
            function goToSlide(slideIndex) {
                currentSlide = slideIndex;
                updateSliderPosition();
                updateIndicators();
                resetAutoPlay();
            }

            // Next slide
            function nextSlide() {
                currentSlide = (currentSlide + 1) % totalSlides;
                updateSliderPosition();
                updateIndicators();
            }

            // Previous slide
            function prevSlide() {
                currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
                updateSliderPosition();
                updateIndicators();
            }

            // Start auto play
            function startAutoPlay() {
                if (!isAutoPlaying || totalSlides <= 1) return;

                autoPlayInterval = setInterval(() => {
                    nextSlide();
                }, autoPlayDuration);

                startProgressBar();

                if (autoPlayIndicator) {
                    autoPlayIndicator.classList.remove('paused');
                }
            }

            // Stop auto play
            function stopAutoPlay() {
                clearInterval(autoPlayInterval);
                clearInterval(progressInterval);

                if (progressBar) {
                    progressBar.style.width = '0%';
                }

                if (autoPlayIndicator) {
                    autoPlayIndicator.classList.add('paused');
                }
            }

            // Reset auto play
            function resetAutoPlay() {
                stopAutoPlay();
                if (isAutoPlaying && totalSlides > 1) {
                    setTimeout(startAutoPlay, 100);
                }
            }

            // Progress bar animation
            function startProgressBar() {
                if (!progressBar) return;

                let progress = 0;
                const increment = 100 / (autoPlayDuration / 50); // Update every 50ms

                progressInterval = setInterval(() => {
                    progress += increment;
                    progressBar.style.width = `${Math.min(progress, 100)}%`;

                    if (progress >= 100) {
                        progress = 0;
                    }
                }, 50);
            }

            // Event listeners
            if (nextBtn) {
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    resetAutoPlay();
                });
            }

            if (prevBtn) {
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    resetAutoPlay();
                });
            }

            // Indicator clicks
            indicators.forEach((indicator, index) => {
                indicator.addEventListener('click', () => {
                    goToSlide(index);
                });
            });

            // Auto play toggle
            if (autoPlayIndicator) {
                autoPlayIndicator.addEventListener('click', () => {
                    isAutoPlaying = !isAutoPlaying;

                    if (isAutoPlaying) {
                        startAutoPlay();
                    } else {
                        stopAutoPlay();
                    }

                    const icon = autoPlayIndicator.querySelector('i');
                    const text = autoPlayIndicator.querySelector('span');

                    if (icon && text) {
                        if (isAutoPlaying) {
                            icon.className = 'fas fa-play';
                            text.textContent = 'Auto Play';
                        } else {
                            icon.className = 'fas fa-pause';
                            text.textContent = 'Paused';
                        }
                    }
                });
            }

            // Pause on hover
            const sliderContainer = document.querySelector('.perangkat-slider');
            if (sliderContainer) {
                sliderContainer.addEventListener('mouseenter', () => {
                    if (isAutoPlaying) {
                        stopAutoPlay();
                    }
                });

                sliderContainer.addEventListener('mouseleave', () => {
                    if (isAutoPlaying && totalSlides > 1) {
                        startAutoPlay();
                    }
                });
            }

            // Touch/swipe support for mobile
            let startX = 0;
            let endX = 0;

            if (sliderContainer) {
                sliderContainer.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                }, { passive: true });

                sliderContainer.addEventListener('touchmove', (e) => {
                    endX = e.touches[0].clientX;
                }, { passive: true });

                sliderContainer.addEventListener('touchend', () => {
                    const diffX = startX - endX;
                    const threshold = 50; // Minimum swipe distance

                    if (Math.abs(diffX) > threshold) {
                        if (diffX > 0) {
                            // Swipe left - next slide
                            nextSlide();
                        } else {
                            // Swipe right - previous slide
                            prevSlide();
                        }
                        resetAutoPlay();
                    }
                }, { passive: true });
            }

            // Keyboard navigation
            document.addEventListener('keydown', (e) => {
                if (e.key === 'ArrowLeft') {
                    prevSlide();
                    resetAutoPlay();
                } else if (e.key === 'ArrowRight') {
                    nextSlide();
                    resetAutoPlay();
                } else if (e.key === ' ') { // Spacebar to toggle auto play
                    e.preventDefault();
                    if (autoPlayIndicator) {
                        autoPlayIndicator.click();
                    }
                }
            });

            // Initialize the slider
            initSlider();
        });

        // Video player functionality - Previous code remains the same
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
