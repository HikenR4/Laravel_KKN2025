@extends('layouts.app')
@section('title', 'Tentang - ' . ($profil->nama_nagari ?? 'Nagari'))
@section('content')
<style>
.tentang-container {
    padding: 20px;
    /* Red gradient background similar to landing page */
    background: linear-gradient(135deg, #FFFFFF 0%, #FFF5F5 20%, #FFE4E1 40%, #FFCCCB 60%, #FF9999 80%, #FF6B6B 100%);
    /* REMOVED min-height: 100vh; - this was causing extra white space */
    position: relative;
}

/* Add floating background pattern like landing page */
.tentang-container::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%23FFFFFF;stop-opacity:0.7" /><stop offset="25%" style="stop-color:%23FFE4E1;stop-opacity:0.5" /><stop offset="50%" style="stop-color:%23FFCCCB;stop-opacity:0.6" /><stop offset="75%" style="stop-color:%23FF9999;stop-opacity:0.5" /><stop offset="100%" style="stop-color:%23FF6B6B;stop-opacity:0.7" /></linearGradient></defs><rect width="1200" height="800" fill="url(%23grad1)"/><circle cx="200" cy="200" r="120" fill="%23DC143C" opacity="0.08"/><circle cx="800" cy="600" r="180" fill="%23FF6B6B" opacity="0.04"/><circle cx="1000" cy="300" r="100" fill="%23B22222" opacity="0.06"/><polygon points="100,100 200,50 250,150 150,200" fill="%23DC143C" opacity="0.03"/></svg>');
    animation: gentleFloat 25s infinite linear;
    z-index: 1;
}

@keyframes gentleFloat {
    0% { transform: translateX(-50px) translateY(-30px); }
    50% { transform: translateX(30px) translateY(20px); }
    100% { transform: translateX(-50px) translateY(-30px); }
}

.content-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    position: relative;
    z-index: 2;
    /* Add padding bottom to ensure proper spacing */
    padding-bottom: 40px;
}

.page-header {
    text-align: center;
    margin-bottom: 40px;
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 50px 30px;
    border: 1px solid rgba(220, 20, 60, 0.2);
    box-shadow: 0 20px 40px rgba(220, 20, 60, 0.1);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

@keyframes fadeInUp {
    0% { opacity: 0; transform: translateY(30px); }
    100% { opacity: 1; transform: translateY(0); }
}

.page-header h1 {
    color: #333;
    font-size: 2.5rem;
    margin-bottom: 15px;
    font-weight: 700;
    text-shadow: none;
}

.page-header h1 i {
    color: #DC143C;
    margin-right: 15px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.page-header p {
    color: #666;
    font-size: 1.1rem;
    max-width: 800px;
    margin: 0 auto;
    line-height: 1.6;
}

.vision-mission {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 40px;
    margin-bottom: 30px;
    box-shadow: 0 20px 40px rgba(220, 20, 60, 0.1);
    border: 1px solid rgba(220, 20, 60, 0.1);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
}

.vision-mission h2 {
    color: #333;
    text-align: center;
    margin-bottom: 30px;
    font-size: 2rem;
    font-weight: 700;
}

.vision-mission h2 i {
    color: #DC143C;
    margin-right: 15px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.vision-mission-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 30px;
}

.vision, .mission {
    padding: 30px;
    border-radius: 20px;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.1));
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.vision::before, .mission::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    transform: scaleX(0);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: left;
}

.vision:hover::before, .mission:hover::before {
    transform: scaleX(1);
}

.vision {
    border-left: 5px solid #DC143C;
}

.mission {
    border-left: 5px solid #FF6B6B;
}

.vision:hover, .mission:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(220, 20, 60, 0.2);
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.15), rgba(220, 20, 60, 0.15));
}

.vision h3, .mission h3 {
    color: #DC143C;
    margin-bottom: 15px;
    font-size: 1.4rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.content-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
    margin-bottom: 30px;
}

.card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 30px;
    box-shadow: 0 20px 40px rgba(220, 20, 60, 0.1);
    border: 1px solid rgba(220, 20, 60, 0.1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
}

.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    transform: scaleX(0);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: left;
}

.card::after {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.02), rgba(220, 20, 60, 0.02));
    opacity: 0;
    transition: opacity 0.4s ease;
}

.card:hover::before {
    transform: scaleX(1);
}

.card:hover::after {
    opacity: 1;
}

.card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 30px 60px rgba(220, 20, 60, 0.2);
}

.card-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    border-radius: 25px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 20px;
    font-size: 2rem;
    color: white;
    box-shadow: 0 10px 30px rgba(220, 20, 60, 0.3);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
}

.card-icon::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255,255,255,0.3), transparent);
    transform: rotate(45deg);
    transition: all 0.6s ease;
    opacity: 0;
}

.card:hover .card-icon {
    transform: scale(1.1) rotate(5deg);
}

.card:hover .card-icon::before {
    animation: shine 0.6s ease-in-out;
}

@keyframes shine {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
    50% { opacity: 1; }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
}

.card h3 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
    font-size: 1.5rem;
    font-weight: 600;
    transition: color 0.3s ease;
}

.card:hover h3 {
    color: #DC143C;
}

.card p, .card ul {
    color: #666;
    margin-bottom: 15px;
    line-height: 1.6;
}

.card ul {
    padding-left: 20px;
}

.card li {
    margin-bottom: 8px;
    position: relative;
}

.card li::before {
    content: '✓';
    position: absolute;
    left: -20px;
    color: #DC143C;
    font-weight: bold;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
    gap: 20px;
    margin: 20px 0;
}

.stat-item {
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    padding: 25px 20px;
    border-radius: 20px;
    text-align: center;
    color: white;
    transform: scale(1);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
}

.stat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: all 0.6s ease;
}

.stat-item:hover {
    transform: scale(1.05) translateY(-5px);
    box-shadow: 0 15px 40px rgba(220, 20, 60, 0.4);
}

.stat-item:hover::before {
    left: 100%;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    display: block;
    margin-bottom: 5px;
}

.stat-label {
    font-size: 0.9rem;
    opacity: 0.95;
}

.contact-info {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(15px);
    border-radius: 25px;
    padding: 40px;
    /* REDUCED margin-top from 30px to 20px and added margin-bottom 0 */
    margin: 20px 0 0 0;
    box-shadow: 0 20px 40px rgba(220, 20, 60, 0.1);
    border: 1px solid rgba(220, 20, 60, 0.1);
    animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
}

.contact-info h2 {
    color: #DC143C;
    margin-bottom: 20px;
}

.contact-info h2 i {
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-right: 10px;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.contact-item {
    display: flex;
    align-items: center;
    padding: 20px;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.1));
    border-radius: 15px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(220, 20, 60, 0.1);
    position: relative;
    overflow: hidden;
}

.contact-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(220, 20, 60, 0.1), transparent);
    transition: all 0.6s ease;
}

.contact-item:hover {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(220, 20, 60, 0.2));
    transform: translateX(10px) translateY(-2px);
    box-shadow: 0 10px 25px rgba(220, 20, 60, 0.15);
}

.contact-item:hover::before {
    left: 100%;
}

.contact-item i {
    font-size: 1.5rem;
    color: #DC143C;
    margin-right: 15px;
    width: 30px;
    transition: transform 0.3s ease;
}

.contact-item:hover i {
    transform: scale(1.1);
}

.perangkat-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.perangkat-item {
    text-align: center;
    padding: 25px 20px;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.1));
    border-radius: 20px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    border: 1px solid rgba(220, 20, 60, 0.1);
    position: relative;
    overflow: hidden;
}

.perangkat-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C);
    transform: scaleX(0);
    transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    transform-origin: left;
}

.perangkat-item:hover::before {
    transform: scaleX(1);
}

.perangkat-item:hover {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(220, 20, 60, 0.2));
    transform: translateY(-8px);
    box-shadow: 0 15px 30px rgba(220, 20, 60, 0.15);
}

.perangkat-foto {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    margin: 0 auto 15px;
    background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #DC143C;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(220, 20, 60, 0.2);
}

.perangkat-item:hover .perangkat-foto {
    transform: scale(1.1);
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
}

.perangkat-foto img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
}

.perangkat-item h4 {
    color: #333;
    font-weight: 600;
    margin-bottom: 5px;
    transition: color 0.3s ease;
}

.perangkat-item:hover h4 {
    color: #DC143C;
}

.perangkat-item p {
    color: #666;
    font-size: 0.9rem;
}

.layanan-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 15px;
    margin-top: 20px;
}

.layanan-item {
    padding: 20px;
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.1), rgba(220, 20, 60, 0.1));
    border-radius: 15px;
    border-left: 4px solid #DC143C;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    overflow: hidden;
    border: 1px solid rgba(220, 20, 60, 0.1);
}

.layanan-item::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(220, 20, 60, 0.1), transparent);
    transition: all 0.6s ease;
}

.layanan-item:hover {
    background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(220, 20, 60, 0.2));
    transform: translateX(8px) translateY(-2px);
    box-shadow: 0 8px 20px rgba(220, 20, 60, 0.15);
}

.layanan-item:hover::before {
    left: 100%;
}

.layanan-item h4 {
    color: #333;
    margin-bottom: 8px;
    font-size: 1rem;
    font-weight: 600;
    transition: color 0.3s ease;
}

.layanan-item:hover h4 {
    color: #DC143C;
}

.layanan-item p {
    color: #666;
    font-size: 0.9rem;
    margin: 0;
}

.layanan-item i {
    color: #DC143C;
    margin-right: 8px;
}

/* Button Styles */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    padding: 12px 24px;
    background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
    color: white;
    text-decoration: none;
    border-radius: 50px;
    font-weight: 600;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
    position: relative;
    overflow: hidden;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
    transition: all 0.6s ease;
}

.btn:hover {
    transform: translateY(-3px) scale(1.05);
    box-shadow: 0 15px 40px rgba(220, 20, 60, 0.4);
    color: white;
    text-decoration: none;
}

.btn:hover::before {
    left: 100%;
}

/* Animation delays for stagger effect */
.card:nth-child(1) { animation-delay: 0.1s; }
.card:nth-child(2) { animation-delay: 0.2s; }
.card:nth-child(3) { animation-delay: 0.3s; }
.card:nth-child(4) { animation-delay: 0.4s; }
.card:nth-child(5) { animation-delay: 0.5s; }
.card:nth-child(6) { animation-delay: 0.6s; }

.perangkat-item:nth-child(odd) { animation-delay: 0.1s; }
.perangkat-item:nth-child(even) { animation-delay: 0.2s; }

.layanan-item:hover {
    border-left-color: #FF6B6B;
}

@media (max-width: 768px) {
    .tentang-container {
        padding: 10px;
    }
    .page-header {
        padding: 30px 20px;
    }
    .page-header h1 {
        font-size: 2rem;
    }
    .content-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .card {
        padding: 25px 20px;
    }
    .vision-mission {
        padding: 30px 20px;
    }
    .vision-mission-grid {
        grid-template-columns: 1fr;
    }
    .contact-info {
        padding: 30px 20px;
    }
    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    .section-title {
        font-size: 1.8rem;
    }
}

@media (max-width: 480px) {
    .page-header h1 {
        font-size: 1.8rem;
    }
    .card {
        padding: 20px 15px;
    }
    .vision-mission {
        padding: 25px 15px;
    }
    .contact-info {
        padding: 25px 15px;
    }
    .stats-grid {
        grid-template-columns: 1fr;
    }
    .stat-item {
        padding: 20px 15px;
    }
}
</style>

<div class="tentang-container">
    <div class="content-wrapper">
        <!-- Header Section -->
        <div class="page-header">
            <h1><i class="fas fa-info-circle"></i> Tentang {{ $profil->nama_nagari ?? 'Nagari Kami' }}</h1>
            <p>
                @if($profil && $profil->sejarah)
                    {{ Str::limit($profil->sejarah, 200) }}
                @else
                    Mengenal lebih dekat profil, visi, misi, dan layanan yang tersedia di Nagari kami. 
                    Komitmen kami adalah memberikan pelayanan terbaik untuk masyarakat dengan 
                    transparansi dan akuntabilitas.
                @endif
            </p>
        </div>

        <!-- Visi & Misi Section -->
        @if($profil && ($profil->visi || $profil->misi))
        <div class="vision-mission">
            <h2><i class="fas fa-eye"></i> Visi & Misi</h2>
            <div class="vision-mission-grid">
                <div class="vision">
                    <h3><i class="fas fa-bullseye"></i> Visi</h3>
                    <p>{{ $profil->visi ?? 'Visi belum diatur dalam sistem.' }}</p>
                </div>
                <div class="mission">
                    <h3><i class="fas fa-tasks"></i> Misi</h3>
                    <p>{{ $profil->misi ?? 'Misi belum diatur dalam sistem.' }}</p>
                </div>
            </div>
        </div>
        @endif

        <div class="content-grid">
            <!-- Profil Wilayah Card -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-map-marked-alt"></i>
                </div>
                <h3>Profil Wilayah</h3>
                @if($profil)
                    <p><strong>{{ $profil->nama_nagari }}</strong></p>
                    @if($profil->alamat)
                        <p><i class="fas fa-map-marker-alt"></i> {{ $profil->alamat }}</p>
                    @endif
                    @if($profil->luas_wilayah || $profil->jumlah_rt || $profil->jumlah_rw)
                        <ul style="list-style: none; padding: 0;">
                            @if($profil->luas_wilayah)
                                <li><i class="fas fa-expand-arrows-alt"></i> Luas: {{ $profil->luas_wilayah }}</li>
                            @endif
                            @if($profil->jumlah_rt)
                                <li><i class="fas fa-home"></i> RT: {{ $profil->jumlah_rt }}</li>
                            @endif
                            @if($profil->jumlah_rw)
                                <li><i class="fas fa-building"></i> RW: {{ $profil->jumlah_rw }}</li>
                            @endif
                        </ul>
                    @endif
                    @if($profil->batas_utara || $profil->batas_selatan || $profil->batas_timur || $profil->batas_barat)
                        <p><strong>Batas Wilayah:</strong></p>
                        <ul style="font-size: 0.9rem;">
                            @if($profil->batas_utara)<li>Utara: {{ $profil->batas_utara }}</li>@endif
                            @if($profil->batas_selatan)<li>Selatan: {{ $profil->batas_selatan }}</li>@endif
                            @if($profil->batas_timur)<li>Timur: {{ $profil->batas_timur }}</li>@endif
                            @if($profil->batas_barat)<li>Barat: {{ $profil->batas_barat }}</li>@endif
                        </ul>
                    @endif
                @else
                    <p>Data profil nagari belum diatur dalam sistem.</p>
                @endif
            </div>

            <!-- Statistik Penduduk Card -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3>Statistik Penduduk</h3>
                <div class="stats-grid">
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($statistikPenduduk['total']) }}</span>
                        <div class="stat-label">Total Penduduk</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($statistikPenduduk['total_kk']) }}</span>
                        <div class="stat-label">Kepala Keluarga</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($statistikPenduduk['pria']) }}</span>
                        <div class="stat-label">Laki-laki</div>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number">{{ number_format($statistikPenduduk['wanita']) }}</span>
                        <div class="stat-label">Perempuan</div>
                    </div>
                </div>
                @if($kelompokUmur['anak'] > 0 || $kelompokUmur['dewasa'] > 0 || $kelompokUmur['lansia'] > 0)
                    <p><strong>Berdasarkan Kelompok Usia:</strong></p>
                    <div class="stats-grid">
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($kelompokUmur['anak']) }}</span>
                            <div class="stat-label">Anak-anak</div>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($kelompokUmur['dewasa']) }}</span>
                            <div class="stat-label">Dewasa</div>
                        </div>
                        <div class="stat-item">
                            <span class="stat-number">{{ number_format($kelompokUmur['lansia']) }}</span>
                            <div class="stat-label">Lansia</div>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Perangkat Nagari Card -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-users-cog"></i>
                </div>
                <h3>Perangkat Nagari</h3>
                @if($perangkat->count() > 0)
                    <div class="perangkat-grid">
                        @foreach($perangkat->take(8) as $p)
                        <div class="perangkat-item">
                            <div class="perangkat-foto">
                                @if($p->foto && file_exists(public_path('storage/perangkat/foto/' . basename($p->foto))))
                                    <img src="{{ $p->foto }}" alt="{{ $p->nama }}">
                                @else
                                    <i class="fas fa-user"></i>
                                @endif
                            </div>
                            <h4>{{ $p->nama }}</h4>
                            <p>{{ $p->jabatan }}</p>
                        </div>
                        @endforeach
                    </div>
                    @if($perangkat->count() > 8)
                        <p style="text-align: center; margin-top: 15px; font-size: 0.9rem; color: #666;">
                            Dan {{ $perangkat->count() - 8 }} perangkat lainnya...
                        </p>
                    @endif
                @else
                    <p>Data perangkat nagari belum diatur dalam sistem.</p>
                @endif
            </div>

            <!-- Layanan Publik Card -->
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <h3>Layanan Publik</h3>
                @if($layanan->count() > 0)
                    <div class="layanan-grid">
                        @foreach($layanan->take(12) as $l)
                        <div class="layanan-item">
                            <h4>{{ $l->nama_layanan }}</h4>
                            @if($l->waktu_penyelesaian)
                                <p><i class="fas fa-clock"></i> {{ $l->waktu_penyelesaian }}</p>
                            @endif
                            @if($l->biaya)
                                <p><i class="fas fa-money-bill-alt"></i> {{ $l->biaya }}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @if($layanan->count() > 12)
                        <p style="text-align: center; margin-top: 15px;">
                            <a href="{{ route('layanan') }}" class="btn">
                                <i class="fas fa-plus"></i> Lihat Semua Layanan ({{ $layanan->count() }})
                            </a>
                        </p>
                    @endif
                @else
                    <p>Belum ada layanan yang tersedia dalam sistem.</p>
                @endif
            </div>

            <!-- Statistik Pekerjaan -->
            @if($statistikPekerjaan->count() > 0)
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-briefcase"></i>
                </div>
                <h3>Statistik Pekerjaan</h3>
                <div class="layanan-grid">
                    @foreach($statistikPekerjaan as $pekerjaan)
                    <div class="layanan-item">
                        <h4>{{ $pekerjaan->pekerjaan }}</h4>
                        <p>{{ number_format($pekerjaan->jumlah) }} orang</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Statistik Pendidikan -->
            @if($statistikPendidikan->count() > 0)
            <div class="card">
                <div class="card-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <h3>Statistik Pendidikan</h3>
                <div class="layanan-grid">
                    @foreach($statistikPendidikan as $pendidikan)
                    <div class="layanan-item">
                        <h4>{{ $pendidikan->pendidikan }}</h4>
                        <p>{{ number_format($pendidikan->jumlah) }} orang</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>

        <!-- Contact Info Section -->
        @if($profil && ($profil->alamat || $profil->telepon || $profil->email))
        <div class="contact-info">
            <h2 style="text-align: center; margin-bottom: 20px;">
                <i class="fas fa-address-book"></i> Informasi Kontak
            </h2>
            <div class="contact-grid">
                @if($profil->alamat)
                <div class="contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <div>
                        <strong>Alamat</strong><br>
                        {{ $profil->alamat }}
                        @if($profil->kode_pos)
                            <br>Kode Pos: {{ $profil->kode_pos }}
                        @endif
                    </div>
                </div>
                @endif
                @if($profil->telepon)
                <div class="contact-item">
                    <i class="fas fa-phone"></i>
                    <div>
                        <strong>Telepon</strong><br>
                        {{ $profil->telepon }}
                    </div>
                </div>
                @endif
                @if($profil->email)
                <div class="contact-item">
                    <i class="fas fa-envelope"></i>
                    <div>
                        <strong>Email</strong><br>
                        {{ $profil->email }}
                    </div>
                </div>
                @endif
                <div class="contact-item">
                    <i class="fas fa-clock"></i>
                    <div>
                        <strong>Jam Pelayanan</strong><br>
                        Senin - Jumat: 08:00 - 16:00<br>
                        Sabtu: 08:00 - 12:00
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced animation observer with stagger effect
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0) scale(1)';
                }, index * 100); // Stagger animation
            }
        });
    }, observerOptions);

    // Initialize cards with starting state
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(50px) scale(0.95)';
        card.style.transition = `all 0.8s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
        observer.observe(card);
    });

    // Animate page header
    const pageHeader = document.querySelector('.page-header');
    if (pageHeader) {
        pageHeader.style.opacity = '0';
        pageHeader.style.transform = 'translateY(30px)';
        setTimeout(() => {
            pageHeader.style.opacity = '1';
            pageHeader.style.transform = 'translateY(0)';
        }, 200);
    }

    // Animate vision mission
    const visionMission = document.querySelector('.vision-mission');
    if (visionMission) {
        const visionMissionObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';

                    // Animate vision and mission cards separately
                    const vision = entry.target.querySelector('.vision');
                    const mission = entry.target.querySelector('.mission');

                    if (vision) {
                        setTimeout(() => {
                            vision.style.opacity = '1';
                            vision.style.transform = 'translateX(0)';
                        }, 200);
                    }

                    if (mission) {
                        setTimeout(() => {
                            mission.style.opacity = '1';
                            mission.style.transform = 'translateX(0)';
                        }, 400);
                    }

                    visionMissionObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        visionMission.style.opacity = '0';
        visionMission.style.transform = 'translateY(30px)';

        // Initialize vision and mission cards
        const vision = visionMission.querySelector('.vision');
        const mission = visionMission.querySelector('.mission');

        if (vision) {
            vision.style.opacity = '0';
            vision.style.transform = 'translateX(-30px)';
            vision.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        }

        if (mission) {
            mission.style.opacity = '0';
            mission.style.transform = 'translateX(30px)';
            mission.style.transition = 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)';
        }

        visionMissionObserver.observe(visionMission);
    }

    // Enhanced counter animation for statistics
    function animateValue(element, start, end, duration) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);

            // Easing function for smoother animation
            const easeOutCubic = 1 - Math.pow(1 - progress, 3);
            const current = Math.floor(easeOutCubic * (end - start) + start);

            element.innerHTML = current.toLocaleString('id-ID');

            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        };
        window.requestAnimationFrame(step);
    }

    // Animate statistics when they come into view
    const statNumbers = document.querySelectorAll('.stat-number');
    const statObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting && !entry.target.classList.contains('animated')) {
                const endValue = parseInt(entry.target.textContent.replace(/[^\d]/g, ''));
                if (endValue > 0) {
                    // Add a small delay for each stat item
                    const delay = Array.from(statNumbers).indexOf(entry.target) * 200;
                    setTimeout(() => {
                        animateValue(entry.target, 0, endValue, 2000);
                        entry.target.classList.add('animated');
                    }, delay);
                }
            }
        });
    }, {
        threshold: 0.5
    });

    statNumbers.forEach(stat => {
        statObserver.observe(stat);
    });

    // Add hover effects for enhanced interactivity
    document.querySelectorAll('.card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });

        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Add loading animation for images
    document.querySelectorAll('.perangkat-foto img').forEach(img => {
        img.addEventListener('load', function() {
            this.style.opacity = '1';
            this.style.transform = 'scale(1)';
        });

        // Set initial state
        img.style.opacity = '0';
        img.style.transform = 'scale(0.8)';
        img.style.transition = 'all 0.3s ease';
    });

    // Animate contact items with stagger
    const contactItems = document.querySelectorAll('.contact-item');
    const contactObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry, index) => {
            if (entry.isIntersecting) {
                setTimeout(() => {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateX(0)';
                }, index * 100);
            }
        });
    }, observerOptions);

    contactItems.forEach((item, index) => {
        item.style.opacity = '0';
        item.style.transform = 'translateX(-30px)';
        item.style.transition = `all 0.6s cubic-bezier(0.4, 0, 0.2, 1) ${index * 0.1}s`;
        contactObserver.observe(item);
    });
});
</script>
@endsection