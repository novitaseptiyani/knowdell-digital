@extends('layouts.dashboard')

@section('content')
<div class="dash-container">

    {{-- Welcome header --}}
    <div class="dash-page-header dash-page-header--top">
        <div>
            <h1 class="dash-page-title">
                Selamat Datang, <span>{{ explode(' ', Auth::guard('staff')->user()->full_name)[0] }}</span>!
            </h1>
            <p class="dash-page-subtitle">Kelola dan analisis hasil tes peserta untuk membantu mereka menemukan arah karier terbaik.</p>
        </div>
    </div>

    {{-- Stat cards --}}
    <div class="stat-card-grid">

        <a href="{{ route('counselor.patients') }}" class="stat-card stat-card--blue">
            <div class="stat-card-icon stat-card-icon--blue">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_patients'] }}</div>
                <div class="stat-card-label stat-card-label--blue">Total Klien Anda</div>
            </div>
        </a>

        <a href="{{ route('counselor.completed_tests') }}" class="stat-card stat-card--green">
            <div class="stat-card-icon stat-card-icon--green">
                <i class="fa-solid fa-file-circle-check"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_finished'] }}</div>
                <div class="stat-card-label stat-card-label--green">Total Seluruh Tes Selesai</div>
            </div>
        </a>

        <a href="{{ route('counselor.unreviewed') }}" class="stat-card stat-card--yellow">
            <div class="stat-card-icon stat-card-icon--yellow">
                <i class="fa-solid fa-hourglass-half"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_unreviewed'] }}</div>
                <div class="stat-card-label stat-card-label--yellow">Hasil Belum Ditinjau</div>
            </div>
        </a>
    </div>

    {{-- Tabel Hasil Tes Terbaru --}}
    <div class="dash-card" style="margin-top: 1.5rem;">
        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar"></div>
                <h3 class="dash-section-title">Daftar Hasil Tes Terbaru</h3>
            </div>
            <a href="{{ route('counselor.completed_tests') }}" class="btn-view-all">
                <i class="fa-solid fa-list"></i> Lihat Semua
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="dash-table dash-table--lg">
                <thead>
                    <tr>
                        <th class="th-left">KLIEN</th>
                        <th>INSTANSI</th>
                        <th>JENIS TES</th>
                        <th>TANGGAL</th>
                        <th>STATUS TINJAUAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($latestResults as $session)
                        <tr>
                            <td class="td-first-16">
                                <div class="td-user-wrap">
                                    <div class="table-avatar">{{ substr($session->user->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="td-name">{{ $session->user->full_name }}</div>
                                        <div class="td-email">{{ $session->user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-center">
                                <span class="td-instansi">{{ $session->user->institution ?? '-' }}</span>
                            </td>
                            <td class="td-center td-nowrap">
                                <span class="badge-tes">{{ $session->category->name }}</span>
                            </td>
                            <td class="td-center td-muted td-nowrap">
                                {{ $session->finished_at->format('d M Y, H:i') }}
                            </td>
                            <td class="td-center td-nowrap">
                                @if($session->testResult?->is_reviewed)
                                    <span class="badge-reviewed">Sudah Ditinjau</span>
                                @else
                                    <span class="badge-unreviewed">Belum Ditinjau</span>
                                @endif
                            </td>
                            <td class="td-last-16 td-right">
                                <a href="{{ route('counselor.result', $session->id) }}" class="btn-action">Lihat Hasil</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="table-empty">
                                    <div class="table-empty-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                                    <p class="table-empty-text">Belum ada data hasil tes untuk ditampilkan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dash-pagination dash-pagination--lg">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $latestResults->count() }}</span> dari
                <span>{{ $latestResults->total() }}</span> hasil tes
            </div>
            {{ $latestResults->links() }}
        </div>
    </div>
</div>
@endsection
