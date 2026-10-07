@extends('layouts.dashboard')

@section('title', 'Admin Dashboard - Knowdell Digital')

@section('content')
<div class="dash-container">

    {{-- Welcome Header --}}
    <div class="dash-page-header dash-page-header--top animate-fade-up">
        <div>
            <h1 class="dash-page-title">Control Panel <span>Administrator</span></h1>
            <p class="dash-page-subtitle" style="font-size: 1.1rem;">
                Pantau aktivitas, kelola pengguna, dan kendalikan seluruh ekosistem Knowdell Digital.
            </p>
        </div>
    </div>

    {{-- Quick Navigation --}}
    <div class="quick-nav-grid animate-fade-up">
        <a href="{{ route('admin.users') }}"      class="quick-nav-card quick-nav-card--blue">
            <div class="quick-nav-icon quick-nav-icon--blue"><i class="fa-solid fa-user-gear"></i></div>
            <span class="quick-nav-label">Kelola User</span>
        </a>
        <a href="{{ route('admin.admins') }}"     class="quick-nav-card quick-nav-card--purple">
            <div class="quick-nav-icon quick-nav-icon--purple"><i class="fa-solid fa-user-shield"></i></div>
            <span class="quick-nav-label">Kelola Admin</span>
        </a>
        <a href="{{ route('admin.counselors') }}" class="quick-nav-card quick-nav-card--green">
            <div class="quick-nav-icon quick-nav-icon--green"><i class="fa-solid fa-user-tie"></i></div>
            <span class="quick-nav-label">Kelola Konselor</span>
        </a>
        <a href="{{ route('admin.assignments') }}" class="quick-nav-card quick-nav-card--yellow">
            <div class="quick-nav-icon quick-nav-icon--yellow"><i class="fa-solid fa-link"></i></div>
            <span class="quick-nav-label">Assignment</span>
        </a>
    </div>

    {{-- Stat Cards --}}
    <div class="stat-card-grid">
        <div class="stat-card stat-card--blue animate-fade-up">
            <div class="stat-card-icon stat-card-icon--blue stat-card-icon--sm">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_users'] }}</div>
                <div class="stat-card-label stat-card-label--blue">Total Pengguna</div>
            </div>
        </div>
        <div class="stat-card stat-card--green animate-fade-up" style="animation-delay: 0.1s;">
            <div class="stat-card-icon stat-card-icon--green stat-card-icon--sm">
                <i class="fa-solid fa-user-tie"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_counselors'] }}</div>
                <div class="stat-card-label stat-card-label--green">Total Konselor Terdaftar</div>
            </div>
        </div>
        <div class="stat-card stat-card--yellow animate-fade-up" style="animation-delay: 0.2s;">
            <div class="stat-card-icon stat-card-icon--yellow stat-card-icon--sm">
                <i class="fa-solid fa-clipboard-check"></i>
            </div>
            <div class="stat-card-body">
                <div class="stat-card-number">{{ $stats['total_tests'] }}</div>
                <div class="stat-card-label stat-card-label--yellow">Total Tes Diselesaikan</div>
            </div>
        </div>
    </div>

    {{-- Statistik Instrumen --}}
    <div class="dash-card animate-fade-up" style="margin-top: 2rem;">
        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar" style="background: #8b5cf6;"></div>
                <h3 class="dash-section-title">Statistik Penggunaan Instrumen</h3>
            </div>
            <span style="font-size: 0.8rem; color: #94a3b8; font-weight: 600;">Berdasarkan tes yang diselesaikan</span>
        </div>

        {{-- Mini stat cards — background dynamic PHP, struktur dari class --}}
        <div class="instrument-stats-grid">
            @foreach ($instrumentStats as $index => $instrument)
                @php
                    $colors = ['#f59e0b', '#ef4444', '#10b981', '#2563eb'];
                    $bgs    = ['#fff7ed', '#fef2f2', '#f0fdf4', '#eff6ff'];
                @endphp
                <div class="instrument-stat-card" style="background: {{ $bgs[$index] }};">
                    <p class="instrument-stat-label">{{ $instrument['label'] }}</p>
                    <p class="instrument-stat-number" style="color: {{ $colors[$index] }};">{{ $instrument['total'] }}</p>
                    <p class="instrument-stat-sub">kali diselesaikan</p>
                </div>
            @endforeach
        </div>

        <div style="position: relative; width: 100%; height: 220px;">
            <canvas id="instrumentChart" role="img" aria-label="Bar chart jumlah pengerjaan per instrumen">
                @foreach ($instrumentStats as $i) {{ $i['label'] }}: {{ $i['total'] }}. @endforeach
            </canvas>
        </div>
    </div>

    {{-- Recent Users --}}
    <div class="dash-card animate-fade-up" style="margin-top: 3rem;" data-delay="0.3">
        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar dash-accent-bar--blue"></div>
                <h3 class="dash-section-title">Registrasi User Terbaru</h3>
            </div>
            <a href="{{ route('admin.export.users') }}" class="btn-export">
                <i class="fa-solid fa-file-excel"></i> Download Excel
            </a>
        </div>

        <div style="overflow-x: auto;">
            <table class="dash-table dash-table--lg">
                <thead>
                    <tr>
                        <th>NAMA USER</th>
                        <th>EMAIL</th>
                        <th>TANGGAL DAFTAR</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentUsers as $user)
                        <tr>
                            <td class="td-first-16"><span class="td-name">{{ $user->full_name }}</span></td>
                            <td class="td-muted">{{ $user->email }}</td>
                            <td class="td-muted">{{ $user->created_at->format('d M Y, H:i') }}</td>
                            <td class="td-last-16">
                                <span class="badge-user-status">{{ $user->status ?? 'User' }}</span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="dash-pagination">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $recentUsers->count() }}</span> dari
                <span>{{ $recentUsers->total() }}</span> pengguna
            </div>
            {{ $recentUsers->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Chart(document.getElementById('instrumentChart'), {
            type: 'bar',
            data: {
                labels: @json(array_column($instrumentStats, 'label')),
                datasets: [{
                    label: 'Jumlah diselesaikan',
                    data: @json(array_column($instrumentStats, 'total')),
                    backgroundColor: ['#f59e0b', '#ef4444', '#10b981', '#2563eb'],
                    borderRadius: 8,
                    borderSkipped: false,
                    minBarLength: 6,
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: ctx => '  ' + ctx.parsed.x + ' kali diselesaikan' } }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(0,0,0,0.04)' },
                        ticks: { stepSize: 1, font: { size: 12 }, color: '#94a3b8', callback: val => Number.isInteger(val) ? val : null },
                        border: { display: false }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { font: { size: 13, weight: '600' }, color: '#334155' },
                        border: { display: false }
                    }
                },
                layout: { padding: { right: 16 } }
            }
        });
    });
</script>
@endsection
