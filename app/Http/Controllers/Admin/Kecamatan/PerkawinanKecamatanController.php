<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class PerkawinanKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index()
    {
        return view('admin.chart.perkawinan.kecamatan');
    }

    /**
     * Statistik Jumlah Total
     */
    public function jumlah()
    {
        return Cache::remember('perkawinan.jumlah', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->select([
                        DB::raw('COUNT(DISTINCT t1.no_nik) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "KAWIN" THEN 1 ELSE 0 END) as total_kawin'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI HIDUP" THEN 1 ELSE 0 END) as total_cerai_hidup'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI MATI" THEN 1 ELSE 0 END) as total_cerai_mati'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "BELUM KAWIN" THEN 1 ELSE 0 END) as total_belum_kawin'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tercatat" THEN 1 ELSE 0 END) as total_kawin_tercatat'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tidak_tercatat" THEN 1 ELSE 0 END) as total_kawin_tidak_tercatat'),
                    ])
                    ->first();

                // Hitung data abnormal
                $abnormal = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where(function($query) {
                        // Status kawin tapi tidak ada keterangan tercatat
                        $query->where('t1.sts_perkawinan', 'KAWIN')
                              ->whereNull('t1.status_kawin_tercatat');
                    })
                    ->orWhere(function($query) {
                        // Status belum kawin tapi ada keterangan tercatat
                        $query->where('t1.sts_perkawinan', 'BELUM KAWIN')
                              ->whereNotNull('t1.status_kawin_tercatat');
                    })
                    ->orWhere(function($query) {
                        // Status cerai tapi masih ada keterangan kawin tercatat
                        $query->whereIn('t1.sts_perkawinan', ['CERAI HIDUP', 'CERAI MATI'])
                              ->whereNotNull('t1.status_kawin_tercatat');
                    })
                    ->count();

                return response()->json([
                    'success' => true,
                    'data' => [
                        'total_penduduk' => (int) $data->total_penduduk,
                        'total_kawin' => (int) $data->total_kawin,
                        'total_cerai_hidup' => (int) $data->total_cerai_hidup,
                        'total_cerai_mati' => (int) $data->total_cerai_mati,
                        'total_belum_kawin' => (int) $data->total_belum_kawin,
                        'total_kawin_tercatat' => (int) $data->total_kawin_tercatat,
                        'total_kawin_tidak_tercatat' => (int) $data->total_kawin_tidak_tercatat,
                        'total_abnormal' => (int) $abnormal,
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Statistik Rasio & Persentase
     */
    public function rasio()
    {
        return Cache::remember('perkawinan.rasio', self::CACHE_TTL, function () {
            try {
                $total = DB::table('t_kartu_keluarga_anggota')->count();

                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->select([
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "KAWIN" THEN 1 ELSE 0 END) as kawin'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI HIDUP" THEN 1 ELSE 0 END) as cerai_hidup'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI MATI" THEN 1 ELSE 0 END) as cerai_mati'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tercatat" THEN 1 ELSE 0 END) as tercatat'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tidak_tercatat" THEN 1 ELSE 0 END) as tidak_tercatat'),
                    ])
                    ->first();

                $persentase_kawin = $total > 0 ? number_format(($data->kawin / $total) * 100, 1) : 0;
                $persentase_cerai = $total > 0 ? number_format((($data->cerai_hidup + $data->cerai_mati) / $total) * 100, 1) : 0;

                $total_kawin = $data->kawin;
                $rasio_tercatat = $total_kawin > 0 ? number_format(($data->tercatat / $total_kawin) * 100, 1) : 0;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'persentase_kawin' => $persentase_kawin,
                        'persentase_cerai' => $persentase_cerai,
                        'rasio_tercatat' => $rasio_tercatat,
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Status Perkawinan
     */
    public function distribusiStatus()
    {
        return Cache::remember('perkawinan.distribusi_status', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->select('t1.sts_perkawinan', DB::raw('COUNT(*) as total'))
                    ->groupBy('t1.sts_perkawinan')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $status = $item->sts_perkawinan ?: 'Tidak Diketahui';
                    $result[$status] = (int) $item->total;
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Status Kawin Tercatat
     */
    public function distribusiTercatat()
    {
        return Cache::remember('perkawinan.distribusi_tercatat', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select('t1.status_kawin_tercatat', DB::raw('COUNT(*) as total'))
                    ->groupBy('t1.status_kawin_tercatat')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    if ($item->status_kawin_tercatat == 'kawin_tercatat') {
                        $result['Kawin Tercatat'] = (int) $item->total;
                    } elseif ($item->status_kawin_tercatat == 'kawin_tidak_tercatat') {
                        $result['Kawin Tidak Tercatat'] = (int) $item->total;
                    } else {
                        $result['Tidak Ada Keterangan'] = (int) $item->total;
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Per Desa
     */
    public function distribusiDesa()
    {
        return Cache::remember('perkawinan.distribusi_desa', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select('t3.name as desa', DB::raw('COUNT(*) as total'))
                    ->groupBy('t3.name')
                    ->orderBy('total', 'DESC')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $desa = $item->desa ?: 'Tidak Diketahui';
                    $result[$desa] = (int) $item->total;
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Berdasarkan Jenis Kelamin
     */
    public function distribusiJenkel()
    {
        return Cache::remember('perkawinan.distribusi_jenkel', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select('t1.jenkel', DB::raw('COUNT(*) as total'))
                    ->groupBy('t1.jenkel')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    if ($item->jenkel == 1) {
                        $result['Laki-laki'] = (int) $item->total;
                    } elseif ($item->jenkel == 2) {
                        $result['Perempuan'] = (int) $item->total;
                    }
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Berdasarkan Kelompok Umur (yang sudah menikah)
     */
    public function distribusiUmur()
    {
        return Cache::remember('perkawinan.distribusi_umur', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select([
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19 THEN 1 ELSE 0 END) as kurang_19'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 19 AND 25 THEN 1 ELSE 0 END) as umur_19_25'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 26 AND 35 THEN 1 ELSE 0 END) as umur_26_35'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 36 AND 45 THEN 1 ELSE 0 END) as umur_36_45'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 46 AND 55 THEN 1 ELSE 0 END) as umur_46_55'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) > 55 THEN 1 ELSE 0 END) as lebih_55'),
                    ])
                    ->first();

                $result = [
                    '< 19 tahun' => (int) $data->kurang_19,
                    '19-25 tahun' => (int) $data->umur_19_25,
                    '26-35 tahun' => (int) $data->umur_26_35,
                    '36-45 tahun' => (int) $data->umur_36_45,
                    '46-55 tahun' => (int) $data->umur_46_55,
                    '> 55 tahun' => (int) $data->lebih_55,
                ];

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Data Abnormal
     */
    public function dataAbnormal()
    {
        return Cache::remember('perkawinan.data_abnormal', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select([
                        't3.name as desa',
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "KAWIN" AND t1.status_kawin_tercatat IS NULL THEN 1 ELSE 0 END) as kawin_tanpa_keterangan'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "BELUM KAWIN" AND t1.status_kawin_tercatat IS NOT NULL THEN 1 ELSE 0 END) as belum_kawin_ada_keterangan'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan IN ("CERAI HIDUP", "CERAI MATI") AND t1.status_kawin_tercatat IS NOT NULL THEN 1 ELSE 0 END) as cerai_ada_keterangan'),
                    ])
                    ->groupBy('t3.name')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $desa = $item->desa ?: 'Tidak Diketahui';
                    $result[] = [
                        'desa' => $desa,
                        'kawin_tanpa_keterangan' => (int) $item->kawin_tanpa_keterangan,
                        'belum_kawin_ada_keterangan' => (int) $item->belum_kawin_ada_keterangan,
                        'cerai_ada_keterangan' => (int) $item->cerai_ada_keterangan,
                        'total_abnormal' => (int) ($item->kawin_tanpa_keterangan + $item->belum_kawin_ada_keterangan + $item->cerai_ada_keterangan),
                    ];
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Tabel Detail Per Desa
     */
    public function detailPerDesa()
    {
        return Cache::remember('perkawinan.detail_per_desa', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select([
                        't3.name as desa',
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "KAWIN" THEN 1 ELSE 0 END) as kawin'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "BELUM KAWIN" THEN 1 ELSE 0 END) as belum_kawin'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI HIDUP" THEN 1 ELSE 0 END) as cerai_hidup'),
                        DB::raw('SUM(CASE WHEN t1.sts_perkawinan = "CERAI MATI" THEN 1 ELSE 0 END) as cerai_mati'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tercatat" THEN 1 ELSE 0 END) as tercatat'),
                        DB::raw('SUM(CASE WHEN t1.status_kawin_tercatat = "kawin_tidak_tercatat" THEN 1 ELSE 0 END) as tidak_tercatat'),
                    ])
                    ->groupBy('t3.name')
                    ->orderBy('total_penduduk', 'DESC')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $total_kawin = (int) $item->kawin;
                    $persentase_tercatat = $total_kawin > 0 ? number_format(($item->tercatat / $total_kawin) * 100, 1) : 0;

                    $result[] = [
                        'desa' => $item->desa ?: 'Tidak Diketahui',
                        'total_penduduk' => (int) $item->total_penduduk,
                        'kawin' => (int) $item->kawin,
                        'belum_kawin' => (int) $item->belum_kawin,
                        'cerai_hidup' => (int) $item->cerai_hidup,
                        'cerai_mati' => (int) $item->cerai_mati,
                        'tercatat' => (int) $item->tercatat,
                        'tidak_tercatat' => (int) $item->tidak_tercatat,
                        'persentase_tercatat' => $persentase_tercatat,
                    ];
                }

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Analisis Usia Menikah (Sangat Penting!)
     * Mendeteksi pernikahan dini dan kelayakan usia menikah
     */
    public function analisaUsiaMenikah()
    {
        return Cache::remember('perkawinan.analisa_usia_menikah', self::CACHE_TTL, function () {
            try {
                // Batas usia menikah menurut UU No 16 Tahun 2019:
                // Laki-laki: 19 tahun
                // Perempuan: 19 tahun (sebelumnya 16, diubah jadi 19)

                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select([
                        DB::raw('COUNT(*) as total_menikah'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19 AND t1.jenkel = 1 THEN 1 ELSE 0 END) as menikah_dibawah_umur_laki'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19 AND t1.jenkel = 2 THEN 1 ELSE 0 END) as menikah_dibawah_umur_perempuan'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 19 THEN 1 ELSE 0 END) as menikah_cukup_umur'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 21 AND 30 THEN 1 ELSE 0 END) as menikah_usia_ideal'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) > 35 THEN 1 ELSE 0 END) as menikah_usia_terlambat')
                    ])
                    ->first();

                $total = (int) $data->total_menikah;
                $total_dibawah_umur = (int) $data->menikah_dibawah_umur_laki + (int) $data->menikah_dibawah_umur_perempuan;

                return response()->json([
                    'success' => true,
                    'data' => [
                        'total_menikah' => $total,
                        'menikah_dibawah_umur_laki' => (int) $data->menikah_dibawah_umur_laki,
                        'menikah_dibawah_umur_perempuan' => (int) $data->menikah_dibawah_umur_perempuan,
                        'menikah_cukup_umur' => (int) $data->menikah_cukup_umur,
                        'menikah_usia_ideal' => (int) $data->menikah_usia_ideal,
                        'menikah_usia_terlambat' => (int) $data->menikah_usia_terlambat,
                        'persentase_dibawah_umur' => $total > 0 ? number_format(($total_dibawah_umur / $total) * 100, 1) : 0,
                        'persentase_cukup_umur' => $total > 0 ? number_format(((int)$data->menikah_cukup_umur / $total) * 100, 1) : 0,
                        'persentase_usia_ideal' => $total > 0 ? number_format(((int)$data->menikah_usia_ideal / $total) * 100, 1) : 0,
                    ]
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Distribusi Menikah Di Bawah Umur Per Kategori
     */
    public function distribusiMenikahDibawahUmur()
    {
        return Cache::remember('perkawinan.distribusi_menikah_dibawah_umur', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select([
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 16 THEN 1 ELSE 0 END) as sangat_dini'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 16 AND 18 THEN 1 ELSE 0 END) as dibawah_umur'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 19 AND 20 THEN 1 ELSE 0 END) as cukup_umur'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 21 AND 30 THEN 1 ELSE 0 END) as usia_ideal'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 31 AND 35 THEN 1 ELSE 0 END) as usia_matang'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) > 35 THEN 1 ELSE 0 END) as usia_lanjut'),
                    ])
                    ->first();

                $result = [
                    'Sangat Dini (< 16 th)' => (int) $data->sangat_dini,
                    'Di Bawah Umur (16-18 th)' => (int) $data->dibawah_umur,
                    'Cukup Umur (19-20 th)' => (int) $data->cukup_umur,
                    'Usia Ideal (21-30 th)' => (int) $data->usia_ideal,
                    'Usia Matang (31-35 th)' => (int) $data->usia_matang,
                    'Usia Lanjut (> 35 th)' => (int) $data->usia_lanjut,
                ];

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Menikah Di Bawah Umur Per Desa (SANGAT PENTING!)
     */
    public function menikahDibawahUmurPerDesa()
    {
        return Cache::remember('perkawinan.menikah_dibawah_umur_per_desa', self::CACHE_TTL, function () {
            try {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->where('t1.sts_perkawinan', 'KAWIN')
                    ->select([
                        't3.name as desa',
                        DB::raw('COUNT(*) as total_menikah'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19 AND t1.jenkel = 1 THEN 1 ELSE 0 END) as dibawah_umur_laki'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19 AND t1.jenkel = 2 THEN 1 ELSE 0 END) as dibawah_umur_perempuan'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 16 THEN 1 ELSE 0 END) as sangat_dini'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 19 THEN 1 ELSE 0 END) as cukup_umur')
                    ])
                    ->groupBy('t3.name')
                    ->get();

                $result = [];
                foreach ($data as $item) {
                    $desa = $item->desa ?: 'Tidak Diketahui';
                    $total_menikah = (int) $item->total_menikah;
                    $dibawah_umur_laki = (int) $item->dibawah_umur_laki;
                    $dibawah_umur_perempuan = (int) $item->dibawah_umur_perempuan;
                    $total_dibawah_umur = $dibawah_umur_laki + $dibawah_umur_perempuan;

                    $result[] = [
                        'desa' => $desa,
                        'total_menikah' => $total_menikah,
                        'dibawah_umur_laki' => $dibawah_umur_laki,
                        'dibawah_umur_perempuan' => $dibawah_umur_perempuan,
                        'sangat_dini' => (int) $item->sangat_dini,
                        'cukup_umur' => (int) $item->cukup_umur,
                        'total_dibawah_umur' => $total_dibawah_umur,
                        'persentase_dibawah_umur' => $total_menikah > 0 ? number_format(($total_dibawah_umur / $total_menikah) * 100, 1) : 0,
                    ];
                }

                // Sort berdasarkan jumlah pernikahan dini tertinggi
                usort($result, function($a, $b) {
                    return $b['total_dibawah_umur'] <=> $a['total_dibawah_umur'];
                });

                return response()->json([
                    'success' => true,
                    'data' => $result
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ], 500);
            }
        });
    }

    /**
     * Detail Nama-Nama Yang Menikah Di Bawah Umur Per Desa
     * NOTE: Data sensitif, tidak di-cache untuk keamanan
     */
    public function detailMenikahDibawahUmur()
    {
        try {
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->where('t1.sts_perkawinan', 'KAWIN')
                ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 19')
                ->select([
                    't3.name as desa',
                    't1.no_nik',
                    't1.nama',
                    't1.jenkel',
                    't1.tgl_lahir',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur'),
                    't1.status_kawin_tercatat',
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) as rt_rw"),
                ])
                ->orderBy('t3.name')
                ->orderBy('umur')
                ->get();

            $result = [];
            foreach ($data as $item) {
                $result[] = [
                    'desa' => $item->desa ?: 'Tidak Diketahui',
                    'no_nik' => $this->maskNumber($item->no_nik),
                    'nama' => strtoupper($item->nama),
                    'jenkel' => $item->jenkel == 1 ? 'Laki-laki' : 'Perempuan',
                    'umur' => (int) $item->umur,
                    'tgl_lahir' => $item->tgl_lahir,
                    'rt_rw' => $item->rt_rw,
                    'status_tercatat' => $item->status_kawin_tercatat ?: 'Tidak Ada Keterangan',
                    'kategori' => $item->umur < 16 ? 'Sangat Dini' : 'Di Bawah Umur',
                ];
            }

            return response()->json([
                'success' => true,
                'data' => $result,
                'total' => count($result)
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
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
