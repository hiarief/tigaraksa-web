<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PendidikanKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index()
    {
        return view('admin.chart.pendidikan.kecamatan');
    }

    // Statistik Jumlah
    public function getStatistikJumlah()
    {
        try {
            $data = Cache::remember('pendidikan_statistik_jumlah_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select([
                        't1.jenkel',
                        't3.nama as pendidikan'
                    ])
                    ->get();
            });

            $totalPenduduk = $data->count();
            $totalLaki = $data->where('jenkel', 1)->count();
            $totalPerempuan = $data->where('jenkel', 2)->count();

            // Hitung berdasarkan kategori pendidikan
            $tidakSekolah = $data->whereIn('pendidikan', [
                'TIDAK / BELUM SEKOLAH',
                'BELUM MASUK TK/KELOMPOK BERMAIN'
            ])->count();

            $pendidikanDasar = $data->whereIn('pendidikan', [
                'BELUM TAMAT SD/SEDERAJAT',
                'TAMAT SD / SEDERAJAT',
                'SEDANG PAKET A'
            ])->count();

            $pendidikanMenengah = $data->whereIn('pendidikan', [
                'SLTP/SEDERAJAT',
                'SLTA / SEDERAJAT',
                'SEDANG PAKET B',
                'SEDANG PAKET C'
            ])->count();

            $pendidikanTinggi = $data->whereIn('pendidikan', [
                'DIPLOMA I / II',
                'AKADEMI/ DIPLOMA III/S. MUDA',
                'DIPLOMA IV/ STRATA I',
                'STRATA II',
                'STRATA III'
            ])->count();

            $sedangSekolahSD = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG') &&
                    (str_contains(strtoupper($item->pendidikan ?? ''), 'SD') ||
                        str_contains(strtoupper($item->pendidikan ?? ''), 'PAKET A'));
            })->count();

            $sedangSekolahSMP = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG') &&
                    (str_contains(strtoupper($item->pendidikan ?? ''), 'SMP') ||
                        str_contains(strtoupper($item->pendidikan ?? ''), 'SLTP') ||
                        str_contains(strtoupper($item->pendidikan ?? ''), 'PAKET B'));
            })->count();

            $sedangSekolahSMA = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG') &&
                    (str_contains(strtoupper($item->pendidikan ?? ''), 'SMA') ||
                        str_contains(strtoupper($item->pendidikan ?? ''), 'SLTA') ||
                        str_contains(strtoupper($item->pendidikan ?? ''), 'PAKET C'));
            })->count();

            $sedangKuliah = $data->filter(function($item) {
                $pendidikan = strtoupper($item->pendidikan ?? '');
                return str_contains($pendidikan, 'SEDANG S') ||
                    str_contains($pendidikan, 'SEDANG  D-');
            })->count();

            $putusSekolah = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'PUTUS SEKOLAH');
            })->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'total_penduduk' => $totalPenduduk,
                    'total_laki' => $totalLaki,
                    'total_perempuan' => $totalPerempuan,
                    'tidak_sekolah' => $tidakSekolah,
                    'pendidikan_dasar' => $pendidikanDasar,
                    'pendidikan_menengah' => $pendidikanMenengah,
                    'pendidikan_tinggi' => $pendidikanTinggi,
                    'sedang_sekolah_sd' => $sedangSekolahSD,
                    'sedang_sekolah_smp' => $sedangSekolahSMP,
                    'sedang_sekolah_sma' => $sedangSekolahSMA,
                    'sedang_kuliah' => $sedangKuliah,
                    'putus_sekolah' => $putusSekolah
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Statistik Rasio
    public function getStatistikRasio()
    {
        try {
            $data = Cache::remember('pendidikan_statistik_rasio_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select(['t3.nama as pendidikan'])
                    ->get();
            });

            $total = $data->count();

            $pendidikanTinggi = $data->whereIn('pendidikan', [
                'DIPLOMA I / II',
                'AKADEMI/ DIPLOMA III/S. MUDA',
                'DIPLOMA IV/ STRATA I',
                'STRATA II',
                'STRATA III'
            ])->count();

            $putusSekolah = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'PUTUS SEKOLAH');
            })->count();

            $tidakSekolah = $data->whereIn('pendidikan', [
                'TIDAK / BELUM SEKOLAH',
                'BELUM MASUK TK/KELOMPOK BERMAIN'
            ])->count();

            return response()->json([
                'success' => true,
                'data' => [
                    'persentase_pendidikan_tinggi' => $total > 0 ? number_format(($pendidikanTinggi / $total) * 100, 1) : 0,
                    'persentase_putus_sekolah' => $total > 0 ? number_format(($putusSekolah / $total) * 100, 1) : 0,
                    'persentase_tidak_sekolah' => $total > 0 ? number_format(($tidakSekolah / $total) * 100, 1) : 0,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Distribusi Tingkat Pendidikan
    public function getDistribusiTingkatPendidikan()
    {
        try {
            $data = Cache::remember('pendidikan_distribusi_tingkat_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select(['t3.nama as pendidikan'])
                    ->get();
            });

            $result = [];

            $result['Tidak/Belum Sekolah'] = $data->whereIn('pendidikan', [
                'TIDAK / BELUM SEKOLAH',
                'BELUM MASUK TK/KELOMPOK BERMAIN'
            ])->count();

            $result['TK/PAUD'] = $data->whereIn('pendidikan', [
                'SEDANG TK/KELOMPOK BERMAIN'
            ])->count();

            $result['SD/Sederajat'] = $data->whereIn('pendidikan', [
                'BELUM TAMAT SD/SEDERAJAT',
                'TAMAT SD / SEDERAJAT'
            ])->count();

            $result['SMP/Sederajat'] = $data->whereIn('pendidikan', [
                'SLTP/SEDERAJAT'
            ])->count();

            $result['SMA/Sederajat'] = $data->whereIn('pendidikan', [
                'SLTA / SEDERAJAT'
            ])->count();

            $result['Diploma'] = $data->whereIn('pendidikan', [
                'DIPLOMA I / II',
                'AKADEMI/ DIPLOMA III/S. MUDA'
            ])->count();

            $result['Sarjana (S1)'] = $data->whereIn('pendidikan', [
                'DIPLOMA IV/ STRATA I'
            ])->count();

            $result['Magister (S2)'] = $data->whereIn('pendidikan', [
                'STRATA II'
            ])->count();

            $result['Doktor (S3)'] = $data->whereIn('pendidikan', [
                'STRATA III'
            ])->count();

            $result['Putus Sekolah'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'PUTUS SEKOLAH');
            })->count();

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
    }

    // Distribusi Jenis Kelamin
    public function getDistribusiJenisKelamin()
    {
        try {
            $data = Cache::remember('pendidikan_distribusi_jenkel_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->select([
                        't1.jenkel',
                        DB::raw('COUNT(*) as total')
                    ])
                    ->groupBy('t1.jenkel')
                    ->get();
            });

            $result = [];
            foreach ($data as $item) {
                $result[$item->jenkel == 1 ? 'Laki-laki' : 'Perempuan'] = $item->total;
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
    }

    // Distribusi Per Desa
    public function getDistribusiPerDesa()
    {
        try {
            $data = Cache::remember('pendidikan_distribusi_desa_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->join('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->select([
                        't4.name as desa',
                        DB::raw('COUNT(*) as total')
                    ])
                    ->groupBy('t4.name')
                    ->orderBy('total', 'DESC')
                    ->get();
            });

            $result = [];
            foreach ($data as $item) {
                $result[$item->desa] = $item->total;
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
    }

    // Distribusi Berdasarkan Umur
    public function getDistribusiUmur()
    {
        try {
            $data = Cache::remember('pendidikan_distribusi_umur_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select([
                        't1.tgl_lahir',
                        't3.nama as pendidikan'
                    ])
                    ->get();
            });

            $result = [
                '0-6 tahun (PAUD)' => 0,
                '7-12 tahun (SD)' => 0,
                '13-15 tahun (SMP)' => 0,
                '16-18 tahun (SMA)' => 0,
                '19-24 tahun (Kuliah)' => 0,
                '25+ tahun (Dewasa)' => 0
            ];

            foreach ($data as $item) {
                $umur = Carbon::parse($item->tgl_lahir)->age;

                if ($umur >= 0 && $umur <= 6) {
                    $result['0-6 tahun (PAUD)']++;
                } elseif ($umur >= 7 && $umur <= 12) {
                    $result['7-12 tahun (SD)']++;
                } elseif ($umur >= 13 && $umur <= 15) {
                    $result['13-15 tahun (SMP)']++;
                } elseif ($umur >= 16 && $umur <= 18) {
                    $result['16-18 tahun (SMA)']++;
                } elseif ($umur >= 19 && $umur <= 24) {
                    $result['19-24 tahun (Kuliah)']++;
                } else {
                    $result['25+ tahun (Dewasa)']++;
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
    }

    // Status Sedang Sekolah
    public function getStatusSedangSekolah()
    {
        try {
            $data = Cache::remember('pendidikan_status_sedang_sekolah_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select(['t3.nama as pendidikan'])
                    ->get();
            });

            $result = [];

            $result['Sedang TK/PAUD'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG TK');
            })->count();

            $result['Sedang SD'] = $data->filter(function($item) {
                $pendidikan = strtoupper($item->pendidikan ?? '');
                return str_contains($pendidikan, 'SEDANG') &&
                    (str_contains($pendidikan, 'SD') || str_contains($pendidikan, 'PAKET A'));
            })->count();

            $result['Sedang SMP'] = $data->filter(function($item) {
                $pendidikan = strtoupper($item->pendidikan ?? '');
                return str_contains($pendidikan, 'SEDANG') &&
                    (str_contains($pendidikan, 'SMP') || str_contains($pendidikan, 'SLTP') || str_contains($pendidikan, 'PAKET B'));
            })->count();

            $result['Sedang SMA'] = $data->filter(function($item) {
                $pendidikan = strtoupper($item->pendidikan ?? '');
                return str_contains($pendidikan, 'SEDANG') &&
                    (str_contains($pendidikan, 'SMA') || str_contains($pendidikan, 'SLTA') || str_contains($pendidikan, 'PAKET C'));
            })->count();

            $result['Sedang Diploma'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG  D-');
            })->count();

            $result['Sedang S1'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG S1');
            })->count();

            $result['Sedang S2'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG S2');
            })->count();

            $result['Sedang S3'] = $data->filter(function($item) {
                return str_contains(strtoupper($item->pendidikan ?? ''), 'SEDANG S3');
            })->count();

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
    }

    // Distribusi Pendidikan Non Formal
    public function getDistribusiPendidikanNonFormal()
    {
        try {
            $data = Cache::remember('pendidikan_non_formal_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->select([
                        't1.pendidikan_non',
                        DB::raw('COUNT(*) as total')
                    ])
                    ->whereNotNull('t1.pendidikan_non')
                    ->where('t1.pendidikan_non', '!=', 'Tidak Ada')
                    ->groupBy('t1.pendidikan_non')
                    ->get();
            });

            $result = [];
            foreach ($data as $item) {
                $result[$item->pendidikan_non ?? 'Tidak Diketahui'] = $item->total;
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
    }

    // Detail Per Desa
    public function getDetailPerDesa()
    {
        try {
            $data = Cache::remember('pendidikan_detail_desa_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->join('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select([
                        't4.name as desa',
                        't3.nama as pendidikan',
                        't1.jenkel'
                    ])
                    ->get();
            });

            $result = [];

            foreach ($data->groupBy('desa') as $desa => $items) {
                $result[] = [
                    'desa' => $desa,
                    'total_penduduk' => $items->count(),
                    'laki_laki' => $items->where('jenkel', 1)->count(),
                    'perempuan' => $items->where('jenkel', 2)->count(),
                    'tidak_sekolah' => $items->whereIn('pendidikan', ['TIDAK / BELUM SEKOLAH', 'BELUM MASUK TK/KELOMPOK BERMAIN'])->count(),
                    'sd' => $items->whereIn('pendidikan', ['BELUM TAMAT SD/SEDERAJAT', 'TAMAT SD / SEDERAJAT'])->count(),
                    'smp' => $items->where('pendidikan', 'SLTP/SEDERAJAT')->count(),
                    'sma' => $items->where('pendidikan', 'SLTA / SEDERAJAT')->count(),
                    'diploma' => $items->whereIn('pendidikan', ['DIPLOMA I / II', 'AKADEMI/ DIPLOMA III/S. MUDA'])->count(),
                    'sarjana' => $items->whereIn('pendidikan', ['DIPLOMA IV/ STRATA I', 'STRATA II', 'STRATA III'])->count(),
                    'putus_sekolah' => $items->filter(function($item) {
                        return str_contains(strtoupper($item->pendidikan ?? ''), 'PUTUS SEKOLAH');
                    })->count()
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
    }

    // Pendidikan Berdasarkan Kelompok Umur dan Jenis Kelamin
    public function getPendidikanByUmurJenkel()
    {
        try {
            $data = Cache::remember('pendidikan_umur_jenkel_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select([
                        't1.tgl_lahir',
                        't1.jenkel',
                        't3.nama as pendidikan'
                    ])
                    ->get();
            });

            $kelompokUmur = [
                '0-6' => ['label' => '0-6 tahun', 'laki' => 0, 'perempuan' => 0],
                '7-12' => ['label' => '7-12 tahun', 'laki' => 0, 'perempuan' => 0],
                '13-15' => ['label' => '13-15 tahun', 'laki' => 0, 'perempuan' => 0],
                '16-18' => ['label' => '16-18 tahun', 'laki' => 0, 'perempuan' => 0],
                '19-24' => ['label' => '19-24 tahun', 'laki' => 0, 'perempuan' => 0],
                '25+' => ['label' => '25+ tahun', 'laki' => 0, 'perempuan' => 0]
            ];

            foreach ($data as $item) {
                $umur = Carbon::parse($item->tgl_lahir)->age;
                $jenkel = $item->jenkel == 1 ? 'laki' : 'perempuan';

                if ($umur >= 0 && $umur <= 6) {
                    $kelompokUmur['0-6'][$jenkel]++;
                } elseif ($umur >= 7 && $umur <= 12) {
                    $kelompokUmur['7-12'][$jenkel]++;
                } elseif ($umur >= 13 && $umur <= 15) {
                    $kelompokUmur['13-15'][$jenkel]++;
                } elseif ($umur >= 16 && $umur <= 18) {
                    $kelompokUmur['16-18'][$jenkel]++;
                } elseif ($umur >= 19 && $umur <= 24) {
                    $kelompokUmur['19-24'][$jenkel]++;
                } else {
                    $kelompokUmur['25+'][$jenkel]++;
                }
            }

            return response()->json([
                'success' => true,
                'data' => $kelompokUmur
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Analisis Kewajaran Usia Sekolah - DITAMBAHKAN CACHE
    public function getAnalisaUsiaSekolah()
    {
        try {
            $data = Cache::remember('pendidikan_analisa_usia_sekolah_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->select([
                        't1.tgl_lahir',
                        't1.jenkel',
                        't3.nama as pendidikan'
                    ])
                    ->get();
            });

            $result = [
                'usia_sd_total' => 0,
                'usia_sd_sekolah' => 0,
                'usia_sd_tidak_sekolah' => 0,
                'usia_sd_sesuai' => 0,
                'usia_smp_total' => 0,
                'usia_smp_sekolah' => 0,
                'usia_smp_tidak_sekolah' => 0,
                'usia_smp_sesuai' => 0,
                'usia_sma_total' => 0,
                'usia_sma_sekolah' => 0,
                'usia_sma_tidak_sekolah' => 0,
                'usia_sma_sesuai' => 0,
                'usia_kuliah_total' => 0,
                'usia_kuliah_kuliah' => 0,
                'usia_kuliah_tidak_kuliah' => 0,
                'putus_sekolah_sd' => 0,
                'putus_sekolah_smp' => 0,
                'putus_sekolah_sma' => 0,
                'wajib_belajar_tidak_sekolah' => 0,
            ];

            foreach ($data as $item) {
                $umur = Carbon::parse($item->tgl_lahir)->age;
                $pendidikan = strtoupper($item->pendidikan ?? '');

                // Usia SD (7-12 tahun)
                if ($umur >= 7 && $umur <= 12) {
                    $result['usia_sd_total']++;

                    $sedangSekolah = str_contains($pendidikan, 'SEDANG') ||
                                    str_contains($pendidikan, 'TAMAT');

                    if ($sedangSekolah) {
                        $result['usia_sd_sekolah']++;

                        if (str_contains($pendidikan, 'SD') ||
                            str_contains($pendidikan, 'PAKET A') ||
                            str_contains($pendidikan, 'TAMAT SD')) {
                            $result['usia_sd_sesuai']++;
                        }
                    } else {
                        $result['usia_sd_tidak_sekolah']++;

                        if (str_contains($pendidikan, 'TIDAK') ||
                            str_contains($pendidikan, 'BELUM')) {
                            $result['wajib_belajar_tidak_sekolah']++;
                        }
                    }

                    if (str_contains($pendidikan, 'PUTUS SEKOLAH')) {
                        $result['putus_sekolah_sd']++;
                    }
                }

                // Usia SMP (13-15 tahun)
                if ($umur >= 13 && $umur <= 15) {
                    $result['usia_smp_total']++;

                    $sedangSekolah = str_contains($pendidikan, 'SEDANG') ||
                                    str_contains($pendidikan, 'TAMAT');

                    if ($sedangSekolah) {
                        $result['usia_smp_sekolah']++;

                        if (str_contains($pendidikan, 'SMP') ||
                            str_contains($pendidikan, 'SLTP') ||
                            str_contains($pendidikan, 'PAKET B') ||
                            str_contains($pendidikan, 'TAMAT SD') ||
                            str_contains($pendidikan, 'SLTP')) {
                            $result['usia_smp_sesuai']++;
                        }
                    } else {
                        $result['usia_smp_tidak_sekolah']++;

                        if (str_contains($pendidikan, 'TIDAK') ||
                            str_contains($pendidikan, 'BELUM')) {
                            $result['wajib_belajar_tidak_sekolah']++;
                        }
                    }

                    if (str_contains($pendidikan, 'PUTUS SEKOLAH')) {
                        $result['putus_sekolah_smp']++;
                    }
                }

                // Usia SMA (16-18 tahun)
                if ($umur >= 16 && $umur <= 18) {
                    $result['usia_sma_total']++;

                    $sedangSekolah = str_contains($pendidikan, 'SEDANG') ||
                                    str_contains($pendidikan, 'TAMAT');

                    if ($sedangSekolah) {
                        $result['usia_sma_sekolah']++;

                        if (str_contains($pendidikan, 'SMA') ||
                            str_contains($pendidikan, 'SLTA') ||
                            str_contains($pendidikan, 'PAKET C') ||
                            str_contains($pendidikan, 'SLTA')) {
                            $result['usia_sma_sesuai']++;
                        }
                    } else {
                        $result['usia_sma_tidak_sekolah']++;
                    }

                    if (str_contains($pendidikan, 'PUTUS SEKOLAH')) {
                        $result['putus_sekolah_sma']++;
                    }
                }

                // Usia Kuliah (19-24 tahun)
                if ($umur >= 19 && $umur <= 24) {
                    $result['usia_kuliah_total']++;

                    if (str_contains($pendidikan, 'SEDANG S') ||
                        str_contains($pendidikan, 'SEDANG  D-') ||
                        str_contains($pendidikan, 'DIPLOMA') ||
                        str_contains($pendidikan, 'STRATA')) {
                        $result['usia_kuliah_kuliah']++;
                    } else {
                        $result['usia_kuliah_tidak_kuliah']++;
                    }
                }
            }

            // Hitung persentase
            $result['persentase_sd_sekolah'] = $result['usia_sd_total'] > 0 ?
                number_format(($result['usia_sd_sekolah'] / $result['usia_sd_total']) * 100, 1) : 0;

            $result['persentase_smp_sekolah'] = $result['usia_smp_total'] > 0 ?
                number_format(($result['usia_smp_sekolah'] / $result['usia_smp_total']) * 100, 1) : 0;

            $result['persentase_sma_sekolah'] = $result['usia_sma_total'] > 0 ?
                number_format(($result['usia_sma_sekolah'] / $result['usia_sma_total']) * 100, 1) : 0;

            $result['persentase_kuliah'] = $result['usia_kuliah_total'] > 0 ?
                number_format(($result['usia_kuliah_kuliah'] / $result['usia_kuliah_total']) * 100, 1) : 0;

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
    }

    // Detail Anak Tidak Sekolah di Usia Wajib Belajar - DataTables
    // TIDAK PERLU CACHE karena menggunakan DataTables dengan pagination dan filtering
    public function getDetailTidakSekolahWajibBelajarDatatable(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't1.jenkel',
                    't1.tgl_lahir',
                    't2.rt',
                    't2.rw',
                    't4.name as desa',
                    't4.code as desa_code',
                    't3.nama as pendidikan'
                ])
                ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 7')
                ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) <= 15')
                ->where(function($q) {
                    $q->whereNull('t3.nama')
                    ->orWhere('t3.nama', 'LIKE', '%TIDAK%')
                    ->orWhere('t3.nama', 'LIKE', '%BELUM SEKOLAH%')
                    ->orWhere('t3.nama', 'LIKE', '%PUTUS SEKOLAH%');
                });

            // Filter by desa if provided
            if ($request->has('desa') && $request->desa != '') {
                $query->where('t4.code', $request->desa);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->addColumn('umur', function($row) {
                    return Carbon::parse($row->tgl_lahir)->age;
                })
                ->addColumn('kategori_usia', function($row) {
                    $umur = Carbon::parse($row->tgl_lahir)->age;
                    if ($umur >= 7 && $umur <= 12) {
                        return 'Usia SD (7-12 tahun)';
                    } else {
                        return 'Usia SMP (13-15 tahun)';
                    }
                })
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<i class="fas fa-male text-primary fa-lg"></i> <small class="d-block">Laki-laki</small>';
                    } else {
                        return '<i class="fas fa-female text-danger fa-lg"></i> <small class="d-block">Perempuan</small>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    $umur = Carbon::parse($row->tgl_lahir)->age;
                    $kategori = ($umur >= 7 && $umur <= 12) ? 'warning' : 'danger';
                    return '<span class="badge badge-'.$kategori.' badge-lg">'.$umur.' th</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return '<small>'.Carbon::parse($row->tgl_lahir)->format('d-m-Y').'</small>';
                })
                ->addColumn('kategori_usia_display', function($row) {
                    $umur = Carbon::parse($row->tgl_lahir)->age;
                    $kategori = ($umur >= 7 && $umur <= 12) ? 'warning' : 'danger';
                    $text = ($umur >= 7 && $umur <= 12) ? 'Usia SD (7-12 th)' : 'Usia SMP (13-15 th)';
                    return '<span class="badge badge-'.$kategori.'">'.$text.'</span>';
                })
                ->addColumn('rt_rw', function($row) {
                    return '<strong>'.$row->rt.'/'.$row->rw.'</strong>';
                })
                ->addColumn('status_pendidikan', function($row) {
                    return $row->pendidikan ?? '<span class="text-muted">Tidak Ada Keterangan</span>';
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'tgl_lahir_display', 'kategori_usia_display', 'rt_rw', 'status_pendidikan'])
                ->make(true);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Get List Desa untuk Filter - DITAMBAHKAN CACHE
    public function getListDesa()
    {
        try {
            $desa = Cache::remember('pendidikan_list_desa_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga as t2')
                    ->join('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->select('t4.code', 't4.name')
                    ->groupBy('t4.code', 't4.name')
                    ->orderBy('t4.name')
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

    // Get Summary Tidak Sekolah - DITAMBAHKAN CACHE
    public function getSummaryTidakSekolahWajibBelajar()
    {
        try {
            $data = Cache::remember('pendidikan_summary_tidak_sekolah_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->select([
                        't1.tgl_lahir',
                        't4.name as desa',
                        't3.nama as pendidikan'
                    ])
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 7')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) <= 15')
                    ->where(function($q) {
                        $q->whereNull('t3.nama')
                        ->orWhere('t3.nama', 'LIKE', '%TIDAK%')
                        ->orWhere('t3.nama', 'LIKE', '%BELUM SEKOLAH%')
                        ->orWhere('t3.nama', 'LIKE', '%PUTUS SEKOLAH%');
                    })
                    ->get();
            });

            $total = $data->count();
            $usiaSD = $data->filter(function($item) {
                $umur = Carbon::parse($item->tgl_lahir)->age;
                return $umur >= 7 && $umur <= 12;
            })->count();

            $usiaSMP = $data->filter(function($item) {
                $umur = Carbon::parse($item->tgl_lahir)->age;
                return $umur >= 13 && $umur <= 15;
            })->count();

            // Group by desa
            $perDesa = $data->groupBy('desa')->map(function($items) {
                return $items->count();
            })->sortDesc();

            return response()->json([
                'success' => true,
                'data' => [
                    'total' => $total,
                    'usia_sd' => $usiaSD,
                    'usia_smp' => $usiaSMP,
                    'per_desa' => $perDesa
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // Distribusi Kesesuaian Usia dan Jenjang Pendidikan Per Desa - DITAMBAHKAN CACHE
    public function getKesesuaianUsiaPerDesa()
    {
        try {
            $data = Cache::remember('pendidikan_kesesuaian_usia_per_desa_v2', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pendidikan_keluarga as t3', 't1.pendidikan', '=', 't3.id')
                    ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->select([
                        't4.name as desa',
                        't1.tgl_lahir',
                        't3.nama as pendidikan'
                    ])
                    ->get();
            });

            $result = [];

            foreach ($data->groupBy('desa') as $desa => $items) {
                $usiaSD = 0;
                $usiaSDSekolah = 0;
                $usiaSMP = 0;
                $usiaSMPSekolah = 0;
                $usiaSMA = 0;
                $usiaSMASekolah = 0;
                $wajibBelajarTidakSekolah = 0;

                foreach ($items as $item) {
                    $umur = Carbon::parse($item->tgl_lahir)->age;
                    $pendidikan = strtoupper($item->pendidikan ?? '');
                    $sedangSekolah = str_contains($pendidikan, 'SEDANG') ||
                                    str_contains($pendidikan, 'TAMAT');

                    if ($umur >= 7 && $umur <= 12) {
                        $usiaSD++;
                        if ($sedangSekolah) {
                            $usiaSDSekolah++;
                        } else {
                            if (str_contains($pendidikan, 'TIDAK') ||
                                str_contains($pendidikan, 'BELUM')) {
                                $wajibBelajarTidakSekolah++;
                            }
                        }
                    }

                    if ($umur >= 13 && $umur <= 15) {
                        $usiaSMP++;
                        if ($sedangSekolah) {
                            $usiaSMPSekolah++;
                        } else {
                            if (str_contains($pendidikan, 'TIDAK') ||
                                str_contains($pendidikan, 'BELUM')) {
                                $wajibBelajarTidakSekolah++;
                            }
                        }
                    }

                    if ($umur >= 16 && $umur <= 18) {
                        $usiaSMA++;
                        if ($sedangSekolah) {
                            $usiaSMASekolah++;
                        }
                    }
                }

                $result[] = [
                    'desa' => $desa,
                    'usia_sd_total' => $usiaSD,
                    'usia_sd_sekolah' => $usiaSDSekolah,
                    'persentase_sd' => $usiaSD > 0 ? number_format(($usiaSDSekolah / $usiaSD) * 100, 1) : 0,
                    'usia_smp_total' => $usiaSMP,
                    'usia_smp_sekolah' => $usiaSMPSekolah,
                    'persentase_smp' => $usiaSMP > 0 ? number_format(($usiaSMPSekolah / $usiaSMP) * 100, 1) : 0,
                    'usia_sma_total' => $usiaSMA,
                    'usia_sma_sekolah' => $usiaSMASekolah,
                    'persentase_sma' => $usiaSMA > 0 ? number_format(($usiaSMASekolah / $usiaSMA) * 100, 1) : 0,
                    'tidak_sekolah_wajib_belajar' => $wajibBelajarTidakSekolah
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