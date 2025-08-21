<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Nagari - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Profil Nagari dengan Video */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
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

        .page-header {
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 1.875rem;
            font-weight: 700;
            color: #1f2937;
        }

        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid #f3f4f6;
        }

        .card-title-custom {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
            display: flex;
            align-items: center;
        }

        .section-icon {
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 12px;
            color: white;
        }

        .icon-primary { background: linear-gradient(135deg, #3b82f6, #1d4ed8); }
        .icon-info { background: linear-gradient(135deg, #06b6d4, #0891b2); }
        .icon-success { background: linear-gradient(135deg, #10b981, #059669); }
        .icon-warning { background: linear-gradient(135deg, #f59e0b, #d97706); }
        .icon-danger { background: linear-gradient(135deg, #ef4444, #dc2626); }
        .icon-secondary { background: linear-gradient(135deg, #6b7280, #4b5563); }
        .icon-video { background: linear-gradient(135deg, #8b5cf6, #7c3aed); }

        .form-control, .form-select {
            border-radius: 0.75rem;
            border: 2px solid #e5e7eb;
            padding: 0.75rem 1rem;
            transition: all 0.3s ease;
            font-size: 0.875rem;
        }

        .form-control:focus, .form-select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
            outline: none;
        }

        .form-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
        }

        /* Upload Area Styling */
        .upload-area {
            border: 2px dashed #d1d5db;
            border-radius: 1rem;
            padding: 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: #f9fafb;
            position: relative;
            overflow: hidden;
            min-height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .upload-area:hover {
            border-color: #3b82f6;
            background: linear-gradient(135deg, #eff6ff, #dbeafe);
            transform: translateY(-2px);
        }

        .upload-area.has-image, .upload-area.has-video {
            padding: 0;
            border-style: solid;
            border-color: #10b981;
            min-height: auto;
        }

        .upload-area.drag-over {
            border-color: #10b981 !important;
            background: linear-gradient(135deg, #ecfdf5, #d1fae5) !important;
            transform: scale(1.02);
            box-shadow: 0 8px 25px rgba(16, 185, 129, 0.2);
        }

        .preview-image, .preview-video {
            width: 100%;
            height: auto;
            object-fit: contain;
            max-height: 400px;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
        }

        .preview-video {
            max-height: 500px;
        }

        .preview-image:hover, .preview-video:hover {
            transform: scale(1.02);
        }

        .upload-content {
            position: relative;
            width: 100%;
        }

        /* Video specific styling */
        .video-upload-area {
            min-height: 180px;
        }

        .video-info {
            background: rgba(0, 0, 0, 0.8);
            color: white;
            padding: 0.5rem;
            border-radius: 0.5rem;
            margin-top: 0.5rem;
            font-size: 0.75rem;
        }

        .video-controls {
            position: absolute;
            top: 10px;
            right: 10px;
            display: flex;
            gap: 0.5rem;
            z-index: 10;
        }

        .video-type-toggle {
            background: #f3f4f6;
            border: 2px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 0.75rem;
            margin-bottom: 1rem;
        }

        .video-type-toggle input[type="radio"] {
            margin-right: 0.5rem;
        }

        .video-type-toggle label {
            margin-bottom: 0;
            cursor: pointer;
            font-weight: 500;
        }

        .video-type-toggle .form-check {
            margin-bottom: 0;
        }

        /* Button Styling */
        .btn-primary {
            background: linear-gradient(135deg, #3b82f6, #1d4ed8);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(59, 130, 246, 0.4);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #4b5563);
            border: none;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(107, 114, 128, 0.4);
        }

        .btn-coordinates {
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            color: white;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-coordinates:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 8px rgba(16, 185, 129, 0.4);
            color: white;
        }

        /* Loading Animation */
        .loading {
            border: 2px solid #fff;
            border-top: 2px solid transparent;
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

        /* Fade In Animation */
        .profil-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: profilFadeInUp 0.6s ease forwards;
        }

        @keyframes profilFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .save-section {
            position: sticky;
            bottom: 20px;
            background: white;
            border-radius: 1rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            padding: 1.5rem;
            text-align: center;
            margin-top: 2rem;
        }

        .coordinate-display {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 0.5rem;
            padding: 0.75rem;
            font-family: 'Courier New', monospace;
            font-size: 0.875rem;
        }

        .alert {
            border-radius: 0.75rem;
            border: none;
            padding: 1rem 1.25rem;
        }

        .alert-success {
            background: linear-gradient(135deg, #dcfdf7, #a7f3d0);
            color: #065f46;
        }

        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
        }

        /* Upload button styling */
        .upload-area .btn-danger {
            background: rgba(220, 38, 38, 0.9);
            border: none;
            border-radius: 50%;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .upload-area .btn-danger:hover {
            background: rgba(220, 38, 38, 1);
            transform: scale(1.1);
        }

        /* Animation untuk preview */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .preview-image, .preview-video {
            animation: fadeInUp 0.5s ease;
        }

        /* Progress bar styling untuk upload video */
        .upload-progress {
            background: #e5e7eb;
            border-radius: 0.5rem;
            height: 8px;
            overflow: hidden;
            margin-top: 1rem;
        }

        .upload-progress-bar {
            background: linear-gradient(135deg, #10b981, #059669);
            height: 100%;
            transition: width 0.3s ease;
        }

        /* Video URL Preview */
        .video-url-preview {
            margin-top: 1rem;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 2px solid #e5e7eb;
        }

        .video-url-preview iframe {
            width: 100%;
            height: 200px;
            border: none;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .content-card {
                padding: 1rem;
                margin-bottom: 1rem;
            }

            .card-header-custom {
                flex-direction: column;
                text-align: center;
                gap: 0.5rem;
            }

            .upload-area {
                padding: 1.5rem 1rem;
                min-height: 100px;
            }

            .upload-area.has-image, .upload-area.has-video {
                min-height: auto;
            }

            .preview-image {
                max-height: 150px;
            }

            .preview-video {
                max-height: 200px;
            }

            .page-main-wrapper {
                padding: 0.5rem;
            }

            .video-url-preview iframe {
                height: 150px;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 profil-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Profil Nagari</h1>
                <p class="text-gray-600 mt-2">Kelola informasi lengkap tentang nagari</p>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show profil-fade-in mb-4" role="alert" style="animation-delay: 0.1s;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show profil-fade-in mb-4" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Form -->
            <form action="{{ route('admin.profil.store') }}" method="POST" enctype="multipart/form-data" id="profilForm">
                @csrf

                <!-- Informasi Dasar -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.2s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-primary">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            Informasi Dasar
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Nama Nagari <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama_nagari') is-invalid @enderror"
                                   name="nama_nagari" value="{{ old('nama_nagari', $profil->nama_nagari ?? '') }}"
                                   placeholder="Masukkan nama nagari" required>
                            @error('nama_nagari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Kode Nagari</label>
                            <input type="text" class="form-control @error('kode_nagari') is-invalid @enderror"
                                   name="kode_nagari" value="{{ old('kode_nagari', $profil->kode_nagari ?? '') }}"
                                   placeholder="Masukkan kode nagari">
                            @error('kode_nagari')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Visi & Misi -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.3s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-info">
                                <i class="fas fa-eye"></i>
                            </div>
                            Visi & Misi
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-4">
                            <label class="form-label">Sejarah</label>
                            <textarea class="form-control @error('sejarah') is-invalid @enderror"
                                      name="sejarah" rows="4" placeholder="Masukkan sejarah nagari">{{ old('sejarah', $profil->sejarah ?? '') }}</textarea>
                            @error('sejarah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Visi</label>
                            <textarea class="form-control @error('visi') is-invalid @enderror"
                                      name="visi" rows="5" placeholder="Masukkan visi nagari">{{ old('visi', $profil->visi ?? '') }}</textarea>
                            @error('visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Misi</label>
                            <textarea class="form-control @error('misi') is-invalid @enderror"
                                      name="misi" rows="5" placeholder="Masukkan misi nagari">{{ old('misi', $profil->misi ?? '') }}</textarea>
                            @error('misi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Kontak & Lokasi -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.4s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-success">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            Kontak & Lokasi
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label class="form-label">Alamat</label>
                            <textarea class="form-control @error('alamat') is-invalid @enderror"
                                      name="alamat" rows="3" placeholder="Masukkan alamat lengkap">{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                            @error('alamat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Kode Pos</label>
                            <input type="text" class="form-control @error('kode_pos') is-invalid @enderror"
                                   name="kode_pos" value="{{ old('kode_pos', $profil->kode_pos ?? '') }}"
                                   placeholder="25xxx">
                            @error('kode_pos')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Telepon</label>
                            <input type="text" class="form-control @error('telepon') is-invalid @enderror"
                                   name="telepon" value="{{ old('telepon', $profil->telepon ?? '') }}"
                                   placeholder="(0751) xxxxxxx">
                            @error('telepon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Luas Wilayah</label>
                            <input type="text" class="form-control @error('luas_wilayah') is-invalid @enderror"
                                   name="luas_wilayah" value="{{ old('luas_wilayah', $profil->luas_wilayah ?? '') }}"
                                   placeholder="xx km²">
                            @error('luas_wilayah')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email', $profil->email ?? '') }}"
                                   placeholder="nagari@example.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Website</label>
                            <input type="url" class="form-control @error('website') is-invalid @enderror"
                                   name="website" value="{{ old('website', $profil->website ?? '') }}"
                                   placeholder="https://nagari.example.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Koordinat -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.5s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-warning">
                                <i class="fas fa-globe"></i>
                            </div>
                            Koordinat
                        </div>
                        <button type="button" class="btn-coordinates" onclick="getCurrentLocation()">
                            <i class="fas fa-map-marked-alt me-2"></i>Ambil Koordinat Saat Ini
                        </button>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Latitude</label>
                            <input type="text" class="form-control coordinate-display @error('koordinat_lat') is-invalid @enderror"
                                   name="koordinat_lat" value="{{ old('koordinat_lat', $profil->koordinat_lat ?? '') }}"
                                   placeholder="-0.9471" id="latitude">
                            @error('koordinat_lat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Longitude</label>
                            <input type="text" class="form-control coordinate-display @error('koordinat_lng') is-invalid @enderror"
                                   name="koordinat_lng" value="{{ old('koordinat_lng', $profil->koordinat_lng ?? '') }}"
                                   placeholder="100.3543" id="longitude">
                            @error('koordinat_lng')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Batas Wilayah -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.6s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-danger">
                                <i class="fas fa-border-all"></i>
                            </div>
                            Batas Wilayah
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Utara</label>
                            <textarea class="form-control @error('batas_utara') is-invalid @enderror"
                                      name="batas_utara" rows="2" placeholder="Masukkan batas utara">{{ old('batas_utara', $profil->batas_utara ?? '') }}</textarea>
                            @error('batas_utara')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Selatan</label>
                            <textarea class="form-control @error('batas_selatan') is-invalid @enderror"
                                      name="batas_selatan" rows="2" placeholder="Masukkan batas selatan">{{ old('batas_selatan', $profil->batas_selatan ?? '') }}</textarea>
                            @error('batas_selatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Timur</label>
                            <textarea class="form-control @error('batas_timur') is-invalid @enderror"
                                      name="batas_timur" rows="2" placeholder="Masukkan batas timur">{{ old('batas_timur', $profil->batas_timur ?? '') }}</textarea>
                            @error('batas_timur')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Batas Barat</label>
                            <textarea class="form-control @error('batas_barat') is-invalid @enderror"
                                      name="batas_barat" rows="2" placeholder="Masukkan batas barat">{{ old('batas_barat', $profil->batas_barat ?? '') }}</textarea>
                            @error('batas_barat')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Administratif -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.7s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-secondary">
                                <i class="fas fa-chart-bar"></i>
                            </div>
                            Data Administratif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah RT</label>
                            <input type="number" class="form-control @error('jumlah_rt') is-invalid @enderror"
                                   name="jumlah_rt" value="{{ old('jumlah_rt', $profil->jumlah_rt ?? 0) }}"
                                   min="0" placeholder="0">
                            @error('jumlah_rt')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Jumlah RW</label>
                            <input type="number" class="form-control @error('jumlah_rw') is-invalid @enderror"
                                   name="jumlah_rw" value="{{ old('jumlah_rw', $profil->jumlah_rw ?? 0) }}"
                                   min="0" placeholder="0">
                            @error('jumlah_rw')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Media Section -->
                <div class="content-card profil-fade-in" style="animation-delay: 0.8s;">
                    <div class="card-header-custom">
                        <div class="card-title-custom">
                            <div class="section-icon icon-video">
                                <i class="fas fa-photo-video"></i>
                            </div>
                            Media: Logo, Peta & Video Profil
                        </div>
                    </div>
                    <div class="row">
                        <!-- Logo Nagari -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Logo Nagari</label>
                            <div class="upload-area {{ ($profil && $profil->hasLogoFile()) ? 'has-image' : '' }}"
                                 id="logo-upload-area" onclick="document.getElementById('logo').click()">
                                <div class="upload-content" id="logo-content">
                                    @if($profil && $profil->hasLogoFile())
                                        <div class="position-relative">
                                            <img src="{{ $profil->getLogoUrl() }}" alt="Logo" class="preview-image" id="logo-preview">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('logo')" style="z-index: 10;"
                                                    title="Hapus logo">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div id="logo-placeholder">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload logo</p>
                                            <p class="text-gray-400 text-sm">Format: JPG, PNG, GIF, SVG<br>Maksimal: 2MB</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <input type="file" class="d-none" id="logo" name="logo" accept="image/*" onchange="previewImage(this, 'logo')">
                            @error('logo')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Banner Nagari -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Peta Nagari</label>
                            <div class="upload-area {{ ($profil && $profil->hasBannerFile()) ? 'has-image' : '' }}"
                                 id="banner-upload-area" onclick="document.getElementById('banner').click()">
                                <div class="upload-content" id="banner-content">
                                    @if($profil && $profil->hasBannerFile())
                                        <div class="position-relative">
                                            <img src="{{ $profil->getBannerUrl() }}" alt="Banner" class="preview-image" id="banner-preview">
                                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                                    onclick="event.stopPropagation(); removeImage('banner')" style="z-index: 10;"
                                                    title="Hapus banner">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    @else
                                        <div id="banner-placeholder">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload peta</p>
                                            <p class="text-gray-400 text-sm">Format: JPG, PNG, GIF, SVG<br>Maksimal: 5MB</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <input type="file" class="d-none" id="banner" name="banner" accept="image/*" onchange="previewImage(this, 'banner')">
                            @error('banner')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Video Profil Nagari -->
                        <div class="col-md-4 mb-4">
                            <label class="form-label">Video Profil</label>

                            <!-- Video Type Toggle -->
                            <div class="video-type-toggle">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="video_type" id="video_upload" value="upload"
                                           {{ (!$profil || !$profil->hasExternalVideo()) ? 'checked' : '' }} onchange="toggleVideoType()">
                                    <label class="form-check-label" for="video_upload">Upload Video</label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="video_type" id="video_url_type" value="url"
                                           {{ ($profil && $profil->hasExternalVideo()) ? 'checked' : '' }} onchange="toggleVideoType()">
                                    <label class="form-check-label" for="video_url_type">Link YouTube/Video</label>
                                </div>
                            </div>

                            <!-- Video Upload Area -->
                            <div id="video-upload-section" style="{{ ($profil && $profil->hasExternalVideo()) ? 'display: none;' : '' }}">
                                <div class="upload-area video-upload-area {{ ($profil && $profil->hasVideoFile()) ? 'has-video' : '' }}"
                                     id="video-upload-area" onclick="document.getElementById('video_profil').click()">
                                    <div class="upload-content" id="video-content">
                                        @if($profil && $profil->hasVideoFile())
                                            <div class="position-relative">
                                                <video class="preview-video" id="video-preview" controls>
                                                    <source src="{{ $profil->getVideoUrl() }}" type="video/mp4">
                                                    Browser Anda tidak mendukung tag video.
                                                </video>
                                                <div class="video-controls">
                                                    <button type="button" class="btn btn-danger btn-sm"
                                                            onclick="event.stopPropagation(); removeVideo()" title="Hapus video">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                                @if($profil->video_durasi || $profil->video_size)
                                                    <div class="video-info">
                                                        @if($profil->video_durasi)
                                                            <span><i class="fas fa-clock"></i> {{ $profil->video_durasi_formatted }}</span>
                                                        @endif
                                                        @if($profil->video_size)
                                                            <span class="ms-3"><i class="fas fa-hdd"></i> {{ $profil->video_size_formatted }}</span>
                                                        @endif
                                                    </div>
                                                @endif
                                            </div>
                                        @else
                                            <div id="video-placeholder">
                                                <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                                                <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload video profil</p>
                                                <p class="text-gray-400 text-sm">Format: MP4, AVI, MOV, WMV, FLV, WebM<br>Maksimal: 50MB</p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <input type="file" class="d-none" id="video_profil" name="video_profil"
                                       accept="video/mp4,video/avi,video/mov,video/wmv,video/flv,video/webm"
                                       onchange="previewVideo(this)">
                                @error('video_profil')
                                    <div class="text-danger small mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Video URL Section -->
                            <div id="video-url-section" style="{{ ($profil && $profil->hasExternalVideo()) ? '' : 'display: none;' }}">
                                <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                                       name="video_url" value="{{ old('video_url', $profil->video_url ?? '') }}"
                                       placeholder="https://www.youtube.com/watch?v=..." id="video_url_input"
                                       onchange="previewVideoUrl()">
                                @error('video_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror

                                <!-- Video URL Preview -->
                                <div id="video-url-preview" class="video-url-preview" style="{{ ($profil && $profil->hasExternalVideo()) ? '' : 'display: none;' }}">
                                    @if($profil && $profil->hasExternalVideo())
                                        <iframe src="{{ $profil->video_embed_url }}" frameborder="0" allowfullscreen></iframe>
                                    @endif
                                </div>
                            </div>

                            <!-- Video Description -->
                            <div class="mt-3">
                                <label class="form-label">Deskripsi Video</label>
                                <textarea class="form-control @error('video_deskripsi') is-invalid @enderror"
                                          name="video_deskripsi" rows="3"
                                          placeholder="Deskripsi singkat tentang video profil">{{ old('video_deskripsi', $profil->video_deskripsi ?? '') }}</textarea>
                                @error('video_deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Section -->
                <div class="save-section profil-fade-in" style="animation-delay: 0.9s;">
                    <button type="submit" class="btn btn-primary btn-lg me-3" id="submitBtn">
                        <i class="fas fa-save me-2"></i>Simpan Profil
                    </button>
                    <button type="button" class="btn btn-secondary btn-lg" id="resetBtn">
                        <i class="fas fa-undo me-2"></i>Reset
                    </button>
                </div>
            </form>
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
            const fadeElements = document.querySelectorAll('.profil-fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });

            // Auto-resize textareas
            $('textarea').on('input', function() {
                this.style.height = 'auto';
                this.style.height = this.scrollHeight + 'px';
            });

            // Initialize drag and drop
            initializeDragAndDrop();

            // Handle custom reset button
            $('#resetBtn').on('click', function(e) {
                e.preventDefault();
                resetCompleteForm();
            });
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Toggle video type (upload vs URL) - FIXED
        function toggleVideoType() {
            const uploadSection = document.getElementById('video-upload-section');
            const urlSection = document.getElementById('video-url-section');
            const videoUploadRadio = document.getElementById('video_upload');
            const videoUrlRadio = document.getElementById('video_url_type');

            if (videoUploadRadio.checked) {
                uploadSection.style.display = 'block';
                urlSection.style.display = 'none';
                // Clear URL input and preview
                document.getElementById('video_url_input').value = '';
                document.getElementById('video-url-preview').style.display = 'none';
                document.getElementById('video-url-preview').innerHTML = '';
            } else if (videoUrlRadio.checked) {
                uploadSection.style.display = 'none';
                urlSection.style.display = 'block';
                // Clear file input
                document.getElementById('video_profil').value = '';
                resetUploadArea('video');
            }
        }

        // Preview video URL - NEW FUNCTION
        function previewVideoUrl() {
            const urlInput = document.getElementById('video_url_input');
            const preview = document.getElementById('video-url-preview');
            const url = urlInput.value.trim();

            if (!url) {
                preview.style.display = 'none';
                preview.innerHTML = '';
                return;
            }

            let embedUrl = '';

            // YouTube
            if (url.includes('youtube.com/watch?v=') || url.includes('youtu.be/')) {
                const videoId = url.includes('youtube.com/watch?v=')
                    ? url.split('v=')[1].split('&')[0]
                    : url.split('youtu.be/')[1].split('?')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}`;
            }
            // Vimeo
            else if (url.includes('vimeo.com/')) {
                const videoId = url.split('vimeo.com/')[1].split('?')[0];
                embedUrl = `https://player.vimeo.com/video/${videoId}`;
            }
            // Direct video URL
            else if (url.match(/\.(mp4|webm|ogg|avi|mov)(\?.*)?$/i)) {
                preview.innerHTML = `
                    <video width="100%" height="200" controls>
                        <source src="${url}" type="video/mp4">
                        Browser Anda tidak mendukung tag video.
                    </video>
                `;
                preview.style.display = 'block';
                showNotification('Preview video URL berhasil ditampilkan', 'success');
                return;
            }

            if (embedUrl) {
                preview.innerHTML = `<iframe src="${embedUrl}" frameborder="0" allowfullscreen></iframe>`;
                preview.style.display = 'block';
                showNotification('Preview video URL berhasil ditampilkan', 'success');
            } else {
                showNotification('Format URL video tidak didukung. Gunakan YouTube, Vimeo, atau link video langsung.', 'error');
                preview.style.display = 'none';
                preview.innerHTML = '';
            }
        }

        // Reset form lengkap
        function resetCompleteForm() {
            if (confirm('Apakah Anda yakin ingin mereset semua data? Semua perubahan akan hilang dan kembali ke data asli.')) {
                // Reset semua input text, email, url, number
                $('#profilForm input[type="text"], #profilForm input[type="email"], #profilForm input[type="url"], #profilForm input[type="number"]').val('');

                // Reset semua textarea
                $('#profilForm textarea').val('').trigger('input');

                // Reset file inputs
                $('#logo, #banner, #video_profil').val('');

                // Reset preview images dan video
                resetUploadArea('logo');
                resetUploadArea('banner');
                resetUploadArea('video');

                // Reset koordinat
                $('#latitude, #longitude').val('');

                // Reset video type ke upload
                document.getElementById('video_upload').checked = true;
                toggleVideoType();

                // Reset video URL preview
                document.getElementById('video-url-preview').style.display = 'none';
                document.getElementById('video-url-preview').innerHTML = '';

                // Hapus semua error states
                $('#profilForm .is-invalid').removeClass('is-invalid');
                $('#profilForm .invalid-feedback').hide();

                // Show success message
                showNotification('Form berhasil direset! Semua data dikembalikan ke kondisi kosong.', 'success');

                // Focus ke field pertama
                $('#profilForm input[name="nama_nagari"]').focus();
            }
        }

        // Reset upload area ke state awal
        function resetUploadArea(type) {
            const uploadArea = document.getElementById(`${type}-upload-area`);
            const content = document.getElementById(`${type}-content`);

            if (content) {
                let placeholder = '';
                if (type === 'video') {
                    placeholder = `
                        <div id="video-placeholder">
                            <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload video profil</p>
                            <p class="text-gray-400 text-sm">Format: MP4, AVI, MOV, WMV, FLV, WebM<br>Maksimal: 50MB</p>
                        </div>
                    `;
                } else {
                    placeholder = `
                        <div id="${type}-placeholder">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload ${type === 'logo' ? 'logo' : 'banner'}</p>
                            <p class="text-gray-400 text-sm">Format: JPG, PNG, GIF, SVG<br>Maksimal: ${type === 'logo' ? '2MB' : '5MB'}</p>
                        </div>
                    `;
                }
                content.innerHTML = placeholder;
            }

            if (uploadArea) {
                uploadArea.classList.remove('has-image', 'has-video');
            }
        }

        // Enhanced preview image function
        function previewImage(input, type) {
            if (input.files && input.files[0]) {
                const file = input.files[0];

                // Show loading state
                const uploadArea = document.getElementById(`${type}-upload-area`);
                const content = document.getElementById(`${type}-content`);

                content.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memproses ${type === 'logo' ? 'logo' : 'banner'}...</p>
                    </div>
                `;

                // Validate file size
                const maxSize = type === 'logo' ? 2048 * 1024 : 5120 * 1024;
                if (file.size > maxSize) {
                    showNotification(`File terlalu besar. Maksimal ${type === 'logo' ? '2MB' : '5MB'}`, 'error');
                    resetUploadArea(type);
                    input.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/svg+xml'];
                if (!allowedTypes.includes(file.type)) {
                    showNotification('Format file tidak didukung. Gunakan JPG, PNG, GIF, atau SVG', 'error');
                    resetUploadArea(type);
                    input.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    content.innerHTML = `
                        <div class="position-relative">
                            <img src="${e.target.result}" alt="${type}" class="preview-image" id="${type}-preview">
                            <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2"
                                    onclick="event.stopPropagation(); removeImage('${type}')"
                                    style="z-index: 10;" title="Hapus ${type === 'logo' ? 'logo' : 'banner'}">
                                <i class="fas fa-times"></i>
                            </button>
                            <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 text-white p-2 text-center"
                                 style="border-radius: 0 0 0.75rem 0.75rem;">
                                <small><i class="fas fa-check-circle text-success me-1"></i>${file.name}</small>
                            </div>
                        </div>
                    `;

                    uploadArea.classList.add('has-image');
                    showNotification(`${type === 'logo' ? 'Logo' : 'Banner'} berhasil dipilih`, 'success');
                }

                reader.onerror = function() {
                    showNotification('Gagal membaca file. Silakan coba lagi.', 'error');
                    resetUploadArea(type);
                    input.value = '';
                }

                reader.readAsDataURL(file);
            }
        }

        // Preview video function
        function previewVideo(input) {
            if (input.files && input.files[0]) {
                const file = input.files[0];
                const uploadArea = document.getElementById('video-upload-area');
                const content = document.getElementById('video-content');

                // Show loading state with progress
                content.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 text-muted">Memproses video...</p>
                        <div class="upload-progress mt-3">
                            <div class="upload-progress-bar" style="width: 0%"></div>
                        </div>
                    </div>
                `;

                // Validate file size (50MB)
                const maxSize = 500 * 1024 * 1024;
                if (file.size > maxSize) {
                    showNotification('File video terlalu besar. Maksimal 500MB', 'error');
                    resetUploadArea('video');
                    input.value = '';
                    return;
                }

                // Validate file type
                const allowedTypes = ['video/mp4', 'video/avi', 'video/mov', 'video/wmv', 'video/flv', 'video/webm'];
                if (!allowedTypes.includes(file.type)) {
                    showNotification('Format video tidak didukung. Gunakan MP4, AVI, MOV, WMV, FLV, atau WebM', 'error');
                    resetUploadArea('video');
                    input.value = '';
                    return;
                }

                // Simulate loading progress
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += Math.random() * 15;
                    if (progress >= 100) {
                        progress = 100;
                        clearInterval(progressInterval);
                    }
                    const progressBar = document.querySelector('.upload-progress-bar');
                    if (progressBar) {
                        progressBar.style.width = progress + '%';
                    }
                }, 200);

                // Create video preview
                const videoUrl = URL.createObjectURL(file);
                const sizeInMB = (file.size / (1024 * 1024)).toFixed(2);

                setTimeout(() => {
                    content.innerHTML = `
                        <div class="position-relative">
                            <video class="preview-video" id="video-preview" controls>
                                <source src="${videoUrl}" type="${file.type}">
                                Browser Anda tidak mendukung tag video.
                            </video>
                            <div class="video-controls">
                                <button type="button" class="btn btn-danger btn-sm"
                                        onclick="event.stopPropagation(); removeVideo()" title="Hapus video">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div class="video-info">
                                <span><i class="fas fa-file-video"></i> ${file.name}</span>
                                <span class="ms-3"><i class="fas fa-hdd"></i> ${sizeInMB} MB</span>
                            </div>
                        </div>
                    `;

                    uploadArea.classList.add('has-video');
                    showNotification('Video berhasil dipilih', 'success');
                }, 1500);
            }
        }

        // Remove image function
        function removeImage(type) {
            if (confirm(`Apakah Anda yakin ingin menghapus ${type === 'logo' ? 'logo' : 'banner'} ini?`)) {
                
                // Show loading state
                const uploadArea = document.getElementById(`${type}-upload-area`);
                const content = document.getElementById(`${type}-content`);
                
                content.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Menghapus...</span>
                        </div>
                        <p class="mt-2 text-muted">Menghapus ${type === 'logo' ? 'logo' : 'banner'}...</p>
                    </div>
                `;
                
                // Jika ada file yang sudah tersimpan di database, hapus via AJAX
                $.ajax({
                    url: `/admin/profil/delete-${type}`,
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reset input file
                            const input = document.getElementById(type);
                            if (input) {
                                input.value = '';
                            }
                            
                            // Reset upload area
                            resetUploadArea(type);
                            
                            showNotification(response.message, 'success');
                        } else {
                            showNotification(response.message || 'Gagal menghapus file', 'error');
                            // Restore original content if failed
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        // Jika error 404, artinya file belum tersimpan, langsung reset area
                        if (xhr.status === 404) {
                            const input = document.getElementById(type);
                            if (input) {
                                input.value = '';
                            }
                            resetUploadArea(type);
                            showNotification(`${type === 'logo' ? 'Logo' : 'Banner'} dihapus`, 'success');
                        } else {
                            showNotification('Gagal menghapus file', 'error');
                            // Restore original content if failed
                            location.reload();
                        }
                    }
                });
            }
        }

        // Update fungsi removeVideo
        function removeVideo() {
            if (confirm('Apakah Anda yakin ingin menghapus video ini?')) {
                
                // Show loading state
                const uploadArea = document.getElementById('video-upload-area');
                const content = document.getElementById('video-content');
                
                content.innerHTML = `
                    <div class="text-center py-4">
                        <div class="spinner-border text-danger" role="status">
                            <span class="visually-hidden">Menghapus...</span>
                        </div>
                        <p class="mt-2 text-muted">Menghapus video...</p>
                    </div>
                `;
                
                // Jika ada video yang sudah tersimpan di database, hapus via AJAX
                $.ajax({
                    url: '/admin/profil/delete-video',
                    method: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            // Reset input file
                            const input = document.getElementById('video_profil');
                            if (input) {
                                input.value = '';
                            }
                            
                            // Reset upload area
                            resetUploadArea('video');
                            
                            showNotification(response.message, 'success');
                        } else {
                            showNotification(response.message || 'Gagal menghapus video', 'error');
                            // Restore original content if failed
                            location.reload();
                        }
                    },
                    error: function(xhr) {
                        // Jika error 404, artinya file belum tersimpan, langsung reset area
                        if (xhr.status === 404) {
                            const input = document.getElementById('video_profil');
                            if (input) {
                                input.value = '';
                            }
                            resetUploadArea('video');
                            showNotification('Video dihapus', 'success');
                        } else {
                            showNotification('Gagal menghapus video', 'error');
                            // Restore original content if failed
                            location.reload();
                        }
                    }
                });
            }
        }

        // Enhanced resetUploadArea function
        function resetUploadArea(type) {
            const uploadArea = document.getElementById(`${type}-upload-area`);
            const content = document.getElementById(`${type}-content`);
            
            if (content) {
                let placeholder = '';
                if (type === 'video') {
                    placeholder = `
                        <div id="video-placeholder">
                            <i class="fas fa-video text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload video profil</p>
                            <p class="text-gray-400 text-sm">Format: MP4, AVI, MOV, WMV, FLV, WebM<br>Maksimal: 50MB</p>
                        </div>
                    `;
                } else {
                    const typeLabel = type === 'logo' ? 'logo' : (type === 'banner' ? 'peta' : 'banner');
                    const maxSize = type === 'logo' ? '2MB' : '5MB';
                    placeholder = `
                        <div id="${type}-placeholder">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-600 mb-2 font-semibold">Klik untuk upload ${typeLabel}</p>
                            <p class="text-gray-400 text-sm">Format: JPG, PNG, GIF, SVG<br>Maksimal: ${maxSize}</p>
                        </div>
                    `;
                }
                
                content.innerHTML = placeholder;
            }
            
            if (uploadArea) {
                uploadArea.classList.remove('has-image', 'has-video');
            }
        }

        // Drag and drop functionality
        function initializeDragAndDrop() {
            const uploadAreas = ['logo-upload-area', 'banner-upload-area', 'video-upload-area'];

            uploadAreas.forEach(areaId => {
                const area = document.getElementById(areaId);
                if (!area) return;

                const type = areaId.includes('logo') ? 'logo' : (areaId.includes('banner') ? 'banner' : 'video');
                const input = document.getElementById(type === 'video' ? 'video_profil' : type);

                if (area && input) {
                    // Prevent default drag behaviors
                    ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                        area.addEventListener(eventName, preventDefaults, false);
                    });

                    // Highlight drop area
                    ['dragenter', 'dragover'].forEach(eventName => {
                        area.addEventListener(eventName, () => {
                            area.classList.add('drag-over');
                        }, false);
                    });

                    ['dragleave', 'drop'].forEach(eventName => {
                        area.addEventListener(eventName, () => {
                            area.classList.remove('drag-over');
                        }, false);
                    });

                    // Handle dropped files
                    area.addEventListener('drop', function(e) {
                        const files = e.dataTransfer.files;
                        if (files.length > 0) {
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(files[0]);
                            input.files = dataTransfer.files;

                            if (type === 'video') {
                                previewVideo(input);
                            } else {
                                previewImage(input, type);
                            }
                        }
                    }, false);
                }
            });
        }

        function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        // Get current location
        function getCurrentLocation() {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;

            btn.innerHTML = '<div class="spinner-border spinner-border-sm me-2"></div>Mengambil koordinat...';
            btn.disabled = true;

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    document.getElementById('latitude').value = position.coords.latitude.toFixed(7);
                    document.getElementById('longitude').value = position.coords.longitude.toFixed(7);

                    showNotification('Koordinat berhasil diambil!', 'success');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, function(error) {
                    let errorMessage = 'Gagal mendapatkan lokasi. ';
                    switch (error.code) {
                        case error.PERMISSION_DENIED:
                            errorMessage += 'Berikan izin akses lokasi.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            errorMessage += 'Lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            errorMessage += 'Timeout mendapatkan lokasi.';
                            break;
                        default:
                            errorMessage += 'Terjadi kesalahan yang tidak diketahui.';
                            break;
                    }

                    showNotification(errorMessage, 'error');
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                });
            } else {
                showNotification('Geolocation tidak didukung oleh browser ini.', 'error');
                btn.innerHTML = originalContent;
                btn.disabled = false;
            }
        }

        // Enhanced notification function
        function showNotification(message, type = 'success') {
            const iconClass = type === 'success' ? 'check-circle' : 'exclamation-triangle';
            const alertClass = type === 'success' ? 'success' : 'danger';

            const notification = $(`
                <div class="alert alert-${alertClass} alert-dismissible fade show position-fixed"
                     style="top: 20px; right: 20px; z-index: 9999; min-width: 300px; max-width: 400px;">
                    <i class="fas fa-${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);

            $('body').append(notification);

            setTimeout(() => {
                notification.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }

        // Form submission with better UX
        $('#profilForm').on('submit', function(e) {
            const submitBtn = $('#submitBtn');
            const originalText = submitBtn.html();

            submitBtn.html('<div class="spinner-border spinner-border-sm me-2"></div>Menyimpan...').prop('disabled', true);

            // Timeout fallback
            setTimeout(() => {
                if (document.getElementById('submitBtn') && document.getElementById('submitBtn').disabled) {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            }, 30000);
        });

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
