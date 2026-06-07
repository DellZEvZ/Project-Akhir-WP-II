<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Barbershop Modern') — Barber Flow</title>
    <link rel="icon" type="image/png" href="{{ asset('image/icon_univ_bsi.png') }}">

    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    {{-- Bootstrap + Icons (dipakai halaman yang belum diredesain) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- Legacy styles (halaman lama) + Design System baru (menang karena dimuat terakhir) --}}
    <link href="{{ asset('css/legacy-frontend.css') }}" rel="stylesheet">
    <link href="{{ asset('css/supreme-theme.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="st-scope">

{{-- ===== TOP PROMO BAR ===== --}}
<div class="st-topbar">
    <i class="bi bi-truck"></i> Konsultasi grooming <strong>GRATIS</strong> &amp; pengiriman produk se-Jabodetabek — <strong>Tampil rapi tiap hari.</strong>
</div>

{{-- ===== NAVBAR ===== --}}
<header class="st-nav">
    <div class="st-container st-nav__inner">
        <a class="st-nav__brand" href="{{ route('beranda') }}">BARBER<span>FLOW</span></a>

        <nav>
            <ul class="st-nav__menu" id="stMenu">
                <li><a class="st-nav__link {{ request()->routeIs('beranda') ? 'is-active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                <li><a class="st-nav__link {{ request()->routeIs('front.layanan*') ? 'is-active' : '' }}" href="{{ route('front.layanan') }}">Layanan</a></li>
                <li><a class="st-nav__link {{ request()->routeIs('front.produk*') ? 'is-active' : '' }}" href="{{ route('front.produk') }}">Produk</a></li>
                <li><a class="st-nav__link {{ request()->routeIs('front.barber') ? 'is-active' : '' }}" href="{{ route('front.barber') }}">Barber</a></li>
                <li><a class="st-nav__link {{ request()->routeIs('front.galeri') ? 'is-active' : '' }}" href="{{ route('front.galeri') }}">Galeri</a></li>
            </ul>
        </nav>

        <div class="st-nav__actions">
            @if (session('customer'))
                <a class="st-nav__icon" href="{{ route('booking.cart') }}" title="Keranjang Booking"><i class="bi bi-bag"></i></a>
                <a class="st-nav__icon" href="{{ route('customer.akun') }}" title="Akun Saya"><i class="bi bi-person"></i></a>
            @else
                <x-button :href="route('customer.login')" size="sm"><i class="bi bi-person"></i> Login</x-button>
            @endif
            <button class="st-nav__toggle" id="stToggle" aria-label="Menu"><i class="bi bi-list"></i></button>
        </div>
    </div>
</header>

{{-- ===== KONTEN ===== --}}
<main>
    @yield('content')
</main>

{{-- ===== FOOTER ===== --}}
<footer class="st-footer">
    <div class="st-container">
        <div class="st-footer__grid">
            <div>
                <div class="st-footer__brand">BARBER<span>FLOW</span></div>
                <p class="mt-3" style="font-size:.875rem;max-width:34ch;">Barbershop modern &amp; katalog grooming pria. Layanan premium, produk perawatan rambut & jenggot pilihan.</p>
                <div class="st-footer__social">
                    <a href="#" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
                    <a href="#" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
                    <a href="#" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
                    <a href="#" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
                </div>
            </div>

            <div>
                <h4>Jelajah</h4>
                <ul class="st-footer__list">
                    <li><a href="{{ route('front.layanan') }}">Layanan</a></li>
                    <li><a href="{{ route('front.produk') }}">Produk</a></li>
                    <li><a href="{{ route('front.barber') }}">Tim Barber</a></li>
                    <li><a href="{{ route('front.galeri') }}">Galeri</a></li>
                </ul>
            </div>

            <div>
                <h4>Kontak</h4>
                <ul class="st-footer__list">
                    <li><i class="bi bi-geo-alt"></i> Jl. Barber No. 17, Jakarta</li>
                    <li><i class="bi bi-telephone"></i> 0812-3456-7890</li>
                    <li><i class="bi bi-clock"></i> Setiap hari 09.00–21.00</li>
                </ul>
            </div>

            <div>
                <h4>Newsletter</h4>
                <p style="font-size:.875rem;">Dapatkan tips grooming &amp; promo layanan langsung ke email Anda.</p>
                <form class="st-footer__news" onsubmit="return false;">
                    <x-input name="newsletter_email" type="email" placeholder="Email kamu" aria-label="Email" />
                    <x-button type="submit" size="sm">Daftar</x-button>
                </form>
            </div>
        </div>
        <div class="st-footer__bar">
            &copy; {{ date('Y') }} Barber Flow. Seluruh hak cipta dilindungi.
        </div>
    </div>
</footer>

{{-- ===== SCRIPTS ===== --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Toggle menu mobile
    document.getElementById('stToggle')?.addEventListener('click', () => {
        document.getElementById('stMenu')?.classList.toggle('is-open');
    });
</script>
@if (session('success'))
<script>Swal.fire({icon:'success',title:'Berhasil',text:@json(session('success')),timer:2200,showConfirmButton:false});</script>
@endif
@if (session('error'))
<script>Swal.fire({icon:'error',title:'Oops',text:@json(session('error'))});</script>
@endif
@stack('scripts')
</body>
</html>
