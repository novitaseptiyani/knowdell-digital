@extends('layouts.dashboard')

@section('title', 'Manajemen User - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Manajemen <span>User</span></h1>
            <p class="dash-page-subtitle">Pantau, atur, dan bantu pengguna platform Knowdell Digital.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard Utama
        </a>
    </div>

    @if(session('status') === 'user-deleted')
        <script>
            window.addEventListener('load', function() {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'User telah dihapus' });
            });
        </script>
    @endif

    <div class="dash-card animate-fade-up">
        <div class="dash-section-header">
            <div class="dash-section-title-group">
                <div class="dash-accent-bar dash-accent-bar--blue"></div>
                <h3 class="dash-section-title">Daftar Pengguna Aktif</h3>
            </div>
            <form action="{{ route('admin.users') }}" method="GET" class="section-inline-search">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau email..." style="width: 220px;">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="Pelajar"   {{ request('status') == 'Pelajar'   ? 'selected' : '' }}>Pelajar</option>
                    <option value="Mahasiswa" {{ request('status') == 'Mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="Umum"      {{ request('status') == 'Umum'      ? 'selected' : '' }}>Umum</option>
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
                        <th class="th-lg">STATUS</th>
                        <th class="th-lg">BERGABUNG</th>
                        <th style="padding: 0 1rem; text-align: center;">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($users as $user)
                        <tr>
                            <td class="td-lg td-first-20">
                                <div class="td-user-wrap">
                                    <div class="table-avatar table-avatar--gray table-avatar--lg">{{ substr($user->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="td-name">{{ $user->full_name }}</div>
                                        <div class="td-email">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="td-lg">
                                <span class="badge-user-status">{{ $user->status }}</span>
                            </td>
                            <td class="td-lg td-body">{{ $user->created_at->format('d M Y') }}</td>
                            <td class="td-lg td-last-20 td-right">
                                <button type="button" onclick="confirmDeleteUser('{{ $user->id }}')" class="btn-delete" title="Hapus">
                                    <i class="fa-regular fa-trash-can"></i>
                                </button>
                                <form id="delete-user-form-{{ $user->id }}" action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display: none;">
                                    @csrf @method('DELETE')
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">
                                <div class="table-empty" style="padding: 4rem;">
                                    <div class="table-empty-icon"><i class="fa-solid fa-user-slash"></i></div>
                                    <p class="table-empty-text">Tidak ada data pengguna ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="dash-pagination">
            <div class="dash-pagination-info">
                Menampilkan <span>{{ $users->count() }}</span> dari
                <span>{{ $users->total() }}</span> pengguna
            </div>
            {{ $users->links() }}
        </div>
    </div>
</div>

<script>
    function confirmDeleteUser(userId) {
        Swal.fire({
            title: 'Hapus User?', text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-user-form-' + userId).submit();
        });
    }
</script>
@endsection
