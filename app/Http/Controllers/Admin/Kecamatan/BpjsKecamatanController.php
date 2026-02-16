<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class BpjsKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index(Request $request)
    {
        return view('admin.chart.bpjs.kecamatan');
    }

    // 1. Statistik Jumlah
    public function getStatistikJumlah()
    {
        try {
            $data = Cache::remember('bpjs_statistik_jumlah', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->select([
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as total_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as total_perempuan'),
                        DB::raw('SUM(CASE WHEN t1.punya_bpjs = "ya" THEN 1 ELSE 0 END) as punya_bpjs'),
                        DB::raw('SUM(CASE WHEN t1.punya_bpjs != "ya" OR t1.punya_bpjs IS NULL THEN 1 ELSE 0 END) as tidak_punya_bpjs'),
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs = "bpjs_kesehatan" OR t1.jenis_bpjs = "BPJS Kesehatan") THEN 1 ELSE 0 END) as bpjs_kesehatan'),
                        DB::raw('SUM(CASE WHEN t1.jenis_bpjs = "bpjs_ketenagakerjaan" THEN 1 ELSE 0 END) as bpjs_ketenagakerjaan'),
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs = "memiliki_kedua_bpjs" OR t1.jenis_bpjs = "Memiliki Keduanya" OR t1.jenis_bpjs = "memiliki_keduanya") THEN 1 ELSE 0 END) as memiliki_keduanya'),
                        DB::raw('SUM(CASE WHEN t1.pembayaran_bpjs = "pemerintah" THEN 1 ELSE 0 END) as bayar_pemerintah'),
                        DB::raw('SUM(CASE WHEN (t1.pembayaran_bpjs = "pemerintah/Perusahaan" OR t1.pembayaran_bpjs = "pemerintah / Perusahaan") THEN 1 ELSE 0 END) as bayar_perusahaan'),
                        DB::raw('SUM(CASE WHEN t1.pembayaran_bpjs = "mandiri" THEN 1 ELSE 0 END) as bayar_mandiri')
                    ])
                    ->first();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 2. Statistik Rasio & Persentase
    public function getStatistikRasio()
    {
        try {
            $data = Cache::remember('bpjs_statistik_rasio', self::CACHE_TTL, function() {
                $total = DB::table('t_kartu_keluarga_anggota')->count();
                $punya_bpjs = DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->count();

                $tidak_punya = $total - $punya_bpjs;

                return [
                    'persentase_punya_bpjs' => $total > 0 ? number_format(($punya_bpjs / $total) * 100, 2) : 0,
                    'persentase_tidak_punya' => $total > 0 ? number_format(($tidak_punya / $total) * 100, 2) : 0,
                    'rasio_kepemilikan' => $tidak_punya > 0 ? number_format($punya_bpjs / $tidak_punya, 2) : 0,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 3. Distribusi Jenis BPJS
    public function getDistribusiJenisBpjs()
    {
        try {
            $data = Cache::remember('bpjs_distribusi_jenis', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota')
                    ->select([
                        DB::raw('CASE
                            WHEN jenis_bpjs = "bpjs_kesehatan" OR jenis_bpjs = "BPJS Kesehatan" THEN "BPJS Kesehatan"
                            WHEN jenis_bpjs = "bpjs_ketenagakerjaan" THEN "BPJS Ketenagakerjaan"
                            WHEN jenis_bpjs IN ("memiliki_kedua_bpjs", "Memiliki Keduanya", "memiliki_keduanya") THEN "Memiliki Keduanya"
                            ELSE "Belum Terdaftar"
                        END as jenis'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('jenis')
                    ->get()
                    ->pluck('jumlah', 'jenis')
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 4. Distribusi Metode Pembayaran
    public function getDistribusiPembayaran()
    {
        try {
            $data = Cache::remember('bpjs_distribusi_pembayaran', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->select([
                        DB::raw('CASE
                            WHEN pembayaran_bpjs = "pemerintah" THEN "Pemerintah"
                            WHEN pembayaran_bpjs IN ("pemerintah/Perusahaan", "pemerintah / Perusahaan") THEN "Perusahaan"
                            WHEN pembayaran_bpjs = "mandiri" THEN "Mandiri"
                            ELSE "Tidak Tercatat"
                        END as metode'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('metode')
                    ->get()
                    ->pluck('jumlah', 'metode')
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 5. Distribusi Jenis Kelamin
    public function getDistribusiJenisKelamin()
    {
        try {
            $data = Cache::remember('bpjs_distribusi_jenkel', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->select([
                        DB::raw('CASE WHEN jenkel = 1 THEN "Laki-laki" ELSE "Perempuan" END as jenis_kelamin'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('jenkel')
                    ->get()
                    ->pluck('jumlah', 'jenis_kelamin')
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 6. Distribusi Per Desa
    public function getDistribusiPerDesa()
    {
        try {
            $data = Cache::remember('bpjs_distribusi_desa', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select([
                        't3.name as desa',
                        DB::raw('COUNT(*) as total'),
                        DB::raw('SUM(CASE WHEN t1.punya_bpjs = "ya" THEN 1 ELSE 0 END) as punya_bpjs')
                    ])
                    ->groupBy('t3.name')
                    ->orderBy('punya_bpjs', 'DESC')
                    ->get()
                    ->pluck('punya_bpjs', 'desa')
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 7. Distribusi Berdasarkan Kelompok Umur
    public function getDistribusiKelompokUmur()
    {
        try {
            $data = Cache::remember('bpjs_distribusi_umur', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->select([
                        DB::raw('CASE
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 5 THEN "0-4 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 5 AND 12 THEN "5-12 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 13 AND 17 THEN "13-17 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN "18-25 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 40 THEN "26-40 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 41 AND 60 THEN "41-60 Tahun"
                            ELSE "60+ Tahun"
                        END as kelompok_umur'),
                        DB::raw('COUNT(*) as jumlah')
                    ])
                    ->groupBy('kelompok_umur')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->pluck('jumlah', 'kelompok_umur')
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 8. BPJS Berdasarkan Umur dan Jenis Kelamin
    public function getBpjsUmurJenisKelamin()
    {
        try {
            $data = Cache::remember('bpjs_umur_jenkel', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->select([
                        DB::raw('CASE
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 5 THEN "0-4 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 5 AND 12 THEN "5-12 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 13 AND 17 THEN "13-17 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN "18-25 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 40 THEN "26-40 Tahun"
                            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 41 AND 60 THEN "41-60 Tahun"
                            ELSE "60+ Tahun"
                        END as label'),
                        DB::raw('SUM(CASE WHEN jenkel = 1 THEN 1 ELSE 0 END) as laki'),
                        DB::raw('SUM(CASE WHEN jenkel = 2 THEN 1 ELSE 0 END) as perempuan')
                    ])
                    ->groupBy('label')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->toArray();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 9. Detail BPJS Per Desa
    public function getDetailBpjsPerDesa()
    {
        try {
            $data = Cache::remember('bpjs_detail_desa', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select([
                        't3.name as desa',
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                        DB::raw('SUM(CASE WHEN t1.punya_bpjs = "ya" THEN 1 ELSE 0 END) as punya_bpjs'),
                        DB::raw('SUM(CASE WHEN t1.punya_bpjs != "ya" OR t1.punya_bpjs IS NULL THEN 1 ELSE 0 END) as tidak_punya_bpjs'),
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs = "bpjs_kesehatan" OR t1.jenis_bpjs = "BPJS Kesehatan") THEN 1 ELSE 0 END) as bpjs_kesehatan'),
                        DB::raw('SUM(CASE WHEN t1.jenis_bpjs = "bpjs_ketenagakerjaan" THEN 1 ELSE 0 END) as bpjs_ketenagakerjaan'),
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs IN ("memiliki_kedua_bpjs", "Memiliki Keduanya", "memiliki_keduanya")) THEN 1 ELSE 0 END) as memiliki_keduanya'),
                        DB::raw('SUM(CASE WHEN t1.pembayaran_bpjs = "mandiri" THEN 1 ELSE 0 END) as bayar_mandiri'),
                        DB::raw('SUM(CASE WHEN t1.pembayaran_bpjs = "pemerintah" THEN 1 ELSE 0 END) as bayar_pemerintah')
                    ])
                    ->groupBy('t3.name')
                    ->orderBy('t3.name')
                    ->get();
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 10. Jenis BPJS Per Desa (Stacked Bar)
    public function getJenisBpjsPerDesa()
    {
        try {
            $data = Cache::remember('bpjs_jenis_per_desa', self::CACHE_TTL, function() {
                $rawData = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->where('t1.punya_bpjs', 'ya')
                    ->select([
                        't3.name as desa',
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs = "bpjs_kesehatan" OR t1.jenis_bpjs = "BPJS Kesehatan") THEN 1 ELSE 0 END) as kesehatan'),
                        DB::raw('SUM(CASE WHEN t1.jenis_bpjs = "bpjs_ketenagakerjaan" THEN 1 ELSE 0 END) as ketenagakerjaan'),
                        DB::raw('SUM(CASE WHEN (t1.jenis_bpjs IN ("memiliki_kedua_bpjs", "Memiliki Keduanya", "memiliki_keduanya")) THEN 1 ELSE 0 END) as keduanya')
                    ])
                    ->groupBy('t3.name')
                    ->orderBy('t3.name')
                    ->get();

                $labels = $rawData->pluck('desa')->toArray();
                $datasets = [
                    [
                        'label' => 'BPJS Kesehatan',
                        'data' => $rawData->pluck('kesehatan')->toArray(),
                        'backgroundColor' => '#28a745',
                        'borderColor' => '#28a745',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'BPJS Ketenagakerjaan',
                        'data' => $rawData->pluck('ketenagakerjaan')->toArray(),
                        'backgroundColor' => '#007bff',
                        'borderColor' => '#007bff',
                        'borderWidth' => 1
                    ],
                    [
                        'label' => 'Memiliki Keduanya',
                        'data' => $rawData->pluck('keduanya')->toArray(),
                        'backgroundColor' => '#6f42c1',
                        'borderColor' => '#6f42c1',
                        'borderWidth' => 1
                    ]
                ];

                return [
                    'labels' => $labels,
                    'datasets' => $datasets
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 11. Analisis Data Abnormal
    public function getDataAbnormal()
    {
        try {
            $data = Cache::remember('bpjs_data_abnormal', self::CACHE_TTL, function() {
                // Hitung berbagai jenis abnormalitas
                $bpjs_tanpa_jenis = DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->where(function($query) {
                        $query->whereNull('jenis_bpjs')
                              ->orWhere('jenis_bpjs', '')
                              ->orWhere('jenis_bpjs', 'Pilih');
                    })
                    ->count();

                $bpjs_tanpa_pembayaran = DB::table('t_kartu_keluarga_anggota')
                    ->where('punya_bpjs', 'ya')
                    ->whereNotNull('jenis_bpjs')
                    ->where('jenis_bpjs', '!=', '')
                    ->where('jenis_bpjs', '!=', 'Pilih')
                    ->where(function($query) {
                        $query->whereNull('pembayaran_bpjs')
                              ->orWhere('pembayaran_bpjs', '')
                              ->orWhere('pembayaran_bpjs', 'Pilih');
                    })
                    ->count();

                $tidak_punya_ada_jenis = DB::table('t_kartu_keluarga_anggota')
                    ->where(function($query) {
                        $query->where('punya_bpjs', '!=', 'ya')
                              ->orWhereNull('punya_bpjs');
                    })
                    ->whereNotNull('jenis_bpjs')
                    ->where('jenis_bpjs', '!=', '')
                    ->where('jenis_bpjs', '!=', 'Pilih')
                    ->count();

                $tidak_punya_ada_pembayaran = DB::table('t_kartu_keluarga_anggota')
                    ->where(function($query) {
                        $query->where('punya_bpjs', '!=', 'ya')
                              ->orWhereNull('punya_bpjs');
                    })
                    ->whereNotNull('pembayaran_bpjs')
                    ->where('pembayaran_bpjs', '!=', '')
                    ->where('pembayaran_bpjs', '!=', 'Pilih')
                    ->count();

                return [
                    'Punya BPJS Tanpa Jenis' => $bpjs_tanpa_jenis,
                    'Punya BPJS Tanpa Metode Bayar' => $bpjs_tanpa_pembayaran,
                    'Tidak Punya BPJS Ada Jenis' => $tidak_punya_ada_jenis,
                    'Tidak Punya BPJS Ada Pembayaran' => $tidak_punya_ada_pembayaran,
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $data
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 12. DataTable - Semua Penduduk
    public function getDatatablePenduduk(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't2.no_kk',
                    't1.jenkel',
                    't1.tgl_lahir',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't3.name AS desa',
                    't1.punya_bpjs',
                    't1.jenis_bpjs',
                    't1.pembayaran_bpjs',
                ]);

            // Filter
            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            if ($request->filled('jenkel')) {
                $query->where('t1.jenkel', $request->jenkel);
            }

            if ($request->filled('status_bpjs')) {
                if ($request->status_bpjs == 'punya') {
                    $query->where('t1.punya_bpjs', 'ya');
                } else {
                    $query->where(function($q) {
                        $q->where('t1.punya_bpjs', '!=', 'ya')
                          ->orWhereNull('t1.punya_bpjs');
                    });
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info"><i class="fas fa-male mr-1"></i> Laki-laki</span>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-female mr-1"></i> Perempuan</span>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    return '<span class="badge badge-secondary">' . $row->umur . ' Tahun</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return date('d/m/Y', strtotime($row->tgl_lahir));
                })
                ->addColumn('status_bpjs', function($row) {
                    if ($row->punya_bpjs == 'ya') {
                        return '<span class="badge badge-success badge-lg"><i class="fas fa-check-circle mr-1"></i> Punya BPJS</span>';
                    } else {
                        return '<span class="badge badge-danger badge-lg"><i class="fas fa-times-circle mr-1"></i> Tidak Punya</span>';
                    }
                })
                ->addColumn('jenis_display', function($row) {
                    if (in_array($row->jenis_bpjs, ['bpjs_kesehatan', 'BPJS Kesehatan'])) {
                        return '<span class="badge badge-success">BPJS Kesehatan</span>';
                    } elseif ($row->jenis_bpjs == 'bpjs_ketenagakerjaan') {
                        return '<span class="badge badge-primary">BPJS Ketenagakerjaan</span>';
                    } elseif (in_array($row->jenis_bpjs, ['memiliki_kedua_bpjs', 'Memiliki Keduanya', 'memiliki_keduanya'])) {
                        return '<span class="badge badge-purple">Keduanya</span>';
                    } else {
                        return '<span class="badge badge-secondary">-</span>';
                    }
                })
                ->addColumn('pembayaran_display', function($row) {
                    if ($row->pembayaran_bpjs == 'mandiri') {
                        return '<span class="badge badge-warning">Mandiri</span>';
                    } elseif ($row->pembayaran_bpjs == 'pemerintah') {
                        return '<span class="badge badge-info">Pemerintah</span>';
                    } elseif (in_array($row->pembayaran_bpjs, ['pemerintah/Perusahaan', 'pemerintah / Perusahaan'])) {
                        return '<span class="badge badge-primary">Perusahaan</span>';
                    } else {
                        return '<span class="badge badge-secondary">-</span>';
                    }
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'status_bpjs', 'jenis_display', 'pembayaran_display'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 13. DataTable - Data Abnormal
    public function getDatatableAbnormal(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't2.no_kk',
                    't1.jenkel',
                    't1.tgl_lahir',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't3.name AS desa',
                    't1.punya_bpjs',
                    't1.jenis_bpjs',
                    't1.pembayaran_bpjs',
                    DB::raw('CASE
                        WHEN (t1.punya_bpjs = "ya" AND (t1.jenis_bpjs IS NULL OR t1.jenis_bpjs = "" OR t1.jenis_bpjs = "Pilih")) THEN "Punya BPJS Tanpa Jenis"
                        WHEN (t1.punya_bpjs = "ya" AND t1.jenis_bpjs IS NOT NULL AND t1.jenis_bpjs != "" AND t1.jenis_bpjs != "Pilih" AND (t1.pembayaran_bpjs IS NULL OR t1.pembayaran_bpjs = "" OR t1.pembayaran_bpjs = "Pilih")) THEN "Punya BPJS Tanpa Metode Bayar"
                        WHEN ((t1.punya_bpjs != "ya" OR t1.punya_bpjs IS NULL) AND t1.jenis_bpjs IS NOT NULL AND t1.jenis_bpjs != "" AND t1.jenis_bpjs != "Pilih") THEN "Tidak Punya BPJS Ada Jenis"
                        WHEN ((t1.punya_bpjs != "ya" OR t1.punya_bpjs IS NULL) AND t1.pembayaran_bpjs IS NOT NULL AND t1.pembayaran_bpjs != "" AND t1.pembayaran_bpjs != "Pilih") THEN "Tidak Punya BPJS Ada Pembayaran"
                        ELSE "Normal"
                    END as kategori_abnormal')
                ])
                ->havingRaw('kategori_abnormal != "Normal"');

            // Filter
            if ($request->filled('kategori')) {
                $query->havingRaw('kategori_abnormal = ?', [$request->kategori]);
            }

            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info"><i class="fas fa-male mr-1"></i> Laki-laki</span>';
                    } else {
                        return '<span class="badge badge-danger"><i class="fas fa-female mr-1"></i> Perempuan</span>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    return '<span class="badge badge-secondary">' . $row->umur . ' Tahun</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return date('d/m/Y', strtotime($row->tgl_lahir));
                })
                ->addColumn('kategori_badge', function($row) {
                    $badges = [
                        'Punya BPJS Tanpa Jenis' => 'warning',
                        'Punya BPJS Tanpa Metode Bayar' => 'warning',
                        'Tidak Punya BPJS Ada Jenis' => 'danger',
                        'Tidak Punya BPJS Ada Pembayaran' => 'danger'
                    ];

                    $color = $badges[$row->kategori_abnormal] ?? 'secondary';
                    return '<span class="badge badge-' . $color . ' badge-lg"><i class="fas fa-exclamation-triangle mr-1"></i> ' . $row->kategori_abnormal . '</span>';
                })
                ->addColumn('detail_masalah', function($row) {
                    $html = '<small class="text-muted">';
                    $html .= '<strong>Status BPJS:</strong> ' . ($row->punya_bpjs ?? '-') . '<br>';
                    $html .= '<strong>Jenis:</strong> ' . ($row->jenis_bpjs ?? '-') . '<br>';
                    $html .= '<strong>Pembayaran:</strong> ' . ($row->pembayaran_bpjs ?? '-');
                    $html .= '</small>';
                    return $html;
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'kategori_badge', 'detail_masalah'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // 14. Get List Desa untuk Filter
    public function getListDesa()
    {
        try {
            $desa = Cache::remember('bpjs_list_desa', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga as t1')
                    ->join('indonesia_villages as t2', 't2.code', '=', 't1.desa')
                    ->select('t2.code', 't2.name')
                    ->groupBy('t2.code', 't2.name')
                    ->orderBy('t2.name')
                    ->get();
            });

            return response()->json([
                'success' => true,
                'data' => $desa
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // 15. Clear Cache (Optional - untuk admin)
    public function clearCache()
    {
        try {
            $cacheKeys = [
                'bpjs_statistik_jumlah',
                'bpjs_statistik_rasio',
                'bpjs_distribusi_jenis',
                'bpjs_distribusi_pembayaran',
                'bpjs_distribusi_jenkel',
                'bpjs_distribusi_desa',
                'bpjs_distribusi_umur',
                'bpjs_umur_jenkel',
                'bpjs_detail_desa',
                'bpjs_jenis_per_desa',
                'bpjs_data_abnormal',
                'bpjs_list_desa',
            ];

            foreach ($cacheKeys as $key) {
                Cache::forget($key);
            }

            return response()->json([
                'success' => true,
                'message' => 'Cache berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Helper function untuk masking NIK
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