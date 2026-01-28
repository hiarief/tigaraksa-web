<script src="{{ asset('assets/plugins/jquery/jquery.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // ========================================
        // CONFIGURATION
        // ========================================
        const CONFIG = {
            enableCache: true,
            cacheExpiry: 7200000, // 2 hours in milliseconds
            maxRetries: 3,
            retryDelay: 1000,
            loadingDelay: {
                keyMetrics: 0,
                demografi: 150,
                ekonomi: 300,
                bantuan: 450,
                kesehatan: 600,
                pendidikanPekerjaan: 750,
                penduduk: 900,
                desa: 1050
            }
        };

        // ========================================
        // CACHE MANAGER
        // ========================================
        const CacheManager = {
            set(key, data) {
                if (!CONFIG.enableCache) return;
                const item = {
                    data: data,
                    timestamp: Date.now()
                };
                try {
                    localStorage.setItem(`lp_cache_${key}`, JSON.stringify(item));
                } catch (e) {
                    // console.warn('Cache storage failed:', e);
                }
            },

            get(key) {
                if (!CONFIG.enableCache) return null;
                try {
                    const item = localStorage.getItem(`lp_cache_${key}`);
                    if (!item) return null;

                    const parsed = JSON.parse(item);
                    const age = Date.now() - parsed.timestamp;

                    if (age > CONFIG.cacheExpiry) {
                        this.remove(key);
                        return null;
                    }

                    return parsed.data;
                } catch (e) {
                    //console.warn('Cache retrieval failed:', e);
                    return null;
                }
            },

            remove(key) {
                try {
                    localStorage.removeItem(`lp_cache_${key}`);
                } catch (e) {
                    // console.warn('Cache removal failed:', e);
                }
            },

            clear() {
                try {
                    Object.keys(localStorage).forEach(key => {
                        if (key.startsWith('lp_cache_')) {
                            localStorage.removeItem(key);
                        }
                    });
                } catch (e) {
                    //console.warn('Cache clear failed:', e);
                }
            }
        };

        // ========================================
        // REQUEST MANAGER WITH AUTO-CANCEL
        // ========================================
        const RequestManager = {
            activeRequests: new Map(),
            isNavigating: false,

            makeRequest(url, options = {}) {
                // Cancel jika sedang navigasi
                if (this.isNavigating) {
                    //console.log('⚠️ Skipping request - navigating away');
                    return Promise.reject('Navigation in progress');
                }

                // Check cache first
                const cacheKey = options.cacheKey || url;
                const cached = CacheManager.get(cacheKey);
                if (cached) {
                    //console.log('✅ Using cached data for:', cacheKey);
                    return Promise.resolve(cached);
                }

                // Cancel previous request untuk URL yang sama
                if (this.activeRequests.has(url)) {
                    this.activeRequests.get(url).abort();
                }

                return new Promise((resolve, reject) => {
                    const xhr = $.ajax({
                        url: url,
                        method: 'GET',
                        dataType: 'json',
                        timeout: 30000,
                        cache: true, // Enable browser cache
                        beforeSend: function(jqXHR) {
                            RequestManager.activeRequests.set(url, jqXHR);
                        },
                        success: function(data) {
                            // Save to cache
                            CacheManager.set(cacheKey, data);
                            resolve(data);
                        },
                        error: function(xhr, status, error) {
                            if (status === 'abort') {
                                //console.log('✅ Request cancelled:', url);
                                reject('aborted');
                            } else {
                                //console.error('❌ Request failed:', url, error);
                                reject(error);
                            }
                        },
                        complete: function() {
                            RequestManager.activeRequests.delete(url);
                        }
                    });
                });
            },

            cancelAll() {
                //console.log('🛑 Cancelling', this.activeRequests.size, 'active requests');
                this.activeRequests.forEach(xhr => {
                    if (xhr && xhr.abort) {
                        xhr.abort();
                    }
                });
                this.activeRequests.clear();
            }
        };

        // ========================================
        // NAVIGATION HANDLERS
        // ========================================
        $(document).on('click', 'a:not([href^="#"]), button[type="submit"], .btn-login, .login-btn', function(
            e) {
            RequestManager.isNavigating = true;
            RequestManager.cancelAll();
        });

        $(window).on('beforeunload', function() {
            RequestManager.isNavigating = true;
            RequestManager.cancelAll();
        });

        // ========================================
        // LOADING STATE
        // ========================================
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
        // PROGRESSIVE LOADING WITH DELAYS
        // ========================================
        function startProgressiveLoad() {
            const tasks = [{
                    fn: loadKeyMetrics,
                    delay: CONFIG.loadingDelay.keyMetrics
                },
                {
                    fn: loadDemografiKK,
                    delay: CONFIG.loadingDelay.demografi
                },
                {
                    fn: loadEkonomi,
                    delay: CONFIG.loadingDelay.ekonomi
                },
                {
                    fn: loadBantuan,
                    delay: CONFIG.loadingDelay.bantuan
                },
                {
                    fn: loadKesehatan,
                    delay: CONFIG.loadingDelay.kesehatan
                },
                {
                    fn: loadPendidikanPekerjaan,
                    delay: CONFIG.loadingDelay.pendidikanPekerjaan
                },
                {
                    fn: loadStatistikPenduduk,
                    delay: CONFIG.loadingDelay.penduduk
                }
            ];

            tasks.forEach(task => {
                setTimeout(task.fn, task.delay);
            });

            // Desa pakai lazy load
            setupLazyLoadDesa();
        }

        // ========================================
        // LOAD FUNCTIONS
        // ========================================
        function loadKeyMetrics() {
            RequestManager.makeRequest('{{ route('api.key.metrics') }}', {
                    cacheKey: 'key_metrics'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateKeyMetrics(data);
                    showInsight(data);
                    loadingState.keyMetrics = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#key-metrics', 'Gagal memuat indikator utama');
                    }
                });
        }

        function loadDemografiKK() {
            RequestManager.makeRequest('{{ route('api.demografi.kk') }}', {
                    cacheKey: 'demografi_kk'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateGenderKKStats(data.gender_kk);
                    updateAgeKKStats(data.age_groups_kk);
                    loadingState.demografi = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#demografi-section', 'Gagal memuat demografi');
                    }
                });
        }

        function loadEkonomi() {
            RequestManager.makeRequest('{{ route('api.ekonomi') }}', {
                    cacheKey: 'ekonomi'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updatePendapatanChart(data.pendapatan_kk);
                    updateRumahChart(data.kepemilikan_rumah);
                    loadingState.ekonomi = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#ekonomi-section', 'Gagal memuat data ekonomi');
                    }
                });
        }

        function loadBantuan() {
            RequestManager.makeRequest('{{ route('api.bantuan') }}', {
                    cacheKey: 'bantuan'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateKelayakanStats(data.kelayakan_bantuan);
                    updateBantuanChart(data.jenis_bantuan);
                    loadingState.bantuan = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#bantuan-section', 'Gagal memuat data bantuan');
                    }
                });
        }

        function loadKesehatan() {
            RequestManager.makeRequest('{{ route('api.kesehatan') }}', {
                    cacheKey: 'kesehatan'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateJenisBPJSChart(data.jenis_bpjs);
                    updateSakitKronisChart(data.sakit_kronis);
                    loadingState.kesehatan = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#kesehatan-section', 'Gagal memuat data kesehatan');
                    }
                });
        }

        function loadPendidikanPekerjaan() {
            RequestManager.makeRequest('{{ route('api.pendidikan.pekerjaan') }}', {
                    cacheKey: 'pendidikan_pekerjaan'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updatePendidikanChart(data.pendidikan_kk);
                    updatePekerjaanChart(data.pekerjaan_kk);
                    loadingState.pendidikanPekerjaan = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#pendidikan-section', 'Gagal memuat data pendidikan');
                    }
                });
        }

        function loadStatistikPenduduk() {
            RequestManager.makeRequest('{{ route('api.statistik.penduduk') }}', {
                    cacheKey: 'statistik_penduduk'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateGenderStats(data.gender);
                    updateAgeStats(data.age);
                    updateAgamaChart(data.agama);
                    loadingState.penduduk = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        showError('#penduduk-section', 'Gagal memuat statistik penduduk');
                    }
                });
        }

        function loadDataDesa() {
            if (loadingState.desa || RequestManager.isNavigating) return;

            $('#villagesGrid').html(
                '<div class="loading-indicator"><div class="spinner"></div><p>Memuat data desa...</p></div>'
            );

            RequestManager.makeRequest('{{ route('api.data.desa') }}', {
                    cacheKey: 'data_desa'
                })
                .then(data => {
                    if (RequestManager.isNavigating) return;
                    updateVillages(data.desa);
                    loadingState.desa = true;
                })
                .catch(error => {
                    if (error !== 'aborted') {
                        $('#villagesGrid').html(
                            '<p style="text-align: center; color: #f44336;">Gagal memuat data desa</p>'
                        );
                    }
                });
        }

        // ========================================
        // LAZY LOAD DESA
        // ========================================
        function setupLazyLoadDesa() {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting && !loadingState.desa && !RequestManager
                        .isNavigating) {
                        loadDataDesa();
                        observer.disconnect();
                    }
                });
            }, {
                rootMargin: '300px'
            });

            const desaSection = document.querySelector('#villages');
            if (desaSection) {
                observer.observe(desaSection);
            }
        }

        // ========================================
        // UPDATE FUNCTIONS (Sama seperti sebelumnya)
        // ========================================
        function updateKeyMetrics(data) {
            $('#metric-total-kk').html(formatNumber(data.total_kk) +
                '<small style="font-size: 1rem; color: #666;"> KK</small>');

            const persenRendah = data.persentase_pendapatan_rendah;
            $('#metric-pendapatan-rendah').html(
                `${persenRendah}<small style="font-size: 1.2rem;">%</small>` +
                `<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">${formatNumber(data.pendapatan_rendah)} keluarga</div>`
            );

            const persenLansia = data.persentase_lansia;
            $('#metric-lansia').html(
                `${persenLansia}<small style="font-size: 1.2rem;">%</small>` +
                `<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">${formatNumber(data.jumlah_lansia)} kepala keluarga</div>`
            );

            const persenBelumBantuan = data.persentase_layak_belum_dapat;
            $('#metric-belum-bantuan').html(
                `${persenBelumBantuan}<small style="font-size: 1.2rem;">%</small>` +
                `<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">${formatNumber(data.layak_belum_dapat)} keluarga</div>`
            );

            const persenTanpaBPJS = data.persentase_tidak_bpjs;
            $('#metric-tanpa-bpjs').html(
                `${persenTanpaBPJS}<small style="font-size: 1.2rem;">%</small>` +
                `<div style="font-size: 0.9rem; color: #666; margin-top: 0.5rem;">${formatNumber(data.tidak_punya_bpjs)} keluarga</div>`
            );

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
        $('a[href^="#"]').on('click', function(e) {
            e.preventDefault();
            const target = $(this.getAttribute('href'));
            if (target.length) {
                $('html, body').stop().animate({
                    scrollTop: target.offset().top - 80
                }, 1000);
            }
        });

        let scrollTimeout;
        $(window).on('scroll', function() {
            clearTimeout(scrollTimeout);
            scrollTimeout = setTimeout(function() {
                if ($(window).scrollTop() > 50) {
                    $('header').css('box-shadow', '0 2px 30px rgba(0,0,0,0.15)');
                } else {
                    $('header').css('box-shadow', '0 2px 20px rgba(0,0,0,0.1)');
                }
            }, 10);
        });

        // ========================================
        // CLEAR CACHE BUTTON (untuk development)
        // ========================================
        window.clearLandingPageCache = function() {
            CacheManager.clear();
            //console.log('✅ Cache cleared!');
            location.reload();
        };

        // ========================================
        // START LOADING
        // ========================================
        //console.log('🚀 Optimized progressive loading initialized');
        startProgressiveLoad();
    });
</script>
