<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">
    <style>
        body {
            background: radial-gradient(circle at 10% 20%, rgba(30, 64, 175, 0.45) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(30, 64, 175, 0.45) 0%, transparent 40%),
                #e0f2fe;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Inter', sans-serif;
        }
        .error-container {
            text-align: center;
            padding: 3rem;
            max-width: 600px;
        }
        .error-code {
            font-size: 8rem;
            font-weight: 900;
            color: #2563eb;
            line-height: 1;
            margin-bottom: 1rem;
            letter-spacing: -4px;
        }
        .error-icon {
            font-size: 4rem;
            color: #2563eb;
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }
        .error-title {
            font-size: 2rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 1rem;
        }
        .error-desc {
            color: #64748b;
            font-size: 1.1rem;
            font-weight: 500;
            margin-bottom: 2.5rem;
            line-height: 1.6;
        }
        .btn-home {
            display: inline-flex;
            align-items: center;
            gap: 0.75rem;
            background: #2563eb;
            color: white;
            padding: 1rem 2rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            box-shadow: 0 8px 25px rgba(37,99,235,0.35);
            transition: all 0.2s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .btn-home:hover {
            transform: scale(1.05);
            box-shadow: 0 12px 30px rgba(37,99,235,0.5);
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <i class="fa-solid fa-map-location-dot"></i>
        </div>
        <div class="error-code">404</div>
        <h1 class="error-title">Halaman Tidak Ditemukan</h1>
        <p class="error-desc">
            Maaf, halaman yang kamu cari tidak ada atau mungkin sudah dipindahkan.
            Yuk kembali ke halaman utama!
        </p>
        <a href="{{ url('/') }}" class="btn-home">
            <i class="fa-solid fa-house"></i> Kembali ke Beranda
        </a>
    </div>
</body>
</html>