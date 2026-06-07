<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toko Online</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f6fa;
            margin: 0;
            padding: 0;
        }
        nav {
            background-color: #2f3640;
            color: #fff;
            padding: 10px 20px;
        }
        nav a {
            color: #f5f6fa;
            text-decoration: none;
            margin-right: 15px;
            font-weight: bold;
        }
        nav a:hover {
            text-decoration: underline;
        }
        main {
            padding: 20px;
        }
        footer {
            background-color: #2f3640;
            color: #f5f6fa;
            text-align: center;
            padding: 10px;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

    <nav>
        <a href="{{ route('backend.beranda') }}">Beranda</a>
        <a href="#">User</a>
        <a href="#">Keluar</a>
    </nav>

    <main>
        <div class="container">
            @yield('content')
        </div>
    </main>

    <footer>
        &copy; {{ date('Y') }} TokoOnline. All Rights Reserved.
    </footer>

</body>
</html>
