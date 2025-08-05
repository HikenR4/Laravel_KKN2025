<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Berita - Nagari Mungo</title>
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

                <!-- Main Card -->
                <div class="content-card berita-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Berita Nagari</h2>
                        <button class="btn-tambah-kategori" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">
                            <i class="fas fa-plus me-2"></i>Tambah Kategori
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
                                    </td>
                                    <td>
                                        <div class="tanggal-berita">
                                            {{ isset($item->tanggal) ? $item->tanggal->format('d/m/Y') : 'Berfungsi Jumlah' }}
                                        </div>
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
                                @for($i = 1; $i <= 6; $i++)
                                <tr class="berita-fade-in" style="animation-delay: {{ 0.3 + ($i * 0.1) }}s;">
                                    <td>
                                        <span class="kategori-badge">Lorem Ipsum</span>
                                    </td>
                                    <td>
                                        <div class="judul-berita">
                                            Lorem Ipsum Dolor Sit Amet Consectetur
                                        </div>
                                    </td>
                                    <td>
                                        <div class="tanggal-berita">
                                            Berfungsi Jumlah
                                        </div>
                                    </td>
                                    <td>
                                        <div class="no-image">
                                            <i class="fas fa-image"></i>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-delete" onclick="deleteItem({{ $i }})" 
                                                    title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <button class="action-btn btn-edit" onclick="editItem({{ $i }})" 
                                                    title="Edit" data-bs-toggle="tooltip">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="action-btn btn-view" onclick="viewItem({{ $i }})" 
                                                    title="Lihat" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endfor
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

            <!-- Modal Tambah Kategori -->
            <div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahKategoriModalLabel">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Kategori Berita
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form id="formTambahKategori">
                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="namaKategori" class="form-label">Nama Kategori</label>
                                        <input type="text" class="form-control" id="namaKategori" required 
                                               placeholder="Masukkan nama kategori">
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="warnaBadge" class="form-label">Warna Badge</label>
                                        <select class="form-select" id="warnaBadge">
                                            <option value="#3498db">Biru</option>
                                            <option value="#e74c3c">Merah</option>
                                            <option value="#27ae60">Hijau</option>
                                            <option value="#f39c12">Orange</option>
                                            <option value="#9b59b6">Ungu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="deskripsiKategori" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" id="deskripsiKategori" rows="4" 
                                              placeholder="Masukkan deskripsi kategori (opsional)"></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="fas fa-times me-1"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i>Simpan Kategori
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

        // Action functions
        function deleteItem(id) {
            $('#deleteForm').attr('action', '/admin/berita/delete/' + id);
            $('#deleteModal').modal('show');
        }

        function editItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.get('/admin/berita/edit/' + id)
                .done(function(response) {
                    if (response.success) {
                        alert('Edit berita: ' + response.data.judul);
                    } else {
                        alert('Error: ' + response.message);
                    }
                })
                .fail(function() {
                    alert('Terjadi kesalahan saat mengambil data berita');
                })
                .always(function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                });
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.get('/admin/berita/show/' + id)
                .done(function(response) {
                    if (response.success) {
                        alert('Lihat berita: ' + response.data.judul);
                    } else {
                        alert('Error: ' + response.message);
                    }
                })
                .fail(function() {
                    alert('Terjadi kesalahan saat mengambil data berita');
                })
                .always(function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                });
        }

        // Form submission for adding category
        $('#formTambahKategori').on('submit', function(e) {
            e.preventDefault();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<div class="loading"></div> Menyimpan...').prop('disabled', true);

            setTimeout(function() {
                alert('Kategori "' + $('#namaKategori').val() + '" berhasil ditambahkan!');
                $('#tambahKategoriModal').modal('hide');
                $('#formTambahKategori')[0].reset();
                submitBtn.html(originalText).prop('disabled', false);
            }, 1500);
        });

        // Reset form when modal is hidden
        $('#tambahKategoriModal').on('hidden.bs.modal', function() {
            $('#formTambahKategori')[0].reset();
        });

        // Delete form submission with loading
        $('#deleteForm').on('submit', function(e) {
            e.preventDefault();
            const submitBtn = $(this).find('button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<div class="loading"></div> Menghapus...').prop('disabled', true);

            setTimeout(function() {
                alert('Data berhasil dihapus!');
                $('#deleteModal').modal('hide');
                submitBtn.html(originalText).prop('disabled', false);
            }, 1000);
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