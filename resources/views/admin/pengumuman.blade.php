<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pengumuman - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Pengumuman */
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
        }

        .card-header-custom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .card-title-custom {
            font-size: 1.25rem;
            font-weight: 600;
            color: #1f2937;
        }

        .btn-tambah-pengumuman {
            background: #8b5cf6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-tambah-pengumuman:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            color: white;
        }

        .search-filter-section {
            margin-bottom: 1.5rem;
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .custom-table th,
        .custom-table td {
            padding: 1rem;
            text-align: left;
            border-bottom: 1px solid #e5e7eb;
        }

        .custom-table th {
            background: #f8fafc;
            font-weight: 600;
            color: #374151;
        }

        .kategori-badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .kategori-umum { background: #dbeafe; color: #1e40af; }
        .kategori-penting { background: #fef3c7; color: #d97706; }
        .kategori-kegiatan { background: #d1fae5; color: #047857; }
        .kategori-pelayanan { background: #fce7f3; color: #be185d; }
        .kategori-lainnya { background: #e5e7eb; color: #374151; }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-aktif {
            background: #10b981;
            color: white;
        }

        .status-tidak_aktif {
            background: #ef4444;
            color: white;
        }

        .pengumuman-date {
            font-weight: 600;
            color: #1f2937;
        }

        .pengumuman-time {
            font-size: 0.875rem;
            color: #6b7280;
        }

        .views-badge {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
        }

        .penting-badge {
            background: #fbbf24;
            color: #92400e;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            background: #f3f4f6;
            color: #374151;
            padding: 0.5rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-view:hover {
            background: #10b981;
            color: white;
        }

        .card-footer {
            background: #f8fafc;
            padding: 1.25rem;
            border-radius: 0 0 1rem 1rem;
        }

        .pagination-links .page-link {
            border-radius: 0.5rem;
            margin: 0 0.25rem;
            padding: 0.5rem 1rem;
        }

        .pagination-links .page-item.active .page-link {
            background: #8b5cf6;
            border-color: #8b5cf6;
        }

        .modal-content {
            border-radius: 1rem;
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
        }

        .btn-close-white {
            filter: invert(1);
        }

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

        /* Animasi Fade In */
        .pengumuman-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: pengumumanFadeInUp 0.6s ease forwards;
        }

        @keyframes pengumumanFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pengumuman-active {
            border-left: 4px solid #10b981;
        }

        .pengumuman-inactive {
            opacity: 0.7;
            border-left: 4px solid #ef4444;
        }

        .pengumuman-penting {
            border-left: 4px solid #f59e0b;
            background: #fffbeb;
        }

        .custom-control {
            position: relative;
            display: block;
            min-height: 1.5rem;
            padding-left: 1.5rem;
        }

        .custom-control-input {
            position: absolute;
            left: 0;
            z-index: -1;
            width: 1rem;
            height: 1.25rem;
            opacity: 0;
        }

        .custom-control-label {
            position: relative;
            margin-bottom: 0;
            vertical-align: top;
        }

        .custom-control-label::before {
            position: absolute;
            top: 0.25rem;
            left: -1.5rem;
            display: block;
            width: 1rem;
            height: 1rem;
            pointer-events: none;
            content: "";
            background-color: #fff;
            border: 1px solid #adb5bd;
            border-radius: 0.25rem;
        }

        .custom-control-label::after {
            position: absolute;
            top: 0.25rem;
            left: -1.5rem;
            display: block;
            width: 1rem;
            height: 1rem;
            content: "";
            background: no-repeat 50%/50% 50%;
        }

        .custom-switch .custom-control-label::before {
            left: -2.25rem;
            width: 1.75rem;
            pointer-events: all;
            border-radius: 0.5rem;
        }

        .custom-switch .custom-control-label::after {
            top: calc(0.25rem + 2px);
            left: calc(-2.25rem + 2px);
            width: calc(1rem - 4px);
            height: calc(1rem - 4px);
            background-color: #adb5bd;
            border-radius: 0.5rem;
            transition: transform 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .custom-switch .custom-control-input:checked ~ .custom-control-label::after {
            background-color: #fff;
            transform: translateX(0.75rem);
        }

        .custom-switch .custom-control-input:checked ~ .custom-control-label::before {
            color: #fff;
            border-color: #10b981;
            background-color: #10b981;
        }

        /* CKEditor 5 Custom Styling */
        .ck-editor__editable {
            min-height: 200px;
        }

        .ck.ck-editor {
            max-width: 100%;
        }

        .ck-content {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 pengumuman-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Pengumuman</h1>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show pengumuman-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show pengumuman-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show pengumuman-fade-in" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>Ada kesalahan pada form:</strong>
                        <ul class="mb-0 mt-2">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Card -->
                <div class="content-card pengumuman-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Daftar Pengumuman</h2>
                        <button class="btn-tambah-pengumuman" data-bs-toggle="modal" data-bs-target="#tambahPengumumanModal">
                            <i class="fas fa-bullhorn me-2"></i>Tambah Pengumuman
                        </button>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="search-filter-section mb-6">
                        <div class="row">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari pengumuman berdasarkan judul...">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <select class="form-select" id="filterKategori">
                                    <option value="">Semua Kategori</option>
                                    <option value="umum">Umum</option>
                                    <option value="penting">Penting</option>
                                    <option value="kegiatan">Kegiatan</option>
                                    <option value="pelayanan">Pelayanan</option>
                                    <option value="lainnya">Lainnya</option>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button class="btn btn-outline-secondary w-100" onclick="resetFilters()">
                                    <i class="fas fa-undo me-1"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 35%">Pengumuman</th>
                                    <th style="width: 12%">Kategori</th>
                                    <th style="width: 18%">Tanggal</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 8%">Views</th>
                                    <th style="width: 17%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($pengumuman ?? [] as $index => $item)
                                @php
                                    $isActive = $item->status === 'aktif' && $item->is_active;
                                    $isInactive = $item->status === 'tidak_aktif' || !$item->is_active;
                                    $rowClass = $item->penting ? 'pengumuman-penting' : ($isActive ? 'pengumuman-active' : 'pengumuman-inactive');
                                @endphp
                                <tr class="pengumuman-fade-in {{ $rowClass }}" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <div class="pengumuman-info">
                                            <div class="pengumuman-title fw-bold d-flex align-items-center">
                                                @if($item->penting)
                                                    <i class="fas fa-exclamation-triangle text-warning me-2" title="Penting"></i>
                                                @endif
                                                {{ $item->judul ?? 'Pengumuman Kegiatan' }}
                                            </div>
                                            @if($item->konten)
                                                <small class="text-muted d-block mt-1">{{ Str::limit(strip_tags($item->konten), 100) }}</small>
                                            @endif
                                            <div class="mt-1 d-flex align-items-center gap-2">
                                                @if($item->penting)
                                                    <span class="penting-badge">
                                                        <i class="fas fa-star"></i> Penting
                                                    </span>
                                                @endif
                                                @if($item->gambar && $item->getRawOriginal('gambar'))
                                                    <small class="text-info">
                                                        <i class="fas fa-image"></i> Ada gambar
                                                    </small>
                                                @endif
                                                <small class="text-muted">
                                                    Target: {{ ucwords(str_replace('_', ' ', $item->target_audience ?? 'Semua')) }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="kategori-badge kategori-{{ $item->kategori ?? 'umum' }}">
                                            {{ ucfirst($item->kategori ?? 'Umum') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="pengumuman-date">
                                            {{ $item->tanggal_mulai ? $item->tanggal_mulai->format('d/m/Y') : date('d/m/Y') }}
                                            @if($item->tanggal_berakhir)
                                                <br><small class="text-muted">s/d {{ $item->tanggal_berakhir->format('d/m/Y') }}</small>
                                            @else
                                                <br><small class="text-success">Tidak terbatas</small>
                                            @endif
                                        </div>
                                        @if($item->waktu_mulai)
                                            <div class="pengumuman-time">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ \Carbon\Carbon::parse($item->waktu_mulai)->format('H:i') }}
                                                @if($item->waktu_berakhir)
                                                    - {{ \Carbon\Carbon::parse($item->waktu_berakhir)->format('H:i') }}
                                                @endif
                                                WIB
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="custom-control custom-switch">
                                            <input type="checkbox" class="custom-control-input status-toggle" 
                                                   id="status{{ $item->id ?? ($index + 1) }}" 
                                                   data-id="{{ $item->id ?? ($index + 1) }}"
                                                   {{ ($item->status ?? 'aktif') == 'aktif' ? 'checked' : '' }}>
                                            <label class="custom-control-label" for="status{{ $item->id ?? ($index + 1) }}"></label>
                                        </div>
                                        <small class="d-block text-center mt-1">
                                            <span class="status-badge status-{{ $item->status ?? 'aktif' }}">
                                                {{ ucfirst($item->status ?? 'Aktif') }}
                                            </span>
                                        </small>
                                    </td>
                                    <td>
                                        <span class="views-badge">
                                            <i class="fas fa-eye"></i>
                                            {{ $item->views ?? 0 }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-view" onclick="viewItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Lihat" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" onclick="editItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Edit" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn btn-delete" onclick="deleteItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            @if(($item->status ?? 'aktif') == 'aktif' && ($item->is_active ?? true))
                                                <a href="{{ route('admin.pengumuman', $item->slug ?? 'sample-slug') }}" 
                                                   target="_blank" class="action-btn" title="Lihat di Website" data-bs-toggle="tooltip">
                                                    <i class="fas fa-external-link-alt"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada pengumuman yang ditambahkan</p>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPengumumanModal">
                                            <i class="fas fa-bullhorn me-1"></i>Tambah Pengumuman Pertama
                                        </button>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if(isset($pengumuman) && $pengumuman->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $pengumuman->firstItem() }} - {{ $pengumuman->lastItem() }}
                                    dari {{ $pengumuman->total() }} pengumuman
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $pengumuman->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tambah Pengumuman -->
            <div class="modal fade" id="tambahPengumumanModal" tabindex="-1" aria-labelledby="tambahPengumumanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="tambahPengumumanModalLabel">
                                <i class="fas fa-bullhorn me-2"></i>Tambah Pengumuman Baru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formTambahPengumuman" action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="judul" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" required
                                               placeholder="Masukkan judul pengumuman" value="{{ old('judul') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                            <option value="penting" {{ old('kategori') == 'penting' ? 'selected' : '' }}>Penting</option>
                                            <option value="kegiatan" {{ old('kategori') == 'kegiatan' ? 'selected' : '' }}>Kegiatan</option>
                                            <option value="pelayanan" {{ old('kategori') == 'pelayanan' ? 'selected' : '' }}>Pelayanan</option>
                                            <option value="lainnya" {{ old('kategori') == 'lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="konten" class="form-label">Konten Pengumuman <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="konten" name="konten" rows="6" required
                                              placeholder="Isi konten pengumuman...">{{ old('konten') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required
                                               value="{{ old('tanggal_mulai', date('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                                        <input type="date" class="form-control" id="tanggal_berakhir" name="tanggal_berakhir"
                                               value="{{ old('tanggal_berakhir') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai"
                                               value="{{ old('waktu_mulai') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="waktu_berakhir" class="form-label">Waktu Berakhir</label>
                                        <input type="time" class="form-control" id="waktu_berakhir" name="waktu_berakhir"
                                               value="{{ old('waktu_berakhir') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="target_audience" class="form-label">Target Audience <span class="text-danger">*</span></label>
                                        <select class="form-select" id="target_audience" name="target_audience" required>
                                            <option value="">Pilih Target</option>
                                            <option value="semua" {{ old('target_audience') == 'semua' ? 'selected' : '' }}>Semua</option>
                                            <option value="warga" {{ old('target_audience') == 'warga' ? 'selected' : '' }}>Warga</option>
                                            <option value="perangkat" {{ old('target_audience') == 'perangkat' ? 'selected' : '' }}>Perangkat</option>
                                            <option value="tokoh_masyarakat" {{ old('target_audience') == 'tokoh_masyarakat' ? 'selected' : '' }}>Tokoh Masyarakat</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="gambar" class="form-label">Gambar</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input type="checkbox" class="form-check-input" id="penting" name="penting" value="1"
                                               {{ old('penting') ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold text-warning" for="penting">
                                            <i class="fas fa-star me-1"></i>Tandai sebagai Pengumuman Penting
                                        </label>
                                    </div>
                                    <small class="text-muted">Pengumuman penting akan ditampilkan di bagian atas dan mendapat highlight khusus</small>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Pengumuman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Pengumuman -->
            <div class="modal fade" id="editPengumumanModal" tabindex="-1" aria-labelledby="editPengumumanModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-dark" id="editPengumumanModalLabel">
                                <i class="fas fa-edit me-2"></i>Edit Pengumuman
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditPengumuman" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body" id="editPengumumanContent">
                                <div class="text-center">
                                    <div class="loading"></div>
                                    <p class="mt-2">Memuat form edit...</p>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Update Pengumuman
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Konfirmasi Hapus -->
            <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header bg-danger">
                            <h5 class="modal-title text-white" id="deleteModalLabel">
                                <i class="fas fa-exclamation-triangle me-2"></i>Konfirmasi Hapus
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body text-center py-4">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                            <h5 class="mb-3">Apakah Anda yakin?</h5>
                            <p class="text-muted">Pengumuman yang dihapus tidak dapat dikembalikan lagi.</p>
                            <div class="alert alert-warning mt-3">
                                <small><i class="fas fa-info-circle me-1"></i>Pastikan pengumuman ini sudah tidak diperlukan lagi</small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Batal
                            </button>
                            <form id="deleteForm" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fas fa-trash me-1"></i>Ya, Hapus Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- CKEditor 5 - VERSI TERBARU DAN AMAN -->
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>
    <script>
        let editorInstance;
        let editEditorInstance;

        $(document).ready(function() {
            // Initialize CKEditor 5 untuk form tambah
            ClassicEditor
                .create(document.querySelector('#konten'), {
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'underline',
                            '|',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'link',
                            'insertTable',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'undo',
                            'redo'
                        ]
                    },
                    language: 'id',
                    table: {
                        contentToolbar: [
                            'tableColumn',
                            'tableRow',
                            'mergeTableCells'
                        ]
                    }
                })
                .then(editor => {
                    editorInstance = editor;
                    editor.model.document.on('change:data', () => {
                        // Sync dengan textarea asli
                        document.querySelector('#konten').value = editor.getData();
                    });
                })
                .catch(error => {
                    console.error('Error initializing CKEditor:', error);
                });

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });

            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add staggered animation to fade-in elements
            const fadeElements = document.querySelectorAll('.pengumuman-fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Search functionality
        $('#searchInput').on('keyup', function() {
            var value = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

        // Filter by kategori
        $('#filterKategori').on('change', function() {
            var kategori = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                if (kategori === '') {
                    $(this).show();
                } else {
                    $(this).toggle($(this).find('.kategori-badge').text().toLowerCase().indexOf(kategori) > -1);
                }
            });
        });

        // Filter by status
        $('#filterStatus').on('change', function() {
            var status = $(this).val().toLowerCase();
            $('tbody tr').filter(function() {
                if (status === '') {
                    $(this).show();
                } else {
                    $(this).toggle($(this).find('.status-badge').text().toLowerCase().indexOf(status) > -1);
                }
            });
        });

        // Reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#filterKategori').val('');
            $('#filterStatus').val('');
            $('tbody tr').show();
        }

        // Status Toggle
        $('.status-toggle').change(function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 'aktif' : 'tidak_aktif';
            
            $.ajax({
                url: `/admin/pengumuman/${id}/status`,
                type: 'PATCH',
                data: { status: status },
                success: function(response) {
                    if(response.success) {
                        // Update status badge
                        const statusBadge = $(`.status-badge:contains('${status === 'aktif' ? 'Tidak Aktif' : 'Aktif'}')`);
                        statusBadge.removeClass('status-aktif status-tidak_aktif').addClass('status-' + status);
                        statusBadge.text(status === 'aktif' ? 'Aktif' : 'Tidak Aktif');
                        
                        // Show success message
                        showAlert('success', response.message);
                    }
                },
                error: function() {
                    // Revert checkbox
                    $(this).prop('checked', !$(this).is(':checked'));
                    showAlert('error', 'Gagal mengubah status');
                }
            });
        });

        // Action functions
        function deleteItem(id) {
            $('#deleteForm').attr('action', '/admin/pengumuman/delete/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Redirect to detail page
            setTimeout(() => {
                window.location.href = '/admin/pengumuman/show/' + id;
            }, 500);
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Load edit form via AJAX
            $.ajax({
                url: '/admin/pengumuman/edit/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        
                        // Build edit form content
                        const content = buildEditForm(data);
                        
                        $('#editPengumumanContent').html(content);
                        $('#formEditPengumuman').attr('action', '/admin/pengumuman/update/' + id);
                        $('#editPengumumanModal').modal('show');
                        
                        // Initialize CKEditor 5 for edit form
                        ClassicEditor
                            .create(document.querySelector('#edit_konten'), {
                                toolbar: {
                                    items: [
                                        'heading',
                                        '|',
                                        'bold',
                                        'italic',
                                        'underline',
                                        '|',
                                        'bulletedList',
                                        'numberedList',
                                        '|',
                                        'link',
                                        'insertTable',
                                        '|',
                                        'outdent',
                                        'indent',
                                        '|',
                                        'undo',
                                        'redo'
                                    ]
                                },
                                language: 'id',
                                table: {
                                    contentToolbar: [
                                        'tableColumn',
                                        'tableRow',
                                        'mergeTableCells'
                                    ]
                                }
                            })
                            .then(editor => {
                                editEditorInstance = editor;
                                editor.model.document.on('change:data', () => {
                                    document.querySelector('#edit_konten').value = editor.getData();
                                });
                            })
                            .catch(error => {
                                console.error('Error initializing edit CKEditor:', error);
                            });
                    } else {
                        showAlert('error', 'Gagal memuat data pengumuman: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let errorMessage = 'Terjadi kesalahan saat memuat form edit.';
                    
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Pengumuman tidak ditemukan.';
                    } else if (xhr.status === 500) {
                        errorMessage = 'Terjadi kesalahan server. Silakan coba lagi.';
                    }
                    
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        function buildEditForm(data) {
            // Escape function untuk mencegah XSS
            function escapeHtml(text) {
                if (!text) return '';
                return text.toString()
                    .replace(/&/g, "&amp;")
                    .replace(/</g, "&lt;")
                    .replace(/>/g, "&gt;")
                    .replace(/"/g, "&quot;")
                    .replace(/'/g, "&#039;");
            }

            // Build kategori options
            const kategoris = ['umum', 'penting', 'kegiatan', 'pelayanan', 'lainnya'];
            let kategoriOptions = '';
            kategoris.forEach(function(kat) {
                const selected = data.kategori === kat ? 'selected' : '';
                kategoriOptions += `<option value="${kat}" ${selected}>${kat.charAt(0).toUpperCase() + kat.slice(1)}</option>`;
            });

            // Build target audience options
            const targets = ['semua', 'warga', 'perangkat', 'tokoh_masyarakat'];
            let targetOptions = '';
            targets.forEach(function(target) {
                const selected = data.target_audience === target ? 'selected' : '';
                const label = target.replace('_', ' ').split(' ').map(word => word.charAt(0).toUpperCase() + word.slice(1)).join(' ');
                targetOptions += `<option value="${target}" ${selected}>${label}</option>`;
            });

            // Build current image preview
            let currentImageHtml = '';
            if (data.gambar) {
                currentImageHtml = 
                    `<div class="mt-2">
                        <label class="form-label">Gambar Saat Ini:</label><br>
                        <img src="${data.gambar}" alt="Current" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 0.25rem;">
                    </div>`;
            }

            return `
                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label for="edit_judul" class="form-label">Judul Pengumuman <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_judul" name="judul" required value="${escapeHtml(data.judul)}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_kategori" name="kategori" required>
                            ${kategoriOptions}
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_konten" class="form-label">Konten Pengumuman <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="edit_konten" name="konten" rows="6" required>${escapeHtml(data.konten || '')}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_tanggal_mulai" class="form-label">Tanggal Mulai <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tanggal_mulai" name="tanggal_mulai" required value="${data.tanggal_mulai}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_tanggal_berakhir" class="form-label">Tanggal Berakhir</label>
                        <input type="date" class="form-control" id="edit_tanggal_berakhir" name="tanggal_berakhir" value="${data.tanggal_berakhir || ''}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="edit_waktu_mulai" name="waktu_mulai" value="${data.waktu_mulai || ''}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_waktu_berakhir" class="form-label">Waktu Berakhir</label>
                        <input type="time" class="form-control" id="edit_waktu_berakhir" name="waktu_berakhir" value="${data.waktu_berakhir || ''}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edit_target_audience" class="form-label">Target Audience <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_target_audience" name="target_audience" required>
                            ${targetOptions}
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="aktif" ${data.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                            <option value="tidak_aktif" ${data.status === 'tidak_aktif' ? 'selected' : ''}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_gambar" class="form-label">Gambar</label>
                        <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                        <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                        ${currentImageHtml}
                    </div>
                </div>
                <div class="mb-3">
                    <div class="form-check">
                        <input type="checkbox" class="form-check-input" id="edit_penting" name="penting" value="1" ${data.penting ? 'checked' : ''}>
                        <label class="form-check-label fw-bold text-warning" for="edit_penting">
                            <i class="fas fa-star me-1"></i>Tandai sebagai Pengumuman Penting
                        </label>
                    </div>
                </div>
            `;
        }

        // Show alert function
        function showAlert(type, message) {
            const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
            const iconClass = type === 'success' ? 'fa-check-circle' : 'fa-exclamation-circle';
            
            const alert = $(`
                <div class="alert ${alertClass} alert-dismissible fade show" role="alert">
                    <i class="fas ${iconClass} me-2"></i>
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            `);
            
            $('.page-content').prepend(alert);
            
            setTimeout(function() {
                alert.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }

        // Form submission handlers
        $('#formTambahPengumuman').on('submit', function(e) {
            if (editorInstance) {
                document.querySelector('#konten').value = editorInstance.getData();
            }
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditPengumuman').on('submit', function(e) {
            if (editEditorInstance) {
                document.querySelector('#edit_konten').value = editEditorInstance.getData();
            }
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahPengumumanModal').on('hidden.bs.modal', function() {
            $('#formTambahPengumuman')[0].reset();
            $('#formTambahPengumuman button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Pengumuman').prop('disabled', false);
            if (editorInstance) {
                editorInstance.setData('');
            }
        });

        $('#editPengumumanModal').on('hidden.bs.modal', function() {
            $('#formEditPengumuman button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Pengumuman').prop('disabled', false);
            if (editEditorInstance) {
                editEditorInstance.destroy().then(() => {
                    editEditorInstance = null;
                });
            }
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