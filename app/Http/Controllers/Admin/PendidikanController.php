<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PendidikanController extends Controller
{
    public function pendidikan()
    {
        // Statistik berdasarkan pendidikan
        // $statistik = DB::table('t_kartu_keluarga_anggota as t1')
        //     ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
        //     ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
        //     ->where('t2.desa', $desaId)
        //     ->select([
        //         't1.pendidikan as pendidikan_id',
        //         DB::raw('COALESCE(t3.nama, "Tidak Ada Data") as pendidikan_nama'),
        //         DB::raw('COUNT(t1.no_nik) as jumlah'),
        //         DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
        //         DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan')
        //     ])
        //     ->groupBy('t1.pendidikan', 't3.nama')
        //     ->orderBy('jumlah', 'DESC')
        //     ->get();

        $statistik = DB::table('m_pendidikan_keluarga')->count();

        return view('admin.chart.pendidikan.pendidikan', compact('statistik'));
    }

    public function pendidikanDatatable(Request $request)
    {
        $desaId = auth()->user()->desa;

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
            ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
            ->where('t2.desa', $desaId)
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                DB::raw("
                    CASE
                        WHEN t1.jenkel = 1 THEN 'Laki-laki'
                        WHEN t1.jenkel = 2 THEN 'Perempuan'
                        ELSE '-'
                    END as jenkel
                "),
                't1.tgl_lahir',
                DB::raw("CONCAT(t2.rt,'/',t2.rw) as rt_rw"),
                't4.name as desa',
                't1.pendidikan'
            ]);

        if ($request->pendidikan_id !== null) {
            $query->where('t1.pendidikan', $request->pendidikan_id);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            // ->editColumn('tmpt_lahir', fn($row) => strtoupper($row->tmpt_lahir))
            ->editColumn('tgl_lahir', fn($row) => date('d-m-Y', strtotime($row->tgl_lahir)))
            ->make(true);
    }

    public function pendidikanJson()
    {
        $desaId = auth()->user()->desa;

        $statistik = Cache::remember("pendidikan_stats_{$desaId}", 300, function() use ($desaId) {
            return DB::table('t_kartu_keluarga_anggota as t1')
            // $statistik = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                ->where('t2.desa', $desaId)
                ->select(
                    't1.pendidikan as pendidikan_id',
                    DB::raw('COALESCE(t3.nama,"Tidak Ada Data") as pendidikan_nama'),
                    DB::raw('COUNT(*) as jumlah'),
                    DB::raw('SUM(t1.jenkel=1) as laki_laki'),
                    DB::raw('SUM(t1.jenkel=2) as perempuan')
                )
                ->groupBy('t1.pendidikan','t3.nama')
                ->orderBy('jumlah','DESC')
                ->get();
            });

        return response()->json([
            'total' => $statistik->sum('jumlah'),
            'statistik' => $statistik
        ]);
    }
}
