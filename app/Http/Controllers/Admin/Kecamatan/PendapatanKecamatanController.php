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
            $data = Cache::remember('pendapatan_statistik_jumlah', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->select([
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as total_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as total_perempuan'),
                        DB::raw('SUM(CASE WHEN t4.nama = "KEPALA KELUARGA" THEN 1 ELSE 0 END) as total_kepala_keluarga'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as total_pekerja'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NULL OR t5.nama IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as total_tidak_bekerja'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan = "0-1 Juta" THEN 1 ELSE 0 END) as pendapatan_0_1'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan = "1-2 Juta" THEN 1 ELSE 0 END) as pendapatan_1_2'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan = "2-3 Juta" THEN 1 ELSE 0 END) as pendapatan_2_3'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan = "3-5 Juta" THEN 1 ELSE 0 END) as pendapatan_3_5'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan = "5-10 Juta" THEN 1 ELSE 0 END) as pendapatan_5_10'),
                        DB::raw('SUM(CASE WHEN t1.pendapatan_perbulan IN ("10-20 Juta", "20-50 Juta", "50-100 Juta", ">100 Juta") THEN 1 ELSE 0 END) as pendapatan_10_plus'),
                    ])
                    ->first();
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
            $data = Cache::remember('pendapatan_statistik_rasio', self::CACHE_TTL, function() {
                $stats = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->select([
                        DB::raw('COUNT(*) as total'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as total_pekerja'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NULL OR t5.nama IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as total_tidak_bekerja')
                    ])
                    ->first();

                $total = $stats->total;
                $totalPekerja = $stats->total_pekerja;
                $totalTidakBekerja = $stats->total_tidak_bekerja;

                // Hitung rata-rata pendapatan keluarga
                $rataRata = $this->hitungRataRataPendapatanKeluargaOptimized();

                return [
                    'persentase_pekerja' => $total > 0 ? number_format(($totalPekerja / $total) * 100, 1) : 0,
                    'persentase_tidak_bekerja' => $total > 0 ? number_format(($totalTidakBekerja / $total) * 100, 1) : 0,
                    'rasio_pekerja' => $totalTidakBekerja > 0 ? number_format($totalPekerja / $totalTidakBekerja, 2) : 0,
                    'rata_rata_pendapatan_keluarga' => $rataRata
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
     * Helper: Hitung rata-rata pendapatan per keluarga (OPTIMIZED)
     */
    private function hitungRataRataPendapatanKeluargaOptimized()
    {
        try {
            $result = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->whereNotNull('t1.pendapatan_perbulan')
                ->where('t1.pendapatan_perbulan', '!=', '')
                ->select([
                    't2.no_kk',
                    't1.pendapatan_perbulan'
                ])
                ->get()
                ->groupBy('no_kk');

            $totalPendapatan = 0;
            $jumlahKeluarga = 0;

            foreach ($result as $kk => $anggota) {
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
        } catch (\Exception $e) {
            return '0';
        }
    }

    /**
     * Helper: Konversi kategori pendapatan ke nilai tengah
     */
    private function konversiPendapatanKeNilai($kategori)
    {
        // Validasi input
        if (empty($kategori) || !is_string($kategori)) {
            return 0;
        }

        // Trim whitespace
        $kategori = trim($kategori);

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

        // Jika kategori tidak ada dalam mapping, log untuk debugging
        if (!isset($mapping[$kategori])) {
            \Log::warning('Kategori pendapatan tidak valid', [
                'kategori' => $kategori,
                'method' => 'konversiPendapatanKeNilai'
            ]);
            return 0;
        }

        return $mapping[$kategori];
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
                return DB::table('t_kartu_keluarga_anggota')
                    ->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->select([
                        'pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('pendapatan_perbulan')
                    ->get()
                    ->pluck('jumlah', 'pendapatan_perbulan')
                    ->sortKeysUsing(function ($a, $b) {
                        return ($this->pendapatanOrder[$a] ?? 999) <=> ($this->pendapatanOrder[$b] ?? 999);
                    })
                    ->toArray();
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
                return DB::table('t_kartu_keluarga_anggota')
                    ->select([
                        DB::raw('CASE WHEN jenkel = 1 THEN "Laki-laki" ELSE "Perempuan" END as jenis_kelamin'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('jenkel')
                    ->get()
                    ->pluck('jumlah', 'jenis_kelamin')
                    ->toArray();
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
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select([
                        't3.name as desa',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t3.name')
                    ->orderBy('jumlah', 'DESC')
                    ->get()
                    ->pluck('jumlah', 'desa')
                    ->toArray();
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
                return DB::table('t_kartu_keluarga_anggota')
                    ->select([
                        DB::raw('CASE
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 17 THEN "0-17"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN "18-25"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 35 THEN "26-35"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 36 AND 45 THEN "36-45"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 46 AND 55 THEN "46-55"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 56 AND 65 THEN "56-65"
                            ELSE ">65"
                        END as kelompok'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('kelompok')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->pluck('jumlah', 'kelompok')
                    ->toArray();
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
                return DB::table('t_kartu_keluarga_anggota')
                    ->select([
                        DB::raw('CASE
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 17 THEN "0-17"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN "18-25"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 35 THEN "26-35"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 36 AND 45 THEN "36-45"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 46 AND 55 THEN "46-55"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 56 AND 65 THEN "56-65"
                            ELSE ">65"
                        END as label'),
                        DB::raw('SUM(CASE WHEN jenkel = 1 THEN 1 ELSE 0 END) as laki'),
                        DB::raw('SUM(CASE WHEN jenkel = 2 THEN 1 ELSE 0 END) as perempuan')
                    ])
                    ->groupBy('label')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->toArray();
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
                // Get raw data dengan query yang lebih efisien
                $rawData = DB::table('t_kartu_keluarga_anggota')
                    ->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->select([
                        DB::raw('CASE
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 17 THEN "0-17"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN "18-25"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 35 THEN "26-35"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 36 AND 45 THEN "36-45"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 46 AND 55 THEN "46-55"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 56 AND 65 THEN "56-65"
                            ELSE ">65"
                        END as kelompok_umur'),
                        'pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('kelompok_umur', 'pendapatan_perbulan')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get();

                // Format untuk stacked bar chart
                $labels = ['0-17', '18-25', '26-35', '36-45', '46-55', '56-65', '>65'];
                $semuaKategori = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta', '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'];
                $colors = ['#28a745', '#20c997', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#ffc107', '#dc3545', '#e83e8c'];

                // Organize data by age group and income category
                $organizedData = [];
                foreach ($rawData as $row) {
                    if (!isset($organizedData[$row->kelompok_umur])) {
                        $organizedData[$row->kelompok_umur] = [];
                    }
                    $organizedData[$row->kelompok_umur][$row->pendapatan_perbulan] = $row->jumlah;
                }

                $datasets = [];
                foreach ($semuaKategori as $index => $kategori) {
                    $dataKategori = [];
                    foreach ($labels as $umur) {
                        $dataKategori[] = $organizedData[$umur][$kategori] ?? 0;
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
                // Ambil data dengan query yang sudah dioptimasi
                $rawData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->select([
                        't5.nama as jenis_pekerjaan',
                        't1.pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t5.nama', 't1.pendapatan_perbulan')
                    ->get();

                if ($rawData->isEmpty()) {
                    return [];
                }

                // Hitung rata-rata per pekerjaan
                $pekerjaan = [];
                foreach ($rawData as $row) {
                    if (!isset($pekerjaan[$row->jenis_pekerjaan])) {
                        $pekerjaan[$row->jenis_pekerjaan] = [
                            'total_nilai' => 0,
                            'total_count' => 0,
                            'jumlah_orang' => 0
                        ];
                    }

                    $nilai = $this->konversiPendapatanKeNilai($row->pendapatan_perbulan);
                    $pekerjaan[$row->jenis_pekerjaan]['total_nilai'] += ($nilai * $row->jumlah);
                    $pekerjaan[$row->jenis_pekerjaan]['total_count'] += $row->jumlah;
                    $pekerjaan[$row->jenis_pekerjaan]['jumlah_orang'] += $row->jumlah;
                }

                // Hitung rata-rata dan sort
                $result = [];
                foreach ($pekerjaan as $nama => $info) {
                    $result[$nama] = [
                        'rata_rata' => $info['total_count'] > 0 ? $info['total_nilai'] / $info['total_count'] : 0,
                        'jumlah' => $info['jumlah_orang']
                    ];
                }

                // Sort by rata-rata descending
                uasort($result, function($a, $b) {
                    return $b['rata_rata'] <=> $a['rata_rata'];
                });

                // Take top 10 and return only jumlah
                $top10 = array_slice($result, 0, 10, true);
                $finalResult = [];
                foreach ($top10 as $nama => $info) {
                    $finalResult[$nama] = $info['jumlah'];
                }

                return $finalResult;
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
                // Get raw data dengan query optimized
                $rawData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->select([
                        't3.name as desa',
                        't1.pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t3.name', 't1.pendapatan_perbulan')
                    ->get();

                // Hitung rata-rata per desa
                $desaData = [];
                foreach ($rawData as $row) {
                    if (!isset($desaData[$row->desa])) {
                        $desaData[$row->desa] = [
                            'total_nilai' => 0,
                            'total_count' => 0
                        ];
                    }

                    $nilai = $this->konversiPendapatanKeNilai($row->pendapatan_perbulan);
                    $desaData[$row->desa]['total_nilai'] += ($nilai * $row->jumlah);
                    $desaData[$row->desa]['total_count'] += $row->jumlah;
                }

                // Calculate average and format
                $result = [];
                foreach ($desaData as $nama => $info) {
                    $rataRata = $info['total_count'] > 0 ? $info['total_nilai'] / $info['total_count'] : 0;
                    $result[$nama] = round($rataRata / 1000000, 2); // Dalam jutaan
                }

                // Sort descending
                arsort($result);

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
                // Get basic stats per desa
                $desaStats = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->select([
                        't3.name as desa',
                        't2.desa as kode_desa',
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                        DB::raw('SUM(CASE WHEN t4.nama = "KEPALA KELUARGA" THEN 1 ELSE 0 END) as kepala_keluarga'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as pekerja'),
                        DB::raw('SUM(CASE WHEN t5.nama IS NULL OR t5.nama IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") THEN 1 ELSE 0 END) as tidak_bekerja')
                    ])
                    ->groupBy('t3.name', 't2.desa')
                    ->get();

                // Get pendapatan data per desa
                $pendapatanData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->select([
                        't2.desa as kode_desa',
                        't1.pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t2.desa', 't1.pendapatan_perbulan')
                    ->get()
                    ->groupBy('kode_desa');

                // Combine data
                $result = [];
                foreach ($desaStats as $desa) {
                    $totalPendapatan = 0;
                    $countPendapatan = 0;

                    if (isset($pendapatanData[$desa->kode_desa])) {
                        foreach ($pendapatanData[$desa->kode_desa] as $item) {
                            $nilai = $this->konversiPendapatanKeNilai($item->pendapatan_perbulan);
                            $totalPendapatan += ($nilai * $item->jumlah);
                            $countPendapatan += $item->jumlah;
                        }
                    }

                    $result[] = [
                        'desa' => $desa->desa,
                        'total_penduduk' => $desa->total_penduduk,
                        'laki_laki' => $desa->laki_laki,
                        'perempuan' => $desa->perempuan,
                        'kepala_keluarga' => $desa->kepala_keluarga,
                        'pekerja' => $desa->pekerja,
                        'tidak_bekerja' => $desa->tidak_bekerja,
                        'rata_rata_pendapatan' => $countPendapatan > 0 ?
                            $this->formatPendapatan($totalPendapatan / $countPendapatan) : '0',
                        'rata_rata_nilai' => $countPendapatan > 0 ?
                            $totalPendapatan / $countPendapatan : 0
                    ];
                }

                // Sort by rata-rata pendapatan tertinggi
                usort($result, function ($a, $b) {
                    return $b['rata_rata_nilai'] <=> $a['rata_rata_nilai'];
                });

                // Remove helper field
                foreach ($result as &$item) {
                    unset($item['rata_rata_nilai']);
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
                $pekerjaan = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->select([
                        't5.nama as jenis_pekerjaan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t5.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->get();

                if ($pekerjaan->isEmpty()) {
                    return [];
                }

                // Ambil top 10, sisanya masuk "Lainnya"
                $top10 = $pekerjaan->take(10)->pluck('jumlah', 'jenis_pekerjaan')->toArray();
                $lainnya = $pekerjaan->skip(10)->sum('jumlah');

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
                $rawData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->select([
                        't3.name as desa',
                        't1.pendapatan_perbulan',
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('t3.name', 't1.pendapatan_perbulan')
                    ->orderBy('t3.name')
                    ->get();

                $desas = $rawData->pluck('desa')->unique()->values()->toArray();

                // Prepare datasets
                $kategoriPendapatan = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta', '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'];
                $colors = ['#28a745', '#20c997', '#17a2b8', '#007bff', '#6f42c1', '#fd7e14', '#ffc107', '#dc3545', '#e83e8c'];

                // Organize data
                $organizedData = [];
                foreach ($rawData as $row) {
                    if (!isset($organizedData[$row->desa])) {
                        $organizedData[$row->desa] = [];
                    }
                    $organizedData[$row->desa][$row->pendapatan_perbulan] = $row->jumlah;
                }

                $datasets = [];
                foreach ($kategoriPendapatan as $index => $kategori) {
                    $dataKategori = [];
                    foreach ($desas as $desa) {
                        $dataKategori[] = $organizedData[$desa][$kategori] ?? 0;
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
                    'labels' => $desas,
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
                // Ambil top 10 pekerjaan
                $topPekerjaan = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->whereNotIn('t5.nama', ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA'])
                    ->select([
                        't5.nama as jenis_pekerjaan',
                        DB::raw('COUNT(*) as total')
                    ])
                    ->groupBy('t5.nama')
                    ->orderBy('total', 'DESC')
                    ->limit(10)
                    ->pluck('jenis_pekerjaan');

                if ($topPekerjaan->isEmpty()) {
                    return [];
                }

                // Get gender distribution for top 10
                $genderData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereIn('t5.nama', $topPekerjaan)
                    ->select([
                        't5.nama as label',
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan')
                    ])
                    ->groupBy('t5.nama')
                    ->get()
                    ->keyBy('label')
                    ->toArray();

                return $genderData;
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
     * 19. Clear Cache (Optional - untuk admin)
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