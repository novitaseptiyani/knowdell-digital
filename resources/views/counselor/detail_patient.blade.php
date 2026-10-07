@extends('layouts.dashboard')

@section('title', 'Detail Klien - Knowdell Digital')

@section('content')
<div style="max-width: 1000px; margin: 0 auto; padding-bottom: 4rem;">

    {{-- Tombol Kembali --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('counselor.patients') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Daftar Klien
        </a>
    </div>

    {{-- Header Klien --}}
    <div class="patient-detail-header">
        <div class="patient-info-row">
            <div class="patient-avatar">
                {{ substr($patient->full_name, 0, 1) }}
            </div>
            <div style="flex: 1;">
                <h1 class="patient-name">{{ $patient->full_name }}</h1>
                <p class="patient-email">{{ $patient->email }}</p>
                <div class="patient-badges">
                    <span class="patient-badge-status">{{ $patient->status ?? '-' }}</span>
                    @if($patient->institution)
                        <span class="patient-badge-pill">
                            <i class="fa-solid fa-building"></i>{{ $patient->institution }}
                        </span>
                    @endif
                    <span class="patient-badge-pill">
                        <i class="fa-regular fa-calendar"></i>Bergabung {{ $patient->created_at->translatedFormat('d F Y') }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Demografis --}}
        <div class="demo-grid">
            <div class="demo-card">
                <p class="demo-label">Nomor Ponsel</p>
                <p class="demo-value">{{ $patient->phone ?? '-' }}</p>
            </div>
            <div class="demo-card">
                <p class="demo-label">Tanggal Lahir</p>
                <p class="demo-value">
                    {{ $patient->birth_date ? $patient->birth_date->translatedFormat('d F Y') : '-' }}
                </p>
            </div>
            <div class="demo-card">
                <p class="demo-label">Jenis Kelamin</p>
                <p class="demo-value">{{ $patient->gender ?? '-' }}</p>
            </div>
        </div>

        {{-- Info Karir --}}
        <div style="border-top: 1px solid #e2e8f0; margin-top: 1.5rem; padding-top: 1.5rem;">
            <p style="font-size: 0.75rem; font-weight: 800; color: #94a3b8; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 1.25rem;">
                <i class="fa-solid fa-briefcase" style="color: #2563eb; margin-right: 0.4rem;"></i> Info Karir
            </p>
            <div class="career-info-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">

                {{-- Riwayat Pekerjaan --}}
                <div>
                    <p style="font-size: 0.72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">Riwayat Pekerjaan</p>
                    @if(!empty($patient->work_history) && count($patient->work_history) > 0)
                        <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                            @foreach($patient->work_history as $index => $job)
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                                    <div style="width: 26px; height: 26px; background: #eff6ff; color: #2563eb; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 800; flex-shrink: 0;">
                                        {{ $index + 1 }}
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <p style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin: 0 0 0.1rem;">{{ $job['job'] }}</p>
                                        <p style="font-size: 0.75rem; color: #94a3b8; font-weight: 600; margin: 0;">{{ $job['duration'] }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 0.85rem; color: #cbd5e1; font-weight: 600; font-style: italic;">Belum ada riwayat pekerjaan</p>
                    @endif
                </div>

                {{-- Pekerjaan Impian --}}
                <div>
                    <p style="font-size: 0.72rem; font-weight: 700; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.75rem;">3 Pekerjaan Impian</p>
                    @if(!empty($patient->dream_jobs) && count($patient->dream_jobs) > 0)
                        <div style="display: flex; flex-direction: column; gap: 0.6rem;">
                            @foreach($patient->dream_jobs as $index => $dream)
                                <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem 1rem; background: #ffffff; border-radius: 12px; border: 1px solid #e2e8f0;">
                                    <div style="width: 26px; height: 26px; background: #fff7ed; color: #f59e0b; border-radius: 7px; display: flex; align-items: center; justify-content: center; font-size: 0.72rem; font-weight: 800; flex-shrink: 0;">
                                        {{ $index + 1 }}
                                    </div>
                                    <p style="font-weight: 700; color: #0f172a; font-size: 0.88rem; margin: 0;">{{ $dream }}</p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p style="font-size: 0.85rem; color: #cbd5e1; font-weight: 600; font-style: italic;">Belum ada pekerjaan impian</p>
                    @endif
                </div>

            </div>
        </div>
    </div>

    {{-- ===== RIWAYAT TES ===== --}}
    <div class="riwayat-card">
        <div class="riwayat-header">
            <h3 class="riwayat-title">
                <i class="fa-solid fa-clipboard-list"></i> Riwayat Tes
            </h3>
        </div>

        {{-- Filter --}}
        <form action="{{ route('counselor.patient', $patient->id) }}" method="GET" class="dash-filter">
            <select name="tes" class="dash-select dash-select--w200">
                <option value="">Semua Tes</option>
                <option value="Career Values"                     {{ request('tes') == 'Career Values' ? 'selected' : '' }}>Career Values</option>
                <option value="Motivated Skills"                  {{ request('tes') == 'Motivated Skills' ? 'selected' : '' }}>Motivated Skills</option>
                <option value="Occupational Interests"            {{ request('tes') == 'Occupational Interests' ? 'selected' : '' }}>Occupational Interests</option>
                <option value="Leisure and Retirement Activities" {{ request('tes') == 'Leisure and Retirement Activities' ? 'selected' : '' }}>Leisure & Retirement</option>
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" lang="id"
                class="dash-input dash-input--w170 dash-input--date">
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>

        @if($sessions->isEmpty())
            <div class="table-empty" style="padding: 3rem;">
                <div class="table-empty-icon"><i class="fa-solid fa-clipboard"></i></div>
                <p class="table-empty-text">Klien belum menyelesaikan tes apapun.</p>
            </div>
        @else
            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th>JENIS TES</th>
                            <th>TANGGAL SELESAI</th>
                            <th>DURASI</th>
                            <th>STATUS TINJAUAN</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $session)
                            <tr>
                                <td class="td-first-14 td-center">
                                    <span class="badge-tes">{{ $session->category->name }}</span>
                                </td>
                                <td class="td-center td-muted td-nowrap">
                                    {{ $session->finished_at->format('d M Y, H:i') }}
                                </td>
                                <td class="td-center td-muted td-nowrap">
                                    @php
                                        $minutes = floor($session->duration / 60);
                                        $seconds = $session->duration % 60;
                                    @endphp
                                    {{ $minutes }}m {{ $seconds }}d
                                </td>
                                <td class="td-center td-nowrap">
                                    @if($session->testResult?->is_reviewed)
                                        <span class="badge-reviewed">Sudah Ditinjau</span>
                                    @else
                                        <span class="badge-unreviewed">Belum Ditinjau</span>
                                    @endif
                                </td>
                                <td class="td-last-14 td-center">
                                    <a href="{{ route('counselor.result', $session->id) }}" class="btn-action">Lihat Hasil</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="dash-pagination">
                <div class="dash-pagination-info">
                    Menampilkan <span>{{ $sessions->count() }}</span> dari
                    <span>{{ $sessions->total() }}</span> tes
                </div>
                {{ $sessions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
