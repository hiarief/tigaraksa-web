<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class BpjsController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function bpjs()
    {
        return view('admin.chart.bpjs.bpjs');
    }

    public function getStatistik()
    {
        $desaId = auth()->user()->desa;

        return Cache::remember("bpjs_statistik_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            // 1. STATISTIK DASAR KEPEMILIKAN
            $kepemilikan = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->select([
                    DB::raw('COUNT(*) as total_penduduk'),
                    DB::raw('SUM(CASE WHEN t1.punya_bpjs = "ya" THEN 1 ELSE 0 END) as punya_bpjs'),
                    DB::raw('SUM(CASE WHEN t1.punya_bpjs = "tidak" OR t1.punya_bpjs IS NULL THEN 1 ELSE 0 END) as tidak_punya_bpjs')
                ])
                ->first();

            $kepemilikan->persentase_punya = $kepemilikan->total_penduduk > 0
                ? round(($kepemilikan->punya_bpjs / $kepemilikan->total_penduduk) * 100, 2)
                : 0;

            // 2. JENIS BPJS (Hanya yang punya BPJS)
            $jenisBpjs = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.punya_bpjs', 'ya')
                ->whereNotNull('t1.jenis_bpjs')
                ->select([
                    't1.jenis_bpjs',
                    DB::raw('COUNT(*) as jumlah')
                ])
                ->groupBy('t1.jenis_bpjs')
                ->get();

            // 3. SUMBER PEMBAYARAN (Hanya yang punya BPJS)
            $pembayaran = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.punya_bpjs', 'ya')
                ->whereNotNull('t1.pembayaran_bpjs')
                ->select([
                    't1.pembayaran_bpjs',
                    DB::raw('COUNT(*) as jumlah')
                ])
                ->groupBy('t1.pembayaran_bpjs')
                ->get();

            // 4. KOMBINASI JENIS × PEMBAYARAN
            $kombinasi = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.punya_bpjs', 'ya')
                ->whereNotNull('t1.jenis_bpjs')
                ->whereNotNull('t1.pembayaran_bpjs')
                ->select([
                    't1.jenis_bpjs',
                    't1.pembayaran_bpjs',
                    DB::raw('COUNT(*) as jumlah')
                ])
                ->groupBy('t1.jenis_bpjs', 't1.pembayaran_bpjs')
                ->get();

            // 5. STATISTIK PER KARTU KELUARGA
            $statsKK = DB::table('t_kartu_keluarga as kk')
                ->where('kk.desa', $desaId)
                ->leftJoin('t_kartu_keluarga_anggota as anggota', 'kk.id', '=', 'anggota.no_kk')
                ->select([
                    'kk.id as no_kk',
                    DB::raw('COUNT(anggota.id) as total_anggota'),
                    DB::raw('SUM(CASE WHEN anggota.punya_bpjs = "ya" THEN 1 ELSE 0 END) as anggota_punya_bpjs')
                ])
                ->groupBy('kk.id')
                ->get();

            $kkSemua = $statsKK->where('total_anggota', '>', 0)->filter(function($kk) {
                return $kk->anggota_punya_bpjs == $kk->total_anggota;
            })->count();

            $kkSebagian = $statsKK->where('total_anggota', '>', 0)->filter(function($kk) {
                return $kk->anggota_punya_bpjs > 0 && $kk->anggota_punya_bpjs < $kk->total_anggota;
            })->count();

            $kkTidakAda = $statsKK->where('total_anggota', '>', 0)->filter(function($kk) {
                return $kk->anggota_punya_bpjs == 0;
            })->count();

            $kepemilikanKK = [
                'total_kk' => $statsKK->where('total_anggota', '>', 0)->count(),
                'kk_semua_punya' => $kkSemua,
                'kk_sebagian_punya' => $kkSebagian,
                'kk_tidak_ada' => $kkTidakAda
            ];

            // 6. VALIDASI & ANOMALI DATA
            $anomali = [
                'punya_tapi_null_jenis' => DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t2.desa', $desaId)
                    ->where('t1.punya_bpjs', 'ya')
                    ->whereNull('t1.jenis_bpjs')
                    ->count(),

                'tidak_punya_tapi_ada_jenis' => DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t2.desa', $desaId)
                    ->where('t1.punya_bpjs', 'tidak')
                    ->whereNotNull('t1.jenis_bpjs')
                    ->count(),

                'ada_jenis_null_pembayaran' => DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t2.desa', $desaId)
                    ->where('t1.punya_bpjs', 'ya')
                    ->whereNotNull('t1.jenis_bpjs')
                    ->whereNull('t1.pembayaran_bpjs')
                    ->count()
            ];

            return [
                'kepemilikan' => $kepemilikan,
                'jenis_bpjs' => $jenisBpjs,
                'pembayaran' => $pembayaran,
                'kombinasi' => $kombinasi,
                'kepemilikan_kk' => $kepemilikanKK,
                'anomali' => $anomali
            ];
        });
    }

    public function getDetailData(Request $request)
    {
        $desaId = auth()->user()->desa;
        $filter = $request->get('filter');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->where('t2.desa', $desaId)
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't1.punya_bpjs',
                't1.jenis_bpjs',
                't1.pembayaran_bpjs',
            ]);

        /** =========================
         * FILTER DATA
         * ========================= */
        if ($filter) {
            switch ($filter) {

                case 'punya_bpjs':
                    $query->where('t1.punya_bpjs', 'ya');
                    break;

                case 'tidak_punya_bpjs':
                    $query->where(function ($q) {
                        $q->where('t1.punya_bpjs', 'tidak')
                        ->orWhereNull('t1.punya_bpjs');
                    });
                    break;

                case 'anomali_punya_null_jenis':
                    $query->where('t1.punya_bpjs', 'ya')
                        ->whereNull('t1.jenis_bpjs');
                    break;

                case 'anomali_tidak_punya_ada_jenis':
                    $query->where('t1.punya_bpjs', 'tidak')
                        ->whereNotNull('t1.jenis_bpjs');
                    break;

                case 'anomali_ada_jenis_null_pembayaran':
                    $query->where('t1.punya_bpjs', 'ya')
                        ->whereNotNull('t1.jenis_bpjs')
                        ->whereNull('t1.pembayaran_bpjs');
                    break;

                default:
                    // Filter jenis_bpjs
                    if (str_starts_with($filter, 'jenis_')) {
                        $query->where('t1.jenis_bpjs', str_replace('jenis_', '', $filter));
                    }

                    // Filter pembayaran_bpjs
                    if (str_starts_with($filter, 'pembayaran_')) {
                        $query->where('t1.pembayaran_bpjs', str_replace('pembayaran_', '', $filter));
                    }

                    // Filter kombinasi
                    if (str_starts_with($filter, 'kombinasi_')) {
                        $value = str_replace('kombinasi_', '', $filter);
                        [$jenis, $pembayaran] = explode('|', $value);
                        $query->where('t1.jenis_bpjs', $jenis)
                            ->where('t1.pembayaran_bpjs', $pembayaran);
                    }
            }
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('no_kk', function ($row) {
                return $this->maskNumber($row->no_kk);
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->rawColumns(['punya_bpjs', 'jenis_bpjs', 'pembayaran_bpjs'])
            ->make(true);
    }

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
     * Method untuk clear cache ketika ada update data
     * Panggil method ini di controller yang handle CRUD
     */
    public function clearCache()
    {
        $desaId = auth()->user()->desa;

        Cache::forget("bpjs_statistik_{$desaId}");

        return response()->json(['message' => 'Cache cleared successfully']);
    }
}
