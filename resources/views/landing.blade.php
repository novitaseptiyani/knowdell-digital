@extends('layouts.landing')

@section('title', 'Knowdell Digital')

@section('content')
    <div class="landing-wrapper">

        {{-- HERO --}}
        <section class="hero">
            <div class="hero-badge animate-fade">
                METODE KNOWDELL CARD SORTS
            </div>
            <h1 class="animate-fade delay-100">
                Kenali Potensi Dirimu<br>
                <span class="text-blue-italic">Dengan Baik</span>
            </h1>
            <p class="animate-fade delay-200">
                Platform asesmen karier interaktif berbasis metode <strong>Knowdell Card Sorts</strong>
                dikembangkan oleh konselor karier bersertifikat internasional dan telah digunakan
                oleh para profesional konseling di seluruh dunia selama lebih dari 40 tahun.
            </p>
            <div class="animate-fade delay-300">
                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-dark">
                        DAFTAR & MULAI TES <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                @else
                    <a href="#" class="btn-dark">
                        DAFTAR & MULAI TES <i class="fas fa-arrow-right" style="margin-left: 5px;"></i>
                    </a>
                @endif
            </div>

            <div class="info-strip animate-fade delay-300">
                <a href="{{ route('privacy-policy') }}">
                    <i class="fas fa-shield-alt"></i>
                    Data kamu aman &amp; hanya diakses oleh konselor yang ditugaskan.
                </a>
                <a href="{{ route('disclaimer') }}">
                    <i class="fas fa-circle-info"></i>
                    Hasil tes bukan diagnosis klinis, selalu konsultasikan dengan konselor!
                </a>
            </div>
        </section>

        {{-- FEATURE SECTION --}}
        <section class="feature-section">
            <div class="feature-grid-wrapper">

                {{-- Card Cara Penggunaan --}}
                <div class="feature-card animate-fade">
                    <h3 class="feature-card-title">
                        <i class="fa-solid fa-circle-play" style="color: #2563eb; margin-right: 8px;"></i> Cara Penggunaan
                    </h3>
                    <ul class="feature-list">
                        <li>
                            <div class="step-num">1</div>
                            <div>
                                <h4>Daftar Akun</h4>
                                <p>Buat akun gratis dengan email dan data dirimu. Pastikan data diisi lengkap agar konselor dapat mengenalmu dengan baik.</p>
                            </div>
                        </li>
                        <li>
                            <div class="step-num">2</div>
                            <div>
                                <h4>Pilih Instrumen Tes</h4>
                                <p>Pilih salah satu dari 4 instrumen yang tersedia di dashboard, lalu baca petunjuk sebelum memulai.</p>
                            </div>
                        </li>
                        <li>
                            <div class="step-num">3</div>
                            <div>
                                <h4>Sortir Kartu</h4>
                                <p>Drag &amp; drop setiap kartu ke kategori yang paling sesuai denganmu. Kamu bisa berhenti dan melanjutkan kapan saja — progres tersimpan selama kamu menekan Simpan Progress.</p>
                            </div>
                        </li>
                        <li>
                            <div class="step-num">4</div>
                            <div>
                                <h4>Lihat Hasil &amp; Konsultasi</h4>
                                <p>Hasil langsung muncul setelah selesai. Unduh atau cetak, lalu bawa ke sesi konseling bersama konselormu.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                {{-- Card Fitur Platform --}}
                <div class="feature-card animate-fade delay-100">
                    <h3 class="feature-card-title">
                        <i class="fa-solid fa-star" style="color: #2563eb; margin-right: 8px;"></i> Fitur Platform
                    </h3>
                    <ul class="feature-list">
                        <li>
                            <div class="feature-icon"><i class="fa-solid fa-layer-group"></i></div>
                            <div>
                                <h4>4 Instrumen Tes Card Sort</h4>
                                <p>Career Values, Motivated Skills, Occupational Interests, dan Leisure &amp; Retirement Activities.</p>
                            </div>
                        </li>
                        <li>
                            <div class="feature-icon"><i class="fa-solid fa-floppy-disk"></i></div>
                            <div>
                                <h4>Hasil Tersimpan Aman</h4>
                                <p>Semua hasil tes tersimpan dan bisa diakses kapan saja, lengkap dengan catatan dari konselor.</p>
                            </div>
                        </li>
                        <li>
                            <div class="feature-icon"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <h4>Terhubung dengan Konselor</h4>
                                <p>Setiap peserta bisa mendapatkan konselor yang dapat memantau dan memberikan catatan pada hasil tes.</p>
                            </div>
                        </li>
                        <li>
                            <div class="feature-icon"><i class="fa-solid fa-file-arrow-down"></i></div>
                            <div>
                                <h4>Unduh &amp; Cetak Hasil</h4>
                                <p>Hasil tes dapat diunduh dalam format PDF atau dicetak untuk dibawa ke sesi konseling.</p>
                            </div>
                        </li>
                    </ul>
                </div>

            </div>
        </section>

    </div>
@endsection
