<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class KependudukanKecamatanContrroller extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index()
    {
        return view('admin.chart.kependudukan.kecamatan');
    }

    // Statistik Jumlah - Super cepat
    public function getJumlah()
    {
        return Cache::remember('kependudukan.jumlah', self::CACHE_TTL, function () {
            $totalPenduduk = DB::table('t_kartu_keluarga_anggota')->count();
            $totalKK = DB::table('t_kartu_keluarga')->count();
            $totalKepalaKeluarga = DB::table('t_kartu_keluarga_anggota')
                ->join('m_hubungan_keluarga', 't_kartu_keluarga_anggota.sts_hub_kel', '=', 'm_hubungan_keluarga.id')
                ->where('m_hubungan_keluarga.nama', 'KEPALA KELUARGA')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_penduduk' => $totalPenduduk,
                    'total_kk' => $totalKK,
                    'total_kepala_keluarga' => $totalKepalaKeluarga,
                    'total_anggota_keluarga' => $totalPenduduk - $totalKepalaKeluarga,
                ]
            ]);
        });
    }

    // Statistik Rasio
    public function getRasio()
    {
        return Cache::remember('kependudukan.rasio', self::CACHE_TTL, function () {
            $totalPenduduk = DB::table('t_kartu_keluarga_anggota')->count();
            $totalKK = DB::table('t_kartu_keluarga')->count();

            $produktif = DB::table('t_kartu_keluarga_anggota')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 59')
                ->count();

            $totalKepalaKeluarga = DB::table('t_kartu_keluarga_anggota')
                ->join('m_hubungan_keluarga', 't_kartu_keluarga_anggota.sts_hub_kel', '=', 'm_hubungan_keluarga.id')
                ->where('m_hubungan_keluarga.nama', 'KEPALA KELUARGA')
                ->count();

            $nonProduktif = $totalPenduduk - $produktif;
            $rataAnggotaKK = $totalKK > 0 ? round($totalPenduduk / $totalKK, 2) : 0;
            $rasioKepalaKeluarga = $totalPenduduk > 0 ? round(($totalKepalaKeluarga / $totalPenduduk) * 100, 2) : 0;
            $dependencyRatio = $produktif > 0 ? round(($nonProduktif / $produktif) * 100, 2) : 0;

            return response()->json([
                'success' => true,
                'data' => [
                    'rata_anggota_kk' => $rataAnggotaKK,
                    'rasio_kepala_keluarga' => $rasioKepalaKeluarga,
                    'dependency_ratio' => $dependencyRatio,
                ]
            ]);
        });
    }

    // Distribusi Desa
    public function getDistribusiDesa()
    {
        return Cache::remember('kependudukan.desa', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->join('indonesia_villages as t5', 't2.desa', '=', 't5.code')
                ->select('t5.name as desa', DB::raw('COUNT(*) as total'))
                ->groupBy('t5.name')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'desa');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }

    // Distribusi Hubungan Keluarga
    public function getDistribusiHubungan()
    {
        return Cache::remember('kependudukan.hubungan', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('m_hubungan_keluarga as t6', 't1.sts_hub_kel', '=', 't6.id')
                ->select('t6.nama as hubungan', DB::raw('COUNT(*) as total'))
                ->groupBy('t6.nama')
                ->orderByDesc('total')
                ->get()
                ->pluck('total', 'hubungan');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }

    // Distribusi Kelompok Umur
    public function getDistribusiUmur()
    {
        return Cache::remember('kependudukan.umur', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota')
                ->select(DB::raw("
                    CASE
                        WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 5 THEN 'Balita (0-4)'
                        WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 12 THEN 'Anak (5-11)'
                        WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 18 THEN 'Remaja (12-17)'
                        WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 60 THEN 'Produktif (18-59)'
                        ELSE 'Lansia (60+)'
                    END as kelompok,
                    COUNT(*) as total
                "))
                ->groupBy('kelompok')
                ->get()
                ->pluck('total', 'kelompok');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }

    // Produktif vs Non Produktif
    public function getProduktif()
    {
        return Cache::remember('kependudukan.produktif', self::CACHE_TTL, function () {
            $produktif = DB::table('t_kartu_keluarga_anggota')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 59')
                ->count();

            $nonProduktif = DB::table('t_kartu_keluarga_anggota')
                ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) NOT BETWEEN 18 AND 59')
                ->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'Produktif (18-59 tahun)' => $produktif,
                    'Non Produktif (<18 & 60+ tahun)' => $nonProduktif
                ]
            ]);
        });
    }

    // Distribusi Anggota per KK
    public function getDistribusiAnggotaKK()
    {
        return Cache::remember('kependudukan.anggota_kk', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota')
                ->select('no_kk', DB::raw('COUNT(*) as jumlah'))
                ->groupBy('no_kk')
                ->get()
                ->groupBy(function($item) {
                    $count = $item->jumlah;
                    if ($count == 1) return '1 orang';
                    if ($count == 2) return '2 orang';
                    if ($count <= 4) return '3-4 orang';
                    if ($count <= 6) return '5-6 orang';
                    return '7+ orang';
                })
                ->map(function($items) {
                    return $items->count();
                });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }

    // Pertumbuhan Bulanan - FIXED: dari tgl_lahir
    public function getPertumbuhan()
    {
        return Cache::remember('kependudukan.pertumbuhan', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota')
                ->select(DB::raw("
                    DATE_FORMAT(tgl_lahir, '%Y-%m') as bulan,
                    COUNT(*) as total
                "))
                ->where('tgl_lahir', '>=', DB::raw('DATE_SUB(CURDATE(), INTERVAL 12 MONTH)'))
                ->groupBy('bulan')
                ->orderBy('bulan')
                ->get()
                ->pluck('total', 'bulan');

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }

    // Distribusi Wilayah (Table)
    public function getDistribusiWilayah()
    {
        return Cache::remember('kependudukan.wilayah', self::CACHE_TTL, function () {
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->join('indonesia_villages as t5', 't2.desa', '=', 't5.code')
                ->select(
                    't5.name as desa',
                    DB::raw('COUNT(*) as penduduk'),
                    DB::raw('COUNT(DISTINCT t1.no_kk) as kk')
                )
                ->groupBy('t5.name')
                ->orderByDesc('penduduk')
                ->get()
                ->map(function($item) {
                    $item->rasio = $item->kk > 0 ? round($item->penduduk / $item->kk, 2) : 0;
                    return $item;
                });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        });
    }
}
