<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#667eea">
    <title>BARBERFLOW - Barbershop Management System</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        html, body { width: 100%; height: 100%; }
        body { font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Arial, sans-serif; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: #333; display: flex; flex-direction: column; min-height: 100vh; }
        header { background: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1); position: sticky; top: 0; z-index: 100; }
        nav { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; width: 100%; }
        .logo { font-size: 1.5rem; font-weight: 700; color: #667eea; white-space: nowrap; }
        .nav-toggle { display: none; background: none; border: none; cursor: pointer; font-size: 1.5rem; color: #667eea; }
        .nav-links { display: flex; gap: 2rem; align-items: center; }
        .nav-links a { text-decoration: none; color: #333; font-weight: 500; font-size: 0.95rem; transition: color 0.3s; }
        .nav-links a:hover { color: #667eea; }
        .auth-buttons { display: flex; gap: 1rem; }
        .btn { padding: 0.6rem 1.2rem; border-radius: 6px; text-decoration: none; font-weight: 600; border: none; cursor: pointer; font-size: 0.9rem; transition: all 0.3s; }
        .btn-primary { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; }
        .btn-primary:hover { opacity: 0.9; transform: translateY(-2px); }
        .btn-secondary { border: 2px solid #667eea; color: #667eea; background: transparent; }
        .btn-secondary:hover { background: rgba(102, 126, 234, 0.1); }
        .btn-light { background: white; color: #667eea; }
        .btn-light:hover { background: #f0f0f0; }
        .container { flex: 1; max-width: 1200px; margin: 0 auto; padding: 2rem 1.5rem; width: 100%; }
        .hero { display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; align-items: center; margin-bottom: 4rem; }
        .hero-content h1 { font-size: 2.8rem; color: white; margin-bottom: 1rem; font-weight: 800; }
        .hero-content p { font-size: 1rem; color: rgba(255,255,255,0.9); margin-bottom: 1.5rem; line-height: 1.6; }
        .hero-buttons { display: flex; gap: 1rem; flex-wrap: wrap; }
        .hero-image { background: rgba(255,255,255,0.1); border-radius: 1rem; padding: 2rem; text-align: center; color: white; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 2rem; margin: 4rem 0; }
        .feature-card { background: white; padding: 1.5rem; border-radius: 1rem; box-shadow: 0 4px 12px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .feature-card:hover { transform: translateY(-5px); box-shadow: 0 8px 16px rgba(0,0,0,0.15); }
        .feature-icon { font-size: 2.5rem; margin-bottom: 1rem; }
        .feature-card h3 { font-size: 1.2rem; margin-bottom: 0.8rem; color: #333; }
        .feature-card p { color: #666; font-size: 0.9rem; }
        .modules { background: white; padding: 2rem 1.5rem; border-radius: 1rem; margin: 3rem 0; }
        .modules h2 { font-size: 2rem; margin-bottom: 2rem; color: #333; text-align: center; }
        .module-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; }
        .module-item { padding: 1.5rem; border-left: 4px solid #667eea; background: #f8f9ff; }
        .module-item h4 { color: #667eea; margin-bottom: 1rem; font-size: 1.1rem; }
        .module-item ul { list-style: none; }
        .module-item li { padding: 0.4rem 0; color: #555; position: relative; padding-left: 1.5rem; font-size: 0.9rem; }
        .module-item li:before { content: "✓"; position: absolute; left: 0; color: #667eea; font-weight: bold; }
        .benefits { background: linear-gradient(135deg, rgba(102,126,234,0.1) 0%, rgba(118,75,162,0.1) 100%); padding: 2rem 1.5rem; border-radius: 1rem; margin: 3rem 0; }
        .benefits h2 { font-size: 2rem; margin-bottom: 2rem; color: #333; text-align: center; }
        .benefits-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 1.5rem; }
        .benefit-number { font-size: 2.5rem; font-weight: 700; color: #667eea; }
        .benefit-text { color: #555; margin-top: 0.5rem; font-weight: 600; font-size: 0.9rem; }
        footer { background: white; padding: 2rem 1.5rem; text-align: center; border-top: 1px solid #eee; margin-top: 4rem; color: #666; }
        footer p { font-size: 0.9rem; margin: 0.5rem 0; }
        h2 { font-size: 2rem; margin: 3rem 0 2rem; color: white; text-align: center; }

        /* Mobile Navigation Styles */
        .mobile-nav { display: none; }
        .mobile-nav.active { display: flex; position: absolute; top: 70px; left: 0; right: 0; background: white; flex-direction: column; padding: 1rem; box-shadow: 0 4px 8px rgba(0,0,0,0.1); z-index: 99; }
        .mobile-nav a { padding: 0.8rem; border-bottom: 1px solid #eee; color: #333; text-decoration: none; font-weight: 500; }
        .mobile-nav a:hover { background: #f5f5f5; }
        .mobile-nav .auth-buttons { flex-direction: column; gap: 0.5rem; }
        .mobile-nav .btn { width: 100%; text-align: center; }

        /* Tablet & Mobile Responsive */
        @media (max-width: 992px) {
            nav { padding: 1rem 1rem; }
            .logo { font-size: 1.3rem; }
            .nav-links { gap: 1.5rem; }
            .auth-buttons { gap: 0.5rem; }
            .btn { padding: 0.5rem 1rem; font-size: 0.85rem; }
            .hero { gap: 1.5rem; }
            .hero-content h1 { font-size: 2.2rem; }
        }

        @media (max-width: 768px) {
            nav { padding: 0.8rem 1rem; }
            .logo { font-size: 1.2rem; }
            .nav-toggle { display: flex; z-index: 101; }
            .nav-links { display: none; }
            .auth-buttons { display: none; }
            .container { padding: 1.5rem 1rem; }
            .hero { grid-template-columns: 1fr; gap: 2rem; margin-bottom: 2rem; }
            .hero-content h1 { font-size: 2rem; }
            .hero-content p { font-size: 0.95rem; margin-bottom: 1rem; }
            .hero-image { padding: 1.5rem; font-size: 0.9rem; }
            .hero-buttons { gap: 0.5rem; flex-wrap: wrap; }
            .btn { padding: 0.6rem 1rem; font-size: 0.85rem; min-height: 40px; min-width: 40px; }
            .features { gap: 1.5rem; margin: 2rem 0; }
            .feature-card { padding: 1.2rem; }
            .feature-icon { font-size: 2rem; }
            .feature-card h3 { font-size: 1rem; }
            .feature-card p { font-size: 0.85rem; }
            .modules { padding: 1.5rem 1rem; margin: 2rem 0; }
            .modules h2 { font-size: 1.5rem; margin-bottom: 1.5rem; }
            .module-grid { gap: 1rem; }
            .module-item { padding: 1.2rem; }
            .module-item h4 { font-size: 1rem; margin-bottom: 0.8rem; }
            .module-item li { font-size: 0.85rem; }
            .benefits { padding: 1.5rem 1rem; margin: 2rem 0; }
            .benefits h2 { font-size: 1.5rem; margin-bottom: 1.5rem; }
            .benefits-grid { gap: 1rem; }
            .benefit-number { font-size: 2rem; }
            .benefit-text { font-size: 0.8rem; }
            h2 { font-size: 1.5rem; margin: 2rem 0 1.5rem; }
            footer { padding: 1.5rem 1rem; }
            footer p { font-size: 0.8rem; }
        }

        @media (max-width: 480px) {
            nav { padding: 0.75rem 1rem; }
            .logo { font-size: 1rem; }
            .container { padding: 1rem 0.75rem; }
            .hero-content h1 { font-size: 1.6rem; font-weight: 700; line-height: 1.2; }
            .hero-content p { font-size: 0.85rem; margin-bottom: 1rem; }
            .hero-buttons { gap: 0.4rem; }
            .btn { padding: 0.5rem 0.8rem; font-size: 0.8rem; min-height: 36px; }
            .feature-card { padding: 1rem; }
            .feature-icon { font-size: 1.8rem; }
            .feature-card h3 { font-size: 0.95rem; }
            .feature-card p { font-size: 0.8rem; }
            .modules h2 { font-size: 1.3rem; }
            .module-item { padding: 1rem; }
            .module-item h4 { font-size: 0.95rem; }
            .module-item li { font-size: 0.8rem; padding-left: 1.2rem; }
            .benefits h2 { font-size: 1.3rem; }
            .benefit-number { font-size: 1.8rem; }
            .benefit-text { font-size: 0.75rem; }
            h2 { font-size: 1.3rem; margin: 1.5rem 0 1rem; }
            footer { padding: 1rem 0.75rem; }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">BARBERFLOW</div>
            <button class="nav-toggle" id="navToggle">☰</button>
            <div class="nav-links">
                <a href="#features">Fitur</a>
                <a href="#modules">Modul</a>
                <a href="#benefits">Manfaat</a>
            </div>
            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endauth
            </div>
        </nav>
        <div class="mobile-nav" id="mobileNav">
            <a href="#features">Fitur</a>
            <a href="#modules">Modul</a>
            <a href="#benefits">Manfaat</a>
            <div class="auth-buttons">
                @auth
                    <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    <div class="container">
        <div class="hero">
            <div class="hero-content">
                <h1>BARBERFLOW</h1>
                <p><strong>Barbershop Management System</strong></p>
                <p>Solusi Sistem Informasi Terpadu untuk Manajemen Barbershop Modern</p>
                <p>Aplikasi mobile-first dirancang khusus untuk mengelola kepegawaian dan inventaris rumah sakit dengan efisien dan real-time.</p>
                <div class="hero-buttons">
                    <a href="{{ route('login') }}" class="btn btn-light">Masuk Sekarang</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="btn btn-primary">Daftar Akun</a>
                    @endif
                </div>
            </div>
            <div class="hero-image">
                <div style="font-size: 4rem;">📱</div>
                <p>Platform Mobile-First untuk Rumah Sakit</p>
            </div>
        </div>

        <section id="features">
            <h2>Fitur Unggulan</h2>
            <div class="features">
                <div class="feature-card">
                    <div class="feature-icon">🔐</div>
                    <h3>Keamanan Terjamin</h3>
                    <p>Enkripsi end-to-end dan autentikasi biometrik (fingerprint/face recognition).</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📍</div>
                    <h3>GPS Tracking</h3>
                    <p>Absensi digital dengan GPS dan selfie verification yang akurat.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Dashboard Real-Time</h3>
                    <p>Pantau produktivitas pegawai dan inventaris dari smartphone.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Mobile-First Design</h3>
                    <p>Interface intuitif dan responsif untuk smartphone.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔄</div>
                    <h3>Sinkronisasi Cloud</h3>
                    <p>Data real-time dengan mode offline terbatas.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🔔</div>
                    <h3>Notifikasi Push</h3>
                    <p>Pengingat jadwal shift dan alert inventaris.</p>
                </div>
            </div>
        </section>

        <section id="modules" class="modules">
            <h2>Modul Sistem</h2>
            <div class="module-grid">
                <div class="module-item">
                    <h4>Modul Kepegawaian</h4>
                    <ul>
                        <li>Manajemen Data Pegawai</li>
                        <li>Absensi Digital dengan GPS</li>
                        <li>Pengelolaan Jadwal Shift</li>
                        <li>Monitoring Kinerja</li>
                        <li>Slip Gaji Digital</li>
                        <li>Tracking Pelatihan & Sertifikasi</li>
                    </ul>
                </div>
                <div class="module-item">
                    <h4>Modul Inventaris</h4>
                    <ul>
                        <li>Pencatatan Aset dengan Kamera</li>
                        <li>Scanning Barcode/QR Code</li>
                        <li>Manajemen Pengadaan</li>
                        <li>Reminder Pemeliharaan</li>
                        <li>Monitoring Stok Barang</li>
                        <li>Alert Otomatis Barang Habis</li>
                    </ul>
                </div>
                <div class="module-item">
                    <h4>Modul Pelaporan</h4>
                    <ul>
                        <li>Dashboard Analytics</li>
                        <li>Laporan Kepegawaian</li>
                        <li>Laporan Inventaris</li>
                        <li>Export Data Lengkap</li>
                        <li>Historical Data Tracking</li>
                        <li>Audit Trail Komprehensif</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="benefits" class="benefits">
            <h2>Manfaat BARBERFLOW</h2>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <div class="benefit-number">70%</div>
                    <div class="benefit-text">Penghematan Waktu</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-number">100%</div>
                    <div class="benefit-text">Akurasi Data Real-Time</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-number">∞</div>
                    <div class="benefit-text">Skalabilitas Tanpa Batas</div>
                </div>
                <div class="benefit-item">
                    <div class="benefit-number">24/7</div>
                    <div class="benefit-text">Akses Kapan Saja</div>
                </div>
            </div>
        </section>
    </div>

    <footer>
        <p>&copy; 2024 BARBERFLOW - Barbershop Management System</p>
        <p>Dirancang untuk meningkatkan efisiensi dan kualitas pelayanan kesehatan.</p>
    </footer>

    <script>
        // Mobile Navigation Toggle
        const navToggle = document.getElementById('navToggle');
        const mobileNav = document.getElementById('mobileNav');

        navToggle.addEventListener('click', function() {
            mobileNav.classList.toggle('active');
        });

        // Close mobile menu when a link is clicked
        const mobileNavLinks = mobileNav.querySelectorAll('a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileNav.classList.remove('active');
            });
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInsideNav = mobileNav.contains(event.target);
            const isClickToggle = navToggle.contains(event.target);

            if (!isClickInsideNav && !isClickToggle && mobileNav.classList.contains('active')) {
                mobileNav.classList.remove('active');
            }
        });
    </script>
</body>
</html>
