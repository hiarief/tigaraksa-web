<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class KepemilikanRumahKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index(Request $request)
    {
        return view('admin.chart.kepemilikan-rumah.kecamatan');
    }

    /**
     * Get Statistik Jumlah
     */
    public function getStatistikJumlah()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.statistik_jumlah', self::CACHE_TTL, function () {
                // Hanya ambil Kepala Keluarga (sts_hub_kel = 1) untuk menghindari data bias
                $query = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1); // Hanya kepala keluarga

                $totalKK = $query->count();
                $totalLakiLaki = (clone $query)->where('t1.jenkel', 1)->count();
                $totalPerempuan = (clone $query)->where('t1.jenkel', 2)->count();

                // Kepemilikan Rumah
                $milikSendiri = (clone $query)->where('t1.kepemilikan_rumah', 'Milik Sendiri')->count();
                $orangTua = (clone $query)->where('t1.kepemilikan_rumah', 'Orang Tua')->count();
                $ngontrak = (clone $query)->where('t1.kepemilikan_rumah', 'Ngontrak')->count();
                $lainnya = (clone $query)->where('t1.kepemilikan_rumah', 'Lainnya')->count();
                $tidakAda = (clone $query)->where(function($q) {
                    $q->whereNull('t1.kepemilikan_rumah')
                      ->orWhere('t1.kepemilikan_rumah', '');
                })->count();

                return [
                    'total_kk' => $totalKK,
                    'total_laki_laki' => $totalLakiLaki,
                    'total_perempuan' => $totalPerempuan,
                    'milik_sendiri' => $milikSendiri,
                    'orang_tua' => $orangTua,
                    'ngontrak' => $ngontrak,
                    'lainnya' => $lainnya,
                    'tidak_ada_data' => $tidakAda,
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
     * Get Statistik Rasio
     */
    public function getStatistikRasio()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.statistik_rasio', self::CACHE_TTL, function () {
                $query = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1);

                $totalKK = $query->count();
                $milikSendiri = (clone $query)->where('t1.kepemilikan_rumah', 'Milik Sendiri')->count();
                $tidakMilikSendiri = $totalKK - $milikSendiri;

                $persentaseMilikSendiri = $totalKK > 0 ? round(($milikSendiri / $totalKK) * 100, 2) : 0;
                $persentaseTidakMilikSendiri = $totalKK > 0 ? round(($tidakMilikSendiri / $totalKK) * 100, 2) : 0;

                $rasio = $tidakMilikSendiri > 0 ? round($milikSendiri / $tidakMilikSendiri, 2) : $milikSendiri;

                return [
                    'persentase_milik_sendiri' => $persentaseMilikSendiri,
                    'persentase_tidak_milik_sendiri' => $persentaseTidakMilikSendiri,
                    'rasio_kepemilikan' => $rasio,
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
     * Get Distribusi Kepemilikan Rumah
     */
    public function getDistribusiKepemilikan()
    {
        try {
            $result = Cache::remember('kepemilikan_rumah.distribusi_kepemilikan', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->select('t1.kepemilikan_rumah', DB::raw('COUNT(*) as total'))
                    ->groupBy('t1.kepemilikan_rumah')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $label = $item->kepemilikan_rumah ?: 'Tidak Ada Data';
                    $result[$label] = $item->total;
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Distribusi Jenis Kelamin Kepala Keluarga
     */
    public function getDistribusiJenisKelamin()
    {
        try {
            $result = Cache::remember('kepemilikan_rumah.distribusi_jenkel', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->select('t1.jenkel', DB::raw('COUNT(*) as total'))
                    ->groupBy('t1.jenkel')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $label = $item->jenkel == 1 ? 'Laki-laki' : 'Perempuan';
                    $result[$label] = $item->total;
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Distribusi Per Desa
     */
    public function getDistribusiPerDesa()
    {
        try {
            $result = Cache::remember('kepemilikan_rumah.distribusi_desa', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->where('t1.sts_hub_kel', 1)
                    ->select('t3.name as desa', DB::raw('COUNT(*) as total'))
                    ->groupBy('t3.name')
                    ->orderBy('t3.name')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $result[$item->desa] = $item->total;
                }

                return $result;
            });

            return response()->json([
                'success' => true,
                'data' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Distribusi Kelompok Umur
     */
    public function getDistribusiKelompokUmur()
    {
        try {
            $kelompokUmur = Cache::remember('kepemilikan_rumah.distribusi_umur', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->select(
                        DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                        't1.kepemilikan_rumah'
                    )
                    ->get();

                $kelompokUmur = [
                    '0-17 tahun' => 0,
                    '18-25 tahun' => 0,
                    '26-35 tahun' => 0,
                    '36-45 tahun' => 0,
                    '46-55 tahun' => 0,
                    '56-65 tahun' => 0,
                    '>65 tahun' => 0,
                ];

                foreach ($data as $item) {
                    $umur = $item->umur;
                    if ($umur <= 17) {
                        $kelompokUmur['0-17 tahun']++;
                    } elseif ($umur <= 25) {
                        $kelompokUmur['18-25 tahun']++;
                    } elseif ($umur <= 35) {
                        $kelompokUmur['26-35 tahun']++;
                    } elseif ($umur <= 45) {
                        $kelompokUmur['36-45 tahun']++;
                    } elseif ($umur <= 55) {
                        $kelompokUmur['46-55 tahun']++;
                    } elseif ($umur <= 65) {
                        $kelompokUmur['56-65 tahun']++;
                    } else {
                        $kelompokUmur['>65 tahun']++;
                    }
                }

                return $kelompokUmur;
            });

            return response()->json([
                'success' => true,
                'data' => $kelompokUmur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Kepemilikan Rumah Berdasarkan Umur dan Jenis Kelamin
     */
    public function getKepemilikanUmurJenisKelamin()
    {
        try {
            $kelompokUmur = Cache::remember('kepemilikan_rumah.umur_jenkel', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->select(
                        DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                        't1.jenkel',
                        't1.kepemilikan_rumah'
                    )
                    ->get();

                $kelompokUmur = [
                    '0-17' => ['label' => '0-17 tahun', 'laki' => 0, 'perempuan' => 0],
                    '18-25' => ['label' => '18-25 tahun', 'laki' => 0, 'perempuan' => 0],
                    '26-35' => ['label' => '26-35 tahun', 'laki' => 0, 'perempuan' => 0],
                    '36-45' => ['label' => '36-45 tahun', 'laki' => 0, 'perempuan' => 0],
                    '46-55' => ['label' => '46-55 tahun', 'laki' => 0, 'perempuan' => 0],
                    '56-65' => ['label' => '56-65 tahun', 'laki' => 0, 'perempuan' => 0],
                    '>65' => ['label' => '>65 tahun', 'laki' => 0, 'perempuan' => 0],
                ];

                foreach ($data as $item) {
                    $umur = $item->umur;
                    $jenkel = $item->jenkel;

                    if ($umur <= 17) {
                        $key = '0-17';
                    } elseif ($umur <= 25) {
                        $key = '18-25';
                    } elseif ($umur <= 35) {
                        $key = '26-35';
                    } elseif ($umur <= 45) {
                        $key = '36-45';
                    } elseif ($umur <= 55) {
                        $key = '46-55';
                    } elseif ($umur <= 65) {
                        $key = '56-65';
                    } else {
                        $key = '>65';
                    }

                    if ($jenkel == 1) {
                        $kelompokUmur[$key]['laki']++;
                    } else {
                        $kelompokUmur[$key]['perempuan']++;
                    }
                }

                return $kelompokUmur;
            });

            return response()->json([
                'success' => true,
                'data' => $kelompokUmur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Detail Per Desa
     */
    public function getDetailPerDesa()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.detail_desa', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->where('t1.sts_hub_kel', 1)
                    ->select(
                        't3.name as desa',
                        DB::raw('COUNT(*) as total_kk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                        DB::raw('SUM(CASE WHEN t1.kepemilikan_rumah = "Milik Sendiri" THEN 1 ELSE 0 END) as milik_sendiri'),
                        DB::raw('SUM(CASE WHEN t1.kepemilikan_rumah = "Orang Tua" THEN 1 ELSE 0 END) as orang_tua'),
                        DB::raw('SUM(CASE WHEN t1.kepemilikan_rumah = "Ngontrak" THEN 1 ELSE 0 END) as ngontrak'),
                        DB::raw('SUM(CASE WHEN t1.kepemilikan_rumah = "Lainnya" THEN 1 ELSE 0 END) as lainnya'),
                        DB::raw('SUM(CASE WHEN t1.kepemilikan_rumah IS NULL OR t1.kepemilikan_rumah = "" THEN 1 ELSE 0 END) as tidak_ada_data')
                    )
                    ->groupBy('t3.name')
                    ->orderBy('t3.name')
                    ->get();
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
     * Get Kepemilikan Rumah Per Desa (Stacked)
     */
    public function getKepemilikanPerDesa()
    {
        try {
            $chartData = Cache::remember('kepemilikan_rumah.kepemilikan_desa', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->where('t1.sts_hub_kel', 1)
                    ->select(
                        't3.name as desa',
                        't1.kepemilikan_rumah',
                        DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('t3.name', 't1.kepemilikan_rumah')
                    ->orderBy('t3.name')
                    ->get();

                $labels = [];
                $datasets = [
                    'Milik Sendiri' => ['label' => 'Milik Sendiri', 'data' => [], 'backgroundColor' => '#28a745'],
                    'Orang Tua' => ['label' => 'Orang Tua', 'data' => [], 'backgroundColor' => '#007bff'],
                    'Ngontrak' => ['label' => 'Ngontrak', 'data' => [], 'backgroundColor' => '#ffc107'],
                    'Lainnya' => ['label' => 'Lainnya', 'data' => [], 'backgroundColor' => '#6c757d'],
                    'Tidak Ada Data' => ['label' => 'Tidak Ada Data', 'data' => [], 'backgroundColor' => '#dc3545'],
                ];

                $groupedData = [];
                foreach ($data as $item) {
                    $desa = $item->desa;
                    if (!in_array($desa, $labels)) {
                        $labels[] = $desa;
                    }

                    $kepemilikan = $item->kepemilikan_rumah ?: 'Tidak Ada Data';
                    if (!isset($groupedData[$desa])) {
                        $groupedData[$desa] = [];
                    }
                    $groupedData[$desa][$kepemilikan] = $item->total;
                }

                foreach ($labels as $desa) {
                    foreach ($datasets as $key => $dataset) {
                        $datasets[$key]['data'][] = $groupedData[$desa][$key] ?? 0;
                    }
                }

                return [
                    'labels' => $labels,
                    'datasets' => array_values($datasets)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $chartData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Kepemilikan Berdasarkan Pendapatan
     */
    public function getKepemilikanBerdasarkanPendapatan()
    {
        try {
            $chartData = Cache::remember('kepemilikan_rumah.pendapatan', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->select(
                        't1.pendapatan_perbulan',
                        't1.kepemilikan_rumah',
                        DB::raw('COUNT(*) as total')
                    )
                    ->groupBy('t1.pendapatan_perbulan', 't1.kepemilikan_rumah')
                    ->get();

                $pendapatanOrder = ["0-1 Juta", "1-2 Juta", "2-3 Juta", "3-5 Juta", "5-10 Juta", "10-20 Juta", "20-50 Juta", "50-100 Juta", ">100 Juta"];
                $labels = [];

                $datasets = [
                    'Milik Sendiri' => ['label' => 'Milik Sendiri', 'data' => [], 'backgroundColor' => '#28a745'],
                    'Orang Tua' => ['label' => 'Orang Tua', 'data' => [], 'backgroundColor' => '#007bff'],
                    'Ngontrak' => ['label' => 'Ngontrak', 'data' => [], 'backgroundColor' => '#ffc107'],
                    'Lainnya' => ['label' => 'Lainnya', 'data' => [], 'backgroundColor' => '#6c757d'],
                ];

                $groupedData = [];
                foreach ($data as $item) {
                    $pendapatan = $item->pendapatan_perbulan ?: 'Tidak Diketahui';
                    if (!in_array($pendapatan, $labels) && in_array($pendapatan, $pendapatanOrder)) {
                        $labels[] = $pendapatan;
                    }

                    $kepemilikan = $item->kepemilikan_rumah;
                    if ($kepemilikan && isset($datasets[$kepemilikan])) {
                        if (!isset($groupedData[$pendapatan])) {
                            $groupedData[$pendapatan] = [];
                        }
                        $groupedData[$pendapatan][$kepemilikan] = $item->total;
                    }
                }

                // Sort labels based on pendapatanOrder
                usort($labels, function($a, $b) use ($pendapatanOrder) {
                    return array_search($a, $pendapatanOrder) - array_search($b, $pendapatanOrder);
                });

                foreach ($labels as $pendapatan) {
                    foreach ($datasets as $key => $dataset) {
                        $datasets[$key]['data'][] = $groupedData[$pendapatan][$key] ?? 0;
                    }
                }

                return [
                    'labels' => $labels,
                    'datasets' => array_values($datasets)
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $chartData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get Data Abnormal
     */
    public function getDataAbnormal()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.data_abnormal', self::CACHE_TTL, function () {
                $query = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1);

                // Data abnormal: kepemilikan rumah null/kosong
                $kepemilikanKosong = (clone $query)->where(function($q) {
                    $q->whereNull('t1.kepemilikan_rumah')
                      ->orWhere('t1.kepemilikan_rumah', '');
                })->count();

                // Kepala keluarga dengan status "Orang Tua" (seharusnya tidak mungkin)
                $kepalaOrangTua = (clone $query)->where('t1.kepemilikan_rumah', 'Orang Tua')->count();

                // Kepala keluarga umur < 18 tahun
                $kepalaUmurMuda = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_hub_kel', 1)
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18')
                    ->count();

                // Pendapatan tidak diisi
                $pendapatanKosong = (clone $query)->where(function($q) {
                    $q->whereNull('t1.pendapatan_perbulan')
                      ->orWhere('t1.pendapatan_perbulan', '');
                })->count();

                return [
                    'Kepemilikan Tidak Diisi' => $kepemilikanKosong,
                    'Kepala KK Status Orang Tua' => $kepalaOrangTua,
                    'Kepala KK Umur < 18 Tahun' => $kepalaUmurMuda,
                    'Pendapatan Tidak Diisi' => $pendapatanKosong,
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
     * Get DataTable Kepala Keluarga
     */
    public function getDatatableKepalaKeluarga(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                ->where('t1.sts_hub_kel', 1)
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't2.no_kk',
                    't1.jenkel',
                    't1.tgl_lahir',
                    't1.pendapatan_perbulan',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't3.name AS desa',
                    't1.kepemilikan_rumah'
                ]);

            // Filter
            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            if ($request->filled('kepemilikan')) {
                if ($request->kepemilikan == 'kosong') {
                    $query->where(function($q) {
                        $q->whereNull('t1.kepemilikan_rumah')
                          ->orWhere('t1.kepemilikan_rumah', '');
                    });
                } else {
                    $query->where('t1.kepemilikan_rumah', $request->kepemilikan);
                }
            }

            if ($request->filled('jenkel')) {
                $query->where('t1.jenkel', $request->jenkel);
            }

            if ($request->filled('pendapatan')) {
                $query->where('t1.pendapatan_perbulan', $request->pendapatan);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info badge-stat"><i class="fas fa-male mr-1"></i> Laki-laki</span>';
                    } else {
                        return '<span class="badge badge-danger badge-stat"><i class="fas fa-female mr-1"></i> Perempuan</span>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    return '<span class="badge badge-secondary badge-stat">' . $row->umur . ' th</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return date('d/m/Y', strtotime($row->tgl_lahir));
                })
                ->addColumn('kepemilikan_display', function($row) {
                    if (!$row->kepemilikan_rumah) {
                        return '<span class="badge badge-danger">Tidak Ada Data</span>';
                    }

                    $badges = [
                        'Milik Sendiri' => 'success',
                        'Orang Tua' => 'primary',
                        'Ngontrak' => 'warning',
                        'Lainnya' => 'secondary',
                    ];

                    $class = $badges[$row->kepemilikan_rumah] ?? 'secondary';
                    return '<span class="badge badge-' . $class . '">' . $row->kepemilikan_rumah . '</span>';
                })
                ->addColumn('pendapatan_display', function($row) {
                    if (!$row->pendapatan_perbulan) {
                        return '<span class="badge badge-secondary">Tidak Diketahui</span>';
                    }
                    return '<span class="badge badge-info">' . $row->pendapatan_perbulan . '</span>';
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'kepemilikan_display', 'pendapatan_display'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get DataTable Data Abnormal
     */
    public function getDatatableAbnormal(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->where('t1.sts_hub_kel', 1)
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't2.no_kk',
                    't1.jenkel',
                    't1.tgl_lahir',
                    't1.pendapatan_perbulan',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't3.name AS desa',
                    't1.kepemilikan_rumah'
                ])
                ->where(function($q) {
                    // Kondisi abnormal
                    $q->whereNull('t1.kepemilikan_rumah')
                      ->orWhere('t1.kepemilikan_rumah', '')
                      ->orWhere('t1.kepemilikan_rumah', 'Orang Tua')
                      ->orWhereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18')
                      ->orWhereNull('t1.pendapatan_perbulan')
                      ->orWhere('t1.pendapatan_perbulan', '');
                });

            // Filter
            if ($request->filled('kategori')) {
                switch ($request->kategori) {
                    case 'Kepemilikan Tidak Diisi':
                        $query->where(function($q) {
                            $q->whereNull('t1.kepemilikan_rumah')
                              ->orWhere('t1.kepemilikan_rumah', '');
                        });
                        break;
                    case 'Kepala KK Status Orang Tua':
                        $query->where('t1.kepemilikan_rumah', 'Orang Tua');
                        break;
                    case 'Kepala KK Umur < 18 Tahun':
                        $query->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18');
                        break;
                    case 'Pendapatan Tidak Diisi':
                        $query->where(function($q) {
                            $q->whereNull('t1.pendapatan_perbulan')
                              ->orWhere('t1.pendapatan_perbulan', '');
                        });
                        break;
                }
            }

            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info"><i class="fas fa-male mr-1"></i> L</span>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-female mr-1"></i> P</span>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    $badge = $row->umur < 18 ? 'badge-danger' : 'badge-secondary';
                    return '<span class="badge ' . $badge . '">' . $row->umur . ' th</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return date('d/m/Y', strtotime($row->tgl_lahir));
                })
                ->addColumn('kategori_badge', function($row) {
                    $badges = [];

                    if (!$row->kepemilikan_rumah || $row->kepemilikan_rumah == '') {
                        $badges[] = '<span class="badge badge-danger mb-1">Kepemilikan Kosong</span>';
                    }

                    if ($row->kepemilikan_rumah == 'Orang Tua') {
                        $badges[] = '<span class="badge badge-warning mb-1">Status Orang Tua</span>';
                    }

                    if ($row->umur < 18) {
                        $badges[] = '<span class="badge badge-danger mb-1">Umur < 18 Tahun</span>';
                    }

                    if (!$row->pendapatan_perbulan || $row->pendapatan_perbulan == '') {
                        $badges[] = '<span class="badge badge-warning mb-1">Pendapatan Kosong</span>';
                    }

                    return implode('<br>', $badges);
                })
                ->addColumn('detail_masalah', function($row) {
                    $masalah = [];

                    if (!$row->kepemilikan_rumah || $row->kepemilikan_rumah == '') {
                        $masalah[] = 'Kepemilikan rumah belum diisi';
                    }

                    if ($row->kepemilikan_rumah == 'Orang Tua') {
                        $masalah[] = 'Kepala KK tidak bisa status "Orang Tua"';
                    }

                    if ($row->umur < 18) {
                        $masalah[] = 'Kepala KK berusia di bawah 18 tahun';
                    }

                    if (!$row->pendapatan_perbulan || $row->pendapatan_perbulan == '') {
                        $masalah[] = 'Pendapatan belum diisi';
                    }

                    return '<small>' . implode('; ', $masalah) . '</small>';
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'kategori_badge', 'detail_masalah'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get List Desa
     */
    public function getListDesa()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.list_desa', self::CACHE_TTL, function () {
                // Option 1: Hanya ambil desa yang memiliki data KK (AKTIF)
                return DB::table('indonesia_villages as t3')
                    ->join('t_kartu_keluarga as t2', 't3.code', '=', 't2.desa')
                    ->join('t_kartu_keluarga_anggota as t1', 't2.id', '=', 't1.no_kk')
                    ->where('t1.sts_hub_kel', 1)
                    ->select('t3.code', 't3.name')
                    ->distinct()
                    ->orderBy('t3.name')
                    ->get();
            });

            // Option 2: Jika ingin filter berdasarkan kecamatan tertentu
            // Ganti 'KODE_KECAMATAN' dengan kode kecamatan Anda
            /*
            $data = Cache::remember('kepemilikan_rumah.list_desa', self::CACHE_TTL, function () {
                return DB::table('indonesia_villages')
                    ->where('district_code', 'KODE_KECAMATAN') // Sesuaikan dengan kode kecamatan
                    ->select('code', 'name')
                    ->orderBy('name')
                    ->get();
            });
            */

            // Option 3: Jika struktur tabel berbeda dan ada field kecamatan_id
            /*
            $kecamatanId = 'ID_KECAMATAN_ANDA'; // Sesuaikan
            $data = Cache::remember('kepemilikan_rumah.list_desa', self::CACHE_TTL, function () use ($kecamatanId) {
                return DB::table('indonesia_villages')
                    ->where('kecamatan_id', $kecamatanId)
                    ->select('code', 'name')
                    ->orderBy('name')
                    ->get();
            });
            */

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
     * Get List Pendapatan
     */
    public function getListPendapatan()
    {
        try {
            $data = Cache::remember('kepemilikan_rumah.list_pendapatan', self::CACHE_TTL, function () {
                return ["0-1 Juta", "1-2 Juta", "2-3 Juta", "3-5 Juta", "5-10 Juta", "10-20 Juta", "20-50 Juta", "50-100 Juta", ">100 Juta"];
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
     * Clear All Cache
     * Method helper untuk clear cache ketika ada update data
     * Panggil method ini setelah insert/update/delete data KK
     */
    public function clearCache()
    {
        try {
            $cacheKeys = [
                'kepemilikan_rumah.statistik_jumlah',
                'kepemilikan_rumah.statistik_rasio',
                'kepemilikan_rumah.distribusi_kepemilikan',
                'kepemilikan_rumah.distribusi_jenkel',
                'kepemilikan_rumah.distribusi_desa',
                'kepemilikan_rumah.distribusi_umur',
                'kepemilikan_rumah.umur_jenkel',
                'kepemilikan_rumah.detail_desa',
                'kepemilikan_rumah.kepemilikan_desa',
                'kepemilikan_rumah.pendapatan',
                'kepemilikan_rumah.data_abnormal',
                'kepemilikan_rumah.list_desa',
                'kepemilikan_rumah.list_pendapatan',
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            return response()->json([
                'success' => true,
                'message' => 'All cache cleared successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
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
}