<x-app-layout>
    <script src="https://unpkg.com/lucide@latest"></script>
    <x-slot name="header">
        <div class="flex justify-between items-center relative">
            <div class="flex-1 sm:w-1/3 flex justify-start">
                <button onclick="document.getElementById('modal-kembali').classList.add('active')"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-orange-200 rounded-lg hover:bg-orange-50 hover:border-orange-300 text-orange-600 font-medium transition-colors text-sm shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </button>
            </div>
            <div class="hidden sm:flex w-1/3 justify-center">
                <h2 class="font-bold text-2xl text-orange-600 tracking-tight">Worksheet: Nilai Karir</h2>
            </div>
            <div class="flex-1 sm:w-1/3 flex justify-end">
                <!-- Indikator progres sengaja dihapus -->
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 min-h-[calc(100vh-100px)] flex flex-col">
        <div class="max-w-[1600px] mx-auto px-3 sm:px-6 lg:px-8 w-full flex-1 flex flex-col gap-4">
            <div class="flex flex-col xl:flex-row h-full gap-4 sm:gap-6 w-full items-start">

                {{-- LEFT: Instructions & Controls --}}
                <div class="w-full xl:w-[30%] flex flex-col gap-3 sm:gap-5 sm:sticky sm:top-6" style="z-index: 10;">

                    {{-- Action Buttons & Timer --}}
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex items-center gap-2 sm:gap-3 w-full">
                            <button type="button" onclick="submitWorksheet()"
                                class="px-3 sm:px-5 py-2 bg-orange-500 text-white rounded-md hover:bg-orange-600 font-medium transition-all text-xs sm:text-sm shadow-sm flex items-center justify-center gap-1.5 sm:gap-2 flex-1">
                                Simpan Worksheet
                                <i data-lucide="save" class="w-4 h-4"></i>
                            </button>
                            <div
                                class="px-2 sm:px-3 py-2 bg-white/80 backdrop-blur-sm border border-orange-200 text-orange-700 font-bold rounded-md shadow-sm flex items-center gap-1 sm:gap-1.5 justify-center flex-shrink-0">
                                <i data-lucide="timer" class="h-4 w-4 sm:h-5 sm:w-5 text-orange-500"></i>
                                @php
                                    $h = str_pad(floor($elapsedSeconds / 3600), 2, '0', STR_PAD_LEFT);
                                    $m = str_pad(floor(($elapsedSeconds % 3600) / 60), 2, '0', STR_PAD_LEFT);
                                    $s = str_pad($elapsedSeconds % 60, 2, '0', STR_PAD_LEFT);
                                @endphp
                                <span id="timer-text"
                                    class="tracking-widest tabular-nums text-xs sm:text-sm">{{ $h }}:{{ $m }}:{{ $s }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Info Box --}}
                    <div
                        class="w-full bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 flex flex-col relative">
                        <div
                            class="inline-block bg-orange-100 text-orange-800 text-[10px] sm:text-xs font-bold px-3 py-1 rounded-full mb-4 w-fit tracking-wider">
                            STEP 2 — CAREER OPTIONS WORKSHEET</div>
                        <h1 class="text-lg sm:text-xl font-bold text-orange-900 mb-2">Seberapa Cocok Profesi Impian
                            Anda?</h1>
                        <p class="text-xs sm:text-sm text-gray-600 mb-5 leading-relaxed">Nilai setiap karir (yang Anda
                            tempatkan di 'Selalu Penting') terhadap 3 profesi impian Anda. Skor tinggi berarti profesi
                            tersebut selaras dengan nilai karir Anda.</p>

                        <div class="flex flex-col gap-2.5">
                            <div
                                class="flex items-center gap-3 bg-orange-50 p-2.5 rounded-lg border border-orange-100 text-sm font-semibold text-orange-900">
                                <span
                                    class="w-6 h-6 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-xs shadow-sm">1</span>
                                <span class="flex-1">{{ $user->profesi_1 }}</span>
                            </div>
                            <div
                                class="flex items-center gap-3 bg-orange-50 p-2.5 rounded-lg border border-orange-100 text-sm font-semibold text-orange-900">
                                <span
                                    class="w-6 h-6 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-xs shadow-sm">2</span>
                                <span class="flex-1">{{ $user->profesi_2 }}</span>
                            </div>
                            <div
                                class="flex items-center gap-3 bg-orange-50 p-2.5 rounded-lg border border-orange-100 text-sm font-semibold text-orange-900">
                                <span
                                    class="w-6 h-6 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-xs shadow-sm">3</span>
                                <span class="flex-1">{{ $user->profesi_3 }}</span>
                            </div>
                        </div>

                        <div
                            class="mt-6 text-xs sm:text-sm text-gray-700 bg-blue-50/50 border border-blue-100 p-4 rounded-lg leading-relaxed">
                            <strong class="text-blue-900 block mb-1">Cara Pengisian:</strong>
                            Pilih angka yang menggambarkan seberapa baik profesi mendukung nilai tersebut. Jangan
                            kosongkan agar skor valid.
                        </div>

                        <div class="mt-5 grid grid-cols-2 gap-2 text-[11px] sm:text-xs">
                            <div
                                class="px-2 py-1.5 bg-blue-50 border border-blue-200 text-blue-800 rounded font-medium">
                                <strong class="mr-1">4</strong> Perfect Fit
                            </div>
                            <div
                                class="px-2 py-1.5 bg-cyan-50 border border-cyan-200 text-cyan-800 rounded font-medium">
                                <strong class="mr-1">3</strong> Very Congruent
                            </div>
                            <div
                                class="px-2 py-1.5 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded font-medium">
                                <strong class="mr-1">2</strong> Congruent
                            </div>
                            <div
                                class="px-2 py-1.5 bg-yellow-50 border border-yellow-200 text-yellow-800 rounded font-medium">
                                <strong class="mr-1">?</strong> Don't Know
                            </div>
                            <div
                                class="px-2 py-1.5 bg-orange-50 border border-orange-200 text-orange-800 rounded font-medium">
                                <strong class="mr-1">-1</strong> Incongruent
                            </div>
                            <div class="px-2 py-1.5 bg-red-50 border border-red-200 text-red-800 rounded font-medium">
                                <strong class="mr-1">-2</strong> Very Incongruent
                            </div>
                            <div
                                class="px-2 py-1.5 bg-rose-50 border border-rose-200 text-rose-800 rounded font-medium col-span-2 text-center">
                                <strong class="mr-1">-3</strong> No Way
                            </div>
                        </div>
                    </div>
                </div>

                {{-- RIGHT: The Table --}}
                <div class="w-full xl:w-[70%] bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-gray-100 p-1 sm:p-2 overflow-hidden flex flex-col relative"
                    style="z-index: 1;">
                    <form action="{{ route('tests.worksheet.save', $session->id) }}" method="POST" id="worksheet-form"
                        class="h-full flex flex-col">
                        @csrf
                        <input type="hidden" name="duration" id="input-duration" value="">
                        <div class="overflow-x-auto w-full">
                            <table class="w-full text-left border-collapse min-w-[700px]">
                                <thead>
                                    <tr>
                                        <th
                                            class="p-4 bg-gray-50/80 border-b border-gray-200 text-xs sm:text-sm font-bold text-gray-700 w-1/3">
                                            Nilai Karir (Always Valued)
                                        </th>
                                        <th class="p-3 bg-orange-50/50 border-b border-gray-200 text-center w-[22%]">
                                            <div
                                                class="text-xs font-semibold text-orange-900 mb-1 flex items-center justify-center gap-1.5">
                                                <div
                                                    class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-[10px]">
                                                    1</div>
                                            </div>
                                            <div class="text-[11px] font-bold text-gray-600 uppercase tracking-wider truncate px-2"
                                                title="{{ $user->profesi_1 }}">{{ $user->profesi_1 }}</div>
                                        </th>
                                        <th
                                            class="p-3 bg-orange-50/50 border-b border-gray-200 text-center w-[22%] border-l border-gray-100">
                                            <div
                                                class="text-xs font-semibold text-orange-900 mb-1 flex items-center justify-center gap-1.5">
                                                <div
                                                    class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-[10px]">
                                                    2</div>
                                            </div>
                                            <div class="text-[11px] font-bold text-gray-600 uppercase tracking-wider truncate px-2"
                                                title="{{ $user->profesi_2 }}">{{ $user->profesi_2 }}</div>
                                        </th>
                                        <th
                                            class="p-3 bg-orange-50/50 border-b border-gray-200 text-center w-[22%] border-l border-gray-100">
                                            <div
                                                class="text-xs font-semibold text-orange-900 mb-1 flex items-center justify-center gap-1.5">
                                                <div
                                                    class="w-5 h-5 bg-orange-200 text-orange-800 rounded-full flex items-center justify-center font-bold text-[10px]">
                                                    3</div>
                                            </div>
                                            <div class="text-[11px] font-bold text-gray-600 uppercase tracking-wider truncate px-2"
                                                title="{{ $user->profesi_3 }}">{{ $user->profesi_3 }}</div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sortedAlways as $i => $cs)
                                        @php
                                            $existing = $existingWorksheet->get($cs->card_id);
                                            $ep1 = $existing ? $existing->profesi_1_score : null;
                                            $ep2 = $existing ? $existing->profesi_2_score : null;
                                            $ep3 = $existing ? $existing->profesi_3_score : null;
                                        @endphp
                                        <tr class="border-b border-gray-100 hover:bg-orange-50/30 transition-colors group">
                                            <td class="p-4">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="w-6 h-6 shrink-0 bg-orange-100 text-orange-700 rounded-md flex items-center justify-center text-xs font-bold mt-0.5 border border-orange-200">
                                                        {{ $i + 1 }}
                                                    </div>
                                                    <div>
                                                        <div class="font-bold text-sm text-gray-800">
                                                            {{ $cs->card->card_name }}
                                                        </div>
                                                        @if($cs->card->description)
                                                            <div class="text-xs text-gray-500 mt-1 leading-relaxed max-w-xs">
                                                                {{ $cs->card->description }}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>

                                            {{-- Profesi 1 --}}
                                            <td class="p-3 align-middle bg-white group-hover:bg-transparent">
                                                <div class="flex flex-wrap justify-center gap-1 score-group"
                                                    data-kartu="{{ $cs->card_id }}" data-profesi="profesi_1">
                                                    @foreach([4, 3, 2, '?', -1, -2, -3] as $val)
                                                        @php $stored = ($val === '?') ? 0 : $val; @endphp
                                                        <button type="button"
                                                            class="score-btn {{ $ep1 !== null && $ep1 === (($val === '?') ? 0 : (int) $val) ? 'active-p1' : '' }} w-8 h-8 rounded text-xs font-bold border border-gray-200 text-gray-600 bg-gray-50 hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition-all flex items-center justify-center shadow-sm"
                                                            data-val="{{ $val }}" data-stored="{{ $stored }}"
                                                            onclick="selectScore(this, 'p1')">
                                                            {{ $val }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="scores[{{ $cs->card_id }}][profesi_1]"
                                                    id="inp-{{ $cs->card_id }}-p1" value="{{ $ep1 !== null ? $ep1 : '' }}">
                                            </td>

                                            {{-- Profesi 2 --}}
                                            <td
                                                class="p-3 align-middle bg-white group-hover:bg-transparent border-l border-gray-100">
                                                <div class="flex flex-wrap justify-center gap-1 score-group"
                                                    data-kartu="{{ $cs->card_id }}" data-profesi="profesi_2">
                                                    @foreach([4, 3, 2, '?', -1, -2, -3] as $val)
                                                        @php $stored = ($val === '?') ? 0 : $val; @endphp
                                                        <button type="button"
                                                            class="score-btn {{ $ep2 !== null && $ep2 === (($val === '?') ? 0 : (int) $val) ? 'active-p2' : '' }} w-8 h-8 rounded text-xs font-bold border border-gray-200 text-gray-600 bg-gray-50 hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition-all flex items-center justify-center shadow-sm"
                                                            data-val="{{ $val }}" data-stored="{{ $stored }}"
                                                            onclick="selectScore(this, 'p2')">
                                                            {{ $val }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="scores[{{ $cs->card_id }}][profesi_2]"
                                                    id="inp-{{ $cs->card_id }}-p2" value="{{ $ep2 !== null ? $ep2 : '' }}">
                                            </td>

                                            {{-- Profesi 3 --}}
                                            <td
                                                class="p-3 align-middle bg-white group-hover:bg-transparent border-l border-gray-100">
                                                <div class="flex flex-wrap justify-center gap-1 score-group"
                                                    data-kartu="{{ $cs->card_id }}" data-profesi="profesi_3">
                                                    @foreach([4, 3, 2, '?', -1, -2, -3] as $val)
                                                        @php $stored = ($val === '?') ? 0 : $val; @endphp
                                                        <button type="button"
                                                            class="score-btn {{ $ep3 !== null && $ep3 === (($val === '?') ? 0 : (int) $val) ? 'active-p3' : '' }} w-8 h-8 rounded text-xs font-bold border border-gray-200 text-gray-600 bg-gray-50 hover:border-orange-400 hover:text-orange-600 hover:bg-orange-50 transition-all flex items-center justify-center shadow-sm"
                                                            data-val="{{ $val }}" data-stored="{{ $stored }}"
                                                            onclick="selectScore(this, 'p3')">
                                                            {{ $val }}
                                                        </button>
                                                    @endforeach
                                                </div>
                                                <input type="hidden" name="scores[{{ $cs->card_id }}][profesi_3]"
                                                    id="inp-{{ $cs->card_id }}-p3" value="{{ $ep3 !== null ? $ep3 : '' }}">
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50/80 border-t-2 border-gray-200">
                                        <td class="p-4 font-bold text-gray-700 text-sm">TOTAL SKOR KECOCOKAN</td>
                                        <td class="p-4 text-center">
                                            <div class="text-xs text-gray-500 mb-1 font-semibold uppercase">
                                                {{ $user->profesi_1 }}
                                            </div>
                                            <span id="total-p1"
                                                class="text-xl font-bold text-orange-600 bg-white px-4 py-1.5 rounded-lg border border-orange-200 shadow-sm inline-block min-w-[70px]">0</span>
                                        </td>
                                        <td class="p-4 text-center border-l border-gray-100">
                                            <div class="text-xs text-gray-500 mb-1 font-semibold uppercase">
                                                {{ $user->profesi_2 }}
                                            </div>
                                            <span id="total-p2"
                                                class="text-xl font-bold text-orange-600 bg-white px-4 py-1.5 rounded-lg border border-orange-200 shadow-sm inline-block min-w-[70px]">0</span>
                                        </td>
                                        <td class="p-4 text-center border-l border-gray-100">
                                            <div class="text-xs text-gray-500 mb-1 font-semibold uppercase">
                                                {{ $user->profesi_3 }}
                                            </div>
                                            <span id="total-p3"
                                                class="text-xl font-bold text-orange-600 bg-white px-4 py-1.5 rounded-lg border border-orange-200 shadow-sm inline-block min-w-[70px]">0</span>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="modal-kembali"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[9999] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <div
            class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300">
            <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="alert-triangle" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Kembali ke Drag & Drop?</h3>
            <p class="text-sm text-center text-gray-500 mb-6 leading-relaxed">
                Hasil sortir Anda sebelumnya tidak akan hilang, namun Anda akan mengulang melihat tumpukan kartu. Apakah
                Anda yakin?
            </p>
            <div class="flex gap-3 justify-center">
                <button onclick="document.getElementById('modal-kembali').classList.remove('active')"
                    class="px-5 py-2.5 rounded-lg font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors flex-1">
                    Batal
                </button>
                <a href="{{ route('tests.start', $session->category_id) }}"
                    class="px-5 py-2.5 rounded-lg font-semibold text-white bg-red-500 hover:bg-red-600 transition-colors flex-1 text-center">
                    Ya, Kembali
                </a>
            </div>
        </div>
    </div>

    <!-- Modal Validasi -->
    <div id="modal-validasi"
        class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm z-[9999] hidden items-center justify-center opacity-0 transition-opacity duration-300">
        <div
            class="bg-white rounded-2xl p-6 sm:p-8 max-w-sm w-full mx-4 shadow-2xl transform scale-95 transition-transform duration-300">
            <div
                class="w-16 h-16 bg-orange-100 text-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                <i data-lucide="info" class="w-8 h-8"></i>
            </div>
            <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Oops! Belum Selesai</h3>
            <p class="text-sm text-center text-gray-500 mb-6 leading-relaxed">
                Mohon pastikan Anda mengisi semua kolom (3 profesi untuk setiap kartu) dengan angka penilaian sebelum
                menyimpan.
            </p>
            <div class="flex justify-center">
                <button onclick="document.getElementById('modal-validasi').classList.remove('active')"
                    class="px-8 py-2.5 rounded-lg font-semibold text-white bg-orange-500 hover:bg-orange-600 transition-colors w-full text-center">
                    Mengerti
                </button>
            </div>
        </div>
    </div>

    <style>
        /* Sembunyikan navigasi utama aplikasi agar tampilan layar penuh untuk tes */
        nav {
            display: none !important;
        }

        /* Override background bawaan layout agar menjadi gradasi biru */
        .min-h-screen {
            background: linear-gradient(135deg, #8ba8d8 0%, #e8f0fe 50%, #8ba8d8 100%) !important;
        }

        .score-btn.active-p1,
        .score-btn.active-p2,
        .score-btn.active-p3 {
            background-color: #ea580c !important;
            border-color: #ea580c !important;
            color: white !important;
            transform: scale(1.05);
            box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.3);
        }

        .score-btn[data-val="-1"],
        .score-btn[data-val="-2"],
        .score-btn[data-val="-3"] {
            color: #ef4444;
        }

        .score-btn[data-val="-1"]:hover,
        .score-btn[data-val="-2"]:hover,
        .score-btn[data-val="-3"]:hover {
            border-color: #ef4444 !important;
            color: #ef4444 !important;
            background-color: #fef2f2 !important;
        }

        #modal-kembali.active,
        #modal-validasi.active {
            display: flex !important;
            opacity: 1 !important;
        }

        #modal-kembali.active>div,
        #modal-validasi.active>div {
            transform: scale(1) !important;
        }
    </style>

    <script>
        lucide.createIcons();

        // Timer Logic: Ambil dari localStorage terlebih dahulu (yang disimpan tahap 1), jika tidak ada pakai database
        let savedTime = localStorage.getItem('test_timer_1');
        let dbTime = {{ intval($elapsedSeconds ?? 0) }};
        let timeElapsed = savedTime ? parseInt(savedTime) : dbTime;

        const timerTextEl = document.getElementById('timer-text');

        function formatTime(s) {
            const h = Math.floor(s / 3600);
            const m = Math.floor((s % 3600) / 60);
            const sec = s % 60;
            return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
        }

        let timerInterval = null;

        function startTimer() {
            if (timerInterval) return;
            timerInterval = setInterval(() => {
                timeElapsed++;
                if (timerTextEl) timerTextEl.textContent = formatTime(timeElapsed);
            }, 1000);
        }

        function stopTimer() {
            if (timerInterval) {
                clearInterval(timerInterval);
                timerInterval = null;
            }
        }

        if (timerTextEl) {
            timerTextEl.textContent = formatTime(timeElapsed);
            if (!document.hidden) startTimer();
            document.addEventListener('visibilitychange', () => document.hidden ? stopTimer() : startTimer());
        }

        const TOTAL_CELLS = {{ $sortedAlways->count() * 3 }};
        let filledCount = 0;

        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('input[type=hidden][id^="inp-"]').forEach(inp => {
                if (inp.value !== '') filledCount++;
            });
            recalcAll();
        });

        function selectScore(btn, profesiKey) {
            const group = btn.closest('.score-group');
            const kartuId = group.dataset.kartu;
            const storedVal = btn.dataset.stored;
            const activeClass = 'active-' + profesiKey;

            const wasActive = btn.classList.contains(activeClass);
            const prevActive = group.querySelector('.' + activeClass);
            const hadPrev = !!prevActive;

            group.querySelectorAll('.score-btn').forEach(b => b.classList.remove(activeClass));

            const inp = document.getElementById('inp-' + kartuId + '-' + profesiKey);
            if (wasActive) {
                inp.value = '';
                if (hadPrev) filledCount--;
            } else {
                btn.classList.add(activeClass);
                inp.value = storedVal;
                if (!hadPrev) filledCount++;
            }

            recalcAll();
        }

        function recalcAll() {
            let t1 = 0, t2 = 0, t3 = 0;
            document.querySelectorAll('input[id$="-p1"]').forEach(i => { if (i.value !== '') t1 += parseInt(i.value); });
            document.querySelectorAll('input[id$="-p2"]').forEach(i => { if (i.value !== '') t2 += parseInt(i.value); });
            document.querySelectorAll('input[id$="-p3"]').forEach(i => { if (i.value !== '') t3 += parseInt(i.value); });

            document.getElementById('total-p1').textContent = t1 >= 0 ? '+' + t1 : t1;
            document.getElementById('total-p2').textContent = t2 >= 0 ? '+' + t2 : t2;
            document.getElementById('total-p3').textContent = t3 >= 0 ? '+' + t3 : t3;
        }

        function submitWorksheet() {
            if (filledCount < TOTAL_CELLS) {
                document.getElementById('modal-validasi').classList.add('active');
                return;
            }
            document.getElementById('input-duration').value = timeElapsed;
            document.getElementById('worksheet-form').submit();
        }
    </script>
</x-app-layout>