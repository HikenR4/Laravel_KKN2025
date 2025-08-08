<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pengumuman - {{ $pengumuman->judul ?? 'Pengumuman' }} - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Detail Pengumuman */
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

        .detail-header {
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 1rem;
            margin-bottom: 2rem;
        }

        .detail-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .detail-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: center;
            color: #6b7280;
            font-size: 0.875rem;
        }

        .detail-content {
            font-size: 1rem;
            line-height: 1.75;
            color: #374151;
            margin-bottom: 2rem;
        }

        .detail-content img {
            max-width: 100%;
            height: auto;
            margin: 1rem 0;
            border-radius: 0.5rem;
        }

        .detail-image {
            margin-bottom: 2rem;
            text-align: center;
        }

        .detail-image img {
            max-width: 100%;
            height: auto;
            border-radius: 1rem;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .info-sidebar {
            background: #f8fafc;
            border-radius: 1rem;
            padding: 1.5rem;
        }

        .info-item {
            margin-bottom: 1rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #6b7280;
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

        .penting-badge {
            background: #fbbf24;
            color: #92400e;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .action-buttons {
            display: flex;
            gap: 0.75rem;
            margin-top: 2rem;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            text-decoration: none;
        }

        .btn-primary {
            background: #8b5cf6;
            color: white;
        }

        .btn-primary:hover {
            background: #7c3aed;
            transform: translateY(-2px);
            color: white;
        }

        .btn-warning {
            background: #f59e0b;
            color: white;
        }

        .btn-warning:hover {
            background: #d97706;
            transform: translateY(-2px);
            color: white;
        }

        .btn-danger {
            background: #ef4444;
            color: white;
        }

        .btn-danger:hover {
            background: #dc2626;
            transform: translateY(-2px);
            color: white;
        }

        .btn-secondary {
            background: #6b7280;
            color: white;
        }

        .btn-secondary:hover {
            background: #4b5563;
            transform: translateY(-2px);
            color: white;
        }

        .btn-success {
            background: #10b981;
            color: white;
        }

        .btn-success:hover {
            background: #059669;
            transform: translateY(-2px);
            color: white;
        }

        .views-info {
            background: #f3f4f6;
            color: #6b7280;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
        }

        .breadcrumb-nav {
            background: transparent;
            margin-bottom: 1rem;
        }

        .breadcrumb-nav .breadcrumb-item {
            font-size: 0.875rem;
        }

        .breadcrumb-nav .breadcrumb-item a {
            color: #6b7280;
            text-decoration: none;
        }

        .breadcrumb-nav .breadcrumb-item a:hover {
            color: #8b5cf6;
        }

        .breadcrumb-nav .breadcrumb-item.active {
            color: #374151;
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
            <!-- Breadcrumb -->
            <nav class="breadcrumb-nav detail-fade-in" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-home me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('admin.pengumuman') }}">Pengumuman</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        Detail Pengumuman
                    </li>
                </ol>
            </nav>

            <!-- Page Header -->
            <div class="page-header mb-6 detail-fade-in" style="animation-delay: 0.1s;">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Detail Pengumuman</h1>
            </div>

            <!-- Page Content -->
            <div class="page-content">
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

                <div class="row">
                    <!-- Main Content -->
                    <div class="col-lg-8">
                        <div class="content-card detail-fade-in" style="animation-delay: 0.3s;">
                            <!-- Header -->
                            <div class="detail-header">
                                <div class="detail-title d-flex align-items-center">
                                    @if($pengumuman->penting ?? false)
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    @endif
                                    {{ $pengumuman->judul ?? 'Judul Pengumuman' }}
                                </div>
                                
                                <div class="detail-meta">
                                    <span>
                                        <i class="fas fa-user me-1"></i>
                                        {{ $pengumuman->admin->nama_lengkap ?? 'Admin' }}
                                    </span>
                                    <span>
                                        <i class="fas fa-calendar me-1"></i>
                                        {{ $pengumuman->created_at ? $pengumuman->created_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                    </span>
                                    @if($pengumuman->views ?? 0)
                                        <span class="views-info">
                                            <i class="fas fa-eye"></i>
                                            {{ number_format($pengumuman->views ?? 0) }} views
                                        </span>
                                    @endif
                                </div>

                                <!-- Badges -->
                                <div class="mt-3">
                                    <span class="kategori-badge kategori-{{ $pengumuman->kategori ?? 'umum' }}">
                                        {{ ucfirst($pengumuman->kategori ?? 'Umum') }}
                                    </span>
                                    <span class="status-badge status-{{ $pengumuman->status ?? 'aktif' }} ms-2">
                                        {{ ucfirst($pengumuman->status ?? 'Aktif') }}
                                    </span>
                                    @if($pengumuman->penting ?? false)
                                        <span class="penting-badge ms-2">
                                            <i class="fas fa-star"></i>
                                            Penting
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Image -->
                            @if($pengumuman->gambar && $pengumuman->getRawOriginal('gambar'))
                                <div class="detail-image">
                                    <img src="{{ $pengumuman->gambar }}" 
                                         alt="{{ $pengumuman->judul ?? 'Gambar Pengumuman' }}" 
                                         class="img-fluid">
                                </div>
                            @endif

                            <!-- Content -->
                            <div class="detail-content">
                                {!! $pengumuman->konten ?? '<p class="text-muted">Tidak ada konten untuk ditampilkan.</p>' !!}
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <a href="{{ route('admin.pengumuman.edit', $pengumuman->id ?? 1) }}" class="btn-action btn-warning">
                                    <i class="fas fa-edit"></i>
                                    Edit Pengumuman
                                </a>
                                
                                @if(($pengumuman->status ?? 'aktif') === 'aktif' && ($pengumuman->is_active ?? true))
                                    <a href="{{ route('admin.pengumuman', $pengumuman->slug ?? 'sample-slug') }}" 
                                       target="_blank" class="btn-action btn-success">
                                        <i class="fas fa-external-link-alt"></i>
                                        Lihat di Website
                                    </a>
                                @endif

                                <button class="btn-action btn-danger" onclick="deleteItem({{ $pengumuman->id ?? 1 }})">
                                    <i class="fas fa-trash"></i>
                                    Hapus
                                </button>

                                <a href="{{ route('admin.pengumuman') }}" class="btn-action btn-secondary">
                                    <i class="fas fa-arrow-left"></i>
                                    Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Sidebar Info -->
                    <div class="col-lg-4">
                        <div class="info-sidebar detail-fade-in" style="animation-delay: 0.4s;">
                            <h5 class="mb-3">
                                <i class="fas fa-info-circle me-2 text-primary"></i>
                                Informasi Pengumuman
                            </h5>

                            <div class="info-item">
                                <div class="info-label">ID Pengumuman</div>
                                <div class="info-value">{{ $pengumuman->id ?? '1' }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Slug</div>
                                <div class="info-value">
                                    <code>{{ $pengumuman->slug ?? 'sample-pengumuman' }}</code>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Kategori</div>
                                <div class="info-value">
                                    <span class="kategori-badge kategori-{{ $pengumuman->kategori ?? 'umum' }}">
                                        {{ ucfirst($pengumuman->kategori ?? 'Umum') }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Target Audience</div>
                                <div class="info-value">{{ ucwords(str_replace('_', ' ', $pengumuman->target_audience ?? 'semua')) }}</div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Status</div>
                                <div class="info-value">
                                    <span class="status-badge status-{{ $pengumuman->status ?? 'aktif' }}">
                                        {{ ucfirst($pengumuman->status ?? 'Aktif') }}
                                    </span>
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Total Views</div>
                                <div class="info-value">{{ number_format($pengumuman->views ?? 0) }} kali</div>
                            </div>

                            @if($pengumuman->penting ?? false)
                                <div class="info-item">
                                    <div class="info-label">Status Penting</div>
                                    <div class="info-value">
                                        <span class="penting-badge">
                                            <i class="fas fa-star"></i>
                                            Ya, Penting
                                        </span>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Schedule Info -->
                        <div class="info-sidebar detail-fade-in mt-4" style="animation-delay: 0.5s;">
                            <h5 class="mb-3">
                                <i class="fas fa-calendar-alt me-2 text-success"></i>
                                Jadwal Pengumuman
                            </h5>

                            <div class="info-item">
                                <div class="info-label">Tanggal Mulai</div>
                                <div class="info-value">
                                    {{ $pengumuman->tanggal_mulai ? $pengumuman->tanggal_mulai->format('d M Y') : date('d M Y') }}
                                </div>
                            </div>

                            @if($pengumuman->tanggal_berakhir)
                                <div class="info-item">
                                    <div class="info-label">Tanggal Berakhir</div>
                                    <div class="info-value">
                                        {{ $pengumuman->tanggal_berakhir->format('d M Y') }}
                                    </div>
                                </div>
                            @else
                                <div class="info-item">
                                    <div class="info-label">Tanggal Berakhir</div>
                                    <div class="info-value text-success">Tidak terbatas</div>
                                </div>
                            @endif

                            @if($pengumuman->waktu_mulai || $pengumuman->waktu_berakhir)
                                <div class="info-item">
                                    <div class="info-label">Waktu</div>
                                    <div class="info-value">
                                        @if($pengumuman->waktu_mulai)
                                            {{ \Carbon\Carbon::parse($pengumuman->waktu_mulai)->format('H:i') }}
                                        @endif
                                        @if($pengumuman->waktu_berakhir)
                                            - {{ \Carbon\Carbon::parse($pengumuman->waktu_berakhir)->format('H:i') }}
                                        @endif
                                        WIB
                                    </div>
                                </div>
                            @endif

                            <div class="info-item">
                                <div class="info-label">Status Aktif</div>
                                <div class="info-value">
                                    @if($pengumuman->is_active ?? true)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Tidak Aktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Metadata -->
                        <div class="info-sidebar detail-fade-in mt-4" style="animation-delay: 0.6s;">
                            <h5 class="mb-3">
                                <i class="fas fa-clock me-2 text-warning"></i>
                                Metadata
                            </h5>

                            <div class="info-item">
                                <div class="info-label">Dibuat</div>
                                <div class="info-value">
                                    {{ $pengumuman->created_at ? $pengumuman->created_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Diperbarui</div>
                                <div class="info-value">
                                    {{ $pengumuman->updated_at ? $pengumuman->updated_at->format('d M Y, H:i') : date('d M Y, H:i') }} WIB
                                </div>
                            </div>

                            <div class="info-item">
                                <div class="info-label">Penulis</div>
                                <div class="info-value">{{ $pengumuman->admin->nama_lengkap ?? 'Admin' }}</div>
                            </div>

                            @if($pengumuman->gambar && $pengumuman->getRawOriginal('gambar'))
                                <div class="info-item">
                                    <div class="info-label">Gambar</div>
                                    <div class="info-value text-success">
                                        <i class="fas fa-check me-1"></i>Tersedia
                                    </div>
                                </div>
                            @else
                                <div class="info-item">
                                    <div class="info-label">Gambar</div>
                                    <div class="info-value text-muted">
                                        <i class="fas fa-times me-1"></i>Tidak ada
                                    </div>
                                </div>
                            @endif
                        </div>
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
                            <p class="text-muted">Pengumuman <strong>"{{ $pengumuman->judul ?? 'ini' }}"</strong> yang dihapus tidak dapat dikembalikan lagi.</p>
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
    <script>
        $(document).ready(function() {
            // Auto hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Add staggered animation to fade-in elements
            const fadeElements = document.querySelectorAll('.detail-fade-in');
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

        // Delete function
        function deleteItem(id) {
            $('#deleteForm').attr('action', '/admin/pengumuman/' + id);
            $('#deleteModal').modal('show');
        }

        // Handle form submission with loading state
        $('#deleteForm').on('submit', function() {
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<div class="loading me-1"></div>Menghapus...').prop('disabled', true);
            
            // Allow form to submit naturally
            setTimeout(() => {
                submitBtn.html(originalText).prop('disabled', false);
            }, 3000);
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