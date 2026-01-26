<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PekerjaanController extends Controller
{
    public function index()
    {
        return view('admin.chart.pekerjaan.pekerjaan');
    }

    // API untuk KPI Cards (Enhanced)
    public function getKpiData()
    {
        $desaId = auth()->user()->desa;

        // Total Penduduk
        $totalPenduduk = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->count();

        // Usia Kerja (15-64 tahun)
        $usiaKerja = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
            ->count();

        // Pekerja Aktif (tidak termasuk belum bekerja, IRT, pelajar/mahasiswa)
        $pekerjaAktif = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
            ->whereNotNull('t1.jns_pekerjaan')
            ->where(function($q) {
                $q->whereNotIn(DB::raw('LOWER(t4.nama)'), [
                    'belum/tidak bekerja',
                    'mengurus rumah tangga',
                    'pelajar/mahasiswa',
                    '-'
                ])
                ->orWhereNull('t4.nama');
            })
            ->count();

        // Pengangguran (usia kerja yang belum/tidak bekerja, exclude IRT & Pelajar)
        $pengangguran = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
            ->where(function($q) {
                $q->whereRaw('LOWER(t4.nama) = ?', ['belum/tidak bekerja'])
                  ->orWhereNull('t1.jns_pekerjaan');
            })
            ->count();

        // Pendapatan Dominan
        $pendapatanDominan = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->whereNotNull('t1.pendapatan_perbulan')
            ->where('t1.pendapatan_perbulan', '>', 0)
            ->select(
                DB::raw("CASE
                    WHEN t1.pendapatan_perbulan < 1000000 THEN '0 - 1 Juta'
                    WHEN t1.pendapatan_perbulan >= 1000000 AND t1.pendapatan_perbulan < 2000000 THEN '1 - 2 Juta'
                    WHEN t1.pendapatan_perbulan >= 2000000 AND t1.pendapatan_perbulan < 5000000 THEN '2 - 5 Juta'
                    ELSE '> 5 Juta'
                END as kategori"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('kategori')
            ->orderBy('jumlah', 'DESC')
            ->first();

        // Tingkat Partisipasi Angkatan Kerja (TPAK)
        $tpak = $usiaKerja > 0 ? round((($pekerjaAktif + $pengangguran) / $usiaKerja) * 100, 1) : 0;

        return response()->json([
            'total_penduduk' => $totalPenduduk,
            'usia_kerja' => $usiaKerja,
            'pekerja_aktif' => $pekerjaAktif,
            'pengangguran' => $pengangguran,
            'persentase_pengangguran' => $usiaKerja > 0 ? round(($pengangguran / $usiaKerja) * 100, 1) : 0,
            'pendapatan_dominan' => $pendapatanDominan->kategori ?? 'Tidak Ada Data',
            'tpak' => $tpak
        ]);
    }

    // API untuk Distribusi Pekerjaan (Filtered)
    public function getDistribusiPekerjaan()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 15') // Usia kerja
            ->select(
                DB::raw('COALESCE(t4.nama, "Tidak Diketahui") as pekerjaan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('t4.nama')
            ->orderBy('jumlah', 'DESC')
            ->limit(10)
            ->get();

        return response()->json($data);
    }

    // API untuk Distribusi Pendapatan
    public function getDistribusiPendapatan()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 15')
            ->select(
                DB::raw("CASE
                    WHEN t1.pendapatan_perbulan IS NULL OR t1.pendapatan_perbulan = 0 THEN 'Tidak Ada Pendapatan'
                    WHEN t1.pendapatan_perbulan < 1000000 THEN '0 - 1 Juta'
                    WHEN t1.pendapatan_perbulan >= 1000000 AND t1.pendapatan_perbulan < 2000000 THEN '1 - 2 Juta'
                    WHEN t1.pendapatan_perbulan >= 2000000 AND t1.pendapatan_perbulan < 5000000 THEN '2 - 5 Juta'
                    ELSE '> 5 Juta'
                END as kategori"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('kategori')
            ->get();

        return response()->json($data);
    }

    // API untuk Pekerjaan vs Pendapatan
    public function getPekerjaanVsPendapatan()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 15')
            ->select(
                DB::raw('COALESCE(t4.nama, "Tidak Diketahui") as pekerjaan'),
                DB::raw("CASE
                    WHEN t1.pendapatan_perbulan IS NULL OR t1.pendapatan_perbulan = 0 THEN 'Tidak Ada'
                    WHEN t1.pendapatan_perbulan < 1000000 THEN '0-1 Juta'
                    WHEN t1.pendapatan_perbulan >= 1000000 AND t1.pendapatan_perbulan < 2000000 THEN '1-2 Juta'
                    WHEN t1.pendapatan_perbulan >= 2000000 AND t1.pendapatan_perbulan < 5000000 THEN '2-5 Juta'
                    ELSE '>5 Juta'
                END as pendapatan"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('pekerjaan', 'pendapatan')
            ->get();

        // Get top 8 pekerjaan
        $topPekerjaan = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 15')
            ->select(DB::raw('COALESCE(t4.nama, "Tidak Diketahui") as pekerjaan'), DB::raw('COUNT(*) as total'))
            ->groupBy('pekerjaan')
            ->orderBy('total', 'DESC')
            ->limit(8)
            ->pluck('pekerjaan');

        $pendapatans = ['Tidak Ada', '0-1 Juta', '1-2 Juta', '2-5 Juta', '>5 Juta'];

        $datasets = [];
        foreach ($pendapatans as $pendapatan) {
            $values = [];
            foreach ($topPekerjaan as $pekerjaan) {
                $item = $data->where('pekerjaan', $pekerjaan)
                            ->where('pendapatan', $pendapatan)
                            ->first();
                $values[] = $item ? $item->jumlah : 0;
            }
            $datasets[] = [
                'label' => $pendapatan,
                'data' => $values
            ];
        }

        return response()->json([
            'labels' => $topPekerjaan->values(),
            'datasets' => $datasets
        ]);
    }

    // API untuk Pekerjaan berdasarkan Gender (FIXED)
    public function getPekerjaanByGender()
    {
        $desaId = auth()->user()->desa;

        $rows = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 15')
            ->selectRaw("
                UPPER(TRIM(COALESCE(t4.nama, 'LAINNYA'))) AS pekerjaan,
                CASE
                    WHEN t1.jenkel = 1 THEN 'Laki-Laki'
                    WHEN t1.jenkel = 2 THEN 'Perempuan'
                    ELSE 'Tidak Diketahui'
                END AS jenkel,
                COUNT(*) AS jumlah
            ")
            ->groupBy('pekerjaan', 'jenkel')
            ->get();

        // Ambil TOP 8 pekerjaan berdasarkan total
        $labels = $rows
            ->groupBy('pekerjaan')
            ->map(fn($g) => $g->sum('jumlah'))
            ->sortDesc()
            ->take(8)
            ->keys()
            ->values();

        $laki = [];
        $perempuan = [];

        foreach ($labels as $p) {
            $laki[] = $rows
                ->firstWhere(fn($r) => $r->pekerjaan === $p && $r->jenkel === 'Laki-Laki')
                ->jumlah ?? 0;

            $perempuan[] = $rows
                ->firstWhere(fn($r) => $r->pekerjaan === $p && $r->jenkel === 'Perempuan')
                ->jumlah ?? 0;
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Laki-Laki',
                    'data' => $laki
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $perempuan
                ]
            ]
        ]);
    }



    // API untuk Pekerjaan by Usia (6 Kategori)
    public function getPekerjaanByUsia()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->select(
                DB::raw('COALESCE(t4.nama, "Tidak Diketahui") as pekerjaan'),
                DB::raw("CASE
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15 THEN 'Anak (<15)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 17 THEN 'Usia Sekolah (15-17)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 18 AND 24 THEN 'Produktif Awal (18-24)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 44 THEN 'Produktif Utama (25-44)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 45 AND 59 THEN 'Produktif Akhir (45-59)'
                    ELSE 'Lansia (≥60)'
                END as kategori_usia"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('pekerjaan', 'kategori_usia')
            ->get();

        // Get top 8 pekerjaan
        $topPekerjaan = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->select(DB::raw('COALESCE(t4.nama, "Tidak Diketahui") as pekerjaan'), DB::raw('COUNT(*) as total'))
            ->groupBy('pekerjaan')
            ->orderBy('total', 'DESC')
            ->limit(8)
            ->pluck('pekerjaan');

        $usiaCat = [
            'Anak (<15)',
            'Usia Sekolah (15-17)',
            'Produktif Awal (18-24)',
            'Produktif Utama (25-44)',
            'Produktif Akhir (45-59)',
            'Lansia (≥60)'
        ];

        $datasets = [];
        foreach ($usiaCat as $usia) {
            $values = [];
            foreach ($topPekerjaan as $pekerjaan) {
                $item = $data->where('pekerjaan', $pekerjaan)
                            ->where('kategori_usia', $usia)
                            ->first();
                $values[] = $item ? $item->jumlah : 0;
            }
            $datasets[] = [
                'label' => $usia,
                'data' => $values
            ];
        }

        return response()->json([
            'labels' => $topPekerjaan->values()->toArray(),
            'datasets' => $datasets
        ]);
    }

    // API untuk Piramida Penduduk (FIXED)
    public function getDistribusiUsia()
    {
        $desaId = auth()->user()->desa;

        $rows = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->selectRaw("
                CASE
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15 THEN 'Anak (<15)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 17 THEN 'Usia Sekolah (15-17)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 18 AND 24 THEN 'Produktif Awal (18-24)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 44 THEN 'Produktif Utama (25-44)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 45 AND 59 THEN 'Produktif Akhir (45-59)'
                    ELSE 'Lansia (≥60)'
                END AS kategori,
                CASE
                    WHEN t1.jenkel = 1 THEN 'Laki-Laki'
                    WHEN t1.jenkel = 2 THEN 'Perempuan'
                    ELSE 'Tidak Diketahui'
                END AS jenkel,
                COUNT(*) AS jumlah
            ")
            ->groupBy('kategori', 'jenkel')
            ->get();

        $kategoris = [
            'Anak (<15)',
            'Usia Sekolah (15-17)',
            'Produktif Awal (18-24)',
            'Produktif Utama (25-44)',
            'Produktif Akhir (45-59)',
            'Lansia (≥60)'
        ];

        $lakiLaki = [];
        $perempuan = [];

        foreach ($kategoris as $kategori) {
            $lakiLaki[] = -(
                $rows->firstWhere(fn($r) =>
                    $r->kategori === $kategori && $r->jenkel === 'Laki-Laki'
                )->jumlah ?? 0
            );

            $perempuan[] = (
                $rows->firstWhere(fn($r) =>
                    $r->kategori === $kategori && $r->jenkel === 'Perempuan'
                )->jumlah ?? 0
            );
        }

        return response()->json([
            'labels' => $kategoris,
            'datasets' => [
                [
                    'label' => 'Laki-Laki',
                    'data' => $lakiLaki
                ],
                [
                    'label' => 'Perempuan',
                    'data' => $perempuan
                ]
            ]
        ]);
    }


    // NEW: API untuk Perbandingan Status Pekerjaan
    public function getStatusPekerjaan()
    {
        $desaId = auth()->user()->desa;

        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('m_pekerjaan as t4', 't4.id', '=', 't1.jns_pekerjaan')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
            ->select(
                DB::raw("CASE
                    WHEN LOWER(t4.nama) = 'belum/tidak bekerja' OR t1.jns_pekerjaan IS NULL THEN 'Pengangguran'
                    WHEN LOWER(t4.nama) = 'mengurus rumah tangga' THEN 'Mengurus Rumah Tangga'
                    WHEN LOWER(t4.nama) LIKE '%pelajar%' OR LOWER(t4.nama) LIKE '%mahasiswa%' THEN 'Pelajar/Mahasiswa'
                    ELSE 'Bekerja'
                END as status"),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('status')
            ->get();

        return response()->json($data);
    }

    // NEW: API untuk Analisis Pendapatan Produktif
    public function getAnalisisPendapatanProduktif()
    {
        $desaId = auth()->user()->desa;

        // Pendapatan by Usia Produktif
        $data = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->where('t2.desa', $desaId)
            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
            ->where('t1.pendapatan_perbulan', '>', 0)
            ->select(
                DB::raw("CASE
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 24 THEN 'Muda (15-24)'
                    WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 44 THEN 'Produktif Utama (25-44)'
                    ELSE 'Menjelang Pensiun (45-64)'
                END as kategori_usia"),
                DB::raw('AVG(t1.pendapatan_perbulan) as rata_pendapatan'),
                DB::raw('MIN(t1.pendapatan_perbulan) as min_pendapatan'),
                DB::raw('MAX(t1.pendapatan_perbulan) as max_pendapatan'),
                DB::raw('COUNT(*) as jumlah')
            )
            ->groupBy('kategori_usia')
            ->get();

        return response()->json($data);
    }
}