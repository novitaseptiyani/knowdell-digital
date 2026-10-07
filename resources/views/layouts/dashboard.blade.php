<!DOCTYPE html>
<html lang="id" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Beranda - Knowdell Digital')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/landing.css') }}">

    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        (function() {
            const saved = localStorage.getItem('theme') || 'light';
            document.documentElement.setAttribute('data-theme', saved);
        })();
    </script>
    <style>
        /* Global Bootstrap Pagination Style */
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
            gap: 0.25rem;
            justify-content: center;
        }
        .page-link {
            padding: 0.4rem 0.8rem;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            color: #475569;
            background: white;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 500;
            transition: all 0.2s ease;
        }
        .page-link:hover {
            background-color: #f8fafc;
            border-color: #cbd5e1;
        }
        .page-item.active .page-link {
            background-color: #3b82f6;
            color: white;
            border-color: #3b82f6;
        }
        .page-item.disabled .page-link {
            color: #cbd5e1;
            background: #f8fafc;
            pointer-events: none;
        }
    </style>
</head>

{{-- .dash-body = gradient background + flex column layout --}}
<body class="dash-body">

    @php
        $authUser    = Auth::guard('staff')->check()
            ? Auth::guard('staff')->user()
            : Auth::guard('web')->user();
        $isStaff     = Auth::guard('staff')->check();
        $isAdmin     = $isStaff && $authUser?->role === 'admin';
        $isCounselor = $isStaff && $authUser?->role === 'counselor';

        $homeRoute    = $isAdmin
            ? route('admin.dashboard')
            : ($isCounselor ? route('counselor.dashboard') : route('dashboard'));

        $profileRoute = $isAdmin
            ? route('admin.profile')
            : ($isCounselor ? route('counselor.profile') : route('profile.edit'));
    @endphp

    <nav class="dash-nav">
        <a href="{{ $homeRoute }}" class="logo">
            <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA" style="height: 36px; object-fit: contain;">
            <span class="logo-text">UKRIDA</span>
        </a>

        <div class="user-menu">
            <button id="dark-mode-toggle" onclick="toggleDarkMode()" class="dark-toggle-btn" title="Mode Gelap">
                <i class="fa-solid fa-moon"></i>
            </button>

            <div class="user-info">
                <div class="user-name">{{ explode(' ', $authUser?->full_name ?? '')[0] }}</div>
            </div>

            <a href="{{ $profileRoute }}" class="user-avatar">
                <i class="fa-regular fa-user"></i>
            </a>

            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                </button>
            </form>
        </div>
    </nav>

    {{-- .dashboard-main = flex:1 + padding + max-width wrapper --}}
    <main class="dashboard-main">
        @yield('content')
    </main>

    @include('components.footer')

    <script>
        function toggleDarkMode() {
            const current = document.documentElement.getAttribute('data-theme');
            const next    = current === 'dark' ? 'light' : 'dark';
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

        document.addEventListener('DOMContentLoaded', () => updateIcon(localStorage.getItem('theme') || 'light'));
    </script>

</body>
</html>
