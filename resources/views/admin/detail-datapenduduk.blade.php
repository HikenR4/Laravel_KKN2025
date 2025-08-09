<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Data Penduduk - {{ $penduduk->nama }} - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Detail Data Penduduk */
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

        .content-card {
            background: #ffffff;
            border-radius: 1rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }

        .penduduk-header {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: white;
            border-radius: 1rem 1rem 0 0;
            padding: 2rem 1.5rem;
            margin: -1.5rem -1.5rem 1.5rem -1.5rem;
            position: relative;
            overflow: hidden;
        }

        .penduduk-header::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            transform: translate(30px, -30px);
        }

        .penduduk-avatar {
            width: 5rem;
            height: 5rem;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1rem;
            position: relative;
            z-index: 1;
        }

        .penduduk-title {
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            line-height: 1.2;
            position: relative;
            z-index: 1;
        }

        .penduduk-meta {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            opacity: 0.9;
            position: relative;
            z-index: 1;
        }

        .info-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .info-table td {
            padding: 0.75rem 0;
            border-bottom: 1px solid #f3f4f6;
        }

        .info-table td:first-child {
            color: #6b7280;
            font-weight: 500;
            width: 35%;
        }

        .info-table td:nth-child(2) {
            width: 5%;
            text-align: center;
            color: #6b7280;
        }

        .info-table td:last-child {
            font-weight: 600;
            color: #1f2937;
        }

        .btn-group-custom {
            display: flex;
            gap: 0.5rem;
            flex-wrap: wrap;
        }

        .btn-group-custom .btn {
            padding: 0.75rem 1.5rem;
            border-radius: 0.75rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .btn-back {
            background: #6b7280;
            color: white;
            border: none;
        }

        .btn-back:hover {
            background: #4b5563;
            color: white;
            transform: translateY(-2px);
        }

        .btn-edit {
            background: #f59e0b;
            color: white;
            border: none;
        }

        .btn-edit:hover {
            background: #d97706;
            color: white;
            transform: translateY(-2px);
        }

        .btn-print {
            background: #10b981;
            color: white;
            border: none;
        }

        .btn-print:hover {
            background: #059669;
            color: white;
            transform: translateY(-2px);
        }

        .btn-delete {
            background: #ef4444;
            color: white;
            border: none;
        }

        .btn-delete:hover {
            background: #dc2626;
            color: white;
            transform: translateY(-2px);
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 0.75rem;
            font-size: 0.875rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .status-aktif {
            background: #d1fae5;
            color: #065f46;
        }

        .status-tidak-aktif {
            background: #fee2e2;
            color: #991b1b;
        }

        .jenis-kelamin-badge {
            padding: 0.375rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .jk-pria { background: #dbeafe; color: #1e40af; }
        .jk-wanita { background: #fce7f3; color: #be185d; }

        .card-header-custom {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-bottom: 1.5rem;
        }

        .section-icon {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: white;
        }

        .icon-identity { background: #3b82f6; }
        .icon-address { background: #f59e0b; }
        .icon-family { background: #10b981; }
        .icon-contact { background: #8b5cf6; }
        .icon-additional { background: #ef4444; }

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

        .highlight-data {
            background: #f0f9ff;
            border-left: 4px solid #3b82f6;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
        }

        .stats-card {
            background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
            color: white;
            border-radius: 0.75rem;
            padding: 1rem;
            text-align: center;
            margin-bottom: 1rem;
        }

        .stat-number {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 0.25rem;
        }

        .stat-label {
            font-size: 0.875rem;
            opacity: 0.9;
        }

        .empty-data {
            color: #9ca3af;
            font-style: italic;
        }

        .print-area {
            display: none;
        }

        @media print {
            body * {
                visibility: hidden;
            }
            .print-area, .print-area * {
                visibility: visible;
            }
            .print-area {
                position: absolute;
                left: 0;
                top: 0;
                display: block !important;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 detail-fade-in">
                <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Detail Data Penduduk</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.datapenduduk') }}">Data Penduduk</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </nav>
            </div>

            <!-- Flash Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show detail-fade-in" role="alert" style="animation-delay: 0.1s;">
                    <i class="fas fa-check-circle me-2"></i>
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show detail-fade-in" role="alert" style="animation-delay: 0.1s;">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Action Buttons -->
            <div class="content-card detail-fade-in no-print" style="animation-delay: 0.2s;">
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div>
                        <h5 class="mb-1">{{ $penduduk->nama }}</h5>
                        <p class="text-muted mb-0">
                            <i class="fas fa-id-card me-2"></i>NIK: {{ $penduduk->nik }}
                        </p>
                        <small class="text-muted">
                            Terakhir diperbarui: {{ $penduduk->updated_at->format('d M Y, H:i') }} WIB
                        </small>
                    </div>
                    <div class="btn-group-custom">
                        <a href="{{ route('admin.datapenduduk') }}" class="btn btn-back">
                            <i class="fas fa-arrow-left me-2"></i>Kembali
                        </a>
                        <button type="button" class="btn btn-edit" onclick="editPenduduk({{ $penduduk->id }})">
                            <i class="fas fa-edit me-2"></i>Edit
                        </button>
                        <button type="button" class="btn btn-print" onclick="printData()">
                            <i class="fas fa-print me-2"></i>Cetak
                        </button>
                        <form method="POST" action="{{ route('admin.datapenduduk.delete', $penduduk->id) }}" 
                              class="d-inline" onsubmit="return confirmDelete()">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-delete">
                                <i class="fas fa-trash me-2"></i>Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="row">
                <!-- Konten Utama -->
                <div class="col-lg-8">
                    <!-- Header Penduduk -->
                    <div class="content-card detail-fade-in" style="animation-delay: 0.3s;">
                        <div class="penduduk-header">
                            <div class="penduduk-avatar">
                                <i class="fas fa-{{ $penduduk->jenis_kelamin === 'L' ? 'male' : 'female' }}"></i>
                            </div>
                            <div class="penduduk-title">{{ $penduduk->nama }}</div>
                            <div class="penduduk-meta">
                                <div class="meta-item">
                                    <i class="fas fa-id-card"></i>
                                    <span>{{ $penduduk->nik }}</span>
                                </div>
                                @if($penduduk->no_kk)
                                <div class="meta-item">
                                    <i class="fas fa-users"></i>
                                    <span>KK: {{ $penduduk->no_kk }}</span>
                                </div>
                                @endif
                                <div class="meta-item">
                                    <i class="fas fa-birthday-cake"></i>
                                    <span>{{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age : 0 }} tahun</span>
                                </div>
                            </div>
                        </div>

                        <!-- Status dan Gender -->
                        <div class="d-flex gap-3 align-items-center mb-3">
                            <span class="status-badge status-{{ $penduduk->status == 'aktif' ? 'aktif' : 'tidak-aktif' }}">
                                <i class="fas fa-{{ $penduduk->status == 'aktif' ? 'check-circle' : 'times-circle' }}"></i>
                                {{ ucfirst($penduduk->status) }}
                            </span>
                            <span class="jenis-kelamin-badge {{ $penduduk->jenis_kelamin === 'L' ? 'jk-pria' : 'jk-wanita' }}">
                                <i class="fas fa-{{ $penduduk->jenis_kelamin === 'L' ? 'male' : 'female' }} me-1"></i>
                                {{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}
                            </span>
                        </div>

                        <!-- Informasi Ringkas -->
                        <div class="highlight-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Tempat, Tanggal Lahir:</strong><br>
                                    {{ $penduduk->tempat_lahir ?? 'Tidak diketahui' }}, {{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d F Y') : 'Tidak diketahui' }}
                                </div>
                                <div class="col-md-6">
                                    <strong>Alamat:</strong><br>
                                    {{ $penduduk->alamat ?? 'Tidak diketahui' }}
                                    @if($penduduk->rt || $penduduk->rw)
                                        RT {{ $penduduk->rt ?? '-' }} RW {{ $penduduk->rw ?? '-' }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Informasi -->
                <div class="col-lg-4">
                    <!-- Statistik Umur -->
                    <div class="content-card detail-fade-in" style="animation-delay: 0.4s;">
                        <div class="stats-card">
                            <div class="stat-number">{{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age : 0 }}</div>
                            <div class="stat-label">Tahun</div>
                            <small class="d-block mt-2">
                                @if($penduduk->tanggal_lahir)
                                    Lahir {{ \Carbon\Carbon::parse($penduduk->tanggal_lahir)->diffForHumans() }}
                                @else
                                    Tanggal lahir tidak diketahui
                                @endif
                            </small>
                        </div>
                    </div>

                    <!-- Quick Info -->
                    <div class="content-card detail-fade-in" style="animation-delay: 0.5s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-identity">
                                <i class="fas fa-info-circle"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Informasi Singkat</h6>
                        </div>
                        <table class="info-table">
                            <tr>
                                <td>Status</td>
                                <td>:</td>
                                <td>
                                    <span class="badge bg-{{ $penduduk->status == 'aktif' ? 'success' : 'danger' }}">
                                        {{ ucfirst($penduduk->status) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>Agama</td>
                                <td>:</td>
                                <td>{{ $penduduk->agama ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Pekerjaan</td>
                                <td>:</td>
                                <td>{{ $penduduk->pekerjaan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Status Perkawinan</td>
                                <td>:</td>
                                <td>{{ $penduduk->status_perkawinan ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Kewarganegaraan</td>
                                <td>:</td>
                                <td>{{ $penduduk->kewarganegaraan ?? 'WNI' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Detail Sections -->
            <div class="row mt-4">
                <!-- Data Identitas -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card detail-fade-in" style="animation-delay: 0.6s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-identity">
                                <i class="fas fa-id-card"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Data Identitas</h6>
                        </div>
                        <table class="info-table">
                            <tr>
                                <td>NIK</td>
                                <td>:</td>
                                <td>{{ $penduduk->nik }}</td>
                            </tr>
                            <tr>
                                <td>No. KK</td>
                                <td>:</td>
                                <td>{{ $penduduk->no_kk ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Nama Lengkap</td>
                                <td>:</td>
                                <td>{{ $penduduk->nama }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                            </tr>
                            <tr>
                                <td>Tempat Lahir</td>
                                <td>:</td>
                                <td>{{ $penduduk->tempat_lahir ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Tanggal Lahir</td>
                                <td>:</td>
                                <td>{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d F Y') : '-' }}</td>
                            </tr>
                            <tr>
                                <td>Umur</td>
                                <td>:</td>
                                <td>{{ $penduduk->tanggal_lahir ? \Carbon\Carbon::parse($penduduk->tanggal_lahir)->age . ' tahun' : '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Alamat -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card detail-fade-in" style="animation-delay: 0.7s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-address">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Data Alamat</h6>
                        </div>
                        <table class="info-table">
                            <tr>
                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $penduduk->alamat ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>RT</td>
                                <td>:</td>
                                <td>{{ $penduduk->rt ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>RW</td>
                                <td>:</td>
                                <td>{{ $penduduk->rw ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Alamat Lengkap</td>
                                <td>:</td>
                                <td>
                                    {{ $penduduk->alamat ?? '' }}
                                    @if($penduduk->rt || $penduduk->rw)
                                        RT {{ $penduduk->rt ?? '-' }} RW {{ $penduduk->rw ?? '-' }}
                                    @endif
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Keluarga -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card detail-fade-in" style="animation-delay: 0.8s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-family">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Data Keluarga</h6>
                        </div>
                        <table class="info-table">
                            <tr>
                                <td>Nama Ayah</td>
                                <td>:</td>
                                <td>{{ $penduduk->nama_ayah ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Nama Ibu</td>
                                <td>:</td>
                                <td>{{ $penduduk->nama_ibu ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Status Hub. Keluarga</td>
                                <td>:</td>
                                <td>{{ $penduduk->status_hubungan_keluarga ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Status Perkawinan</td>
                                <td>:</td>
                                <td>{{ $penduduk->status_perkawinan ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Kontak -->
                <div class="col-lg-6 mb-4">
                    <div class="content-card detail-fade-in" style="animation-delay: 0.9s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-contact">
                                <i class="fas fa-phone"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Data Kontak</h6>
                        </div>
                        <table class="info-table">
                            <tr>
                                <td>Telepon</td>
                                <td>:</td>
                                <td>{{ $penduduk->telepon ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $penduduk->email ?? '-' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <!-- Data Tambahan -->
                <div class="col-lg-12 mb-4">
                    <div class="content-card detail-fade-in" style="animation-delay: 1.0s;">
                        <div class="card-header-custom">
                            <div class="section-icon icon-additional">
                                <i class="fas fa-list"></i>
                            </div>
                            <h6 class="mb-0 fw-bold">Data Tambahan</h6>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <table class="info-table">
                                    <tr>
                                        <td>Agama</td>
                                        <td>:</td>
                                        <td>{{ $penduduk->agama ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pendidikan</td>
                                        <td>:</td>
                                        <td>{{ $penduduk->pendidikan ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Pekerjaan</td>
                                        <td>:</td>
                                        <td>{{ $penduduk->pekerjaan ?? '-' }}</td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="info-table">
                                    <tr>
                                        <td>Golongan Darah</td>
                                        <td>:</td>
                                        <td>{{ $penduduk->golongan_darah ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Kewarganegaraan</td>
                                        <td>:</td>
                                        <td>{{ $penduduk->kewarganegaraan ?? 'WNI' }}</td>
                                    </tr>
                                    <tr>
                                        <td>Status Data</td>
                                        <td>:</td>
                                        <td>
                                            <span class="badge bg-{{ $penduduk->status == 'aktif' ? 'success' : 'danger' }}">
                                                {{ ucfirst($penduduk->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Print Area -->
            <div class="print-area">
                <div class="text-center mb-4">
                    <h2>DATA PENDUDUK</h2>
                    <h3>NAGARI MUNGO</h3>
                    <hr>
                </div>
                
                <table class="table table-borderless">
                    <tr>
                        <td width="20%"><strong>NIK</strong></td>
                        <td width="5%">:</td>
                        <td width="25%">{{ $penduduk->nik }}</td>
                        <td width="20%"><strong>No. KK</strong></td>
                        <td width="5%">:</td>
                        <td width="25%">{{ $penduduk->no_kk ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Lengkap</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->nama }}</td>
                        <td><strong>Jenis Kelamin</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tempat Lahir</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->tempat_lahir ?? '-' }}</td>
                        <td><strong>Tanggal Lahir</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->tanggal_lahir ? $penduduk->tanggal_lahir->format('d F Y') : '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Alamat</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->alamat ?? '-' }}</td>
                        <td><strong>RT/RW</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->rt ?? '-' }}/{{ $penduduk->rw ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Agama</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->agama ?? '-' }}</td>
                        <td><strong>Status Perkawinan</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->status_perkawinan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pekerjaan</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->pekerjaan ?? '-' }}</td>
                        <td><strong>Pendidikan</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->pendidikan ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Nama Ayah</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->nama_ayah ?? '-' }}</td>
                        <td><strong>Nama Ibu</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->nama_ibu ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Telepon</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->telepon ?? '-' }}</td>
                        <td><strong>Email</strong></td>
                        <td>:</td>
                        <td>{{ $penduduk->email ?? '-' }}</td>
                    </tr>
                </table>

                <div class="mt-5">
                    <div class="row">
                        <div class="col-6"></div>
                        <div class="col-6 text-center">
                            <p>Mungo, {{ now()->format('d F Y') }}</p>
                            <p>Kepala Nagari</p>
                            <br><br><br>
                            <p><strong>(...........................)</strong></p>
                        </div>
                    </div>
                </div>
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
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Auto dismiss alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Print Data Function
        function printData() {
            window.print();
        }

        // Edit Penduduk Function
        function editPenduduk(id) {
            $('#editPendudukModal').modal('show');
            
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
                    } else {
                        showAlert('error', 'Gagal memuat data penduduk: ' + (response.message || 'Unknown error'));
                        $('#editPendudukModal').modal('hide');
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
                    $('#editPendudukModal').modal('hide');
                }
            });
        }

        function buildEditForm(data) {
            return `
                <!-- Identitas Pribadi -->
                <div class="row">
                    <div class="col-12 mb-3">
                        <h6 class="text-primary"><i class="fas fa-id-card me-2"></i>Identitas Pribadi</h6>
                        <hr>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_nik" class="form-label">NIK <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="edit_nik" name="nik" required maxlength="16"
                               placeholder="Masukkan NIK 16 digit" value="${data.nik || ''}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_no_kk" class="form-label">No. KK</label>
                        <input type="text" class="form-control" id="edit_no_kk" name="no_kk" maxlength="16"
                               placeholder="Masukkan No. KK" value="${data.no_kk || ''}">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="edit_nama" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="edit_nama" name="nama" required
                           placeholder="Masukkan nama lengkap" value="${data.nama || ''}">
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label for="edit_jenis_kelamin" class="form-label">Jenis Kelamin <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_jenis_kelamin" name="jenis_kelamin" required>
                            <option value="">Pilih Jenis Kelamin</option>
                            <option value="L" ${data.jenis_kelamin === 'L' ? 'selected' : ''}>Laki-laki</option>
                            <option value="P" ${data.jenis_kelamin === 'P' ? 'selected' : ''}>Perempuan</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="edit_tempat_lahir" name="tempat_lahir"
                               placeholder="Tempat lahir" value="${data.tempat_lahir || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="edit_tanggal_lahir" name="tanggal_lahir"
                               value="${data.tanggal_lahir || ''}">
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
                    <label for="edit_alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="edit_alamat" name="alamat" rows="2"
                              placeholder="Masukkan alamat lengkap">${data.alamat || ''}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-3">
                        <label for="edit_rt" class="form-label">RT</label>
                        <input type="text" class="form-control" id="edit_rt" name="rt" maxlength="3"
                               placeholder="001" value="${data.rt || ''}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_rw" class="form-label">RW</label>
                        <input type="text" class="form-control" id="edit_rw" name="rw" maxlength="3"
                               placeholder="001" value="${data.rw || ''}">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_agama" class="form-label">Agama</label>
                        <select class="form-select" id="edit_agama" name="agama">
                            <option value="Islam" ${(data.agama || 'Islam') === 'Islam' ? 'selected' : ''}>Islam</option>
                            <option value="Kristen" ${data.agama === 'Kristen' ? 'selected' : ''}>Kristen</option>
                            <option value="Katolik" ${data.agama === 'Katolik' ? 'selected' : ''}>Katolik</option>
                            <option value="Hindu" ${data.agama === 'Hindu' ? 'selected' : ''}>Hindu</option>
                            <option value="Buddha" ${data.agama === 'Buddha' ? 'selected' : ''}>Buddha</option>
                            <option value="Konghucu" ${data.agama === 'Konghucu' ? 'selected' : ''}>Konghucu</option>
                        </select>
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="edit_status_perkawinan" class="form-label">Status Perkawinan</label>
                        <select class="form-select" id="edit_status_perkawinan" name="status_perkawinan">
                            <option value="Belum Kawin" ${(data.status_perkawinan || 'Belum Kawin') === 'Belum Kawin' ? 'selected' : ''}>Belum Kawin</option>
                            <option value="Kawin" ${data.status_perkawinan === 'Kawin' ? 'selected' : ''}>Kawin</option>
                            <option value="Cerai Hidup" ${data.status_perkawinan === 'Cerai Hidup' ? 'selected' : ''}>Cerai Hidup</option>
                            <option value="Cerai Mati" ${data.status_perkawinan === 'Cerai Mati' ? 'selected' : ''}>Cerai Mati</option>
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
                        <label for="edit_pendidikan" class="form-label">Pendidikan</label>
                        <select class="form-select" id="edit_pendidikan" name="pendidikan">
                            <option value="">Pilih Pendidikan</option>
                            <option value="Tidak/Belum Sekolah" ${data.pendidikan === 'Tidak/Belum Sekolah' ? 'selected' : ''}>Tidak/Belum Sekolah</option>
                            <option value="Belum Tamat SD/Sederajat" ${data.pendidikan === 'Belum Tamat SD/Sederajat' ? 'selected' : ''}>Belum Tamat SD/Sederajat</option>
                            <option value="Tamat SD/Sederajat" ${data.pendidikan === 'Tamat SD/Sederajat' ? 'selected' : ''}>Tamat SD/Sederajat</option>
                            <option value="SLTP/Sederajat" ${data.pendidikan === 'SLTP/Sederajat' ? 'selected' : ''}>SLTP/Sederajat</option>
                            <option value="SLTA/Sederajat" ${data.pendidikan === 'SLTA/Sederajat' ? 'selected' : ''}>SLTA/Sederajat</option>
                            <option value="Diploma I/II" ${data.pendidikan === 'Diploma I/II' ? 'selected' : ''}>Diploma I/II</option>
                            <option value="Akademi/Diploma III/S.Muda" ${data.pendidikan === 'Akademi/Diploma III/S.Muda' ? 'selected' : ''}>Akademi/Diploma III/S.Muda</option>
                            <option value="Diploma IV/Strata I" ${data.pendidikan === 'Diploma IV/Strata I' ? 'selected' : ''}>Diploma IV/Strata I</option>
                            <option value="Strata II" ${data.pendidikan === 'Strata II' ? 'selected' : ''}>Strata II</option>
                            <option value="Strata III" ${data.pendidikan === 'Strata III' ? 'selected' : ''}>Strata III</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="edit_pekerjaan" name="pekerjaan"
                               placeholder="Masukkan pekerjaan" value="${data.pekerjaan || ''}">
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
                        <label for="edit_telepon" class="form-label">Telepon</label>
                        <input type="text" class="form-control" id="edit_telepon" name="telepon"
                               placeholder="Nomor telepon" value="${data.telepon || ''}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email" name="email"
                               placeholder="Alamat email" value="${data.email || ''}">
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
                        <label for="edit_nama_ayah" class="form-label">Nama Ayah</label>
                        <input type="text" class="form-control" id="edit_nama_ayah" name="nama_ayah"
                               placeholder="Nama ayah" value="${data.nama_ayah || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_nama_ibu" class="form-label">Nama Ibu</label>
                        <input type="text" class="form-control" id="edit_nama_ibu" name="nama_ibu"
                               placeholder="Nama ibu" value="${data.nama_ibu || ''}">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label for="edit_status_hubungan_keluarga" class="form-label">Status Hubungan Keluarga</label>
                        <select class="form-select" id="edit_status_hubungan_keluarga" name="status_hubungan_keluarga">
                            <option value="">Pilih Status</option>
                            <option value="Kepala Keluarga" ${data.status_hubungan_keluarga === 'Kepala Keluarga' ? 'selected' : ''}>Kepala Keluarga</option>
                            <option value="Istri" ${data.status_hubungan_keluarga === 'Istri' ? 'selected' : ''}>Istri</option>
                            <option value="Anak" ${data.status_hubungan_keluarga === 'Anak' ? 'selected' : ''}>Anak</option>
                            <option value="Menantu" ${data.status_hubungan_keluarga === 'Menantu' ? 'selected' : ''}>Menantu</option>
                            <option value="Cucu" ${data.status_hubungan_keluarga === 'Cucu' ? 'selected' : ''}>Cucu</option>
                            <option value="Orangtua" ${data.status_hubungan_keluarga === 'Orangtua' ? 'selected' : ''}>Orangtua</option>
                            <option value="Mertua" ${data.status_hubungan_keluarga === 'Mertua' ? 'selected' : ''}>Mertua</option>
                            <option value="Famili Lain" ${data.status_hubungan_keluarga === 'Famili Lain' ? 'selected' : ''}>Famili Lain</option>
                            <option value="Pembantu" ${data.status_hubungan_keluarga === 'Pembantu' ? 'selected' : ''}>Pembantu</option>
                            <option value="Lainnya" ${data.status_hubungan_keluarga === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                        </select>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="edit_golongan_darah" class="form-label">Golongan Darah</label>
                        <select class="form-select" id="edit_golongan_darah" name="golongan_darah">
                            <option value="">Pilih Golongan Darah</option>
                            <option value="A" ${data.golongan_darah === 'A' ? 'selected' : ''}>A</option>
                            <option value="B" ${data.golongan_darah === 'B' ? 'selected' : ''}>B</option>
                            <option value="AB" ${data.golongan_darah === 'AB' ? 'selected' : ''}>AB</option>
                            <option value="O" ${data.golongan_darah === 'O' ? 'selected' : ''}>O</option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="edit_kewarganegaraan" class="form-label">Kewarganegaraan</label>
                        <select class="form-select" id="edit_kewarganegaraan" name="kewarganegaraan">
                            <option value="WNI" ${(data.kewarganegaraan || 'WNI') === 'WNI' ? 'selected' : ''}>WNI</option>
                            <option value="WNA" ${data.kewarganegaraan === 'WNA' ? 'selected' : ''}>WNA</option>
                        </select>
                    </div>
                </div>
            `;
        }

        // Confirm delete function
        function confirmDelete() {
            return confirm('Apakah Anda yakin ingin menghapus data penduduk ini? Tindakan ini tidak dapat dibatalkan.');
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
            
            $('body').prepend(alert);
            
            setTimeout(function() {
                alert.fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 5000);
        }

        // Form submission handler
        $('#formEditPenduduk').on('submit', function(e) {
            e.preventDefault();
            
            const form = $(this);
            const submitBtn = form.find('button[type="submit"]');
            const originalText = submitBtn.html();
            
            submitBtn.html('<i class="fas fa-spinner fa-spin me-1"></i>Updating...').prop('disabled', true);
            
            $.ajax({
                url: form.attr('action'),
                method: 'PUT',
                data: form.serialize(),
                success: function(response) {
                    if (response.success) {
                        $('#editPendudukModal').modal('hide');
                        showAlert('success', response.message);
                        
                        // Reload page after a short delay
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    } else {
                        showAlert('error', response.message || 'Gagal mengupdate data');
                    }
                },
                error: function(xhr) {
                    let errorMessage = 'Terjadi kesalahan saat mengupdate data';
                    
                    if (xhr.responseJSON) {
                        if (xhr.responseJSON.errors) {
                            const errors = Object.values(xhr.responseJSON.errors).flat();
                            errorMessage = errors.join('<br>');
                        } else if (xhr.responseJSON.message) {
                            errorMessage = xhr.responseJSON.message;
                        }
                    }
                    
                    showAlert('error', errorMessage);
                },
                complete: function() {
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });

        // Reset form when modal is hidden
        $('#editPendudukModal').on('hidden.bs.modal', function() {
            $('#formEditPenduduk')[0].reset();
            $('#editPendudukContent').html(`
                <div class="text-center">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-2">Memuat form edit...</p>
                </div>
            `);
        });

        // Handle sidebar layout adjustments
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

        document.addEventListener('DOMContentLoaded', adjustPageLayout);
        window.addEventListener('resize', adjustPageLayout);
        window.addEventListener('load', adjustPageLayout);
    </script>
</body>
</html>