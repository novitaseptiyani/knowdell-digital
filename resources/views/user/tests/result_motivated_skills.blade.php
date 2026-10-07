@extends('layouts.dashboard')

@section('title', 'Hasil Tes - Motivated Skills')

@section('content')
<div class="user-result-container animate-fade-up" id="result-content">

    {{-- Back --}}
    <div style="margin-bottom: 1.5rem;" class="no-print">
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    {{-- Satu Card Utama --}}
    <div class="user-result-card">

        {{-- Header Dokumen --}}
        <div class="result-doc-header">
            <div class="result-doc-top-bar">
                <div class="result-doc-logo-wrap">
                    <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA" style="height: 60px; object-fit: contain;">
                    <div>
                        <div class="result-doc-uni-label">Universitas Kristen Krida Wacana</div>
                        <div class="result-doc-test-name">Jenis Tes: Motivated Skills</div>
                    </div>
                </div>
            </div>

            <div class="result-info-grid">
                <div>
                    <div class="result-info-label">Nama Peserta</div>
                    <div class="result-info-value-lg">{{ Auth::user()->full_name }}</div>
                </div>
                <div>
                    <div class="result-info-label">Email</div>
                    <div class="result-info-value">{{ Auth::user()->email }}</div>
                </div>
                <div>
                    <div class="result-info-label">Instansi</div>
                    <div class="result-info-value">{{ Auth::user()->institution ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">No. Ponsel</div>
                    <div class="result-info-value">{{ Auth::user()->phone ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">Status</div>
                    <div class="result-info-value">{{ Auth::user()->status ?? '-' }}</div>
                </div>
                <div>
                    <div class="result-info-label">Tanggal Selesai</div>
                    <div class="result-info-value">{{ $session->finished_at->translatedFormat('d F Y, H:i') }}</div>
                </div>
            </div>

            <div class="result-meta-row">
                <div class="meta-badge meta-badge--red">
                    <i class="fa-regular fa-clock"></i>
                    Durasi:
                    @if($duration['hours'] > 0) {{ $duration['hours'] }}j @endif
                    {{ $duration['minutes'] }}m {{ $duration['seconds'] }}d
                </div>
                <div class="meta-badge meta-badge--red">
                    <i class="fa-solid fa-layer-group"></i>
                    {{ $session->cardSessions->count() }} Kartu Disortir
                </div>
                @if(Auth::user()->counselor?->counselor)
                    <div class="meta-badge meta-badge--red">
                        <i class="fa-solid fa-user-tie"></i>
                        Konselor: {{ Auth::user()->counselor->counselor->full_name }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Matrix Hasil --}}
        @php
            $rows = [
                ['id' => 11, 'label' => 'Sangat Suka',         'ids' => [11,12,13], 'border' => '#16a34a', 'bg' => '#f0fdf4', 'text' => '#15803d'],
                ['id' => 14, 'label' => 'Benar-benar Senang',  'ids' => [14,15,16], 'border' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1d4ed8'],
                ['id' => 17, 'label' => 'Suka',                'ids' => [17,18,19], 'border' => '#f59e0b', 'bg' => '#fffbeb', 'text' => '#d97706'],
                ['id' => 20, 'label' => 'Lebih Memilih Tidak', 'ids' => [20,21,22], 'border' => '#f97316', 'bg' => '#fff7ed', 'text' => '#ea580c'],
                ['id' => 23, 'label' => 'Sangat Tidak Suka',   'ids' => [23,24,25], 'border' => '#ef4444', 'bg' => '#fef2f2', 'text' => '#dc2626'],
            ];
            $cols = ['Sangat Mahir', 'Kompeten', 'Kurang Menguasai'];

            $motivatedIds   = [11, 12];
            $developmentIds = [13];
            $burnoutIds     = [23, 24];
        @endphp

        <div class="result-section result-section--bordered">
            <div class="result-card-title">
                <i class="fa-solid fa-table-cells"></i>
                Hasil Sortir Motivated Skills
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

                                {{-- Zone label strip --}}
                                @if($isMotivated)
                                    <div style="background:#16a34a;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">
                                        MOTIVATED SKILLS
                                    </div>
                                @elseif($isDevelopment)
                                    <div style="background:#f59e0b;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">
                                        AREA PENGEMBANGAN
                                    </div>
                                @elseif($isBurnout)
                                    <div style="background:#dc2626;color:white;text-align:center;font-size:0.55rem;font-weight:800;padding:2px 4px;letter-spacing:0.08em;">
                                        BURNOUT SKILLS
                                    </div>
                                @endif

                                <div style="padding:0.5rem;">
                                    <div class="cell-count" style="color:#94a3b8;">
                                        {{ $cardsInCell->count() }} kartu
                                    </div>
                                    @if($cardsInCell->isEmpty())
                                        <div class="empty-label" style="text-align:center;padding:0.5rem 0;">—</div>
                                    @else
                                        <div class="cell-cards">
                                            @foreach($cardsInCell as $card)
                                                <span class="cell-chip--row"
                                                    style="background:#f8fafc;color:#334155;border-color:#e2e8f0;">
                                                    {{ $card->card_name }}
                                                </span>
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

        {{-- ===== ANALISIS ZONA PENTING ===== --}}
        @php
            $motivatedCards   = collect($motivatedIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
            $developmentCards = collect($developmentIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
            $burnoutCards     = collect($burnoutIds)->flatMap(fn($id) => $groupedCards->get($id, collect()));
        @endphp

        <div class="result-section result-section--bordered">
            <div class="result-card-title">
                <i class="fa-solid fa-star"></i>
                Analisis Zona Penting
            </div>

            <div class="zona-grid" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 1.25rem;">

                {{-- MOTIVATED SKILLS --}}
                <div style="border-radius: 16px; overflow: hidden; border: 1.5px solid #16a34a; background: #16a34a; padding: 1.25rem;">
                    <div style="font-size: 0.7rem; font-weight: 800; color: #bbf7d0; letter-spacing: 0.08em; margin-bottom: 0.35rem;">ZONA 1</div>
                    <div style="font-size: 1rem; font-weight: 800; color: white; margin-bottom: 0.75rem;">Motivated Skills</div>
                    <div style="font-size: 0.78rem; color: #dcfce7; line-height: 1.6; margin-bottom: 1rem;">
                        Keterampilan ini berada di zona terbaik — kamu tidak hanya <strong style="color:white;">menyukainya, tetapi juga menguasainya</strong> dengan baik. Ini adalah kekuatan sejatimu yang perlu dipertahankan dan terus dikembangkan. Karier yang ideal adalah karier yang memungkinkan kamu menggunakan keterampilan ini setiap hari. Jadikan keterampilan di zona ini sebagai <strong style="color:white;">fondasi utama</strong> dalam merencanakan jalur karier yang memuaskan dan berkelanjutan.
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                        @if($motivatedCards->isEmpty())
                            <p style="font-size: 0.8rem; color: #bbf7d0; font-style: italic; margin: 0;">Tidak ada kartu di zona ini.</p>
                        @else
                            @foreach($motivatedCards as $card)
                                <span style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.35); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                                    {{ $card->card_name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- AREA PENGEMBANGAN --}}
                <div style="border-radius: 16px; overflow: hidden; border: 1.5px solid #d97706; background: #f59e0b; padding: 1.25rem;">
                    <div style="font-size: 0.7rem; font-weight: 800; color: #fef9c3; letter-spacing: 0.08em; margin-bottom: 0.35rem;">ZONA 2</div>
                    <div style="font-size: 1rem; font-weight: 800; color: white; margin-bottom: 0.75rem;">Area Pengembangan</div>
                    <div style="font-size: 0.78rem; color: #fef9c3; line-height: 1.6; margin-bottom: 1rem;">
                        Keterampilan di zona ini mencerminkan <strong style="color:white;">minat dan passion</strong> kamu yang sesungguhnya — kamu sangat menyukainya, namun kemampuanmu belum mencapai tingkat yang kamu inginkan. Ini adalah <strong style="color:white;">peluang emas untuk berkembang</strong>. Dengan investasi waktu, latihan, dan bimbingan yang tepat, keterampilan ini berpotensi menjadi Motivated Skills di masa depan. Pertimbangkan untuk mengambil kursus atau mencari pengalaman langsung di bidang ini.
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                        @if($developmentCards->isEmpty())
                            <p style="font-size: 0.8rem; color: #fef9c3; font-style: italic; margin: 0;">Tidak ada kartu di zona ini.</p>
                        @else
                            @foreach($developmentCards as $card)
                                <span style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.35); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                                    {{ $card->card_name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

                {{-- BURNOUT SKILLS --}}
                <div style="border-radius: 16px; overflow: hidden; border: 1.5px solid #b91c1c; background: #dc2626; padding: 1.25rem;">
                    <div style="font-size: 0.7rem; font-weight: 800; color: #fecaca; letter-spacing: 0.08em; margin-bottom: 0.35rem;">ZONA 3</div>
                    <div style="font-size: 1rem; font-weight: 800; color: white; margin-bottom: 0.75rem;">Burnout Skills</div>
                    <div style="font-size: 0.78rem; color: #fee2e2; line-height: 1.6; margin-bottom: 1rem;">
                        Keterampilan di zona ini adalah keterampilan yang kamu miliki dan kuasai, namun <strong style="color:white;">tidak memberikan kepuasan atau kesenangan</strong> bagimu. Menghabiskan sebagian besar waktu kerja dengan keterampilan ini berisiko menyebabkan <strong style="color:white;">kelelahan dan burnout</strong> dalam jangka panjang. Meskipun bisa menjadi aset dalam situasi tertentu, hindari menjadikannya fokus utama kariermu. Diskusikan dengan konselormu cara meminimalkan ketergantungan pada keterampilan ini.
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                        @if($burnoutCards->isEmpty())
                            <p style="font-size: 0.8rem; color: #fecaca; font-style: italic; margin: 0;">Tidak ada kartu di zona ini.</p>
                        @else
                            @foreach($burnoutCards as $card)
                                <span style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.35); border-radius: 50px; padding: 0.2rem 0.7rem; font-size: 0.75rem; font-weight: 600;">
                                    {{ $card->card_name }}
                                </span>
                            @endforeach
                        @endif
                    </div>
                </div>

            </div>
        </div>

        {{-- Catatan Konselor --}}
        <div class="result-section">
            <div class="result-card-title">
                <i class="fa-solid fa-comment-dots"></i>
                Catatan Konselor
            </div>

            @if($session->testResult?->recommendation)
                <p class="result-recommendation-text">{{ $session->testResult->recommendation }}</p>
            @else
                <div class="result-alert result-alert--warning">
                    <i class="fa-solid fa-hourglass-half"></i>
                    <p>Konselor belum memberikan catatan untuk hasil tes ini.</p>
                </div>
            @endif

            <div class="result-alert result-alert--info">
                <i class="fa-solid fa-circle-info"></i>
                <p>Hasil ini sudah tersimpan dan dapat dilihat oleh konselormu. Bawa hasil ini saat sesi konseling untuk mendapatkan penjelasan lebih mendalam.</p>
            </div>
        </div>

    </div>

    {{-- Action Buttons --}}
    <div class="result-action-buttons no-print">
        <a href="{{ route('tests.intro', 2) }}" class="btn-secondary">
            <i class="fa-solid fa-rotate-right"></i> Ulangi Tes
        </a>
        <button onclick="window.print()" class="btn-secondary">
            <i class="fa-solid fa-print"></i> Cetak
        </button>
        <button onclick="downloadPDF()" class="btn-secondary">
            <i class="fa-solid fa-download"></i> Download PDF
        </button>
    </div>

</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
    async function downloadPDF() {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById('result-content');
        const hiddenEls = document.querySelectorAll('.no-print, .result-action-buttons');
        hiddenEls.forEach(el => el.style.display = 'none');
        const canvas = await html2canvas(element, {
            scale: 2, useCORS: true, allowTaint: true,
            backgroundColor: '#ffffff', logging: false,
            onclone: function(clonedDoc) {
                clonedDoc.querySelectorAll('.no-print, .result-action-buttons')
                    .forEach(el => el.style.display = 'none');
            }
        });
        hiddenEls.forEach(el => el.style.display = '');
        const imgData   = canvas.toDataURL('image/png');
        const pdf       = new jsPDF('p', 'mm', 'a4');
        const pdfWidth  = pdf.internal.pageSize.getWidth();
        const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
        let heightLeft  = pdfHeight;
        let position    = 0;
        pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
        heightLeft -= pdf.internal.pageSize.getHeight();
        while (heightLeft > 0) {
            position = heightLeft - pdfHeight;
            pdf.addPage();
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();
        }
        pdf.save('MotivatedSkills_{{ Auth::user()->full_name }}.pdf');
    }
</script>
@endsection
