@extends('layouts.dashboard')

@section('title', 'Hasil Tes - Career Values')

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
                        <div class="result-doc-test-name">Jenis Tes: Career Values</div>
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
                    <div class="result-info-value">{{ $session->finished_at ? $session->finished_at->translatedFormat('d F Y, H:i') : '-' }}</div>
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

        {{-- ===== TAHAP 1: HASIL SORTIR KARTU ===== --}}
        <div class="result-section result-section--bordered">
            <div class="result-card-title">
                <i class="fa-solid fa-layer-group"></i>
                Tahap 1: Hasil Sortir Nilai Karir
            </div>

            <div style="display: flex; flex-direction: column; gap: 1rem;">
                @php
                    $catColors = [
                        ['border' => '#16a34a', 'bg' => '#16a34a', 'light' => '#f0fdf4', 'text' => '#15803d'], // Selalu Penting
                        ['border' => '#2563eb', 'bg' => '#2563eb', 'light' => '#eff6ff', 'text' => '#1d4ed8'], // Sering Penting
                        ['border' => '#f59e0b', 'bg' => '#f59e0b', 'light' => '#fffbeb', 'text' => '#d97706'], // Kadang-kadang
                        ['border' => '#f97316', 'bg' => '#f97316', 'light' => '#fff7ed', 'text' => '#ea580c'], // Jarang Penting
                        ['border' => '#ef4444', 'bg' => '#ef4444', 'light' => '#fef2f2', 'text' => '#dc2626'], // Tidak Pernah
                    ];
                @endphp

                @foreach($choiceCategories as $index => $category)
                    @if($index === 0 || $index === count($choiceCategories) - 1)
                        @php
                            $cardsInCat = $groupedCards->get($category->id, collect());
                            $color = $catColors[$index % count($catColors)];
                        @endphp
                        <div style="border-radius: 12px; overflow: hidden; border: 1px solid {{ $color['border'] }};">
                            <div style="background: {{ $color['bg'] }}; color: white; padding: 0.5rem 1rem; font-weight: 700; display: flex; justify-content: space-between; align-items: center;">
                                <span>{{ $category->name }}</span>
                                <span style="background: rgba(255,255,255,0.2); padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem;">{{ $cardsInCat->count() }} Kartu</span>
                            </div>
                            <div style="background: {{ $color['light'] }}; padding: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @if($cardsInCat->isEmpty())
                                    <span style="color: {{ $color['text'] }}; font-style: italic; font-size: 0.85rem;">Tidak ada kartu di kategori ini.</span>
                                @else
                                    @foreach($cardsInCat as $card)
                                        <span style="background: white; color: {{ $color['text'] }}; border: 1px solid {{ $color['border'] }}; border-radius: 6px; padding: 0.3rem 0.6rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                            {{ $card->card_name }}
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- ===== TAHAP 2: KECOCOKAN PROFESI ===== --}}
        @php
            $profesiData = [
                ['name' => Auth::user()->dream_jobs[0] ?? 'Profesi 1', 'score' => 0, 'key' => 'profesi_1_score'],
                ['name' => Auth::user()->dream_jobs[1] ?? 'Profesi 2', 'score' => 0, 'key' => 'profesi_2_score'],
                ['name' => Auth::user()->dream_jobs[2] ?? 'Profesi 3', 'score' => 0, 'key' => 'profesi_3_score'],
            ];

            // Kategori ID 1 biasanya adalah "Selalu Penting" untuk tes ini
            $alwaysValuedCards = $groupedCards->get(1, collect());
            
            // Hitung skor dari tabel card_sessions
            $cardSessionMap = $session->cardSessions->keyBy('card_id');
            
            foreach ($alwaysValuedCards as $card) {
                $cs = $cardSessionMap->get($card->id);
                if($cs) {
                    $profesiData[0]['score'] += (int) ($cs->profesi_1_score ?? 0);
                    $profesiData[1]['score'] += (int) ($cs->profesi_2_score ?? 0);
                    $profesiData[2]['score'] += (int) ($cs->profesi_3_score ?? 0);
                }
            }

            // Urutkan profesi berdasarkan skor tertinggi
            $sortedProfesi = $profesiData;
            usort($sortedProfesi, function($a, $b) {
                return $b['score'] <=> $a['score'];
            });
            
            $winner = $sortedProfesi[0];
        @endphp

        <div class="result-section result-section--bordered">
            <div class="result-card-title">
                <i class="fa-solid fa-ranking-star"></i>
                Tahap 2: Analisis Kecocokan Profesi
            </div>

            <div style="display: grid; grid-template-columns: 1fr; gap: 1.5rem;">
                <div style="background: #fffbeb; border: 1px solid #fcd34d; border-radius: 12px; padding: 1.5rem; text-align: center;">
                    <div style="font-size: 0.8rem; font-weight: 800; color: #d97706; text-transform: uppercase; letter-spacing: 0.1em; margin-bottom: 0.5rem;">Profesi Paling Selaras</div>
                    <div style="font-size: 1.8rem; font-weight: 900; color: #92400e; margin-bottom: 0.5rem;">{{ $winner['name'] }}</div>
                    <div style="color: #b45309; font-size: 0.95rem;">Memperoleh skor kecocokan tertinggi sebesar <strong>+{{ $winner['score'] }}</strong> berdasarkan nilai-nilai karir yang Anda anggap "Selalu Penting".</div>
                </div>

                <div style="background: white; border: 1px solid #e2e8f0; border-radius: 12px; overflow: hidden; font-size: 0.9rem;">
                    <div style="background: #f8fafc; padding: 1rem; border-bottom: 1px solid #e2e8f0; font-weight: 700; color: #334155;">
                        Rincian Perhitungan Skor
                    </div>
                    <div style="overflow-x: auto;">
                        <table style="width: 100%; border-collapse: collapse; min-width: 500px;">
                            <thead>
                                <tr style="background: #f1f5f9;">
                                    <th style="text-align: left; padding: 0.75rem 1rem; border-bottom: 1px solid #cbd5e1; color: #475569;">Nilai Karir (Selalu Penting)</th>
                                    @foreach($sortedProfesi as $p)
                                        <th style="text-align: center; padding: 0.75rem 1rem; border-bottom: 1px solid #cbd5e1; color: #475569;">{{ $p['name'] }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($alwaysValuedCards as $card)
                                    @php $cs = $cardSessionMap->get($card->id); @endphp
                                    <tr>
                                        <td style="padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9; font-weight: 600;">{{ $card->card_name }}</td>
                                        @foreach($sortedProfesi as $p)
                                            @php 
                                                $key = $p['key']; 
                                                $score = $cs ? ((int) ($cs->$key ?? 0)) : 0;
                                            @endphp
                                            <td style="text-align: center; padding: 0.75rem 1rem; border-bottom: 1px solid #f1f5f9; color: {{ $score > 0 ? '#16a34a' : ($score < 0 ? '#ef4444' : '#64748b') }};">
                                                {{ $score > 0 ? '+' : '' }}{{ $score }}
                                            </td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="background: #f8fafc;">
                                    <td style="padding: 1rem; font-weight: 800; text-align: right; border-top: 2px solid #cbd5e1; color: #1e293b;">Total Skor</td>
                                    @foreach($sortedProfesi as $index => $p)
                                        <td style="text-align: center; padding: 1rem; font-weight: 900; font-size: 1.1rem; border-top: 2px solid #cbd5e1; color: {{ $index === 0 ? '#d97706' : '#1e293b' }};">
                                            {{ $p['score'] > 0 ? '+' : '' }}{{ $p['score'] }}
                                        </td>
                                    @endforeach
                                </tr>
                            </tfoot>
                        </table>
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
        <a href="{{ route('tests.intro', 1) }}" class="btn-secondary">
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
        
        pdf.save('CareerValues_{{ Auth::user()->full_name }}.pdf');
    }
</script>
@endsection
