<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PendapatanKecamatanController extends Controller
{
    // Cache TTL (Time To Live) - 2 jam
    private const CACHE_TTL = 7200;

    // Mapping pendapatan untuk sorting
    private $pendapatanOrder = [
        '0-1 Juta' => 1,
        '1-2 Juta' => 2,
        '2-3 Juta' => 3,
        '3-5 Juta' => 4,
        '5-10 Juta' => 5,
        '10-20 Juta' => 6,
        '20-50 Juta' => 7,
        '50-100 Juta' => 8,
        '>100 Juta' => 9
    ];

    // Kategori umur
    private $kategoriUmur = [
        '0-17' => [0, 17],
        '18-25' => [18, 25],
        '26-35' => [26, 35],
        '36-45' => [36, 45],
        '46-55' => [46, 55],
        '56-65' => [56, 65],
        '>65' => [66, 999]
    ];

    public function index(Request $request)
    {
        return view('admin.chart.pendapatan.kecamatan');
    }

    /**
     * Get base query untuk data penduduk
     */
    private function getBaseQuery()
    {
        return DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
            ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                't1.pendapatan_perbulan',
                't5.nama as jenis_pekerjaan',
                't4.nama as hubungan_keluarga',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't2.desa as kode_desa'
            ]);
    }

    /**
     * 1. Statistik Jumlah - Overview angka-angka penting
     */
    public function getStatistikJumlah()
    {
        try {
            // Tambah cache, tapi TETAP pakai logika original
            $data = Cache::remember('pendapatan_statistik_jumlah', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $stats = [
                    'total_penduduk' => $data->count(),
                    'total_laki' => $data->where('jenkel', 1)->count(),
                    'total_perempuan' => $data->where('jenkel', 2)->count(),
                    'total_kepala_keluarga' => $data->where('hubungan_keluarga', 'KEPALA KELUARGA')->count(),
                    'total_pekerja' => $data->filter(function($item) {
                        return !empty($item->jenis_pekerjaan) &&
                               !in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                    })->count(),
                    'total_tidak_bekerja' => $data->filter(function($item) {
                        return empty($item->jenis_pekerjaan) ||
                               in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                    })->count(),
                ];

                // Hitung pendapatan berdasarkan kategori
                $pendapatanKategori = $data->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->groupBy('pendapatan_perbulan');

                $stats['pendapatan_0_1'] = $pendapatanKategori->get('0-1 Juta')->count() ?? 0;
                $stats['pendapatan_1_2'] = $pendapatanKategori->get('1-2 Juta')->count() ?? 0;
                $stats['pendapatan_2_3'] = $pendapatanKategori->get('2-3 Juta')->count() ?? 0;
                $stats['pendapatan_3_5'] = $pendapatanKategori->get('3-5 Juta')->count() ?? 0;
                $stats['pendapatan_5_10'] = $pendapatanKategori->get('5-10 Juta')->count() ?? 0;
                $stats['pendapatan_10_plus'] =
                    ($pendapatanKategori->get('10-20 Juta')->count() ?? 0) +
                    ($pendapatanKategori->get('20-50 Juta')->count() ?? 0) +
                    ($pendapatanKategori->get('50-100 Juta')->count() ?? 0) +
                    ($pendapatanKategori->get('>100 Juta')->count() ?? 0);

                return $stats;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 2. Statistik Rasio - Persentase dan ratio
     */
    public function getStatistikRasio()
    {
        try {
            // Tambah cache, tapi TETAP pakai logika original
            $data = Cache::remember('pendapatan_statistik_rasio', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $total = $data->count();
                $totalPekerja = $data->filter(function($item) {
                    return !empty($item->jenis_pekerjaan) &&
                           !in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                })->count();
                $totalTidakBekerja = $data->filter(function($item) {
                    return empty($item->jenis_pekerjaan) ||
                           in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                })->count();

                $stats = [
                    'persentase_pekerja' => $total > 0 ? number_format(($totalPekerja / $total) * 100, 1) : 0,
                    'persentase_tidak_bekerja' => $total > 0 ? number_format(($totalTidakBekerja / $total) * 100, 1) : 0,
                    'rasio_pekerja' => $totalTidakBekerja > 0 ? number_format($totalPekerja / $totalTidakBekerja, 2) : 0,
                    'rata_rata_pendapatan_keluarga' => $this->hitungRataRataPendapatanKeluarga($data) // ORIGINAL METHOD
                ];

                return $stats;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Hitung rata-rata pendapatan per keluarga
     * LOGIKA ORIGINAL - TIDAK DIUBAH!
     */
    private function hitungRataRataPendapatanKeluarga($data)
    {
        $keluarga = $data->groupBy('no_kk');
        $totalPendapatan = 0;
        $jumlahKeluarga = 0;

        foreach ($keluarga as $kk => $anggota) {
            $pendapatanKK = 0;
            foreach ($anggota as $item) {
                $pendapatanKK += $this->konversiPendapatanKeNilai($item->pendapatan_perbulan);
            }
            if ($pendapatanKK > 0) {
                $totalPendapatan += $pendapatanKK;
                $jumlahKeluarga++;
            }
        }

        $rataRata = $jumlahKeluarga > 0 ? $totalPendapatan / $jumlahKeluarga : 0;
        return $this->formatPendapatan($rataRata);
    }

    /**
     * Helper: Konversi kategori pendapatan ke nilai tengah
     */
    private function konversiPendapatanKeNilai($kategori)
    {
        $mapping = [
            '0-1 Juta' => 500000,
            '1-2 Juta' => 1500000,
            '2-3 Juta' => 2500000,
            '3-5 Juta' => 4000000,
            '5-10 Juta' => 7500000,
            '10-20 Juta' => 15000000,
            '20-50 Juta' => 35000000,
            '50-100 Juta' => 75000000,
            '>100 Juta' => 150000000
        ];

        return $mapping[$kategori] ?? 0;
    }

    /**
     * Helper: Format pendapatan ke string
     */
    private function formatPendapatan($nilai)
    {
        if ($nilai >= 1000000) {
            return number_format($nilai / 1000000, 1) . ' Juta';
        } else if ($nilai >= 1000) {
            return number_format($nilai / 1000, 0) . ' Ribu';
        }
        return number_format($nilai, 0);
    }

    /**
     * 3. Distribusi Pendapatan - Pie Chart
     */
    public function getDistribusiPendapatan()
    {
        try {
            $data = Cache::remember('pendapatan_distribusi', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->get();

                $distribusi = $data->groupBy('pendapatan_perbulan')
                    ->map(function ($item) {
                        return $item->count();
                    })
                    ->sortKeysUsing(function ($a, $b) {
                        return ($this->pendapatanOrder[$a] ?? 999) <=> ($this->pendapatanOrder[$b] ?? 999);
                    })
                    ->toArray();

                return $distribusi;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 4. Distribusi Jenis Kelamin dengan Pendapatan
     */
    public function getDistribusiJenisKelamin()
    {
        try {
            $data = Cache::remember('pendapatan_jenkel', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $distribusi = [
                    'Laki-laki' => $data->where('jenkel', 1)->count(),
                    'Perempuan' => $data->where('jenkel', 2)->count()
                ];

                return $distribusi;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 5. Distribusi Per Desa - Bar Chart
     */
    public function getDistribusiPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_per_desa', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $distribusi = $data->groupBy('desa')
                    ->map(function ($item) {
                        return $item->count();
                    })
                    ->sortDesc()
                    ->toArray();

                return $distribusi;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 6. Distribusi Kelompok Umur
     */
    public function getDistribusiKelompokUmur()
    {
        try {
            $data = Cache::remember('pendapatan_kelompok_umur', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $distribusi = [];
                foreach ($this->kategoriUmur as $label => $range) {
                    $distribusi[$label] = $data->whereBetween('umur', $range)->count();
                }

                return $distribusi;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 7. Pendapatan Berdasarkan Umur dan Jenis Kelamin - Grouped Bar
     */
    public function getPendapatanUmurJenisKelamin()
    {
        try {
            $data = Cache::remember('pendapatan_umur_jenkel', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $result = [];
                foreach ($this->kategoriUmur as $label => $range) {
                    $dataUmur = $data->whereBetween('umur', $range);
                    $result[$label] = [
                        'label' => $label,
                        'laki' => $dataUmur->where('jenkel', 1)->count(),
                        'perempuan' => $dataUmur->where('jenkel', 2)->count()
                    ];
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 8. Pendapatan Berdasarkan Kelompok Umur - Detail
     */
    public function getPendapatanBerdasarkanUmur()
    {
        try {
            $data = Cache::remember('pendapatan_by_umur_detail', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->get();

                $result = [];
                foreach ($this->kategoriUmur as $label => $range) {
                    $dataUmur = $data->whereBetween('umur', $range);
                    $distribusiPendapatan = $dataUmur->groupBy('pendapatan_perbulan')
                        ->map(function ($item) {
                            return $item->count();
                        })
                        ->toArray();

                    foreach ($distribusiPendapatan as $kategori => $jumlah) {
                        if (!isset($result[$label])) {
                            $result[$label] = [];
                        }
                        $result[$label][$kategori] = $jumlah;
                    }
                }

                // Format untuk stacked bar chart
                $labels = array_keys($this->kategoriUmur);
                $datasets = [];

                $semuaKategori = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta', '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'];
                $colors = ['#28a745', '#20c997', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#ffc107', '#dc3545', '#e83e8c'];

                foreach ($semuaKategori as $index => $kategori) {
                    $dataKategori = [];
                    foreach ($labels as $umur) {
                        $dataKategori[] = $result[$umur][$kategori] ?? 0;
                    }

                    $datasets[] = [
                        'label' => $kategori,
                        'data' => $dataKategori,
                        'backgroundColor' => $colors[$index % count($colors)],
                        'borderColor' => $colors[$index % count($colors)],
                        'borderWidth' => 1
                    ];
                }

                return [
                    'labels' => $labels,
                    'datasets' => $datasets
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 9. Top 10 Pekerjaan dengan Pendapatan Tertinggi
     */
    public function getTop10PekerjaanPendapatanTertinggi()
    {
        try {
            $data = Cache::remember('top10_pekerjaan_pendapatan', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->get();

                if ($data->isEmpty()) {
                    return [];
                }

                // Group by pekerjaan dan hitung rata-rata pendapatan
                $pekerjaan = $data->groupBy('jenis_pekerjaan')
                    ->map(function ($items) {
                        $totalNilai = 0;
                        $count = 0;
                        foreach ($items as $item) {
                            $nilai = $this->konversiPendapatanKeNilai($item->pendapatan_perbulan);
                            if ($nilai > 0) {
                                $totalNilai += $nilai;
                                $count++;
                            }
                        }
                        return [
                            'jumlah' => $items->count(),
                            'rata_rata' => $count > 0 ? $totalNilai / $count : 0
                        ];
                    })
                    ->filter(function ($info) {
                        return $info['rata_rata'] > 0;
                    })
                    ->sortByDesc('rata_rata')
                    ->take(10);

                $result = [];
                foreach ($pekerjaan as $nama => $info) {
                    $result[$nama] = $info['jumlah'];
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * 10. Pendapatan Tertinggi Per Desa
     */
    public function getPendapatanTertinggiPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_tertinggi_desa', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->get();

                // Group by desa dan hitung rata-rata pendapatan
                $desa = $data->groupBy('desa')
                    ->map(function ($items) {
                        $totalNilai = 0;
                        $count = 0;
                        foreach ($items as $item) {
                            $nilai = $this->konversiPendapatanKeNilai($item->pendapatan_perbulan);
                            if ($nilai > 0) {
                                $totalNilai += $nilai;
                                $count++;
                            }
                        }
                        return $count > 0 ? $totalNilai / $count : 0;
                    })
                    ->sortDesc();

                $result = [];
                foreach ($desa as $nama => $rataRata) {
                    $result[$nama] = round($rataRata / 1000000, 2); // Dalam jutaan
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 11. Detail Per Desa - Table
     */
    public function getDetailPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_detail_desa', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->get();

                $desas = DB::table('indonesia_villages')
                    ->whereIn('code', $data->pluck('kode_desa')->unique())
                    ->get()
                    ->keyBy('code');

                $result = [];
                foreach ($desas as $code => $desaInfo) {
                    $dataDesa = $data->where('kode_desa', $code);

                    $totalPendapatan = 0;
                    $countPendapatan = 0;
                    foreach ($dataDesa as $item) {
                        $nilai = $this->konversiPendapatanKeNilai($item->pendapatan_perbulan);
                        if ($nilai > 0) {
                            $totalPendapatan += $nilai;
                            $countPendapatan++;
                        }
                    }

                    $pekerja = $dataDesa->filter(function($item) {
                        return !empty($item->jenis_pekerjaan) &&
                               !in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                    })->count();

                    $tidakBekerja = $dataDesa->filter(function($item) {
                        return empty($item->jenis_pekerjaan) ||
                               in_array($item->jenis_pekerjaan, ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA']);
                    })->count();

                    $result[] = [
                        'desa' => $desaInfo->name,
                        'total_penduduk' => $dataDesa->count(),
                        'laki_laki' => $dataDesa->where('jenkel', 1)->count(),
                        'perempuan' => $dataDesa->where('jenkel', 2)->count(),
                        'kepala_keluarga' => $dataDesa->where('hubungan_keluarga', 'KEPALA KELUARGA')->count(),
                        'pekerja' => $pekerja,
                        'tidak_bekerja' => $tidakBekerja,
                        'rata_rata_pendapatan' => $countPendapatan > 0 ? $this->formatPendapatan($totalPendapatan / $countPendapatan) : '0'
                    ];
                }

                // Sort by rata-rata pendapatan tertinggi
                usort($result, function ($a, $b) {
                    return $this->konversiFormatKeNilai($b['rata_rata_pendapatan']) <=> $this->konversiFormatKeNilai($a['rata_rata_pendapatan']);
                });

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Helper: Konversi format string ke nilai
     */
    private function konversiFormatKeNilai($format)
    {
        if (strpos($format, 'Juta') !== false) {
            return (float) str_replace(' Juta', '', $format) * 1000000;
        } else if (strpos($format, 'Ribu') !== false) {
            return (float) str_replace(' Ribu', '', $format) * 1000;
        }
        return (float) $format;
    }

    /**
     * 12. Distribusi Pekerjaan - Pie Chart
     */
    public function getDistribusiPekerjaan()
    {
        try {
            $data = Cache::remember('pendapatan_distribusi_pekerjaan', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->get();

                if ($data->isEmpty()) {
                    return [];
                }

                // Ambil top 10 pekerjaan, sisanya masuk "Lainnya"
                $pekerjaan = $data->groupBy('jenis_pekerjaan')
                    ->map(function ($item) {
                        return $item->count();
                    })
                    ->sortDesc();

                $top10 = $pekerjaan->take(10)->toArray();
                $lainnya = $pekerjaan->skip(10)->sum();

                if ($lainnya > 0) {
                    $top10['LAINNYA'] = $lainnya;
                }

                return $top10;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * 13. Pendapatan Per Desa - Stacked Bar Chart
     */
    public function getPendapatanPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_stacked_desa', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->get();

                $desas = $data->pluck('desa')->unique()->values();

                // Prepare datasets
                $kategoriPendapatan = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta', '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'];
                $colors = ['#28a745', '#20c997', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#ffc107', '#dc3545', '#e83e8c'];

                $datasets = [];
                foreach ($kategoriPendapatan as $index => $kategori) {
                    $dataKategori = [];
                    foreach ($desas as $desa) {
                        $count = $data->where('desa', $desa)
                            ->where('pendapatan_perbulan', $kategori)
                            ->count();
                        $dataKategori[] = $count;
                    }

                    $datasets[] = [
                        'label' => $kategori,
                        'data' => $dataKategori,
                        'backgroundColor' => $colors[$index % count($colors)],
                        'borderColor' => $colors[$index % count($colors)],
                        'borderWidth' => 1
                    ];
                }

                return [
                    'labels' => $desas->toArray(),
                    'datasets' => $datasets
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 14. DataTable Kepala Keluarga dengan Filter
     */
    public function getDatatableKepalaKeluarga(Request $request)
    {
        try {
            $query = $this->getBaseQuery()
                ->where('t4.nama', 'KEPALA KELUARGA');

            // Apply filters
            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            if ($request->filled('pendapatan')) {
                $query->where('t1.pendapatan_perbulan', $request->pendapatan);
            }

            if ($request->filled('pekerjaan')) {
                $query->where('t5.nama', $request->pekerjaan);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function ($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info">Laki-laki</span>';
                    } else {
                        return '<span class="badge badge-danger">Perempuan</span>';
                    }
                })
                ->addColumn('umur_display', function ($row) {
                    return '<span class="badge badge-secondary">' . $row->umur . ' th</span>';
                })
                ->addColumn('tgl_lahir_display', function ($row) {
                    return date('d-m-Y', strtotime($row->tgl_lahir));
                })
                ->addColumn('pendapatan_badge', function ($row) {
                    $colors = [
                        '0-1 Juta' => 'success',
                        '1-2 Juta' => 'info',
                        '2-3 Juta' => 'primary',
                        '3-5 Juta' => 'warning',
                        '5-10 Juta' => 'purple',
                        '10-20 Juta' => 'danger',
                        '20-50 Juta' => 'dark',
                        '50-100 Juta' => 'secondary',
                        '>100 Juta' => 'indigo'
                    ];
                    $color = $colors[$row->pendapatan_perbulan] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . ($row->pendapatan_perbulan ?? 'Tidak Ada Data') . '</span>';
                })
                ->addColumn('pekerjaan_display', function ($row) {
                    return '<small>' . ($row->jenis_pekerjaan ?? '-') . '</small>';
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'pendapatan_badge', 'pekerjaan_display'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 15. List Desa untuk Filter
     */
    public function getListDesa()
    {
        try {
            $desas = Cache::remember('pendapatan_list_desa', self::CACHE_TTL, function() {
                return DB::table('indonesia_villages')
                    ->whereIn('code', function ($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->orderBy('name')
                    ->get(['code', 'name']);
            });

            return response()->json([
                'success' => true,
                'data' => $desas
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 16. List Pendapatan untuk Filter
     */
    public function getListPendapatan()
    {
        try {
            $pendapatan = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta', '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'];

            return response()->json([
                'success' => true,
                'data' => $pendapatan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * 17. List Pekerjaan untuk Filter
     */
    public function getListPekerjaan()
    {
        try {
            $pekerjaan = Cache::remember('pendapatan_list_pekerjaan', self::CACHE_TTL, function() {
                return DB::table('m_pekerjaan')
                    ->orderBy('nama')
                    ->pluck('nama')
                    ->filter(function($item) {
                        return !empty($item);
                    })
                    ->values();
            });

            return response()->json([
                'success' => true,
                'data' => $pekerjaan
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    /**
     * 18. Statistik Pekerjaan Berdasarkan Gender
     */
    public function getPekerjaanBerdasarkanGender()
    {
        try {
            $data = Cache::remember('pendapatan_pekerjaan_gender', self::CACHE_TTL, function() {
                $query = $this->getBaseQuery();
                $data = $query->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->whereNotIn('t5.nama', ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA'])
                    ->get();

                if ($data->isEmpty()) {
                    return [];
                }

                // Ambil top 10 pekerjaan
                $topPekerjaan = $data->groupBy('jenis_pekerjaan')
                    ->map(function ($item) {
                        return $item->count();
                    })
                    ->sortDesc()
                    ->take(10)
                    ->keys();

                $result = [];
                foreach ($topPekerjaan as $pekerjaan) {
                    $dataPekerjaan = $data->where('jenis_pekerjaan', $pekerjaan);
                    $result[$pekerjaan] = [
                        'label' => $pekerjaan,
                        'laki' => $dataPekerjaan->where('jenkel', 1)->count(),
                        'perempuan' => $dataPekerjaan->where('jenkel', 2)->count()
                    ];
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => []
            ], 500);
        }
    }

    // Helper function untuk masking NIK
    private function maskNumber($number)
    {
        if (!$number || strlen($number) < 16) {
            return $number;
        }

        return substr($number, 0, 3)
            . str_repeat('*', 10)
            . substr($number, -3);
    }

    /**
     * 19. Clear Cache
     */
    public function clearCache()
    {
        try {
            $cacheKeys = [
                'pendapatan_statistik_jumlah',
                'pendapatan_statistik_rasio',
                'pendapatan_distribusi',
                'pendapatan_jenkel',
                'pendapatan_per_desa',
                'pendapatan_kelompok_umur',
                'pendapatan_umur_jenkel',
                'pendapatan_by_umur_detail',
                'top10_pekerjaan_pendapatan',
                'pendapatan_tertinggi_desa',
                'pendapatan_detail_desa',
                'pendapatan_distribusi_pekerjaan',
                'pendapatan_stacked_desa',
                'pendapatan_list_desa',
                'pendapatan_list_pekerjaan',
                'pendapatan_pekerjaan_gender',
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
