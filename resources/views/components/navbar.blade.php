<nav class="navbar animate-fade" x-data="{ open: false }">
    <a href="/" class="logo">
        <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA" style="height: 36px; object-fit: contain;">
        <span class="logo-text">UKRIDA</span>
    </a>

    {{-- Desktop nav links --}}
    <div class="nav-links">
        <button id="dark-mode-toggle" onclick="toggleDarkMode()" class="dark-toggle-btn" title="Mode Gelap">
            <i class="fa-solid fa-moon"></i>
        </button>
        @auth
            <a href="{{ route('dashboard') }}" class="btn-primary">
                <i class="fa-solid fa-house-chimney" style="margin-right: 0.5rem;"></i> Kembali ke Beranda
            </a>
        @else
            <a href="{{ route('login') }}" class="nav-link">Masuk</a>
            <a href="{{ route('register') }}" class="btn-primary">Daftar Sekarang</a>
        @endauth
    </div>

    {{-- Mobile: dark mode toggle + hamburger --}}
    <div class="nav-mobile-controls">
        <button onclick="toggleDarkMode()" class="dark-toggle-btn" title="Mode Gelap">
            <i class="fa-solid fa-moon"></i>
        </button>
        <button @click="open = !open" class="hamburger-btn" :aria-expanded="open.toString()">
            <i class="fa-solid" :class="open ? 'fa-xmark' : 'fa-bars'"></i>
        </button>
    </div>

    {{-- Mobile dropdown menu --}}
    <div class="nav-mobile-menu" x-show="open" x-transition @click.outside="open = false">
        @auth
            <a href="{{ route('dashboard') }}" class="nav-mobile-link nav-mobile-link--primary">
                <i class="fa-solid fa-house-chimney"></i> Kembali ke Beranda
            </a>
        @else
            <a href="{{ route('login') }}" class="nav-mobile-link">Masuk</a>
            <a href="{{ route('register') }}" class="nav-mobile-link nav-mobile-link--primary">Daftar Sekarang</a>
        @endauth
    </div>
</nav>
