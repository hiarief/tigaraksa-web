<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class UmurController extends Controller
{
    private const CACHE_TTL = 7200;

    public function umur()
    {
        return view('admin.chart.umur.umur');
    }

    public function getDataUmur()
    {
        $desaId = auth()->user()->desa;
        $cacheKey = "data_umur_{$desaId}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desaId) {
            // Data per kelompok umur
            $kelompokUmur = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->select([
                    DB::raw("
                        CASE
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 0 AND 4 THEN '0-4'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 5 AND 9 THEN '5-9'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 10 AND 14 THEN '10-14'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 19 THEN '15-19'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 20 AND 24 THEN '20-24'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 29 THEN '25-29'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 30 AND 34 THEN '30-34'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 35 AND 39 THEN '35-39'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 40 AND 44 THEN '40-44'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 45 AND 49 THEN '45-49'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 50 AND 54 THEN '50-54'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 55 AND 59 THEN '55-59'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 60 AND 64 THEN '60-64'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 65 AND 69 THEN '65-69'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 70 AND 74 THEN '70-74'
                            ELSE '75+'
                        END AS kelompok_umur
                    "),
                    't1.jenkel',
                    DB::raw('COUNT(*) as jumlah')
                ])
                ->groupBy('kelompok_umur', 't1.jenkel')
                ->orderByRaw("
                    CASE kelompok_umur
                        WHEN '0-4' THEN 1
                        WHEN '5-9' THEN 2
                        WHEN '10-14' THEN 3
                        WHEN '15-19' THEN 4
                        WHEN '20-24' THEN 5
                        WHEN '25-29' THEN 6
                        WHEN '30-34' THEN 7
                        WHEN '35-39' THEN 8
                        WHEN '40-44' THEN 9
                        WHEN '45-49' THEN 10
                        WHEN '50-54' THEN 11
                        WHEN '55-59' THEN 12
                        WHEN '60-64' THEN 13
                        WHEN '65-69' THEN 14
                        WHEN '70-74' THEN 15
                        ELSE 16
                    END
                ")
                ->get();

            // Data pemilih (17+ tahun)
            $pemilih = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->where('t2.desa', $desaId)
                ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 17')
                ->select([
                    DB::raw("
                        CASE
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 17 AND 19 THEN '17-19'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 20 AND 24 THEN '20-24'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 29 THEN '25-29'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 30 AND 34 THEN '30-34'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 35 AND 39 THEN '35-39'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 40 AND 44 THEN '40-44'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 45 AND 49 THEN '45-49'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 50 AND 54 THEN '50-54'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 55 AND 59 THEN '55-59'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 60 AND 64 THEN '60-64'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 65 AND 69 THEN '65-69'
                            WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 70 AND 74 THEN '70-74'
                            ELSE '75+'
                        END AS kelompok_umur
                    "),
                    't1.jenkel',
                    DB::raw('COUNT(*) as jumlah')
                ])
                ->groupBy('kelompok_umur', 't1.jenkel')
                ->orderByRaw("
                    CASE kelompok_umur
                        WHEN '17-19' THEN 1
                        WHEN '20-24' THEN 2
                        WHEN '25-29' THEN 3
                        WHEN '30-34' THEN 4
                        WHEN '35-39' THEN 5
                        WHEN '40-44' THEN 6
                        WHEN '45-49' THEN 7
                        WHEN '50-54' THEN 8
                        WHEN '55-59' THEN 9
                        WHEN '60-64' THEN 10
                        WHEN '65-69' THEN 11
                        WHEN '70-74' THEN 12
                        ELSE 13
                    END
                ")
                ->get();

            return response()->json([
                'kelompok_umur' => $kelompokUmur,
                'pemilih' => $pemilih
            ]);
        });
    }

    // Method baru untuk DataTables
    public function getDataPemilih(Request $request)
    {
        $desaId = auth()->user()->desa;

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 17')
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                't2.kp',
                't2.rt',
                't2.rw',
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa'
            ]);

        // Filter RW
        if ($request->filled('rw')) {
            $query->where('t2.rw', $request->rw);
        }

        // Filter RT
        if ($request->filled('rt')) {
            $query->where('t2.rt', $request->rt);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('no_kk', function ($row) {
                return $this->maskNumber($row->no_kk);
            })
            ->editColumn('jenkel', function ($row) {
                return match ($row->jenkel) {
                    1 => 'L',
                    2 => 'P',
                    default => '-',
                };
            })
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->editColumn('umur', function ($row) {
                return  $row->umur . ' tahun';
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->rawColumns(['tgl_lahir'])
            ->make(true);
    }

    public function getDataSemua(Request $request)
    {
        $desaId = auth()->user()->desa;

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->where('t2.desa', $desaId)
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                't2.kp',
                't2.rt',
                't2.rw',
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa'
            ]);

        // Filter RW
        if ($request->filled('rw')) {
            $query->where('t2.rw', $request->rw);
        }

        // Filter RT
        if ($request->filled('rt')) {
            $query->where('t2.rt', $request->rt);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('no_kk', function ($row) {
                return $this->maskNumber($row->no_kk);
            })
            ->editColumn('jenkel', function ($row) {
                return match ($row->jenkel) {
                    1 => 'L',
                    2 => 'P',
                    default => '-',
                };
            })
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->editColumn('umur', function ($row) {
                return  $row->umur . ' tahun';
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->rawColumns(['tgl_lahir'])
            ->make(true);
    }

    // Method untuk mendapatkan list RW
    public function getRwList()
    {
        $desaId = auth()->user()->desa;
        $cacheKey = "rw_list_{$desaId}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desaId) {
            $rwList = DB::table('t_kartu_keluarga')
                ->where('desa', $desaId)
                ->select('rw')
                ->distinct()
                ->orderBy('rw')
                ->pluck('rw');

            return response()->json($rwList);
        });
    }

    // Method untuk mendapatkan list RT berdasarkan RW
    public function getRtList(Request $request)
    {
        $desaId = auth()->user()->desa;
        $rw = $request->rw ?? 'all';
        $cacheKey = "rt_list_{$desaId}_{$rw}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($desaId, $request) {
            $query = DB::table('t_kartu_keluarga')
                ->where('desa', $desaId);

            if ($request->has('rw') && $request->rw != '') {
                $query->where('rw', $request->rw);
            }

            $rtList = $query->select('rt')
                ->distinct()
                ->orderBy('rt')
                ->pluck('rt');

            return response()->json($rtList);
        });
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
}
