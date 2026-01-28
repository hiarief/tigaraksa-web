<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class KepemilikanRumahController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function kepemilikanRumah()
    {
        return view('admin.chart.kepemilikan-rumah.kepemilikan-rumah');
    }

    // API untuk Chart - Statistik Dasar (Per NIK)
    public function getDistribusiPerNik()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_per_nik_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_hub_kel', 1)
                ->select('t1.kepemilikan_rumah', DB::raw('COUNT(*) as total'))
                ->groupBy('t1.kepemilikan_rumah')
                ->get();
        });

        return response()->json($data);
    }

    // API untuk Chart - Statistik Per KK (Status Rumah Dominan)
    public function getDistribusiPerKK()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_per_kk_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_hub_kel', 1)
                ->select('t1.kepemilikan_rumah', DB::raw('COUNT(DISTINCT t2.id) as total_kk'))
                ->groupBy('t1.kepemilikan_rumah')
                ->get();
        });

        return response()->json($data);
    }

    // API untuk Chart - Kerentanan Perumahan
    public function getKerentananPerumahan()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_kerentanan_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_hub_kel', 1)
                ->select(
                    DB::raw("CASE
                        WHEN t1.kepemilikan_rumah IN ('Ngontrak', 'Menumpang', 'Lainnya') THEN 'Rentan'
                        WHEN t1.kepemilikan_rumah = 'Orang Tua' THEN 'Semi Rentan'
                        WHEN t1.kepemilikan_rumah = 'Milik Sendiri' THEN 'Aman'
                        ELSE 'Tidak Diketahui'
                    END as kategori_kerentanan"),
                    DB::raw('COUNT(DISTINCT t2.id) as total_kk')
                )
                ->groupBy('kategori_kerentanan')
                ->get();
        });

        return response()->json($data);
    }

    // API untuk Chart - Kepemilikan Rumah × Umur KK
    public function getKepemilikanByUmur()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_by_umur_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_hub_kel', 1)
                ->select(
                    't1.kepemilikan_rumah',
                    DB::raw("CASE
                        WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 30 THEN '<30 Tahun'
                        WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 30 AND 45 THEN '30-45 Tahun'
                        WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 46 AND 60 THEN '46-60 Tahun'
                        ELSE '>60 Tahun'
                    END as kelompok_umur"),
                    DB::raw('COUNT(*) as total')
                )
                ->groupBy('t1.kepemilikan_rumah', 'kelompok_umur')
                ->get();
        });

        return response()->json($data);
    }

    // API untuk Chart - Distribusi Per RT/RW
    public function getDistribusiPerWilayah()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_per_wilayah_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_hub_kel', 1)
                ->select(
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't1.kepemilikan_rumah',
                    DB::raw('COUNT(DISTINCT t2.id) as total_kk')
                )
                ->groupBy('rt_rw', 't1.kepemilikan_rumah')
                ->orderBy('rt_rw')
                ->get();
        });

        return response()->json($data);
    }

    // API untuk Chart - Anomali Data
    public function getAnomaliData()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_anomali_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            // KK dengan status kepemilikan rumah berbeda dalam 1 KK
            $anomali = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->select('t2.id', DB::raw('COUNT(DISTINCT t1.kepemilikan_rumah) as jumlah_status'))
                ->groupBy('t2.id')
                ->having('jumlah_status', '>', 1)
                ->get()
                ->count();

            // Total KK
            $totalKK = DB::table('t_kartu_keluarga')
                ->where('desa', $desaId)
                ->count();

            // KK tanpa data kepemilikan
            $tanpaData = DB::table('t_kartu_keluarga as t2')
                ->leftJoin('t_kartu_keluarga_anggota as t1', 't2.id', '=', 't1.no_kk')
                ->where('t2.desa', $desaId)
                ->where(function($query) {
                    $query->whereNull('t1.kepemilikan_rumah')
                          ->orWhere('t1.kepemilikan_rumah', '');
                })
                ->distinct('t2.id')
                ->count('t2.id');

            return [
                ['kategori' => 'KK Normal', 'total' => $totalKK - $anomali - $tanpaData],
                ['kategori' => 'KK Anomali (>1 Status)', 'total' => $anomali],
                ['kategori' => 'KK Tanpa Data', 'total' => $tanpaData],
            ];
        });

        return response()->json($data);
    }

    // API untuk mendapatkan list RW dan RT
    public function getRwRtList()
    {
        $desaId = auth()->user()->desa;

        $data = Cache::remember("kepemilikan_rumah_rw_rt_list_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            $rwList = DB::table('t_kartu_keluarga')
                ->where('desa', $desaId)
                ->distinct()
                ->orderBy('rw')
                ->pluck('rw')
                ->filter()
                ->values();

            $rtList = DB::table('t_kartu_keluarga')
                ->where('desa', $desaId)
                ->distinct()
                ->orderBy('rt')
                ->pluck('rt')
                ->filter()
                ->values();

            return [
                'rw_list' => $rwList,
                'rt_list' => $rtList
            ];
        });

        return response()->json($data);
    }

    // API untuk mendapatkan RT berdasarkan RW
    public function getRtByRw(Request $request)
    {
        $desaId = auth()->user()->desa;
        $rw = $request->get('rw');

        $data = Cache::remember("kepemilikan_rumah_rt_by_rw_{$desaId}_{$rw}", self::CACHE_TTL, function() use ($desaId, $rw) {
            return DB::table('t_kartu_keluarga')
                ->where('desa', $desaId)
                ->where('rw', $rw)
                ->distinct()
                ->orderBy('rt')
                ->pluck('rt')
                ->filter()
                ->values();
        });

        return response()->json(['rt_list' => $data]);
    }

    // DataTables - Data Lengkap Kepala Keluarga
    public function getDataTable(Request $request)
    {
        $desaId = auth()->user()->desa;

        // Subquery untuk mendeteksi anomali KK
        $anomaliKK = DB::table('t_kartu_keluarga_anggota')
            ->select('no_kk', DB::raw('COUNT(DISTINCT kepemilikan_rumah) as jumlah_status'))
            ->groupBy('no_kk')
            ->havingRaw('COUNT(DISTINCT kepemilikan_rumah) > 1');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoinSub($anomaliKK, 'anomali', function($join) {
                $join->on('t2.id', '=', 'anomali.no_kk');
            })
            ->where('t2.desa', $desaId)
            ->where('t1.sts_hub_kel', 1)
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                't2.rt',
                't2.rw',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't1.kepemilikan_rumah',
                DB::raw('IF(anomali.jumlah_status > 1, "Anomali", "Normal") as status_anomali')
            ]);

        // Filter berdasarkan kepemilikan rumah
        if ($request->has('kepemilikan') && $request->kepemilikan != '') {
            $query->where('t1.kepemilikan_rumah', $request->kepemilikan);
        }

        // Filter berdasarkan kerentanan
        if ($request->has('kerentanan') && $request->kerentanan != '') {
            if ($request->kerentanan == 'Rentan') {
                $query->whereIn('t1.kepemilikan_rumah', ['Ngontrak', 'Menumpang', 'Lainnya']);
            } elseif ($request->kerentanan == 'Semi Rentan') {
                $query->where('t1.kepemilikan_rumah', 'Orang Tua');
            } elseif ($request->kerentanan == 'Aman') {
                $query->where('t1.kepemilikan_rumah', 'Milik Sendiri');
            }
        }

        // Filter berdasarkan RW
        if ($request->has('rw') && $request->rw != '') {
            $query->where('t2.rw', $request->rw);
        }

        // Filter berdasarkan RT
        if ($request->has('rt') && $request->rt != '') {
            $query->where('t2.rt', $request->rt);
        }

        // Filter berdasarkan anomali
        if ($request->has('anomali') && $request->anomali != '') {
            if ($request->anomali == 'anomali') {
                $query->havingRaw('status_anomali = "Anomali"');
            } elseif ($request->anomali == 'normal') {
                $query->havingRaw('status_anomali = "Normal"');
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
            ->editColumn('jenkel', function ($row) {
                return $row->jenkel == 1 ? 'L' : 'P';
            })
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->editColumn('status_anomali', function ($row) {
                if ($row->status_anomali == 'Anomali') {
                    return '<span class="badge badge-danger">Anomali</span>';
                }
                return '<span class="badge badge-success">Normal</span>';
            })
            ->rawColumns(['status_anomali'])
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

        $cacheKeys = [
            "kepemilikan_rumah_per_nik_{$desaId}",
            "kepemilikan_rumah_per_kk_{$desaId}",
            "kepemilikan_rumah_kerentanan_{$desaId}",
            "kepemilikan_rumah_by_umur_{$desaId}",
            "kepemilikan_rumah_per_wilayah_{$desaId}",
            "kepemilikan_rumah_anomali_{$desaId}",
            "kepemilikan_rumah_rw_rt_list_{$desaId}",
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        // Clear cache RT by RW (semua RW)
        $rwList = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->distinct()
            ->pluck('rw')
            ->filter();

        foreach ($rwList as $rw) {
            Cache::forget("kepemilikan_rumah_rt_by_rw_{$desaId}_{$rw}");
        }

        return response()->json(['message' => 'Cache cleared successfully']);
    }
}
