@extends('layouts.dashboard')

@section('title', 'Manajemen Penugasan - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Manajemen <span>Penugasan</span></h1>
            <p class="dash-page-subtitle">Pasangkan pengguna dengan konselor yang tepat untuk pendampingan karier.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard Utama
        </a>
    </div>

    @if(session('status') === 'assignment-updated')
        <script>
            window.addEventListener('load', function() {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'Penugasan diperbarui!' });
            });
        </script>
    @endif

    @if(session('status') === 'assignment-removed')
        <script>
            window.addEventListener('load', function() {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'Konselor berhasil dilepas' });
            });
        </script>
    @endif

    <div class="dash-card animate-fade-up">
        <div class="dash-section-header" style="flex-wrap: wrap; gap: 1rem;">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar dash-accent-bar--yellow"></div>
                <h3 class="dash-section-title">Pemetaan Konselor</h3>
            </div>
            <form action="{{ route('admin.assignments') }}" method="GET" class="section-inline-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." style="width: 200px;">
                <select name="filter">
                    <option value="">Semua</option>
                    <option value="assigned"   {{ request('filter') == 'assigned'   ? 'selected' : '' }}>Sudah Punya Konselor</option>
                    <option value="unassigned" {{ request('filter') == 'unassigned' ? 'selected' : '' }}>Belum Punya Konselor</option>
                </select>
                <button type="submit" class="search-btn">
                    <i class="fa-solid fa-magnifying-glass"></i> Cari
                </button>
            </form>
        </div>

        <div style="overflow-x: auto;">
            <table class="dash-table">
                <thead>
                    <tr>
                        <th class="th-lg">PENGGUNA</th>
                        <th class="th-lg">KONSELOR SAAT INI</th>
                        <th style="padding: 0 1.5rem; text-align: center;">GANTI KONSELOR</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        <tr>
                            <td class="td-lg td-first-20">
                                <div class="td-user-wrap">
                                    <div class="table-avatar table-avatar--yellow table-avatar--lg">{{ substr($student->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="td-name">{{ $student->full_name }}</div>
                                        <div class="td-email">{{ $student->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-lg">
                                @if($student->counselor)
                                    <div class="cell-assigned">
                                        <i class="fa-solid fa-user-check"></i>
                                        <span>{{ $student->counselor->counselor->full_name ?? 'Konselor Tidak Ditemukan' }}</span>
                                    </div>
                                @else
                                    <div class="cell-unassigned">
                                        <i class="fa-solid fa-user-minus"></i>
                                        <span>Belum Ditugaskan</span>
                                    </div>
                                @endif
                            </td>
                            <td class="td-lg td-last-20">
                                <div class="assign-action-row">
                                    <form method="POST" action="{{ route('admin.assignments.update', $student) }}" style="display: flex; gap: 0.75rem; align-items: center;">
                                        @csrf
                                        <select name="counselor_id" class="assign-select">
                                            <option value="">-- Pilih Konselor --</option>
                                            @foreach($counselors as $c)
                                                <option value="{{ $c->id }}" {{ optional($student->counselor)->counselor_id == $c->id ? 'selected' : '' }}>
                                                    {{ $c->full_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <button type="submit" class="assign-save-btn">Simpan</button>
                                    </form>
                                    @if($student->counselor)
                                        <form method="POST" action="{{ route('admin.assignments.unassign', $student) }}">
                                            @csrf @method('DELETE')
                                            <button type="button" onclick="confirmUnassign(this.form)" class="btn-delete" title="Lepas Konselor">
                                                <i class="fa-solid fa-user-minus"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="table-empty" style="padding: 4rem;">
                                    <div class="table-empty-icon"><i class="fa-solid fa-users-slash"></i></div>
                                    <p class="table-empty-text">Belum ada pengguna terdaftar.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dash-pagination">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $students->count() }}</span> dari
                <span>{{ $students->total() }}</span> pengguna
            </div>
            {{ $students->links() }}
        </div>
    </div>
</div>

<script>
    function confirmUnassign(form) {
        Swal.fire({
            title: 'Lepas Konselor?', text: "Pengguna ini tidak akan punya konselor setelah ini.",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Lepas!', cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    }
</script>
@endsection
