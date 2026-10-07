@extends('layouts.dashboard')

@section('title', 'Profil Konselor - ' . $counselor->full_name)

@section('content')
<div class="bio-page-wrapper animate-fade-up">

    {{-- Back --}}
    <div style="margin-bottom: 1.5rem;">
        <a href="javascript:history.back()" class="btn-back">
            <i class="fa-solid fa-arrow-left"></i> Kembali
        </a>
    </div>

    {{-- Hero Card --}}
    <div class="bio-hero-card">
        <div class="bio-avatar">{{ substr($counselor->full_name, 0, 1) }}</div>

        <div class="bio-name-block">
            <h1 class="bio-name">{{ $counselor->full_name }}</h1>

            @if($counselor->title)
                <p class="bio-title">{{ $counselor->title }}</p>
            @endif

            @if($counselor->specialization)
                <div class="bio-spec-badge">
                    <i class="fa-solid fa-star"></i>
                    {{ $counselor->specialization }}
                </div>
            @endif

            <div class="bio-meta-row">
                @if($counselor->institution)
                    <span class="bio-meta-item">
                        <i class="fa-solid fa-building"></i> {{ $counselor->institution }}
                    </span>
                @endif
                <span class="bio-meta-item">
                    <i class="fa-regular fa-calendar-check"></i>
                    Bergabung {{ $counselor->created_at->translatedFormat('F Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- Biografi --}}
    <div class="bio-content-card">
        <h2 class="bio-section-title">
            <i class="fa-solid fa-user-graduate"></i> Riwayat &amp; Biografi
        </h2>

        @if($counselor->biography)
            <p class="bio-text">{{ $counselor->biography }}</p>
        @else
            <div class="bio-empty">
                <i class="fa-regular fa-file-lines"></i>
                <p>Konselor belum menambahkan biografi.</p>
            </div>
        @endif
    </div>

    {{-- Info kontak (opsional) --}}
    @if($counselor->email)
    <div class="bio-content-card">
        <h2 class="bio-section-title">
            <i class="fa-solid fa-envelope"></i> Kontak
        </h2>
        <div class="bio-meta-row" style="gap: 1.5rem;">
            <span class="bio-meta-item" style="font-size: 0.95rem;">
                <i class="fa-solid fa-envelope"></i> {{ $counselor->email }}
            </span>
            @if($counselor->phone)
                <span class="bio-meta-item" style="font-size: 0.95rem;">
                    <i class="fa-solid fa-phone"></i> {{ $counselor->phone }}
                </span>
            @endif
        </div>
    </div>
    @endif

</div>
@endsection
