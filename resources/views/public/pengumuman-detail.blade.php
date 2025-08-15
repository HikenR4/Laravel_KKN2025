<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $pengumuman->judul }} - Nagari Mungo</title>
    <meta name="description" content="{{ Str::limit(strip_tags($pengumuman->konten), 150) }}">
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

        /* Hero Section - RED GRADIENT THEME */
        .hero-detail {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 10rem 0 4rem;
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
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.08"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.06"/></svg>');
            animation: gentleFloat 20s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-50px) translateY(-30px); }
            50% { transform: translateX(30px) translateY(20px); }
            100% { transform: translateX(-50px) translateY(-30px); }
        }

        .hero-content {
            max-width: 1000px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .breadcrumb {
            margin-bottom: 2rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .breadcrumb a {
            color: white;
            text-decoration: none;
            transition: opacity 0.3s ease;
        }

        .breadcrumb a:hover {
            opacity: 0.8;
        }

        .breadcrumb span {
            margin: 0 0.5rem;
        }

        .hero-meta {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 2rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .hero-category {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 600;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .priority-badge {
            background: linear-gradient(135deg, #FF4444, #CC0000);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 15px;
            font-size: 0.8rem;
            font-weight: 600;
            animation: pulse 2s infinite;
            box-shadow: 0 4px 15px rgba(255, 68, 68, 0.3);
        }

        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.7; }
        }

        .hero-date {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            opacity: 0.9;
            font-size: 0.9rem;
        }

        .hero-title {
            font-size: 2.8rem;
            font-weight: 700;
            margin-bottom: 1rem;
            line-height: 1.3;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        /* Main Content */
        .main-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 3rem;
        }

        .content-article {
            background: white;
            border-radius: 25px;
            box-shadow: 0 20px 60px rgba(220, 20, 60, 0.12);
            overflow: hidden;
            border: 1px solid rgba(220, 20, 60, 0.08);
            position: relative;
        }

        .content-article::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
        }

        /* Featured Image Section */
        .article-featured-image {
            width: 100%;
            height: 400px;
            overflow: hidden;
            position: relative;
        }

        .article-featured-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.4s ease;
        }

        .article-featured-image:hover img {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: linear-gradient(transparent, rgba(0,0,0,0.7));
            padding: 2rem;
            color: white;
        }

        .image-caption {
            font-size: 0.9rem;
            font-style: italic;
            opacity: 0.9;
        }

        .article-header {
            padding: 2.5rem;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.02), rgba(255, 107, 107, 0.01));
        }

        .article-meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            color: #666;
            font-size: 0.95rem;
            padding: 0.8rem;
            background: rgba(220, 20, 60, 0.05);
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .meta-item:hover {
            background: rgba(220, 20, 60, 0.1);
            transform: translateY(-2px);
        }

        .meta-item i {
            color: #DC143C;
            width: 18px;
            font-size: 1rem;
        }

        .validity-period {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            border-left: 4px solid #DC143C;
            position: relative;
        }

        .validity-period::before {
            content: '\f017';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: -8px;
            left: 15px;
            background: #DC143C;
            color: white;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.7rem;
        }

        .validity-title {
            font-weight: 700;
            color: #DC143C;
            margin-bottom: 1rem;
            font-size: 1.1rem;
        }

        .validity-item {
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .validity-item strong {
            color: #333;
            font-weight: 600;
        }

        .article-content {
            padding: 2.5rem;
        }


.content-body {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            /* Tambahan CSS untuk mengatasi teks panjang */
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            word-break: break-word;
            max-width: 100%;
            overflow: hidden;
        }

        .content-body h1, .content-body h2, .content-body h3 {
            color: #DC143C;
            margin: 2rem 0 1rem;
            font-weight: 600;
            /* Tambahan untuk heading */
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .content-body h1 {
            font-size: 1.8rem;
            word-break: break-word;
        }
        .content-body h2 {
            font-size: 1.5rem;
            word-break: break-word;
        }
        .content-body h3 {
            font-size: 1.3rem;
            word-break: break-word;
        }

        .content-body p {
            margin-bottom: 1.5rem;
            text-align: justify;
            /* Tambahan untuk paragraf */
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
            white-space: pre-wrap; /* Mempertahankan line break dari nl2br() */
        }

        .content-body ul, .content-body ol {
            margin: 1rem 0 1.5rem 2rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        .content-body li {
            margin-bottom: 0.5rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .content-body blockquote {
            background: rgba(220, 20, 60, 0.05);
            border-left: 4px solid #DC143C;
            padding: 1.5rem;
            margin: 2rem 0;
            font-style: italic;
            border-radius: 0 15px 15px 0;
            position: relative;
            /* Tambahan untuk blockquote */
            word-wrap: break-word;
            overflow-wrap: break-word;
            hyphens: auto;
        }

        .content-body blockquote::before {
            content: '\f10d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 15px;
            left: 15px;
            color: #DC143C;
            font-size: 1.2rem;
            opacity: 0.3;
        }

        /* Tambahan CSS untuk mengatasi teks panjang tanpa spasi */
        .content-body * {
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        /* Khusus untuk link panjang */
        .content-body a {
            word-break: break-all;
            overflow-wrap: break-word;
        }

        /* Untuk kode atau text monospace */
        .content-body code,
        .content-body pre {
            word-wrap: break-word;
            overflow-wrap: break-word;
            white-space: pre-wrap;
            max-width: 100%;
            overflow-x: auto;
        }

        /* Responsive tambahan untuk mobile */
        @media (max-width: 768px) {
            .content-body {
                font-size: 1rem;
                word-break: break-word;
                overflow-wrap: break-word;
            }

            .content-body h1 { font-size: 1.5rem; }
            .content-body h2 { font-size: 1.3rem; }
            .content-body h3 { font-size: 1.1rem; }
        }

        @media (max-width: 480px) {
            .content-body {
                font-size: 0.95rem;
                line-height: 1.6;
            }
        }

        /* Share Section */
        .share-section {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.05), rgba(255, 107, 107, 0.02));
            padding: 2rem 2.5rem;
            border-top: 1px solid rgba(220, 20, 60, 0.1);
        }

        .share-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .share-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .share-btn {
            padding: 0.8rem 1.5rem;
            border: none;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .share-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s ease;
        }

        .share-facebook {
            background: linear-gradient(135deg, #1877F2, #166FE5);
            color: white;
            box-shadow: 0 4px 15px rgba(24, 119, 242, 0.3);
        }

        .share-twitter {
            background: linear-gradient(135deg, #1DA1F2, #1A91DA);
            color: white;
            box-shadow: 0 4px 15px rgba(29, 161, 242, 0.3);
        }

        .share-whatsapp {
            background: linear-gradient(135deg, #25D366, #20BA5A);
            color: white;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.3);
        }

        .share-copy {
            background: linear-gradient(135deg, #6B7280, #4B5563);
            color: white;
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.3);
        }

        .share-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        }

        .share-btn:hover::before {
            left: 100%;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        .sidebar-widget {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 35px rgba(220, 20, 60, 0.1);
            border: 1px solid rgba(220, 20, 60, 0.05);
            transition: all 0.3s ease;
        }

        .sidebar-widget:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 45px rgba(220, 20, 60, 0.15);
        }

        .widget-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            padding-bottom: 0.8rem;
            border-bottom: 2px solid rgba(220, 20, 60, 0.1);
            position: relative;
        }

        .widget-title::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 50px;
            height: 2px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 2px;
        }

        /* Related Announcements */
        .related-item {
            padding: 1.2rem 0;
            border-bottom: 1px solid rgba(220, 20, 60, 0.1);
            transition: all 0.3s ease;
            text-decoration: none;
            display: block;
        }

        .related-item:last-child {
            border-bottom: none;
        }

        .related-item:hover {
            transform: translateX(8px);
        }

        .related-title {
            font-size: 1rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            transition: color 0.3s ease;
        }

        .related-item:hover .related-title {
            color: #DC143C;
        }

        .related-meta {
            font-size: 0.85rem;
            color: #666;
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .related-category {
            background: rgba(220, 20, 60, 0.1);
            color: #DC143C;
            padding: 0.3rem 0.8rem;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .related-date {
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        /* Important Info Widget */
        .important-info {
            background: linear-gradient(135deg, #FFF3CD, #FCF3CF);
            border: 2px solid #F4D03F;
            border-radius: 15px;
            padding: 1.8rem;
            position: relative;
        }

        .important-info::before {
            content: '\f071';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: -12px;
            left: 20px;
            background: linear-gradient(135deg, #F39C12, #E67E22);
            color: white;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            box-shadow: 0 4px 15px rgba(243, 156, 18, 0.3);
        }

        .important-info h4 {
            color: #B7950B;
            margin-bottom: 0.8rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .important-info p {
            color: #7D6608;
            font-size: 0.9rem;
            margin: 0;
            line-height: 1.6;
        }

        /* Contact Info */
        .contact-info {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.05), rgba(255, 107, 107, 0.02));
            border-radius: 15px;
            padding: 1.5rem;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.2rem;
            padding: 0.5rem;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .contact-item:hover {
            background: rgba(220, 20, 60, 0.08);
            transform: translateX(5px);
        }

        .contact-item:last-child {
            margin-bottom: 0;
        }

        .contact-icon {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1rem;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
            transition: all 0.3s ease;
        }

        .contact-item:hover .contact-icon {
            transform: scale(1.1);
        }

        .contact-text {
            flex: 1;
        }

        .contact-label {
            font-size: 0.8rem;
            color: #666;
            margin-bottom: 0.3rem;
            font-weight: 500;
        }

        .contact-value {
            font-weight: 600;
            color: #333;
            font-size: 0.95rem;
        }

        /* Back to List */
        .back-to-list {
            position: fixed;
            bottom: 2rem;
            right: 2rem;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            box-shadow: 0 6px 25px rgba(220, 20, 60, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 1000;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
        }

        .back-to-list:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 10px 35px rgba(220, 20, 60, 0.5);
            color: white;
        }

        /* Stats Widget */
        .stats-widget {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .stat-item {
            text-align: center;
            padding: 1rem;
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            border-radius: 12px;
            transition: all 0.3s ease;
        }

        .stat-item:hover {
            transform: translateY(-3px);
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.15), rgba(255, 107, 107, 0.08));
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            color: #DC143C;
            margin-bottom: 0.3rem;
        }

        .stat-label {
            font-size: 0.8rem;
            color: #666;
            font-weight: 500;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.2rem;
            }

            .hero-meta {
                flex-direction: column;
                align-items: flex-start;
                gap: 1rem;
            }

            .main-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .article-meta {
                grid-template-columns: 1fr;
            }

            .share-buttons {
                justify-content: center;
            }

            .back-to-list {
                bottom: 1rem;
                right: 1rem;
                padding: 0.8rem 1rem;
            }

            .back-to-list span {
                display: none;
            }

            .stats-widget {
                grid-template-columns: 1fr;
            }

            .contact-item {
                flex-direction: column;
                text-align: center;
            }

            .article-featured-image {
                height: 250px;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .hero-title {
                font-size: 1.8rem;
            }

            .article-header,
            .article-content,
            .share-section {
                padding: 1.8rem;
            }

            .sidebar-widget {
                padding: 1.5rem;
            }

            .article-featured-image {
                height: 200px;
            }
        }

        /* Animation */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Copy notification */
        .copy-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            background: linear-gradient(135deg, #10B981, #059669);
            color: white;
            padding: 1rem 1.5rem;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(16, 185, 129, 0.3);
            transform: translateX(400px);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            z-index: 9999;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .copy-notification.show {
            transform: translateX(0);
        }

        /* Image Zoom Modal */
        .image-modal {
            display: none;
            position: fixed;
            z-index: 10000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.9);
            animation: fadeIn 0.3s ease;
        }

        .image-modal.show {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            max-width: 90%;
            max-height: 90%;
            object-fit: contain;
            border-radius: 10px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
        }

        .close-modal {
            position: absolute;
            top: 20px;
            right: 35px;
            color: white;
            font-size: 40px;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: #DC143C;
        }

        @keyframes fadeIn {
            from {opacity: 0;}
            to {opacity: 1;}
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
                <a href="{{ route('pengumuman') }}">Pengumuman</a>
                <span>/</span>
                <span>{{ Str::limit($pengumuman->judul, 50) }}</span>
            </nav>

            <div class="hero-meta">
                <span class="hero-category">{{ ucfirst($pengumuman->kategori) }}</span>
                @if($pengumuman->penting)
                    <span class="priority-badge">
                        <i class="fas fa-exclamation"></i> PENTING
                    </span>
                @endif
                <div class="hero-date">
                    <i class="fas fa-calendar"></i>
                    {{ $pengumuman->tanggal_mulai->format('d F Y') }}
                    @if($pengumuman->tanggal_berakhir)
                        - {{ $pengumuman->tanggal_berakhir->format('d F Y') }}
                    @endif
                </div>
            </div>

            <h1 class="hero-title">{{ $pengumuman->judul }}</h1>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-container">
        <main>
            <article class="content-article fade-in">
                <!-- Featured Image -->
                @if($pengumuman->gambar)
                <div class="article-featured-image" onclick="openImageModal('{{ asset('uploads/pengumuman/' . basename($pengumuman->gambar)) }}')">
                    <img src="{{ asset('uploads/pengumuman/' . basename($pengumuman->gambar)) }}"
                         alt="{{ $pengumuman->alt_gambar ?? $pengumuman->judul }}"
                         loading="lazy">
                    <div class="image-overlay">
                        @if($pengumuman->alt_gambar)
                            <div class="image-caption">{{ $pengumuman->alt_gambar }}</div>
                        @endif
                        <div style="position: absolute; top: 1rem; right: 1rem; background: rgba(0,0,0,0.5); padding: 0.5rem; border-radius: 50%; cursor: pointer;">
                            <i class="fas fa-expand-alt" style="color: white; font-size: 0.9rem;"></i>
                        </div>
                    </div>
                </div>
                @endif

                <header class="article-header">
                    <div class="article-meta">
                        <div class="meta-item">
                            <i class="fas fa-user"></i>
                            <span>{{ $pengumuman->admin->nama_lengkap }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-users"></i>
                            <span>{{ $targetAudiences[$pengumuman->target_audience] ?? ucfirst($pengumuman->target_audience) }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-eye"></i>
                            <span>{{ $pengumuman->views }} kali dilihat</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-clock"></i>
                            <span>{{ $pengumuman->created_at->diffForHumans() }}</span>
                        </div>
                    </div>

                    @if($pengumuman->tanggal_berakhir || $pengumuman->waktu_mulai)
                    <div class="validity-period">
                        <div class="validity-title">Masa Berlaku Pengumuman</div>
                        <div class="validity-item">
                            <strong>Mulai:</strong> {{ $pengumuman->tanggal_mulai->format('d F Y') }}
                            @if($pengumuman->waktu_mulai)
                                pukul {{ date('H:i', strtotime($pengumuman->waktu_mulai)) }} WIB
                            @endif
                        </div>
                        @if($pengumuman->tanggal_berakhir)
                        <div class="validity-item">
                            <strong>Berakhir:</strong> {{ $pengumuman->tanggal_berakhir->format('d F Y') }}
                            @if($pengumuman->waktu_berakhir)
                                pukul {{ date('H:i', strtotime($pengumuman->waktu_berakhir)) }} WIB
                            @endif
                        </div>
                        @endif
                    </div>
                    @endif
                </header>

                <div class="article-content">
                    <div class="content-body">
                        {!! nl2br(e($pengumuman->konten)) !!}
                    </div>
                </div>

                <div class="share-section">
                    <h3 class="share-title">
                        <i class="fas fa-share-alt"></i>
                        Bagikan Pengumuman Ini
                    </h3>
                    <div class="share-buttons">
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                           target="_blank" class="share-btn share-facebook">
                            <i class="fab fa-facebook-f"></i>
                            Facebook
                        </a>
                        <a href="https://twitter.com/intent/tweet?text={{ urlencode($pengumuman->judul) }}&url={{ urlencode(request()->url()) }}"
                           target="_blank" class="share-btn share-twitter">
                            <i class="fab fa-twitter"></i>
                            Twitter
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($pengumuman->judul . ' - ' . request()->url()) }}"
                           target="_blank" class="share-btn share-whatsapp">
                            <i class="fab fa-whatsapp"></i>
                            WhatsApp
                        </a>
                        <button onclick="copyLink()" class="share-btn share-copy">
                            <i class="fas fa-copy"></i>
                            Salin Link
                        </button>
                    </div>
                </div>
            </article>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Stats Widget -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Statistik</h3>
                <div class="stats-widget">
                    <div class="stat-item">
                        <div class="stat-number">{{ $pengumuman->views }}</div>
                        <div class="stat-label">Dilihat</div>
                    </div>
                    <div class="stat-item">
                        <div class="stat-number">{{ $pengumuman->created_at->diffForHumans() }}</div>
                        <div class="stat-label">Dipublikasi</div>
                    </div>
                </div>
            </div>

            <!-- Important Info -->
            <div class="sidebar-widget">
                <div class="important-info">
                    <h4>Informasi Penting</h4>
                    <p>Pastikan Anda membaca pengumuman ini dengan seksama dan mengikuti petunjuk yang diberikan. Untuk pertanyaan lebih lanjut, silakan hubungi kontak yang tersedia di bawah ini.</p>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="sidebar-widget">
                <h3 class="widget-title">Kontak Informasi</h3>
                <div class="contact-info">
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Telepon</div>
                            <div class="contact-value">(0751) 123-4567</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Email</div>
                            <div class="contact-value">info@nagarimungo.id</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Alamat</div>
                            <div class="contact-value">Kantor Nagari Mungo<br>Jl. Nagari Mungo No. 123</div>
                        </div>
                    </div>
                    <div class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="contact-text">
                            <div class="contact-label">Jam Layanan</div>
                            <div class="contact-value">Senin - Jumat<br>08:00 - 16:00 WIB</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Announcements -->
            @if($relatedPengumuman->count() > 0)
            <div class="sidebar-widget">
                <h3 class="widget-title">Pengumuman Terkait</h3>
                @foreach($relatedPengumuman as $related)
                <a href="{{ route('pengumuman.detail', $related->slug) }}" class="related-item">
                    <h4 class="related-title">{{ Str::limit($related->judul, 70) }}</h4>
                    <div class="related-meta">
                        <span class="related-category">{{ ucfirst($related->kategori) }}</span>
                        <div class="related-date">
                            <i class="fas fa-calendar"></i>
                            {{ $related->tanggal_mulai->format('d M Y') }}
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @endif
        </aside>
    </div>

    <!-- Back to List Button -->
    <a href="{{ route('pengumuman') }}" class="back-to-list">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Daftar</span>
    </a>

    <!-- Copy Notification -->
    <div class="copy-notification" id="copyNotification">
        <i class="fas fa-check-circle"></i>
        <span>Link berhasil disalin!</span>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="image-modal" onclick="closeImageModal()">
        <span class="close-modal">&times;</span>
        <img class="modal-content" id="modalImage">
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

    <script>
        // Copy link functionality
        function copyLink() {
            const url = window.location.href;
            const notification = document.getElementById('copyNotification');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(url).then(function() {
                    showNotification();
                }).catch(function() {
                    fallbackCopyText(url);
                });
            } else {
                fallbackCopyText(url);
            }
        }

        function fallbackCopyText(text) {
            const textArea = document.createElement('textarea');
            textArea.value = text;
            textArea.style.position = 'fixed';
            textArea.style.left = '-999999px';
            textArea.style.top = '-999999px';
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();

            try {
                document.execCommand('copy');
                showNotification();
            } catch (err) {
                console.error('Fallback: Copying text command was unsuccessful', err);
                alert('Gagal menyalin link. Silakan salin manual: ' + text);
            }

            document.body.removeChild(textArea);
        }

        function showNotification() {
            const notification = document.getElementById('copyNotification');
            notification.classList.add('show');

            setTimeout(() => {
                notification.classList.remove('show');
            }, 3000);
        }

        // Image Modal Functions
        function openImageModal(imageSrc) {
            const modal = document.getElementById('imageModal');
            const modalImg = document.getElementById('modalImage');
            modal.classList.add('show');
            modalImg.src = imageSrc;
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Close modal with ESC key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeImageModal();
            }
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Auto-hide back button on scroll up
        let lastScrollTop = 0;
        const backButton = document.querySelector('.back-to-list');

        window.addEventListener('scroll', function() {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

            if (scrollTop > lastScrollTop && scrollTop > 200) {
                // Scrolling down
                backButton.style.transform = 'translateY(120px)';
                backButton.style.opacity = '0';
            } else {
                // Scrolling up
                backButton.style.transform = 'translateY(0)';
                backButton.style.opacity = '1';
            }
            lastScrollTop = scrollTop;
        });

        // Smooth scroll untuk anchor links
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
    </script>
</body>
</html>
