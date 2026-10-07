@extends('layouts.landing')

@section('title', 'Masuk - Knowdell Digital')

@section('content')
    <section class="auth-section">
        <div class="auth-card animate-fade">
            <div class="auth-header">
                <h2>Selamat Datang Kembali</h2>
                <p>Masukkan email dan kata sandi kamu untuk melanjutkan</p>
            </div>

            @if (session('status'))
                <div class="auth-status-success">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" class="form-control" type="email" name="email"
                        value="{{ old('email') }}" required autofocus autocomplete="username">
                    @error('email')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">Kata Sandi</label>
                    <div class="password-field">
                        <input id="password" class="form-control form-control--password"
                            type="password" name="password" required
                            autocomplete="current-password">
                        <span id="togglePassword" class="password-toggle">
                            <i class="fa-regular fa-eye-slash" id="eyeIcon"></i>
                        </span>
                    </div>
                    @error('password')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <p id="password-hint" class="password-hint">
                        <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i>
                        Minimal 8 karakter. Harus kombinasi dari huruf dan angka.
                    </p>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-dark btn-auth-submit">M A S U K</button>
                </div>

                <div class="auth-links">
                    Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const password       = document.querySelector('#password');
        const eyeIcon        = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function () {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            eyeIcon.classList.toggle('fa-eye-slash', type === 'password');
            eyeIcon.classList.toggle('fa-eye',       type === 'text');
        });

        password.addEventListener('input', function () {
            document.getElementById('password-hint').style.display =
                this.value.length > 0 ? 'block' : 'none';
        });
    </script>
@endsection
