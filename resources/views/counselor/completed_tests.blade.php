@extends('layouts.dashboard')

@section('title', 'Tes Selesai - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Tes <span>Selesai</span></h1>
            <p class="dash-page-subtitle">Seluruh tes yang telah diselesaikan oleh klien Anda.</p>
        </div>
        <a href="{{ route('counselor.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="dash-card animate-fade-up">

        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar dash-accent-bar--green"></div>
                <h3 class="dash-section-title">Semua Tes Selesai</h3>
            </div>
            <a href="{{ route('counselor.export', request()->only(['tes', 'tanggal', 'tinjauan'])) }}" class="btn-csv">
                <i class="fa-solid fa-file-excel"></i> Download CSV
            </a>
        </div>

        {{-- Filter --}}
        <form action="{{ route('counselor.completed_tests') }}" method="GET" class="dash-filter">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau instansi..."
                class="dash-input dash-input--flex">
            <select name="tes" class="dash-select dash-select--w200">
                <option value="">Semua Tes</option>
                <option value="Career Values"                  {{ request('tes') == 'Career Values' ? 'selected' : '' }}>Career Values</option>
                <option value="Motivated Skills"               {{ request('tes') == 'Motivated Skills' ? 'selected' : '' }}>Motivated Skills</option>
                <option value="Occupational Interests"         {{ request('tes') == 'Occupational Interests' ? 'selected' : '' }}>Occupational Interests</option>
                <option value="Leisure and Retirement Activities" {{ request('tes') == 'Leisure and Retirement Activities' ? 'selected' : '' }}>Leisure & Retirement</option>
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" lang="id"
                class="dash-input dash-input--w170 dash-input--date">
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>

        <div style="overflow-x: auto;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th>KLIEN</th>
                        <th>JENIS TES</th>
                        <th>TANGGAL SELESAI</th>
                        <th>DURASI</th>
                        <th>STATUS TINJAUAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($completedTests as $session)
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
                            <td class="td-center td-nowrap">
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
                            <td class="td-last-16 td-center">
                                <a href="{{ route('counselor.result', $session->id) }}" class="btn-action">Lihat Hasil</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="table-empty">
                                    <div class="table-empty-icon"><i class="fa-solid fa-clipboard-list"></i></div>
                                    <p class="table-empty-text">Belum ada tes yang diselesaikan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dash-pagination">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $completedTests->count() }}</span> dari
                <span>{{ $completedTests->total() }}</span> tes
            </div>
            {{ $completedTests->links() }}
        </div>
    </div>
</div>
@endsection
