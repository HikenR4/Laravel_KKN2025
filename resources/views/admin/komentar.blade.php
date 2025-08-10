<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Komentar - Nagari Mungo</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS Khusus untuk Halaman Komentar */
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
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 1rem;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fbbf24;
            color: #92400e;
        }

        .status-approved {
            background: #10b981;
            color: white;
        }

        .status-rejected {
            background: #ef4444;
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
            transition: all 0.3s ease;
            border: none;
        }

        .action-btn:hover {
            transform: translateY(-2px);
        }

        .btn-delete:hover {
            background: #ef4444;
            color: white;
        }

        .btn-approve:hover {
            background: #10b981;
            color: white;
        }

        .btn-reject:hover {
            background: #f59e0b;
            color: white;
        }

        .btn-view:hover {
            background: #3b82f6;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: #ffffff;
            padding: 1.5rem;
            border-radius: 0.75rem;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: 700;
            color: #1f2937;
        }

        .stat-label {
            color: #6b7280;
            font-size: 0.875rem;
            margin-top: 0.5rem;
        }

        .komentar-text {
            max-width: 300px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
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

        .komentar-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: komentarFadeInUp 0.6s ease forwards;
        }

        @keyframes komentarFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .bulk-actions {
            background: #f8fafc;
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1rem;
            display: none;
        }

        .bulk-actions.show {
            display: block;
        }

        .rating-stars {
            color: #fbbf24;
        }

        .berita-link {
            color: #3b82f6;
            text-decoration: none;
        }

        .berita-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="min-h-screen">
    <div class="flex min-h-screen">
        @include('layouts.sidebar')

        <div class="page-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="pageMainContent">
            <!-- Page Header -->
            <div class="page-header mb-6 komentar-fade-in">
                <h1 class="page-title text-2xl lg:text-3xl font-bold text-gray-800">Manajemen Komentar</h1>
            </div>

            <!-- Statistics Cards -->
            <div class="stats-grid komentar-fade-in" style="animation-delay: 0.1s;">
                <div class="stat-card">
                    <div class="stat-number text-blue-600">{{ $stats['total'] ?? 0 }}</div>
                    <div class="stat-label">Total Komentar</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number text-yellow-600">{{ $stats['pending'] ?? 0 }}</div>
                    <div class="stat-label">Menunggu Review</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number text-green-600">{{ $stats['approved'] ?? 0 }}</div>
                    <div class="stat-label">Disetujui</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number text-red-600">{{ $stats['rejected'] ?? 0 }}</div>
                    <div class="stat-label">Ditolak</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number text-purple-600">{{ $stats['today'] ?? 0 }}</div>
                    <div class="stat-label">Hari Ini</div>
                </div>
            </div>

            <!-- Page Content -->
            <div class="page-content">
                <!-- Flash Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show komentar-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show komentar-fade-in" role="alert" style="animation-delay: 0.1s;">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Main Card -->
                <div class="content-card komentar-fade-in" style="animation-delay: 0.2s;">
                    <!-- Card Header -->
                    <div class="card-header-custom">
                        <h2 class="card-title-custom">Daftar Komentar</h2>
                        <div class="d-flex gap-2">
                            <button class="btn btn-outline-danger btn-sm" id="btnBulkDelete" style="display: none;">
                                <i class="fas fa-trash me-1"></i>Hapus Terpilih
                            </button>
                            <button class="btn btn-outline-success btn-sm" id="btnBulkApprove" style="display: none;">
                                <i class="fas fa-check me-1"></i>Setujui Terpilih
                            </button>
                            <button class="btn btn-outline-warning btn-sm" id="btnBulkReject" style="display: none;">
                                <i class="fas fa-times me-1"></i>Tolak Terpilih
                            </button>
                        </div>
                    </div>

                    <!-- Search & Filter Section -->
                    <div class="search-filter-section mb-6">
                        <form method="GET" action="{{ route('admin.komentar') }}" id="filterForm">
                            <div class="row">
                                <div class="col-md-4 mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-search"></i>
                                        </span>
                                        <input type="text" class="form-control" id="searchInput" name="search"
                                               placeholder="Cari berdasarkan nama atau komentar..."
                                               value="{{ request('search') }}">
                                    </div>
                                </div>
                                <div class="col-md-2 mb-3">
                                    <select class="form-select" id="filterStatus" name="status">
                                        <option value="">Semua Status</option>
                                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Disetujui</option>
                                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <select class="form-select" id="filterBerita" name="berita_id">
                                        <option value="">Semua Berita</option>
                                        @foreach($beritaList as $berita)
                                            <option value="{{ $berita->id }}" {{ request('berita_id') == $berita->id ? 'selected' : '' }}>
                                                {{ Str::limit($berita->judul, 50) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-filter me-1"></i>Filter
                                        </button>
                                        <a href="{{ route('admin.komentar') }}" class="btn btn-outline-secondary">
                                            <i class="fas fa-refresh me-1"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Bulk Actions -->
                    <div class="bulk-actions" id="bulkActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span id="selectedCount">0 komentar terpilih</span>
                            <div class="d-flex gap-2">
                                <button class="btn btn-success btn-sm" onclick="bulkAction('approve')">
                                    <i class="fas fa-check me-1"></i>Setujui
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="bulkAction('reject')">
                                    <i class="fas fa-times me-1"></i>Tolak
                                </button>
                                <button class="btn btn-danger btn-sm" onclick="bulkDelete()">
                                    <i class="fas fa-trash me-1"></i>Hapus
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
                                    <th style="width: 15%">Pengirim</th>
                                    <th style="width: 30%">Komentar</th>
                                    <th style="width: 20%">Berita</th>
                                    <th style="width: 10%">Status</th>
                                    <th style="width: 10%">Tanggal</th>
                                    <th style="width: 10%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($komentar as $index => $item)
                                <tr class="komentar-fade-in" style="animation-delay: {{ 0.3 + ($index * 0.1) }}s;">
                                    <td>
                                        <input type="checkbox" class="form-check-input comment-checkbox" value="{{ $item->id }}">
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $item->nama }}</div>
                                        @if($item->email)
                                            <small class="text-muted">{{ $item->email }}</small>
                                        @endif
                                        @if($item->rating)
                                            <div class="rating-stars mt-1">
                                                @for($i = 1; $i <= 5; $i++)
                                                    <i class="fas fa-star{{ $i <= $item->rating ? '' : '-o' }}"></i>
                                                @endfor
                                            </div>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="komentar-text" title="{{ $item->komentar }}">
                                            {{ $item->komentar }}
                                        </div>
                                        @if($item->parent_id)
                                            <small class="text-info">
                                                <i class="fas fa-reply me-1"></i>Balasan dari {{ $item->parent->nama ?? 'Unknown' }}
                                            </small>
                                        @endif
                                        @if($item->replies->count() > 0)
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-comments me-1"></i>{{ $item->replies->count() }} balasan
                                            </small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($item->berita)
                                            <a href="#" class="berita-link">
                                                {{ Str::limit($item->berita->judul, 40) }}
                                            </a>
                                        @else
                                            <span class="text-muted">Berita dihapus</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="status-badge status-{{ $item->status }}">
                                            {{ ucfirst($item->status) }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="fw-bold">{{ $item->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $item->created_at->format('H:i') }}</small>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="action-btn btn-view" onclick="viewItem({{ $item->id }})"
                                                    title="Lihat Detail" data-bs-toggle="tooltip">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            @if($item->status !== 'approved')
                                                <button class="action-btn btn-approve" onclick="approveItem({{ $item->id }})"
                                                        title="Setujui" data-bs-toggle="tooltip">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            @endif
                                            @if($item->status !== 'rejected')
                                                <button class="action-btn btn-reject" onclick="rejectItem({{ $item->id }})"
                                                        title="Tolak" data-bs-toggle="tooltip">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            @endif
                                            <button class="action-btn btn-delete" onclick="deleteItem({{ $item->id }})"
                                                    title="Hapus" data-bs-toggle="tooltip">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4">
                                        <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                                        <p class="text-muted">Belum ada komentar</p>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination Section -->
                    @if($komentar->hasPages())
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="pagination-info">
                                <small class="text-muted">
                                    Menampilkan {{ $komentar->firstItem() }} - {{ $komentar->lastItem() }}
                                    dari {{ $komentar->total() }} komentar
                                </small>
                            </div>
                            <div class="pagination-links">
                                {{ $komentar->appends(request()->query())->links() }}
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Modal Detail Komentar -->
            <div class="modal fade" id="detailKomentarModal" tabindex="-1" aria-labelledby="detailKomentarModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header bg-primary">
                            <h5 class="modal-title text-white" id="detailKomentarModalLabel">
                                <i class="fas fa-comment me-2"></i>Detail Komentar
                            </h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body" id="detailKomentarContent">
                            <div class="text-center">
                                <div class="loading"></div>
                                <p class="mt-2">Memuat detail komentar...</p>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                <i class="fas fa-times me-1"></i>Tutup
                            </button>
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
                            <p class="text-muted">Komentar yang dihapus tidak dapat dikembalikan lagi.</p>
                            <div class="alert alert-warning mt-3">
                                <small><i class="fas fa-info-circle me-1"></i>Balasan komentar juga akan ikut terhapus</small>
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
                                    <i class="fas fa-trash me-1"></i>Ya, Hapus Komentar
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

            // Checkbox functionality
            $('#selectAll').on('change', function() {
                $('.comment-checkbox').prop('checked', this.checked);
                toggleBulkActions();
            });

            $('.comment-checkbox').on('change', function() {
                var totalCheckboxes = $('.comment-checkbox').length;
                var checkedCheckboxes = $('.comment-checkbox:checked').length;

                $('#selectAll').prop('indeterminate', checkedCheckboxes > 0 && checkedCheckboxes < totalCheckboxes);
                $('#selectAll').prop('checked', checkedCheckboxes === totalCheckboxes);

                toggleBulkActions();
            });

            function toggleBulkActions() {
                var checkedCount = $('.comment-checkbox:checked').length;
                if (checkedCount > 0) {
                    $('#bulkActions').addClass('show');
                    $('#selectedCount').text(checkedCount + ' komentar terpilih');
                } else {
                    $('#bulkActions').removeClass('show');
                }
            }
        });

        // CSRF Token Setup
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Action functions
        function deleteItem(id) {
            $('#deleteForm').attr('action', '{{ url("admin/komentar/delete") }}/' + id);
            $('#deleteModal').modal('show');
        }

        function viewItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.ajax({
                url: '{{ url("admin/komentar/show") }}/' + id,
                method: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.success) {
                        const data = response.data;
                        const content = `
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Informasi Pengirim</h6>
                                    <table class="table table-sm">
                                        <tr><td><strong>Nama:</strong></td><td>${data.nama}</td></tr>
                                        <tr><td><strong>Email:</strong></td><td>${data.email || '-'}</td></tr>
                                        <tr><td><strong>Telepon:</strong></td><td>${data.telepon || '-'}</td></tr>
                                        ${data.rating ? `<tr><td><strong>Rating:</strong></td><td>${'★'.repeat(data.rating)}${'☆'.repeat(5-data.rating)}</td></tr>` : ''}
                                        <tr><td><strong>Status:</strong></td><td><span class="status-badge status-${data.status}">${data.status.toUpperCase()}</span></td></tr>
                                    </table>
                                </div>
                                <div class="col-md-6">
                                    <h6>Informasi Sistem</h6>
                                    <table class="table table-sm">
                                        <tr><td><strong>IP Address:</strong></td><td>${data.ip_address || '-'}</td></tr>
                                        <tr><td><strong>Dibuat:</strong></td><td>${data.created_at}</td></tr>
                                        <tr><td><strong>Diupdate:</strong></td><td>${data.updated_at}</td></tr>
                                        <tr><td><strong>Balasan:</strong></td><td>${data.replies_count} balasan</td></tr>
                                    </table>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Berita Terkait</h6>
                                    <p class="text-muted">${data.berita}</p>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <h6>Isi Komentar</h6>
                                    <div class="border p-3 rounded bg-light">
                                        ${data.komentar}
                                    </div>
                                </div>
                            </div>
                        `;
                        $('#detailKomentarContent').html(content);
                        $('#detailKomentarModal').modal('show');
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memuat detail komentar.');
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        function approveItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.ajax({
                url: '{{ url("admin/komentar") }}/' + id + '/approve',
                method: 'PATCH',
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menyetujui komentar.');
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        function rejectItem(id) {
            const btn = event.target.closest('button');
            const originalContent = btn.innerHTML;
            btn.innerHTML = '<div class="loading"></div>';
            btn.disabled = true;

            $.ajax({
                url: '{{ url("admin/komentar") }}/' + id + '/reject',
                method: 'PATCH',
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menolak komentar.');
                },
                complete: function() {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }
            });
        }

        function bulkAction(action) {
            const selectedIds = $('.comment-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Pilih minimal satu komentar.');
                return;
            }

            const actionText = action === 'approve' ? 'menyetujui' : 'menolak';
            if (!confirm(`Apakah Anda yakin ingin ${actionText} ${selectedIds.length} komentar?`)) {
                return;
            }

            $.ajax({
                url: '{{ route("admin.komentar.bulk-action") }}',
                method: 'POST',
                data: {
                    ids: selectedIds,
                    action: action
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat memproses komentar.');
                }
            });
        }

        function bulkDelete() {
            const selectedIds = $('.comment-checkbox:checked').map(function() {
                return this.value;
            }).get();

            if (selectedIds.length === 0) {
                alert('Pilih minimal satu komentar.');
                return;
            }

            if (!confirm(`Apakah Anda yakin ingin menghapus ${selectedIds.length} komentar? Tindakan ini tidak dapat dibatalkan.`)) {
                return;
            }

            $.ajax({
                url: '{{ route("admin.komentar.bulk-delete") }}',
                method: 'DELETE',
                data: {
                    ids: selectedIds
                },
                success: function(response) {
                    if (response.success) {
                        location.reload();
                    } else {
                        alert(response.message);
                    }
                },
                error: function() {
                    alert('Terjadi kesalahan saat menghapus komentar.');
                }
            });
        }

        // Auto-submit filter form on change
        $('#filterStatus, #filterBerita').on('change', function() {
            $('#filterForm').submit();
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
