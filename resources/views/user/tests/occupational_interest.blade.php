<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center relative">
            <div class="flex-1 sm:w-1/3 flex justify-start">
                <a href="/tests/{{ $kategori->id }}/intro"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-blue-200 rounded-lg hover:bg-blue-50 hover:border-blue-300 text-blue-600 font-medium transition-colors text-sm shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    <span class="hidden sm:inline">Kembali</span>
                </a>
            </div>
            <div class="hidden sm:flex w-1/3 justify-center">
                <h2 class="font-bold text-2xl text-blue-600 tracking-tight">{{ $kategori->name }}</h2>
            </div>
            <div class="flex-1 sm:w-1/3 flex justify-end">
                <div class="flex flex-col items-end">
                    <span class="text-sm font-semibold text-gray-700 mb-1">
                        <span class="hidden sm:inline">Disortir: </span>
                        <span id="sorted-count">0</span>/<span id="total-count">{{ count($cards) }}</span>
                    </span>
                    <div class="w-24 sm:w-32 h-2 bg-gray-200 rounded-full overflow-hidden shadow-inner">
                        <div id="progress-bar" class="h-full bg-blue-500 w-0 transition-all duration-300"></div>
                    </div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-4 sm:py-6 min-h-[calc(100vh-100px)] flex flex-col">
        <div class="max-w-[1600px] mx-auto px-3 sm:px-6 lg:px-8 w-full flex-1 flex flex-col gap-4">
            <div class="flex flex-col xl:flex-row h-full gap-4 sm:gap-6 w-full items-start">

                {{-- LEFT: Controls & Deck --}}
                <div class="w-full xl:w-[30%] flex flex-col gap-3 sm:gap-5 sm:sticky sm:top-6" style="z-index: 10;">

                    {{-- Action Buttons & Timer --}}
                    <div class="flex flex-col gap-2 w-full">
                        <div class="flex items-center gap-2 sm:gap-3 w-full">
                            <button id="btn-save"
                                class="px-3 sm:px-5 py-2 border border-blue-200 text-blue-600 rounded-md hover:bg-blue-100 font-medium transition-all text-xs sm:text-sm shadow-sm flex items-center justify-center gap-1.5 sm:gap-2 bg-white flex-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                                </svg>
                                Simpan Progres
                            </button>
                            <button id="btn-finish" disabled
                                class="px-3 sm:px-5 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 disabled:opacity-50 disabled:cursor-not-allowed font-medium transition-all text-xs sm:text-sm shadow-sm flex items-center justify-center gap-1.5 sm:gap-2 flex-1">
                                Selesai
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <div class="px-2 sm:px-3 py-2 bg-white/80 backdrop-blur-sm border border-blue-200 text-blue-700 font-bold rounded-md shadow-sm flex items-center gap-1 sm:gap-1.5 justify-center flex-shrink-0">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 sm:h-5 sm:w-5 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span id="test-timer" class="tracking-widest tabular-nums text-xs sm:text-sm">00:00:00</span>
                            </div>
                        </div>
                        <p id="cell-hint" class="text-xs font-semibold text-center"></p>
                    </div>

                    {{-- Deck --}}
                    <div class="w-full bg-white/80 backdrop-blur-md rounded-xl shadow-sm border border-gray-100 p-4 sm:p-6 flex flex-col relative min-h-[260px] sm:min-h-[400px]">
                        <div id="deck" class="flex justify-center items-center flex-1 container-drop relative" data-column="deck">
                            @php $savedPositions = $responses->pluck('choice_category_id', 'card_id')->toArray(); @endphp
                            @foreach($cards as $card)
                                @php $savedColumn = $savedPositions[$card->id] ?? null; @endphp
                                <div draggable="true"
                                    id="card-{{ $card->id }}"
                                    data-id="{{ $card->id }}"
                                    data-saved-column="{{ $savedColumn }}"
                                    class="sort-card relative bg-gradient-to-br from-blue-50 to-blue-100 border border-blue-200 shadow-sm rounded-xl p-4 sm:p-5 cursor-grab active:cursor-grabbing hover:-translate-y-2 hover:shadow-[0_0_20px_rgba(59,130,246,0.5)] transition-all duration-300 select-none flex flex-col items-center justify-center min-w-[160px] sm:min-w-[200px] h-[220px] sm:h-[280px] max-w-[190px] sm:max-w-[240px] text-center w-full">
                                    <h4 class="card-title text-base sm:text-lg font-bold text-blue-900 mb-2 sm:mb-3">{{ $card->card_name }}</h4>
                                    @if($card->kode)
                                        <div class="card-desc absolute top-3 right-3 flex items-center justify-center">
                                            <span class="px-2 py-0.5 bg-blue-100 text-blue-800 font-bold rounded text-[0.65rem] sm:text-xs border border-blue-200 tracking-wider shadow-sm">
                                                {{ $card->kode }}
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div id="deck-hint" class="text-center mt-3 text-xs font-medium text-blue-800 bg-blue-50 py-2 rounded-lg border border-dashed border-blue-200 mb-2">
                            Tarik kartu ke kolom di sebelah kanan
                        </div>
                    </div>
                </div>

                {{-- RIGHT: 5 Columns --}}
                <div class="w-full xl:w-[70%] overflow-x-auto -mx-3 px-3 sm:mx-0 sm:px-0" style="z-index: 1; position: relative;">
                    @php
                        $columns = [
                            ['id' => 26, 'label' => 'Pasti Tertarik', 'sub' => 'Definitely Interested', 'max' => 999, 'is_limited' => false],
                            ['id' => 27, 'label' => 'Mungkin Tertarik', 'sub' => 'Probably Interested', 'max' => 999, 'is_limited' => false],
                            ['id' => 28, 'label' => 'Biasa Saja', 'sub' => 'Indifferent', 'max' => 999, 'is_limited' => false],
                            ['id' => 29, 'label' => 'Mungkin Tidak Tertarik', 'sub' => 'Probably Not Interested', 'max' => 999, 'is_limited' => false],
                            ['id' => 30, 'label' => 'Pasti Tidak Tertarik', 'sub' => 'Definitely Not Interested', 'max' => 999, 'is_limited' => false],
                        ];
                        $green = ['border' => '#3b82f6', 'bg' => '#eff6ff', 'text' => '#1d4ed8'];
                    @endphp

                    <div style="display: grid; grid-template-columns: repeat(5, 1fr); gap: 8px; min-width: 650px;">
                        @foreach($columns as $col)
                            <div style="display: flex; flex-direction: column; gap: 6px;">
                                <div style="background: {{ $green['bg'] }}; border: 1.5px solid {{ $green['border'] }}; border-radius: 10px; padding: 0.4rem; text-align: center; min-height: 72px; display: flex; flex-direction: column; align-items: center; justify-content: center;">
                                    <div style="font-size: 0.78rem; font-weight: 800; color: {{ $green['text'] }}; line-height: 1.3;">{{ $col['label'] }}</div>
                                    <div style="font-size: 0.6rem; color: {{ $green['text'] }}; opacity: 0.7; font-style: italic;">{{ $col['sub'] }}</div>
                                    @if($col['is_limited'])
                                        <div style="font-size: 0.58rem; font-weight: 700; color: {{ $green['text'] }}; margin-top: 2px;">Maks. {{ $col['max'] }} kartu</div>
                                    @else
                                        <div style="font-size: 0.58rem; visibility: hidden;">placeholder</div>
                                    @endif
                                </div>
                                <div style="text-align: center; padding: 2px 0;">
                                    <span style="font-size: 0.68rem; font-weight: 600; color: #94a3b8;" id="count-{{ $col['id'] }}">
                                        {{ $col['is_limited'] ? '0 Kartu' : '0 Kartu' }}
                                    </span>
                                </div>
                                <div class="container-drop"
                                    data-column="{{ $col['id'] }}"
                                    data-max="{{ $col['max'] }}"
                                    style="background: #ffffff; border: 1.5px solid {{ $green['border'] }}; border-radius: 12px; min-height: 300px; padding: 5px; display: flex; flex-direction: column; align-items: stretch; gap: 4px;">
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Confirmation Modal --}}
        <div id="finish-modal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/40 backdrop-blur-sm opacity-0 pointer-events-none transition-opacity duration-300">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 p-6 transform scale-95 transition-transform duration-300" id="finish-modal-content">
                <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center mb-4 mx-auto">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-center text-gray-900 mb-2">Selesai Tes?</h3>
                <p class="text-center text-sm text-gray-500 mb-6">Apakah kamu yakin telah menempatkan semua kartu? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="flex gap-3">
                    <button id="btn-cancel-finish" class="flex-1 px-4 py-2.5 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition-colors text-sm">Batal</button>
                    <button id="btn-confirm-finish" class="flex-1 px-4 py-2.5 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition-colors shadow-md shadow-blue-200 text-sm">Ya, Selesai</button>
                </div>
            </div>
        </div>

        <style>
            nav { display: none !important; }
            body {
                background: radial-gradient(circle at 10% 20%, rgba(30, 64, 175, 0.45) 0%, transparent 40%),
                            radial-gradient(circle at 90% 80%, rgba(30, 64, 175, 0.45) 0%, transparent 40%),
                            #e0f2fe !important;
                background-attachment: fixed !important;
            }
            .min-h-screen { background-color: transparent !important; }

            #deck .sort-card { display: none !important; }
            #deck .sort-card:first-child {
                display: flex !important;
                height: 110px !important;
                min-height: unset !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 6px 0 -2px #dbeafe, 0 6px 3px -2px rgba(0,0,0,0.1), 0 12px 0 -4px #bfdbfe, 0 12px 3px -4px rgba(0,0,0,0.1);
                transform: translateY(-6px);
            }
            #deck .sort-card:first-child:hover {
                transform: translateY(-10px);
                box-shadow: 0 1px 3px rgba(0,0,0,0.1), 0 6px 0 -2px #dbeafe, 0 6px 3px -2px rgba(0,0,0,0.1), 0 12px 0 -4px #bfdbfe, 0 12px 3px -4px rgba(0,0,0,0.1), 0 0 20px rgba(59,130,246,0.5);
            }

            .container-drop:not([data-column="deck"]) .sort-card {
                display: flex !important;
                width: 100% !important;
                min-height: 40px !important;
                height: auto !important;
                max-width: unset !important;
                min-width: unset !important;
                padding: 0.35rem 0.5rem !important;
                border-radius: 8px !important;
                cursor: grab !important;
                transform: none !important;
                box-shadow: 0 1px 3px rgba(0,0,0,0.06) !important;
                flex-shrink: 0 !important;
                align-items: center !important;
                justify-content: flex-start !important;
                text-align: left !important;
            }
            .container-drop:not([data-column="deck"]) .sort-card:hover {
                transform: scale(1.01) !important;
                box-shadow: 0 2px 8px rgba(59,130,246,0.2) !important;
            }
            .container-drop:not([data-column="deck"]) .sort-card .card-desc { display: none !important; }
            .container-drop:not([data-column="deck"]) .sort-card .card-title {
                font-size: 0.68rem !important;
                font-weight: 700 !important;
                line-height: 1.3 !important;
                margin-bottom: 0 !important;
                white-space: normal !important;
                text-align: left !important;
            }
            .sort-card.dragging { opacity: 0.5; transform: scale(1.05); }
            .container-drop.drag-over {
                background-color: rgba(34, 197, 94, 0.08) !important;
                border-radius: 0.5rem;
                outline: 2px dashed #3b82f6;
            }
            .container-drop.drag-full {
                border-color: #dc2626 !important;
                background-color: #fef2f2 !important;
            }

            @media (max-width: 768px) {
                .py-6 { padding-top: 0.75rem !important; padding-bottom: 0.75rem !important; }
                .sm\:px-6 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
                #btn-save, #btn-finish { font-size: 0.72rem !important; padding: 0.5rem 0.6rem !important; }
                #test-timer { font-size: 0.72rem !important; }
                #deck .sort-card:first-child {
                    min-width: 150px !important;
                    height: 180px !important;
                    max-width: 180px !important;
                }
                #deck .sort-card .card-title { font-size: 0.9rem !important; }
                #deck .sort-card .card-desc  { font-size: 0.72rem !important; }
                .min-h-\[400px\] { min-height: 250px !important; }
                .text-sm { font-size: 0.75rem !important; }
                .w-32 { width: 6rem !important; }
                .gap-6 { gap: 0.875rem !important; }
                .gap-5 { gap: 0.625rem !important; }
                .p-6   { padding: 0.875rem !important; }
            }

            /* Mobile: Modal Move */
            @media (max-width: 1024px) {
                .card-selected {
                    outline: 3px solid #3b82f6 !important;
                    transform: translateY(-6px) scale(1.03) !important;
                    box-shadow: 0 0 0 4px rgba(59,130,246,0.25), 0 8px 20px rgba(59,130,246,0.4) !important;
                    z-index: 50;
                    position: relative;
                }
            }
        </style>

        <script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const containers    = document.querySelectorAll('.container-drop');
                const totalCards    = {{ count($cards) }};
                const sortedCountEl = document.getElementById('sorted-count');
                const progressBar   = document.getElementById('progress-bar');
                const btnFinish     = document.getElementById('btn-finish');
                const btnSave       = document.getElementById('btn-save');
                const categoryId    = {{ $kategori->id }};
                const csrfToken     = document.querySelector('meta[name="csrf-token"]').content;

                const isMobile = window.innerWidth <= 1024;

                // ── DESKTOP: SortableJS drag & drop
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
                            onMove: function(evt) {
                                const to  = evt.to;
                                const max = parseInt(to.getAttribute('data-max')) || 999;
                                if (to.getAttribute('data-column') !== 'deck' && to.children.length >= max) {
                                    return false;
                                }
                            },
                            onEnd: function() { updateCounts(); updateProgress(); }
                        });
                    });
                }


                // ── MOBILE: Modal Move 
                if (isMobile) {
                    const deckHint = document.getElementById('deck-hint');
                    if (deckHint) deckHint.textContent = 'Ketuk kartu untuk memindahkannya';

                    let selectedCard = null;
                    const moveModal = document.getElementById('mobile-move-modal');
                    const moveModalContent = document.getElementById('mobile-move-content');

                    function openMoveModal(card) {
                        selectedCard = card;
                        card.classList.add('card-selected');
                        
                        const title = card.querySelector('.card-title')?.textContent?.trim() ?? 'Kartu';
                        const desc = card.querySelector('.card-desc')?.textContent?.trim() ?? '';
                        
                        document.getElementById('move-modal-title').textContent = title;
                        document.getElementById('move-modal-desc').textContent = desc;

                        moveModal.classList.remove('opacity-0', 'pointer-events-none');
                        if (window.innerWidth <= 640) {
                            moveModalContent.classList.remove('translate-y-full');
                        } else {
                            moveModalContent.classList.remove('scale-95');
                        }
                    }

                    function closeMoveModal() {
                        if (selectedCard) selectedCard.classList.remove('card-selected');
                        selectedCard = null;
                        
                        moveModal.classList.add('opacity-0', 'pointer-events-none');
                        if (window.innerWidth <= 640) {
                            moveModalContent.classList.add('translate-y-full');
                        } else {
                            moveModalContent.classList.add('scale-95');
                        }
                    }

                    document.getElementById('btn-cancel-move').addEventListener('click', closeMoveModal);

                    document.querySelectorAll('.btn-move-target').forEach(btn => {
                        btn.addEventListener('click', (e) => {
                            if (!selectedCard) return;
                            const targetColId = e.currentTarget.getAttribute('data-target');
                            const container = document.querySelector(`.container-drop[data-column="${targetColId}"]`);
                            
                            if (container) {
                                const max = parseInt(container.dataset.max) || 999;
                                if (targetColId !== 'deck' && container.children.length >= max) {
                                    showToast('Penuh!', 'warning');
                                    return; // Jangan tutup modal
                                }
                                container.appendChild(selectedCard);
                                updateCounts();
                                updateProgress();
                            }
                            closeMoveModal();
                        });
                    });

                    document.addEventListener('click', function(e) {
                        if (e.target.closest('#btn-save') || e.target.closest('#btn-finish') ||
                            e.target.closest('#finish-modal') || e.target.closest('#mobile-move-modal') ||
                            e.target.closest('.btn-move-target')) return;

                        const card = e.target.closest('.sort-card');
                        if (card) {
                            e.stopPropagation();
                            if (selectedCard === card) { closeMoveModal(); return; }
                            openMoveModal(card);
                        }
                    });
                }

                // ── SHARED FUNCTIONS 
                function updateCounts() {
                    containers.forEach(container => {
                        const colId = container.getAttribute('data-column');
                        if (colId === 'deck') return;
                        const max     = parseInt(container.getAttribute('data-max')) || 999;
                        const count   = container.children.length;
                        const isFull  = max < 999 && count >= max;
                        const countEl = document.getElementById(`count-${colId}`);
                        if (countEl) {
                            countEl.textContent  = max < 999 ? `${count} / ${max} Kartu` : `${count} Kartu`;
                            countEl.style.color  = isFull ? '#dc2626' : '#94a3b8';
                            countEl.style.fontWeight = isFull ? '800' : '600';
                        }
                        container.classList.toggle('drag-full', isFull);
                    });
                }

                function updateProgress() {
                    const deck = document.getElementById('deck');
                    const sortedCount = totalCards - deck.children.length;
                    sortedCountEl.textContent = sortedCount;
                    progressBar.style.width = `${(sortedCount / totalCards) * 100}%`;
                    btnFinish.disabled = sortedCount !== totalCards;

                    const isFull = false;
                    
                    const hint = document.getElementById('cell-hint');
                    if (hint) {
                        if (sortedCount === totalCards) {
                            hint.textContent = 'Semua kartu tersortir — tes siap diselesaikan!';
                            hint.style.color = '#3b82f6';
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

                const finishModal        = document.getElementById('finish-modal');
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

                window.showToast = function(message, type = 'success') {
                    let container = document.getElementById('toast-container');
                    if (!container) {
                        container = document.createElement('div');
                        container.id = 'toast-container';
                        container.className = 'fixed top-5 right-5 z-[200] flex flex-col gap-3';
                        document.body.appendChild(container);
                    }
                    const bgColors = {
                        success: 'bg-blue-50 text-blue-800 border-blue-200',
                        error:   'bg-red-50 text-red-800 border-red-200',
                        info:    'bg-blue-50 text-blue-800 border-blue-200',
                        warning: 'bg-orange-50 text-orange-800 border-orange-200',
                    };
                    const icons = {
                        success: `<svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`,
                        error:   `<svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`,
                        info:    `<svg class="w-5 h-5 text-blue-500 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`,
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

                // ── TIMER 
                const timerEl = document.getElementById('test-timer');
                let accumulatedSeconds = {{ $initialDuration ?? 0 }};
                let timerInterval = null;

                function formatTime(s) {
                    const h   = Math.floor(s / 3600);
                    const m   = Math.floor((s % 3600) / 60);
                    const sec = s % 60;
                    return String(h).padStart(2,'0')+':'+String(m).padStart(2,'0')+':'+String(sec).padStart(2,'0');
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

                // ── RESTORE SAVED POSITIONS 
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