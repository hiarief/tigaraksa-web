<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    private const CACHE_TTL = 21600; // 6 hours

    public function page()
    {
        try {
            $basicStats = DB::table('t_kartu_keluarga as t1')
                ->leftJoin('t_kartu_keluarga_anggota as t2', 't1.id', '=', 't2.no_kk')
                ->selectRaw(
                    '
                    COUNT(DISTINCT t1.id) as total_kk,
                    COUNT(t2.id) as total_nik,
                    COUNT(DISTINCT t1.desa) as total_desa
                ',
                )
                ->first();

            return view('landing-page.page', [
                'kk' => $basicStats->total_kk ?? 0,
                'nik' => $basicStats->total_nik ?? 0,
                'totalDesa' => $basicStats->total_desa ?? 0,
            ]);
        } catch (\Exception $e) {
            Log::error('Error in page: ' . $e->getMessage());
            return view('landing-page.page', [
                'kk' => 0,
                'nik' => 0,
                'totalDesa' => 0,
            ]);
        }
    }

    public function clearCache()
    {
        try {
            Cache::flush();
            return response()->json(['message' => 'Cache cleared successfully']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // ========================================
    // 1️⃣ BASIC STATS
    // ========================================
    public function getBasicStats()
    {
        try {
            $data = Cache::remember('lp_basic_stats', self::CACHE_TTL, function () {
                $stats = DB::table('t_kartu_keluarga as t1')
                    ->leftJoin('t_kartu_keluarga_anggota as t2', 't1.id', '=', 't2.no_kk')
                    ->selectRaw(
                        '
                        COUNT(DISTINCT t1.id) as total_kk,
                        COUNT(t2.id) as total_penduduk,
                        COUNT(DISTINCT t1.desa) as total_desa
                    ',
                    )
                    ->first();

                return [
                    'total_kk' => $stats->total_kk ?? 0,
                    'total_penduduk' => $stats->total_penduduk ?? 0,
                    'total_desa' => $stats->total_desa ?? 0,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getBasicStats: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load basic stats',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 2️⃣ KEY METRICS
    // ========================================
    public function getKeyMetrics()
    {
        try {
            $data = Cache::remember('lp_key_metrics', self::CACHE_TTL, function () {
                $metrics = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->leftJoin('bantuan_pemerintah as bp', 't2.bantuan_pemerintah', '=', 'bp.Id')
                    ->selectRaw(
                        "
                        COUNT(*) as total_kk,
                        SUM(CASE WHEN t2.pendapatan_perbulan = '0-1 Juta' THEN 1 ELSE 0 END) as pendapatan_rendah,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as jumlah_lansia,
                        SUM(CASE
                            WHEN t2.tanya_bantuanpemerintah = 'Layak'
                            AND bp.nama = 'Belum Pernah Dapat Bantuan'
                            THEN 1 ELSE 0
                        END) as layak_belum_dapat,
                        SUM(CASE
                            WHEN t2.punya_bpjs = 'tidak' OR t2.punya_bpjs IS NULL
                            THEN 1 ELSE 0
                        END) as tidak_bpjs,
                        SUM(CASE
                            WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60
                            AND t2.pendapatan_perbulan = '0-1 Juta'
                            AND bp.nama = 'Belum Pernah Dapat Bantuan'
                            THEN 1 ELSE 0
                        END) as sangat_rentan,
                        SUM(CASE
                            WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60
                            AND bp.nama = 'Belum Pernah Dapat Bantuan'
                            THEN 1 ELSE 0
                        END) as lansia_belum_bantuan
                    ",
                    )
                    ->first();

                $total = $metrics->total_kk ?: 1;

                return [
                    'total_kk' => (int) $metrics->total_kk,
                    'pendapatan_rendah' => (int) $metrics->pendapatan_rendah,
                    'persentase_pendapatan_rendah' => round(($metrics->pendapatan_rendah / $total) * 100, 1),
                    'jumlah_lansia' => (int) $metrics->jumlah_lansia,
                    'persentase_lansia' => round(($metrics->jumlah_lansia / $total) * 100, 1),
                    'layak_belum_dapat' => (int) $metrics->layak_belum_dapat,
                    'persentase_layak_belum_dapat' => round(($metrics->layak_belum_dapat / $total) * 100, 1),
                    'tidak_punya_bpjs' => (int) $metrics->tidak_bpjs,
                    'persentase_tidak_bpjs' => round(($metrics->tidak_bpjs / $total) * 100, 1),
                    'keluarga_sangat_rentan' => (int) $metrics->sangat_rentan,
                    'lansia_belum_bantuan' => (int) $metrics->lansia_belum_bantuan,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getKeyMetrics: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load key metrics',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 3️⃣ DEMOGRAFI KK
    // ========================================
    public function getDemografiKK()
    {
        try {
            $data = Cache::remember('lp_demografi_kk', self::CACHE_TTL, function () {
                $stats = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->selectRaw(
                        "
                        SUM(CASE WHEN t2.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki,
                        SUM(CASE WHEN t2.jenkel = 2 THEN 1 ELSE 0 END) as perempuan,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) < 25 THEN 1 ELSE 0 END) as muda,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) BETWEEN 25 AND 44 THEN 1 ELSE 0 END) as produktif,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) BETWEEN 45 AND 59 THEN 1 ELSE 0 END) as pra_lansia,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia
                    ",
                    )
                    ->first();

                return [
                    'gender_kk' => [
                        'laki_laki' => (int) $stats->laki_laki,
                        'perempuan' => (int) $stats->perempuan,
                    ],
                    'age_groups_kk' => [
                        'muda' => (int) $stats->muda,
                        'produktif' => (int) $stats->produktif,
                        'pra_lansia' => (int) $stats->pra_lansia,
                        'lansia' => (int) $stats->lansia,
                    ],
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getDemografiKK: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load demografi KK',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 4️⃣ EKONOMI
    // ========================================
    public function getEkonomi()
    {
        try {
            $data = Cache::remember('lp_ekonomi', self::CACHE_TTL, function () {
                $pendapatan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.pendapatan_perbulan as nama', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('t2.pendapatan_perbulan')
                    ->where('t2.pendapatan_perbulan', '!=', '')
                    ->groupBy('t2.pendapatan_perbulan')
                    ->orderByRaw(
                        "
                        CASE t2.pendapatan_perbulan
                            WHEN '0-1 Juta' THEN 1
                            WHEN '1-2 Juta' THEN 2
                            WHEN '2-3 Juta' THEN 3
                            WHEN '3-5 Juta' THEN 4
                            ELSE 5
                        END
                    ",
                    )
                    ->get();

                $rumah = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.kepemilikan_rumah as nama', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('t2.kepemilikan_rumah')
                    ->where('t2.kepemilikan_rumah', '!=', '')
                    ->groupBy('t2.kepemilikan_rumah')
                    ->orderBy('total', 'desc')
                    ->get();

                return [
                    'pendapatan_kk' => $pendapatan,
                    'kepemilikan_rumah' => $rumah,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getEkonomi: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load ekonomi',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 5️⃣ BANTUAN
    // ========================================
    public function getBantuan()
    {
        try {
            $data = Cache::remember('lp_bantuan', self::CACHE_TTL, function () {
                $stats = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->selectRaw(
                        "
                        SUM(CASE WHEN t2.tanya_bantuanpemerintah = 'Layak' THEN 1 ELSE 0 END) as layak,
                        SUM(CASE WHEN t2.tanya_bantuanpemerintah = 'Tidak Layak' THEN 1 ELSE 0 END) as tidak_layak
                    ",
                    )
                    ->first();

                $jenisBantuan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('bantuan_pemerintah as bp', 't2.bantuan_pemerintah', '=', 'bp.Id')
                    ->select('bp.nama', DB::raw('COUNT(*) as total'))
                    ->groupBy('bp.nama')
                    ->orderBy('total', 'desc')
                    ->get();

                return [
                    'kelayakan_bantuan' => [
                        'layak' => (int) $stats->layak,
                        'tidak layak' => (int) $stats->tidak_layak,
                    ],
                    'jenis_bantuan' => $jenisBantuan,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getBantuan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load bantuan',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 6️⃣ KESEHATAN
    // ========================================
    public function getKesehatan()
    {
        try {
            $data = Cache::remember('lp_kesehatan', self::CACHE_TTL, function () {
                // BPJS Stats (tanpa join dulu)
                $bpjsStats = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->selectRaw(
                        "
                    SUM(CASE WHEN t2.punya_bpjs = 'ya' THEN 1 ELSE 0 END) as punya_bpjs,
                    SUM(CASE WHEN t2.punya_bpjs = 'tidak' OR t2.punya_bpjs IS NULL THEN 1 ELSE 0 END) as tidak_punya_bpjs
                ",
                    )
                    ->first();

                // Jenis BPJS (tanpa join dulu)
                $jenisBPJS = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.jenis_bpjs', DB::raw('COUNT(*) as total'))
                    ->where('t2.punya_bpjs', 'ya')
                    ->whereNotNull('t2.jenis_bpjs')
                    ->where('t2.jenis_bpjs', '!=', '')
                    ->groupBy('t2.jenis_bpjs')
                    ->get();

                // Sakit Kronis - QUERY TERPISAH untuk avoid timeout
                $sakitKronisRaw = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.sakitkronis', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('t2.sakitkronis')
                    ->where('t2.sakitkronis', '>', 0)
                    ->groupBy('t2.sakitkronis')
                    ->orderBy('total', 'desc')
                    ->get();

                // Ambil nama sakit kronis dari master
                $sakitKronisIds = $sakitKronisRaw->pluck('sakitkronis')->toArray();
                $sakitKronisNames = [];

                if (!empty($sakitKronisIds)) {
                    $sakitKronisNames = DB::table('m_sakit_kronis')->whereIn('id', $sakitKronisIds)->pluck('nama', 'id')->toArray();
                }

                // Gabungkan hasil
                $sakitKronis = $sakitKronisRaw->map(function ($item) use ($sakitKronisNames) {
                    return (object) [
                        'nama' => $sakitKronisNames[$item->sakitkronis] ?? 'Unknown',
                        'total' => $item->total,
                    ];
                });

                return [
                    'bpjs_kk' => $bpjsStats,
                    'jenis_bpjs' => $jenisBPJS,
                    'sakit_kronis' => $sakitKronis,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getKesehatan: ' . $e->getMessage());
            return response()->json(
                [
                    'error' => 'Failed to load kesehatan',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 7️⃣ PENDIDIKAN & PEKERJAAN
    // ========================================
    public function getPendidikanPekerjaan()
    {
        try {
            $data = Cache::remember('lp_pendidikan_pekerjaan', self::CACHE_TTL, function () {
                // Pendidikan - QUERY TERPISAH
                $pendidikanRaw = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.pendidikan', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('t2.pendidikan')
                    ->where('t2.pendidikan', '>', 0)
                    ->groupBy('t2.pendidikan')
                    ->orderBy('total', 'desc')
                    ->get();

                $pendidikanIds = $pendidikanRaw->pluck('pendidikan')->toArray();
                $pendidikanNames = [];

                if (!empty($pendidikanIds)) {
                    $pendidikanNames = DB::table('m_pendidikan_keluarga')->whereIn('id', $pendidikanIds)->pluck('nama', 'id')->toArray();
                }

                $pendidikan = $pendidikanRaw->map(function ($item) use ($pendidikanNames) {
                    return (object) [
                        'nama' => $pendidikanNames[$item->pendidikan] ?? 'Unknown',
                        'total' => $item->total,
                    ];
                });

                // Pekerjaan - QUERY TERPISAH
                $pekerjaanRaw = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function ($join) {
                        $join->on('t1.id', '=', 't2.no_kk')->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.jns_pekerjaan', DB::raw('COUNT(*) as total'))
                    ->whereNotNull('t2.jns_pekerjaan')
                    ->where('t2.jns_pekerjaan', '>', 0)
                    ->groupBy('t2.jns_pekerjaan')
                    ->orderBy('total', 'desc')
                    ->limit(10)
                    ->get();

                $pekerjaanIds = $pekerjaanRaw->pluck('jns_pekerjaan')->toArray();
                $pekerjaanNames = [];

                if (!empty($pekerjaanIds)) {
                    $pekerjaanNames = DB::table('m_pekerjaan')->whereIn('id', $pekerjaanIds)->pluck('nama', 'id')->toArray();
                }

                $pekerjaan = $pekerjaanRaw->map(function ($item) use ($pekerjaanNames) {
                    return (object) [
                        'nama' => $pekerjaanNames[$item->jns_pekerjaan] ?? 'Unknown',
                        'total' => $item->total,
                    ];
                });

                return [
                    'pendidikan_kk' => $pendidikan,
                    'pekerjaan_kk' => $pekerjaan,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getPendidikanPekerjaan: ' . $e->getMessage());
            return response()->json(
                [
                    'error' => 'Failed to load pendidikan & pekerjaan',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 8️⃣ STATISTIK PENDUDUK
    // ========================================
    public function getStatistikPenduduk()
    {
        try {
            $data = Cache::remember('lp_statistik_penduduk', self::CACHE_TTL, function () {
                // Gender & Age (query cepat, tanpa join)
                $stats = DB::table('t_kartu_keluarga_anggota')
                    ->selectRaw(
                        "
                    SUM(CASE WHEN jenkel = 1 THEN 1 ELSE 0 END) as laki_laki,
                    SUM(CASE WHEN jenkel = 2 THEN 1 ELSE 0 END) as perempuan,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 5 THEN 1 ELSE 0 END) as balita,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 5 AND 17 THEN 1 ELSE 0 END) as anak,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 59 THEN 1 ELSE 0 END) as dewasa,
                    SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia
                ",
                    )
                    ->first();

                // Agama - QUERY TERPISAH
                $agamaRaw = DB::table('t_kartu_keluarga_anggota')->select('agama', DB::raw('COUNT(*) as total'))->whereNotNull('agama')->where('agama', '>', 0)->groupBy('agama')->orderBy('total', 'desc')->get();

                $agamaIds = $agamaRaw->pluck('agama')->toArray();
                $agamaNames = [];

                if (!empty($agamaIds)) {
                    $agamaNames = DB::table('m_agama')->whereIn('id', $agamaIds)->pluck('nama', 'id')->toArray();
                }

                $agama = $agamaRaw->map(function ($item) use ($agamaNames) {
                    return (object) [
                        'nama' => $agamaNames[$item->agama] ?? 'Unknown',
                        'total' => $item->total,
                    ];
                });

                return [
                    'gender' => [
                        'laki_laki' => (int) $stats->laki_laki,
                        'perempuan' => (int) $stats->perempuan,
                    ],
                    'age' => [
                        'balita' => (int) $stats->balita,
                        'anak' => (int) $stats->anak,
                        'dewasa' => (int) $stats->dewasa,
                        'lansia' => (int) $stats->lansia,
                    ],
                    'agama' => $agama,
                ];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getStatistikPenduduk: ' . $e->getMessage());
            return response()->json(
                [
                    'error' => 'Failed to load statistik penduduk',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }

    // ========================================
    // 9️⃣ DATA DESA
    // ========================================
    public function getDataDesa()
    {
        try {
            $data = Cache::remember('lp_data_desa', self::CACHE_TTL, function () {
                $desa = DB::table('t_kartu_keluarga as kk')->join('indonesia_villages as v', 'kk.desa', '=', 'v.code')->leftJoin('t_kartu_keluarga_anggota as a', 'kk.id', '=', 'a.no_kk')->select('v.name as nama_desa', DB::raw('COUNT(DISTINCT kk.id) as jumlah_kk'), DB::raw('COUNT(a.id) as jumlah_penduduk'))->groupBy('v.name')->orderBy('jumlah_kk', 'desc')->get();

                return ['desa' => $desa];
            });

            return response()
                ->json($data)
                ->header('Cache-Control', 'public, max-age=' . self::CACHE_TTL);
        } catch (\Exception $e) {
            Log::error('Error in getDataDesa: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            return response()->json(
                [
                    'error' => 'Failed to load data desa',
                    'message' => config('app.debug') ? $e->getMessage() : 'Internal server error',
                ],
                500,
            );
        }
    }
}
