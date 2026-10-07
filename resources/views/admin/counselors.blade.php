@extends('layouts.dashboard')

@section('title', 'Manajemen Konselor - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Manajemen <span>Konselor</span></h1>
            <p class="dash-page-subtitle">Daftarkan dan kelola akun konselor profesional di sini.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard Utama
        </a>
    </div>

    @if(session('status') === 'counselor-created')
        <script>
            window.addEventListener('load', function() {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Akun konselor telah berhasil didaftarkan.', confirmButtonColor: '#0f172a', padding: '2.5rem' });
            });
        </script>
    @endif

    @if(session('status') === 'counselor-deleted')
        <script>
            window.addEventListener('load', function() {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'Konselor telah dihapus' });
            });
        </script>
    @endif

    <div class="animate-fade-up" style="display: flex; flex-direction: column; gap: 2rem;">

        {{-- Daftar Konselor --}}
        <div class="dash-card">
            <div class="dash-section-header">
                <div class="dash-section-title-group">
                    <div class="dash-accent-bar"></div>
                    <h3 class="dash-section-title">Daftar Konselor Aktif</h3>
                </div>
                <form action="{{ route('admin.counselors') }}" method="GET" class="section-inline-search">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari konselor..." style="width: 250px;">
                    <button type="submit" class="search-btn">
                        <i class="fa-solid fa-magnifying-glass"></i> Cari
                    </button>
                </form>
            </div>

            <div style="overflow-x: auto;">
                <table class="dash-table">
                    <thead>
                        <tr>
                            <th class="th-lg">Konselor</th>
                            <th class="th-lg">Email</th>
                            <th style="padding: 0 1.25rem; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($counselors as $c)
                            <tr>
                                <td class="td-lg td-first-20">
                                    <div class="td-user-wrap">
                                        <div class="table-avatar table-avatar--gray">{{ substr($c->full_name, 0, 1) }}</div>
                                        <div class="td-name">{{ $c->full_name }}</div>
                                    </div>
                                </td>
                                <td class="td-lg td-muted">{{ $c->email }}</td>
                                <td class="td-lg td-last-20 td-right">
                                    <button type="button" onclick="confirmDelete('{{ $c->id }}')" class="btn-delete" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <form id="delete-form-{{ $c->id }}" action="{{ route('admin.counselors.destroy', $c) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="table-empty" style="padding: 4rem;">
                                        <div class="table-empty-icon"><i class="fa-solid fa-inbox"></i></div>
                                        <p class="table-empty-text">Belum ada konselor yang terdaftar.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="dash-pagination dash-pagination--lg">
                <div class="dash-pagination-info">
                    Menampilkan <span>{{ $counselors->count() }}</span> dari
                    <span>{{ $counselors->total() }}</span> konselor
                </div>
                {{ $counselors->links() }}
            </div>
        </div>

        {{-- Form Tambah Konselor --}}
        <div class="dash-card">
            <div class="dash-section-title-group" style="margin-bottom: 2rem;">
                <div class="dash-accent-bar dash-accent-bar--blue"></div>
                <h3 class="dash-section-title">Tambah Konselor Baru</h3>
            </div>

            <form method="POST" action="{{ route('admin.counselors.store') }}">
                @csrf
                <div class="admin-form-grid">
                    <div>
                        <label class="admin-form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" required
                            class="admin-form-input focus-blue"
                            placeholder="Masukkan nama konselor">
                        @error('full_name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Email Akun</label>
                        <input type="email" name="email" required
                            class="admin-form-input focus-blue"
                            placeholder="Masukkan email">
                        @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Password Awal</label>
                        <input type="password" name="password" required
                            class="admin-form-input focus-blue"
                            placeholder="Minimal 8 karakter, kombinasi huruf & angka">
                        @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="admin-form-input focus-blue"
                            placeholder="Konfirmasi password">
                    </div>
                </div>
                <button type="submit" class="btn-form-submit">Daftarkan Sekarang</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDelete(userId) {
        Swal.fire({
            title: 'Hapus Konselor?', text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-form-' + userId).submit();
        });
    }
</script>
@endsection
