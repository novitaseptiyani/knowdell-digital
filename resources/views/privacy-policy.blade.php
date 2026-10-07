@extends('layouts.landing')

@section('title', 'Kebijakan Privasi — Knowdell Digital')

@section('content')
    <div class="policy-wrapper">

        <span class="policy-badge">KEBIJAKAN PRIVASI</span>

        <h1>Kebijakan Privasi &amp; Perlindungan Data</h1>
        <p class="policy-meta">Terakhir diperbarui: {{ date('d F Y') }} &bull; Berlaku untuk seluruh pengguna platform Knowdell Card Sorts Digital</p>

        <div class="policy-section">
            <h2>1. Pendahuluan</h2>
            <p>Platform Knowdell Card Sorts Digital dikelola oleh Fakultas Psikologi Universitas Kristen Krida Wacana (UKRIDA). Kami berkomitmen untuk melindungi privasi dan keamanan data seluruh pengguna, khususnya mengingat platform ini mengelola data psikologis yang bersifat sensitif dan personal.</p>

            <p>Kebijakan ini menjelaskan jenis data yang kami kumpulkan, bagaimana data tersebut digunakan, siapa yang dapat mengaksesnya, serta hak-hak yang kamu miliki atas datamu. Dengan menggunakan platform ini, kamu dianggap telah membaca dan menyetujui kebijakan ini.</p>
        </div>

        <div class="policy-section">
            <h2>2. Data yang Kami Kumpulkan</h2>
            <p>Kami mengumpulkan data berikut dalam rangka pelaksanaan asesmen dan layanan konseling:</p>
            <ul>
                <li><strong>Data Identitas:</strong> Nama lengkap, tanggal lahir, alamat email, nomor ponsel, jenis kelamin, status dan instansi.</li>
                <li><strong>Data Asesmen:</strong> Jawaban dan hasil sortiran kartu dari setiap instrumen yang kamu kerjakan.</li>
                <li><strong>Data Interaksi:</strong> Waktu pengerjaan tes, status penyelesaian, dan riwayat akses.</li>
                <li><strong>Catatan Konselor:</strong> Annotasi dan catatan yang ditambahkan oleh konselor yang ditugaskan kepadamu.</li>
            </ul>
            <div class="highlight-box">
                <strong>Catatan penting:</strong> Kami tidak mengumpulkan informasi pembayaran, nomor identitas nasional (KTP/SIM), atau data lokasi secara real-time.
            </div>
        </div>

        <div class="policy-section">
            <h2>3. Tujuan Penggunaan Data</h2>
            <p>Data yang dikumpulkan digunakan semata-mata untuk:</p>
            <ul>
                <li>Memfasilitasi pelaksanaan asesmen karier berbasis Knowdell Card Sorts.</li>
                <li>Memungkinkan konselor memantau perkembangan dan memberikan catatan pada hasil tesmu.</li>
                <li>Menghasilkan laporan hasil asesmen yang dapat diunduh dan dibawa ke sesi konseling.</li>
                <li>Keperluan administrasi akademik dan pelaporan internal Fakultas Psikologi UKRIDA.</li>
                <li>Pengembangan dan peningkatan kualitas platform secara berkelanjutan.</li>
            </ul>
        </div>

        <div class="policy-section">
            <h2>4. Siapa yang Dapat Mengakses Datamu?</h2>
            <ul>
                <li><strong>Kamu sendiri:</strong> kamu dapat mengakses dan mengunduh seluruh hasil tesmu kapan saja melalui dashboard.</li>
                <li><strong>Konselor yang ditugaskan:</strong> hanya konselor yang secara resmi ditugaskan kepadamu yang dapat melihat dan memberikan catatan pada hasil tesmu.</li>
                <li><strong>Administrator platform:</strong> pengelola teknis platform hanya mengakses data untuk keperluan pemeliharaan sistem, bukan untuk keperluan asesmen.</li>
            </ul>
            <div class="highlight-box">
                <strong>Data asesmen kamu tidak akan dibagikan kepada pihak ketiga di luar UKRIDA</strong>
                tanpa persetujuan eksplisit darimu, kecuali diwajibkan oleh peraturan perundang-undangan yang berlaku.
            </div>
        </div>

        <div class="policy-section">
            <h2>5. Penyimpanan &amp; Keamanan Data</h2>
            <p>Data disimpan pada server yang dikelola secara internal oleh tim teknologi informasi UKRIDA dan dilindungi dengan enkripsi standar industri. Kami menerapkan kontrol akses berbasis peran (<em>role-based access control</em>) untuk memastikan hanya pihak berwenang yang dapat mengakses data tertentu.</p>

            <p>Data hasil asesmen disimpan selama masa studi aktif pengguna di UKRIDA dan dapat dihapus atas permintaan pengguna setelah masa studi berakhir, sesuai dengan kebijakan retensi data institusi.</p>
        </div>

        <div class="policy-section">
            <h2>6. Hak-hak Pengguna</h2>
            <p>Sesuai dengan prinsip perlindungan data dan regulasi yang berlaku, kamu memiliki hak untuk:</p>
            <ul>
                <li>Mengakses seluruh data pribadimu yang tersimpan di platform ini.</li>
                <li>Meminta koreksi atas data yang tidak akurat.</li>
                <li>Meminta penghapusan datamu setelah masa studi berakhir.</li>
                <li>Mengunduh hasil tesmu dalam format PDF kapan saja.</li>
                <li>Mengajukan keberatan atas pemrosesan datamu.</li>
            </ul>
            <p>Untuk menggunakan hak-hak di atas, hubungi kami melalui kontak yang tersedia di bawah.</p>
        </div>

        <div class="policy-section">
            <h2>7. Hubungi Kami</h2>
            <p>Jika kamu memiliki pertanyaan, keberatan, atau permintaan terkait kebijakan privasi dan data pribadimu, silakan hubungi:</p>
            <div class="contact-box">
                <p><strong>Fakultas Psikologi, Universitas Kristen Krida Wacana</strong></p>
                <p><i class="fas fa-map-marker-alt" style="color: #2563eb; margin-right: 6px;"></i>
                   Jl. Tanjung Duren Raya No.4, Grogol Petamburan, Jakarta Barat 11470</p>
                <p><i class="fab fa-instagram" style="color: #2563eb; margin-right: 6px;"></i>
                   <a href="https://instagram.com/psi.ukrida" target="_blank" style="color: #2563eb;">@psi.ukrida</a> &bull;
                   <a href="https://instagram.com/ccdaukrida" target="_blank" style="color: #2563eb;">@ccdaukrida</a>
                </p>
            </div>
        </div>

    </div>
@endsection
