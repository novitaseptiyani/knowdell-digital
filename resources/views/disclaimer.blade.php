@extends('layouts.landing')

@section('title', 'Disclaimer — Knowdell Digital')

@section('content')
    <div class="disclaimer-wrapper">

        <span class="disclaimer-badge"><i class="fas fa-triangle-exclamation" style="margin-right: 6px;"></i>DISCLAIMER</span>

        <h1>Disclaimer Penggunaan Platform</h1>
        <p class="disclaimer-meta">Harap baca seluruh pernyataan ini sebelum menggunakan platform &bull; Berlaku untuk seluruh pengguna</p>

        <div class="warning-banner">
            <i class="fas fa-triangle-exclamation"></i>
            <p>
                <strong>Penting:</strong> Hasil asesmen dari platform ini <strong>bukan merupakan diagnosis klinis</strong>
                dalam bentuk apapun. Platform ini adalah alat bantu eksplorasi karier, bukan pengganti layanan
                psikologi profesional, konseling klinis, atau pemeriksaan kesehatan mental.
            </p>
        </div>

        <div class="disclaimer-section">
            <h2>1. Sifat dan Tujuan Platform</h2>
            <p>Platform Knowdell Card Sorts Digital adalah alat asesmen karier berbasis psikologi vokasional yang dirancang untuk membantu individu <strong>mengeksplorasi</strong> nilai-nilai, keterampilan, minat, dan preferensi karier mereka bukan untuk menilai kondisi kesehatan mental, mendiagnosis gangguan psikologis, atau memberikan rekomendasi klinis.</p>
            <p>Instrumen yang tersedia di platform ini (Career Values, Motivated Skills, Occupational Interests, dan Leisure &amp; Retirement Activities) adalah alat asesmen psikologi vokasional yang valid secara internasional, namun interpretasi hasilnya tetap memerlukan keterlibatan konselor yang terlatih dan bersertifikat.</p>
        </div>

        <div class="disclaimer-section">
            <h2>2. Apa yang Boleh dan Tidak Boleh Dilakukan dengan Hasil Tes</h2>
            <div class="do-dont-grid">
                <div class="do-box">
                    <h3><i class="fas fa-check-circle" style="margin-right: 6px;"></i> Yang Tepat Dilakukan</h3>
                    <ul>
                        <li>Gunakan hasil sebagai bahan refleksi diri dan eksplorasi karier.</li>
                        <li>Bawa hasil ke sesi konseling bersama konselor yang ditugaskan.</li>
                        <li>Diskusikan hasil dengan konselor untuk mendapatkan interpretasi yang tepat.</li>
                        <li>Gunakan hasil sebagai salah satu pertimbangan dalam perencanaan karier.</li>
                    </ul>
                </div>
                <div class="dont-box">
                    <h3><i class="fas fa-times-circle" style="margin-right: 6px;"></i> Yang Tidak Tepat Dilakukan</h3>
                    <ul>
                        <li>Menggunakan hasil sebagai diagnosis kondisi psikologis atau kesehatan mental.</li>
                        <li>Mengambil keputusan besar karier semata-mata berdasarkan hasil tes tanpa konsultasi.</li>
                        <li>Menyimpulkan bahwa hasil tes bersifat mutlak atau tidak dapat berubah.</li>
                        <li>Membagikan hasil sebagai "bukti" kemampuan atau ketidakmampuan psikologis.</li>
                        <li>Menjadikan hasil sebagai dasar keputusan seleksi penerimaan, rekrutmen, atau evaluasi akademik tanpa melalui proses konseling yang komprehensif oleh tenaga ahli bersertifikat.</li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="disclaimer-section">
            <h2>3. Keterbatasan Asesmen Digital</h2>
            <p>Meskipun platform ini mengadaptasi instrumen Knowdell Card Sorts yang telah teruji, terdapat beberapa keterbatasan yang perlu dipahami:</p>
            <ul>
                <li>Hasil asesmen dipengaruhi oleh kondisi subjektif pengguna pada saat pengerjaan termasuk suasana hati, kelelahan, dan konteks sosial saat itu.</li>
                <li>Platform ini tidak dapat menangkap nuansa perilaku, ekspresi, dan respons nonverbal yang biasanya dapat diamati dalam sesi asesmen tatap muka.</li>
                <li>Hasil bukan prediksi kesuksesan karier, melainkan gambaran preferensi dan nilai-nilai yang diyakini pengguna saat ini.</li>
                <li>Setiap individu terus berkembang; hasil asesmen dapat berubah seiring waktu dan pengalaman.</li>
            </ul>
        </div>

        <div class="disclaimer-section">
            <h2>4. Peran Konselor</h2>
            <p>Konselor yang ditugaskan melalui platform ini adalah bagian dari tim Pusat Pengembangan Karier dan layanan psikologi Fakultas Psikologi UKRIDA. Mereka berperan untuk:</p>
            <ul>
                <li>Membantu interpretasi hasil asesmen secara kontekstual dan personal.</li>
                <li>Memberikan panduan perencanaan karier yang tepat berdasarkan hasil asesmen.</li>
                <li>Menjadi mitra diskusi dalam proses pengambilan keputusan karier.</li>
            </ul>
            <div class="konselor-box">
                <strong>Catatan:</strong> Jika kamu memerlukan dukungan terkait kesehatan mental, kesejahteraan psikologis, atau masalah klinis, silakan menghubungi layanan konseling psikologi UKRIDA secara langsung. Platform ini tidak dirancang untuk menangani kebutuhan tersebut.
            </div>
        </div>

        <div class="disclaimer-section">
            <h2>5. Persetujuan Pengguna</h2>
            <p>Dengan menggunakan platform ini dan mengerjakan tes yang tersedia, kamu menyatakan bahwa kamu telah membaca, memahami, dan menyetujui seluruh ketentuan dalam disclaimer ini. Kamu juga menyatakan bahwa kamu menggunakan platform ini untuk tujuan eksplorasi karier dan bukan sebagai pengganti layanan kesehatan mental profesional.</p>
        </div>

    </div>
@endsection
