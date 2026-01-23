<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil list desa untuk filter
        $desaList = DB::table('indonesia_villages as t3')
            ->join('t_kartu_keluarga as t2', 't3.code', '=', 't2.desa')
            ->select('t3.code', 't3.name')
            ->distinct()
            ->orderBy('t3.name')
            ->get();

        return view('admin.dashboard.dashboard', compact('desaList'));
    }

    // 1. Statistik Kependudukan
    public function statsKependudukan(Request $request)
    {
        $desa = $request->get('desa');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa');

        if ($desa) {
            $query->where('t2.desa', $desa);
        }

        $totalPenduduk = $query->count();

        // Hitung Total KK berdasarkan sts_hub_kel = 1 (Kepala Keluarga)
        $totalKK = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t1.sts_hub_kel', 1)
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->count();

        $rataAnggotaKK = $totalKK > 0 ? round($totalPenduduk / $totalKK, 1) : 0;

        // Distribusi per RT/RW
        $distribusiRTRW = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select(
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t2.rt', 't2.rw')
            ->orderBy('t2.rt')
            ->orderBy('t2.rw')
            ->get();

        return response()->json([
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKK,
            'rata_anggota_kk' => $rataAnggotaKK,
            'distribusi_rt_rw' => $distribusiRTRW
        ]);
    }

    // 2. Statistik Jenis Kelamin
    public function statsGender(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select(
                't1.jenkel',
                DB::raw('COUNT(*) as jumlah')
            )
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.jenkel')
            ->get();

        $lakiLaki = $stats->where('jenkel', 1)->first()->jumlah ?? 0;
        $perempuan = $stats->where('jenkel', 2)->first()->jumlah ?? 0;
        $total = $lakiLaki + $perempuan;
        $rasio = $perempuan > 0 ? round(($lakiLaki / $perempuan) * 100, 2) : 0;

        return response()->json([
            'laki_laki' => $lakiLaki,
            'perempuan' => $perempuan,
            'total' => $total,
            'rasio' => $rasio,
            'chart_data' => [
                ['label' => 'Laki-laki', 'value' => $lakiLaki],
                ['label' => 'Perempuan', 'value' => $perempuan]
            ]
        ]);
    }

    // 3. Statistik Kelompok Umur
    public function statsUmur(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select(
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy(DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE())'))
            ->get();

        // Kelompokkan umur
        $kelompok = [
            '0-5 (Balita)' => 0,
            '6-12 (Anak)' => 0,
            '13-17 (Remaja)' => 0,
            '18-25' => 0,
            '26-45' => 0,
            '46-60' => 0,
            '60+ (Lansia)' => 0
        ];

        foreach ($stats as $stat) {
            $umur = $stat->umur;
            if ($umur >= 0 && $umur <= 5) $kelompok['0-5 (Balita)'] += $stat->jumlah;
            elseif ($umur >= 6 && $umur <= 12) $kelompok['6-12 (Anak)'] += $stat->jumlah;
            elseif ($umur >= 13 && $umur <= 17) $kelompok['13-17 (Remaja)'] += $stat->jumlah;
            elseif ($umur >= 18 && $umur <= 25) $kelompok['18-25'] += $stat->jumlah;
            elseif ($umur >= 26 && $umur <= 45) $kelompok['26-45'] += $stat->jumlah;
            elseif ($umur >= 46 && $umur <= 60) $kelompok['46-60'] += $stat->jumlah;
            elseif ($umur > 60) $kelompok['60+ (Lansia)'] += $stat->jumlah;
        }

        $chartData = [];
        foreach ($kelompok as $label => $value) {
            $chartData[] = ['label' => $label, 'value' => $value];
        }

        // Hitung produktif vs non-produktif
        $produktif = $kelompok['18-25'] + $kelompok['26-45'] + $kelompok['46-60'];
        $nonProduktif = $kelompok['0-5 (Balita)'] + $kelompok['6-12 (Anak)'] + $kelompok['13-17 (Remaja)'] + $kelompok['60+ (Lansia)'];

        return response()->json([
            'kelompok' => $kelompok,
            'chart_data' => $chartData,
            'produktif' => $produktif,
            'non_produktif' => $nonProduktif,
            'lansia' => $kelompok['60+ (Lansia)']
        ]);
    }

    // 4. Statistik Status Perkawinan
    public function statsPerkawinan(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select(
                't1.sts_perkawinan',
                't1.status_kawin_tercatat',
                DB::raw('COUNT(*) as jumlah')
            )
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.sts_perkawinan', 't1.status_kawin_tercatat')
            ->get();

        $kawin = $stats->where('sts_perkawinan', 'KAWIN')->sum('jumlah');
        $belumKawin = $stats->where('sts_perkawinan', 'BELUM KAWIN')->sum('jumlah');
        $kawinTercatat = $stats->whereNotNull('status_kawin_tercatat')->sum('jumlah');

        return response()->json([
            'kawin' => $kawin,
            'belum_kawin' => $belumKawin,
            'kawin_tercatat' => $kawinTercatat,
            'chart_data' => [
                ['label' => 'Kawin', 'value' => $kawin],
                ['label' => 'Belum Kawin', 'value' => $belumKawin]
            ]
        ]);
    }

    // 5. Statistik BPJS
    public function statsBPJS(Request $request)
    {
        $desa = $request->get('desa');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->when($desa, function($q) use ($desa) {
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
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.jenis_bpjs')
            ->get();

        // Pembayaran BPJS
        $pembayaranBPJS = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select('t1.pembayaran_bpjs', DB::raw('COUNT(*) as jumlah'))
            ->where('t1.punya_bpjs', 'ya')
            ->when($desa, function($q) use ($desa) {
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
            'chart_data' => [
                ['label' => 'Punya BPJS', 'value' => $punyaBPJS],
                ['label' => 'Tidak Punya BPJS', 'value' => $tidakPunyaBPJS]
            ]
        ]);
    }

    // 6. Statistik Pendapatan
    public function statsPendapatan(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select('t1.pendapatan_perbulan', DB::raw('COUNT(*) as jumlah'))
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.pendapatan_perbulan')
            ->get();

        $chartData = $stats->map(function($item) {
            return [
                'label' => $item->pendapatan_perbulan ?? 'Tidak Diketahui',
                'value' => $item->jumlah
            ];
        });

        return response()->json([
            'stats' => $stats,
            'chart_data' => $chartData
        ]);
    }

    // 7. Statistik Kepemilikan Rumah
    public function statsKepemilikanRumah(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->select('t1.kepemilikan_rumah', DB::raw('COUNT(*) as jumlah'))
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t1.kepemilikan_rumah')
            ->get();

        $chartData = $stats->map(function($item) {
            return [
                'label' => $item->kepemilikan_rumah ?? 'Tidak Diketahui',
                'value' => $item->jumlah
            ];
        });

        return response()->json([
            'stats' => $stats,
            'chart_data' => $chartData
        ]);
    }

    // 8. Statistik Golongan Darah
    public function statsGolDarah(Request $request)
    {
        $desa = $request->get('desa');

        $stats = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_gol_darah as t4', 't4.id', '=', 't1.gol_darah')
            ->select('t4.nama as gol_darah', DB::raw('COUNT(*) as jumlah'))
            ->when($desa, function($q) use ($desa) {
                return $q->where('t2.desa', $desa);
            })
            ->groupBy('t4.nama')
            ->get();

        $chartData = $stats->map(function($item) {
            return [
                'label' => $item->gol_darah ?? 'Tidak Diketahui',
                'value' => $item->jumlah
            ];
        });

        return response()->json([
            'stats' => $stats,
            'chart_data' => $chartData
        ]);
    }

    // 9. Statistik Per Desa (Summary)
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
}