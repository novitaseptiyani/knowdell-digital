<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center relative">
            <div class="w-1/3 flex justify-start">
                <a href="/tests/{{ $kategori->id }}/intro"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-red-200 rounded-lg hover:bg-red-50 hover:border-red-300 text-red-600 font-medium transition-colors text-sm shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
            </div>
            <div class="w-1/3 flex justify-center">
                <h2 class="font-bold text-2xl text-red-600 tracking-tight">{{ $kategori->name }}</h2>
            </div>
            <div class="w-1/3 flex justify-end">
                <div class="flex flex-col items-end">
                    <span class="text-sm font-semibold text-gray-700 mb-1">
                        Disortir: <span id="sorted-count">0</span> / <span id="total-count">{{ count($cards) }}</span>
                    </span>
                    <div class="w-32 h-2 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="h-full bg-red-500 w-0 transition-all duration-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-6 min-h-[calc(100vh-100px)] flex flex-col">
        <div class="max-w-[1600px] mx-auto sm:px-6 lg:px-8 w-full flex-1 flex flex-col gap-4">

            <div class="flex flex-col xl:flex-row h-full gap-6 w-full items-start">

                {{-- LEFT: Controls & Deck --}}
                <div class="w-full xl:w-[35%] flex flex-col gap-5 sticky top-6">

                    {{-- Action Buttons & Timer --}}
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex items-center gap-3 w-full">
                            <button id="btn-save"
                                class="px-5 py-2 border border-red-200 text-red-600 rounded-md hover:bg-red-100 font-medium transition-all text-sm shadow-sm flex items-center justify-center gap-2 bg-white flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Progres
                            </button>
                            <button id="btn-finish" disabled
                                class="px-5 py-2 bg-red-500 text-white rounded-md hover:bg-red-600 disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-all text-sm shadow-sm flex items-center justify-center gap-2 flex-1">
                                Selesai Tes
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <div
                                class="px-3 py-2 bg-white/80 backdrop-blur-sm border border-red-200 text-red-700 font-bold rounded-md shadow-sm flex items-center gap-1.5 justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="test-timer" class="tracking-widest tabular-nums text-sm">00:00:00</span>
                            </div>
                        </div>
                        <p id="cell-hint" class="text-xs font-semibold text-center"></p>
                    </div>

                    {{-- Deck --}}
                    <div
                        class="w-full bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col relative min-h-[400px]">
                        <div id="deck" class="flex justify-center items-center flex-1 container-drop relative"
                            data-column="deck">
                            @php
                                $savedPositions = $responses->pluck('choice_category_id', 'card_id')->toArray();
                            @endphp
                            @foreach($cards as $card)
                                @php $savedColumn = $savedPositions[$card->id] ?? null; @endphp
                                <div draggable="true" id="card-{{ $card->id }}" data-id="{{ $card->id }}"
                                    data-saved-column="{{ $savedColumn }}"
                                    class="sort-card bg-gradient-to-br from-red-50 to-red-100 border border-red-200 shadow-sm rounded-xl p-5 cursor-grab active:cursor-grabbing hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(239,68,68,0.5)] transition-all duration-300 select-none flex flex-col items-center justify-center min-w-[200px] h-[280px] max-w-[240px] text-center w-full">
                                    <h4 class="card-title text-lg font-bold text-red-900 mb-3">{{ $card->card_name }}</h4>
                                    <p
                                        class="card-desc text-xs text-red-800/80 flex-1 flex items-center justify-center leading-relaxed font-medium">
                                        {{ $card->description }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                        <div id="deck-hint"
                            class="text-center mt-4 text-xs font-medium text-red-800 bg-red-50 py-2 rounded-lg border border-dashed border-red-200">
                            Tarik kartu ke sel matrix di sebelah kanan
                        </div>
                    </div>
                </div>

                {{-- RIGHT: Matrix Grid --}}
                <div class="w-full xl:w-[65%] overflow-x-auto">
                    @php
                        $rows = [
                            ['id' => 11, 'label' => 'Sangat Suka', 'sub' => 'Totally Delight', 'ids' => [11, 12, 13]],
                            ['id' => 14, 'label' => 'Benar-benar Senang', 'sub' => 'Enjoy Very Much', 'ids' => [14, 15, 16]],
                            ['id' => 17, 'label' => 'Suka', 'sub' => 'Like Using', 'ids' => [17, 18, 19]],
                            ['id' => 20, 'label' => 'Lebih Memilih Tidak', 'sub' => 'Prefer Not To', 'ids' => [20, 21, 22]],
                            ['id' => 23, 'label' => 'Sangat Tidak Suka', 'sub' => 'Strongly Dislike', 'ids' => [23, 24, 25]],
                        ];
                        $cols = [
                            ['label' => 'Sangat Mahir', 'sub' => 'Highly Proficient'],
                            ['label' => 'Kompeten', 'sub' => 'Competent'],
                            ['label' => 'Kurang Menguasai', 'sub' => 'Lack Desired Skill'],
                        ];

                        $motivatedZones = [11, 12];
                        $developmentZones = [13];
                        $burnoutZones = [23, 24];
                    @endphp

                    <div style="min-width: 700px;">

                        {{-- Header kolom --}}
                        <div
                            style="display: grid; grid-template-columns: 160px repeat(3, 1fr); gap: 8px; margin-bottom: 8px;">
                            <div></div>
                            @foreach($cols as $col)
                                <div
                                    style="text-align: center; font-size: 0.8rem; font-weight: 800; color: #9f1239; padding: 0.5rem; background: #fff1f2; border: 1.5px solid #fecaca; border-radius: 10px; letter-spacing: 0.03em;">
                                    {{ $col['label'] }}
                                    <div
                                        style="font-size: 0.62rem; font-weight: 500; color: #be123c; opacity: 0.75; font-style: italic; letter-spacing: 0; margin-top: 1px;">
                                        {{ $col['sub'] }}
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        {{-- Baris matrix --}}
                        @foreach($rows as $row)
                            <div
                                style="display: grid; grid-template-columns: 160px repeat(3, 1fr); gap: 8px; margin-bottom: 8px;">

                                <div style="display: flex; align-items: center;">
                                    <div
                                        style="text-align: center; font-size: 0.8rem; font-weight: 800; color: #9f1239; padding: 0.5rem 0.4rem; background: #fff1f2; border: 1.5px solid #fecaca; border-radius: 10px; width: 100%; line-height: 1.3;">
                                        {{ $row['label'] }}
                                        <div
                                            style="font-size: 0.62rem; font-weight: 500; color: #be123c; opacity: 0.75; font-style: italic; letter-spacing: 0; margin-top: 1px;">
                                            {{ $row['sub'] }}
                                        </div>
                                    </div>
                                </div>

                                @foreach($row['ids'] as $choiceId)
                                    @php
                                        $isMotivated = in_array($choiceId, $motivatedZones);
                                        $isDevelopment = in_array($choiceId, $developmentZones);
                                        $isBurnout = in_array($choiceId, $burnoutZones);
                                        $cellBorder = $isMotivated ? '#16a34a'
                                            : ($isDevelopment ? '#f59e0b'
                                                : ($isBurnout ? '#dc2626' : '#e2e8f0'));
                                    @endphp
                                    <div
                                        style="background: #ffffff; border: 1.5px solid {{ $cellBorder }}; border-radius: 12px; min-height: 120px; overflow: hidden; position: relative;">

                                        @if($isMotivated)
                                            <div
                                                style="background: #16a34a; color: white; text-align: center; font-size: 0.6rem; font-weight: 800; padding: 3px 6px; letter-spacing: 0.08em;">
                                                MOTIVATED SKILLS</div>
                                        @elseif($isDevelopment)
                                            <div
                                                style="background: #f59e0b; color: white; text-align: center; font-size: 0.6rem; font-weight: 800; padding: 3px 6px; letter-spacing: 0.08em;">
                                                AREA PENGEMBANGAN</div>
                                        @elseif($isBurnout)
                                            <div
                                                style="background: #dc2626; color: white; text-align: center; font-size: 0.6rem; font-weight: 800; padding: 3px 6px; letter-spacing: 0.08em;">
                                                BURNOUT SKILLS</div>
                                        @endif

                                        <div style="padding: 4px 8px; border-bottom: 1px solid #f1f5f9; text-align: center;">
                                            <span style="font-size: 0.7rem; font-weight: 600; color: #94a3b8;"
                                                id="count-{{ $choiceId }}">0 Kartu</span>
                                        </div>

                                        <div class="container-drop" data-column="{{ $choiceId }}" data-max="999"
                                            style="padding: 6px; min-height: 80px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmation Modal --}}
        <div id="finish-modal"
            class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 transform scale-95 transition-transform duration-300"
                id="finish-modal-content">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Selesai Tes?</h3>
                <p class="text-center text-sm text-gray-500 mb-6">Apakah kamu yakin telah menempatkan semua kartu di sel
                    yang tepat? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex gap-3">
                    <button id="btn-cancel-finish"
                        class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">Batal</button>
                    <button id="btn-confirm-finish"
                        class="flex-1 px-4 py-2.5 bg-red-500 text-white font-semibold rounded-lg hover:bg-red-600 transition-colors shadow-md shadow-red-200 text-sm">Ya,
                        Selesai</button>
                </div>
            </div>
        </div>

        <style>
            nav {
                display: none !important;
            }

            body {
                background: radial-gradient(circle at 10% 20%, rgba(30, 64, 175, 0.45) 0%, transparent 40%), radial-gradient(circle at 90% 80%, rgba(30, 64, 175, 0.45) 0%, transparent 40%), #e0f2fe !important;
                background-attachment: fixed !important;
            }

            .min-h-screen {
                background-color: transparent !important;
            }

            #deck .sort-card {
                display: none !important;
            }

            #deck .sort-card:first-child {
                display: flex !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 6px 0 -2px #fee2e2, 0 6px 3px -2px rgba(0, 0, 0, 0.1), 0 12px 0 -4px #fecaca, 0 12px 3px -4px rgba(0, 0, 0, 0.1);
                transform: translateY(-6px);
            }

            #deck .sort-card:first-child:hover {
                transform: translateY(-10px);
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 6px 0 -2px #fee2e2, 0 6px 3px -2px rgba(0, 0, 0, 0.1), 0 12px 0 -4px #fecaca, 0 12px 3px -4px rgba(0, 0, 0, 0.1), 0 0 20px rgba(239, 68, 68, 0.5);
            }

            .container-drop:not([data-column="deck"]) .sort-card {
                display: none !important;
            }

            .container-drop:not([data-column="deck"]) .sort-card:last-child {
                display: flex !important;
                width: 70px !important;
                height: 90px !important;
                min-width: 70px !important;
                flex-shrink: 0 !important;
                padding: 0.35rem !important;
                margin-top: 0 !important;
                box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1), 0 3px 0 -1px #fee2e2, 0 3px 2px -1px rgba(0, 0, 0, 0.1), 0 6px 0 -2px #fecaca, 0 6px 2px -2px rgba(0, 0, 0, 0.1) !important;
                border-radius: 6px !important;
                cursor: pointer !important;
                transform: translateY(-2px);
                transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            }

            .container-drop:not([data-column="deck"]) .sort-card:last-child:hover {
                transform: translateY(-6px);
                z-index: 50;
            }

            .container-drop:not([data-column="deck"]) .sort-card .card-desc {
                display: none !important;
            }

            .container-drop:not([data-column="deck"]) .sort-card .card-title {
                margin-bottom: 0 !important;
                font-size: 0.6rem !important;
                line-height: 0.85rem !important;
                white-space: normal;
            }

            .sort-card.dragging {
                opacity: 0.5;
                transform: scale(1.05);
            }

            .container-drop.drag-over {
                background-color: rgba(0, 0, 0, 0.04) !important;
                border-radius: 0.5rem;
                outline: 2px dashed #94a3b8;
            }

            @media (max-width: 768px) {
                .py-6 {
                    padding-top: 0.75rem !important;
                    padding-bottom: 0.75rem !important;
                }

                .sm\:px-6 {
                    padding-left: 0.75rem !important;
                    padding-right: 0.75rem !important;
                }

                #btn-save,
                #btn-finish {
                    font-size: 0.72rem !important;
                    padding: 0.5rem 0.6rem !important;
                }

                #test-timer {
                    font-size: 0.72rem !important;
                }

                #deck .sort-card:first-child {
                    min-width: 150px !important;
                    height: 180px !important;
                    max-width: 180px !important;
                }

                #deck .sort-card .card-title {
                    font-size: 0.9rem !important;
                }

                #deck .sort-card .card-desc {
                    font-size: 0.72rem !important;
                }

                .min-h-\[400px\] {
                    min-height: 250px !important;
                }

                .text-sm {
                    font-size: 0.75rem !important;
                }

                .w-32 {
                    width: 6rem !important;
                }

                .gap-6 {
                    gap: 0.875rem !important;
                }

                .gap-5 {
                    gap: 0.625rem !important;
                }

                .p-6 {
                    padding: 0.875rem !important;
                }
            }

            /* Mobile: tap-to-place */
            @media (max-width: 1024px) {
                .card-selected {
                    outline: 3px solid #f59e0b !important;
                    transform: translateY(-6px) scale(1.03) !important;
                    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.25), 0 8px 20px rgba(245, 158, 11, 0.4) !important;
                    z-index: 50;
                    position: relative;
                }

                .container-drop.drop-target {
                    outline: 2px dashed #f59e0b !important;
                    background: #fffbeb !important;
                }

                #mobile-banner {
                    position: fixed;
                    bottom: 1.25rem;
                    left: 50%;
                    transform: translateX(-50%) translateY(100px);
                    background: #0f172a;
                    color: white;
                    padding: 0.75rem 1.25rem;
                    border-radius: 50px;
                    font-size: 0.8rem;
                    font-weight: 700;
                    z-index: 500;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    box-shadow: 0 8px 24px rgba(0, 0, 0, 0.35);
                    transition: transform 0.3s ease;
                    max-width: 88vw;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }

                #mobile-banner.show {
                    transform: translateX(-50%) translateY(0);
                }

                #mobile-banner-cancel {
                    background: rgba(255, 255, 255, 0.15);
                    border: none;
                    border-radius: 50px;
                    color: white;
                    padding: 0.2rem 0.75rem;
                    font-size: 0.78rem;
                    font-weight: 700;
                    cursor: pointer;
                    font-family: inherit;
                    flex-shrink: 0;
                }
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const containers = document.querySelectorAll('.container-drop');
                const totalCards = {{ count($cards) }};
                const sortedCountEl = document.getElementById('sorted-count');
                const progressBar = document.getElementById('progress-bar');
                const btnFinish = document.getElementById('btn-finish');
                const btnSave = document.getElementById('btn-save');
                const categoryId = {{ $kategori->id }};
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                const isMobile = window.innerWidth <= 1024;

                // DESKTOP: SortableJS drag & drop
                if (!isMobile) {
                    containers.forEach(container => {
                        new Sortable(container, {
                            group: { name: 'shared', put: true },
                            animation: 150,
                            easing: "cubic-bezier(0.175, 0.885, 0.32, 1.275)",
                            ghostClass: 'opacity-50',
                            dragClass: 'scale-105',
                            delay: 50,
                            delayOnTouchOnly: true,
                            touchStartThreshold: 5,
                            onEnd: function () { updateCounts(); updateProgress(); }
                        });
                    });
                }

                // MOBILE: tap-to-place
                if (isMobile) {
                    const deckHint = document.getElementById('deck-hint');
                    if (deckHint) deckHint.textContent = 'Ketuk kartu, lalu ketuk sel tujuan';

                    let selectedCard = null;

                    const banner = document.createElement('div');
                    banner.id = 'mobile-banner';
                    banner.innerHTML = `<span id="mobile-banner-text">Pilih sel tujuan</span><button id="mobile-banner-cancel">✕ Batal</button>`;
                    document.body.appendChild(banner);

                    document.getElementById('mobile-banner-cancel').addEventListener('click', deselect);

                    function selectCard(card) {
                        if (selectedCard) selectedCard.classList.remove('card-selected');
                        selectedCard = card;
                        card.classList.add('card-selected');
                        containers.forEach(c => {
                            if (c.dataset.column !== 'deck') c.classList.add('drop-target');
                        });
                        const name = card.querySelector('.card-title')?.textContent?.trim() ?? 'Kartu';
                        document.getElementById('mobile-banner-text').textContent =
                            `"${name.length > 20 ? name.slice(0, 20) + '…' : name}" — pilih sel`;
                        banner.classList.add('show');
                    }

                    function deselect() {
                        if (selectedCard) selectedCard.classList.remove('card-selected');
                        selectedCard = null;
                        containers.forEach(c => c.classList.remove('drop-target'));
                        banner.classList.remove('show');
                    }

                    document.addEventListener('click', function (e) {
                        if (e.target.closest('#btn-save') || e.target.closest('#btn-finish') ||
                            e.target.closest('#finish-modal') || e.target.closest('#mobile-banner-cancel')) return;

                        const card = e.target.closest('.sort-card');
                        const container = e.target.closest('.container-drop');

                        if (card) {
                            e.stopPropagation();
                            if (selectedCard === card) { deselect(); return; }
                            selectCard(card);
                            return;
                        }

                        if (selectedCard && container) {
                            e.stopPropagation();
                            const col = container.dataset.column;
                            if (col === 'deck') { deselect(); return; }
                            container.appendChild(selectedCard);
                            deselect();
                            updateCounts();
                            updateProgress();
                            return;
                        }

                        if (selectedCard && !card && !container) deselect();
                    });
                }

                // SHARED FUNCTIONS 
                function updateCounts() {
                    containers.forEach(container => {
                        const colId = container.getAttribute('data-column');
                        if (colId !== 'deck') {
                            const countEl = document.getElementById(`count-${colId}`);
                            if (countEl) countEl.textContent = `${container.children.length} Kartu`;
                        }
                    });
                }

                function updateProgress() {
                    const deck = document.getElementById('deck');
                    const sortedCardsCount = totalCards - deck.children.length;
                    sortedCountEl.textContent = sortedCardsCount;
                    progressBar.style.width = `${(sortedCardsCount / totalCards) * 100}%`;

                    const allSorted = sortedCardsCount === totalCards;
                    const cellContainers = [...containers].filter(c => c.getAttribute('data-column') !== 'deck');
                    const emptyCells = cellContainers.filter(c => c.children.length === 0).length;
                    const allCellsFilled = emptyCells === 0;

                    btnFinish.disabled = !(allSorted && allCellsFilled);

                    const hint = document.getElementById('cell-hint');
                    if (hint) {
                        if (allSorted && allCellsFilled) {
                            hint.textContent = 'Semua sel terisi — tes siap diselesaikan!';
                            hint.style.color = '#16a34a';
                        } else if (allSorted && !allCellsFilled) {
                            hint.textContent = `${emptyCells} sel masih kosong — setiap sel harus berisi minimal 1 kartu.`;
                            hint.style.color = '#dc2626';
                        } else {
                            hint.textContent = '';
                        }
                    }
                }

                function collectCardPositions() {
                    const cardData = {};
                    containers.forEach(container => {
                        const colId = container.getAttribute('data-column');
                        if (colId === 'deck') return;
                        container.querySelectorAll('.sort-card').forEach(card => {
                            cardData[card.getAttribute('data-id')] = colId;
                        });
                    });
                    return cardData;
                }

                function saveToServer(callback = null) {
                    const payload = { duration: accumulatedSeconds, cards: collectCardPositions() };
                    fetch(`/tests/${categoryId}/save`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify(payload),
                        keepalive: true,
                    })
                        .then(res => res.json())
                        .then(data => { if (callback) callback(data); })
                        .catch(err => console.error('Save failed:', err));
                }

                btnSave.addEventListener('click', () => {
                    saveToServer(() => showToast('Progres berhasil disimpan.', 'success'));
                });

                const finishModal = document.getElementById('finish-modal');
                const finishModalContent = document.getElementById('finish-modal-content');

                btnFinish.addEventListener('click', () => {
                    finishModal.classList.remove('opacity-0', 'pointer-events-none');
                    finishModalContent.classList.remove('scale-95');
                });

                document.getElementById('btn-cancel-finish').addEventListener('click', () => {
                    finishModal.classList.add('opacity-0', 'pointer-events-none');
                    finishModalContent.classList.add('scale-95');
                });

                document.getElementById('btn-confirm-finish').addEventListener('click', () => {
                    stopTimer();
                    showToast('Mengirim data...', 'info');
                    fetch(`/tests/${categoryId}/finish`, {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken },
                        body: JSON.stringify({ duration: accumulatedSeconds, cards: collectCardPositions() }),
                    })
                        .then(res => res.json())
                        .then(data => {
                            if (data.status === 'finished') {
                                showToast('Tes selesai! Mengalihkan...', 'success');
                                setTimeout(() => {
                                    window.location.href = `/tests/${categoryId}/result/${data.session_id}`;
                                }, 1500);
                            }
                        })
                        .catch(err => {
                            console.error('Finish failed:', err);
                            showToast('Terjadi kesalahan. Coba lagi.', 'error');
                        });
                });

                window.showToast = function (message, type = 'success') {
                    let container = document.getElementById('toast-container');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'toast-container';
                        container.className = 'fixed top-5 right-5 z-[200] flex flex-col gap-3';
                        document.body.appendChild(container);
                    }
                    const bgColors = {
                        success: 'bg-green-50 text-green-800 border-green-200',
                        error: 'bg-red-50 text-red-800 border-red-200',
                        info: 'bg-blue-50 text-blue-800 border-blue-200',
                        warning: 'bg-orange-50 text-orange-800 border-orange-200',
                    };
                    const icons = {
                        success: `<svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`,
                        error: `<svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`,
                        info: `<svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
                        warning: `<svg class="w-5 h-5 text-orange-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`,
                    };
                    const toast = document.createElement('div');
                    toast.className = `flex items-center gap-3 px-4 py-3 border rounded-lg shadow-lg transform transition-all duration-300 translate-y-[-1rem] opacity-0 ${bgColors[type]}`;
                    toast.innerHTML = `${icons[type]}<p class="font-medium text-sm m-0 leading-none">${message}</p>`;
                    container.appendChild(toast);
                    requestAnimationFrame(() => toast.classList.remove('translate-y-[-1rem]', 'opacity-0'));
                    setTimeout(() => {
                        toast.classList.add('opacity-0', 'translate-x-full');
                        setTimeout(() => toast.remove(), 300);
                    }, 3000);
                };

                // TIMER
                const timerEl = document.getElementById('test-timer');
                let accumulatedSeconds = {{ $initialDuration ?? 0 }};
                let timerInterval = null;

                function formatTime(s) {
                    const h = Math.floor(s / 3600);
                    const m = Math.floor((s % 3600) / 60);
                    const sec = s % 60;
                    return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
                }

                function startTimer() {
                    if (timerInterval) return;
                    timerInterval = setInterval(() => { accumulatedSeconds++; timerEl.textContent = formatTime(accumulatedSeconds); }, 1000);
                }

                function stopTimer() {
                    if (timerInterval) { clearInterval(timerInterval); timerInterval = null; }
                }

                timerEl.textContent = formatTime(accumulatedSeconds);
                if (!document.hidden) startTimer();
                document.addEventListener('visibilitychange', () => document.hidden ? stopTimer() : startTimer());

                // RESTORE SAVED POSITIONS
                function restoreSavedPositions() {
                    document.querySelectorAll('.sort-card[data-saved-column]').forEach(card => {
                        const savedColumn = card.getAttribute('data-saved-column');
                        if (savedColumn && savedColumn !== 'null') {
                            const targetContainer = document.querySelector(`.container-drop[data-column="${savedColumn}"]`);
                            if (targetContainer) targetContainer.appendChild(card);
                        }
                    });
                }

                restoreSavedPositions();
                updateCounts();
                updateProgress();
            });
        </script>
    </div>
</x-app-layout>