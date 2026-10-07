@extends('layouts.landing')

@section('title', 'FAQ — Knowdell Digital')

@section('content')
    <div class="faq-wrapper">

        <span class="faq-badge">FAQ</span>
        <h1>Pertanyaan yang Sering Diajukan</h1>
        <p class="faq-lead">
            Kumpulan jawaban atas pertanyaan yang paling sering muncul seputar platform,
            proses tes, dan penggunaan hasil asesmen. Tidak menemukan jawaban yang kamu cari?
            Hubungi kami melalui Instagram <a href="https://instagram.com/ccdaukrida" target="_blank" style="color: #2563eb; font-weight: 600;">@ccdaukrida</a>.
        </p>

        {{-- TENTANG PLATFORM --}}
        <p class="faq-category">Tentang Platform</p>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Apakah platform ini gratis digunakan?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Ya, platform ini sepenuhnya gratis untuk pengguna. Cukup daftarkan akun menggunakan email dan data dirimu, lalu kamu sudah bisa mengakses semua instrumen tes yang tersedia.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Apa itu Knowdell Card Sorts dan mengapa digunakan di sini?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Knowdell Card Sorts adalah serangkaian instrumen asesmen karier yang dikembangkan oleh Richard Knowdell, konselor karier bersertifikat internasional. Metode ini telah digunakan oleh para profesional konseling di seluruh dunia selama lebih dari 40 tahun. Platform ini mengadaptasi metode tersebut ke dalam bentuk digital agar lebih mudah diakses kapan saja dan di mana saja.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Apakah hasil tes ini sama dengan diagnosis psikologis?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Tidak. Hasil asesmen dari platform ini bukan merupakan diagnosis klinis dalam bentuk apapun. Platform ini adalah alat bantu eksplorasi karier yang dirancang untuk membantu kamu mengenali nilai, minat, dan keterampilan yang paling sesuai denganmu. Hasil tes sebaiknya selalu dikonsultasikan dengan konselor yang ditugaskan untuk mendapatkan interpretasi yang tepat.</p>
            </div>
        </div>

        {{-- PENGERJAAN TES --}}
        <p class="faq-category">Pengerjaan Tes</p>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Berapa lama waktu yang dibutuhkan untuk menyelesaikan satu tes?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Tidak ada batas waktu pengerjaan. Kamu bebas mengerjakan tes dengan kecepatan yang paling nyaman untukmu — bisa diselesaikan sekaligus, atau dicicil beberapa sesi. Selama kamu menekan tombol <strong>Simpan Progress</strong> sebelum keluar, semua jawaban yang sudah kamu isi akan tersimpan dan bisa dilanjutkan kapan saja.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Apakah progress saya tersimpan otomatis jika browser ditutup?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Progress tidak tersimpan secara otomatis. Pastikan kamu menekan tombol <strong>Simpan Progress</strong> sebelum menutup browser atau keluar dari halaman tes. Jika tidak, jawaban yang belum disimpan akan hilang. Biasakan untuk menyimpan secara berkala, terutama setelah menyortir sejumlah kartu.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Bisakah saya mengerjakan lebih dari satu instrumen tes?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Bisa. Kamu dapat mengerjakan semua 4 instrumen yang tersedia yaitu Career Values, Motivated Skills, Occupational Interests, dan Leisure & Retirement Activities. Bahkan kamu bisa mengulang instrumen yang sama lebih dari sekali jika ingin membandingkan hasilmu dari waktu ke waktu.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Apakah saya bisa mengerjakan ulang tes yang sudah selesai?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Ya, tidak ada batasan jumlah pengerjaan. Kamu bisa mengerjakan instrumen yang sama berkali-kali. Setiap hasil pengerjaan akan tersimpan dan bisa diakses melalui riwayat tes di dashboard, sehingga kamu bisa membandingkan perkembanganmu dari waktu ke waktu.</p>
            </div>
        </div>

        {{-- KONSELOR & HASIL TES --}}
        <p class="faq-category">Konselor &amp; Hasil Tes</p>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Bagaimana saya mendapatkan konselor?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Konselor ditugaskan secara manual oleh administrator platform dari Fakultas Psikologi UKRIDA. Setelah kamu mendaftar dan mengisi data diri secara lengkap, administrator akan menugaskan konselor yang sesuai untukmu. Kamu akan dapat melihat konselor yang ditugaskan melalui dashboard setelah proses penugasan selesai.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Siapa saja yang bisa melihat hasil tes saya?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Hasil tesmu hanya dapat diakses oleh kamu sendiri dan konselor yang secara resmi ditugaskan kepadamu. Administrator platform hanya mengakses data untuk keperluan teknis, bukan untuk keperluan asesmen. Data kamu tidak akan dibagikan kepada pihak lain yang tidak diperlukan tanpa persetujuanmu.</p>
            </div>
        </div>

        <div class="faq-item">
            <button class="faq-question" onclick="toggleFaq(this)">
                <span>Bagaimana cara mengunduh atau mencetak hasil tes?</span>
                <div class="faq-icon"><i class="fas fa-chevron-down"></i></div>
            </button>
            <div class="faq-answer">
                <p>Setelah tes selesai, hasil akan langsung muncul di dashboard-mu. Dari halaman hasil, kamu bisa mengunduh laporan dalam format PDF atau mencetak langsung untuk dibawa ke sesi konseling bersama konselormu.</p>
            </div>
        </div>

        <div class="faq-contact">
            <div>
                <h3>Masih ada pertanyaan lain?</h3>
                <p>Hubungi kami langsung melalui Instagram — kami akan membantu secepatnya.</p>
            </div>
            <a href="https://instagram.com/ccdaukrida" target="_blank">
                <i class="fab fa-instagram"></i> @ccdaukrida
            </a>
        </div>

    </div>

    <script>
        function toggleFaq(btn) {
            const item   = btn.closest('.faq-item');
            const answer = item.querySelector('.faq-answer');
            const isOpen = item.classList.contains('open');

            document.querySelectorAll('.faq-item.open').forEach(el => {
                el.classList.remove('open');
                el.querySelector('.faq-answer').classList.remove('open');
            });

            if (!isOpen) {
                item.classList.add('open');
                answer.classList.add('open');
            }
        }
    </script>
@endsection
