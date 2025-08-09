<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Layanan - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Layanan */
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

        .btn-tambah-layanan {
            background: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-tambah-layanan:hover {
            background: #2563eb;
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

        .kode-layanan {
            background: #dbeafe;
            color: #1e40af;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .biaya-badge {
            background: #fef3c7;
            color: #d97706;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .waktu-badge {
            background: #fce7f3;
            color: #be185d;
            padding: 0.25rem 0.5rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 500;
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
            background: #059669;
            border-color: #059669;
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
        .layanan-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: layananFadeInUp 0.6s ease forwards;
        }

        @keyframes layananFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .layanan-active {
            border-left: 4px solid #10b981;
        }

        .layanan-inactive {
            opacity: 0.7;
            border-left: 4px solid #ef4444;
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
            min-height: 150px;
        }

        .ck.ck-editor {
            max-width: 100%;
        }

        .ck-content {
            font-family: 'Inter', sans-serif;
        }

        .urutan-badge {
            background: #e5e7eb;
            color: #374151;
            padding: 0.25rem 0.5rem;
            border-radius: 50%;
            font-size: 0.75rem;
            font-weight: 600;
            width: 2rem;
            height: 2rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 layanan-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Layanan</h1>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show layanan-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show layanan-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show layanan-fade-in" role="alert">
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
                <div class="content-card layanan-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Daftar Layanan</h2>
                        <button class="btn-tambah-layanan" data-bs-toggle="modal" data-bs-target="#tambahLayananModal">
                            <i class="fas fa-plus me-2"></i>Tambah Layanan
                        </button>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="search-filter-section mb-6">
                        <div class="row">
                            <div class="col-md-6 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari layanan berdasarkan nama atau kode...">
                                </div>
                            </div>
                            <div class="col-md-3 mb-3 mb-md-0">
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="tidak_aktif">Tidak Aktif</option>
                                </select>
                            </div>
                            <div class="col-md-3">
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
                                    <th style="width: 5%">#</th>
                                    <th style="width: 10%">Kode</th>
                                    <th style="width: 30%">Layanan</th>
                                    <th style="width: 15%">Biaya & Waktu</th>
                                    <th style="width: 15%">Penanggung Jawab</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($layanan ?? [] as $index => $item)
                                @php
                                    $isActive = $item->status === 'aktif';
                                    $rowClass = $isActive ? 'layanan-active' : 'layanan-inactive';
                                @endphp
                                <tr class="layanan-fade-in {{ $rowClass }}" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <span class="urutan-badge">{{ $item->urutan ?: ($index + 1) }}</span>
                                    </td>
                                    <td>
                                        <span class="kode-layanan">{{ $item->kode_layanan ?: 'LAY-' . str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </td>
                                    <td>
                                        <div class="layanan-info">
                                            <div class="layanan-title fw-bold">
                                                {{ $item->nama_layanan ?? 'Nama Layanan' }}
                                            </div>
                                            @if($item->deskripsi)
                                                <small class="text-muted d-block mt-1">{{ Str::limit(strip_tags($item->deskripsi), 100) }}</small>
                                            @endif
                                            @if($item->formulir_url)
                                                <small class="text-success d-block mt-1">
                                                    <i class="fas fa-link"></i> Formulir Online
                                                </small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="biaya-waktu">
                                            <span class="biaya-badge d-block mb-1">
                                                <i class="fas fa-money-bill-wave me-1"></i>
                                                {{ $item->biaya ?: 'Gratis' }}
                                            </span>
                                            <span class="waktu-badge">
                                                <i class="fas fa-clock me-1"></i>
                                                {{ $item->waktu_penyelesaian ?: '1-3 Hari' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="penanggung-jawab">
                                            <div class="fw-bold text-sm">{{ $item->penanggung_jawab ?: 'Staff Admin' }}</div>
                                            @if($item->kontak)
                                                <small class="text-muted">{{ $item->kontak }}</small>
                                            @endif
                                        </div>
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
                                            @if(($item->status ?? 'aktif') == 'aktif')
                                                @if($item->formulir_url)
                                                    <a href="{{ $item->formulir_url }}" target="_blank"
                                                       class="action-btn" title="Formulir Online" data-bs-toggle="tooltip">
                                                        <i class="fas fa-external-link-alt"></i>
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-concierge-bell fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada layanan yang ditambahkan</p>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahLayananModal">
                                            <i class="fas fa-plus me-1"></i>Tambah Layanan Pertama
                                        </button>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if(isset($layanan) && $layanan->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $layanan->firstItem() }} - {{ $layanan->lastItem() }}
                                    dari {{ $layanan->total() }} layanan
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $layanan->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tambah Layanan -->
            <div class="modal fade" id="tambahLayananModal" tabindex="-1" aria-labelledby="tambahLayananModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-success">
                            <h5 class="modal-title text-white" id="tambahLayananModalLabel">
                                <i class="fas fa-plus me-2"></i>Tambah Layanan Baru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formTambahLayanan" action="{{ route('admin.layanan.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="kode_layanan" class="form-label">Kode Layanan</label>
                                        <input type="text" class="form-control" id="kode_layanan" name="kode_layanan"
                                               placeholder="LAY-0001 (otomatis jika kosong)" value="{{ old('kode_layanan') }}">
                                    </div>
                                    <div class="col-md-8 mb-3">
                                        <label for="nama_layanan" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_layanan" name="nama_layanan" required
                                               placeholder="Masukkan nama layanan" value="{{ old('nama_layanan') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="deskripsi" class="form-label">Deskripsi Layanan <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="deskripsi" name="deskripsi" rows="4" required
                                              placeholder="Deskripsi lengkap layanan...">{{ old('deskripsi') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="persyaratan" class="form-label">Persyaratan <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="persyaratan" name="persyaratan" rows="5" required
                                                  placeholder="1. Persyaratan pertama&#10;2. Persyaratan kedua&#10;3. Dst...">{{ old('persyaratan') }}</textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="prosedur" class="form-label">Prosedur <span class="text-danger">*</span></label>
                                        <textarea class="form-control" id="prosedur" name="prosedur" rows="5" required
                                                  placeholder="1. Langkah pertama&#10;2. Langkah kedua&#10;3. Dst...">{{ old('prosedur') }}</textarea>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="biaya" class="form-label">Biaya</label>
                                        <input type="text" class="form-control" id="biaya" name="biaya"
                                               placeholder="Gratis / Rp 10.000" value="{{ old('biaya') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="waktu_penyelesaian" class="form-label">Waktu Penyelesaian</label>
                                        <input type="text" class="form-control" id="waktu_penyelesaian" name="waktu_penyelesaian"
                                               placeholder="1-3 Hari Kerja" value="{{ old('waktu_penyelesaian') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="penanggung_jawab" name="penanggung_jawab" required
                                               placeholder="Nama Penanggung Jawab" value="{{ old('penanggung_jawab') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="kontak" class="form-label">Kontak</label>
                                        <input type="text" class="form-control" id="kontak" name="kontak"
                                               placeholder="08123456789" value="{{ old('kontak') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="output_layanan" class="form-label">Output Layanan</label>
                                        <input type="text" class="form-control" id="output_layanan" name="output_layanan"
                                               placeholder="Surat Keterangan, Legalisir, dll" value="{{ old('output_layanan') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="formulir_url" class="form-label">URL Formulir Online</label>
                                        <input type="url" class="form-control" id="formulir_url" name="formulir_url"
                                               placeholder="https://forms.google.com/..." value="{{ old('formulir_url') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="dasar_hukum" class="form-label">Dasar Hukum</label>
                                    <textarea class="form-control" id="dasar_hukum" name="dasar_hukum" rows="3"
                                              placeholder="UU/Perda yang mendasari layanan ini...">{{ old('dasar_hukum') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                            <option value="tidak_aktif" {{ old('status') == 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="urutan" class="form-label">Urutan</label>
                                        <input type="number" class="form-control" id="urutan" name="urutan" min="0"
                                               placeholder="0 (otomatis jika kosong)" value="{{ old('urutan') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-1"></i>Simpan Layanan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Layanan -->
            <div class="modal fade" id="editLayananModal" tabindex="-1" aria-labelledby="editLayananModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-dark" id="editLayananModalLabel">
                                <i class="fas fa-edit me-2"></i>Edit Layanan
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditLayanan" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body" id="editLayananContent">
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
                                    <i class="fas fa-save me-1"></i>Update Layanan
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
                            <p class="text-muted">Layanan yang dihapus tidak dapat dikembalikan lagi.</p>
                            <div class="alert alert-warning mt-3">
                                <small><i class="fas fa-info-circle me-1"></i>Pastikan layanan ini sudah tidak diperlukan lagi</small>
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
        let editorInstanceDesc, editEditorInstanceDesc;
        let editorInstancePersyaratan, editEditorInstancePersyaratan;
        let editorInstanceProsedur, editEditorInstanceProsedur;
        let editorInstanceDasarHukum, editEditorInstanceDasarHukum;

        $(document).ready(function() {
            // Initialize CKEditor 5 untuk form tambah
            initializeAddFormEditors();

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
            const fadeElements = document.querySelectorAll('.layanan-fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });
        });

        function initializeAddFormEditors() {
            // Deskripsi editor
            ClassicEditor
                .create(document.querySelector('#deskripsi'), {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    language: 'id'
                })
                .then(editor => {
                    editorInstanceDesc = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#deskripsi').value = editor.getData();
                    });
                })
                .catch(error => console.error('Error initializing deskripsi editor:', error));

            // Dasar Hukum editor
            ClassicEditor
                .create(document.querySelector('#dasar_hukum'), {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    language: 'id'
                })
                .then(editor => {
                    editorInstanceDasarHukum = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#dasar_hukum').value = editor.getData();
                    });
                })
                .catch(error => console.error('Error initializing dasar hukum editor:', error));
        }

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
            $('#filterStatus').val('');
            $('tbody tr').show();
        }

        // Status Toggle
        $('.status-toggle').change(function() {
            let id = $(this).data('id');
            let status = $(this).is(':checked') ? 'aktif' : 'tidak_aktif';

            $.ajax({
                url: `/admin/layanan/${id}/status`,
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
            $('#deleteForm').attr('action', '/admin/layanan/delete/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Redirect to detail page
            setTimeout(() => {
                window.location.href = '/admin/layanan/show/' + id;
            }, 500);
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Load edit form via AJAX
            $.ajax({
                url: '/admin/layanan/edit/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Build edit form content
                        const content = buildEditForm(data);

                        $('#editLayananContent').html(content);
                        $('#formEditLayanan').attr('action', '/admin/layanan/update/' + id);
                        $('#editLayananModal').modal('show');

                        // Initialize CKEditor 5 for edit form
                        initializeEditFormEditors();
                    } else {
                        showAlert('error', 'Gagal memuat data layanan: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let errorMessage = 'Terjadi kesalahan saat memuat form edit.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Layanan tidak ditemukan.';
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

        function initializeEditFormEditors() {
            // Deskripsi edit editor
            ClassicEditor
                .create(document.querySelector('#edit_deskripsi'), {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    language: 'id'
                })
                .then(editor => {
                    editEditorInstanceDesc = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#edit_deskripsi').value = editor.getData();
                    });
                })
                .catch(error => console.error('Error initializing edit deskripsi editor:', error));

            // Dasar Hukum edit editor
            ClassicEditor
                .create(document.querySelector('#edit_dasar_hukum'), {
                    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', '|', 'undo', 'redo'],
                    language: 'id'
                })
                .then(editor => {
                    editEditorInstanceDasarHukum = editor;
                    editor.model.document.on('change:data', () => {
                        document.querySelector('#edit_dasar_hukum').value = editor.getData();
                    });
                })
                .catch(error => console.error('Error initializing edit dasar hukum editor:', error));
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

            return `
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edit_kode_layanan" class="form-label">Kode Layanan</label>
                        <input type="text" class="form-control" id="edit_kode_layanan" name="kode_layanan" value="${escapeHtml(data.kode_layanan)}">
                    </div>
                    <div class="col-md-8 mb-3">
                        <label for="edit_nama_layanan" class="form-label">Nama Layanan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nama_layanan" name="nama_layanan" required value="${escapeHtml(data.nama_layanan)}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_deskripsi" class="form-label">Deskripsi Layanan <span class="text-danger">*</span></label>
                    <textarea class="form-control" id="edit_deskripsi" name="deskripsi" rows="4" required>${escapeHtml(data.deskripsi || '')}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_persyaratan" class="form-label">Persyaratan <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_persyaratan" name="persyaratan" rows="5" required>${escapeHtml(data.persyaratan || '')}</textarea>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_prosedur" class="form-label">Prosedur <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_prosedur" name="prosedur" rows="5" required>${escapeHtml(data.prosedur || '')}</textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="edit_biaya" class="form-label">Biaya</label>
                        <input type="text" class="form-control" id="edit_biaya" name="biaya" value="${escapeHtml(data.biaya || '')}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_waktu_penyelesaian" class="form-label">Waktu Penyelesaian</label>
                        <input type="text" class="form-control" id="edit_waktu_penyelesaian" name="waktu_penyelesaian" value="${escapeHtml(data.waktu_penyelesaian || '')}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_penanggung_jawab" class="form-label">Penanggung Jawab <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_penanggung_jawab" name="penanggung_jawab" required value="${escapeHtml(data.penanggung_jawab || '')}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_kontak" class="form-label">Kontak</label>
                        <input type="text" class="form-control" id="edit_kontak" name="kontak" value="${escapeHtml(data.kontak || '')}">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_output_layanan" class="form-label">Output Layanan</label>
                        <input type="text" class="form-control" id="edit_output_layanan" name="output_layanan" value="${escapeHtml(data.output_layanan || '')}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_formulir_url" class="form-label">URL Formulir Online</label>
                        <input type="url" class="form-control" id="edit_formulir_url" name="formulir_url" value="${escapeHtml(data.formulir_url || '')}">
                    </div>
                </div>
                <div class="mb-3">
                    <label for="edit_dasar_hukum" class="form-label">Dasar Hukum</label>
                    <textarea class="form-control" id="edit_dasar_hukum" name="dasar_hukum" rows="3">${escapeHtml(data.dasar_hukum || '')}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_status" name="status" required>
                            <option value="aktif" ${data.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                            <option value="tidak_aktif" ${data.status === 'tidak_aktif' ? 'selected' : ''}>Tidak Aktif</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_urutan" class="form-label">Urutan</label>
                        <input type="number" class="form-control" id="edit_urutan" name="urutan" min="0" value="${data.urutan || 0}">
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
        $('#formTambahLayanan').on('submit', function(e) {
            if (editorInstanceDesc) {
                document.querySelector('#deskripsi').value = editorInstanceDesc.getData();
            }
            if (editorInstanceDasarHukum) {
                document.querySelector('#dasar_hukum').value = editorInstanceDasarHukum.getData();
            }
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditLayanan').on('submit', function(e) {
            if (editEditorInstanceDesc) {
                document.querySelector('#edit_deskripsi').value = editEditorInstanceDesc.getData();
            }
            if (editEditorInstanceDasarHukum) {
                document.querySelector('#edit_dasar_hukum').value = editEditorInstanceDasarHukum.getData();
            }
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahLayananModal').on('hidden.bs.modal', function() {
            $('#formTambahLayanan')[0].reset();
            $('#formTambahLayanan button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Layanan').prop('disabled', false);
            if (editorInstanceDesc) {
                editorInstanceDesc.setData('');
            }
            if (editorInstanceDasarHukum) {
                editorInstanceDasarHukum.setData('');
            }
        });

        $('#editLayananModal').on('hidden.bs.modal', function() {
            $('#formEditLayanan button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Layanan').prop('disabled', false);
            if (editEditorInstanceDesc) {
                editEditorInstanceDesc.destroy().then(() => {
                    editEditorInstanceDesc = null;
                });
            }
            if (editEditorInstanceDasarHukum) {
                editEditorInstanceDasarHukum.destroy().then(() => {
                    editEditorInstanceDasarHukum = null;
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
