@props([
    'theme'       => 'blue',
    'icon'        => 'fa-regular fa-lightbulb',
    'title'       => 'Title',
    'description' => 'Description',
    'href'        => '#',
    'disabled'    => false
])

@php
    $bgColors = [
        'blue'   => '#2563eb',
        'green'  => '#10b981',
        'yellow' => '#f59e0b',
        'red'    => '#ef4444',
    ];
    $shadowColors = [
        'blue'   => 'rgba(37, 99, 235, 0.3)',
        'green'  => 'rgba(16, 185, 129, 0.3)',
        'yellow' => 'rgba(245, 158, 11, 0.3)',
        'red'    => 'rgba(239, 68, 68, 0.3)',
    ];
    $bgColor     = $bgColors[$theme]     ?? '#2563eb';
    $shadowColor = $shadowColors[$theme] ?? 'rgba(37, 99, 235, 0.3)';
    $isDisabled  = $disabled ?? false;
@endphp

{{--
    Inline style hanya menyimpan nilai DINAMIS dari PHP:
    - --card-shadow : warna shadow hover (CSS custom property, resolve di :hover)
    - background-color card-top & color card-title/card-btn tetap inline karena $bgColor dinamis

    onmouseover/onmouseout sudah dihapus — hover ditangani CSS .instrument-card:hover
    onclick tetap JS karena CSS tidak bisa navigasi
--}}
<div class="instrument-card animate-fade-up {{ $isDisabled ? 'instrument-card--disabled' : '' }}"
     style="--card-shadow: {{ $shadowColor }};"
     @if(!$isDisabled) onclick="window.location.href='{{ $href }}'" @endif>

    <div class="card-top" style="background-color: {{ $bgColor }};">
        <i class="{{ $icon }} card-top-icon"></i>
    </div>

    <div class="card-bottom">
        <h3 class="card-title" style="color: {{ $bgColor }};">{{ $title }}</h3>
        <p class="card-desc">{{ $description }}</p>

        @if($isDisabled)
            <div class="card-coming-soon">
                <i class="fa-solid fa-clock"></i> Segera Hadir
            </div>
        @else
            <a href="{{ $href }}" class="card-btn" style="color: {{ $bgColor }};">
                Mulai Tes <i class="fa-solid fa-arrow-right" style="font-size: 0.9rem;"></i>
            </a>
        @endif
    </div>
</div>
