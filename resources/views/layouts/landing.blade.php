<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Knowdell Digital - Tes Minat Bakat')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Custom Landing CSS -->
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <!-- Alpine.js for Tabs -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        const saved = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', saved);
    </script>
</head>

<body>

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    <script>
        function toggleDarkMode() {
            const current = document.documentElement.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            document.documentElement.setAttribute('data-theme', next);
            localStorage.setItem('theme', next);
            updateIcon(next);
        }

        function updateIcon(theme) {
            const btn = document.getElementById('dark-mode-toggle');
            if (!btn) return;
            btn.innerHTML = theme === 'dark'
                ? '<i class="fa-solid fa-sun"></i>'
                : '<i class="fa-solid fa-moon"></i>';
            btn.title = theme === 'dark' ? 'Mode Terang' : 'Mode Gelap';
        }

        updateIcon(localStorage.getItem('theme') || 'light');
    </script>
</body>

</html>
