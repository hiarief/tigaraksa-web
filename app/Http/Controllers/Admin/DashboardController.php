<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    private const CACHE_TTL = 7200;

    public function index()
    {
        $desaList = Cache::remember('dashboard_desa_list', self::CACHE_TTL, function () {
            return DB::table('indonesia_villages as t3')->join('t_kartu_keluarga as t2', 't3.code', '=', 't2.desa')->select('t3.code', 't3.name')->distinct()->orderBy('t3.name')->get();
        });

        return view('admin.dashboard.dashboard', compact('desaList'));
    }

    // 1. Statistik Kependudukan
    public function statsKependudukan(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_kependudukan_{$desa}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $baseQuery = DB::table('t_kartu_keluarga_anggota as t1')->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id');

            if ($desa !== 'all') {
                $baseQuery->where('t2.desa', $desa);
            }

            $totalPenduduk = $baseQuery->count();

            $totalKK = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t1.sts_hub_kel', 1)
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->count();

            $distribusiRTRW = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select(DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"), DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('t2.rt', 't2.rw')
                ->orderBy('t2.rt')
                ->orderBy('t2.rw')
                ->get();

            return response()->json([
                'total_penduduk' => $totalPenduduk,
                'total_kk' => $totalKK,
                'rata_anggota_kk' => $totalKK > 0 ? round($totalPenduduk / $totalKK, 1) : 0,
                'distribusi_rt_rw' => $distribusiRTRW,
            ]);
        });
    }

    // 2. Statistik Jenis Kelamin
    public function statsGender(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_gender_{$desa}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select('t1.jenkel', DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('t1.jenkel')
                ->get();

            $laki = $stats->where('jenkel', 1)->first()->jumlah ?? 0;
            $perempuan = $stats->where('jenkel', 2)->first()->jumlah ?? 0;

            return response()->json([
                'laki_laki' => $laki,
                'perempuan' => $perempuan,
                'total' => $laki + $perempuan,
                'rasio' => $perempuan > 0 ? round(($laki / $perempuan) * 100, 2) : 0,
                'chart_data' => [['label' => 'Laki-laki', 'value' => $laki], ['label' => 'Perempuan', 'value' => $perempuan]],
            ]);
        });
    }

    // 3. Statistik Umur
    public function statsUmur(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_umur_{$desa}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select(DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'), DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy(DB::raw('umur'))
                ->get();

            $kelompok = [
                '0-5 (Balita)' => 0,
                '6-12 (Anak)' => 0,
                '13-17 (Remaja)' => 0,
                '18-25' => 0,
                '26-45' => 0,
                '46-60' => 0,
                '60+ (Lansia)' => 0,
            ];

            foreach ($stats as $s) {
                match (true) {
                    $s->umur <= 5 => ($kelompok['0-5 (Balita)'] += $s->jumlah),
                    $s->umur <= 12 => ($kelompok['6-12 (Anak)'] += $s->jumlah),
                    $s->umur <= 17 => ($kelompok['13-17 (Remaja)'] += $s->jumlah),
                    $s->umur <= 25 => ($kelompok['18-25'] += $s->jumlah),
                    $s->umur <= 45 => ($kelompok['26-45'] += $s->jumlah),
                    $s->umur <= 60 => ($kelompok['46-60'] += $s->jumlah),
                    default => ($kelompok['60+ (Lansia)'] += $s->jumlah),
                };
            }

            return response()->json([
                'kelompok' => $kelompok,
                'chart_data' => collect($kelompok)
                    ->map(
                        fn($v, $k) => [
                            'label' => $k,
                            'value' => $v,
                        ],
                    )
                    ->values(),
                'produktif' => $kelompok['18-25'] + $kelompok['26-45'] + $kelompok['46-60'],
                'non_produktif' => array_sum($kelompok) - ($kelompok['18-25'] + $kelompok['26-45'] + $kelompok['46-60']),
                'lansia' => $kelompok['60+ (Lansia)'],
            ]);
        });
    }

    // 4. Statistik BPJS
    public function statsBPJS(Request $request)
    {
        $desa = $request->get('desa');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->when($desa, function ($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            });

        $total = $query->count();
        $punyaBPJS = (clone $query)->where('t1.punya_bpjs', 'ya')->count();
        $tidakPunyaBPJS = $total - $punyaBPJS;
        $persentase = $total > 0 ? round(($punyaBPJS / $total) * 100, 2) : 0;

        // Jenis BPJS
        $jenisBPJS = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select('t1.jenis_bpjs', DB::raw('COUNT(*) as jumlah'))
            ->where('t1.punya_bpjs', 'ya')
            ->when($desa, function ($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.jenis_bpjs')
            ->get();

        // Pembayaran BPJS
        $pembayaranBPJS = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select('t1.pembayaran_bpjs', DB::raw('COUNT(*) as jumlah'))
            ->where('t1.punya_bpjs', 'ya')
            ->when($desa, function ($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.pembayaran_bpjs')
            ->get();

        return response()->json([
            'punya_bpjs' => $punyaBPJS,
            'tidak_punya_bpjs' => $tidakPunyaBPJS,
            'persentase' => $persentase,
            'jenis_bpjs' => $jenisBPJS,
            'pembayaran_bpjs' => $pembayaranBPJS,
            'chart_data' => [['label' => 'Punya BPJS', 'value' => $punyaBPJS], ['label' => 'Tidak Punya BPJS', 'value' => $tidakPunyaBPJS]],
        ]);
    }

    public function statsPerDesa()
    {

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->select(
                't3.name as desa',
                't2.desa as desa_code',
                DB::raw('COUNT(DISTINCT t1.no_nik) as total_penduduk'),
                DB::raw('SUM(CASE WHEN t1.sts_hub_kel = 1 THEN 1 ELSE 0 END) as total_kk'),
                DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                DB::raw('SUM(CASE WHEN t1.punya_bpjs = "ya" THEN 1 ELSE 0 END) as punya_bpjs')
            )
            ->groupBy('t3.name', 't2.desa')
            ->orderBy('t3.name')
            ->get();

        return response()->json($stats);
    }

    public function statsGolDarah(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_gol_darah_{$desa}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('m_gol_darah as t4', 't4.id', '=', 't1.gol_darah')
                ->select('t4.nama as gol_darah', DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('t4.nama')
                ->get();

            return [
                'stats' => $stats,
                'chart_data' => $stats->map(
                    fn($i) => [
                        'label' => $i->gol_darah ?? 'Tidak Diketahui',
                        'value' => (int) $i->jumlah,
                    ],
                ),
            ];
        });

        return response()->json($data);
    }

    public function statsKepemilikanRumah(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_kepemilikan_rumah_{$desa}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select(DB::raw('COALESCE(t1.kepemilikan_rumah, "Tidak Diketahui") as kepemilikan_rumah'), DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('kepemilikan_rumah')
                ->orderBy('kepemilikan_rumah')
                ->get();

            $chartData = $stats
                ->map(
                    fn($item) => [
                        'label' => $item->kepemilikan_rumah,
                        'value' => (int) $item->jumlah,
                    ],
                )
                ->values();

            return [
                'stats' => $stats,
                'chart_data' => $chartData,
            ];
        });

        return response()->json($data);
    }

    public function statsPendapatan(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_pendapatan_{$desa}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select(DB::raw('COALESCE(t1.pendapatan_perbulan, "Tidak Diketahui") as pendapatan'), DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('pendapatan')
                ->orderBy('pendapatan')
                ->get();

            $chartData = $stats
                ->map(
                    fn($item) => [
                        'label' => $item->pendapatan,
                        'value' => (int) $item->jumlah,
                    ],
                )
                ->values();

            return [
                'stats' => $stats,
                'chart_data' => $chartData,
            ];
        });

        return response()->json($data);
    }

    public function statsPerkawinan(Request $request)
    {
        $desa = $request->get('desa') ?? 'all';
        $cacheKey = "stats_perkawinan_{$desa}";

        $data = Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desa) {
            $stats = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->select('t1.sts_perkawinan', 't1.status_kawin_tercatat', DB::raw('COUNT(*) as jumlah'))
                ->when($desa !== 'all', fn($q) => $q->where('t2.desa', $desa))
                ->groupBy('t1.sts_perkawinan', 't1.status_kawin_tercatat')
                ->get();

            $kawin = $stats->where('sts_perkawinan', 'KAWIN')->sum('jumlah');
            $belumKawin = $stats->where('sts_perkawinan', 'BELUM KAWIN')->sum('jumlah');
            $kawinTercatat = $stats->where('sts_perkawinan', 'KAWIN')->whereNotNull('status_kawin_tercatat')->sum('jumlah');

            return [
                'kawin' => (int) $kawin,
                'belum_kawin' => (int) $belumKawin,
                'kawin_tercatat' => (int) $kawinTercatat,
                'chart_data' => [['label' => 'Kawin', 'value' => (int) $kawin], ['label' => 'Belum Kawin', 'value' => (int) $belumKawin]],
            ];
        });

        return response()->json($data);
    }
}