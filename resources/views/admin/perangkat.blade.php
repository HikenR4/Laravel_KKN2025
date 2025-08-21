<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Perangkat Nagari - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
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

        .btn-tambah-perangkat {
            background: #059669;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            border: none;
            transition: all 0.3s ease;
        }

        .btn-tambah-perangkat:hover {
            background: #047857;
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
            font-size: 0.875rem;
            text-transform: uppercase;
        }

        .foto-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
            border: 2px solid #e5e7eb;
        }

        .no-foto {
            width: 60px;
            height: 60px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            color: #6b7280;
            border: 2px solid #e5e7eb;
        }

        .nama-section {
            font-weight: 600;
            color: #1f2937;
        }

        .jabatan-badge {
            background: #059669;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.75rem;
            font-weight: 600;
        }

        .contact-info {
            font-size: 0.875rem;
            color: #6b7280;
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

        .status-nonaktif {
            background: #6b7280;
            color: white;
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
            border: none;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-view:hover {
            background: #10b981;
            color: white;
        }

        .btn-edit:hover {
            background: #3b82f6;
            color: white;
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .bulk-actions-card {
            background: #fef3c7;
            border: 1px solid #f59e0b;
            border-radius: 0.75rem;
            padding: 1rem;
            margin-bottom: 1rem;
            display: none;
        }

        .modal-content {
            border-radius: 1rem;
            border: none;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
        }

        .modal-header {
            border-bottom: none;
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: none;
            padding: 1rem 1.5rem;
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

        .perangkat-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: perangkatFadeInUp 0.6s ease forwards;
        }

        @keyframes perangkatFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-control, .form-select {
            border-radius: 0.5rem;
            border: 1px solid #d1d5db;
            transition: all 0.2s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .alert {
            border-radius: 0.75rem;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
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

        .custom-table {
            table-layout: fixed !important;
            width: 100% !important;
            min-width: 100% !important; /* Hapus min-width yang membuat scroll */
        }

        /* Sesuaikan lebar kolom agar pas tanpa scroll */
        .custom-table th:nth-child(1), .custom-table td:nth-child(1) { width: 4% !important; } /* Checkbox lebih kecil */
        .custom-table th:nth-child(2), .custom-table td:nth-child(2) { width: 6% !important; } /* Foto lebih kecil */
        .custom-table th:nth-child(3), .custom-table td:nth-child(3) { width: 25% !important; } /* Nama & Jabatan */
        .custom-table th:nth-child(4), .custom-table td:nth-child(4) { width: 15% !important; } /* NIP */
        .custom-table th:nth-child(5), .custom-table td:nth-child(5) { width: 22% !important; } /* Kontak lebih lebar */
        .custom-table th:nth-child(6), .custom-table td:nth-child(6) { width: 12% !important; } /* Masa Jabatan lebih kecil */
        .custom-table th:nth-child(7), .custom-table td:nth-child(7) { width: 8% !important; } /* Status */
        .custom-table th:nth-child(8), .custom-table td:nth-child(8) { width: 8% !important; } /* Aksi lebih lebar */

        /* Perbaiki action buttons agar muat */
        .action-buttons {
            display: flex !important;
            gap: 0.25rem !important;
            flex-wrap: nowrap !important; /* Jangan wrap */
            justify-content: center !important;
        }

        .action-btn {
            background: #f3f4f6 !important;
            color: #374151 !important;
            padding: 0.4rem !important; /* Lebih kecil */
            border-radius: 0.4rem !important;
            border: none !important;
            transition: all 0.3s ease !important;
            min-width: 32px !important; /* Minimum width */
            height: 32px !important; /* Fixed height */
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .action-btn i {
            font-size: 0.75rem !important; /* Icon lebih kecil */
        }

        /* Foto thumb lebih kecil */
        .foto-thumb, .no-foto {
            width: 45px !important;
            height: 45px !important;
        }

        /* Text lebih kecil untuk menghemat ruang */
        .custom-table td, .custom-table th {
            font-size: 0.8rem !important;
            padding: 0.6rem 0.4rem !important;
        }

        .nama-section {
            font-size: 0.85rem !important;
            line-height: 1.2 !important;
        }

        .jabatan-badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.5rem !important;
        }

        .contact-info {
            font-size: 0.75rem !important;
        }

        .status-badge {
            font-size: 0.65rem !important;
            padding: 0.2rem 0.5rem !important;
        }

        /* Responsive untuk layar kecil */
        @media (max-width: 1200px) {
            .custom-table th:nth-child(5), .custom-table td:nth-child(5) {
                width: 20% !important;
            }
            
            .action-buttons {
                flex-direction: column !important;
                gap: 0.15rem !important;
            }
            
            .action-btn {
                width: 28px !important;
                height: 28px !important;
                padding: 0.3rem !important;
            }
            
            .action-btn i {
                font-size: 0.7rem !important;
            }
        }

        @media (max-width: 992px) {
            .custom-table th:nth-child(3), .custom-table td:nth-child(3) { width: 20% !important; }
            .custom-table th:nth-child(5), .custom-table td:nth-child(5) { width: 18% !important; }
            .custom-table th:nth-child(6), .custom-table td:nth-child(6) { width: 10% !important; }
        }

        /* Hilangkan scroll horizontal sama sekali */
        .table-container {
            overflow-x: hidden !important;
            width: 100% !important;
        }

        /* Pastikan container tidak overflow */
        .content-card {
            overflow-x: hidden !important;
        }

        .alamat-wrap-fix {
            word-wrap: break-word !important;
            word-break: break-word !important;
            white-space: normal !important;
            line-height: 1.3 !important;
            max-width: 100% !important;
        }

        .nip-wrap-fix {
            word-wrap: break-word !important;
            word-break: break-all !important;
            font-family: monospace !important;
            font-size: 0.875rem !important;
        }

        .email-wrap-fix {
            word-wrap: break-word !important;
            word-break: break-all !important;
            font-size: 0.875rem !important;
        }

        /* Mobile responsive */
        @media (max-width: 768px) {
            .custom-table th:nth-child(5), .custom-table td:nth-child(5) {
                max-width: 150px !important;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 perangkat-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Perangkat Nagari</h1>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show perangkat-fade-in" role="alert" style="animation-delay: 0.1s;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show perangkat-fade-in" role="alert" style="animation-delay: 0.1s;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger alert-dismissible fade show perangkat-fade-in" role="alert">
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

            <!-- Bulk Actions -->
            <div class="bulk-actions-card" id="bulkActions">
                <div class="d-flex align-items-center justify-content-between">
                    <div>
                        <i class="fas fa-check-circle text-warning me-2"></i>
                        <span class="fw-bold"><span id="selectedCount">0</span> perangkat dipilih</span>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="bulkDelete()">
                        <i class="fas fa-trash me-1"></i>Hapus Terpilih
                    </button>
                </div>
            </div>

            <!-- Main Content Card -->
            <div class="content-card perangkat-fade-in" style="animation-delay: 0.2s;">
                <!-- Card Header -->
                <div class="card-header-custom">
                    <h2 class="card-title-custom">Data Perangkat Nagari</h2>
                    <button class="btn-tambah-perangkat" data-bs-toggle="modal" data-bs-target="#tambahPerangkatModal">
                        <i class="fas fa-plus me-2"></i>Tambah Perangkat
                    </button>
                </div>

                <!-- Search & Filter Section -->
                <div class="search-filter-section">
                    <div class="row">
                        <div class="col-md-4 mb-3 mb-md-0">
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-search text-muted"></i>
                                </span>
                                <input type="text" class="form-control border-start-0" id="searchInput" name="search"
                                       placeholder="Cari nama, jabatan, atau NIP..." value="{{ request('search') }}">
                            </div>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <select class="form-select" id="filterStatus" name="status">
                                <option value="">Semua Status</option>
                                <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                            </select>
                        </div>
                        <div class="col-md-3 mb-3 mb-md-0">
                            <input type="text" class="form-control" id="filterJabatan" name="jabatan"
                                   placeholder="Filter jabatan..." value="{{ request('jabatan') }}">
                        </div>
                        <div class="col-md-2">
                            <button type="button" class="btn btn-outline-secondary w-100" onclick="resetFilter()">
                                <i class="fas fa-redo me-1"></i>Reset
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Table Section -->
                <div class="table-container">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th style="width: 5%">
                                    <input type="checkbox" id="selectAll" class="form-check-input">
                                </th>
                                <th style="width: 10%">Foto</th>
                                <th style="width: 25%">Nama & Jabatan</th>
                                <th style="width: 15%">NIP</th>
                                <th style="width: 15%">Kontak</th>
                                <th style="width: 15%">Masa Jabatan</th>
                                <th style="width: 8%">Status</th>
                                <th style="width: 7%">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($perangkats as $index => $perangkat)
                                <tr class="perangkat-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <input type="checkbox" class="form-check-input item-checkbox" value="{{ $perangkat->id }}">
                                    </td>
                                    <td>
                                        @if($perangkat->foto_filename)
                                            <img src="{{ $perangkat->foto_url }}" alt="{{ $perangkat->nama }}" class="foto-thumb">
                                        @else
                                            <div class="no-foto">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="nama-section">{{ $perangkat->nama }}</div>
                                        <div class="jabatan-badge">{{ $perangkat->jabatan }}</div>
                                        @if($perangkat->email)
                                            <div class="contact-info email-wrap-fix">
                                                <i class="fas fa-envelope me-1"></i>{{ $perangkat->email }}
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        @if($perangkat->nip)
                                            <div class="mb-1 nip-wrap-fix">{{ $perangkat->nip }}</div>
                                        @else
                                            <div class="mb-1">-</div>
                                        @endif
                                        @if($perangkat->pendidikan)
                                            <small class="text-muted">{{ $perangkat->pendidikan }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($perangkat->telepon)
                                            <div class="contact-info mb-1">
                                                <i class="fas fa-phone me-1"></i>
                                                <span>{{ $perangkat->telepon }}</span>
                                            </div>
                                        @endif
                                        @if($perangkat->alamat)
                                            <small class="text-muted alamat-wrap-fix">{{ $perangkat->alamat }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="mb-1">
                                            {{ $perangkat->masa_jabatan_mulai ? $perangkat->masa_jabatan_mulai->format('Y') : '-' }}
                                            -
                                            {{ $perangkat->masa_jabatan_selesai ? $perangkat->masa_jabatan_selesai->format('Y') : 'Sekarang' }}
                                        </div>
                                        @if($perangkat->urutan)
                                            <small class="text-muted">Urutan: {{ $perangkat->urutan }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $perangkat->status }}">{{ ucfirst($perangkat->status) }}</span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-view" onclick="showDetail({{ $perangkat->id }})"
                                                    title="Lihat Detail" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button class="action-btn btn-edit" onclick="editData({{ $perangkat->id }})"
                                                    title="Edit" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn btn-delete" onclick="deleteData({{ $perangkat->id }})"
                                                    title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center py-4">
                                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada perangkat yang ditambahkan</p>
                                        <button class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#tambahPerangkatModal">
                                            <i class="fas fa-plus me-1"></i>Tambah Perangkat Pertama
                                        </button>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Pagination Section -->
                @if($perangkats->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $perangkats->firstItem() }} - {{ $perangkats->lastItem() }}
                                    dari {{ $perangkats->total() }} perangkat
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $perangkats->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Tambah Perangkat -->
    <div class="modal fade" id="tambahPerangkatModal" tabindex="-1" aria-labelledby="tambahPerangkatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title text-white" id="tambahPerangkatModalLabel">
                        <i class="fas fa-plus-circle me-2"></i>Tambah Perangkat
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formTambahPerangkat" action="{{ route('admin.perangkat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nama" name="nama" required
                                       value="{{ old('nama') }}" placeholder="Masukkan nama lengkap">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="jabatan" name="jabatan" required
                                       value="{{ old('jabatan') }}" placeholder="Masukkan jabatan">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nip" class="form-label">NIP</label>
                                <input type="text" class="form-control" id="nip" name="nip"
                                       value="{{ old('nip') }}" placeholder="Masukkan NIP">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="foto" class="form-label">Foto</label>
                                <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                       value="{{ old('telepon') }}" placeholder="Masukkan nomor telepon">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email"
                                       value="{{ old('email') }}" placeholder="Masukkan email">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="2"
                                      placeholder="Masukkan alamat">{{ old('alamat') }}</textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pendidikan" class="form-label">Pendidikan</label>
                                <input type="text" class="form-control" id="pendidikan" name="pendidikan"
                                       value="{{ old('pendidikan') }}" placeholder="Masukkan pendidikan terakhir">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="aktif" {{ old('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                    <option value="nonaktif" {{ old('status') == 'nonaktif' ? 'selected' : '' }}>Non Aktif</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="masa_jabatan_mulai" class="form-label">Masa Jabatan Mulai</label>
                                <input type="date" class="form-control" id="masa_jabatan_mulai" name="masa_jabatan_mulai"
                                       value="{{ old('masa_jabatan_mulai') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="masa_jabatan_selesai" class="form-label">Masa Jabatan Selesai</label>
                                <input type="date" class="form-control" id="masa_jabatan_selesai" name="masa_jabatan_selesai"
                                       value="{{ old('masa_jabatan_selesai') }}">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="urutan" class="form-label">Urutan</label>
                            <input type="number" class="form-control" id="urutan" name="urutan"
                                   value="{{ old('urutan') }}" placeholder="Masukkan urutan tampilan">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-1"></i>Batal
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-1"></i>Simpan Perangkat
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Perangkat -->
    <div class="modal fade" id="editPerangkatModal" tabindex="-1" aria-labelledby="editPerangkatModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning">
                    <h5 class="modal-title text-dark" id="editPerangkatModalLabel">
                        <i class="fas fa-edit me-2"></i>Edit Perangkat
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="formEditPerangkat" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body" id="editPerangkatContent">
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
                            <i class="fas fa-save me-1"></i>Update Perangkat
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
                    <p class="text-muted">Data perangkat yang dihapus tidak dapat dikembalikan lagi.</p>
                    <div class="alert alert-warning mt-3">
                        <small><i class="fas fa-info-circle me-1"></i>Pastikan data ini sudah tidak digunakan lagi</small>
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
            const fadeElements = document.querySelectorAll('.perangkat-fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });

            // Select all checkbox
            $('#selectAll').on('click', function() {
                $('.item-checkbox').prop('checked', this.checked);
                updateBulkActions();
            });

            $('.item-checkbox').on('change', updateBulkActions);

            // Search and filter functionality
            $('#searchInput, #filterStatus, #filterJabatan').on('change keyup', function() {
                const search = $('#searchInput').val().toLowerCase();
                const status = $('#filterStatus').val().toLowerCase();
                const jabatan = $('#filterJabatan').val().toLowerCase();

                $('tbody tr').each(function() {
                    const row = $(this);
                    const nama = row.find('.nama-section').text().toLowerCase();
                    const jabatanText = row.find('.jabatan-badge').text().toLowerCase();
                    const nip = row.find('td:nth-child(4) .mb-1').text().toLowerCase();
                    const rowStatus = row.find('.status-badge').text().toLowerCase();

                    const matchSearch = !search || nama.includes(search) || jabatanText.includes(search) || nip.includes(search);
                    const matchStatus = !status || rowStatus === status;
                    const matchJabatan = !jabatan || jabatanText.includes(jabatan);

                    row.toggle(matchSearch && matchStatus && matchJabatan);
                });
            });
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Update bulk actions visibility and count
        function updateBulkActions() {
            const selectedCount = $('.item-checkbox:checked').length;
            $('#selectedCount').text(selectedCount);
            $('#bulkActions').toggle(selectedCount > 0);
        }

        // Reset filter
        function resetFilter() {
            $('#searchInput').val('');
            $('#filterStatus').val('');
            $('#filterJabatan').val('');
            $('tbody tr').show();
        }

        // Show detail - redirect ke halaman detail
        function showDetail(id) {
            window.location.href = '{{ url("admin/perangkat/detail") }}/' + id;
        }

        // Edit data
        function editData(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.ajax({
                url: '{{ url("admin/perangkat/edit") }}/' + id,
                method: 'GET',
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        const content = `
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_nama" name="nama" required value="${data.nama}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_jabatan" class="form-label">Jabatan <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_jabatan" name="jabatan" required value="${data.jabatan}">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_nip" class="form-label">NIP</label>
                                    <input type="text" class="form-control" id="edit_nip" name="nip" value="${data.nip || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_foto" class="form-label">Foto</label>
                                    <input type="file" class="form-control" id="edit_foto" name="foto" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah foto</small>
                                    ${data.foto ? `<div class="mt-2"><img src="${data.foto}" alt="Current" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 0.25rem;"></div>` : ''}
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_telepon" class="form-label">Telepon</label>
                                    <input type="text" class="form-control" id="edit_telepon" name="telepon" value="${data.telepon || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="edit_email" name="email" value="${data.email || ''}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_alamat" class="form-label">Alamat</label>
                                <textarea class="form-control" id="edit_alamat" name="alamat" rows="2">${data.alamat || ''}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_pendidikan" class="form-label">Pendidikan</label>
                                    <input type="text" class="form-control" id="edit_pendidikan" name="pendidikan" value="${data.pendidikan || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="aktif" ${data.status === 'aktif' ? 'selected' : ''}>Aktif</option>
                                        <option value="nonaktif" ${data.status === 'nonaktif' ? 'selected' : ''}>Non Aktif</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_masa_jabatan_mulai" class="form-label">Masa Jabatan Mulai</label>
                                    <input type="date" class="form-control" id="edit_masa_jabatan_mulai" name="masa_jabatan_mulai" value="${data.masa_jabatan_mulai || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_masa_jabatan_selesai" class="form-label">Masa Jabatan Selesai</label>
                                    <input type="date" class="form-control" id="edit_masa_jabatan_selesai" name="masa_jabatan_selesai" value="${data.masa_jabatan_selesai || ''}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_urutan" class="form-label">Urutan</label>
                                <input type="number" class="form-control" id="edit_urutan" name="urutan" value="${data.urutan || ''}">
                            </div>
                        `;
                        $('#editPerangkatContent').html(content);
                        $('#formEditPerangkat').attr('action', '{{ url("admin/perangkat/update") }}/' + id);
                        $('#editPerangkatModal').modal('show');
                    } else {
                        alert('Data perangkat tidak ditemukan.');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat form edit.');
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        // Delete data
        function deleteData(id) {
            $('#deleteForm').attr('action', '{{ url("admin/perangkat/delete") }}/' + id);
            $('#deleteModal').modal('show');
        }

        // Bulk delete
        function bulkDelete() {
            const ids = $('.item-checkbox:checked').map(function() {
                return $(this).val();
            }).get();

            if (ids.length === 0) {
                alert('Pilih setidaknya satu perangkat untuk dihapus.');
                return;
            }

            if (confirm('Apakah Anda yakin ingin menghapus ' + ids.length + ' perangkat?')) {
                $.ajax({
                    url: '{{ route("admin.perangkat.bulk-delete") }}',
                    method: 'POST',
                    data: { ids: ids },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat menghapus data.');
                    }
                });
            }
        }

        // Form submission handlers
        $('#formTambahPerangkat').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditPerangkat').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahPerangkatModal').on('hidden.bs.modal', function() {
            $('#formTambahPerangkat')[0].reset();
            $('#formTambahPerangkat button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Perangkat').prop('disabled', false);
        });

        $('#editPerangkatModal').on('hidden.bs.modal', function() {
            $('#formEditPerangkat button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Perangkat').prop('disabled', false);
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
