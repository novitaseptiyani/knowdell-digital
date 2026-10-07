@extends('layouts.landing')

@section('title', 'Lengkapi Profil - Knowdell Digital')

@section('content')
<section class="auth-section profile-section">
    <div class="profile-content-wrapper">

        {{-- Header Card --}}
        <div class="profile-header-card animate-fade-up" style="margin-bottom: 2rem;">
            <div class="profile-avatar" style="background: linear-gradient(135deg, #2563eb, #7c3aed);">
                <i class="fa-solid fa-rocket" style="font-size: 2rem;"></i>
            </div>
            <h3 class="profile-name">Satu Langkah Lagi! 🎯</h3>
            <p class="profile-email">Halo, {{ Auth::user()->full_name }}!</p>
            <p style="color: #64748b; font-size: 0.95rem; max-width: 480px; margin: 0.5rem auto 0; line-height: 1.6;">
                Ceritakan sedikit tentang perjalanan karirmu. Informasi ini membantu konselor memahami kamu lebih baik.
            </p>
        </div>

        <form method="POST" action="{{ route('onboarding.store') }}"
              x-data="{
                  jobs: [],
                  addJob()    { this.jobs.push({ job: '', duration: '' }); },
                  removeJob(i){ this.jobs.splice(i, 1); }
              }"
              style="width: 100%;">
            @csrf

            {{-- ===== RIWAYAT PEKERJAAN ===== --}}
            <div class="profile-form-card animate-fade" style="margin-bottom: 2rem;">

                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.75rem; padding-bottom: 1rem; border-bottom: 2px solid #f1f5f9;">
                    <div>
                        <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                            <i class="fa-solid fa-briefcase" style="color: #2563eb; margin-right: 0.5rem;"></i>
                            Riwayat Pekerjaan
                        </h4>
                        <p style="font-size: 0.82rem; color: #94a3b8; font-weight: 600;">
                            Opsional — kosongkan jika belum pernah bekerja
                        </p>
                    </div>
                    <button type="button" @click="addJob()"
                        style="background: #eff6ff; color: #2563eb; border: 1px solid #bfdbfe; border-radius: 12px; padding: 0.6rem 1.1rem; font-size: 0.82rem; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 0.4rem; white-space: nowrap; font-family: inherit; transition: all 0.2s;"
                        onmouseover="this.style.background='#2563eb';this.style.color='white'"
                        onmouseout="this.style.background='#eff6ff';this.style.color='#2563eb'">
                        <i class="fa-solid fa-plus"></i> Tambah Pekerjaan
                    </button>
                </div>

                {{-- Dynamic rows --}}
                <div x-show="jobs.length === 0"
                     style="text-align: center; padding: 2.5rem; border: 2px dashed #e2e8f0; border-radius: 16px; color: #94a3b8;">
                    <i class="fa-solid fa-briefcase" style="font-size: 2rem; opacity: 0.3; display: block; margin-bottom: 0.75rem;"></i>
                    <p style="font-weight: 600; font-size: 0.9rem;">Belum ada riwayat pekerjaan</p>
                    <p style="font-size: 0.8rem; margin-top: 0.25rem;">Klik "Tambah Pekerjaan" untuk menambahkan</p>
                </div>

                <template x-for="(item, index) in jobs" :key="index">
                    <div style="display: grid; grid-template-columns: 1fr 220px 40px; gap: 1rem; margin-bottom: 1rem; align-items: start;">
                        <div>
                            <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">
                                Nama Pekerjaan / Jabatan
                            </label>
                            <input type="text"
                                   :name="'work_history[' + index + '][job]'"
                                   x-model="item.job"
                                   class="form-control form-control--lg"
                                   placeholder="">
                        </div>
                        <div>
                            <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">
                                Durasi
                            </label>
                            <select :name="'work_history[' + index + '][duration]'"
                                    x-model="item.duration"
                                    class="form-control form-control--lg">
                                <option value="" disabled selected>Pilih durasi</option>
                                <option value="Kurang dari 1 tahun">Kurang dari 1 tahun</option>
                                <option value="1 - 2 tahun">1 – 2 tahun</option>
                                <option value="2 - 5 tahun">2 – 5 tahun</option>
                                <option value="Lebih dari 5 tahun">Lebih dari 5 tahun</option>
                            </select>
                        </div>
                        <div style="padding-top: 2rem;">
                            <button type="button" @click="removeJob(index)"
                                style="width: 40px; height: 46px; background: #fef2f2; color: #ef4444; border: 1px solid #fecaca; border-radius: 12px; cursor: pointer; font-size: 0.9rem; display: flex; align-items: center; justify-content: center; font-family: inherit; transition: all 0.2s;"
                                onmouseover="this.style.background='#ef4444';this.style.color='white'"
                                onmouseout="this.style.background='#fef2f2';this.style.color='#ef4444'">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </template>

                @error('work_history.*.job')
                    <p class="text-danger" style="margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
                @error('work_history.*.duration')
                    <p class="text-danger" style="margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            {{-- ===== PEKERJAAN IMPIAN ===== --}}
            <div class="profile-form-card animate-fade">
                <div style="margin-bottom: 1.75rem; padding-bottom: 1rem; border-bottom: 2px solid #f1f5f9;">
                    <h4 style="font-size: 1.15rem; font-weight: 800; color: #0f172a; margin-bottom: 0.25rem;">
                        <i class="fa-solid fa-star" style="color: #f59e0b; margin-right: 0.5rem;"></i>
                        3 Pekerjaan Impian
                    </h4>
                    <p style="font-size: 0.82rem; color: #94a3b8; font-weight: 600;">
                        Wajib diisi — tulis pekerjaan yang paling kamu inginkan
                    </p>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.25rem; margin-bottom: 2.5rem;">
                    @foreach([1, 2, 3] as $i)
                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label form-label--sm" style="margin-bottom: 0.5rem; display: block;">
                                Impian #{{ $i }}
                            </label>
                            <input type="text"
                                   name="dream_jobs[{{ $i - 1 }}]"
                                   class="form-control form-control--lg"
                                   value="{{ old('dream_jobs.' . ($i - 1)) }}"
                                   placeholder=""
                                   required>
                            @error('dream_jobs.' . ($i - 1))
                                <p class="text-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    @endforeach
                </div>

                @error('dream_jobs')
                    <p class="text-danger" style="margin-bottom: 1rem;">{{ $message }}</p>
                @enderror

                <button type="submit" class="btn-submit-full"
                        style="position: relative; overflow: hidden;">
                    <i class="fa-solid fa-rocket"></i> Mulai
                    <span style="position: absolute; top: 0; left: -100%; width: 50%; height: 100%;
                                 background: linear-gradient(to right, rgba(255,255,255,0) 0%, rgba(255,255,255,0.15) 50%, rgba(255,255,255,0) 100%);
                                 transform: skewX(-20deg); transition: all 0.6s ease;"
                          onmouseover="this.style.left='150%'"
                          onmouseout="this.style.left='-100%'"></span>
                </button>
            </div>

        </form>
    </div>
</section>
@endsection
