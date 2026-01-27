 {{--  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>  --}}
 <script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
 <script>
     $(document).ready(function() {
         // ========================================
         // PROGRESSIVE LOADING STRATEGY
         // ========================================
         // Load data secara bertahap untuk performa optimal
         // Priority: High → Medium → Low

         // Track loading state
         const loadingState = {
             keyMetrics: false,
             demografi: false,
             ekonomi: false,
             bantuan: false,
             kesehatan: false,
             pendidikanPekerjaan: false,
             penduduk: false,
             desa: false
         };

         // ========================================
         // STEP 1: Load KEY METRICS (Priority: HIGH)
         // ========================================
         loadKeyMetrics();

         // ========================================
         // STEP 2: Load DEMOGRAFI KK (Priority: HIGH)
         // ========================================
         setTimeout(() => {
             loadDemografiKK();
         }, 300);

         // ========================================
         // STEP 3: Load EKONOMI (Priority: MEDIUM)
         // ========================================
         setTimeout(() => {
             loadEkonomi();
         }, 600);

         // ========================================
         // STEP 4: Load BANTUAN (Priority: MEDIUM)
         // ========================================
         setTimeout(() => {
             loadBantuan();
         }, 900);

         // ========================================
         // STEP 5: Load KESEHATAN (Priority: MEDIUM)
         // ========================================
         setTimeout(() => {
             loadKesehatan();
         }, 1200);

         // ========================================
         // STEP 6: Load PENDIDIKAN & PEKERJAAN (Priority: LOW)
         // ========================================
         setTimeout(() => {
             loadPendidikanPekerjaan();
         }, 1500);

         // ========================================
         // STEP 7: Load STATISTIK PENDUDUK (Priority: LOW)
         // ========================================
         setTimeout(() => {
             loadStatistikPenduduk();
         }, 1800);

         // ========================================
         // STEP 8: Load DATA DESA (Priority: LOW - Lazy Load)
         // ========================================
         // Load saat user scroll ke section desa
         setupLazyLoadDesa();

         // ========================================
         // LOADING FUNCTIONS
         // ========================================

         function loadKeyMetrics() {
             $.ajax({
                 url: '{{ route('api.key.metrics') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Key Metrics loaded:', data);
                     updateKeyMetrics(data);
                     showInsight(data);
                     loadingState.keyMetrics = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading key metrics:', error);
                     showError('#key-metrics', 'Gagal memuat indikator utama');
                 }
             });
         }

         function loadDemografiKK() {
             $.ajax({
                 url: '{{ route('api.demografi.kk') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Demografi KK loaded:', data);
                     updateGenderKKStats(data.gender_kk);
                     updateAgeKKStats(data.age_groups_kk);
                     loadingState.demografi = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading demografi KK:', error);
                 }
             });
         }

         function loadEkonomi() {
             $.ajax({
                 url: '{{ route('api.ekonomi') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Ekonomi loaded:', data);
                     updatePendapatanChart(data.pendapatan_kk);
                     updateRumahChart(data.kepemilikan_rumah);
                     loadingState.ekonomi = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading ekonomi:', error);
                 }
             });
         }

         function loadBantuan() {
             $.ajax({
                 url: '{{ route('api.bantuan') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Bantuan loaded:', data);
                     updateKelayakanStats(data.kelayakan_bantuan);
                     updateBantuanChart(data.jenis_bantuan);
                     loadingState.bantuan = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading bantuan:', error);
                 }
             });
         }

         function loadKesehatan() {
             $.ajax({
                 url: '{{ route('api.kesehatan') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Kesehatan loaded:', data);
                     updateJenisBPJSChart(data.jenis_bpjs);
                     updateSakitKronisChart(data.sakit_kronis);
                     loadingState.kesehatan = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading kesehatan:', error);
                 }
             });
         }

         function loadPendidikanPekerjaan() {
             $.ajax({
                 url: '{{ route('api.pendidikan.pekerjaan') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Pendidikan & Pekerjaan loaded:', data);
                     updatePendidikanChart(data.pendidikan_kk);
                     updatePekerjaanChart(data.pekerjaan_kk);
                     loadingState.pendidikanPekerjaan = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading pendidikan & pekerjaan:', error);
                 }
             });
         }

         function loadStatistikPenduduk() {
             $.ajax({
                 url: '{{ route('api.statistik.penduduk') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Statistik Penduduk loaded:', data);
                     updateGenderStats(data.gender);
                     updateAgeStats(data.age);
                     updateAgamaChart(data.agama);
                     loadingState.penduduk = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading statistik penduduk:', error);
                 }
             });
         }

         function loadDataDesa() {
             if (loadingState.desa) return; // Already loaded

             $('#villagesGrid').html(
                 '<div class="loading-indicator"><div class="spinner"></div><p>Memuat data desa...</p></div>'
             );

             $.ajax({
                 url: '{{ route('api.data.desa') }}',
                 method: 'GET',
                 dataType: 'json',
                 success: function(data) {
                     //console.log('✅ Data Desa loaded:', data);
                     updateVillages(data.desa);
                     loadingState.desa = true;
                 },
                 error: function(xhr, status, error) {
                     //console.error('❌ Error loading data desa:', error);
                     $('#villagesGrid').html(
                         '<p style="text-align: center; color: #f44336;">Gagal memuat data desa</p>'
                     );
                 }
             });
         }

         // ========================================
         // LAZY LOAD SETUP FOR DESA
         // ========================================
         function setupLazyLoadDesa() {
             const observer = new IntersectionObserver((entries) => {
                 entries.forEach(entry => {
                     if (entry.isIntersecting && !loadingState.desa) {
                         loadDataDesa();
                         observer.disconnect(); // Load only once
                     }
                 });
             }, {
                 rootMargin: '200px' // Load saat 200px sebelum terlihat
             });

             const desaSection = document.querySelector('#villages');
             if (desaSection) {
                 observer.observe(desaSection);
             }
         }

         // ========================================
         // UPDATE FUNCTIONS
         // ========================================

         function updateKeyMetrics(data) {
             // 1. Total KK
             $('#metric-total-kk').html(formatNumber(data.total_kk) +
                 '<small style="font-size: 1rem; color: #666;"> KK</small>');

             // 2. Pendapatan Rendah
             const persenRendah = data.persentase_pendapatan_rendah;
             $('#metric-pendapatan-rendah').html(
                 persenRendah + '<small style="font-size: 1.2rem;">%</small>' +
                 '<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">' +
                 formatNumber(data.pendapatan_rendah) + ' keluarga</div>'
             );

             // 3. Lansia
             const persenLansia = data.persentase_lansia;
             $('#metric-lansia').html(
                 persenLansia + '<small style="font-size: 1.2rem;">%</small>' +
                 '<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">' +
                 formatNumber(data.jumlah_lansia) + ' kepala keluarga</div>'
             );

             // 4. Belum Dapat Bantuan
             const persenBelumBantuan = data.persentase_layak_belum_dapat;
             $('#metric-belum-bantuan').html(
                 persenBelumBantuan + '<small style="font-size: 1.2rem;">%</small>' +
                 '<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">' +
                 formatNumber(data.layak_belum_dapat) + ' keluarga</div>'
             );

             // 5. Tanpa BPJS
             const persenTanpaBPJS = data.persentase_tidak_bpjs;
             $('#metric-tanpa-bpjs').html(
                 persenTanpaBPJS + '<small style="font-size: 1.2rem;">%</small>' +
                 '<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">' +
                 formatNumber(data.tidak_punya_bpjs) + ' keluarga</div>'
             );

             // 6. Keluarga Sangat Rentan
             $('#metric-sangat-rentan').html(
                 formatNumber(data.keluarga_sangat_rentan) +
                 '<small style="font-size: 1rem; color: #666;"> KK</small>' +
                 '<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">Perlu perhatian segera</div>'
             );
         }

         function showInsight(data) {
             const insights = [];

             if (data.persentase_pendapatan_rendah > 30) {
                 insights.push(
                     `<strong>${data.persentase_pendapatan_rendah}%</strong> keluarga berpendapatan ≤ 1 juta/bulan`
                 );
             }

             if (data.lansia_belum_bantuan > 0) {
                 insights.push(
                     `<strong>${formatNumber(data.lansia_belum_bantuan)}</strong> kepala keluarga lansia belum pernah menerima bantuan pemerintah`
                 );
             }

             if (data.keluarga_sangat_rentan > 0) {
                 insights.push(
                     `<strong>${formatNumber(data.keluarga_sangat_rentan)}</strong> keluarga masuk kategori sangat rentan (lansia + miskin + belum dapat bantuan)`
                 );
             }

             if (insights.length > 0) {
                 $('#insightText').html(insights.join('. ') + '.');
                 $('#insightBox').fadeIn();
             }
         }

         function updateGenderKKStats(gender) {
             const total = (gender.laki_laki || 0) + (gender.perempuan || 0);
             const lakiPersen = total > 0 ? ((gender.laki_laki || 0) / total * 100).toFixed(1) : 0;
             const perempuanPersen = total > 0 ? ((gender.perempuan || 0) / total * 100).toFixed(1) : 0;

             $('#genderKKStats').html(`
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #2196F3;">${formatNumber(gender.laki_laki || 0)}</div>
                    <div class="stat-value-label">👨 Laki-laki (${lakiPersen}%)</div>
                </div>
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #E91E63;">${formatNumber(gender.perempuan || 0)}</div>
                    <div class="stat-value-label">👩 Perempuan (${perempuanPersen}%)</div>
                </div>
            `);
         }

         function updateAgeKKStats(age) {
             $('#ageKKStats').html(`
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; width: 100%;">
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #4CAF50;">${formatNumber(age.muda)}</div>
                        <div class="stat-value-label">👨 Muda (&lt;25)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #2196F3;">${formatNumber(age.produktif)}</div>
                        <div class="stat-value-label">💼 Produktif (25-44)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #FF9800;">${formatNumber(age.pra_lansia)}</div>
                        <div class="stat-value-label">👴 Pra-Lansia (45-59)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #f44336;">${formatNumber(age.lansia)}</div>
                        <div class="stat-value-label">👴 Lansia (≥60)</div>
                    </div>
                </div>
            `);
         }

         function updatePendapatanChart(data) {
             updateBarChart('#pendapatanChart', data, {
                 colorGradient: true,
                 colors: ['#f44336', '#FF9800', '#FFC107', '#4CAF50']
             });
         }

         function updateKelayakanStats(kelayakan) {
             const layak = kelayakan.layak || 0;
             const tidakLayak = kelayakan['tidak layak'] || 0;
             const total = layak + tidakLayak;
             const layakPersen = total > 0 ? ((layak / total) * 100).toFixed(1) : 0;

             $('#kelayakanStats').html(`
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #4CAF50;">${formatNumber(layak)}</div>
                    <div class="stat-value-label">✅ Layak (${layakPersen}%)</div>
                </div>
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #999;">${formatNumber(tidakLayak)}</div>
                    <div class="stat-value-label">➖ Tidak Layak</div>
                </div>
            `);
         }

         function updateBantuanChart(data) {
             const filteredData = data.filter(item => item.nama !== 'Belum Pernah Dapat Bantuan');
             updateBarChart('#bantuanChart', filteredData);
         }

         function updateJenisBPJSChart(data) {
             const mappedData = data.map(item => {
                 let nama = item.jenis_bpjs;
                 if (nama === 'bpjs_kesehatan') nama = 'BPJS Kesehatan';
                 else if (nama === 'bpjs_ketenagakerjaan') nama = 'BPJS Ketenagakerjaan';
                 else if (nama === 'memiliki_kedua_bpjs') nama = 'Memiliki Keduanya';
                 return {
                     nama: nama,
                     total: item.total
                 };
             });
             updateBarChart('#jenisBPJSChart', mappedData);
         }

         function updateSakitKronisChart(data) {
             updateBarChart('#sakitKronisChart', data);
         }

         function updatePendidikanChart(data) {
             updateBarChart('#pendidikanChart', data);
         }

         function updatePekerjaanChart(data) {
             updateBarChart('#pekerjaanChart', data);
         }

         function updateRumahChart(data) {
             updateBarChart('#rumahChart', data);
         }

         function updateGenderStats(gender) {
             const total = (gender.laki_laki || 0) + (gender.perempuan || 0);
             const lakiPersen = total > 0 ? ((gender.laki_laki || 0) / total * 100).toFixed(1) : 0;
             const perempuanPersen = total > 0 ? ((gender.perempuan || 0) / total * 100).toFixed(1) : 0;

             $('#genderStats').html(`
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #2196F3;">${formatNumber(gender.laki_laki || 0)}</div>
                    <div class="stat-value-label">👨 Laki-laki (${lakiPersen}%)</div>
                </div>
                <div class="stat-value">
                    <div class="stat-value-number" style="color: #E91E63;">${formatNumber(gender.perempuan || 0)}</div>
                    <div class="stat-value-label">👩 Perempuan (${perempuanPersen}%)</div>
                </div>
            `);
         }

         function updateAgeStats(age) {
             $('#ageStats').html(`
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; width: 100%;">
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #FF9800;">${formatNumber(age.balita)}</div>
                        <div class="stat-value-label">👶 Balita (0-4)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #9C27B0;">${formatNumber(age.anak)}</div>
                        <div class="stat-value-label">🧒 Anak (5-17)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #4CAF50;">${formatNumber(age.dewasa)}</div>
                        <div class="stat-value-label">👨 Dewasa (18-59)</div>
                    </div>
                    <div class="stat-value">
                        <div class="stat-value-number" style="color: #795548;">${formatNumber(age.lansia)}</div>
                        <div class="stat-value-label">👴 Lansia (60+)</div>
                    </div>
                </div>
            `);
         }

         function updateAgamaChart(data) {
             updateBarChart('#agamaChart', data);
         }

         function updateBarChart(selector, data, options = {}) {
             if (!data || data.length === 0) {
                 $(selector).html('<p style="text-align: center; color: #999;">Data tidak tersedia</p>');
                 return;
             }

             const maxValue = Math.max(...data.map(item => item.total));
             let html = '<div class="bar-chart">';

             data.forEach((item, index) => {
                 const percentage = (item.total / maxValue * 100);
                 let barColor = 'linear-gradient(90deg, #4CAF50, #2c5f2d)';

                 if (options.colorGradient && options.colors) {
                     const colorIndex = Math.min(index, options.colors.length - 1);
                     barColor = options.colors[colorIndex];
                 }

                 html += `
                    <div class="bar-item">
                        <div class="bar-label">${item.nama}</div>
                        <div class="bar-wrapper">
                            <div class="bar-fill" style="width: ${percentage}%; background: ${barColor}">
                                ${formatNumber(item.total)}
                            </div>
                        </div>
                    </div>
                `;
             });

             html += '</div>';
             $(selector).html(html);
         }

         function updateVillages(villages) {
             let html = '';
             const icon = '🏘️';

             villages.forEach((village, index) => {
                 html += `
                        <div class="village-card" style="animation: fadeInUp 0.6s ease ${index * 0.1}s backwards;">
                            <div class="village-icon">${icon}</div>
                            <h3 class="village-name">${village.nama_desa}</h3>
                            <div class="village-stats">
                                <div class="village-stat">
                                    <div class="village-stat-number">${formatNumber(village.jumlah_penduduk)}</div>
                                    <div class="village-stat-label">Warga</div>
                                </div>
                                <div class="village-stat">
                                    <div class="village-stat-number">${formatNumber(village.jumlah_kk)}</div>
                                    <div class="village-stat-label">KK</div>
                                </div>
                            </div>
                        </div>
                        `;
             });

             $('#villagesGrid').html(html);
         }


         function formatNumber(num) {
             return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
         }

         function showError(selector, message) {
             $(selector).html(`<p style="text-align: center; color: #f44336; padding: 2rem;">${message}</p>`);
         }

         // ========================================
         // UI ENHANCEMENTS
         // ========================================

         // Smooth scrolling
         $('a[href^="#"]').on('click', function(e) {
             e.preventDefault();
             const target = $(this.getAttribute('href'));
             if (target.length) {
                 $('html, body').stop().animate({
                     scrollTop: target.offset().top - 80
                 }, 1000);
             }
         });

         // Header scroll effect
         $(window).on('scroll', function() {
             if ($(this).scrollTop() > 50) {
                 $('header').css('box-shadow', '0 2px 30px rgba(0,0,0,0.15)');
             } else {
                 $('header').css('box-shadow', '0 2px 20px rgba(0,0,0,0.1)');
             }
         });

         // Console log performance
         //console.log('🚀 Progressive loading initialized');
         //console.log(
         //    '📊 Loading sequence: Key Metrics → Demografi → Ekonomi → Bantuan → Kesehatan → Pendidikan → Penduduk → Desa (lazy)'
         //);
     });
 </script>
