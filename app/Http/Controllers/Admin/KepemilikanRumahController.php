<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class KepemilikanRumahController extends Controller
{
    public function kepemilikanRumah()
    {
        return view('admin.chart.kepemilikan-rumah.kepemilikan-rumah');
    }

    // API untuk Chart - Statistik Dasar (Per NIK)
    public function getDistribusiPerNik()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->where('t1.sts_hub_kel', 1)
            ->select('t1.kepemilikan_rumah', DB::raw('COUNT(*) as total'))
            ->groupBy('t1.kepemilikan_rumah')
            ->get();

        return response()->json($data);
    }

    // API untuk Chart - Statistik Per KK (Status Rumah Dominan)
    public function getDistribusiPerKK()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->where('t1.sts_hub_kel', 1)
            ->select('t1.kepemilikan_rumah', DB::raw('COUNT(DISTINCT t2.id) as total_kk'))
            ->groupBy('t1.kepemilikan_rumah')
            ->get();

        return response()->json($data);
    }

    // API untuk Chart - Kerentanan Perumahan
    public function getKerentananPerumahan()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
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

        return response()->json($data);
    }

    // API untuk Chart - Kepemilikan Rumah × Umur KK
    public function getKepemilikanByUmur()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
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

        return response()->json($data);
    }

    // API untuk Chart - Distribusi Per RT/RW
    public function getDistribusiPerWilayah()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
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

        return response()->json($data);
    }

    // API untuk Chart - Anomali Data
    public function getAnomaliData()
    {
        $desaId = auth()->user()->desa;

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

        $data = [
            ['kategori' => 'KK Normal', 'total' => $totalKK - $anomali - $tanpaData],
            ['kategori' => 'KK Anomali (>1 Status)', 'total' => $anomali],
            ['kategori' => 'KK Tanpa Data', 'total' => $tanpaData],
        ];

        return response()->json($data);
    }

    // API untuk mendapatkan list RW dan RT
    public function getRwRtList()
    {
        $desaId = auth()->user()->desa;

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

        return response()->json([
            'rw_list' => $rwList,
            'rt_list' => $rtList
        ]);
    }

    // API untuk mendapatkan RT berdasarkan RW
    public function getRtByRw(Request $request)
    {
        $desaId = auth()->user()->desa;
        $rw = $request->get('rw');

        $rtList = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->where('rw', $rw)
            ->distinct()
            ->orderBy('rt')
            ->pluck('rt')
            ->filter()
            ->values();

        return response()->json(['rt_list' => $rtList]);
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

    // // Export to Excel
    // public function export(Request $request)
    // {
    //     $desaId = auth()->user()->desa;

    //     // Subquery untuk mendeteksi anomali KK
    //     $anomaliKK = DB::table('t_kartu_keluarga_anggota')
    //         ->select('no_kk', DB::raw('COUNT(DISTINCT kepemilikan_rumah) as jumlah_status'))
    //         ->groupBy('no_kk')
    //         ->havingRaw('COUNT(DISTINCT kepemilikan_rumah) > 1');

    //     $query = DB::table('t_kartu_keluarga_anggota as t1')
    //         ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
    //         ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
    //         ->leftJoinSub($anomaliKK, 'anomali', function($join) {
    //             $join->on('t2.id', '=', 'anomali.no_kk');
    //         })
    //         ->where('t2.desa', $desaId)
    //         ->where('t1.sts_hub_kel', 1)
    //         ->select([
    //             't1.no_nik',
    //             't1.nama',
    //             't2.no_kk',
    //             't2.kp',
    //             't1.jenkel',
    //             't1.tgl_lahir',
    //             't2.rt',
    //             't2.rw',
    //             DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
    //             't3.name AS desa',
    //             't1.kepemilikan_rumah',
    //             DB::raw('IF(anomali.jumlah_status > 1, "Anomali", "Normal") as status_anomali')
    //         ]);

    //     // Apply filters
    //     if ($request->has('kepemilikan') && $request->kepemilikan != '') {
    //         $query->where('t1.kepemilikan_rumah', $request->kepemilikan);
    //     }

    //     if ($request->has('kerentanan') && $request->kerentanan != '') {
    //         if ($request->kerentanan == 'Rentan') {
    //             $query->whereIn('t1.kepemilikan_rumah', ['Ngontrak', 'Menumpang', 'Lainnya']);
    //         } elseif ($request->kerentanan == 'Semi Rentan') {
    //             $query->where('t1.kepemilikan_rumah', 'Orang Tua');
    //         } elseif ($request->kerentanan == 'Aman') {
    //             $query->where('t1.kepemilikan_rumah', 'Milik Sendiri');
    //         }
    //     }

    //     if ($request->has('rw') && $request->rw != '') {
    //         $query->where('t2.rw', $request->rw);
    //     }

    //     if ($request->has('rt') && $request->rt != '') {
    //         $query->where('t2.rt', $request->rt);
    //     }

    //     if ($request->has('anomali') && $request->anomali != '') {
    //         if ($request->anomali == 'anomali') {
    //             $query->havingRaw('status_anomali = "Anomali"');
    //         } elseif ($request->anomali == 'normal') {
    //             $query->havingRaw('status_anomali = "Normal"');
    //         }
    //     }

    //     $data = $query->get();

    //     // Generate Excel file
    //     $filename = 'kepemilikan_rumah_' . date('YmdHis') . '.xlsx';

    //     // You can use Laravel Excel package here
    //     // return Excel::download(new KepemilikanRumahExport($data), $filename);

    //     // For now, return JSON (you need to implement Excel export)
    //     return response()->json(['message' => 'Export feature needs Laravel Excel package']);
    // }
}