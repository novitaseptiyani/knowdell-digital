@extends('layouts.dashboard')

@section('title', 'Hasil Tes - Leisure & Retirement Activities')

@section('content')
<div class="user-result-container animate-fade-up" id="result-content">

    {{-- Back --}}
    <div style="margin-bottom: 1.5rem;" class="no-print">
        <a href="{{ route('dashboard') }}" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
        </a>
    </div>

    <div class="user-result-card">

        {{-- Header --}}
        <div class="result-doc-header">
            <div class="result-doc-top-bar" style="border-bottom-color: #e2e8f0;">
                <div class="result-doc-logo-wrap">
                    <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA" style="height: 60px; object-fit: contain;">
                    <div>
                        <div class="result-doc-uni-label">Universitas Kristen Krida Wacana</div>
                        <div class="result-doc-test-name">Jenis Tes: Leisure & Retirement Activities</div>
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

            <div class="result-meta-row" style="border-top-color: #e2e8f0;">
                <div class="meta-badge" style="border-color: #e2e8f0; color: #475569;">
                    <i class="fa-regular fa-clock" style="color: #16a34a;"></i>
                    Durasi:
                    @if($duration['hours'] > 0) {{ $duration['hours'] }}j @endif
                    {{ $duration['minutes'] }}m {{ $duration['seconds'] }}d
                </div>
                <div class="meta-badge" style="border-color: #e2e8f0; color: #475569;">
                    <i class="fa-solid fa-layer-group" style="color: #16a34a;"></i>
                    {{ $session->cardSessions->count() }} Kartu Disortir
                </div>
                @if(Auth::user()->counselor?->counselor)
                    <div class="meta-badge" style="border-color: #e2e8f0; color: #475569;">
                        <i class="fa-solid fa-user-tie" style="color: #16a34a;"></i>
                        Konselor: {{ Auth::user()->counselor->counselor->full_name }}
                    </div>
                @endif
            </div>
        </div>

        {{-- Hasil Sortir --}}
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
                <i class="fa-solid fa-table-columns" style="color: #16a34a;"></i>
                Hasil Sortir Leisure & Retirement Activities
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @foreach($columns as $col)
                    @php $cardsInCol = $groupedCards->get($col['id'], collect()); @endphp
                    <div style="border-radius: 12px; overflow: hidden; border: 1px solid {{ $col['border'] }};">
                        <div style="background: {{ $col['bg'] }}; color: {{ $col['text'] }}; padding: 0.5rem 1rem; font-weight: 800; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid {{ $col['border'] }};">
                            <div style="display: flex; align-items: baseline; gap: 8px;">
                                <span>{{ $col['label'] }}</span>
                                <span style="font-size: 0.75rem; font-style: italic; opacity: 0.8;">{{ $col['sub'] }}</span>
                            </div>
                            <span style="background: {{ $col['chip_border'] }}; color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-shadow: 0 1px 1px rgba(0,0,0,0.1);">{{ $cardsInCol->count() }} Kartu</span>
                        </div>
                        <div style="background: {{ $col['chip_bg'] }}; padding: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                            @if($cardsInCol->isEmpty())
                                <span style="color: {{ $col['text'] }}; font-style: italic; font-size: 0.85rem;">Tidak ada aktivitas di kategori ini.</span>
                            @else
                                @foreach($cardsInCol as $card)
                                    <span style="background: white; color: {{ $col['text'] }}; border: 1px solid {{ $col['chip_border'] }}; border-radius: 6px; padding: 0.35rem 0.6rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                        {{ $card->card_name }}
                                    </span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Highlight: Aktivitas Prioritas (Daily) --}}
        @php $dailyCards = $groupedCards->get(6, collect()); @endphp
        <div class="result-section result-section--bordered">
            <div class="result-card-title">
                <i class="fa-solid fa-star" style="color: #16a34a;"></i>
                Aktivitas Prioritas Utamamu
            </div>

            <div class="leisure-priority-box" style="background: #16a34a; border-radius: 16px; padding: 1.25rem; margin-bottom: 1rem;">
                <div style="font-size: 0.7rem; font-weight: 800; color: #bbf7d0; letter-spacing: 0.08em; margin-bottom: 0.35rem;">SETIAP HARI — DAILY</div>
                <div style="font-size: 0.9rem; color: #dcfce7; line-height: 1.6; margin-bottom: 1rem;">
                    Aktivitas-aktivitas ini adalah yang paling ingin kamu lakukan setiap hari. Ini mencerminkan <strong style="color:white;">nilai dan kebutuhan rekreasi terdalammu</strong>. Jadikan aktivitas ini sebagai prioritas dalam merancang gaya hidup dan masa pensiunmu kelak.
                </div>
                <div style="display: flex; flex-wrap: wrap; gap: 0.5rem;">
                    @if($dailyCards->isEmpty())
                        <p style="font-size: 0.85rem; color: #bbf7d0; font-style: italic; margin: 0;">Tidak ada aktivitas di kategori ini.</p>
                    @else
                        @foreach($dailyCards as $card)
                            <span style="background: rgba(255,255,255,0.2); color: white; border: 1px solid rgba(255,255,255,0.35); border-radius: 50px; padding: 0.25rem 0.75rem; font-size: 0.8rem; font-weight: 600;">
                                {{ $card->card_name }}
                            </span>
                        @endforeach
                    @endif
                </div>
            </div>

            <div class="result-alert result-alert--info">
                <i class="fa-solid fa-circle-info"></i>
                <p>Renungkan: sudah berapa lama kamu tidak melakukan aktivitas-aktivitas ini? Apakah kamu bisa melakukannya bersama pasangan, teman, atau sendiri? Diskusikan bersama konselormu untuk mengintegrasikan aktivitas ini ke dalam rencana kariermu.</p>
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
        <a href="{{ route('tests.intro', 3) }}" class="btn-secondary">
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
        const element   = document.getElementById('result-content');
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
        pdf.save('LeisureRetirement_{{ Auth::user()->full_name }}.pdf');
    }
</script>
@endsection
