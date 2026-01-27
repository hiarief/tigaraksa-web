<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AdminDesaController extends Controller
{
    public function index()
    {
        return view('admin.admin-desa.index');
    }

    public function getStatistics()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('users as u')
            ->join('indonesia_villages as v', 'v.code', '=', 'u.desa')
            ->leftJoin('t_kartu_keluarga as kk', 'kk.user_id', '=', 'u.id')
            ->leftJoin('t_kartu_keluarga_anggota as a', 'a.user_id', '=', 'u.id')
            ->where('u.desa', $desaId)
            ->groupBy('u.id', 'u.name', 'v.name')
            ->select(
                'u.name as nama_user',
                'v.name as nama_desa',
                DB::raw('COUNT(DISTINCT kk.id) as total_kk'),
                DB::raw('COUNT(DISTINCT a.id) as total_anggota')
            )
            ->get();

        // Summary statistics
        $summary = [
            'total_users' => $data->count(),
            'total_kk' => $data->sum('total_kk'),
            'total_anggota' => $data->sum('total_anggota'),
            'avg_kk_per_user' => $data->avg('total_kk'),
            'avg_anggota_per_user' => $data->avg('total_anggota'),
            'users_with_data' => $data->where('total_kk', '>', 0)->count(),
            'users_without_data' => $data->where('total_kk', 0)->count(),
        ];

        return response()->json([
            'success' => true,
            'summary' => $summary,
            'data' => $data
        ]);
    }

    public function getDatatables()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('users as u')
            ->join('indonesia_villages as v', 'v.code', '=', 'u.desa')
            ->leftJoin('t_kartu_keluarga as kk', 'kk.user_id', '=', 'u.id')
            ->leftJoin('t_kartu_keluarga_anggota as a', 'a.user_id', '=', 'u.id')
            ->where('u.desa', $desaId)
            ->groupBy('u.id', 'u.name', 'v.name')
            ->select(
                'u.id',
                'u.name as nama_user',
                'v.name as nama_desa',
                DB::raw('COUNT(DISTINCT kk.id) as total_kk'),
                DB::raw('COUNT(DISTINCT a.id) as total_anggota')
            );

        return DataTables::of($data)
            ->addColumn('status', function ($row) {
                if ($row->total_kk == 0) {
                    return '<span class="badge badge-danger">Belum Input Data</span>';
                } elseif ($row->total_kk < 50) {
                    return '<span class="badge badge-warning">Data Sedikit</span>';
                } elseif ($row->total_kk < 100) {
                    return '<span class="badge badge-info">Data Cukup</span>';
                } else {
                    return '<span class="badge badge-success">Data Lengkap</span>';
                }
            })
            ->addColumn('kategori', function ($row) {
                if ($row->total_kk == 0) {
                    return 'Tidak Aktif';
                } elseif ($row->total_kk < 100) {
                    return 'Aktif Rendah';
                } elseif ($row->total_kk < 150) {
                    return 'Aktif Sedang';
                } else {
                    return 'Aktif Tinggi';
                }
            })
            ->addColumn('avg_anggota_per_kk', function ($row) {
                return $row->total_kk > 0 ? number_format($row->total_anggota / $row->total_kk, 2) : 0;
            })
            ->editColumn('total_kk', function ($row) {
                return number_format($row->total_kk);
            })
            ->editColumn('total_anggota', function ($row) {
                return number_format($row->total_anggota);
            })
            ->rawColumns(['status'])
            ->make(true);
    }

    public function dataHilang()
    {

    }
}