@extends('layouts.dashboard')

@section('title', 'Persiapan - ' . $kategori->name)

@section('content')
    @php
        $theme = [
            'gradient' => '#fef2f2',
            'shadow' => 'rgba(239, 68, 68, 0.08)',
            'svg' => 'rgba(239, 68, 68, 0.03)',
            'icon_bg' => '#fee2e2',
            'icon_color' => '#ef4444',
        ];

        if ($kategori->id == 1) {
            $theme = ['gradient' => '#fff7ed', 'shadow' => 'rgba(234, 88, 12, 0.08)', 'svg' => 'rgba(234, 88, 12, 0.03)', 'icon_bg' => '#ffedd5', 'icon_color' => '#ea580c'];
        } elseif ($kategori->id == 3) {
            $theme = ['gradient' => '#f0fdf4', 'shadow' => 'rgba(34, 197, 94, 0.08)', 'svg' => 'rgba(34, 197, 94, 0.03)', 'icon_bg' => '#dcfce7', 'icon_color' => '#22c55e'];
        } elseif ($kategori->id == 4) {
            $theme = ['gradient' => '#eff6ff', 'shadow' => 'rgba(37, 99, 235, 0.08)', 'svg' => 'rgba(37, 99, 235, 0.03)', 'icon_bg' => '#dbeafe', 'icon_color' => '#3b82f6'];
        }
    @endphp

    <style>
        .intro-banner {
            background: linear-gradient(135deg, #ffffff 0%,
                    {{ $theme['gradient'] }}
                    100%);
            border-radius: 30px;
            padding: 4rem 3rem;
            color: #0f172a;
            text-align: center;
            margin-bottom: 3rem;
            box-shadow: 0 15px 35px
                {{ $theme['shadow'] }}
            ;
            position: relative;
            overflow: hidden;
        }

        .intro-banner::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml;utf8,<svg width="100" height="100" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"><path fill="{{ $theme['svg'] }}" d="M50 0L100 50L50 100L0 50Z"/></svg>') repeat;
            background-size: 50px 50px;
            z-index: 1;
        }

        .intro-icon {
            width: 80px;
            height: 80px;
            background:
                {{ $theme['icon_bg'] }}
            ;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2.5rem;
            color:
                {{ $theme['icon_color'] }}
            ;
            margin: 0 auto 1.5rem auto;
        }
    </style>

    <div class="intro-container animate-fade-up">

        {{-- Back --}}
        <div style="margin-bottom: 1.5rem;">
            <a href="{{ route('dashboard') }}" class="btn-back">
                <i class="fa-solid fa-arrow-left"></i> Kembali ke Beranda
            </a>
        </div>

        {{-- Banner --}}
        <div class="intro-banner">
            <div class="intro-banner-content">
                <div class="intro-icon">
                    @if($kategori->id == 1) <i class="fa-solid fa-bullseye"></i>
                    @elseif($kategori->id == 2) <i class="fa-regular fa-lightbulb"></i>
                    @elseif($kategori->id == 3) <i class="fa-solid fa-umbrella-beach"></i>
                    @elseif($kategori->id == 4) <i class="fa-solid fa-suitcase"></i>
                    @else <i class="fa-solid fa-layer-group"></i>
                    @endif
                </div>

                <h1 class="intro-title">{{ $kategori->name }}</h1>

                @if($kategori->id == 1)
                    <p class="intro-quote">"Pekerjaan yang memuaskan bukan hanya soal gaji atau jabatan, melainkan seberapa
                        selaras pekerjaan tersebut dengan nilai-nilai yang kamu pegang teguh."</p>
                    <p class="intro-quote intro-quote--last">"Tes ini hadir untuk membantumu memetakan dan mengenali apa yang
                        sebenarnya paling kamu butuhkan agar merasa bahagia dan bermakna dalam berkarier."</p>
                @elseif($kategori->id == 2)
                    <p class="intro-quote">"Pernahkah kamu merasa sangat ahli dalam sesuatu tapi tidak menikmatinya? Atau malah
                        sebaliknya, sangat suka sesuatu tapi merasa belum mahir?"</p>
                    <p class="intro-quote intro-quote--last">"Tes ini akan membantumu memetakan keterampilan yang tidak hanya
                        kamu kuasai, tapi juga memberimu semangat saat mengerjakannya."</p>
                @elseif($kategori->id == 3)
                    <p class="intro-quote">"Tidak semua hal dalam hidup harus diukur dari produktivitas kerja."</p>
                    <p class="intro-quote intro-quote--last">"Temukan aktivitas apa saja yang memberimu energi, hobi yang
                        melegakan pikiran, dan hal-hal yang ingin kamu nikmati di masa tuamu kelak."</p>
                @elseif($kategori->id == 4)
                    <p class="intro-quote">"Setiap orang punya panggilan alaminya masing-masing dalam berkarya."</p>
                    <p class="intro-quote intro-quote--last">"Eksplorasi minat pekerjaan mana yang paling membangkitkan rasa
                        antusiasmemu, dan mana yang sama sekali tidak."</p>
                @endif
            </div>
        </div>

        {{-- Deskripsi & Rules --}}
        <div class="intro-desc-box animate-fade-up" style="animation-delay: 0.1s;">
            <h3 class="desc-title"><i class="fa-solid fa-book-open"></i> Deskripsi Tes</h3>
            <div class="desc-content">Silakan pahami panduan tes di bawah ini dengan baik sebelum memulai tesmu.</div>

            <div class="rules-grid">
                <div class="rule-item">
                    <div class="rule-icon"><i class="fa-solid fa-hand-pointer"></i></div>
                    <div class="rule-text">
                        <h4>Cara Bermain</h4>
                        <p>Tes ini menggunakan antarmuka tarik dan lepas untuk pengalaman yang menyenangkan.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <div class="rule-icon"><i class="fa-regular fa-clock"></i></div>
                    <div class="rule-text">
                        <h4>Waktu Pengerjaan</h4>
                        <p>Kami akan mencatat waktu aktif layar Anda saat mengerjakan tes ini, tapi tidak ada batas waktu
                            jadi kerjakan tanpa terburu-buru.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <div class="rule-icon"><i class="fa-solid fa-floppy-disk"></i></div>
                    <div class="rule-text">
                        <h4>Simpan Progres</h4>
                        <p>Progres akan tersimpan saat Anda klik simpan progres. Anda bisa melanjutkan kapanpun tanpa
                            khawatir data hilang atau mulai dari awal.</p>
                    </div>
                </div>
                <div class="rule-item">
                    <div class="rule-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <div class="rule-text">
                        <h4>Validasi Tahap Akhir</h4>
                        <p>Anda dapat mengubah jawaban sebelum menyelesaikan tes. Tidak ada jawaban benar atau salah,
                            jawablah dengan jujur dan santai.</p>
                    </div>
                </div>
            </div>

            {{-- Info box per kategori --}}
            @if($kategori->id == 1)
                <div class="intro-info-box intro-info-box--orange">
                    <i class="fa-solid fa-circle-info intro-info-box-icon"></i>
                    <div>
                        <h4>Cara Kerja Tes Career Values</h4>
                        <p style="margin-bottom: 0.75rem;">Instrumen ini adalah alat sederhana yang memungkinkanmu
                            memprioritaskan nilai-nilai kariermu dalam waktu singkat. Terdapat <strong>54 variabel kepuasan
                                kerja</strong> (seperti kebebasan waktu, kekuasaan, atau kontak dengan publik) yang akan kamu
                            sortir ke dalam 5 kategori.</p>

                        <p style="margin-bottom: 0.5rem;"><strong>Tujuan Tes:</strong></p>
                        <ul style="list-style-type: disc; margin-left: 1.5rem; margin-bottom: 0.75rem; color: #c2410c;">
                            <li>Mendefinisikan faktor-faktor yang mempengaruhi kepuasan kariermu.</li>
                            <li>Menentukan seberapa kuat perasaanmu terhadap faktor-faktor tersebut.</li>
                            <li>Mengidentifikasi area konflik dan keselarasan nilai dalam pilihan karier.</li>
                        </ul>

                        <p style="margin-bottom: 0.5rem;"><strong>Panduan Pengerjaan:</strong></p>
                        <p style="margin-bottom: 0.4rem;"> 1. Tes ini layaknya bermain <em>solitaire</em>. Kamu akan menggeser
                            54 kartu ke dalam 5 kolom: <strong>Selalu Penting, Sering Penting, Kadang Penting, Jarang Penting,
                                dan Tidak Pernah Penting</strong>.</p>
                        <p style="margin-bottom: 0.4rem;"> 2. Identifikasi apa yang benar-benar penting bagimu, <strong>tanpa
                                memedulikan</strong> apa yang orang lain pikirkan atau harapkan darimu. Bergeraklah dengan cepat
                            mengikuti intuisimu.</p>
                        <p style="margin-bottom: 0.4rem;"> 3. <strong>Catatan Penting:</strong> Kolom <strong>"Selalu
                                Penting"</strong> dan <strong>"Tidak Pernah Penting"</strong> masing-masing maksimal berisi <strong>10 kartu</strong>. Setelah
                            selesai mengelompokkan, kamu bisa menyusun ulang kartu di dalam setiap kolom dari yang paling
                            penting (di atas) ke yang paling tidak penting (di bawah).</p>
                    </div>
                </div>

            @elseif($kategori->id == 2)
                <div class="intro-info-box intro-info-box--red">
                    <i class="fa-solid fa-circle-info intro-info-box-icon"></i>
                    <div>
                        <h4>Cara Kerja Tes Motivated Skills</h4>
                        <p style="margin-bottom: 0.75rem;">Kamu akan menyortir <strong>50 kartu keterampilan</strong> ke dalam
                            sebuah <strong>matrix 5×3</strong> yang menggabungkan dua hal sekaligus: seberapa
                            <strong>suka</strong> kamu menggunakan keterampilan itu (baris dari atas ke bawah), dan seberapa
                            <strong>mahir</strong> kamu melakukannya (kolom dari kiri ke kanan).</p>
                        <p style="margin-bottom: 0.5rem;">Ada <strong>3 zona penting</strong> yang akan terbentuk di matrix-mu:
                        </p>
                        <p style="margin-bottom: 0.4rem;"> 1. <strong>Motivated Skills</strong> (pojok kiri atas), kamu sangat
                            suka dan sangat mahir. Inilah kekuatan sejatimu yang sebaiknya jadi fokus utama kariermu.</p>
                        <p style="margin-bottom: 0.4rem;"> 2. <strong>Area Pengembangan</strong> (pojok kanan atas), kamu suka
                            tapi belum terlalu mahir. Potensi besar yang layak dikembangkan lebih lanjut.</p>
                        <p style="margin-bottom: 0.75rem;"> 3. <strong>Burnout Skills</strong> (pojok kiri bawah), kamu mahir
                            tapi tidak suka. Hati-hati, terlalu banyak melakukan hal yang tidak kamu sukai bisa menyebabkan
                            kelelahan.</p>
                        <p style="margin-bottom: 0;"><strong>Yang perlu diingat:</strong> setiap sel dalam matrix wajib terisi
                            minimal 1 kartu sebelum kamu bisa menyelesaikan tes. Jawablah berdasarkan pengalaman nyatamu, bukan
                            apa yang kamu harapkan atau yang terdengar keren di mata orang lain.</p>
                    </div>
                </div>

            @elseif($kategori->id == 3)
                <div class="intro-info-box intro-info-box--green">
                    <i class="fa-solid fa-circle-info intro-info-box-icon"></i>
                    <div>
                        <h4>Cara Kerja Tes Leisure &amp; Retirement</h4>
                        <p style="margin-bottom: 0.75rem;">Kamu akan menyortir <strong>54 kartu aktivitas</strong> ke dalam 5
                            kolom berdasarkan seberapa sering kamu ingin melakukan aktivitas tersebut: <strong>Setiap Hari,
                                Sering, Sesekali, Jarang,</strong> dan <strong>Tidak Pernah</strong>.</p>
                        <p style="margin-bottom: 0.75rem;"><strong>Kolom "Setiap Hari" dibatasi maksimal 8 kartu.</strong>
                            Tujuannya adalah memaksamu untuk benar-benar memilih aktivitas yang paling penting bagimu, bukan
                            semua yang kamu sukai. Dengan batasan ini, hasilmu akan lebih bermakna dan mencerminkan prioritas
                            aslimu.</p>
                        <p style="margin-bottom: 0.5rem;"><strong>Tips dari panduan resmi Knowdell:</strong></p>
                        <p style="margin-bottom: 0.4rem;"> 1. Bayangkan kamu punya waktu luang penuh, tidak ada pekerjaan dan
                            tidak ada kewajiban. Apa yang paling ingin kamu lakukan?</p>
                        <p style="margin-bottom: 0.4rem;"> 2. Gerak cepat dan ikuti instingmu. Jangan terlalu lama memikirkan
                            tiap kartu karena jawaban pertama biasanya yang paling jujur.</p>
                        <p style="margin-bottom: 0.4rem;"> 3. Abaikan soal biaya, kemampuan saat ini, atau ketersediaan waktu.
                            Jawab murni berdasarkan keinginanmu, bukan kondisimu sekarang.</p>
                        <p style="margin-bottom: 0;"> 4. Tidak ada jawaban benar atau salah. Ini semua tentang apa yang
                            benar-benar kamu inginkan untuk hidupmu.</p>
                    </div>
                </div>

            @elseif($kategori->id == 4)
                <div class="intro-info-box intro-info-box--blue">
                    <i class="fa-solid fa-circle-info intro-info-box-icon"></i>
                    <div>
                        <h4>Cara Kerja Tes Occupational Interests</h4>
                        <p style="margin-bottom: 0.75rem;">Instrumen ini memberikan cara cepat dan mudah untuk memperluas
                            pandanganmu mengenai minat pekerjaanmu di luar pekerjaanmu saat ini. Tes ini berisi <strong>114
                                kartu jenis pekerjaan</strong> (seperti Insinyur, Guru Bahasa, Manajer HRD, dll) yang
                            masing-masing dilengkapi dengan kode Holland (RIASEC).</p>

                        <p style="margin-bottom: 0.5rem;"><strong>Tujuan Tes:</strong></p>
                        <ul style="list-style-type: disc; margin-left: 1.5rem; margin-bottom: 0.75rem; color: #1d4ed8;">
                            <li>Memperluas pandanganmu terhadap pekerjaan-pekerjaan yang menurutmu menarik.</li>
                            <li>Mengamati karakteristik umum dari pekerjaan-pekerjaan tersebut.</li>
                            <li>Mengaplikasikan hasil dari penyortiran kartu ini ke dalam rencana dan keputusan masa depanmu.
                            </li>
                        </ul>

                        <p style="margin-bottom: 0.5rem;"><strong>Panduan Pengerjaan:</strong></p>
                        <p style="margin-bottom: 0.4rem;"> 1. <strong>Bayangkan Skenario Ini:</strong> Anggaplah kamu sedang
                            berlibur di sebuah resor besar di mana tamu lainnya adalah individu yang mewakili 114 profesi yang
                            berbeda. Tugasmu adalah mencari tahu tamu mana yang paling ingin kamu ajak berinteraksi atau ngobrol
                            selama berada di resor tersebut.</p>
                        <p style="margin-bottom: 0.4rem;"> 2. Kamu akan menggeser 114 kartu ke dalam 5 kolom: <strong>Pasti
                                Tertarik, Mungkin Tertarik, Biasa Saja, Mungkin Tidak Tertarik,</strong> dan <strong>Pasti Tidak
                                Tertarik</strong>.</p>
                        <p style="margin-bottom: 0.4rem;"> 3. Pilih pekerjaan yang murni menarik bagimu <strong>tanpa
                                memedulikan</strong> apa yang mungkin dikatakan oleh orang lain. Sangat penting bagi kamu untuk
                            mengerjakan tes ini sendiri tanpa dicampuri pendapat teman atau pasangan.</p>
                        <p style="margin-bottom: 0;"> 4. <strong>Catatan Penting:</strong> Berbeda dengan tes lainnya, di sini
                            <strong>tidak ada batasan jumlah kartu</strong> yang harus kamu letakkan di masing-masing kategori.
                            Bergeraklah dengan cepat mengikuti perasaanmu terhadap setiap pekerjaan.</p>

                        <div style="margin-top: 1.5rem; background: #eff6ff; padding: 1.25rem; border-radius: 12px; border-left: 4px solid #3b82f6;">
                            <h5 style="color: #1e3a8a; font-weight: 700; margin-bottom: 0.75rem; font-size: 1.05rem;"><i class="fa-solid fa-tags"></i> Mengenal Kode Holland (RIASEC)</h5>
                            <p style="margin-bottom: 0.75rem; font-size: 0.95rem;">Setiap kartu pekerjaan memiliki kode 1 hingga 3 huruf yang mewakili tipe kepribadian Holland:</p>
                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem; font-size: 0.9rem;">
                                <div><strong style="color: #b91c1c;">R (Realistic):</strong> Praktis, suka bekerja dengan mesin/alat, aktivitas fisik.</div>
                                <div><strong style="color: #b45309;">I (Investigative):</strong> Analitis, suka meneliti, observasi, memecahkan masalah.</div>
                                <div><strong style="color: #15803d;">A (Artistic):</strong> Kreatif, inovatif, intuitif, suka seni & kebebasan berekspresi.</div>
                                <div><strong style="color: #0369a1;">S (Social):</strong> Suka menolong, mendidik, mengobati, atau melayani orang lain.</div>
                                <div><strong style="color: #6d28d9;">E (Enterprising):</strong> Persuasif, suka memimpin, mempengaruhi orang, ambisius.</div>
                                <div><strong style="color: #0f766e;">C (Conventional):</strong> Terorganisir, teliti, mengolah data, suka keteraturan & angka.</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        {{-- Start Action --}}
        <div class="start-action animate-fade-up" style="animation-delay: 0.2s;">
            @if(in_array($kategori->id, [1, 2, 3, 4]))
                <a href="{{ route('tests.start', $kategori->id) }}" class="start-btn">
                    Mulai Tes Sekarang <i class="fa-solid fa-arrow-right"></i>
                </a>
            @else
                <div class="coming-soon-box">
                    <div class="coming-soon-icon">🚧</div>
                    <div class="coming-soon-text">Segera Hadir</div>
                    <div class="coming-soon-desc">Instrumen tes ini sedang dalam tahap pengembangan.</div>
                </div>
            @endif
        </div>

    </div>
@endsection