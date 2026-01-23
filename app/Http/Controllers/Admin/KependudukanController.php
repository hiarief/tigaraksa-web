<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class KependudukanController extends Controller
{
    public function index()
    {
        return view('admin.chart.kependudukan.kependudukan');
    }

    public function chartRwRt(Request $request)
    {
        $desaUser = auth()->user()->desa;

        $statistik = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaUser)
            ->selectRaw("
                COUNT(DISTINCT t1.no_nik) as total_nik,
                SUM(t1.jenkel = 1) as total_laki_laki,
                SUM(t1.jenkel = 2) as total_perempuan
            ")
            ->first();

        $data = DB::table('t_kartu_keluarga')
            ->select('rw', 'rt', DB::raw('COUNT(id) as total_kk'))
            ->where('desa', $desaUser)
            ->groupBy('rw', 'rt')
            ->orderBy('rw')
            ->orderBy('rt')
            ->get();

        // Group berdasarkan RW
        $groupedByRw = $data->groupBy('rw');

        // Buat labels untuk X-axis (RW)
        $labels = [];
        $rwData = [];

        foreach ($groupedByRw as $rw => $rts) {
            $labels[] = "RW {$rw}";
            $rwData[$rw] = $rts;
        }

        // Ambil semua RT unik untuk dijadikan datasets
        $allRts = $data->pluck('rt')->unique()->sort()->values();

        $colors = [
            'rgba(54, 162, 235, 0.8)',
            'rgba(75, 192, 192, 0.8)',
            'rgba(255, 206, 86, 0.8)',
            'rgba(153, 102, 255, 0.8)',
            'rgba(255, 99, 132, 0.8)',
            'rgba(255, 159, 64, 0.8)',
            'rgba(201, 203, 207, 0.8)',
        ];

        $datasets = [];
        $colorIndex = 0;

        // Setiap RT jadi 1 dataset
        foreach ($allRts as $rt) {
            $dataPerRw = [];

            foreach ($groupedByRw as $rw => $rts) {
                $found = $rts->firstWhere('rt', $rt);
                $dataPerRw[] = $found ? (int)$found->total_kk : 0;
            }

            $datasets[] = [
                'label' => "RT {$rt}",
                'data' => $dataPerRw,
                'backgroundColor' => $colors[$colorIndex % count($colors)],
            ];

            $colorIndex++;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => $datasets,
            'rwData' => $rwData,
            'total_nik' => $statistik->total_nik ?? 0,
            'total_laki_laki' => $statistik->total_laki_laki ?? 0,
            'total_perempuan' => $statistik->total_perempuan ?? 0,

        ]);
    }
}
