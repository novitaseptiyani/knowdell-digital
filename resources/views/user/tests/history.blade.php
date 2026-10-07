@extends('layouts.dashboard')

@section('title', 'Riwayat Tes - Knowdell Digital')

@section('content')
    <div class="dash-container animate-fade-up">

        {{-- Header --}}
        <div class="dash-page-header">
            <div>
                <a href="{{ route('dashboard') }}" class="btn-back">
                    <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
                </a>
                <h1 class="dash-page-title" style="margin-top: 1rem;">Riwayat <span>Tes Kamu</span></h1>
                <p class="dash-page-subtitle">Semua hasil tes yang pernah kamu selesaikan.</p>
            </div>
        </div>

        <div class="dash-card">

            @if($sessions->isEmpty())
                <div class="table-empty">
                    <div class="table-empty-icon"><i class="fa-regular fa-clipboard"></i></div>
                    <p class="table-empty-text">Belum ada riwayat tes.</p>
                </div>
            @else
                <div style="overflow-x: auto;">
                    <table class="dash-table">
                        <thead>
                            <tr>
                                <th>INSTRUMEN</th>
                                <th>TANGGAL SELESAI</th>
                                <th>DURASI</th>
                                <th>AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sessions as $session)
                                <tr>
                                    <td class="td-first-16 td-center">
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
                                    <td class="td-last-16 td-center td-nowrap"
                                        style="display: flex; gap: 0.5rem; justify-content: center; align-items: center;">
                                        {{-- Lihat Hasil --}}
                                        <a href="{{ route('tests.result', ['id' => $session->category_id, 'session' => $session->id]) }}"
                                            class="btn-action">
                                            Lihat Hasil
                                        </a>

                                        {{-- Tombol Hapus --}}
                                        <form id="delete-form-{{ $session->id }}" method="POST"
                                            action="{{ route('tests.session.destroy', $session->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn-delete" title="Hapus"
                                                onclick="confirmDelete('delete-form-{{ $session->id }}')">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="dash-pagination">
                    <style>
                        /* Basic styling for bootstrap pagination if bootstrap CSS is not loaded */
                        .dash-pagination .pagination {
                            display: flex;
                            list-style: none;
                            padding: 0;
                            margin: 1rem 0 0 0;
                            gap: 0.25rem;
                            justify-content: center;
                        }

                        .dash-pagination .page-link {
                            padding: 0.35rem 0.75rem;
                            border: 1px solid #e2e8f0;
                            border-radius: 6px;
                            color: #475569;
                            background: white;
                            text-decoration: none;
                            font-size: 0.85rem;
                        }

                        .dash-pagination .page-item.active .page-link {
                            background-color: #3b82f6;
                            color: white;
                            border-color: #3b82f6;
                        }

                        .dash-pagination .page-item.disabled .page-link {
                            color: #cbd5e1;
                            background: #f8fafc;
                            pointer-events: none;
                        }
                    </style>
                    <div class="dash-pagination-info">
                        Menampilkan <span>{{ $sessions->count() }}</span> dari
                        <span>{{ $sessions->total() }}</span> hasil tes
                    </div>
                    {{ $sessions->links() }}
                </div>
            @endif

        </div>
    </div>

    {{-- Toast setelah hapus --}}
    @if(session('status') === 'session-deleted')
        <div id="toast-notification" class="toast-success">
            <i class="fa-solid fa-circle-check"></i> Riwayat tes berhasil dihapus.
        </div>
        <script>
            setTimeout(() => {
                const t = document.getElementById('toast-notification');
                if (t) { t.style.transition = 'all 0.3s ease'; t.style.opacity = '0'; t.style.transform = 'translateY(-10px)'; setTimeout(() => t.remove(), 300); }
            }, 2500);
        </script>
    @endif

    <script>
        function confirmDelete(formId) {
            Swal.fire({
                title: 'Hapus Riwayat Tes?',
                text: 'Tindakan ini tidak dapat dibatalkan dan semua data tes akan dihapus permanen.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<i class="fa-solid fa-trash"></i> Ya, Hapus',
                cancelButtonText: 'Batal',
                customClass: {
                    popup: 'swal-popup-custom',
                    title: 'swal-title-custom',
                    htmlContainer: 'swal-text-custom',
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(formId).submit();
                }
            });
        }
    </script>
@endsection