@extends('layouts.dashboard')

@section('title', 'Beranda - Knowdell Digital')

@section('content')
    <style>
        .welcome-section {
            margin-bottom: 2.5rem;
        }

        .welcome-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .welcome-title span {
            color: var(--primary-blue);
        }

        .welcome-subtitle {
            color: #64748b;
            font-size: 1.1rem;
        }


        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cards-grid {
            display: flex;
            overflow-x: auto;
            gap: 2rem;
            padding: 2rem 5% 4rem 5%;
            margin-left: -5%;
            margin-right: -5%;
            scroll-snap-type: x mandatory;
            -webkit-overflow-scrolling: touch;
        }

        .cards-grid::-webkit-scrollbar {
            height: 8px;
        }

        .cards-grid::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.03);
            border-radius: 10px;
            margin: 0 5%;
        }

        .cards-grid::-webkit-scrollbar-thumb {
            background: rgba(37, 99, 235, 0.2);
            border-radius: 10px;
        }

        .cards-grid::-webkit-scrollbar-thumb:hover {
            background: rgba(37, 99, 235, 0.4);
        }

        .instrument-card:hover .card-top i {
            transform: scale(1.1) rotate(5deg);
        }

        @media (max-width: 768px) {
            .help-banner {
                flex-direction: column;
                text-align: center;
                gap: 1.5rem;
                padding: 2rem;
            }

            .help-content {
                flex-direction: column;
            }
        }

        .history-section {
            margin-top: 4rem;
            background: white;
            border-radius: 24px;
            padding: 2.5rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
        }

        .history-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .history-title {
            font-size: 1.25rem;
            font-weight: 800;
            color: var(--text-dark);
        }

        .history-link {
            color: var(--primary-blue);
            font-size: 0.85rem;
            font-weight: 700;
            text-decoration: none;
        }

        .history-empty {
            text-align: center;
            padding: 3rem 0;
            border: 2px dashed #e2e8f0;
            border-radius: 16px;
            background-color: #f8fafc;
        }

        .history-empty-icon {
            font-size: 3rem;
            color: #cbd5e1;
            margin-bottom: 1rem;
        }

        .history-empty-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .history-empty-desc {
            color: #94a3b8;
            font-size: 0.9rem;
        }
    </style>

    @php
        $fullName = Auth::user()->full_name;
    @endphp

    <div>
        <!-- Welcome Header -->
        <div class="welcome-section animate-fade-up">
            <div style="display: flex; justify-content: space-between; align-items: flex-end; flex-wrap: wrap; gap: 2rem;">
                <div>
                    <h1 class="welcome-title">Selamat Datang, <span>{{ explode(' ', $fullName)[0] }}!</span></h1>
                    <p class="welcome-subtitle">Pilih salah satu instrumen di bawah ini untuk memulai eksplorasi karirmu.
                    </p>
                </div>
            </div>
        </div>

        @php $counselorInfo = Auth::user()->counselor?->counselor; @endphp
        <div class="animate-fade-up" style="margin-bottom: 2rem;">
            @if($counselorInfo)
                <div class="counselor-banner"
                    style="background: white; border-radius: 20px; padding: 1.5rem 2rem; display: flex; align-items: center; gap: 1.5rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border-left: 4px solid #2563eb;">

                    {{-- Avatar --}}
                    <div class="counselor-avatar"
                        style="width: 50px; height: 50px; background: #eff6ff; color: #2563eb; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.25rem; font-weight: 800; flex-shrink: 0;">
                        {{ substr($counselorInfo->full_name, 0, 1) }}
                    </div>

                    {{-- Info --}}
                    <div class="counselor-info" style="flex: 1; min-width: 0;">
                        <div
                            style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.25rem;">
                            Konselor Kamu</div>
                        <div style="font-size: 1rem; font-weight: 800; color: #0f172a; margin-bottom: 0.3rem;">
                            {{ $counselorInfo->full_name }}
                        </div>
                        <div class="counselor-contacts" style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                            <span style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.4rem;">
                                <i class="fa-regular fa-envelope" style="color: #2563eb;"></i>
                                {{ $counselorInfo->email }}
                            </span>
                            @if($counselorInfo->phone)
                                <span style="font-size: 0.85rem; color: #64748b; display: flex; align-items: center; gap: 0.4rem;">
                                    <i class="fa-solid fa-phone" style="color: #2563eb;"></i>
                                    {{ $counselorInfo->phone }}
                                </span>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol --}}
                    @if(Route::has('counselor.public.profile'))
                        <a href="{{ route('counselor.public.profile', $counselorInfo->id) }}" class="counselor-banner-btn"
                            style="background: #2563eb; color: white; border-radius: 50px; padding: 0.65rem 1.25rem; font-size: 0.82rem; font-weight: 700; text-decoration: none; flex-shrink: 0; display: flex; align-items: center; gap: 0.5rem; white-space: nowrap; box-shadow: 0 4px 12px rgba(37,99,235,0.25); transition: all 0.2s;"
                            onmouseover="this.style.background='#1d4ed8';this.style.transform='translateY(-1px)'"
                            onmouseout="this.style.background='#2563eb';this.style.transform='translateY(0)'">
                            <i class="fa-solid fa-id-card"></i> Lihat Selengkapnya
                        </a>
                    @endif
                </div>

            @else
                <div class="counselor-banner counselor-banner--empty"
                    style="background: white; border-radius: 20px; padding: 1.25rem 2rem; display: flex; align-items: center; gap: 1.25rem; box-shadow: 0 4px 15px rgba(0,0,0,0.04); border-left: 4px solid #e2e8f0;">
                    <div
                        style="width: 45px; height: 45px; background: #f8fafc; color: #94a3b8; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.1rem; flex-shrink: 0;">
                        <i class="fa-solid fa-user-slash"></i>
                    </div>
                    <div>
                        <div
                            style="font-size: 0.7rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 0.2rem;">
                            Konselor Kamu</div>
                        <div style="font-size: 0.9rem; font-weight: 600; color: #64748b;">Belum terdapat konselor.</div>
                    </div>
                    <div
                        style="margin-left: auto; background: #fff7ed; color: #ea580c; border: 1px solid #fed7aa; border-radius: 50px; padding: 0.4rem 1rem; font-size: 0.78rem; font-weight: 700; flex-shrink: 0;">
                        <i class="fa-solid fa-clock" style="margin-right: 0.3rem;"></i> Menunggu
                    </div>
                </div>
            @endif
        </div>

        <!-- Cards Grid -->
        <div class="cards-grid">
            <x-dashboard-card theme="yellow" icon="fa-solid fa-bullseye" title="Career Values"
                href="{{ route('tests.intro', 1) }}"
                description="Temukan nilai-nilai karier yang paling penting bagi Anda." />

            <x-dashboard-card theme="red" icon="fa-solid fa-lightbulb" title="Motivated Skills"
                href="{{ route('tests.intro', 2) }}" description="Identifikasi keterampilan yang paling memotivasi Anda." />

            <x-dashboard-card theme="green" icon="fa-solid fa-umbrella-beach" title="Leisure & Retirement"
                href="{{ route('tests.intro', 3) }}" description="Jelajahi aktivitas di luar pekerjaan dan masa pensiun." />

            <x-dashboard-card theme="blue" icon="fa-solid fa-suitcase" title="Occupational Interests"
                href="{{ route('tests.intro', 4) }}" description="Ketahui bidang pekerjaan yang sesuai minat Anda." />
        </div>

        <!-- History Section -->
        <div class="history-section animate-fade-up" style="animation-delay: 0.6s;">
            <div class="history-header">
                <div style="display: flex; align-items: center; gap: 1rem;">
                    <div style="width: 10px; height: 30px; background: #0f172a; border-radius: 5px;"></div>
                    <h2 class="history-title">Riwayat Tes Kamu</h2>
                </div>
                <a href="{{ route('tests.history') }}" class="btn-action"
                    style="display: inline-flex; align-items: center; gap: 0.4rem;">
                    Lihat Semua <i class="fa-solid fa-arrow-right" style="font-size: 0.75rem;"></i>
                </a>
            </div>

            @php
                $recentSessions = Auth::user()->testSessions()
                    ->with('category')
                    ->whereHas('category')
                    ->where('status', 'finished')
                    ->latest('finished_at')
                    ->paginate(10);
            @endphp

            @if($recentSessions->isEmpty())
                <div class="history-empty">
                    <div class="history-empty-icon">
                        <i class="fa-regular fa-clipboard"></i>
                    </div>
                    <h3 class="history-empty-title">Belum Ada Riwayat Tes</h3>
                    <p class="history-empty-desc">Selesaikan instrumen pertamamu dan hasil akhirnya akan otomatis muncul di
                        sini.</p>
                </div>
            @else
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #f1f5f9;">
                            <th
                                style="text-align: center; padding: 0.75rem 1rem; font-size: 0.8rem; color: #0f172a; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                Instrumen</th>
                            <th
                                style="text-align: center; padding: 0.75rem 1rem; font-size: 0.8rem; color: #0f172a; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                Tanggal Selesai</th>
                            <th
                                style="text-align: center; padding: 0.75rem 1rem; font-size: 0.8rem; color: #0f172a; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                Durasi</th>
                            <th
                                style="text-align: center; padding: 0.75rem 1rem; font-size: 0.8rem; color: #0f172a; font-weight: 800; text-transform: uppercase; letter-spacing: 0.05em;">
                                Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentSessions as $session)
                            <tr style="border-bottom: 1px solid #f8fafc;">
                                <td style="padding: 1rem; font-weight: 600; color: var(--text-dark); text-align: center;">
                                    {{ $session->category->name }}
                                </td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.9rem; text-align: center;">
                                    {{ $session->finished_at->format('d M Y, H:i') }}
                                </td>
                                <td style="padding: 1rem; color: #64748b; font-size: 0.9rem; text-align: center;">
                                    @php
                                        $minutes = floor($session->duration / 60);
                                        $seconds = $session->duration % 60;
                                    @endphp
                                    {{ $minutes }}m {{ $seconds }}d
                                </td>
                                <td style="padding: 1rem; text-align: center;">
                                    <a href="{{ route('tests.result', ['id' => $session->category_id, 'session' => $session->id]) }}"
                                        class="btn-action">
                                        Lihat Hasil
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Pagination --}}
                <div
                    style="display:flex;justify-content:space-between;align-items:center;margin-top:1.5rem;padding-top:1rem;border-top:1px solid #f1f5f9;">
                    <div style="color:#94a3b8;font-size:0.9rem;font-weight:600;">
                        Menampilkan <span style="color:#475569;">{{ $recentSessions->count() }}</span> dari
                        <span style="color:#475569;">{{ $recentSessions->total() }}</span> hasil tes
                    </div>
                    {{ $recentSessions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection