<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Data Penduduk - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Data Penduduk */
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

        .btn-tambah-penduduk {
            background: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
            border: none;
        }

        .btn-tambah-penduduk:hover {
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

        .status-pindah {
            background: #f59e0b;
            color: white;
        }

        .status-meninggal {
            background: #ef4444;
            color: white;
        }

        .jenis-kelamin-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .jk-pria { background: #dbeafe; color: #1e40af; }
        .jk-wanita { background: #fce7f3; color: #be185d; }

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

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem;
            padding: 1.5rem;
            position: relative;
            overflow: hidden;
        }

        .stats-card-success {
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);
        }

        .stats-card-pink {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .stats-card-orange {
            background: linear-gradient(135deg, #ff9a9e 0%, #fecfef 100%);
        }

        .stats-icon {
            font-size: 3rem;
            opacity: 0.3;
            position: absolute;
            right: 20px;
            top: 20px;
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
        .penduduk-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: pendudukFadeInUp 0.6s ease forwards;
        }

        @keyframes pendudukFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
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
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 penduduk-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Data Penduduk</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4 penduduk-fade-in" style="animation-delay: 0.1s;">
                <div class="col-md-3 mb-3">
                    <div class="stats-card">
                        <div class="position-relative">
                            <h6 class="mb-1">Total Penduduk</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($statistics['total']) }}</h3>
                            <small class="opacity-75">Jiwa</small>
                            <i class="fas fa-users stats-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card stats-card-success">
                        <div class="position-relative">
                            <h6 class="mb-1">Laki-laki</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($statistics['pria']) }}</h3>
                            <small class="opacity-75">Jiwa</small>
                            <i class="fas fa-male stats-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card stats-card-pink">
                        <div class="position-relative">
                            <h6 class="mb-1">Perempuan</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($statistics['wanita']) }}</h3>
                            <small class="opacity-75">Jiwa</small>
                            <i class="fas fa-female stats-icon"></i>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 mb-3">
                    <div class="stats-card stats-card-orange">
                        <div class="position-relative">
                            <h6 class="mb-1">Kepala Keluarga</h6>
                            <h3 class="mb-0 fw-bold">{{ number_format($statistics['kepala_keluarga']) }}</h3>
                            <small class="opacity-75">KK</small>
                            <i class="fas fa-home stats-icon"></i>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show penduduk-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show penduduk-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show penduduk-fade-in" role="alert">
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
                <div class="content-card penduduk-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Daftar Data Penduduk</h2>
                        <button class="btn-tambah-penduduk" data-bs-toggle="modal" data-bs-target="#tambahPendudukModal">
                            <i class="fas fa-user-plus me-2"></i>Tambah Data Penduduk
                        </button>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="search-filter-section mb-6">
                        <div class="row">
                            <div class="col-md-3 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari berdasarkan nama, NIK...">
                                </div>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="pindah">Pindah</option>
                                    <option value="meninggal">Meninggal</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <select class="form-select" id="filterJenisKelamin">
                                    <option value="">Semua Gender</option>
                                    <option value="L">Laki-laki</option>
                                    <option value="P">Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <select class="form-select" id="filterRT">
                                    <option value="">Semua RT</option>
                                    @foreach($rtOptions as $rt)
                                        <option value="{{ $rt }}">RT {{ $rt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 mb-3 mb-md-0">
                                <select class="form-select" id="filterRW">
                                    <option value="">Semua RW</option>
                                    @foreach($rwOptions as $rw)
                                        <option value="{{ $rw }}">RW {{ $rw }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-1">
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
                                    <th style="width: 20%">Identitas</th>
                                    <th style="width: 15%">Jenis Kelamin</th>
                                    <th style="width: 20%">Alamat</th>
                                    <th style="width: 10%">RT/RW</th>
                                    <th style="width: 15%">TTL & Umur</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($dataPenduduk ?? [] as $index => $item)
                                @php
                                    $umur = $item->tanggal_lahir ? \Carbon\Carbon::parse($item->tanggal_lahir)->age : 0;
                                @endphp
                                <tr class="penduduk-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <div class="penduduk-info">
                                            <div class="fw-bold">{{ $item->nama ?? 'Nama Lengkap' }}</div>
                                            <small class="text-muted d-block">NIK: {{ $item->nik ?? '1234567890123456' }}</small>
                                            @if($item->no_kk)
                                                <small class="text-muted d-block">KK: {{ $item->no_kk }}</small>
                                            @endif
                                            @if($item->pekerjaan)
                                                <small class="text-info d-block">{{ $item->pekerjaan }}</small>
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <span class="jenis-kelamin-badge {{ $item->jenis_kelamin === 'L' ? 'jk-pria' : 'jk-wanita' }}">
                                            <i class="fas fa-{{ $item->jenis_kelamin === 'L' ? 'male' : 'female' }} me-1"></i>
                                            {{ $item->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                                        </span>
                                        @if($item->status_perkawinan)
                                            <br><small class="text-muted">{{ $item->status_perkawinan }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div>{{ $item->alamat ?? 'Alamat tidak tersedia' }}</div>
                                        @if($item->telepon)
                                            <small class="text-muted d-block">
                                                <i class="fas fa-phone me-1"></i>{{ $item->telepon }}
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-light text-dark">
                                            {{ $item->rt ?? '-' }}/{{ $item->rw ?? '-' }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($item->tempat_lahir || $item->tanggal_lahir)
                                            <div class="fw-semibold">
                                                {{ $item->tempat_lahir ?? 'Tempat' }},
                                                {{ $item->tanggal_lahir ? $item->tanggal_lahir->format('d/m/Y') : '01/01/1990' }}
                                            </div>
                                            <small class="text-muted">Umur: {{ $umur }} tahun</small>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $item->status ?? 'aktif' }}">
                                            {{ ucfirst($item->status ?? 'Aktif') }}
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
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada data penduduk yang ditambahkan</p>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPendudukModal">
                                            <i class="fas fa-user-plus me-1"></i>Tambah Data Penduduk Pertama
                                        </button>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if(isset($dataPenduduk) && $dataPenduduk->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $dataPenduduk->firstItem() }} - {{ $dataPenduduk->lastItem() }}
                                    dari {{ $dataPenduduk->total() }} data penduduk
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $dataPenduduk->withQueryString()->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tambah Data Penduduk -->
            <div class="modal fade" id="tambahPendudukModal" tabindex="-1" aria-labelledby="tambahPendudukModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="tambahPendudukModalLabel">
                                <i class="fas fa-user-plus me-2"></i>Tambah Data Penduduk Baru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formTambahPenduduk" action="{{ route('admin.datapenduduk.store') }}" method="POST">
                            @csrf
                            <div class="modal-body">
                                <!-- Identitas Pribadi -->
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <h6 class="text-primary"><i class="fas fa-id-card me-2"></i>Identitas Pribadi</h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="nik" class="form-label">NIK <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nik" name="nik" required maxlength="16"
                                               placeholder="Masukkan NIK 16 digit" value="{{ old('nik') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="no_kk" class="form-label">No. KK</label>
                                        <input type="text" class="form-control" id="no_kk" name="no_kk" maxlength="16"
                                               placeholder="Masukkan No. KK" value="{{ old('no_kk') }}">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="nama" name="nama" required
                                           placeholder="Masukkan nama lengkap" value="{{ old('nama') }}">
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                                        <select class="form-select" id="jenis_kelamin" name="jenis_kelamin" required>
                                            <option value="">Pilih Jenis Kelamin</option>
                                            <option value="L" {{ old('jenis_kelamin') == 'L' ? 'selected' : '' }}>Laki-laki</option>
                                            <option value="P" {{ old('jenis_kelamin') == 'P' ? 'selected' : '' }}>Perempuan</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir"
                                               placeholder="Tempat lahir" value="{{ old('tempat_lahir') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="date" class="form-control" id="tanggal_lahir" name="tanggal_lahir"
                                               value="{{ old('tanggal_lahir') }}">
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="row">
                                    <div class="col-12 mb-3 mt-3">
                                        <h6 class="text-primary"><i class="fas fa-map-marker-alt me-2"></i>Alamat & Tempat Tinggal</h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2"
                                              placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-3 mb-3">
                                        <label for="rt" class="form-label">RT</label>
                                        <input type="text" class="form-control" id="rt" name="rt" maxlength="3"
                                               placeholder="001" value="{{ old('rt') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="rw" class="form-label">RW</label>
                                        <input type="text" class="form-control" id="rw" name="rw" maxlength="3"
                                               placeholder="001" value="{{ old('rw') }}">
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="agama" class="form-label">Agama</label>
                                        <select class="form-select" id="agama" name="agama">
                                            <option value="Islam" {{ old('agama', 'Islam') == 'Islam' ? 'selected' : '' }}>Islam</option>
                                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                                            <option value="Konghucu" {{ old('agama') == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 mb-3">
                                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                                        <select class="form-select" id="status_perkawinan" name="status_perkawinan">
                                            <option value="Belum Kawin" {{ old('status_perkawinan', 'Belum Kawin') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                            <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                            <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                            <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Pendidikan & Pekerjaan -->
                                <div class="row">
                                    <div class="col-12 mb-3 mt-3">
                                        <h6 class="text-primary"><i class="fas fa-graduation-cap me-2"></i>Pendidikan & Pekerjaan</h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="pendidikan" class="form-label">Pendidikan</label>
                                        <select class="form-select" id="pendidikan" name="pendidikan">
                                            <option value="">Pilih Pendidikan</option>
                                            <option value="Tidak/Belum Sekolah" {{ old('pendidikan') == 'Tidak/Belum Sekolah' ? 'selected' : '' }}>Tidak/Belum Sekolah</option>
                                            <option value="Belum Tamat SD/Sederajat" {{ old('pendidikan') == 'Belum Tamat SD/Sederajat' ? 'selected' : '' }}>Belum Tamat SD/Sederajat</option>
                                            <option value="Tamat SD/Sederajat" {{ old('pendidikan') == 'Tamat SD/Sederajat' ? 'selected' : '' }}>Tamat SD/Sederajat</option>
                                            <option value="SLTP/Sederajat" {{ old('pendidikan') == 'SLTP/Sederajat' ? 'selected' : '' }}>SLTP/Sederajat</option>
                                            <option value="SLTA/Sederajat" {{ old('pendidikan') == 'SLTA/Sederajat' ? 'selected' : '' }}>SLTA/Sederajat</option>
                                            <option value="Diploma I/II" {{ old('pendidikan') == 'Diploma I/II' ? 'selected' : '' }}>Diploma I/II</option>
                                            <option value="Akademi/Diploma III/S.Muda" {{ old('pendidikan') == 'Akademi/Diploma III/S.Muda' ? 'selected' : '' }}>Akademi/Diploma III/S.Muda</option>
                                            <option value="Diploma IV/Strata I" {{ old('pendidikan') == 'Diploma IV/Strata I' ? 'selected' : '' }}>Diploma IV/Strata I</option>
                                            <option value="Strata II" {{ old('pendidikan') == 'Strata II' ? 'selected' : '' }}>Strata II</option>
                                            <option value="Strata III" {{ old('pendidikan') == 'Strata III' ? 'selected' : '' }}>Strata III</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan"
                                               placeholder="Masukkan pekerjaan" value="{{ old('pekerjaan') }}">
                                    </div>
                                </div>

                                <!-- Kontak -->
                                <div class="row">
                                    <div class="col-12 mb-3 mt-3">
                                        <h6 class="text-primary"><i class="fas fa-phone me-2"></i>Kontak</h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="telepon" class="form-label">Telepon</label>
                                        <input type="text" class="form-control" id="telepon" name="telepon"
                                               placeholder="Nomor telepon" value="{{ old('telepon') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="email" name="email"
                                               placeholder="Alamat email" value="{{ old('email') }}">
                                    </div>
                                </div>

                                <!-- Keluarga -->
                                <div class="row">
                                    <div class="col-12 mb-3 mt-3">
                                        <h6 class="text-primary"><i class="fas fa-users me-2"></i>Informasi Keluarga</h6>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <label for="nama_ayah" class="form-label">Nama Ayah</label>
                                        <input type="text" class="form-control" id="nama_ayah" name="nama_ayah"
                                               placeholder="Nama ayah" value="{{ old('nama_ayah') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="nama_ibu" class="form-label">Nama Ibu</label>
                                        <input type="text" class="form-control" id="nama_ibu" name="nama_ibu"
                                               placeholder="Nama ibu" value="{{ old('nama_ibu') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="status_hubungan_keluarga" class="form-label">Status Hubungan Keluarga</label>
                                        <select class="form-select" id="status_hubungan_keluarga" name="status_hubungan_keluarga">
                                            <option value="">Pilih Status</option>
                                            <option value="Kepala Keluarga" {{ old('status_hubungan_keluarga') == 'Kepala Keluarga' ? 'selected' : '' }}>Kepala Keluarga</option>
                                            <option value="Istri" {{ old('status_hubungan_keluarga') == 'Istri' ? 'selected' : '' }}>Istri</option>
                                            <option value="Anak" {{ old('status_hubungan_keluarga') == 'Anak' ? 'selected' : '' }}>Anak</option>
                                            <option value="Menantu" {{ old('status_hubungan_keluarga') == 'Menantu' ? 'selected' : '' }}>Menantu</option>
                                            <option value="Cucu" {{ old('status_hubungan_keluarga') == 'Cucu' ? 'selected' : '' }}>Cucu</option>
                                            <option value="Orangtua" {{ old('status_hubungan_keluarga') == 'Orangtua' ? 'selected' : '' }}>Orangtua</option>
                                            <option value="Mertua" {{ old('status_hubungan_keluarga') == 'Mertua' ? 'selected' : '' }}>Mertua</option>
                                            <option value="Famili Lain" {{ old('status_hubungan_keluarga') == 'Famili Lain' ? 'selected' : '' }}>Famili Lain</option>
                                            <option value="Pembantu" {{ old('status_hubungan_keluarga') == 'Pembantu' ? 'selected' : '' }}>Pembantu</option>
                                            <option value="Lainnya" {{ old('status_hubungan_keluarga') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                        </select>
                                    </div>
                                </div>

                                <!-- Additional Info -->
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="golongan_darah" class="form-label">Golongan Darah</label>
                                        <select class="form-select" id="golongan_darah" name="golongan_darah">
                                            <option value="">Pilih Golongan Darah</option>
                                            <option value="A" {{ old('golongan_darah') == 'A' ? 'selected' : '' }}>A</option>
                                            <option value="B" {{ old('golongan_darah') == 'B' ? 'selected' : '' }}>B</option>
                                            <option value="AB" {{ old('golongan_darah') == 'AB' ? 'selected' : '' }}>AB</option>
                                            <option value="O" {{ old('golongan_darah') == 'O' ? 'selected' : '' }}>O</option>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="kewarganegaraan" class="form-label">Kewarganegaraan</label>
                                        <select class="form-select" id="kewarganegaraan" name="kewarganegaraan">
                                            <option value="WNI" {{ old('kewarganegaraan', 'WNI') == 'WNI' ? 'selected' : '' }}>WNI</option>
                                            <option value="WNA" {{ old('kewarganegaraan') == 'WNA' ? 'selected' : '' }}>WNA</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Data Penduduk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Data Penduduk -->
            <div class="modal fade" id="editPendudukModal" tabindex="-1" aria-labelledby="editPendudukModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-dark" id="editPendudukModalLabel">
                                <i class="fas fa-edit me-2"></i>Edit Data Penduduk
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditPenduduk" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body" id="editPendudukContent">
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
                                    <i class="fas fa-save me-1"></i>Update Data Penduduk
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
                            <p class="text-muted">Data penduduk yang dihapus tidak dapat dikembalikan lagi.</p>
                            <div class="alert alert-warning mt-3">
                                <small><i class="fas fa-info-circle me-1"></i>Pastikan data ini sudah tidak diperlukan lagi</small>
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
    <script>
        $(document).ready(function() {
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
            const fadeElements = document.querySelectorAll('.penduduk-fade-in');
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

        // Filter functions
        $('#filterStatus, #filterJenisKelamin, #filterRT, #filterRW').on('change', function() {
            applyFilters();
        });

        function applyFilters() {
            var status = $('#filterStatus').val().toLowerCase();
            var jenisKelamin = $('#filterJenisKelamin').val().toLowerCase();
            var rt = $('#filterRT').val();
            var rw = $('#filterRW').val();

            $('tbody tr').each(function() {
                var row = $(this);
                var showRow = true;

                if (status && !row.find('.status-badge').text().toLowerCase().includes(status)) {
                    showRow = false;
                }

                if (jenisKelamin && !row.find('.jenis-kelamin-badge').text().toLowerCase().includes(jenisKelamin === 'l' ? 'laki' : 'perempuan')) {
                    showRow = false;
                }

                if (rt && !row.text().includes('RT ' + rt)) {
                    showRow = false;
                }

                if (rw && !row.text().includes('RW ' + rw)) {
                    showRow = false;
                }

                row.toggle(showRow);
            });
        }

        // Reset filters
        function resetFilters() {
            $('#searchInput').val('');
            $('#filterStatus').val('');
            $('#filterJenisKelamin').val('');
            $('#filterRT').val('');
            $('#filterRW').val('');
            $('tbody tr').show();
        }

        // Action functions
        function deleteItem(id) {
            $('#deleteForm').attr('action', '/admin/datapenduduk/delete/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Redirect to detail page
            setTimeout(() => {
                window.location.href = '/admin/datapenduduk/show/' + id;
            }, 500);
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Load edit form via AJAX
            $.ajax({
                url: '/admin/datapenduduk/edit/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;

                        // Build edit form content
                        const content = buildEditForm(data);

                        $('#editPendudukContent').html(content);
                        $('#formEditPenduduk').attr('action', '/admin/datapenduduk/update/' + id);
                        $('#editPendudukModal').modal('show');
                    } else {
                        showAlert('error', 'Gagal memuat data penduduk: ' + (response.message || 'Unknown error'));
                    }
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', xhr.responseText);
                    let errorMessage = 'Terjadi kesalahan saat memuat form edit.';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        errorMessage = xhr.responseJSON.message;
                    } else if (xhr.status === 404) {
                        errorMessage = 'Data penduduk tidak ditemukan.';
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
            // Implementation similar to pengumuman edit form
            // Will be a large form with all the same fields as add form but populated with data
            return `
                <!-- Similar form structure as add form but with populated values -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-primary"><i class="fas fa-id-card me-2"></i>Identitas Pribadi</h6>
                        <hr>
                    </div>
                </div>
                <!-- Continue with all form fields populated with data values -->
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
        $('#formTambahPenduduk').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditPenduduk').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahPendudukModal').on('hidden.bs.modal', function() {
            $('#formTambahPenduduk')[0].reset();
            $('#formTambahPenduduk button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Data Penduduk').prop('disabled', false);
        });

        $('#editPendudukModal').on('hidden.bs.modal', function() {
            $('#formEditPenduduk button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Data Penduduk').prop('disabled', false);
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
