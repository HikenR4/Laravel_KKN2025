<!-- Footer Component - layouts/footer.blade.php -->
<style>
    /* Footer Styles */
    .footer {
        background: linear-gradient(135deg, #333 0%, #444 50%, #555 100%);
        color: #F5F5F5;
        padding: 3rem 0 1rem;
        position: relative;
    }

    .footer::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><circle cx="200" cy="100" r="60" fill="%23FF6B6B" opacity="0.03"/><circle cx="1000" cy="200" r="80" fill="%23DC143C" opacity="0.02"/></svg>');
    }

    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        position: relative;
        z-index: 2;
    }

    .footer-section h3 {
        color: #FF6B6B;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .footer-section p {
        line-height: 1.6;
        margin-bottom: 1rem;
        color: #DDD;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.5rem;
    }

    .footer-links a {
        color: #F5F5F5;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
    }

    .footer-links a::before {
        content: '';
        position: absolute;
        bottom: -2px;
        left: 0;
        width: 0;
        height: 1px;
        background: #FF6B6B;
        transition: width 0.3s ease;
    }

    .footer-links a:hover {
        color: #FF6B6B;
        transform: translateX(5px);
    }

    .footer-links a:hover::before {
        width: 100%;
    }

    .social-links {
        display: flex;
        gap: 1rem;
        margin-top: 1rem;
    }

    .social-links a {
        width: 45px;
        height: 45px;
        background: linear-gradient(135deg, #666, #555);
        color: #F5F5F5;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .social-links a::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(135deg, #FF6B6B, #DC143C);
        border-radius: 50%;
        transform: scale(0);
        transition: transform 0.3s ease;
    }

    .social-links a:hover {
        transform: translateY(-3px) scale(1.05);
    }

    .social-links a:hover::before {
        transform: scale(1);
    }

    .social-links a i {
        position: relative;
        z-index: 2;
        transition: color 0.3s ease;
    }

    .social-links a:hover i {
        color: white;
    }

    .footer-bottom {
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid rgba(255, 107, 107, 0.3);
        text-align: center;
        color: #CCC;
        position: relative;
        z-index: 2;
    }

    .footer-info {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }

    .footer-info-item {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        color: #DDD;
    }

    .footer-info-item i {
        color: #FF6B6B;
        margin-top: 0.2rem;
        min-width: 16px;
    }

    /* Responsive Footer */
    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 2rem;
        }

        .social-links {
            justify-content: center;
        }
    }
</style>

<footer id="kontak" class="footer">
    <div class="footer-container">
        <div class="footer-section">
            <h3>Nagari Mungo</h3>
            <p>Portal digital resmi Nagari Mungo yang menghadirkan layanan publik modern dan terintegrasi untuk kemudahan masyarakat.</p>
            <div class="social-links">
                <a href="#" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </a>
                <a href="#" title="Instagram">
                    <i class="fab fa-instagram"></i>
                </a>
                <a href="#" title="Twitter">
                    <i class="fab fa-twitter"></i>
                </a>
                <a href="#" title="YouTube">
                    <i class="fab fa-youtube"></i>
                </a>
            </div>
        </div>

        <div class="footer-section">
            <h3>Layanan</h3>
            <ul class="footer-links">
                <li><a href="{{ route('layanan') }}">Permohonan Surat</a></li>
                <li><a href="{{ route('profil.data-wilayah') }}">Data Kependudukan</a></li>
                <li><a href="{{ route('agenda') }}">Agenda Kegiatan</a></li>
                <li><a href="{{ route('pengumuman') }}">Pengumuman</a></li>
                <li><a href="{{ route('berita') }}">Berita Terkini</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Informasi</h3>
            <ul class="footer-links">
                <li><a href="{{ route('profil.sejarah') }}">Sejarah Nagari</a></li>
                <li><a href="{{ route('profil.perangkat-nagari') }}">Perangkat Nagari</a></li>
                <li><a href="{{ route('profil.visi-misi') }}">Visi & Misi</a></li>
                <li><a href="{{ route('profil.data-wilayah') }}">Data Wilayah</a></li>
                <li><a href="{{ route('tentang') }}">Tentang Portal</a></li>
            </ul>
        </div>

        <div class="footer-section">
            <h3>Kontak</h3>
            <div class="footer-info">
                <div class="footer-info-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span>Jl. Raya Payakumbuh - Lintau KM.8 Pakan Sabtu, Nagari Mungo, Kecamatan Luak, Kabupaten Lima Puluh Kota, 26261</span>
                </div>
                <div class="footer-info-item">
                    <i class="fas fa-phone"></i>
                    <span>(0752) 759249</span>
                </div>
                <div class="footer-info-item">
                    <i class="fas fa-envelope"></i>
                    <span>nagarimungo05@gmail.com</span>
                </div>
                <div class="footer-info-item">
                    <i class="fas fa-clock"></i>
                    <span>Senin - Jumat: 08:00 - 16:00 WIB</span>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Nagari Mungo. Semua hak cipta dilindungi undang-undang.</p>
    </div>
</footer>
