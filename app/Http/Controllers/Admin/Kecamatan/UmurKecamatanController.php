<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class UmurKecamatanController extends Controller
{

    private const CACHE_TTL = 7200; // 2 jam

    public function index(Request $request)
    {
        return view('admin.chart.umur.kecamatan');
    }

    // 1. Distribusi umur penduduk - FIXED
    public function distribusiUmur()
    {
        try {
            $data = Cache::remember('distribusi_umur', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_data AS (
                        SELECT
                            TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota
                        WHERE tgl_lahir IS NOT NULL
                        AND tgl_lahir != ''
                        AND tgl_lahir != '0000-00-00'
                    )
                    SELECT
                        CASE
                            WHEN umur BETWEEN 0 AND 4 THEN '0-4'
                            WHEN umur BETWEEN 5 AND 9 THEN '5-9'
                            WHEN umur BETWEEN 10 AND 14 THEN '10-14'
                            WHEN umur BETWEEN 15 AND 19 THEN '15-19'
                            WHEN umur BETWEEN 20 AND 24 THEN '20-24'
                            WHEN umur BETWEEN 25 AND 29 THEN '25-29'
                            WHEN umur BETWEEN 30 AND 34 THEN '30-34'
                            WHEN umur BETWEEN 35 AND 39 THEN '35-39'
                            WHEN umur BETWEEN 40 AND 44 THEN '40-44'
                            WHEN umur BETWEEN 45 AND 49 THEN '45-49'
                            WHEN umur BETWEEN 50 AND 54 THEN '50-54'
                            WHEN umur BETWEEN 55 AND 59 THEN '55-59'
                            WHEN umur BETWEEN 60 AND 64 THEN '60-64'
                            WHEN umur >= 65 THEN '65+'
                        END as kelompok_umur,
                        COUNT(*) as jumlah
                    FROM umur_data
                    WHERE umur >= 0 AND umur <= 120
                    GROUP BY kelompok_umur
                    ORDER BY FIELD(kelompok_umur, '0-4', '5-9', '10-14', '15-19', '20-24', '25-29', '30-34', '35-39', '40-44', '45-49', '50-54', '55-59', '60-64', '65+')
                ";

                $results = DB::select($query);

                // Convert stdClass to array untuk memastikan kompatibilitas
                return array_map(function($item) {
                    return [
                        'kelompok_umur' => $item->kelompok_umur,
                        'jumlah' => (int)$item->jumlah
                    ];
                }, $results);
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in distribusiUmur: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 2. Distribusi umur per desa - FIXED
    public function distribusiUmurPerDesa()
    {
        try {
            $data = Cache::remember('distribusi_umur_desa', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_desa AS (
                        SELECT
                            t2.desa,
                            TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota t1
                        JOIN t_kartu_keluarga t2 ON t2.id = t1.no_kk
                        WHERE t1.tgl_lahir IS NOT NULL
                        AND t1.tgl_lahir != ''
                        AND t1.tgl_lahir != '0000-00-00'
                        AND t2.desa IS NOT NULL
                    )
                    SELECT
                        t5.name as desa,
                        CASE
                            WHEN umur BETWEEN 0 AND 4 THEN '0-4'
                            WHEN umur BETWEEN 5 AND 14 THEN '5-14'
                            WHEN umur BETWEEN 15 AND 24 THEN '15-24'
                            WHEN umur BETWEEN 25 AND 64 THEN '25-64'
                            WHEN umur >= 65 THEN '65+'
                        END as kelompok_umur,
                        COUNT(*) as jumlah
                    FROM umur_desa
                    LEFT JOIN indonesia_villages t5 ON t5.code = umur_desa.desa
                    WHERE umur >= 0 AND umur <= 120
                    AND t5.name IS NOT NULL
                    GROUP BY t5.name, kelompok_umur
                    ORDER BY t5.name, FIELD(kelompok_umur, '0-4', '5-14', '15-24', '25-64', '65+')
                ";

                $results = DB::select($query);

                return array_map(function($item) {
                    return [
                        'desa' => $item->desa,
                        'kelompok_umur' => $item->kelompok_umur,
                        'jumlah' => (int)$item->jumlah
                    ];
                }, $results);
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in distribusiUmurPerDesa: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 3. Kategori umur - FIXED
    public function kategoriUmur()
    {
        try {
            $data = Cache::remember('kategori_umur', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_calc AS (
                        SELECT TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota
                        WHERE tgl_lahir IS NOT NULL
                        AND tgl_lahir != ''
                        AND tgl_lahir != '0000-00-00'
                        AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 120
                    )
                    SELECT
                        SUM(CASE WHEN umur BETWEEN 0 AND 4 THEN 1 ELSE 0 END) as balita,
                        SUM(CASE WHEN umur BETWEEN 5 AND 14 THEN 1 ELSE 0 END) as anak,
                        SUM(CASE WHEN umur BETWEEN 15 AND 24 THEN 1 ELSE 0 END) as remaja,
                        SUM(CASE WHEN umur BETWEEN 15 AND 64 THEN 1 ELSE 0 END) as produktif,
                        SUM(CASE WHEN umur >= 65 THEN 1 ELSE 0 END) as lansia,
                        SUM(CASE WHEN umur >= 17 THEN 1 ELSE 0 END) as layak_memilih,
                        COUNT(*) as total
                    FROM umur_calc
                ";

                $result = DB::select($query);
                $stats = $result[0];

                return [
                    'balita' => (int)$stats->balita,
                    'anak' => (int)$stats->anak,
                    'remaja' => (int)$stats->remaja,
                    'produktif' => (int)$stats->produktif,
                    'lansia' => (int)$stats->lansia,
                    'layak_memilih' => (int)$stats->layak_memilih,
                    'total' => (int)$stats->total
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in kategoriUmur: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 4. Produktif per desa - FIXED
    public function produktifPerDesa()
    {
        try {
            $data = Cache::remember('produktif_desa', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_desa AS (
                        SELECT
                            t2.desa,
                            TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota t1
                        JOIN t_kartu_keluarga t2 ON t2.id = t1.no_kk
                        WHERE t1.tgl_lahir IS NOT NULL
                        AND t1.tgl_lahir != ''
                        AND t1.tgl_lahir != '0000-00-00'
                        AND TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 0 AND 120
                    )
                    SELECT
                        t5.name as desa,
                        SUM(CASE WHEN umur BETWEEN 15 AND 64 THEN 1 ELSE 0 END) as produktif,
                        COUNT(*) as total
                    FROM umur_desa
                    LEFT JOIN indonesia_villages t5 ON t5.code = umur_desa.desa
                    WHERE t5.name IS NOT NULL
                    GROUP BY t5.name
                    ORDER BY produktif DESC
                ";

                $results = DB::select($query);

                return array_map(function($item) {
                    return [
                        'desa' => $item->desa,
                        'produktif' => (int)$item->produktif,
                        'total' => (int)$item->total
                    ];
                }, $results);
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in produktifPerDesa: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 5. Layak memilih per desa - FIXED
    public function layakMemilihPerDesa()
    {
        try {
            $data = Cache::remember('layak_memilih_desa', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_desa AS (
                        SELECT
                            t2.desa,
                            TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota t1
                        JOIN t_kartu_keluarga t2 ON t2.id = t1.no_kk
                        WHERE t1.tgl_lahir IS NOT NULL
                        AND t1.tgl_lahir != ''
                        AND t1.tgl_lahir != '0000-00-00'
                        AND TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 0 AND 120
                    )
                    SELECT
                        t5.name as desa,
                        SUM(CASE WHEN umur >= 17 THEN 1 ELSE 0 END) as layak_memilih,
                        COUNT(*) as total
                    FROM umur_desa
                    LEFT JOIN indonesia_villages t5 ON t5.code = umur_desa.desa
                    WHERE t5.name IS NOT NULL
                    GROUP BY t5.name
                    ORDER BY layak_memilih DESC
                ";

                $results = DB::select($query);

                return array_map(function($item) {
                    return [
                        'desa' => $item->desa,
                        'layak_memilih' => (int)$item->layak_memilih,
                        'total' => (int)$item->total
                    ];
                }, $results);
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in layakMemilihPerDesa: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 6. Statistik lanjutan - FIXED
    public function statistikLanjutan()
    {
        try {
            $data = Cache::remember('statistik_lanjutan', self::CACHE_TTL, function () {
                $query = "
                    WITH umur_calc AS (
                        SELECT TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) as umur
                        FROM t_kartu_keluarga_anggota
                        WHERE tgl_lahir IS NOT NULL
                        AND tgl_lahir != ''
                        AND tgl_lahir != '0000-00-00'
                    )
                    SELECT
                        COUNT(*) as total_penduduk,
                        SUM(CASE WHEN umur BETWEEN 15 AND 64 THEN 1 ELSE 0 END) as produktif,
                        SUM(CASE WHEN umur < 15 OR umur > 64 THEN 1 ELSE 0 END) as tidak_produktif,
                        SUM(CASE WHEN umur >= 17 THEN 1 ELSE 0 END) as layak_memilih,
                        AVG(CASE WHEN umur BETWEEN 0 AND 120 THEN umur END) as rata_rata_umur
                    FROM umur_calc
                    WHERE umur >= 0 AND umur <= 120
                ";

                $result = DB::select($query);
                $stats = $result[0];

                $dependencyRatio = $stats->produktif > 0
                    ? ($stats->tidak_produktif / $stats->produktif) * 100
                    : 0;

                $persenLayakMemilih = $stats->total_penduduk > 0
                    ? ($stats->layak_memilih / $stats->total_penduduk) * 100
                    : 0;

                // Get median - FIXED VERSION
                $medianQuery = "
                    SELECT
                        AVG(umur) as median_umur
                    FROM (
                        SELECT
                            TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) as umur,
                            ROW_NUMBER() OVER (ORDER BY TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE())) as row_num,
                            COUNT(*) OVER () as total_rows
                        FROM t_kartu_keluarga_anggota
                        WHERE tgl_lahir IS NOT NULL
                        AND tgl_lahir != ''
                        AND tgl_lahir != '0000-00-00'
                        AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0 AND 120
                    ) as ranked
                    WHERE row_num IN (FLOOR((total_rows + 1) / 2), FLOOR((total_rows + 2) / 2))
                ";

                $medianResult = DB::select($medianQuery);
                $median = $medianResult[0]->median_umur ?? 0;

                return [
                    'dependency_ratio' => round($dependencyRatio, 2),
                    'rata_rata_umur' => round((float)$stats->rata_rata_umur, 2),
                    'median_umur' => round((float)$median, 2),
                    'persen_layak_memilih' => round($persenLayakMemilih, 2),
                    'total_penduduk' => (int)$stats->total_penduduk,
                    'produktif' => (int)$stats->produktif,
                    'tidak_produktif' => (int)$stats->tidak_produktif,
                    'layak_memilih' => (int)$stats->layak_memilih
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in statistikLanjutan: ' . $e->getMessage());
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /// 7. Tren pertumbuhan - Menggunakan Query Builder Laravel
    public function trenPertumbuhan()
    {
        try {
            $data = Cache::remember('tren_pertumbuhan', self::CACHE_TTL, function () {
                // Tanggal 12 bulan lalu
                $twelveMonthsAgo = Carbon::now()->subMonths(12)->startOfMonth();
                $fiveYearsAgo = Carbon::now()->subYears(20)->startOfYear();
                $oneYearAgo = Carbon::now()->subYear();
                $oneMonthAgo = Carbon::now()->subMonth();

                // Per Bulan (12 bulan terakhir)
                $rawBulan = DB::table('t_kartu_keluarga_anggota')
                    ->select(
                        DB::raw("DATE_FORMAT(tgl_lahir, '%Y-%m') as periode"),
                        DB::raw("DATE_FORMAT(tgl_lahir, '%b %Y') as label")
                    )
                    ->where('tgl_lahir', '>=', $twelveMonthsAgo)
                    ->whereDate('tgl_lahir', '<=', Carbon::today()) // <-- TAMBAHAN
                    ->whereNotNull('tgl_lahir')
                    ->where('tgl_lahir', '!=', '')
                    ->where('tgl_lahir', '!=', '0000-00-00')
                    ->get();


                // Group manual untuk avoid GROUP BY error
                $perBulan = $rawBulan
                    ->groupBy('periode')
                    ->map(function ($items, $periode) {
                        return [
                            'periode' => $periode,
                            'label' => $items->first()->label,
                            'jumlah' => $items->count()
                        ];
                    })
                    ->sortBy('periode')
                    ->values()
                    ->toArray();

                // Per Tahun (5 tahun terakhir)
                $rawTahun = DB::table('t_kartu_keluarga_anggota')
                    ->select(DB::raw("YEAR(tgl_lahir) as tahun"))
                    ->where('tgl_lahir', '>=', $fiveYearsAgo)
                    ->whereDate('tgl_lahir', '<=', Carbon::today()) // <-- TAMBAHAN
                    ->whereNotNull('tgl_lahir')
                    ->where('tgl_lahir', '!=', '')
                    ->where('tgl_lahir', '!=', '0000-00-00')
                    ->get();


                // Group manual
                $perTahun = $rawTahun
                    ->groupBy('tahun')
                    ->map(function ($items, $tahun) {
                        return [
                            'tahun' => (int)$tahun,
                            'jumlah' => $items->count()
                        ];
                    })
                    ->sortBy('tahun')
                    ->values()
                    ->toArray();

                // Statistik
                $totalKelahiran = DB::table('t_kartu_keluarga_anggota')
                    ->whereDate('tgl_lahir', '<=', Carbon::today()) // <-- TAMBAHAN
                    ->whereNotNull('tgl_lahir')
                    ->where('tgl_lahir', '!=', '')
                    ->where('tgl_lahir', '!=', '0000-00-00')
                    ->count();

                $kelahiranTahunIni = DB::table('t_kartu_keluarga_anggota')
                    ->where('tgl_lahir', '>=', $oneYearAgo)
                    ->whereDate('tgl_lahir', '<=', Carbon::today()) // <-- TAMBAHAN
                    ->whereNotNull('tgl_lahir')
                    ->where('tgl_lahir', '!=', '')
                    ->where('tgl_lahir', '!=', '0000-00-00')
                    ->count();

                $kelahiranBulanIni = DB::table('t_kartu_keluarga_anggota')
                    ->where('tgl_lahir', '>=', $oneMonthAgo)
                    ->whereDate('tgl_lahir', '<=', Carbon::today()) // <-- TAMBAHAN
                    ->whereNotNull('tgl_lahir')
                    ->where('tgl_lahir', '!=', '')
                    ->where('tgl_lahir', '!=', '0000-00-00')
                    ->count();


                return [
                    'per_bulan' => $perBulan,
                    'per_tahun' => $perTahun,
                    'statistik' => [
                        'total_kelahiran' => (int)$totalKelahiran,
                        'kelahiran_tahun_ini' => (int)$kelahiranTahunIni,
                        'kelahiran_bulan_ini' => (int)$kelahiranBulanIni
                    ]
                ];
            });

            return response()->json($data);
        } catch (\Exception $e) {
            Log::error('Error in trenPertumbuhan: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function clearCache()
    {
        Cache::forget('distribusi_umur');
        Cache::forget('distribusi_umur_desa');
        Cache::forget('kategori_umur');
        Cache::forget('produktif_desa');
        Cache::forget('layak_memilih_desa');
        Cache::forget('statistik_lanjutan');
        Cache::forget('tren_pertumbuhan');

        return response()->json(['message' => 'Cache cleared successfully']);
    }
}
