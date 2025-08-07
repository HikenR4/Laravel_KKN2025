<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Berita */
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

        .btn-tambah-kategori {
            background: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            transition: all 0.3s ease;
        }

        .btn-tambah-kategori:hover {
            background: #2563eb;
            transform: translateY(-2px);
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
            background: #e5e7eb;
            color: #374151;
        }

        .gambar-thumb {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .no-image {
            width: 60px;
            height: 60px;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 0.5rem;
            color: #6b7280;
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
            background: #3b82f6;
            border-color: #3b82f6;
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
        .berita-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: beritaFadeInUp 0.6s ease forwards;
        }

        @keyframes beritaFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Style untuk modal detail */
        .detail-image {
            max-width: 100%;
            max-height: 300px;
            object-fit: cover;
            border-radius: 0.5rem;
        }

        .detail-content {
            max-height: 300px;
            overflow-y: auto;
            line-height: 1.6;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-published {
            background: #10b981;
            color: white;
        }

        .status-draft {
            background: #f59e0b;
            color: white;
        }

        .featured-badge {
            background: #ef4444;
            color: white;
            padding: 0.25rem 0.75rem;
            border-radius: 0.5rem;
            font-size: 0.75rem;
            font-weight: 600;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 berita-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Berita</h1>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show berita-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show berita-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show berita-fade-in" role="alert">
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
                <div class="content-card berita-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Berita Nagari</h2>
                        <button class="btn-tambah-kategori" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                            <i class="fas fa-plus me-2"></i>Tambah Berita
                        </button>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="search-filter-section mb-6">
                        <div class="row">
                            <div class="col-md-8 mb-3 mb-md-0">
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="fas fa-search"></i>
                                    </span>
                                    <input type="text" class="form-control" id="searchInput" placeholder="Cari berita berdasarkan judul atau kategori...">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <select class="form-select" id="filterKategori">
                                    <option value="">Semua Kategori</option>
                                    <option value="umum">Umum</option>
                                    <option value="pemerintahan">Pemerintahan</option>
                                    <option value="ekonomi">Ekonomi</option>
                                    <option value="sosial">Sosial</option>
                                    <option value="budaya">Budaya</option>
                                    <option value="kesehatan">Kesehatan</option>
                                    <option value="pendidikan">Pendidikan</option>
                                    <option value="olahraga">Olahraga</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Table Section -->
                    <div class="table-container">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th style="width: 15%">Kategori</th>
                                    <th style="width: 35%">Judul Berita</th>
                                    <th style="width: 20%">Tanggal Berita</th>
                                    <th style="width: 15%">Gambar</th>
                                    <th style="width: 15%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($berita ?? [] as $index => $item)
                                <tr class="berita-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <span class="kategori-badge">{{ ucfirst($item->kategori ?? 'Umum') }}</span>
                                    </td>
                                    <td>
                                        <div class="judul-berita">
                                            {{ $item->judul ?? 'Lorem Ipsum Dolor Sit Amet' }}
                                        </div>
                                        @if($item->excerpt)
                                            <small class="text-muted d-block mt-1">{{ Str::limit($item->excerpt, 80) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="tanggal-berita">
                                            {{ isset($item->tanggal) ? $item->tanggal->format('d/m/Y') : date('d/m/Y') }}
                                        </div>
                                        @if(isset($item->status))
                                            <small class="badge bg-{{ $item->status === 'published' ? 'success' : 'warning' }}">
                                                {{ ucfirst($item->status) }}
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if(isset($item->gambar) && $item->gambar)
                                            <img src="{{ $item->gambar }}" alt="Gambar berita" class="gambar-thumb">
                                        @else
                                            <div class="no-image">
                                                <i class="fas fa-image"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-delete" onclick="deleteItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="action-btn btn-edit" onclick="editItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Edit" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn btn-view" onclick="viewItem({{ $item->id ?? ($index + 1) }})"
                                                    title="Lihat" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada berita yang ditambahkan</p>
                                        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#tambahBeritaModal">
                                            <i class="fas fa-plus me-1"></i>Tambah Berita Pertama
                                        </button>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if(isset($berita) && $berita->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $berita->firstItem() }} - {{ $berita->lastItem() }}
                                    dari {{ $berita->total() }} berita
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $berita->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal Tambah Berita -->
            <div class="modal fade" id="tambahBeritaModal" tabindex="-1" aria-labelledby="tambahBeritaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahBeritaModalLabel">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Berita Baru
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formTambahBerita" action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="judul" name="judul" required
                                               placeholder="Masukkan judul berita" value="{{ old('judul') }}">
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <label for="kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" id="kategori" name="kategori" required>
                                            <option value="">Pilih Kategori</option>
                                            <option value="umum" {{ old('kategori') == 'umum' ? 'selected' : '' }}>Umum</option>
                                            <option value="pemerintahan" {{ old('kategori') == 'pemerintahan' ? 'selected' : '' }}>Pemerintahan</option>
                                            <option value="ekonomi" {{ old('kategori') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                                            <option value="sosial" {{ old('kategori') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                                            <option value="budaya" {{ old('kategori') == 'budaya' ? 'selected' : '' }}>Budaya</option>
                                            <option value="kesehatan" {{ old('kategori') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                                            <option value="pendidikan" {{ old('kategori') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                                            <option value="olahraga" {{ old('kategori') == 'olahraga' ? 'selected' : '' }}>Olahraga</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                        <input type="date" class="form-control" id="tanggal" name="tanggal" required
                                               value="{{ old('tanggal', date('Y-m-d')) }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>Published</option>
                                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="excerpt" class="form-label">Ringkasan</label>
                                    <textarea class="form-control" id="excerpt" name="excerpt" rows="2"
                                              placeholder="Ringkasan singkat berita (opsional)">{{ old('excerpt') }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="konten" class="form-label">Konten Berita <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="konten" name="konten" rows="8" required
                                              placeholder="Tulis konten berita lengkap...">{{ old('konten') }}</textarea>
                                </div>

                                <div class="row">
                                    <div class="col-md-8 mb-3">
                                        <label for="gambar" class="form-label">Gambar Berita</label>
                                        <input type="file" class="form-control" id="gambar" name="gambar" accept="image/*">
                                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <div class="form-check mt-4">
                                            <input class="form-check-input" type="checkbox" id="featured" name="featured" value="1"
                                                   {{ old('featured') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="featured">
                                                Berita Unggulan
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="alt_gambar" class="form-label">Alt Text Gambar</label>
                                        <input type="text" class="form-control" id="alt_gambar" name="alt_gambar"
                                               placeholder="Deskripsi gambar untuk aksesibilitas" value="{{ old('alt_gambar') }}">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="tags" class="form-label">Tags</label>
                                        <input type="text" class="form-control" id="tags" name="tags"
                                               placeholder="tag1, tag2, tag3" value="{{ old('tags') }}">
                                        <small class="text-muted">Pisahkan dengan koma</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea class="form-control" id="meta_description" name="meta_description" rows="2"
                                              placeholder="Deskripsi untuk SEO (maksimal 160 karakter)">{{ old('meta_description') }}</textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Berita
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Berita -->
            <div class="modal fade" id="editBeritaModal" tabindex="-1" aria-labelledby="editBeritaModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-xl">
                    <div class="modal-content">
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title text-dark" id="editBeritaModalLabel">
                                <i class="fas fa-edit me-2"></i>Edit Berita
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formEditBerita" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="modal-body" id="editBeritaContent">
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
                                    <i class="fas fa-save me-1"></i>Update Berita
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
                            <p class="text-muted">Data berita yang dihapus tidak dapat dikembalikan lagi.</p>
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
            const fadeElements = document.querySelectorAll('.berita-fade-in');
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

        // Action functions - Improved dengan AJAX dan Modal
        function deleteItem(id) {
            $('#deleteForm').attr('action', '{{ url("admin/berita/delete") }}/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Redirect to detail page
            setTimeout(() => {
                window.location.href = '{{ url("admin/berita/show") }}/' + id;
            }, 500);
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            // Load edit form via AJAX
            $.ajax({
                url: '{{ url("admin/berita/edit") }}/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        const content = `
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="edit_judul" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="edit_judul" name="judul" required value="${data.judul}">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="edit_kategori" class="form-label">Kategori <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_kategori" name="kategori" required>
                                        <option value="umum" ${data.kategori === 'umum' ? 'selected' : ''}>Umum</option>
                                        <option value="pemerintahan" ${data.kategori === 'pemerintahan' ? 'selected' : ''}>Pemerintahan</option>
                                        <option value="ekonomi" ${data.kategori === 'ekonomi' ? 'selected' : ''}>Ekonomi</option>
                                        <option value="sosial" ${data.kategori === 'sosial' ? 'selected' : ''}>Sosial</option>
                                        <option value="budaya" ${data.kategori === 'budaya' ? 'selected' : ''}>Budaya</option>
                                        <option value="kesehatan" ${data.kategori === 'kesehatan' ? 'selected' : ''}>Kesehatan</option>
                                        <option value="pendidikan" ${data.kategori === 'pendidikan' ? 'selected' : ''}>Pendidikan</option>
                                        <option value="olahraga" ${data.kategori === 'olahraga' ? 'selected' : ''}>Olahraga</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required value="${data.tanggal}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_status" class="form-label">Status <span class="text-danger">*</span></label>
                                    <select class="form-select" id="edit_status" name="status" required>
                                        <option value="published" ${data.status === 'published' ? 'selected' : ''}>Published</option>
                                        <option value="draft" ${data.status === 'draft' ? 'selected' : ''}>Draft</option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_excerpt" class="form-label">Ringkasan</label>
                                <textarea class="form-control" id="edit_excerpt" name="excerpt" rows="2">${data.excerpt || ''}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="edit_konten" class="form-label">Konten Berita <span class="text-danger">*</span></label>
                                <textarea class="form-control" id="edit_konten" name="konten" rows="8" required>${data.konten}</textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-8 mb-3">
                                    <label for="edit_gambar" class="form-label">Gambar Berita</label>
                                    <input type="file" class="form-control" id="edit_gambar" name="gambar" accept="image/*">
                                    <small class="text-muted">Kosongkan jika tidak ingin mengubah gambar</small>
                                    ${data.gambar ? `<div class="mt-2"><img src="${data.gambar}" alt="Current" style="max-width: 100px; max-height: 100px; object-fit: cover; border-radius: 0.25rem;"></div>` : ''}
                                </div>
                                <div class="col-md-4 mb-3">
                                    <div class="form-check mt-4">
                                        <input class="form-check-input" type="checkbox" id="edit_featured" name="featured" value="1" ${data.featured ? 'checked' : ''}>
                                        <label class="form-check-label" for="edit_featured">Berita Unggulan</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="edit_alt_gambar" class="form-label">Alt Text Gambar</label>
                                    <input type="text" class="form-control" id="edit_alt_gambar" name="alt_gambar" value="${data.alt_gambar || ''}">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="edit_tags" class="form-label">Tags</label>
                                    <input type="text" class="form-control" id="edit_tags" name="tags" value="${data.tags || ''}">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="edit_meta_description" class="form-label">Meta Description</label>
                                <textarea class="form-control" id="edit_meta_description" name="meta_description" rows="2">${data.meta_description || ''}</textarea>
                            </div>
                        `;
                        $('#editBeritaContent').html(content);
                        $('#formEditBerita').attr('action', '{{ url("admin/berita/update") }}/' + id);
                        $('#editBeritaModal').modal('show');
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

        // Form submission handlers
        $('#formTambahBerita').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);
        });

        $('#formEditBerita').on('submit', function(e) {
            const submitBtn = $(this).find('button[type="submit"]');
            submitBtn.html('<div class="loading"></div> Mengupdate...').prop('disabled', true);
        });

        // Reset forms when modals are hidden
        $('#tambahBeritaModal').on('hidden.bs.modal', function() {
            $('#formTambahBerita')[0].reset();
            $('#formTambahBerita button[type="submit"]').html('<i class="fas fa-save me-1"></i>Simpan Berita').prop('disabled', false);
        });

        $('#editBeritaModal').on('hidden.bs.modal', function() {
            $('#formEditBerita button[type="submit"]').html('<i class="fas fa-save me-1"></i>Update Berita').prop('disabled', false);
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
