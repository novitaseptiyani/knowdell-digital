@extends('layouts.dashboard')

@section('title', 'Hasil Tes - Knowdell Digital')

@section('content')
<div class="user-result-container animate-fade-up" id="result-content">

    {{-- Back --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="{{ route('counselor.dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    <div class="user-result-card">

        {{-- ===== HEADER DOKUMEN (sama dengan user) ===== --}}
        <div class="result-doc-header">
            <div class="result-doc-top-bar">
                <div class="result-doc-logo-wrap">
                    <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA" style="height: 60px; object-fit: contain;">
                    <div>
                        <div class="result-doc-uni-label">Universitas Kristen Krida Wacana</div>
                        <div class="result-doc-test-name">Jenis Tes: {{ $session->category->name }}</div>
                    </div>
                </div>
            </div>

            <div class="result-info-grid">
                <div>
                    <div class="result-info-label">Nama Peserta</div>
                    <div class="result-info-value-lg">{{ $session->user->full_name }}</div>
                </div>
                <div>
                    <div class="result-info-label">Email</div>
                    <div class="result-info-value">{{ $session->user->email }}</div>
                </div>
                <div>
                    <div class="result-info-label">Instansi</div>
                    <div class="result-info-value">{{ $session->user->institution ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">No. Ponsel</div>
                    <div class="result-info-value">{{ $session->user->phone ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">Status</div>
                    <div class="result-info-value">{{ $session->user->status ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">Tanggal Selesai</div>
                    <div class="result-info-value">{{ $session->finished_at->translatedFormat('d F Y, H:i') }}</div>
                </div>
            </div>

            <div class="result-meta-row">
                @php
                    $hours   = floor($session->duration / 3600);
                    $minutes = floor(($session->duration % 3600) / 60);
                    $seconds = $session->duration % 60;
                @endphp
                <div class="meta-badge" style="border-color:#e2e8f0;color:#475569;">
                    <i class="fa-regular fa-clock" style="color:#0f172a;"></i>
                    Durasi: @if($hours > 0) {{ $hours }}j @endif {{ $minutes }}m {{ $seconds }}d
                </div>
                <div class="meta-badge" style="border-color:#e2e8f0;color:#475569;">
                    <i class="fa-solid fa-layer-group" style="color:#0f172a;"></i>
                    {{ $session->cardSessions->count() }} Kartu Disortir
                </div>
                <div class="meta-badge" style="border-color:#e2e8f0;color:#475569;">
                    <i class="fa-solid fa-user-tie" style="color:#0f172a;"></i>
                    Konselor: {{ Auth::guard('staff')->user()->full_name }}
                </div>
            </div>
        </div>

        {{-- ===== HASIL SORTIR ===== --}}
        @php
            $groupedCards = $session->cardSessions
                ->groupBy('choice_category_id')
                ->map(fn($items) => $items->map(fn($cs) => $cs->card));

            $choiceCategories = \App\Models\ChoiceCategory::where('category_id', $session->category_id)
                ->orderBy('id')->get();
        @endphp

        {{-- Category 1: Career Values --}}
        @if($session->category_id == 1)
            @php $barColors = ['#16a34a','#2563eb','#f59e0b','#f97316','#ef4444']; @endphp
            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-list-check"></i> Hasil Sortir Career Values
                </div>
                @foreach($choiceCategories as $index => $choice)
                    @php $cardsInCategory = $groupedCards->get($choice->id, collect()); @endphp
                    <div class="category-row">
                        <div class="category-bar" style="background: {{ $barColors[$index] ?? '#94a3b8' }};"></div>
                        <div class="category-label">
                            <div class="category-label-name">{{ $choice->name }}</div>
                            <div class="category-label-count">{{ $cardsInCategory->count() }} kartu</div>
                        </div>
                        <div class="cards-list">
                            @forelse($cardsInCategory as $card)
                                <span class="card-chip">{{ $card->card_name }}</span>
                            @empty
                                <span class="empty-label">Tidak ada kartu</span>
                            @endforelse
                        </div>
                    </div>
                @endforeach
            </div>

        {{-- Category 2: Motivated Skills (sama dengan user) --}}
        @elseif($session->category_id == 2)
            @php
                $rows = [
                    ['label' => 'Sangat Suka',         'ids' => [11,12,13], 'border' => '#16a34a', 'bg' => '#f0fdf4', 'text' => '#15803d'],
                    ['label' => 'Benar-benar Senang',  'ids' => [14,15,16], 'border' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1d4ed8'],
                    ['label' => 'Suka',                'ids' => [17,18,19], 'border' => '#f59e0b', 'bg' => '#fffbeb', 'text' => '#d97706'],
                    ['label' => 'Lebih Memilih Tidak', 'ids' => [20,21,22], 'border' => '#f97316', 'bg' => '#fff7ed', 'text' => '#ea580c'],
                    ['label' => 'Sangat Tidak Suka',   'ids' => [23,24,25], 'border' => '#ef4444', 'bg' => '#fef2f2', 'text' => '#dc2626'],
                ];
                $cols           = ['Sangat Mahir', 'Kompeten', 'Kurang Menguasai'];
                $motivatedIds   = [11, 12];
                $developmentIds = [13];
                $burnoutIds     = [23, 24];
            @endphp

            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-table-cells"></i> Hasil Sortir Motivated Skills
                </div>
                <div class="matrix-wrapper">
                    <div class="matrix-grid">
                        <div></div>
                        @foreach($cols as $col)
                            <div class="matrix-col-header">{{ $col }}</div>
                        @endforeach

                        @foreach($rows as $row)
                            <div class="matrix-row-label matrix-row-label--center">
                                <span class="matrix-row-badge"
                                    style="color:#0f172a;background:#ffffff;border:1.5px solid #e2e8f0;">
                                    {{ $row['label'] }}
                                </span>
                            </div>
                            @foreach($row['ids'] as $choiceId)
                                @php
                                    $cardsInCell   = $groupedCards->get($choiceId, collect());
                                    $isMotivated   = in_array($choiceId, $motivatedIds);
                                    $isDevelopment = in_array($choiceId, $developmentIds);
                                    $isBurnout     = in_array($choiceId, $burnoutIds);
                                    $cellBorder    = $isMotivated   ? '#16a34a'
                                                   : ($isDevelopment ? '#f59e0b'
                                                   : ($isBurnout     ? '#dc2626' : '#e2e8f0'));
                                @endphp
                                <div class="matrix-cell" style="background:#ffffff;border-color:{{ $cellBorder }};overflow:hidden;padding:0;">
                                    @if($isMotivated)
                                        <div style="background:#16a34a;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">MOTIVATED SKILLS</div>
                                    @elseif($isDevelopment)
                                        <div style="background:#f59e0b;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">AREA PENGEMBANGAN</div>
                                    @elseif($isBurnout)
                                        <div style="background:#dc2626;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">BURNOUT SKILLS</div>
                                    @endif
                                    <div style="padding:0.5rem;">
                                        <div class="cell-count" style="color:#94a3b8;">{{ $cardsInCell->count() }} kartu</div>
                                        @if($cardsInCell->isEmpty())
                                            <div class="empty-label" style="text-align:center;padding:0.5rem 0;">—</div>
                                        @else
                                            <div class="cell-cards">
                                                @foreach($cardsInCell as $card)
                                                    <span class="cell-chip--row" style="background:#f8fafc;color:#334155;border-color:#e2e8f0;">{{ $card->card_name }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Analisis Zona --}}
            @php
                $motivatedCards   = collect($motivatedIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
                $developmentCards = collect($developmentIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
                $burnoutCards     = collect($burnoutIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
            @endphp
            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-star"></i> Analisis Zona Penting
                </div>
                <div class="zona-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem;">
                    <div style="border-radius:16px;border:1.5px solid #16a34a;background:#16a34a;padding:1.25rem;">
                        <div style="font-size:0.7rem;font-weight:800;color:#bbf7d0;letter-spacing:0.08em;margin-bottom:0.35rem;">ZONA 1</div>
                        <div style="font-size:1rem;font-weight:800;color:white;margin-bottom:0.75rem;">Motivated Skills</div>
                        <div style="font-size:0.78rem;color:#dcfce7;line-height:1.6;margin-bottom:1rem;">Keterampilan ini berada di zona terbaik — kamu tidak hanya <strong style="color:white;">menyukainya, tetapi juga menguasainya</strong> dengan baik. Ini adalah kekuatan sejatimu yang perlu dipertahankan dan terus dikembangkan. Karier yang ideal adalah karier yang memungkinkan kamu menggunakan keterampilan ini setiap hari. Jadikan keterampilan di zona ini sebagai <strong style="color:white;">fondasi utama</strong> dalam merencanakan jalur karier yang memuaskan dan berkelanjutan.</div>
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                            @forelse($motivatedCards as $card)
                                <span style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.35);border-radius:50px;padding:0.2rem 0.7rem;font-size:0.75rem;font-weight:600;">{{ $card->card_name }}</span>
                            @empty
                                <p style="font-size:0.8rem;color:#bbf7d0;font-style:italic;margin:0;">Tidak ada kartu.</p>
                            @endforelse
                        </div>
                    </div>
                    <div style="border-radius:16px;border:1.5px solid #d97706;background:#f59e0b;padding:1.25rem;">
                        <div style="font-size:0.7rem;font-weight:800;color:#fef9c3;letter-spacing:0.08em;margin-bottom:0.35rem;">ZONA 2</div>
                        <div style="font-size:1rem;font-weight:800;color:white;margin-bottom:0.75rem;">Area Pengembangan</div>
                        <div style="font-size:0.78rem;color:#fef9c3;line-height:1.6;margin-bottom:1rem;">Keterampilan di zona ini mencerminkan <strong style="color:white;">minat dan passion</strong> kamu yang sesungguhnya — kamu sangat menyukainya, namun kemampuanmu belum mencapai tingkat yang kamu inginkan. Ini adalah <strong style="color:white;">peluang emas untuk berkembang</strong>. Dengan investasi waktu, latihan, dan bimbingan yang tepat, keterampilan ini berpotensi menjadi Motivated Skills di masa depan. Pertimbangkan untuk mengambil kursus atau mencari pengalaman langsung di bidang ini.</div>
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                            @forelse($developmentCards as $card)
                                <span style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.35);border-radius:50px;padding:0.2rem 0.7rem;font-size:0.75rem;font-weight:600;">{{ $card->card_name }}</span>
                            @empty
                                <p style="font-size:0.8rem;color:#fef9c3;font-style:italic;margin:0;">Tidak ada kartu.</p>
                            @endforelse
                        </div>
                    </div>
                    <div style="border-radius:16px;border:1.5px solid #b91c1c;background:#dc2626;padding:1.25rem;">
                        <div style="font-size:0.7rem;font-weight:800;color:#fecaca;letter-spacing:0.08em;margin-bottom:0.35rem;">ZONA 3</div>
                        <div style="font-size:1rem;font-weight:800;color:white;margin-bottom:0.75rem;">Burnout Skills</div>
                        <div style="font-size:0.78rem;color:#fee2e2;line-height:1.6;margin-bottom:1rem;">Keterampilan di zona ini adalah keterampilan yang klien miliki dan kuasai, namun <strong style="color:white;">tidak memberikan kepuasan atau kesenangan</strong> baginya. Menghabiskan sebagian besar waktu kerja dengan keterampilan ini berisiko menyebabkan <strong style="color:white;">kelelahan dan burnout</strong> dalam jangka panjang. Meskipun bisa menjadi aset dalam situasi tertentu, hindari menjadikannya fokus utama karier. Diskusikan cara meminimalkan ketergantungan pada keterampilan ini.</div>
                        <div style="display:flex;flex-wrap:wrap;gap:0.4rem;">
                            @forelse($burnoutCards as $card)
                                <span style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.35);border-radius:50px;padding:0.2rem 0.7rem;font-size:0.75rem;font-weight:600;">{{ $card->card_name }}</span>
                            @empty
                                <p style="font-size:0.8rem;color:#fecaca;font-style:italic;margin:0;">Tidak ada kartu.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        {{-- Category 3: Leisure & Retirement (sama dengan user) --}}
        @elseif($session->category_id == 3)
            @php
                $columns = [
                    ['id' => 6,  'label' => 'Setiap Hari', 'sub' => 'Daily',        'border' => '#16a34a', 'bg' => '#f0fdf4', 'text' => '#15803d', 'chip_bg' => '#dcfce7', 'chip_border' => '#86efac'],
                    ['id' => 7,  'label' => 'Sering',      'sub' => 'Regularly',    'border' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1d4ed8', 'chip_bg' => '#dbeafe', 'chip_border' => '#93c5fd'],
                    ['id' => 8,  'label' => 'Sesekali',    'sub' => 'Occasionally', 'border' => '#f59e0b', 'bg' => '#fffbeb', 'text' => '#d97706', 'chip_bg' => '#fef9c3', 'chip_border' => '#fcd34d'],
                    ['id' => 9,  'label' => 'Jarang',      'sub' => 'Seldom',       'border' => '#f97316', 'bg' => '#fff7ed', 'text' => '#ea580c', 'chip_bg' => '#ffedd5', 'chip_border' => '#fdba74'],
                    ['id' => 10, 'label' => 'Tidak Pernah','sub' => 'Never',        'border' => '#ef4444', 'bg' => '#fef2f2', 'text' => '#dc2626', 'chip_bg' => '#fee2e2', 'chip_border' => '#fca5a5'],
                ];
            @endphp
            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-table-columns" style="color:#16a34a;"></i>
                    Hasil Sortir Leisure & Retirement Activities
                </div>
                <div class="leisure-result-grid" style="display:grid;grid-template-columns:repeat(5,1fr);gap:12px;">
                    @foreach($columns as $col)
                        @php $cardsInCol = $groupedCards->get($col['id'], collect()); @endphp
                        <div>
                            <div class="leisure-col-header" style="background:{{ $col['bg'] }};border:1.5px solid {{ $col['border'] }};border-radius:10px;padding:0.5rem;text-align:center;margin-bottom:8px;">
                                <div style="font-size:0.82rem;font-weight:800;color:{{ $col['text'] }};">{{ $col['label'] }}</div>
                                <div style="font-size:0.65rem;color:{{ $col['text'] }};opacity:0.7;font-style:italic;">{{ $col['sub'] }}</div>
                                <div style="font-size:0.7rem;font-weight:600;color:{{ $col['text'] }};margin-top:2px;">{{ $cardsInCol->count() }} kartu</div>
                            </div>
                            <div style="display:flex;flex-direction:column;gap:4px;">
                                @forelse($cardsInCol as $card)
                                    <div class="leisure-col-chip" style="background:{{ $col['chip_bg'] }};border:1px solid {{ $col['chip_border'] }};border-radius:8px;padding:0.35rem 0.6rem;font-size:0.75rem;font-weight:600;color:{{ $col['text'] }};line-height:1.3;">{{ $card->card_name }}</div>
                                @empty
                                    <div class="leisure-col-empty" style="text-align:center;padding:1rem;color:#cbd5e1;font-size:0.8rem;font-style:italic;">—</div>
                                @endforelse
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Priority Daily --}}
            @php $dailyCards = $groupedCards->get(6, collect()); @endphp
            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-star" style="color:#16a34a;"></i> Aktivitas Prioritas Utama Klien
                </div>
                <div class="leisure-priority-box" style="background:#16a34a;border-radius:16px;padding:1.25rem;margin-bottom:1rem;">
                    <div style="font-size:0.7rem;font-weight:800;color:#bbf7d0;letter-spacing:0.08em;margin-bottom:0.35rem;">SETIAP HARI — DAILY</div>
                    <div style="font-size:0.9rem;color:#dcfce7;line-height:1.6;margin-bottom:1rem;">Aktivitas-aktivitas ini adalah yang paling ingin dilakukan klien setiap hari. Ini mencerminkan <strong style="color:white;">nilai dan kebutuhan rekreasi terdalam</strong> klien. Jadikan informasi ini sebagai bahan diskusi dalam sesi konseling untuk membantu klien merancang gaya hidup yang seimbang dan bermakna.</div>
                    <div style="display:flex;flex-wrap:wrap;gap:0.5rem;">
                        @forelse($dailyCards as $card)
                            <span style="background:rgba(255,255,255,0.2);color:white;border:1px solid rgba(255,255,255,0.35);border-radius:50px;padding:0.25rem 0.75rem;font-size:0.8rem;font-weight:600;">{{ $card->card_name }}</span>
                        @empty
                            <p style="font-size:0.85rem;color:#bbf7d0;font-style:italic;margin:0;">Tidak ada aktivitas di kategori ini.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        {{-- ===== CATATAN & REKOMENDASI (khusus konselor) ===== --}}
        <div class="result-section">
            <div class="result-card-title">
                <i class="fa-solid fa-comment-dots"></i> Catatan & Rekomendasi
            </div>
            <form method="POST" action="{{ route('counselor.recommendation', $session->id) }}">
                @csrf
                <textarea name="recommendation" rows="6"
                    placeholder="Tulis catatan atau rekomendasi untuk klien ini..."
                    class="recommendation-textarea">{{ old('recommendation', $session->testResult?->recommendation) }}</textarea>
                @error('recommendation')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                <button type="submit" class="btn-save-recommendation">
                    <i class="fa-solid fa-floppy-disk"></i> Simpan Rekomendasi
                </button>
            </form>
        </div>

    </div>

</div>
@endsection

@if(session('status') === 'recommendation-saved')
    <div id="toast-notification" class="toast-success">
        <i class="fa-solid fa-circle-check"></i> Rekomendasi berhasil disimpan!
    </div>
    <script>
        setTimeout(() => {
            const t = document.getElementById('toast-notification');
            if (t) { t.style.transition='all 0.3s ease'; t.style.opacity='0'; t.style.transform='translateY(-10px)'; setTimeout(()=>t.remove(),300); }
        }, 2500);
    </script>
@endif
