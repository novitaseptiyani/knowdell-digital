@extends('layouts.dashboard')

@section('title', 'Kelola Admin - Knowdell Digital')

@section('content')
<div class="dash-container">

    <div class="dash-page-header animate-fade-up">
        <div>
            <h1 class="dash-page-title">Kelola <span>Administrator</span></h1>
            <p class="dash-page-subtitle">Daftarkan dan kelola akun administrator di sini.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Dashboard Utama
        </a>
    </div>

    @if(session('error'))
        <div class="alert-error">
            <i class="fa-solid fa-circle-exclamation"></i> {{ session('error') }}
        </div>
    @endif

    @if(session('status') === 'admin-created')
        <script>
            window.addEventListener('load', function() {
                Swal.fire({ icon: 'success', title: 'Berhasil!', text: 'Akun administrator telah berhasil didaftarkan.', confirmButtonColor: '#0f172a', padding: '2.5rem' });
            });
        </script>
    @endif

    @if(session('status') === 'admin-deleted')
        <script>
            window.addEventListener('load', function() {
                const Toast = Swal.mixin({ toast: true, position: 'top-end', showConfirmButton: false, timer: 3000, timerProgressBar: true });
                Toast.fire({ icon: 'success', title: 'Administrator telah dihapus' });
            });
        </script>
    @endif

    <div class="animate-fade-up" style="display: flex; flex-direction: column; gap: 2rem;">

        {{-- Daftar Admin --}}
        <div class="dash-card">
            <div class="dash-section-title-group" style="margin-bottom: 2rem;">
                <div class="dash-accent-bar"></div>
                <h3 class="dash-section-title">Daftar Administrator Aktif</h3>
            </div>

            <table class="dash-table">
                <thead>
                    <tr>
                        <th class="th-lg">Administrator</th>
                        <th class="th-lg">Email</th>
                        <th style="padding: 0 1.25rem; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admins as $a)
                        <tr>
                            <td class="td-lg td-first-20">
                                <div class="td-user-wrap">
                                    <div class="table-avatar table-avatar--purple">{{ substr($a->full_name, 0, 1) }}</div>
                                    <div>
                                        <div class="td-name">{{ $a->full_name }}</div>
                                        @if($a->id === auth('staff')->id())
                                            <div class="badge-self">(Anda)</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="td-lg td-muted">{{ $a->email }}</td>
                            <td class="td-lg td-last-20 td-right">
                                @if($a->id !== auth('staff')->id())
                                    <button type="button" onclick="confirmDeleteAdmin('{{ $a->id }}')" class="btn-delete" title="Hapus">
                                        <i class="fa-regular fa-trash-can"></i>
                                    </button>
                                    <form id="delete-admin-form-{{ $a->id }}" action="{{ route('admin.admins.destroy', $a) }}" method="POST" style="display: none;">
                                        @csrf @method('DELETE')
                                    </form>
                                @else
                                    <span style="font-size: 0.75rem; color: #cbd5e1; font-weight: 600;">—</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">
                                <div class="table-empty" style="padding: 4rem;">
                                    <div class="table-empty-icon"><i class="fa-solid fa-inbox"></i></div>
                                    <p class="table-empty-text">Belum ada administrator lain.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="dash-pagination dash-pagination--lg">
                <div class="dash-pagination-info">
                    Menampilkan <span>{{ $admins->count() }}</span> dari
                    <span>{{ $admins->total() }}</span> administrator
                </div>
                {{ $admins->links() }}
            </div>
        </div>

        {{-- Form Tambah Admin --}}
        <div class="dash-card">
            <div class="dash-section-title-group" style="margin-bottom: 2rem;">
                <div class="dash-accent-bar" style="background: #8b5cf6;"></div>
                <h3 class="dash-section-title">Tambah Administrator Baru</h3>
            </div>

            <form method="POST" action="{{ route('admin.admins.store') }}">
                @csrf
                <div class="admin-form-grid">
                    <div>
                        <label class="admin-form-label">Nama Lengkap</label>
                        <input type="text" name="full_name" required
                            class="admin-form-input focus-purple"
                            placeholder="Masukkan nama administrator">
                        @error('full_name') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Email Akun</label>
                        <input type="email" name="email" required
                            class="admin-form-input focus-purple"
                            placeholder="Masukkan email">
                        @error('email') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Password Awal</label>
                        <input type="password" name="password" required
                            class="admin-form-input focus-purple"
                            placeholder="Minimal 8 karakter, kombinasi huruf & angka">
                        @error('password') <p class="text-danger">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="admin-form-label">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required
                            class="admin-form-input focus-purple"
                            placeholder="Konfirmasi password">
                    </div>
                </div>
                <button type="submit" class="btn-form-submit">Daftarkan Sekarang</button>
            </form>
        </div>
    </div>
</div>

<script>
    function confirmDeleteAdmin(adminId) {
        Swal.fire({
            title: 'Hapus Administrator?', text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning', showCancelButton: true,
            confirmButtonColor: '#ef4444', cancelButtonColor: '#64748b',
            confirmButtonText: 'Ya, Hapus!', cancelButtonText: 'Batal',
        }).then((result) => {
            if (result.isConfirmed) document.getElementById('delete-admin-form-' + adminId).submit();
        });
    }
</script>
@endsection
