<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PerkawinanController extends Controller
{
    public function index()
    {
        return view('admin.chart.perkawinan.perkawinan');
    }

    public function getData(Request $request)
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
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't1.sts_perkawinan',
                't1.status_kawin_tercatat',
            ]);

        // Filter berdasarkan request
        if ($request->has('rt_rw') && $request->rt_rw != '') {
            $query->whereRaw("CONCAT(t2.rt,'/',t2.rw) = ?", [$request->rt_rw]);
        }

        if ($request->has('kp') && $request->kp != '') {
            $query->where('t2.kp', $request->kp);
        }

        if ($request->has('jenkel') && $request->jenkel != '') {
            $query->where('t1.jenkel', $request->jenkel);
        }

        $data = $query->get();

        // Hitung statistik
        $statistics = $this->calculateStatistics($data);

        return response()->json([
            'success' => true,
            'data' => $data,
            'statistics' => $statistics
        ]);
    }

    public function getDataTable(Request $request)
    {
        $desaId = auth()->user()->desa;
        $kategori = $request->get('kategori', 'semua');

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
                't1.sts_perkawinan',
                't1.status_kawin_tercatat',
            ]);

        // Filter berdasarkan kategori
        switch ($kategori) {
            case 'belum_kawin':
                $query->where('t1.sts_perkawinan', 'BELUM KAWIN');
                break;
            case 'kawin':
                $query->where('t1.sts_perkawinan', 'KAWIN');
                break;
            case 'cerai_hidup':
                $query->where('t1.sts_perkawinan', 'CERAI HIDUP');
                break;
            case 'cerai_mati':
                $query->where('t1.sts_perkawinan', 'CERAI MATI');
                break;
            case 'kawin_tercatat':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->where('t1.status_kawin_tercatat', 'kawin_tercatat');
                break;
            case 'kawin_tidak_tercatat':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereNull('t1.status_kawin_tercatat');
                break;
            case 'usia_anak':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19');
                break;
            case 'belum_kawin_siap':
                $query->where('t1.sts_perkawinan', 'BELUM KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 19');
                break;
            case 'belum_kawin_belum_siap':
                $query->where('t1.sts_perkawinan', 'BELUM KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19');
                break;
            case 'kawin_usia_19_24':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 19 AND 24');
                break;
            case 'kawin_usia_25_34':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 34');
                break;
            case 'kawin_usia_35_49':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 35 AND 49');
                break;
            case 'kawin_usia_50_plus':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 50');
                break;
            case 'kawin_laki':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->where('t1.jenkel', 1);
                break;
            case 'kawin_perempuan':
                $query->where('t1.sts_perkawinan', 'KAWIN')
                    ->where('t1.jenkel', 2);
                break;
        }

        // Filter tambahan dari form
        if ($request->has('rt_rw') && $request->rt_rw != '') {
            $query->whereRaw("CONCAT(t2.rt,'/',t2.rw) = ?", [$request->rt_rw]);
        }

        if ($request->has('kp') && $request->kp != '') {
            $query->where('t2.kp', $request->kp);
        }

        if ($request->has('jenkel_filter') && $request->jenkel_filter != '') {
            $query->where('t1.jenkel', $request->jenkel_filter);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->editColumn('jenis_kelamin', function ($row) {
                return $row->jenkel == 1 ? 'L' : 'P';
            })
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->addColumn('status_tercatat', function ($row) {
                if ($row->sts_perkawinan === 'KAWIN') {
                    if ($row->status_kawin_tercatat) {
                        return '<span class="badge badge-success">Tercatat</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Tercatat</span>';
                    }
                }
                return '<span class="badge badge-secondary">-</span>';
            })
            ->addColumn('badge_status', function ($row) {
                $badges = [
                    'BELUM KAWIN' => '<span class="badge badge-warning">BELUM KAWIN</span>',
                    'KAWIN' => '<span class="badge badge-success">KAWIN</span>',
                    'CERAI HIDUP' => '<span class="badge badge-danger">CERAI HIDUP</span>',
                    'CERAI MATI' => '<span class="badge badge-secondary">CERAI MATI</span>',
                ];
                return $badges[$row->sts_perkawinan] ?? '<span class="badge badge-info">' . $row->sts_perkawinan . '</span>';
            })
            ->rawColumns(['status_tercatat', 'badge_status'])
            ->make(true);
    }

    private function calculateStatistics($data)
    {
        $total = $data->count();

        // 1. Status Perkawinan
        $statusPerkawinan = [
            'BELUM KAWIN' => $data->where('sts_perkawinan', 'BELUM KAWIN')->count(),
            'KAWIN' => $data->where('sts_perkawinan', 'KAWIN')->count(),
            'CERAI HIDUP' => $data->where('sts_perkawinan', 'CERAI HIDUP')->count(),
            'CERAI MATI' => $data->where('sts_perkawinan', 'CERAI MATI')->count(),
        ];

        // 2. Legalitas Perkawinan
        $kawinData = $data->where('sts_perkawinan', 'KAWIN');
        $legalitasPerkawinan = [
            'KAWIN TERCATAT' => $kawinData->where('status_kawin_tercatat', 'kawin_tercatat')->count(),
            'KAWIN TIDAK TERCATAT' => $kawinData->whereNull('status_kawin_tercatat')->count(),
        ];

        // 3. Usia Siap Kawin
        $belumKawin = $data->where('sts_perkawinan', 'BELUM KAWIN');
        $usiaSiapKawin = [
            'BELUM KAWIN USIA >= 19' => $belumKawin->where('umur', '>=', 19)->count(),
            'BELUM KAWIN USIA < 19' => $belumKawin->where('umur', '<', 19)->count(),
        ];

        // 4. Perkawinan Usia Anak
        $perkawinanUsiaAnak = $kawinData->where('umur', '<', 19)->count();
        $persenUsiaAnak = $kawinData->count() > 0 ? round(($perkawinanUsiaAnak / $kawinData->count()) * 100, 2) : 0;

        // 5. Perkawinan Berdasarkan Gender
        $perkawinanGender = [
            'LAKI-LAKI KAWIN' => $kawinData->where('jenkel', 1)->count(),
            'PEREMPUAN KAWIN' => $kawinData->where('jenkel', 2)->count(),
        ];

        // 6. Distribusi Usia Kawin
        $distribusiUsiaKawin = [
            '< 19' => $kawinData->where('umur', '<', 19)->count(),
            '19-24' => $kawinData->whereBetween('umur', [19, 24])->count(),
            '25-34' => $kawinData->whereBetween('umur', [25, 34])->count(),
            '35-49' => $kawinData->whereBetween('umur', [35, 49])->count(),
            '>= 50' => $kawinData->where('umur', '>=', 50)->count(),
        ];

        return [
            'total' => $total,
            'status_perkawinan' => $statusPerkawinan,
            'legalitas_perkawinan' => $legalitasPerkawinan,
            'usia_siap_kawin' => $usiaSiapKawin,
            'perkawinan_usia_anak' => [
                'jumlah' => $perkawinanUsiaAnak,
                'persentase' => $persenUsiaAnak
            ],
            'perkawinan_gender' => $perkawinanGender,
            'distribusi_usia_kawin' => $distribusiUsiaKawin
        ];
    }

    public function getFilterOptions()
    {
        $desaId = auth()->user()->desa;

        $rtRw = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->select(DB::raw("DISTINCT CONCAT(rt,'/',rw) AS rt_rw"))
            ->orderByRaw("CAST(rt AS UNSIGNED), CAST(rw AS UNSIGNED)")
            ->pluck('rt_rw');

        $kampung = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->distinct()
            ->pluck('kp');

        return response()->json([
            'success' => true,
            'rt_rw' => $rtRw,
            'kampung' => $kampung
        ]);
    }
}