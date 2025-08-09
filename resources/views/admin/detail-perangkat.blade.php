<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Perangkat Nagari - {{ $perangkat->nama }}</title>
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

        .breadcrumb-nav {
            background: transparent;
            padding: 0;
            margin-bottom: 1rem;
        }

        .breadcrumb-nav .breadcrumb-item a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb-nav .breadcrumb-item a:hover {
            color: #059669;
        }

        .breadcrumb-nav .breadcrumb-item.active {
            color: #1f2937;
        }

        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 0;
            overflow: hidden;
        }

        .detail-header {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 2rem;
            position: relative;
        }

        .detail-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="10" cy="10" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="30" cy="30" r="1.5" fill="rgba(255,255,255,0.08)"/><circle cx="70" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="1.2" fill="rgba(255,255,255,0.06)"/></svg>');
            opacity: 0.3;
        }

        .detail-header .content {
            position: relative;
            z-index: 1;
        }

        .foto-profile {
            width: 120px;
            height: 120px;
            object-fit: cover;
            border-radius: 1rem;
            border: 4px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
        }

        .no-foto-profile {
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 1rem;
            border: 4px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.8);
            font-size: 2.5rem;
        }

        .detail-body {
            padding: 2rem;
        }

        .info-card {
            background: #f8fafc;
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            border-left: 4px solid #059669;
        }

        .info-label {
            font-size: 0.875rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 0.5rem;
        }

        .info-value {
            font-size: 1rem;
            color: #1f2937;
            font-weight: 500;
        }

        .info-value.empty {
            color: #9ca3af;
            font-style: italic;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .status-aktif {
            background: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .status-nonaktif {
            background: #f3f4f6;
            color: #4b5563;
            border: 1px solid #d1d5db;
        }

        .jabatan-badge {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            color: white;
            padding: 0.5rem 1.25rem;
            border-radius: 2rem;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.3);
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            flex-wrap: wrap;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.3);
            color: white;
        }

        .btn-warning-custom {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
        }

        .btn-warning-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.3);
            color: white;
        }

        .btn-danger-custom {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            color: white;
        }

        .btn-danger-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(239, 68, 68, 0.3);
            color: white;
        }

        .btn-secondary-custom {
            background: #6b7280;
            color: white;
        }

        .btn-secondary-custom:hover {
            background: #4b5563;
            transform: translateY(-2px);
            color: white;
        }

        .detail-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: detailFadeInUp 0.6s ease forwards;
        }

        @keyframes detailFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            background: white;
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
            border: 1px solid #e5e7eb;
        }

        .contact-icon {
            width: 40px;
            height: 40px;
            background: #f3f4f6;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #6b7280;
        }

        .timeline-item {
            position: relative;
            padding-left: 2rem;
            margin-bottom: 1.5rem;
        }

        .timeline-item::before {
            content: '';
            position: absolute;
            left: 0.5rem;
            top: 0;
            bottom: 0;
            width: 2px;
            background: #e5e7eb;
        }

        .timeline-dot {
            position: absolute;
            left: 0;
            top: 0.25rem;
            width: 1rem;
            height: 1rem;
            background: #059669;
            border-radius: 50%;
            border: 3px solid white;
            box-shadow: 0 0 0 3px #e5e7eb;
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

        @keyframes pulse {
            0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); }
            70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); }
            100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
        }

        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav detail-fade-in">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.perangkat') }}">
                            <i class="fas fa-users me-1"></i>Perangkat Nagari
                        </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $perangkat->nama }}</li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="page-header mb-6 detail-fade-in" style="animation-delay: 0.1s;">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Detail Perangkat Nagari</h1>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show detail-fade-in" role="alert" style="animation-delay: 0.2s;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show detail-fade-in" role="alert" style="animation-delay: 0.2s;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Main Content -->
            <div class="content-card detail-fade-in" style="animation-delay: 0.3s;">
                <!-- Header Section -->
                <div class="detail-header">
                    <div class="content">
                        <div class="row align-items-center">
                            <div class="col-md-3 text-center mb-3 mb-md-0">
                                @if($perangkat->foto_filename)
                                    <img src="{{ $perangkat->foto_url }}" alt="{{ $perangkat->nama }}" class="foto-profile">
                                @else
                                    <div class="no-foto-profile">
                                        <i class="fas fa-user"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="col-md-6">
                                <h2 class="h3 mb-2 fw-bold">{{ $perangkat->nama }}</h2>
                                <div class="jabatan-badge mb-3">{{ $perangkat->jabatan }}</div>
                                <div class="status-badge status-{{ $perangkat->status }}">
                                    <i class="fas fa-circle me-2"></i>{{ ucfirst($perangkat->status) }}
                                </div>
                            </div>
                            <div class="col-md-3 text-center text-md-end">
                                @if($perangkat->urutan)
                                    <div class="text-white opacity-75 small">Urutan</div>
                                    <div class="h2 mb-0 fw-bold">{{ $perangkat->urutan }}</div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Body Section -->
                <div class="detail-body">
                    <div class="row">
                        <!-- Informasi Pribadi -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5 class="mb-3 fw-bold text-success">
                                    <i class="fas fa-user me-2"></i>Informasi Pribadi
                                </h5>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="info-label">Nama Lengkap</div>
                                        <div class="info-value">{{ $perangkat->nama }}</div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="info-label">NIP</div>
                                        <div class="info-value {{ !$perangkat->nip ? 'empty' : '' }}">
                                            {{ $perangkat->nip ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="info-label">Pendidikan Terakhir</div>
                                        <div class="info-value {{ !$perangkat->pendidikan ? 'empty' : '' }}">
                                            {{ $perangkat->pendidikan ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="info-label">Alamat</div>
                                        <div class="info-value {{ !$perangkat->alamat ? 'empty' : '' }}">
                                            {{ $perangkat->alamat ?? 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Kontak -->
                            <div class="info-card">
                                <h5 class="mb-3 fw-bold text-success">
                                    <i class="fas fa-address-book me-2"></i>Informasi Kontak
                                </h5>
                                @if($perangkat->telepon)
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-phone"></i>
                                        </div>
                                        <div>
                                            <div class="info-label mb-1">Telepon</div>
                                            <div class="info-value">
                                                <a href="tel:{{ $perangkat->telepon }}" class="text-decoration-none">
                                                    {{ $perangkat->telepon }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($perangkat->email)
                                    <div class="contact-item">
                                        <div class="contact-icon">
                                            <i class="fas fa-envelope"></i>
                                        </div>
                                        <div>
                                            <div class="info-label mb-1">Email</div>
                                            <div class="info-value">
                                                <a href="mailto:{{ $perangkat->email }}" class="text-decoration-none">
                                                    {{ $perangkat->email }}
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if(!$perangkat->telepon && !$perangkat->email)
                                    <div class="text-center py-3">
                                        <i class="fas fa-address-book fa-2x text-muted mb-2"></i>
                                        <p class="text-muted mb-0">Informasi kontak tidak tersedia</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Informasi Jabatan -->
                        <div class="col-md-6">
                            <div class="info-card">
                                <h5 class="mb-3 fw-bold text-success">
                                    <i class="fas fa-briefcase me-2"></i>Informasi Jabatan
                                </h5>
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <div class="info-label">Jabatan</div>
                                        <div class="info-value">{{ $perangkat->jabatan }}</div>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <div class="info-label">Status</div>
                                        <div class="info-value">
                                            <span class="status-badge status-{{ $perangkat->status }}">
                                                <i class="fas fa-circle me-2"></i>{{ ucfirst($perangkat->status) }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="info-label">Masa Jabatan Mulai</div>
                                        <div class="info-value {{ !$perangkat->masa_jabatan_mulai ? 'empty' : '' }}">
                                            {{ $perangkat->masa_jabatan_mulai ? $perangkat->masa_jabatan_mulai->format('d F Y') : 'Tidak tersedia' }}
                                        </div>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="info-label">Masa Jabatan Selesai</div>
                                        <div class="info-value {{ !$perangkat->masa_jabatan_selesai ? 'empty' : '' }}">
                                            {{ $perangkat->masa_jabatan_selesai ? $perangkat->masa_jabatan_selesai->format('d F Y') : 'Hingga sekarang' }}
                                        </div>
                                    </div>
                                    @if($perangkat->masa_jabatan_mulai && $perangkat->masa_jabatan_selesai)
                                        <div class="col-12">
                                            <div class="info-label">Lama Jabatan</div>
                                            <div class="info-value">
                                                {{ $perangkat->masa_jabatan_mulai->diffForHumans($perangkat->masa_jabatan_selesai, true) }}
                                            </div>
                                        </div>
                                    @elseif($perangkat->masa_jabatan_mulai)
                                        <div class="col-12">
                                            <div class="info-label">Lama Menjabat</div>
                                            <div class="info-value">
                                                {{ $perangkat->masa_jabatan_mulai->diffForHumans(null, true) }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Timeline Jabatan -->
                            @if($perangkat->masa_jabatan_mulai)
                                <div class="info-card">
                                    <h5 class="mb-3 fw-bold text-success">
                                        <i class="fas fa-history me-2"></i>Timeline Jabatan
                                    </h5>
                                    <div class="timeline-item">
                                        <div class="timeline-dot"></div>
                                        <div>
                                            <div class="fw-bold">Mulai Menjabat</div>
                                            <div class="text-muted small">{{ $perangkat->masa_jabatan_mulai->format('d F Y') }}</div>
                                            <div class="text-success small">{{ $perangkat->masa_jabatan_mulai->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    @if($perangkat->masa_jabatan_selesai)
                                        <div class="timeline-item">
                                            <div class="timeline-dot" style="background: #ef4444;"></div>
                                            <div>
                                                <div class="fw-bold">Selesai Menjabat</div>
                                                <div class="text-muted small">{{ $perangkat->masa_jabatan_selesai->format('d F Y') }}</div>
                                                <div class="text-danger small">{{ $perangkat->masa_jabatan_selesai->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="timeline-item">
                                            <div class="timeline-dot pulse" style="background: #10b981;"></div>
                                            <div>
                                                <div class="fw-bold text-success">Masih Aktif Menjabat</div>
                                                <div class="text-muted small">Hingga sekarang</div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            <!-- Metadata -->
                            <div class="info-card">
                                <h5 class="mb-3 fw-bold text-success">
                                    <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                                </h5>
                                <div class="row">
                                    <div class="col-6 mb-3">
                                        <div class="info-label">Dibuat</div>
                                        <div class="info-value">{{ $perangkat->created_at->format('d F Y') }}</div>
                                        <small class="text-muted">{{ $perangkat->created_at->diffForHumans() }}</small>
                                    </div>
                                    <div class="col-6 mb-3">
                                        <div class="info-label">Diperbarui</div>
                                        <div class="info-value">{{ $perangkat->updated_at->format('d F Y') }}</div>
                                        <small class="text-muted">{{ $perangkat->updated_at->diffForHumans() }}</small>
                                    </div>
                                    @if($perangkat->urutan)
                                        <div class="col-12">
                                            <div class="info-label">Urutan Tampilan</div>
                                            <div class="info-value">{{ $perangkat->urutan }}</div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="info-card">
                        <h5 class="mb-3 fw-bold text-success">
                            <i class="fas fa-cogs me-2"></i>Aksi
                        </h5>
                        <div class="action-buttons">
                            <a href="{{ route('admin.perangkat') }}" class="btn-action btn-secondary-custom">
                                <i class="fas fa-arrow-left"></i>Kembali ke Daftar
                            </a>
                            <button class="btn-action btn-primary-custom" onclick="editData({{ $perangkat->id }})">
                                <i class="fas fa-edit"></i>Edit Data
                            </button>
                            <button class="btn-action btn-warning-custom" onclick="updateStatus({{ $perangkat->id }}, '{{ $perangkat->status === 'aktif' ? 'nonaktif' : 'aktif' }}')">
                                <i class="fas fa-toggle-{{ $perangkat->status === 'aktif' ? 'off' : 'on' }}"></i>
                                {{ $perangkat->status === 'aktif' ? 'Nonaktifkan' : 'Aktifkan' }}
                            </button>
                            <button class="btn-action btn-danger-custom" onclick="deleteData({{ $perangkat->id }})">
                                <i class="fas fa-trash"></i>Hapus Data
                            </button>
                        </div>
                    </div>
                </div>
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
                    <input type="hidden" name="from_detail" value="1">
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
                    <p class="text-muted">Data perangkat <strong>{{ $perangkat->nama }}</strong> akan dihapus permanen dan tidak dapat dikembalikan lagi.</p>
                    <div class="alert alert-warning mt-3">
                        <small><i class="fas fa-info-circle me-1"></i>Pastikan data ini sudah tidak digunakan lagi</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Batal
                    </button>
                    <form id="deleteForm" method="POST" style="display: inline;" action="{{ route('admin.perangkat.delete', $perangkat->id) }}">
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
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Edit data function
        function editData(id) {
            $.ajax({
                url: '{{ url("admin/perangkat/edit") }}/' + id,
                method: 'GET',
                beforeSend: function() {
                    $('#editPerangkatContent').html(`
                        <div class="text-center">
                            <div class="loading"></div>
                            <p class="mt-2">Memuat form edit...</p>
                        </div>
                    `);
                    $('#editPerangkatModal').modal('show');
                },
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
                    } else {
                        alert('Data perangkat tidak ditemukan.');
                        $('#editPerangkatModal').modal('hide');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat form edit.');
                    $('#editPerangkatModal').modal('hide');
                }
            });
        }

        // Update status function
        function updateStatus(id, newStatus) {
            const statusText = newStatus === 'aktif' ? 'aktifkan' : 'nonaktifkan';

            if (confirm(`Apakah Anda yakin ingin ${statusText} perangkat ini?`)) {
                $.ajax({
                    url: '{{ url("admin/perangkat") }}/' + id + '/status',
                    method: 'PATCH',
                    data: { status: newStatus },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert(response.message || 'Gagal memperbarui status.');
                        }
                    },
                    error: function() {
                        alert('Terjadi kesalahan saat memperbarui status.');
                    }
                });
            }
        }

        // Delete data function
        function deleteData(id) {
            $('#deleteModal').modal('show');
        }

        // Form submission handlers
        $('#formEditPerangkat').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset form when modal is hidden
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
