<footer class="footer">

    {{-- 3 kolom utama --}}
    <div class="footer-top">
        <div class="footer-column">
            <a href="/" class="footer-logo-link logo">
                <div class="logo-icon">K</div>
                <span>KNOWDELL CARD SORTS<span class="footer-brand-accent"> DIGITAL</span></span>
            </a>
            <p class="footer-desc">
                Kegiatan penilaian ini merupakan adaptasi dari metode Knowdell Card Sorts ke dalam
                bentuk platform digital agar dapat diakses dengan lebih mudah kapan saja dan di mana saja.
                Digitalisasi ini diharapkan dapat membantu serta mempermudah proses pelaksanaan konseling
                karier secara lebih efektif dan efisien.
            </p>
        </div>

        <div class="footer-column">
            <h4>Alamat Kami</h4>
            <div class="contact-item">
                <i class="fas fa-map-marker-alt"></i>
                <p>Jl. Tanjung Duren Raya No.4, RT.12/RW.2, Tj. Duren Utara,
                   Kec. Grogol Petamburan, Kota Jakarta Barat, DKI Jakarta 11470</p>
            </div>
        </div>

        <div class="footer-column">
            <h4>Ikuti Kami</h4>
            <ul>
                <li>
                    <a href="https://www.instagram.com/ccdaukrida" target="_blank" class="footer-link">
                        <i class="fab fa-instagram"></i> @ccdaukrida
                    </a>
                </li>
                <li>
                    <a href="https://instagram.com/psi.ukrida" target="_blank" class="footer-link">
                        <i class="fab fa-instagram"></i> @psi.ukrida
                    </a>
                </li>
                <li>
                    <a href="https://instagram.com/kampusukrida" target="_blank" class="footer-link">
                        <i class="fab fa-instagram"></i> @kampusukrida
                    </a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Link legal + copyright --}}
    <div class="footer-bottom">
        <div class="footer-legal-links">
            <a href="{{ route('about') }}" class="footer-link footer-legal-link">
                <i class="fas fa-info-circle"></i> Tentang Platform &amp; Metode
            </a>
            <a href="{{ route('privacy-policy') }}" class="footer-link footer-legal-link">
                <i class="fas fa-shield-alt"></i> Kebijakan Privasi &amp; Data
            </a>
            <a href="{{ route('disclaimer') }}" class="footer-link footer-legal-link">
                <i class="fas fa-circle-exclamation"></i> Disclaimer
            </a>
            <a href="{{ route('faq') }}" class="footer-link footer-legal-link">
                <i class="fas fa-circle-question"></i> FAQ
            </a>
        </div>
        <div class="footer-copyright-bar">
            <p>&copy; {{ date('Y') }} PSIKOLOGI UNIVERSITAS KRISTEN KRIDA WACANA. ALL RIGHTS RESERVED.</p>
        </div>
    </div>

</footer>
