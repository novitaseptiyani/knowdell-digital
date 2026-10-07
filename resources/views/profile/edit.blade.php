@extends('layouts.landing')

@section('title', 'Profil Saya - Knowdell Digital')

@section('content')

<section class="auth-section profile-section">

    <div class="profile-content-wrapper"
         x-data="{ tab: '{{ 
             session('status') === 'password-updated' ? 'keamanan'
             : (session('status') === 'career-updated' ? 'karir'
             : ($errors->updatePassword->any() ? 'keamanan'
             : ($errors->has('dream_jobs') || $errors->has('dream_jobs.*') || $errors->has('work_history.*') ? 'karir'
             : 'pribadi')))
         }}' }">

        {{-- Header Card --}}
        <div class="profile-header-card animate-fade-up">
            <div class="profile-avatar">
                {{ substr(Auth::user()->full_name, 0, 1) }}
            </div>
            <h3 class="profile-name">{{ Auth::user()->full_name }}</h3>
            <p class="profile-email">{{ Auth::user()->email }}</p>
            <div class="profile-meta-row">
                <div class="profile-meta-row">
                    @if(Auth::user()->status)
                        <div class="profile-meta-pill">
                            <i class="fa-solid fa-id-badge"></i>
                            <span>{{ Auth::user()->status }}</span>
                        </div>
                    @endif
                    <div class="profile-meta-pill">
                        <i class="fa-regular fa-calendar-check"></i>
                        <span>Bergabung sejak {{ Auth::user()->created_at->translatedFormat('d F Y') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Navigation Tabs --}}
        <div class="profile-tabs">
            <button @click="tab = 'pribadi'" class="profile-tab"
                :class="tab === 'pribadi' ? 'profile-tab--active' : ''">
                Informasi Pribadi
            </button>
            <button @click="tab = 'karir'" class="profile-tab"
                :class="tab === 'karir' ? 'profile-tab--active' : ''">
                Karir
            </button>
            <button @click="tab = 'keamanan'" class="profile-tab"
                :class="tab === 'keamanan' ? 'profile-tab--active' : ''">
                Keamanan
            </button>
        </div>

        {{-- Tab: Informasi Pribadi --}}
        <div x-show="tab === 'pribadi'" class="profile-form-card animate-fade">
            <form method="post" action="{{ route('profile.update') }}">
                @csrf
                @method('patch')

                {{-- Row 1: Nama Lengkap & Email --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Nama Lengkap</label>
                        <input type="text" name="full_name" class="form-control form-control--lg"
                            value="{{ old('full_name', Auth::user()->full_name) }}" required>
                        @error('full_name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Email Aktif</label>
                        <input type="email" name="email" class="form-control form-control--lg"
                            value="{{ old('email', Auth::user()->email) }}" required>
                        @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Row 2: No. Ponsel & Tanggal Lahir --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">No. Ponsel</label>
                        <input type="text" name="phone" class="form-control form-control--lg"
                            value="{{ old('phone', Auth::user()->phone) }}" placeholder="Nomor Aktif">
                        @error('phone') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Tanggal Lahir</label>
                        <input type="date" name="birth_date" class="form-control form-control--lg"
                            value="{{ old('birth_date', Auth::user()->birth_date ? Auth::user()->birth_date->format('Y-m-d') : '') }}"
                            lang="id">
                        @error('birth_date') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                </div>

                {{-- Row 3: Jenis Kelamin & Status --}}
                <div class="form-row" style="margin-bottom: 1.5rem;">
                    <div class="form-group">
                        <label class="form-label form-label--sm">Jenis Kelamin</label>
                        <select name="gender" class="form-control form-control--lg">
                            <option value="Laki-laki" {{ Auth::user()->gender == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ Auth::user()->gender == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label form-label--sm">Status Saat Ini</label>
                        <select name="status" class="form-control form-control--lg">
                            <option value="Pelajar"   {{ Auth::user()->status == 'Pelajar'   ? 'selected' : '' }}>Pelajar</option>
                            <option value="Mahasiswa" {{ Auth::user()->status == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                            <option value="Umum"      {{ Auth::user()->status == 'Umum'      ? 'selected' : '' }}>Umum</option>
                        </select>
                    </div>
                </div>

                {{-- Row 4: Instansi (full width) --}}
                <div class="form-group" style="margin-bottom: 2.5rem;">
                    <label class="form-label form-label--sm">Nama Instansi</label>
                    <input type="text" name="institution" class="form-control form-control--lg"
                        value="{{ old('institution', Auth::user()->institution) }}"
                        placeholder="Nama Sekolah/Kampus/Kantor">
                    @error('institution') <p class="text-danger">{{ $message }}</p> @enderror
                </div>

                <button type="submit" class="btn-submit-full">
                    <i class="fa-regular fa-floppy-disk"></i> SIMPAN PEMBARUAN PROFIL
                </button>
            </form>
        </div>

        {{-- Tab: Karir --}}
        <div x-show="tab === 'karir'" class="profile-form-card animate-fade"
             x-data="{
                 jobs: {{ json_encode(Auth::user()->work_history ?? []) }},
                 addJob()    { this.jobs.push({ job: '', duration: '' }); },
                 removeJob(i){ this.jobs.splice(i, 1); }
             }">
            <form method="POST" action="{{ route('profile.career.update') }}">
                @csrf
                @method('patch')

                {{-- Riwayat Pekerjaan --}}
                <div style="margin-bottom: 2rem;">
                    <div class="career-section-header">
                        <div>
                            <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.2rem;">
                                <i class="fa-solid fa-briefcase" style="color: #2563eb; margin-right: 0.5rem;"></i>
                                Riwayat Pekerjaan
                            </h4>
                            <p style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">Opsional — kosongkan jika belum pernah bekerja</p>
                        </div>
                        <button type="button" @click="addJob()"
                            style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.6rem 1.1rem; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; font-family: inherit; transition: all 0.2s;"
                            onmouseover="this.style.background='#2563eb';this.style.color='white'"
                            onmouseout="this.style.background='#eff6ff';this.style.color='#2563eb'">
                            <i class="fa-solid fa-plus"></i> Tambah
                        </button>
                    </div>

                    <div x-show="jobs.length === 0"
                         style="text-align: center; padding: 2rem; border: 2px dashed #e2e8f0; border-radius: 16px; color: #94a3b8;">
                        <i class="fa-solid fa-briefcase" style="font-size: 1.75rem; opacity: 0.3; display: block; margin-bottom: 0.5rem;"></i>
                        <p style="font-weight: 600; font-size: 0.88rem;">Belum ada riwayat pekerjaan</p>
                    </div>

                    <template x-for="(item, index) in jobs" :key="index">
                        <div class="work-history-item" style="display: grid; grid-template-columns: 1fr 220px 40px; gap: 1rem; margin-bottom: 1rem; align-items: start;">
                            <div>
                                <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">Nama Pekerjaan / Jabatan</label>
                                <input type="text"
                                       :name="'work_history[' + index + '][job]'"
                                       x-model="item.job"
                                       class="form-control form-control--lg">
                            </div>
                            <div>
                                <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">Durasi</label>
                                <select :name="'work_history[' + index + '][duration]'"
                                        x-model="item.duration"
                                        class="form-control form-control--lg">
                                    <option value="" disabled>Pilih durasi</option>
                                    <option value="Kurang dari 1 tahun">Kurang dari 1 tahun</option>
                                    <option value="1 - 2 tahun">1 – 2 tahun</option>
                                    <option value="2 - 5 tahun">2 – 5 tahun</option>
                                    <option value="Lebih dari 5 tahun">Lebih dari 5 tahun</option>
                                </select>
                            </div>
                            <div class="work-history-delete" style="padding-top: 2rem;">
                                <button type="button" @click="removeJob(index)"
                                    style="width: 40px; height: 46px; background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; border-radius: 12px; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; font-family: inherit; transition: all 0.2s;"
                                    onmouseover="this.style.background='#ef4444';this.style.color='white'"
                                    onmouseout="this.style.background='#fef2f2';this.style.color='#ef4444'">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Pekerjaan Impian --}}
                <div style="padding-top: 1.5rem; border-top: 2px solid #f1f5f9; margin-bottom: 2.5rem;">
                    <h4 style="font-size: 1.1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.2rem; margin-top: 0;">
                        <i class="fa-solid fa-star" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                        3 Pekerjaan Impian
                    </h4>
                    <p style="font-size: 0.8rem; color: #94a3b8; font-weight: 600; margin-bottom: 1.25rem;">Wajib diisi semua</p>

                    @php $dreamJobs = Auth::user()->dream_jobs ?? [null, null, null]; @endphp
                    @foreach([0, 1, 2] as $i)
                        <div class="form-group" style="margin-bottom: 1.25rem;">
                            <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">
                                Impian #{{ $i + 1 }}
                            </label>
                            <input type="text" name="dream_jobs[{{ $i }}]"
                                   class="form-control form-control--lg"
                                   value="{{ old('dream_jobs.' . $i, $dreamJobs[$i] ?? '') }}"
                                   required>
                            @error('dream_jobs.' . $i)
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn-submit-full">
                    <i class="fa-regular fa-floppy-disk"></i> SIMPAN DATA KARIR
                </button>
            </form>
        </div>

        {{-- Tab: Keamanan --}}
        <div x-show="tab === 'keamanan'" class="profile-form-card animate-fade"
            x-data="{
                showOld: false, showNew: false, showConfirm: false,
                newPass: '', confirmPass: '',
                get isMatch()    { return this.confirmPass.length > 0 && this.newPass === this.confirmPass },
                get isMismatch() { return this.confirmPass.length > 0 && this.newPass !== this.confirmPass }
            }">
            <form method="post" action="{{ route('user.password.update') }}">
                @csrf
                @method('put')

                <div class="form-group" style="margin-bottom: 2rem;">
                    <label class="form-label form-label--sm">Kata Sandi Lama</label>
                    <div class="password-field">
                        <input :type="showOld ? 'text' : 'password'" name="current_password"
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
                            <input :type="showNew ? 'text' : 'password'" name="password"
                                class="form-control form-control--password"
                                x-model="newPass" placeholder="Kata sandi baru" required>
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
                            <input :type="showConfirm ? 'text' : 'password'" name="password_confirmation"
                                class="form-control form-control--password"
                                x-model="confirmPass" placeholder="Ulangi kata sandi baru" required
                                :style="isMatch ? 'border: 1.5px solid #10b981; background-color: #f0fdf4;'
                                    : isMismatch ? 'border: 1.5px solid #ef4444; background-color: #fef2f2;' : ''">
                            <span class="password-toggle" @click="showConfirm = !showConfirm">
                                <i class="fa-regular" :class="showConfirm ? 'fa-eye' : 'fa-eye-slash'"></i>
                            </span>
                        </div>
                        <p class="password-match" x-show="isMatch">
                            <i class="fa-solid fa-circle-check" style="margin-right: 4px;"></i> Kata sandi cocok.
                        </p>
                        <p class="password-mismatch" x-show="isMismatch">
                            <i class="fa-solid fa-circle-xmark" style="margin-right: 4px;"></i> Kata sandi tidak cocok.
                        </p>
                    </div>
                </div>

                <button type="submit" class="btn-submit-full">GANTI KATA SANDI SEKARANG</button>
            </form>
        </div>

    </div>
</section>

{{-- Toast sukses --}}
@if(in_array(session('status'), ['profile-updated', 'password-updated', 'career-updated']))
    <div id="toast-notification" class="toast-success">
        <i class="fa-solid fa-circle-check"></i>
        @if(session('status') === 'profile-updated')    Profil berhasil disimpan!
        @elseif(session('status') === 'career-updated') Data karir berhasil disimpan!
        @else                                           Kata sandi berhasil diubah!
        @endif
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-notification');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 2500);
    </script>
@endif

{{-- Toast error password --}}
@if($errors->updatePassword->any())
    <div id="toast-error" class="toast-error">
        <i class="fa-solid fa-circle-xmark"></i>
        {{ $errors->updatePassword->first() }}
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-error');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 3000);
    </script>
@endif
@endsection
