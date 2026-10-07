@extends('layouts.landing')

@section('title', 'Daftar - Knowdell Digital')

@section('content')
    <section class="auth-section">
        <div class="auth-card register-card animate-fade">
            <div class="auth-header">
                <h2>Buat Akun Baru</h2>
                <p>Lengkapi data diri kamu di bawah ini untuk mendaftar</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                {{-- Row 1: Nama Lengkap & Email --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="full_name" class="form-label">Nama Lengkap</label>
                        <input id="full_name" class="form-control" type="text" name="full_name"
                            value="{{ old('full_name') }}" required autofocus autocomplete="name">
                        @error('full_name') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="email" class="form-label">Email</label>
                        <input id="email" class="form-control" type="email" name="email"
                            value="{{ old('email') }}" required autocomplete="username">
                        @error('email') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Row 2: Nomor Ponsel & Tanggal Lahir --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="phone" class="form-label">Nomor Ponsel</label>
                        <input id="phone" class="form-control" type="text" name="phone"
                            value="{{ old('phone') }}" required autocomplete="tel">
                        @error('phone') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="birth_date" class="form-label">Tanggal Lahir</label>
                        <input id="birth_date" class="form-control" type="date" name="birth_date"
                            value="{{ old('birth_date') }}" required lang="id">
                        @error('birth_date') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Row 3: Jenis Kelamin & Status --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="gender" class="form-label">Jenis Kelamin</label>
                        <select id="gender" class="form-control" name="gender" required>
                            <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Pilih Jenis Kelamin</option>
                            <option value="Laki-laki" {{ old('gender') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                        @error('gender') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group">
                        <label for="status" class="form-label">Status</label>
                        <select id="status" class="form-control" name="status" required>
                            <option value="" disabled {{ old('status') ? '' : 'selected' }}>Pilih Status</option>
                            <option value="Pelajar"   {{ old('status') == 'Pelajar'   ? 'selected' : '' }}>Pelajar</option>
                            <option value="Mahasiswa" {{ old('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Umum"      {{ old('status') == 'Umum'      ? 'selected' : '' }}>Umum</option>
                        </select>
                        @error('status') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Row 4: Instansi --}}
                <div class="form-group">
                    <label for="institution" class="form-label">Instansi</label>
                    <input id="institution" class="form-control" type="text" name="institution"
                        value="{{ old('institution') }}" required placeholder="Sekolah/Universitas/Kantor">
                    @error('institution') <div class="text-danger">{{ $message }}</div> @enderror
                </div>

                {{-- Row 5: Kata Sandi & Konfirmasi --}}
                <div class="form-row">
                    <div class="form-group">
                        <label for="password" class="form-label">Kata Sandi</label>
                        <input id="password" class="form-control" type="password" name="password"
                            required autocomplete="new-password">
                        @error('password') <div class="text-danger">{{ $message }}</div> @enderror
                        <p id="password-hint" class="password-hint">
                            <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i>
                            Minimal 8 karakter. Harus kombinasi dari huruf dan angka.
                        </p>
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation" class="form-label">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" class="form-control" type="password"
                            name="password_confirmation" required autocomplete="new-password">
                        @error('password_confirmation') <div class="text-danger">{{ $message }}</div> @enderror
                    </div>
                </div>

                {{-- Consent --}}
                <div class="auth-consent-box">
                    <label class="form-check">
                        <input type="checkbox" required class="form-check-input auth-consent-checkbox">
                        <span class="auth-consent-text">
                            Dengan mendaftar, saya setuju bahwa data diri dan hasil asesmen saya akan dikelola
                            oleh konselor untuk kepentingan bimbingan dan konseling sesuai
                            <a href="{{ route('privacy-policy') }}" target="_blank">Kebijakan Privasi</a>
                            platform ini.
                        </span>
                    </label>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn-dark btn-auth-submit">D A F T A R</button>
                </div>

                <div class="auth-links">
                    Sudah punya akun? <a href="{{ route('login') }}">Masuk di sini</a>
                </div>
            </form>
        </div>
    </section>

    <script>
        document.getElementById('password').addEventListener('input', function () {
            document.getElementById('password-hint').style.display =
                this.value.length > 0 ? 'block' : 'none';
        });
    </script>
@endsection
