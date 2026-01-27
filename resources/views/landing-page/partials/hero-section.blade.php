<section class="hero" id="home">
    <div class="hero-content">
        <h1>DesaBisa</h1>
        <div class="tagline">KEMBALI KE DESA</div>
        <p>Sistem Informasi Pendataan Warga Desa Terintegrasi<br>Mengelola data kependudukan dengan mudah dan
            efisien</p>

        <div class="stats">
            <div class="stat-item">
                <div class="stat-number" id="desaCount">{{ $totalDesa }}</div>
                <div class="stat-label">Desa Terdaftar</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="wargaCount">{{ number_format($nik) }}</div>
                <div class="stat-label">Total Warga</div>
            </div>
            <div class="stat-item">
                <div class="stat-number" id="kkCount">{{ number_format($kk) }}</div>
                <div class="stat-label">Kepala Keluarga</div>
            </div>
        </div>
    </div>
</section>
