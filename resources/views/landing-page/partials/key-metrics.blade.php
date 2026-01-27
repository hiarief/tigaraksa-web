<section class="key-metrics" id="key-metrics">
    <div class="key-metrics-container">
        <h2 class="section-title">🎯 6 Indikator Utama</h2>
        <p class="section-subtitle">Data prioritas untuk kebijakan dan pemberdayaan masyarakat</p>

        <div class="key-metrics-grid">
            <!-- 1. Total KK -->
            <div class="key-metric-card">
                <div class="key-metric-icon">👨‍👩‍👧‍👦</div>
                <div class="key-metric-label">Total Kepala Keluarga</div>
                <div class="key-metric-value" id="metric-total-kk">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Jumlah keseluruhan Kepala Keluarga di kecamatan</div>
            </div>

            <!-- 2. Pendapatan Rendah -->
            {{--  <div class="key-metric-card priority">  --}}
            <div class="key-metric-card">
                {{--  <span class="priority-badge">⚠️ PRIORITAS</span>  --}}
                <div class="key-metric-icon">💰</div>
                <div class="key-metric-label">KK Berpendapatan ≤ 1 Juta</div>
                <div class="key-metric-value" id="metric-pendapatan-rendah">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Keluarga yang perlu perhatian ekonomi</div>
            </div>

            <!-- 3. Lansia -->
            {{--  <div class="key-metric-card priority">  --}}
            <div class="key-metric-card">
                {{--  <span class="priority-badge">⚠️ PRIORITAS</span>  --}}
                <div class="key-metric-icon">👴</div>
                <div class="key-metric-label">KK Lansia (≥ 60 Tahun)</div>
                <div class="key-metric-value" id="metric-lansia">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Kepala Keluarga yang membutuhkan perhatian khusus</div>
            </div>

            <!-- 4. Belum Dapat Bantuan -->
            {{--  <div class="key-metric-card priority">  --}}
            <div class="key-metric-card">
                {{--  <span class="priority-badge">🔥 URGENT</span>  --}}
                <div class="key-metric-icon">🎁</div>
                <div class="key-metric-label">KK Layak Belum Dapat Bantuan</div>
                <div class="key-metric-value" id="metric-belum-bantuan">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Keluarga layak yang perlu segera dibantu</div>
            </div>

            <!-- 5. Tidak Punya BPJS -->
            {{--  <div class="key-metric-card priority">  --}}
            <div class="key-metric-card">
                {{--  <span class="priority-badge">⚠️ PRIORITAS</span>  --}}
                <div class="key-metric-icon">🏥</div>
                <div class="key-metric-label">KK Tanpa BPJS</div>
                <div class="key-metric-value" id="metric-tanpa-bpjs">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Keluarga yang belum terlindungi BPJS</div>
            </div>

            <!-- 6. Keluarga Rentan -->
            {{--  <div class="key-metric-card priority">  --}}
            <div class="key-metric-card">
                {{--  <span class="priority-badge">🔥 URGENT</span>  --}}
                <div class="key-metric-icon">⚠️</div>
                <div class="key-metric-label">Keluarga Sangat Rentan</div>
                <div class="key-metric-value" id="metric-sangat-rentan">
                    <div class="skeleton skeleton-number"></div>
                </div>
                <div class="key-metric-desc">Lansia + Miskin + Belum Dapat Bantuan</div>
            </div>
        </div>

        <!-- Insight Box -->
        <div class="insight-box" id="insightBox" style="display: none;">
            <h4>💡 Insight Data</h4>
            <p id="insightText"></p>
        </div>
    </div>
</section>
