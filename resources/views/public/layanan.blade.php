<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Publik - Nagari Mungo</title>
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

        /* Alert Messages */
        .alert {
            padding: 1rem 2rem;
            margin: 2rem auto;
            max-width: 1200px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 0.8rem;
            font-weight: 500;
            animation: slideInDown 0.5s ease-out;
        }

        .alert-error {
            background: linear-gradient(135deg, rgba(220, 38, 38, 0.1), rgba(248, 113, 113, 0.05));
            color: #dc2626;
            border: 1px solid rgba(220, 38, 38, 0.2);
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(34, 197, 94, 0.1), rgba(74, 222, 128, 0.05));
            color: #16a34a;
            border: 1px solid rgba(34, 197, 94, 0.2);
        }

        .alert-info {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.1), rgba(96, 165, 250, 0.05));
            color: #2563eb;
            border: 1px solid rgba(59, 130, 246, 0.2);
        }

        @keyframes slideInDown {
            0% {
                opacity: 0;
                transform: translateY(-20px);
            }
            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hero Section for Layanan - RED GRADIENT THEME */
        .hero-layanan {
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            padding: 12rem 0 6rem;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .hero-layanan::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.1"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.08"/><polygon points="600,50 650,100 600,150 550,100" fill="white" opacity="0.06"/><rect x="200" y="200" width="60" height="60" fill="white" opacity="0.05" transform="rotate(45 230 230)"/></svg>');
            animation: gentleFloat 20s infinite linear;
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
        }

        .hero-layanan h1 {
            font-size: 3.2rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 0 4px 20px rgba(0,0,0,0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .hero-layanan p {
            font-size: 1.3rem;
            opacity: 0.95;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Search & Filter Section */
        .search-filter {
            background: white;
            border-radius: 25px;
            padding: 2rem;
            margin-top: 3rem;
            box-shadow: 0 20px 50px rgba(220, 20, 60, 0.15);
            border: 1px solid rgba(220, 20, 60, 0.1);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
            position: relative;
        }

        .search-form {
            display: grid;
            grid-template-columns: 1fr auto auto auto;
            gap: 1rem;
            align-items: center;
            width: 100%;
        }

        .search-input {
            padding: 1rem 1.5rem;
            border: 2px solid rgba(220, 20, 60, 0.2);
            border-radius: 50px;
            font-size: 1rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 245, 245, 0.5);
            min-width: 0;
            width: 100%;
        }

        .search-input:focus {
            outline: none;
            border-color: #DC143C;
            background: white;
            box-shadow: 0 0 0 3px rgba(220, 20, 60, 0.1);
        }

        .filter-select {
            padding: 1rem 1.5rem;
            border: 2px solid rgba(220, 20, 60, 0.2);
            border-radius: 50px;
            background: rgba(255, 245, 245, 0.5);
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            min-width: 140px;
            white-space: nowrap;
        }

        .filter-select:focus {
            outline: none;
            border-color: #DC143C;
            background: white;
        }

        .search-btn {
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
            color: white;
            border: none;
            padding: 1rem 1.5rem;
            border-radius: 50px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
            position: relative;
            overflow: hidden;
            white-space: nowrap;
            min-width: fit-content;
        }

        .search-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s ease;
        }

        .search-btn:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
        }

        .search-btn:hover::before {
            left: 100%;
        }

        .search-btn:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        /* Quick Filters */
        .quick-filters {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
            flex-wrap: wrap;
            justify-content: center;
        }

        .quick-filter {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            color: #DC143C;
            padding: 0.5rem 1rem;
            border-radius: 25px;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 2px solid transparent;
        }

        .quick-filter:hover,
        .quick-filter.active {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        /* Enhanced filter indication */
        .search-filter.has-filter {
            border: 2px solid rgba(220, 20, 60, 0.2);
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.02), rgba(255, 107, 107, 0.01));
        }

        .search-filter.has-filter::before {
            content: 'Filter aktif';
            position: absolute;
            top: -10px;
            left: 20px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.2rem 0.8rem;
            border-radius: 10px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Loading Animation */
        .loading {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255,255,255,.3);
            border-radius: 50%;
            border-top-color: #fff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* Main Content */
        .main-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 4rem 2rem;
            display: grid;
            grid-template-columns: 1fr 320px;
            gap: 3rem;
        }

        /* Featured Layanan */
        .featured-section {
            margin-bottom: 3rem;
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

        /* Layanan Grid */
        .layanan-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 2rem;
            width: 100%;
        }

        .layanan-card {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.1);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            border: 1px solid rgba(220, 20, 60, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            width: 100%;
            max-width: 100%;
        }

        .layanan-card::before {
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

        .layanan-card:hover::before {
            transform: scaleX(1);
        }

        .layanan-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 50px rgba(220, 20, 60, 0.2);
        }

        .layanan-header {
            padding: 1.5rem 1.5rem 0;
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 1rem;
        }

        .layanan-kategori {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .layanan-biaya {
            background: rgba(34, 197, 94, 0.1);
            color: #16a34a;
            padding: 0.3rem 0.8rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .layanan-biaya.berbayar {
            background: rgba(239, 68, 68, 0.1);
            color: #dc2626;
        }

        .layanan-content {
            padding: 1rem 1.5rem 1.5rem;
            width: 100%;
            max-width: 100%;
            box-sizing: border-box;
        }

        .layanan-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 0.8rem;
            line-height: 1.4;
            transition: color 0.3s ease;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .layanan-card:hover .layanan-title {
            color: #DC143C;
        }

        .layanan-deskripsi {
            color: #666;
            line-height: 1.6;
            margin-bottom: 1rem;
            font-size: 0.95rem;
            word-wrap: break-word;
            overflow-wrap: break-word;
            max-width: 100%;
        }

        .layanan-meta {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.9rem;
            color: #999;
            margin-bottom: 1rem;
            flex-wrap: wrap;
            gap: 0.5rem;
        }

        .layanan-waktu {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #DC143C;
        }

        .layanan-read-more {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.8rem 1.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 20px rgba(220, 20, 60, 0.3);
            position: relative;
            overflow: hidden;
        }

        .layanan-read-more::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: all 0.6s ease;
        }

        .layanan-read-more:hover {
            transform: translateY(-3px) scale(1.05);
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.4);
            color: white;
        }

        .layanan-read-more:hover::before {
            left: 100%;
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
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
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

        .category-list {
            list-style: none;
        }

        .category-item {
            margin-bottom: 0.5rem;
        }

        .category-link {
            color: #666;
            text-decoration: none;
            padding: 0.8rem 1rem;
            display: block;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 10px;
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .category-link::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            transition: left 0.3s ease;
        }

        .category-link:hover {
            color: #DC143C;
            transform: translateX(8px);
        }

        .category-link:hover::before {
            left: 0;
        }

        .category-count {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.2rem 0.5rem;
            border-radius: 15px;
            font-size: 0.75rem;
            font-weight: 600;
        }

        /* Active states */
        .category-link.active,
        .quick-filter.active {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            color: #DC143C !important;
            transform: translateX(8px);
            border-left: 4px solid #DC143C;
            font-weight: 600;
        }

        .category-link.active::before {
            left: 0;
        }

        /* Statistics Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 2rem;
            width: 100%;
        }

        .stat-card {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 1rem;
            border-radius: 15px;
            text-align: center;
            transition: transform 0.3s ease;
            min-width: 0;
            word-wrap: break-word;
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-number {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }

        .stat-label {
            font-size: 0.85rem;
            opacity: 0.9;
            line-height: 1.3;
        }

        /* Info Section */
        .info-section {
            background: linear-gradient(135deg, rgba(220, 20, 60, 0.1), rgba(255, 107, 107, 0.05));
            padding: 1.5rem;
            border-radius: 15px;
            color: #666;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        .info-section p {
            margin-bottom: 0.5rem;
        }

        .info-section strong {
            color: #DC143C;
        }

        /* Pagination */
        .pagination-wrapper {
            margin-top: 3rem;
            display: flex;
            justify-content: center;
        }

        .pagination {
            display: flex;
            gap: 0.5rem;
            list-style: none;
        }

        .pagination a, .pagination span {
            padding: 0.8rem 1.2rem;
            border-radius: 10px;
            text-decoration: none;
            color: #666;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        .pagination a:hover {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
        }

        .pagination .active span {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
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

        /* Responsive */
        @media (max-width: 768px) {
            .hero-layanan h1 {
                font-size: 2.2rem;
            }

            .hero-layanan p {
                font-size: 1.1rem;
            }

            .search-form {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .quick-filters {
                justify-content: flex-start;
            }

            .main-content {
                grid-template-columns: 1fr;
                gap: 2rem;
                padding: 2rem 1rem;
            }

            .layanan-grid {
                grid-template-columns: 1fr;
            }

            .sidebar {
                position: static;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .hero-content {
                padding: 0 1rem;
            }

            .search-filter {
                margin: 2rem 1rem;
                padding: 1.5rem;
            }

            .hero-layanan h1 {
                font-size: 1.8rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Alert Messages -->
    @if(session('error'))
    <div class="alert alert-error">
        <i class="fas fa-exclamation-triangle"></i>
        {{ session('error') }}
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    @if(session('info'))
    <div class="alert alert-info">
        <i class="fas fa-info-circle"></i>
        {{ session('info') }}
    </div>
    @endif

    <!-- Hero Section -->
    <section class="hero-layanan">
        <div class="hero-content">
            <h1>Layanan Publik</h1>
            <p>Akses mudah untuk berbagai layanan administratif Pemerintah Nagari Mungo</p>

            <!-- Search & Filter -->
            <div class="search-filter {{ (request('search') || request('kategori') || request('biaya')) ? 'has-filter' : '' }}">
                <form class="search-form" method="GET" action="{{ route('layanan') }}">
                    <input
                        type="text"
                        name="search"
                        class="search-input"
                        placeholder="Cari layanan..."
                        value="{{ request('search') }}"
                    >
                    <select name="kategori" class="filter-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $key => $label)
                            <option value="{{ $key }}" {{ request('kategori') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <select name="biaya" class="filter-select">
                        <option value="">Semua Biaya</option>
                        @foreach($biayaOptions as $key => $label)
                            <option value="{{ $key }}" {{ request('biaya') == $key ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                        Cari
                    </button>
                </form>

                <!-- Quick Filters -->
                <div class="quick-filters">
                    <a href="{{ route('layanan') }}" class="quick-filter {{ !request()->hasAny(['kategori', 'biaya']) ? 'active' : '' }}">
                        <i class="fas fa-list"></i> Semua
                    </a>
                    <a href="{{ route('layanan.kategori', 'surat') }}" class="quick-filter {{ request('kategori') == 'surat' ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Surat
                    </a>
                    <a href="{{ route('layanan.kategori', 'izin') }}" class="quick-filter {{ request('kategori') == 'izin' ? 'active' : '' }}">
                        <i class="fas fa-stamp"></i> Izin
                    </a>
                    <a href="{{ route('layanan.kategori', 'keterangan') }}" class="quick-filter {{ request('kategori') == 'keterangan' ? 'active' : '' }}">
                        <i class="fas fa-certificate"></i> Keterangan
                    </a>
                    <a href="{{ route('layanan.kategori', 'penduduk') }}" class="quick-filter {{ request('kategori') == 'penduduk' ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Kependudukan
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <div class="main-content">
        <main>
            <!-- Layanan List -->
            <section>
                <h2 class="section-title">
                    @if(request('search'))
                        Hasil Pencarian: "{{ request('search') }}"
                    @elseif(request('kategori'))
                        Kategori: {{ $categories[request('kategori')] ?? ucfirst(request('kategori')) }}
                    @elseif(request('biaya'))
                        Filter: {{ $biayaOptions[request('biaya')] ?? ucfirst(request('biaya')) }}
                    @else
                        Semua Layanan
                    @endif
                </h2>

                @if($layanan->count() > 0)
                    <div class="layanan-grid">
                        @foreach($layanan as $item)
                            <article class="layanan-card">
                                <div class="layanan-header">
                                    <span class="layanan-kategori">
                                        @if(stripos($item->nama_layanan, 'surat') !== false)
                                            Surat
                                        @elseif(stripos($item->nama_layanan, 'izin') !== false)
                                            Izin
                                        @elseif(stripos($item->nama_layanan, 'keterangan') !== false)
                                            Keterangan
                                        @elseif(stripos($item->nama_layanan, 'ktp') !== false || stripos($item->nama_layanan, 'kk') !== false)
                                            Kependudukan
                                        @else
                                            Layanan
                                        @endif
                                    </span>
                                    <span class="layanan-biaya {{
                                        (stripos($item->biaya, 'gratis') !== false ||
                                         stripos($item->biaya, 'tidak ada') !== false ||
                                         empty($item->biaya)) ? '' : 'berbayar'
                                    }}">
                                        @if(stripos($item->biaya, 'gratis') !== false || stripos($item->biaya, 'tidak ada') !== false || empty($item->biaya))
                                            <i class="fas fa-check-circle"></i> Gratis
                                        @else
                                            <i class="fas fa-money-bill"></i> Berbayar
                                        @endif
                                    </span>
                                </div>
                                <div class="layanan-content">
                                    <h3 class="layanan-title">{{ $item->nama_layanan }}</h3>
                                    <p class="layanan-deskripsi">{{ Str::limit(strip_tags($item->deskripsi), 120) }}</p>
                                    <div class="layanan-meta">
                                        <div class="layanan-waktu">
                                            <i class="fas fa-clock"></i>
                                            {{ $item->waktu_penyelesaian ?? 'Sesuai ketentuan' }}
                                        </div>
                                        @if($item->biaya && !empty(trim($item->biaya)))
                                            <div>
                                                <i class="fas fa-tag"></i> {{ $item->biaya }}
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('layanan.detail', $item->slug) }}" class="layanan-read-more">
                                        Lihat Detail
                                        <i class="fas fa-arrow-right"></i>
                                    </a>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pagination-wrapper">
                        {{ $layanan->appends(request()->query())->links() }}
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-concierge-bell"></i>
                        <h3>Tidak ada layanan yang ditemukan</h3>
                        <p>Coba ubah kata kunci pencarian atau pilih filter lain.</p>
                    </div>
                @endif
            </section>
        </main>

        <!-- Sidebar -->
        <aside class="sidebar">
            <!-- Statistics -->
            <div class="sidebar-section">
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-number">{{ $totalLayanan }}</div>
                        <div class="stat-label">Total Layanan</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-number">{{ $layananGratis }}</div>
                        <div class="stat-label">Layanan Gratis</div>
                    </div>
                </div>
            </div>

            <!-- Categories -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Kategori</h3>
                <ul class="category-list">
                    <li class="category-item">
                        <a href="{{ route('layanan') }}" class="category-link {{ !request('kategori') ? 'active' : '' }}">
                            <span>
                                <i class="fas fa-list"></i> Semua Kategori
                            </span>
                            <span class="category-count">{{ $totalLayanan }}</span>
                        </a>
                    </li>
                    @foreach($categoriesWithCounts as $key => $data)
                        <li class="category-item">
                            <a href="{{ route('layanan.kategori', $key) }}" class="category-link {{ request('kategori') == $key ? 'active' : '' }}">
                                <span>
                                    <i class="fas fa-tag"></i> {{ $data['label'] }}
                                </span>
                                @if($data['count'] > 0)
                                    <span class="category-count">{{ $data['count'] }}</span>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Layanan Populer -->
            @if($layananPopuler->count() > 0)
                <div class="sidebar-section">
                    <h3 class="sidebar-title">Layanan Populer</h3>
                    <ul class="category-list">
                        @foreach($layananPopuler->take(5) as $populer)
                            <li class="category-item">
                                <a href="{{ route('layanan.detail', $populer->slug) }}" class="category-link">
                                    <span>
                                        <i class="fas fa-star"></i> {{ Str::limit($populer->nama_layanan, 25) }}
                                    </span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Info -->
            <div class="sidebar-section">
                <h3 class="sidebar-title">Info</h3>
                <div class="info-section">
                    <p><strong>Total Layanan:</strong> {{ $layanan->total() }}</p>
                    <p><strong>Halaman:</strong> {{ $layanan->currentPage() }} dari {{ $layanan->lastPage() }}</p>
                    @if(request('kategori'))
                        <p><strong>Kategori Aktif:</strong> {{ $categories[request('kategori')] ?? 'Tidak diketahui' }}</p>
                    @endif
                    @if(request('biaya'))
                        <p><strong>Filter Biaya:</strong> {{ $biayaOptions[request('biaya')] ?? 'Tidak diketahui' }}</p>
                    @endif
                    @if(request('search'))
                        <p><strong>Pencarian:</strong> "{{ request('search') }}"</p>
                    @endif
                </div>
            </div>
        </aside>
    </div>

    <!-- Include Footer -->
    @include('layouts.footer')

    <script>
        // Search form enhancement
        document.querySelector('.search-form').addEventListener('submit', function(e) {
            const submitBtn = e.target.querySelector('.search-btn');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<div class="loading"></div> Mencari...';
            submitBtn.disabled = true;

            // Reset button setelah 3 detik jika masih loading
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Auto hide alerts after 5 seconds
        document.querySelectorAll('.alert').forEach(alert => {
            setTimeout(() => {
                alert.style.transition = 'all 0.5s ease-out';
                alert.style.transform = 'translateY(-20px)';
                alert.style.opacity = '0';
                setTimeout(() => {
                    alert.remove();
                }, 500);
            }, 5000);
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
    </script>
</body>
</html>
