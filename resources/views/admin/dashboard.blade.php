<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Nagari Mungo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .dashboard-glass-effect {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
        }

        .dashboard-card-hover {
            transition: all 0.3s ease;
        }

        .dashboard-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        .dashboard-stat-card {
            background: linear-gradient(135deg, var(--tw-gradient-from), var(--tw-gradient-to));
        }

        .dashboard-header-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dashboard-action-button {
            transition: all 0.3s ease;
        }

        .dashboard-action-button:hover {
            transform: translateX(3px);
        }

        .dashboard-activity-dot {
            animation: dashboardPulse 2s infinite;
        }

        @keyframes dashboardPulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }

        .dashboard-fade-in {
            opacity: 0;
            transform: translateY(20px);
            animation: dashboardFadeInUp 0.6s ease forwards;
        }

        @keyframes dashboardFadeInUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-stat-icon {
            transition: transform 0.3s ease;
        }

        .dashboard-card-hover:hover .dashboard-stat-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .dashboard-main-wrapper {
            margin-left: 0;
            transition: margin-left 0.3s ease;
        }

        @media (min-width: 1024px) {
            .dashboard-main-wrapper {
                margin-left: 280px;
            }
        }

        @media (max-width: 768px) {
            .dashboard-main-wrapper {
                margin-left: 0 !important;
            }
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-50 to-gray-100 min-h-screen">
    <div class="flex min-h-screen">
        {{-- Include Sidebar --}}
        @include('layouts.sidebar')

        {{-- Main Content Dashboard --}}
        <div class="dashboard-main-wrapper flex-1 p-4 lg:p-8 transition-all duration-300" id="dashboardMainContent">
            {{-- Header --}}
            <div class="dashboard-header-card rounded-2xl shadow-lg p-6 lg:p-8 mb-6 lg:mb-8 dashboard-fade-in">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between">
                    <div class="mb-4 lg:mb-0">
                        <h1 class="text-2xl lg:text-3xl font-bold text-gray-800 mb-2">
                            Selamat Datang
                        </h1>
                        <p class="text-gray-600">
                            Dashboard untuk mengelola website Nagari Mungo
                        </p>
                    </div>
                    <div class="text-left lg:text-right">
                        <div class="text-sm text-gray-500">Hari ini</div>
                        <div class="text-lg font-semibold text-gray-800" id="dashboardCurrentDate"></div>
                    </div>
                </div>
            </div>

            {{-- Statistics Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-6 lg:mb-8">
                <div class="dashboard-stat-card dashboard-card-hover from-blue-500 to-blue-600 text-white p-6 rounded-2xl shadow-lg dashboard-fade-in" style="animation-delay: 0.1s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Total Berita</h3>
                            <p class="text-3xl font-bold">{{ \App\Models\Berita::where('status', 'published')->count() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center dashboard-stat-icon">
                            <a href="{{ route('admin.berita') }}"><i class="fas fa-newspaper text-2xl"></i></a>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>{{ \App\Models\Berita::where('status', 'published')->whereMonth('tanggal', now()->month)->count() }} baru bulan ini</span>
                    </div>
                </div>

                <div class="dashboard-stat-card dashboard-card-hover from-green-500 to-green-600 text-white p-6 rounded-2xl shadow-lg dashboard-fade-in" style="animation-delay: 0.2s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Agenda Mendatang</h3>
                            <p class="text-3xl font-bold">{{ \App\Models\Agenda::upcoming()->count() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center dashboard-stat-icon">
                            <a href="{{ route('admin.agenda') }}"><i class="fas fa-calendar-alt text-2xl"></i></a>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>{{ \App\Models\Agenda::upcoming()->whereMonth('tanggal_mulai', now()->month)->count() }} di bulan ini</span>
                    </div>
                </div>

                <div class="dashboard-stat-card dashboard-card-hover from-yellow-500 to-orange-500 text-white p-6 rounded-2xl shadow-lg dashboard-fade-in" style="animation-delay: 0.3s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Pengumuman Aktif</h3>
                            <p class="text-3xl font-bold">{{ \App\Models\Pengumuman::active()->count() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center dashboard-stat-icon">
                            <a href="{{ route('admin.pengumuman') }}"><i class="fas fa-bullhorn text-2xl"></i></a>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>{{ \App\Models\Pengumuman::active()->where('penting', true)->count() }} penting</span>
                    </div>
                </div>

                <div class="dashboard-stat-card dashboard-card-hover from-purple-500 to-purple-600 text-white p-6 rounded-2xl shadow-lg dashboard-fade-in" style="animation-delay: 0.4s;">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold opacity-90">Total Penduduk</h3>
                            <p class="text-3xl font-bold">{{ \App\Models\DataPenduduk::active()->count() }}</p>
                        </div>
                        <div class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center dashboard-stat-icon">
                            <i class="fas fa-users text-2xl"></i>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center text-sm opacity-80">
                        <i class="fas fa-arrow-up mr-1"></i>
                        <span>{{ \App\Models\DataPenduduk::where('status', 'aktif')->whereMonth('created_at', now()->month)->count() }} baru bulan ini</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions and Recent Activities --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-fade-in" style="animation-delay: 0.5s;">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aksi Cepat</h3>
                    <div class="space-y-3">
                        <a href="{{ route('admin.berita') }}" class="dashboard-action-button w-full flex items-center justify-between p-4 bg-blue-50 hover:bg-blue-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-plus-circle text-blue-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Tambah Berita Baru</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('admin.agenda') }}" class="dashboard-action-button w-full flex items-center justify-between p-4 bg-green-50 hover:bg-green-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-calendar-plus text-green-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Buat Agenda Baru</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>

                        <a href="{{ route('admin.pengumuman') }}" class="dashboard-action-button w-full flex items-center justify-between p-4 bg-yellow-50 hover:bg-yellow-100 rounded-xl transition-colors">
                            <div class="flex items-center">
                                <i class="fas fa-megaphone text-yellow-600 mr-3"></i>
                                <span class="font-medium text-gray-700">Publikasi Pengumuman</span>
                            </div>
                            <i class="fas fa-arrow-right text-gray-400"></i>
                        </a>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-fade-in" style="animation-delay: 0.6s;">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Aktivitas Terbaru</h3>
                    <div class="space-y-4">
                        @foreach (\App\Models\LogAktivitas::latest()->take(5)->get() as $log)
                            <div class="flex items-start space-x-3">
                                <div class="w-2 h-2 bg-{{ ['blue', 'green', 'purple', 'yellow', 'red'][array_rand(['blue', 'green', 'purple', 'yellow', 'red'])] }}-500 rounded-full mt-2 dashboard-activity-dot" style="animation-delay: {{ $loop->index * 0.5 }}s;"></div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $log->aktivitas }}</p>
                                    <p class="text-xs text-gray-500">{{ $log->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Pending Letter Requests --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-fade-in" style="animation-delay: 0.7s;">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Permohonan Surat Pending</h3>
                @if (\App\Models\PermohonanSurat::where('status', 'pending')->count() > 0)
                    <div class="space-y-3">
                        @foreach (\App\Models\PermohonanSurat::where('status', 'pending')->latest()->take(5)->get() as $permohonan)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <div>
                                    <p class="text-sm font-medium text-gray-700">{{ $permohonan->nama_pemohon }} ({{ $permohonan->jenis_surat }})</p>
                                    <p class="text-xs text-gray-500">Diajukan: {{ $permohonan->tanggal_permohonan->format('d M Y') }}</p>
                                </div>
                                <a href="{{ route('admin.permohonan_surat.show', $permohonan->id) }}" class="text-blue-600 hover:text-blue-800">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-600">Tidak ada permohonan surat pending saat ini.</p>
                @endif
            </div>

            {{-- Visitor Statistics Chart --}}
            <div class="bg-white rounded-2xl shadow-lg p-6 dashboard-fade-in" style="animation-delay: 0.8s;">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Statistik Kunjungan Bulanan</h3>
                <canvas id="visitorChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Update current date
        const dateElement = document.getElementById('dashboardCurrentDate');
        const now = new Date();
        const options = {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        };
        dateElement.textContent = now.toLocaleDateString('id-ID', options);

        // Initialize Chart.js
        const ctx = document.getElementById('visitorChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: [
                    @foreach (now()->startOfYear()->toPeriod('now', '1 month') as $month)
                        "{{ $month->format('M Y') }}",
                    @endforeach
                ],
                datasets: [{
                    label: 'Kunjungan',
                    data: [
                        @foreach (now()->startOfYear()->toPeriod('now', '1 month') as $month)
                            {{ \App\Models\StatistikKunjungan::whereMonth('tanggal', $month->month)->whereYear('tanggal', $month->year)->sum('jumlah_kunjungan') }},
                        @endforeach
                    ],
                    fill: true,
                    backgroundColor: 'rgba(59, 130, 246, 0.2)',
                    borderColor: '#3b82f6',
                    borderWidth: 2,
                    tension: 0.4
                }, {
                    label: 'Pengunjung Unik',
                    data: [
                        @foreach (now()->startOfYear()->toPeriod('now', '1 month') as $month)
                            {{ \App\Models\StatistikKunjungan::whereMonth('tanggal', $month->month)->whereYear('tanggal', $month->year)->sum('unique_visitors') }},
                        @endforeach
                    ],
                    fill: true,
                    backgroundColor: 'rgba(139, 92, 246, 0.2)',
                    borderColor: '#8b5cf6',
                    borderWidth: 2,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'top' },
                    title: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        title: { display: true, text: 'Jumlah' }
                    },
                    x: {
                        title: { display: true, text: 'Bulan' }
                    }
                }
            }
        });

        // Initialize dashboard animations
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.dashboard-fade-in');
            fadeElements.forEach((element, index) => {
                if (!element.style.animationDelay) {
                    element.style.animationDelay = `${index * 0.1}s`;
                }
            });
        });

        // Sidebar toggle and layout adjustment
        document.addEventListener('DOMContentLoaded', function() {
            const mainContent = document.getElementById('dashboardMainContent');
            const sidebar = document.getElementById('sidebar');
            const toggleBtn = document.getElementById('toggleSidebar');

            if (toggleBtn && sidebar && mainContent) {
                toggleBtn.addEventListener('click', function() {
                    setTimeout(() => {
                        if (sidebar.classList.contains('sidebar-collapsed')) {
                            if (window.innerWidth >= 1024) {
                                mainContent.style.marginLeft = '80px';
                            }
                        } else {
                            if (window.innerWidth >= 1024) {
                                mainContent.style.marginLeft = '280px';
                            }
                        }
                    }, 150);
                });
            }
        });

        // Handle responsive layout
        function adjustDashboardLayout() {
            const mainContent = document.getElementById('dashboardMainContent');
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

        window.addEventListener('resize', adjustDashboardLayout);
        window.addEventListener('load', adjustDashboardLayout);
    </script>
</body>
</html>
