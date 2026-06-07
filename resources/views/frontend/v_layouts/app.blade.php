<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Barber Flow — @yield('title', 'Barbershop Modern')</title>

    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_univ_bsi.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@400;500;600;700&family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        :root {
            --bf-dark: #2d2d2d;       /* abu-abu tua  rgb(45,45,45) */
            --bf-darker: #232323;     /* blok gelap lebih dalam */
            --bf-gold: #800020;       /* merah maroon rgb(128,0,32) */
            --bf-gold-light: #a0283c; /* maroon terang rgb(160,40,60) */
            --bf-ice: #f8f8f8;        /* putih ice    rgb(248,248,248) */
        }
        body { font-family: 'Roboto', sans-serif; color: #2d2d2d; }
        h1,h2,h3,h4,h5,.font-head { font-family: 'Oswald', sans-serif; letter-spacing: .5px; }

        .navbar-bf { background: var(--bf-dark); }
        .navbar-bf .navbar-brand { font-family:'Oswald',sans-serif; font-weight:700; font-size:24px; color:#fff; letter-spacing:1px; }
        .navbar-bf .navbar-brand .gold { color: var(--bf-gold-light); }
        .navbar-bf .nav-link { color:#e6e6e6; font-weight:500; text-transform:uppercase; font-size:13px; letter-spacing:.5px; }
        .navbar-bf .nav-link:hover, .navbar-bf .nav-link.active { color: var(--bf-gold-light); }

        .btn-gold { background: var(--bf-gold); border:none; color: var(--bf-ice); font-weight:600; text-transform:uppercase; letter-spacing:.5px; }
        .btn-gold:hover { background: var(--bf-gold-light); color: var(--bf-ice); }
        .btn-outline-gold { border:2px solid var(--bf-gold); color: var(--bf-gold); font-weight:600; text-transform:uppercase; }
        .btn-outline-gold:hover { background: var(--bf-gold); color: var(--bf-ice); }

        .text-gold { color: var(--bf-gold) !important; }
        .bg-dark-bf { background: var(--bf-dark) !important; }

        .hero { position:relative; overflow:hidden; color:#fff; padding:120px 0; }
        .hero-slides { position:absolute; inset:0; z-index:0; }
        .hero-slide {
            position:absolute; inset:0; background-size:cover; background-position:center;
            opacity:0; animation: heroFade 30s infinite;
        }
        .hero-slide:nth-child(1){ animation-delay:0s; }
        .hero-slide:nth-child(2){ animation-delay:6s; }
        .hero-slide:nth-child(3){ animation-delay:12s; }
        .hero-slide:nth-child(4){ animation-delay:18s; }
        .hero-slide:nth-child(5){ animation-delay:24s; }
        @keyframes heroFade {
            0% { opacity:0; transform:scale(1.06); }
            3% { opacity:1; }
            17% { opacity:1; }
            20% { opacity:0; }
            100% { opacity:0; transform:scale(1); }
        }
        .hero::before {
            content:''; position:absolute; inset:0; z-index:1;
            background: linear-gradient(rgba(45,45,45,.72), rgba(45,45,45,.85));
        }
        .hero .container { position:relative; z-index:2; }
        .hero h1 { font-size:54px; font-weight:700; }
        @media (prefers-reduced-motion: reduce) {
            .hero-slide { animation:none; }
            .hero-slide:nth-child(1){ opacity:1; }
        }

        /* Image page headers + section backgrounds with dark overlay for readability */
        .page-header { position:relative; color:#fff; padding:56px 0; background-size:cover; background-position:center; }
        .page-header::before { content:''; position:absolute; inset:0; background: linear-gradient(rgba(45,45,45,.78), rgba(45,45,45,.90)); }
        .page-header .container { position:relative; z-index:1; }

        .section-bg { position:relative; background-size:cover; background-position:center; }
        .section-bg::before { content:''; position:absolute; inset:0; background: rgba(45,45,45,.92); }
        .section-bg > .container { position:relative; z-index:1; }
        .section-bg .section-title, .section-bg h2 { color:#fff; }
        .section-bg .text-muted { color: rgba(255,255,255,.7) !important; }
        .section-title { position:relative; display:inline-block; margin-bottom:8px; }
        .section-title:after { content:''; display:block; width:60px; height:3px; background:var(--bf-gold); margin:10px auto 0; }

        .card-bf { border:none; box-shadow:0 4px 18px rgba(0,0,0,.08); transition:transform .25s, box-shadow .25s; border-radius:10px; overflow:hidden; }
        .card-bf:hover { transform:translateY(-6px); box-shadow:0 10px 28px rgba(0,0,0,.16); }

        footer.bf-footer { background: var(--bf-darker); color: var(--bf-ice); padding:50px 0 20px; }
        footer.bf-footer a { color:#dcdcdc; text-decoration:none; }
        footer.bf-footer a:hover { color: var(--bf-gold-light); }

        .price-tag { color: var(--bf-gold); font-weight:700; font-family:'Oswald',sans-serif; }
    </style>
    @stack('styles')
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-bf sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('beranda') }}">
            <i class="bi bi-scissors text-gold"></i> BARBER<span class="gold">FLOW</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon" style="filter:invert(1);"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('beranda') ? 'active' : '' }}" href="{{ route('beranda') }}">Beranda</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('front.layanan*') ? 'active' : '' }}" href="{{ route('front.layanan') }}">Layanan</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('front.produk*') ? 'active' : '' }}" href="{{ route('front.produk') }}">Produk</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('front.barber') ? 'active' : '' }}" href="{{ route('front.barber') }}">Barber</a></li>
                <li class="nav-item"><a class="nav-link {{ request()->routeIs('front.galeri') ? 'active' : '' }}" href="{{ route('front.galeri') }}">Galeri</a></li>
            </ul>
            <ul class="navbar-nav">
                @if (session('customer'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('booking.cart') }}"><i class="bi bi-calendar-check"></i> Booking</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ Str::limit(session('customer')->nama, 12) }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="{{ route('customer.akun') }}"><i class="bi bi-person"></i> Akun Saya</a></li>
                            <li><a class="dropdown-item" href="{{ route('booking.cart') }}"><i class="bi bi-cart"></i> Keranjang Booking</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('customer.logout') }}" method="POST">@csrf
                                    <button class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="btn btn-gold btn-sm mt-1" href="{{ route('customer.login') }}"><i class="bi bi-box-arrow-in-right"></i> Login</a></li>
                @endif
            </ul>
        </div>
    </div>
</nav>

@yield('content')

<!-- FOOTER -->
<footer class="bf-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-4">
                <h4 class="text-white font-head"><i class="bi bi-scissors text-gold"></i> BARBER<span class="text-gold">FLOW</span></h4>
                <p class="small">Barbershop modern dengan layanan men's grooming premium. Tampil rapi, percaya diri, dan bergaya.</p>
                <div>
                    <a href="#" class="me-2"><i class="bi bi-facebook fs-5"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-instagram fs-5"></i></a>
                    <a href="#" class="me-2"><i class="bi bi-whatsapp fs-5"></i></a>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-white font-head">Menu</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="{{ route('front.layanan') }}">Layanan</a></li>
                    <li class="mb-2"><a href="{{ route('front.produk') }}">Produk</a></li>
                    <li class="mb-2"><a href="{{ route('front.barber') }}">Tim Barber</a></li>
                    <li class="mb-2"><a href="{{ route('front.galeri') }}">Galeri</a></li>
                </ul>
            </div>
            <div class="col-md-4 mb-4">
                <h5 class="text-white font-head">Kontak</h5>
                <ul class="list-unstyled small">
                    <li class="mb-2"><i class="bi bi-geo-alt text-gold"></i> Jl. Barber No. 17, Jakarta</li>
                    <li class="mb-2"><i class="bi bi-telephone text-gold"></i> 0812-3456-7890</li>
                    <li class="mb-2"><i class="bi bi-clock text-gold"></i> Setiap hari 09.00 - 21.00</li>
                </ul>
            </div>
        </div>
        <hr style="border-color:#333;">
        <p class="text-center small mb-0">&copy; {{ date('Y') }} Barber Flow. All rights reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if (session('success'))
<script>Swal.fire({icon:'success',title:'Berhasil',text:@json(session('success')),timer:2200,showConfirmButton:false});</script>
@endif
@if (session('error'))
<script>Swal.fire({icon:'error',title:'Oops',text:@json(session('error'))});</script>
@endif
@stack('scripts')
</body>
</html>
