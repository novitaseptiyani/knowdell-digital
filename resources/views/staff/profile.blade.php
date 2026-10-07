@extends('layouts.landing')

@section('title', 'Profil Saya - Knowdell Digital')

@section('content')
@php
    $authUser = Auth::guard('staff')->user();
    $isAdmin  = $authUser->role === 'admin';
@endphp

<section class="auth-section profile-section">

    <div class="profile-content-wrapper"
         x-data="{ tab: '{{ 
             session('status') === 'password-updated' ? 'keamanan'
             : (session('status') === 'bio-updated'   ? 'biografi'
             : ($errors->updatePassword->any()        ? 'keamanan'
             : ($errors->has('biography') || $errors->has('title') || $errors->has('specialization') ? 'biografi'
             : 'pribadi')))
         }}' }">

        {{-- Header Card --}}
        <div class="profile-header-card animate-fade-up">
            <div class="profile-avatar">
                {{ substr($authUser->full_name, 0, 1) }}
            </div>
            <h3 class="profile-name">{{ $authUser->full_name }}</h3>
            {{-- Tampilkan gelar di bawah nama (konselor saja) --}}
            @if(!$isAdmin && $authUser->title)
                <p class="profile-title">{{ $authUser->title }}</p>
            @endif
            <p class="profile-email">{{ $authUser->email }}</p>
            <div class="profile-meta-row">
                <div class="profile-meta-pill">
                    <i class="fa-solid fa-user-tie"></i>
                    <span>{{ $isAdmin ? 'Administrator' : 'Konselor' }}</span>
                </div>
                <div class="profile-meta-pill">
                    <i class="fa-regular fa-calendar-check"></i>
                    <span>Bergabung sejak {{ $authUser->created_at->translatedFormat('d F Y') }}</span>
                </div>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="profile-tabs">
            <button @click="tab = 'pribadi'"
                class="profile-tab"
                :class="tab === 'pribadi' ? 'profile-tab--active' : ''">
                Informasi Pribadi
            </button>
            {{-- Tab Biografi hanya untuk konselor --}}
            @if(!$isAdmin)
                <button @click="tab = 'biografi'"
                    class="profile-tab"
                    :class="tab === 'biografi' ? 'profile-tab--active' : ''">
                    Biografi
                </button>
            @endif
            <button @click="tab = 'keamanan'"
                class="profile-tab"
                :class="tab === 'keamanan' ? 'profile-tab--active' : ''">
                Keamanan
            </button>
        </div>

        {{-- Tab: Informasi Pribadi --}}
        <div x-show="tab === 'pribadi'" class="profile-form-card animate-fade">
            <form method="post" action="{{ $isAdmin ? route('admin.profile.update') : route('counselor.profile.update') }}">
                @csrf
                @method('patch')

                {{-- Row 1: Nama Lengkap & Email --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Nama Lengkap</label>
                        <input type="text" name="full_name"
                            class="form-control form-control--lg"
                            value="{{ old('full_name', $authUser->full_name) }}" required>
                        @error('full_name')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Email Aktif</label>
                        <input type="email" name="email"
                            class="form-control form-control--lg"
                            value="{{ old('email', $authUser->email) }}" required>
                        @error('email')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 2: No. Ponsel & Tanggal Lahir --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">No. Ponsel</label>
                        <input type="text" name="phone"
                            class="form-control form-control--lg"
                            value="{{ old('phone', $authUser->phone) }}"
                            placeholder="Nomor Aktif">
                        @error('phone')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Tanggal Lahir</label>
                        <input type="date" name="birth_date"
                            class="form-control form-control--lg"
                            value="{{ old('birth_date', $authUser->birth_date ? $authUser->birth_date->format('Y-m-d') : '') }}"
                            lang="id">
                        @error('birth_date')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Row 3: Jenis Kelamin & Nama Instansi --}}
                <div class="form-row" style="margin-bottom: 2.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Jenis Kelamin</label>
                        <select name="gender" class="form-control form-control--lg">
                            <option value="Laki-laki" {{ old('gender', $authUser->gender ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('gender', $authUser->gender ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Nama Instansi</label>
                        <input type="text" name="institution"
                            class="form-control form-control--lg"
                            value="{{ old('institution', $authUser->institution ?? '') }}"
                            placeholder="Nama Sekolah/Kampus/Kantor">
                        @error('institution')
                            <p class="text-danger">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="btn-submit-full">
                    <i class="fa-regular fa-floppy-disk"></i> SIMPAN PEMBARUAN PROFIL
                </button>
            </form>
        </div>

        {{-- Tab: Biografi (konselor saja) --}}
        @if(!$isAdmin)
        <div x-show="tab === 'biografi'" class="profile-form-card animate-fade">
            <form method="post" action="{{ route('counselor.profile.bio') }}">
                @csrf
                @method('patch')

                {{-- Gelar & Spesialisasi --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Gelar Akademik</label>
                        <input type="text" name="title"
                            class="form-control form-control--lg"
                            value="{{ old('title', $authUser->title ?? '') }}"
                            placeholder="">
                        <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 6px;">
                            Akan ditampilkan di bawah nama pada profil publik kamu.
                        </p>
                        @error('title') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Bidang Spesialisasi</label>
                        <input type="text" name="specialization"
                            class="form-control form-control--lg"
                            value="{{ old('specialization', $authUser->specialization ?? '') }}"
                            placeholder="">
                        <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 6px;">
                            Ditampilkan sebagai badge pada profil publik kamu.
                        </p>
                        @error('specialization') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Biografi --}}
                <div class="form-group" style="margin-bottom: 2.5rem;">
                    <label class="form-label form-label--sm">Biografi &amp; Riwayat Akademik</label>
                    <textarea name="biography" rows="10"
                        class="form-control form-control--lg"
                        style="resize: vertical; line-height: 1.7; padding-top: 1rem;"
                        placeholder="Ceritakan latar belakang pendidikan, pengalaman kerja, sertifikasi, dan pendekatan konseling kamu...">{{ old('biography', $authUser->biography ?? '') }}</textarea>
                    <p style="font-size: 0.78rem; color: #94a3b8; margin-top: 6px;">
                        Maksimal 5.000 karakter. Gunakan enter untuk paragraf baru.
                    </p>
                    @error('biography') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                {{-- Link preview (muncul setelah ada isi + route sudah didefinisikan) --}}
                @if(($authUser->biography || $authUser->title) && Route::has('counselor.public.profile'))
                    <div style="background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 0.875rem 1.25rem; margin-bottom: 1.5rem; display: flex; align-items: center; gap: 0.75rem;">
                        <i class="fa-solid fa-eye" style="color: #16a34a;"></i>
                        <span style="font-size: 0.88rem; color: #15803d; font-weight: 600;">
                            Profil publikmu sudah aktif —
                            <a href="{{ route('counselor.public.profile', $authUser->id) }}"
                               style="color: #15803d; font-weight: 700; text-decoration: underline;">
                                lihat tampilannya di sini
                            </a>
                        </span>
                    </div>
                @endif

                <button type="submit" class="btn-submit-full">
                    <i class="fa-regular fa-floppy-disk"></i> SIMPAN BIOGRAFI
                </button>
            </form>
        </div>
        @endif

        {{-- Tab: Keamanan --}}
        <div x-show="tab === 'keamanan'" class="profile-form-card animate-fade"
            x-data="{
                showOld: false,
                showNew: false,
                showConfirm: false,
                newPass: '',
                confirmPass: '',
                get isMatch()    { return this.confirmPass.length > 0 && this.newPass === this.confirmPass },
                get isMismatch() { return this.confirmPass.length > 0 && this.newPass !== this.confirmPass }
            }">

            <form method="post" action="{{ $isAdmin ? route('admin.profile.password') : route('counselor.profile.password') }}">
                @csrf
                @method('put')

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label class="form-label form-label--sm">Kata Sandi Lama</label>
                    <div class="password-field">
                        <input :type="showOld ? 'text' : 'password'"
                            name="current_password"
                            class="form-control form-control--password"
                            placeholder="Masukkan kata sandi saat ini" required>
                        <span class="password-toggle" @click="showOld = !showOld">
                            <i class="fa-regular" :class="showOld ? 'fa-eye' : 'fa-eye-slash'"></i>
                        </span>
                    </div>
                    @if($errors->updatePassword->has('current_password'))
                        <p class="text-danger">{{ $errors->updatePassword->first('current_password') }}</p>
                    @endif
                </div>

                <div class="form-row" style="margin-bottom: 3rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Kata Sandi Baru</label>
                        <div class="password-field">
                            <input :type="showNew ? 'text' : 'password'"
                                name="password"
                                class="form-control form-control--password"
                                x-model="newPass"
                                placeholder="Kata sandi baru" required>
                            <span class="password-toggle" @click="showNew = !showNew">
                                <i class="fa-regular" :class="showNew ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </span>
                        </div>
                        <p class="password-hint" x-show="newPass.length > 0">
                            <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i>
                            Minimal 8 karakter, kombinasi huruf &amp; angka.
                        </p>
                        @if($errors->updatePassword->has('password'))
                            <p class="text-danger">{{ $errors->updatePassword->first('password') }}</p>
                        @endif
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Konfirmasi Sandi Baru</label>
                        <div class="password-field">
                            <input :type="showConfirm ? 'text' : 'password'"
                                name="password_confirmation"
                                class="form-control form-control--password"
                                x-model="confirmPass"
                                placeholder="Ulangi kata sandi baru" required
                                :style="isMatch ? 'border: 1.5px solid #10b981; background-color: #f0fdf4;'
                                    : isMismatch ? 'border: 1.5px solid #ef4444; background-color: #fef2f2;' : ''">
                            <span class="password-toggle" @click="showConfirm = !showConfirm">
                                <i class="fa-regular" :class="showConfirm ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </span>
                        </div>
                        <p class="password-match" x-show="isMatch">
                            <i class="fa-solid fa-circle-check" style="margin-right: 4px;"></i>
                            Kata sandi cocok.
                        </p>
                        <p class="password-mismatch" x-show="isMismatch">
                            <i class="fa-solid fa-circle-xmark" style="margin-right: 4px;"></i>
                            Kata sandi tidak cocok.
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn-submit-full">
                    GANTI KATA SANDI SEKARANG
                </button>
            </form>
        </div>

    </div>
</section>

{{-- Toast sukses --}}
@if(session('status') === 'profile-updated' || session('status') === 'password-updated' || session('status') === 'bio-updated')
    <div id="toast-notification" class="toast-success">
        <i class="fa-solid fa-circle-check"></i>
        @if(session('status') === 'profile-updated')      Profil berhasil disimpan!
        @elseif(session('status') === 'password-updated') Kata sandi berhasil diubah!
        @else                                             Biografi berhasil disimpan!
        @endif
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-notification');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 2500);
    </script>
@endif

{{-- Toast error — kata sandi gagal diubah --}}
@if($errors->updatePassword->any())
    <div id="toast-notification" class="toast-error">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->updatePassword->first() }}
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-notification');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 3000);
    </script>
@endif

{{-- Toast error — biografi gagal disimpan --}}
@if($errors->has('biography') || $errors->has('title') || $errors->has('specialization'))
    <div id="toast-notification" class="toast-error">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->first('biography') ?: ($errors->first('title') ?: $errors->first('specialization')) }}
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-notification');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 3000);
    </script>
@endif
@endsection
