@extends('layouts.dashboard')

@section('title', 'Hasil Tes - Occupational Interests')

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
                        <img src="{{ asset('images/ukridalogo.png') }}" alt="UKRIDA"
                            style="height: 60px; object-fit: contain;">
                        <div>
                            <div class="result-doc-uni-label">Universitas Kristen Krida Wacana</div>
                            <div class="result-doc-test-name">Jenis Tes: Occupational Interests</div>
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
                        <i class="fa-regular fa-clock" style="color: #3b82f6;"></i>
                        Durasi:
                        @if($duration['hours'] > 0) {{ $duration['hours'] }}j @endif
                        {{ $duration['minutes'] }}m {{ $duration['seconds'] }}d
                    </div>
                    <div class="meta-badge" style="border-color: #e2e8f0; color: #475569;">
                        <i class="fa-solid fa-layer-group" style="color: #3b82f6;"></i>
                        {{ $session->cardSessions->count() }} Kartu Disortir
                    </div>
                    @if(Auth::user()->counselor?->counselor)
                        <div class="meta-badge" style="border-color: #e2e8f0; color: #475569;">
                            <i class="fa-solid fa-user-tie" style="color: #3b82f6;"></i>
                            Konselor: {{ Auth::user()->counselor->counselor->full_name }}
                        </div>
                    @endif
                </div>
            </div>

            {{-- Hasil Sortir --}}
            @php
                $columns = [
                    ['id' => 26, 'label' => 'Pasti Tertarik', 'sub' => 'Definitely Interested', 'border' => '#3b82f6', 'bg' => '#eff6ff', 'text' => '#1d4ed8', 'chip_bg' => '#dbeafe', 'chip_border' => '#93c5fd'],
                    ['id' => 30, 'label' => 'Pasti Tidak Tertarik', 'sub' => 'Definitely Not Interested', 'border' => '#ef4444', 'bg' => '#fef2f2', 'text' => '#dc2626', 'chip_bg' => '#fee2e2', 'chip_border' => '#fca5a5'],
                    ['id' => 27, 'label' => 'Mungkin Tertarik', 'sub' => 'Probably Interested', 'border' => '#2563eb', 'bg' => '#eff6ff', 'text' => '#1d4ed8', 'chip_bg' => '#dbeafe', 'chip_border' => '#93c5fd'],
                    ['id' => 28, 'label' => 'Biasa Saja', 'sub' => 'Indifferent', 'border' => '#f59e0b', 'bg' => '#fffbeb', 'text' => '#d97706', 'chip_bg' => '#fef9c3', 'chip_border' => '#fcd34d'],
                    ['id' => 29, 'label' => 'Mungkin Tidak Tertarik', 'sub' => 'Probably Not Interested', 'border' => '#f97316', 'bg' => '#fff7ed', 'text' => '#ea580c', 'chip_bg' => '#ffedd5', 'chip_border' => '#fdba74'],
                ];
            @endphp

            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-table-columns" style="color: #3b82f6;"></i>
                    Hasil Sortir Occupational Interests
                </div>

                <div style="display: flex; flex-direction: column; gap: 1rem;">
                    @foreach($columns as $index => $col)
                        @php $cardsInCol = $groupedCards->get($col['id'], collect()); @endphp
                        <div style="border-radius: 12px; overflow: hidden; border: 1px solid {{ $col['border'] }};">
                            <div
                                style="background: {{ $col['bg'] }}; color: {{ $col['text'] }}; padding: 0.5rem 1rem; font-weight: 800; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid {{ $col['border'] }};">
                                <div style="display: flex; align-items: baseline; gap: 8px;">
                                    <span>{{ $col['label'] }}</span>
                                    <span style="font-size: 0.75rem; font-style: italic; opacity: 0.8;">{{ $col['sub'] }}</span>
                                </div>
                                <span
                                    style="background: {{ $col['chip_border'] }}; color: white; padding: 0.2rem 0.6rem; border-radius: 20px; font-size: 0.8rem; font-weight: bold; text-shadow: 0 1px 1px rgba(0,0,0,0.1);">{{ $cardsInCol->count() }}
                                    Kartu</span>
                            </div>
                            <div
                                style="background: {{ $col['chip_bg'] }}; padding: 1rem; display: flex; flex-wrap: wrap; gap: 0.5rem;">
                                @if($cardsInCol->isEmpty())
                                    <span style="color: {{ $col['text'] }}; font-style: italic; font-size: 0.85rem;">Tidak ada
                                        pekerjaan di kategori ini.</span>
                                @else
                                    @foreach($cardsInCol as $card)
                                        <span
                                            style="background: white; color: {{ $col['text'] }}; border: 1px solid {{ $col['chip_border'] }}; border-radius: 6px; padding: 0.35rem 0.6rem; font-size: 0.8rem; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05); display: inline-flex; align-items: center; gap: 6px;">
                                            {{ $card->card_name }}
                                            @if($card->kode)
                                                <span
                                                    style="background: #e0f2fe; color: #0284c7; padding: 0.1rem 0.4rem; border-radius: 4px; font-size: 0.65rem; font-weight: 700; border: 1px solid #bae6fd;">
                                                    {{ $card->kode }}
                                                </span>
                                            @endif
                                        </span>
                                    @endforeach
                                @endif
                            </div>
                        </div>

                        {{-- Pembatas visual setelah "Pasti Tertarik" dan "Pasti Tidak Tertarik" --}}
                        @if($index === 1)
                            <div style="display: flex; align-items: center; text-align: center; margin: 0.5rem 0;">
                                <div style="flex: 1; border-bottom: 2px dashed #cbd5e1;"></div>
                                <span style="padding: 0 1rem; color: #64748b; font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em;">Kategori Lainnya</span>
                                <div style="flex: 1; border-bottom: 2px dashed #cbd5e1;"></div>
                            </div>
                        @endif

                    @endforeach
                </div>
            </div>

            {{-- Highlight: Aktivitas Prioritas (Pasti Tertarik) --}}
            @php 
                                                            $priorityCards = $groupedCards->get(26, collect());

                $letterCounts = ['R' => 0, 'I' => 0, 'A' => 0, 'S' => 0, 'E' => 0, 'C' => 0];
                foreach ($priorityCards as $card) {
                    if ($card->kode) {
                        $chars = str_split(strtoupper($card->kode));
                        foreach ($chars as $char) {
                            if (array_key_exists($char, $letterCounts)) {
                                $letterCounts[$char]++;
                            }
                        }
                    }
                }
                arsort($letterCounts);
                $top3 = array_slice(array_filter($letterCounts, function ($v) {
                    return $v > 0;
                }), 0, 3, true);
            @endphp
            <div class="result-section result-section--bordered">
                <div class="result-card-title">
                    <i class="fa-solid fa-star" style="color: #3b82f6;"></i>
                    Pekerjaan Impianmu
                </div>

                <div class="leisure-priority-box"
                    style="background: #3b82f6; border-radius: 16px; padding: 1.25rem; margin-bottom: 1rem;">
                    <div
                        style="font-size: 0.7rem; font-weight: 800; color: #bfdbfe; letter-spacing: 0.08em; margin-bottom: 0.35rem;">
                        PASTI TERTARIK — DEFINITELY INTERESTED</div>
                    <div style="font-size: 0.9rem; color: #eff6ff; line-height: 1.6; margin-bottom: 1rem;">
                        Pekerjaan-pekerjaan ini adalah yang paling membuatmu antusias. Daftar ini mencerminkan <strong
                            style="color:white;">minat dan kecenderungan karier terkuatmu</strong>. Perhatikan kode Holland
                        (RIASEC) yang dominan pada daftar ini, karena itu menunjukkan lingkungan kerja yang paling cocok
                        untukmu.
                    </div>
                    @if(!empty($top3))
                        <div
                            style="background: rgba(255,255,255,0.15); border-radius: 12px; padding: 1.5rem; border: 1px solid rgba(255,255,255,0.2);">
                            <div
                                style="font-size: 0.85rem; font-weight: 800; color: #bfdbfe; letter-spacing: 0.05em; margin-bottom: 1rem; text-transform: uppercase; text-align: center;">
                                Tiga Kode Holland (RIASEC) Dominan Anda:</div>
                            <div style="display: flex; gap: 1rem; margin-bottom: 1.5rem;">
                                @foreach($top3 as $letter => $count)
                                    <div
                                        style="background: white; color: #1e40af; border-radius: 12px; padding: 1rem; display: flex; flex-direction: column; align-items: center; justify-content: center; flex: 1; box-shadow: 0 4px 10px rgba(0,0,0,0.15);">
                                        <span style="font-size: 2.5rem; font-weight: 900; line-height: 1;">{{ $letter }}</span>
                                        <span style="font-size: 0.75rem; font-weight: 700; color: #3b82f6; margin-top: 8px;">Muncul
                                            {{ $count }}x</span>
                                    </div>
                                @endforeach
                            </div>

                            @php
                                $riasecDesc = [
                                    'R' => ['title' => 'Realistic (Realistis)', 'desc' => 'Suka bekerja praktis dengan mesin, peralatan, hewan, atau bekerja di luar ruangan. Cenderung lebih menyukai tindakan dan penyelesaian masalah secara nyata dibandingkan teori.'],
                                    'I' => ['title' => 'Investigative (Investigatif)', 'desc' => 'Suka meneliti, menganalisis, dan memecahkan masalah yang kompleks. Merasa lebih nyaman bekerja dengan ide, teori, dan konsep abstrak.'],
                                    'A' => ['title' => 'Artistic (Artistik)', 'desc' => 'Sangat menghargai kreativitas, inovasi, dan ekspresi diri. Lebih suka bekerja di lingkungan yang fleksibel, artistik, dan tidak terlalu terstruktur.'],
                                    'S' => ['title' => 'Social (Sosial)', 'desc' => 'Suka berinteraksi, membantu, melatih, atau menyembuhkan orang lain. Memiliki empati yang tinggi dan keterampilan komunikasi interpersonal yang sangat baik.'],
                                    'E' => ['title' => 'Enterprising (Enterprising)', 'desc' => 'Suka memimpin, mengambil inisiatif, mempengaruhi, atau meyakinkan orang lain. Berani mengambil risiko dan terorientasi pada pencapaian target bisnis atau organisasi.'],
                                    'C' => ['title' => 'Conventional (Konvensional)', 'desc' => 'Suka bekerja dengan data, angka, dan detail yang sangat terstruktur. Sangat teliti, teratur, dapat diandalkan, dan mahir mengikuti prosedur rutin yang jelas.'],
                                ];
                            @endphp

                            <div style="background: rgba(0,0,0,0.15); border-radius: 12px; padding: 1.25rem;">
                                <div style="font-size: 0.8rem; font-weight: 800; color: #bfdbfe; margin-bottom: 1rem; text-transform: uppercase;">
                                    Arti Kode Dominan Anda:
                                </div>
                                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                                    @foreach($top3 as $letter => $count)
                                        <div style="display: flex; gap: 1rem; align-items: flex-start;">
                                            <div style="background: white; color: #1e40af; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 1.1rem; flex-shrink: 0;">
                                                {{ $letter }}
                                            </div>
                                            <div style="flex: 1;">
                                                <div style="color: white; font-weight: 800; font-size: 0.95rem; margin-bottom: 0.2rem;">{{ $riasecDesc[$letter]['title'] }}</div>
                                                <div style="color: #bfdbfe; font-size: 0.85rem; line-height: 1.5; margin-bottom: 0.75rem;">{{ $riasecDesc[$letter]['desc'] }}</div>
                                                
                                                {{-- Filter kartu yang mengandung kode ini --}}
                                                @php
                                                    $cardsWithLetter = $priorityCards->filter(function($c) use ($letter) {
                                                        return str_contains(strtoupper($c->kode), $letter);
                                                    });
                                                @endphp
                                                @if($cardsWithLetter->isNotEmpty())
                                                    <div style="display: flex; flex-wrap: wrap; gap: 0.4rem;">
                                                        @foreach($cardsWithLetter as $card)
                                                            <span style="background: rgba(255,255,255,0.15); color: white; border: 1px solid rgba(255,255,255,0.25); border-radius: 6px; padding: 0.2rem 0.5rem; font-size: 0.75rem; font-weight: 600;">
                                                                {{ $card->card_name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="result-alert result-alert--info">
                    <i class="fa-solid fa-circle-info"></i>
                    <p>Renungkan: apa kesamaan dari pekerjaan-pekerjaan di atas? Huruf RIASEC apa yang paling sering muncul?
                        Diskusikan bersama konselormu untuk memahami bagaimana mengejar jalur karier yang selaras dengan
                        minatmu ini.</p>
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
                    <p>Hasil ini sudah tersimpan dan dapat dilihat oleh konselormu. Bawa hasil ini saat sesi konseling untuk
                        mendapatkan penjelasan lebih mendalam.</p>
                </div>
            </div>

        </div>

        {{-- Action Buttons --}}
        <div class="result-action-buttons no-print">
            <a href="{{ route('tests.intro', 4) }}" class="btn-secondary">
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
                onclone: function (clonedDoc) {
                    clonedDoc.querySelectorAll('.no-print, .result-action-buttons')
                        .forEach(el => el.style.display = 'none');
                }
            });
            hiddenEls.forEach(el => el.style.display = '');
            const imgData = canvas.toDataURL('image/png');
            const pdf = new jsPDF('p', 'mm', 'a4');
            const pdfWidth = pdf.internal.pageSize.getWidth();
            const pdfHeight = (canvas.height * pdfWidth) / canvas.width;
            let heightLeft = pdfHeight;
            let position = 0;
            pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
            heightLeft -= pdf.internal.pageSize.getHeight();
            while (heightLeft > 0) {
                position = heightLeft - pdfHeight;
                pdf.addPage();
                pdf.addImage(imgData, 'PNG', 0, position, pdfWidth, pdfHeight);
                heightLeft -= pdf.internal.pageSize.getHeight();
            }
            pdf.save('OccupationalInterests_{{ Auth::user()->full_name }}.pdf');
        }
    </script>
@endsection