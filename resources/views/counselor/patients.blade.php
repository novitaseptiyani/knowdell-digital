@extends('layouts.dashboard')

@section('title', 'Daftar Klien - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Daftar <span>Klien Saya</span></h1>
            <p class="dash-page-subtitle">Kelola dan pantau seluruh klien yang ditugaskan kepada Anda.</p>
        </div>
        <a href="{{ route('counselor.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard
        </a>
    </div>

    <div class="dash-card animate-fade-up">

        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar dash-accent-bar--blue"></div>
                <h3 class="dash-section-title">Semua Klien</h3>
            </div>
            <a href="{{ route('counselor.export.patients') }}" class="btn-csv">
                <i class="fa-solid fa-file-excel"></i> Download CSV
            </a>
        </div>

        {{-- Filter --}}
        <form action="{{ route('counselor.patients') }}" method="GET" class="dash-filter dash-filter--left">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Cari nama atau instansi..."
                class="dash-input dash-input--flex2">
            <select name="status" class="dash-select dash-select--flex">
                <option value="">Semua Status</option>
                <option value="Pelajar"   {{ request('status') == 'Pelajar'   ? 'selected' : '' }}>Pelajar</option>
                <option value="Mahasiswa" {{ request('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                <option value="Umum"      {{ request('status') == 'Umum'      ? 'selected' : '' }}>Umum</option>
            </select>
            <input type="date" name="tanggal" value="{{ request('tanggal') }}" lang="id"
                class="dash-input dash-input--flex dash-input--date">
            <button type="submit" class="btn-search">
                <i class="fa-solid fa-magnifying-glass"></i> Cari
            </button>
        </form>

        <div style="overflow-x: auto;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th class="th-lg">KLIEN</th>
                        <th class="th-lg">STATUS</th>
                        <th class="th-lg">INSTANSI</th>
                        <th class="th-lg">BERGABUNG</th>
                        <th>AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td class="td-lg td-first-20">
                                <div class="td-user-wrap">
                                    <div class="table-avatar table-avatar--lg">{{ substr($patient->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="td-name">{{ $patient->full_name }}</div>
                                        <div class="td-email">{{ $patient->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-lg td-center">
                                <span class="badge-user-status">{{ $patient->status ?? '-' }}</span>
                            </td>
                            <td class="td-lg td-body td-center">{{ $patient->institution ?? '-' }}</td>
                            <td class="td-lg td-body td-center">{{ $patient->created_at->format('d M Y') }}</td>
                            <td class="td-lg td-last-20 td-center">
                                <a href="{{ route('counselor.patient', $patient->id) }}" class="btn-action">Lihat Detail</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="table-empty" style="padding: 4rem;">
                                    <div class="table-empty-icon"><i class="fa-solid fa-users-slash"></i></div>
                                    <p class="table-empty-text">Belum ada klien yang ditugaskan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dash-pagination">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $patients->count() }}</span> dari
                <span>{{ $patients->total() }}</span> klien
            </div>
            {{ $patients->links() }}
        </div>
    </div>
</div>
@endsection
