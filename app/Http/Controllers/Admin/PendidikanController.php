<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class PekerjaanKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index()
    {
        return view('admin.chart.pekerjaan.kecamatan');
    }

    /**
     * Statistik Jumlah - Total penduduk, laki-laki, perempuan, bekerja, tidak bekerja
     */
    public function getStatistikJumlah()
    {
        try {
            $data = Cache::remember('pekerjaan_statistik_jumlah', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->select([
                        DB::raw('COUNT(*) as total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as total_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as total_perempuan'),
                        DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as belum_bekerja'),
                        DB::raw('SUM(CASE WHEN t3.nama = "MENGURUS RUMAH TANGGA" THEN 1 ELSE 0 END) as mengurus_rumah_tangga'),
                        DB::raw('SUM(CASE WHEN t3.nama = "PELAJAR/MAHASISWA" THEN 1 ELSE 0 END) as pelajar_mahasiswa'),
                        DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("PEGAWAI NEGERI SIPIL (PNS)", "TENTARA NASIONAL INDONESIA (TNI)", "KEPOLISIAN RI (POLRI)") THEN 1 ELSE 0 END) as pns_tni_polri'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("KARYAWAN SWASTA", "KARYAWAN BUMN", "KARYAWAN BUMD") THEN 1 ELSE 0 END) as karyawan'),
                        DB::raw('SUM(CASE WHEN t3.nama LIKE "%WIRASWASTA%" OR t3.nama LIKE "%PEDAGANG%" THEN 1 ELSE 0 END) as wiraswasta'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("PETANI/PEKEBUN", "BURUH TANI/PERKEBUNAN") THEN 1 ELSE 0 END) as petani'),
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

    /**
     * Statistik Rasio - Persentase berbagai kategori pekerjaan
     */
    public function getStatistikRasio()
    {
        try {
            $data = Cache::remember('pekerjaan_statistik_rasio', self::CACHE_TTL, function () {
                $total = DB::table('t_kartu_keluarga_anggota')->count();

                if ($total == 0) {
                    return [
                        'persentase_bekerja' => '0.00',
                        'persentase_tidak_bekerja' => '0.00',
                        'tingkat_partisipasi_kerja' => '0.00',
                        'tingkat_pengangguran' => '0.00'
                    ];
                }

                $stats = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->select([
                        DB::raw('COUNT(*) as total'),
                        DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                        DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as tidak_bekerja'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64 THEN 1 ELSE 0 END) as usia_produktif'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64 AND t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as usia_produktif_bekerja'),
                    ])
                    ->first();

                $persentaseBekerja = number_format(($stats->bekerja / $total) * 100, 2);
                $persentaseTidakBekerja = number_format(($stats->tidak_bekerja / $total) * 100, 2);
                $tingkatPartisipasiKerja = $stats->usia_produktif > 0 ? number_format(($stats->usia_produktif_bekerja / $stats->usia_produktif) * 100, 2) : '0.00';

                $tidakBekerjaUsiaProduktif = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
                    ->where('t3.nama', 'BELUM/TIDAK BEKERJA')
                    ->count();

                $tingkatPengangguran = $stats->usia_produktif > 0 ? number_format(($tidakBekerjaUsiaProduktif / $stats->usia_produktif) * 100, 2) : '0.00';

                return [
                    'persentase_bekerja' => $persentaseBekerja,
                    'persentase_tidak_bekerja' => $persentaseTidakBekerja,
                    'tingkat_partisipasi_kerja' => $tingkatPartisipasiKerja,
                    'tingkat_pengangguran' => $tingkatPengangguran
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

    /**
     * Distribusi Jenis Pekerjaan
     */
    public function getDistribusiJenisPekerjaan()
    {
        try {
            $data = Cache::remember('pekerjaan_distribusi_jenis', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->select('t3.nama as pekerjaan', DB::raw('COUNT(*) as jumlah'))
                    ->whereNotNull('t3.nama')
                    ->groupBy('t3.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->limit(10)
                    ->get()
                    ->pluck('jumlah', 'pekerjaan')
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

    /**
     * Distribusi Jenis Kelamin dalam Pekerjaan
     */
    public function getDistribusiJenisKelamin()
    {
        try {
            $data = Cache::remember('pekerjaan_distribusi_jenkel', self::CACHE_TTL, function () {
                return (array) DB::table('t_kartu_keluarga_anggota as t1')
                    ->select([
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as "Laki-laki"'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as "Perempuan"')
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

    /**
     * Distribusi Per Desa
     */
    public function getDistribusiPerDesa()
    {
        try {
            $data = Cache::remember('pekerjaan_distribusi_desa', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                    ->select('t4.name as desa', DB::raw('COUNT(*) as jumlah'))
                    ->whereNotNull('t4.name')
                    ->groupBy('t4.name')
                    ->orderBy('jumlah', 'DESC')
                    ->get()
                    ->pluck('jumlah', 'desa')
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

    /**
     * Distribusi Kelompok Umur
     */
    public function getDistribusiKelompokUmur()
    {
        try {
            $data = Cache::remember('pekerjaan_distribusi_umur', self::CACHE_TTL, function () {
                return (array) DB::table('t_kartu_keluarga_anggota as t1')
                    ->select([
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15 THEN 1 ELSE 0 END) as "0-14 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 24 THEN 1 ELSE 0 END) as "15-24 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 25 AND 34 THEN 1 ELSE 0 END) as "25-34 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 35 AND 44 THEN 1 ELSE 0 END) as "35-44 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 45 AND 54 THEN 1 ELSE 0 END) as "45-54 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 55 AND 64 THEN 1 ELSE 0 END) as "55-64 tahun"'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) >= 65 THEN 1 ELSE 0 END) as "65+ tahun"')
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

    /**
     * Status Pekerjaan (Kategori Besar)
     */
    public function getStatusPekerjaan()
    {
        try {
            $data = Cache::remember('pekerjaan_status', self::CACHE_TTL, function () {
                return (array) DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->select([
                        DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as "Belum/Tidak Bekerja"'),
                        DB::raw('SUM(CASE WHEN t3.nama = "MENGURUS RUMAH TANGGA" THEN 1 ELSE 0 END) as "Mengurus Rumah Tangga"'),
                        DB::raw('SUM(CASE WHEN t3.nama = "PELAJAR/MAHASISWA" THEN 1 ELSE 0 END) as "Pelajar/Mahasiswa"'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("PEGAWAI NEGERI SIPIL (PNS)", "TENTARA NASIONAL INDONESIA (TNI)", "KEPOLISIAN RI (POLRI)") THEN 1 ELSE 0 END) as "PNS/TNI/POLRI"'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("KARYAWAN SWASTA", "KARYAWAN BUMN", "KARYAWAN BUMD", "KARYAWAN HONORER") THEN 1 ELSE 0 END) as "Karyawan"'),
                        DB::raw('SUM(CASE WHEN t3.nama LIKE "%WIRASWASTA%" OR t3.nama LIKE "%PEDAGANG%" THEN 1 ELSE 0 END) as "Wiraswasta/Pedagang"'),
                        DB::raw('SUM(CASE WHEN t3.nama IN ("PETANI/PEKEBUN", "BURUH TANI/PERKEBUNAN") THEN 1 ELSE 0 END) as "Petani"'),
                        DB::raw('SUM(CASE WHEN t3.nama LIKE "%BURUH%" AND t3.nama NOT LIKE "%TANI%" THEN 1 ELSE 0 END) as "Buruh"')
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

    /**
     * Pekerjaan Berdasarkan Umur dan Jenis Kelamin
     */
    public function getPekerjaanUmurJenisKelamin()
    {
        try {
            $data = Cache::remember('pekerjaan_umur_jenkel', self::CACHE_TTL, function () {
                $kelompokUmur = [
                    '0-14' => [0, 14],
                    '15-24' => [15, 24],
                    '25-34' => [25, 34],
                    '35-44' => [35, 44],
                    '45-54' => [45, 54],
                    '55-64' => [55, 64],
                    '65+' => [65, 150]
                ];

                $result = [];

                foreach ($kelompokUmur as $label => $range) {
                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN ? AND ?', $range)
                        ->select([
                            DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki'),
                            DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan')
                        ])
                        ->first();

                    $result[$label] = [
                        'label' => $label . ' tahun',
                        'laki' => $data->laki ?? 0,
                        'perempuan' => $data->perempuan ?? 0
                    ];
                }

                return $result;
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

    /**
     * Detail Pekerjaan Per Desa
     */
    public function getDetailPekerjaanPerDesa()
    {
        try {
            $data = Cache::remember('pekerjaan_detail_desa', self::CACHE_TTL, function () {
                $desas = DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->pluck('name', 'code');

                $result = [];

                foreach ($desas as $code => $name) {
                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->where('t2.desa', $code)
                        ->select([
                            DB::raw('COUNT(*) as total_penduduk'),
                            DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                            DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                            DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as tidak_bekerja'),
                            DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                            DB::raw('SUM(CASE WHEN t3.nama IN ("PEGAWAI NEGERI SIPIL (PNS)", "TENTARA NASIONAL INDONESIA (TNI)", "KEPOLISIAN RI (POLRI)") THEN 1 ELSE 0 END) as pns_tni_polri'),
                            DB::raw('SUM(CASE WHEN t3.nama IN ("KARYAWAN SWASTA", "KARYAWAN BUMN", "KARYAWAN BUMD") THEN 1 ELSE 0 END) as karyawan'),
                            DB::raw('SUM(CASE WHEN t3.nama LIKE "%WIRASWASTA%" OR t3.nama LIKE "%PEDAGANG%" THEN 1 ELSE 0 END) as wiraswasta'),
                            DB::raw('SUM(CASE WHEN t3.nama IN ("PETANI/PEKEBUN", "BURUH TANI/PERKEBUNAN") THEN 1 ELSE 0 END) as petani'),
                            DB::raw('SUM(CASE WHEN t3.nama = "MENGURUS RUMAH TANGGA" THEN 1 ELSE 0 END) as irt'),
                        ])
                        ->first();

                    $result[] = [
                        'desa' => $name,
                        'total_penduduk' => $data->total_penduduk,
                        'laki_laki' => $data->laki_laki,
                        'perempuan' => $data->perempuan,
                        'tidak_bekerja' => $data->tidak_bekerja,
                        'bekerja' => $data->bekerja,
                        'pns_tni_polri' => $data->pns_tni_polri,
                        'karyawan' => $data->karyawan,
                        'wiraswasta' => $data->wiraswasta,
                        'petani' => $data->petani,
                        'irt' => $data->irt
                    ];
                }

                return $result;
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

    /**
     * Analisa Usia Produktif (15-64 tahun)
     */
    public function getAnalisaUsiaProduktif()
    {
        try {
            $data = Cache::remember('pekerjaan_usia_produktif', self::CACHE_TTL, function () {
                $data = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 15 AND 64')
                    ->select([
                        DB::raw('COUNT(*) as total_usia_produktif'),
                        DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                        DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as tidak_bekerja'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                    ])
                    ->first();

                $persentaseBekerja = $data->total_usia_produktif > 0 ?
                    number_format(($data->bekerja / $data->total_usia_produktif) * 100, 2) : '0.00';

                $persentaseTidakBekerja = $data->total_usia_produktif > 0 ?
                    number_format(($data->tidak_bekerja / $data->total_usia_produktif) * 100, 2) : '0.00';

                return [
                    'total_usia_produktif' => $data->total_usia_produktif,
                    'bekerja' => $data->bekerja,
                    'tidak_bekerja' => $data->tidak_bekerja,
                    'laki_laki' => $data->laki_laki,
                    'perempuan' => $data->perempuan,
                    'persentase_bekerja' => $persentaseBekerja,
                    'persentase_tidak_bekerja' => $persentaseTidakBekerja
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

    /**
     * Pekerjaan Berdasarkan Kelompok Umur
     */
    public function getPekerjaanBerdasarkanKelompokUmur()
    {
        try {
            $data = Cache::remember('pekerjaan_kelompok_umur', self::CACHE_TTL, function () {
                $kelompokUmur = [
                    '15-24' => [15, 24],
                    '25-34' => [25, 34],
                    '35-44' => [35, 44],
                    '45-54' => [45, 54],
                    '55-64' => [55, 64],
                ];

                $result = [];

                foreach ($kelompokUmur as $label => $range) {
                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN ? AND ?', $range)
                        ->select([
                            DB::raw('COUNT(*) as total'),
                            DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                            DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as tidak_bekerja'),
                        ])
                        ->first();

                    $result[] = [
                        'label' => $label . ' tahun',
                        'total' => $data->total,
                        'bekerja' => $data->bekerja,
                        'tidak_bekerja' => $data->tidak_bekerja
                    ];
                }

                return $result;
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

    /**
     * DataTable - Daftar Lengkap Penduduk dengan Pekerjaan
     * NOTE: DataTable tidak menggunakan cache karena sifatnya real-time dan ada filter
     */
    public function getDatatablePenduduk(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't1.jenkel',
                    't1.tgl_lahir',
                    't2.rt',
                    't2.rw',
                    't3.nama as pekerjaan',
                    't4.name as desa',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur')
                ]);

            if ($request->has('desa') && $request->desa != '') {
                $query->where('t2.desa', $request->desa);
            }

            if ($request->has('status_pekerjaan') && $request->status_pekerjaan != '') {
                $status = $request->status_pekerjaan;

                if ($status == 'bekerja') {
                    $query->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'MENGURUS RUMAH TANGGA', 'PELAJAR/MAHASISWA'])
                          ->whereNotNull('t3.nama');
                } elseif ($status == 'tidak_bekerja') {
                    $query->where('t3.nama', 'BELUM/TIDAK BEKERJA');
                } elseif ($status == 'irt') {
                    $query->where('t3.nama', 'MENGURUS RUMAH TANGGA');
                } elseif ($status == 'pelajar') {
                    $query->where('t3.nama', 'PELAJAR/MAHASISWA');
                }
            }

            if ($request->has('jenkel') && $request->jenkel != '') {
                $query->where('t1.jenkel', $request->jenkel);
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    if ($row->jenkel == 1) {
                        return '<span class="badge badge-info badge-lg"><i class="fas fa-male mr-1"></i>Laki-laki</span>';
                    } else {
                        return '<span class="badge badge-danger badge-lg"><i class="fas fa-female mr-1"></i>Perempuan</span>';
                    }
                })
                ->addColumn('umur_display', function($row) {
                    return '<span class="badge badge-secondary badge-lg">' . $row->umur . ' th</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return '<small class="text-muted">' . Carbon::parse($row->tgl_lahir)->format('d/m/Y') . '</small>';
                })
                ->addColumn('rt_rw', function($row) {
                    return '<small class="text-muted">RT ' . $row->rt . ' / RW ' . $row->rw . '</small>';
                })
                ->addColumn('kategori_usia', function($row) {
                    $umur = $row->umur;
                    if ($umur < 15) {
                        return '<span class="badge badge-warning">Anak-anak</span>';
                    } elseif ($umur >= 15 && $umur <= 64) {
                        return '<span class="badge badge-success">Usia Produktif</span>';
                    } else {
                        return '<span class="badge badge-secondary">Lansia</span>';
                    }
                })
                ->addColumn('status_bekerja', function($row) {
                    if ($row->pekerjaan == 'BELUM/TIDAK BEKERJA') {
                        return '<span class="badge badge-danger">Tidak Bekerja</span>';
                    } elseif ($row->pekerjaan == 'MENGURUS RUMAH TANGGA') {
                        return '<span class="badge badge-info">IRT</span>';
                    } elseif ($row->pekerjaan == 'PELAJAR/MAHASISWA') {
                        return '<span class="badge badge-primary">Pelajar/Mahasiswa</span>';
                    } else {
                        return '<span class="badge badge-success">Bekerja</span>';
                    }
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'tgl_lahir_display', 'rt_rw', 'kategori_usia', 'status_bekerja'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * List Desa untuk Filter
     */
    public function getListDesa()
    {
        try {
            $data = Cache::remember('pekerjaan_list_desa', self::CACHE_TTL, function () {
                return DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->select('code', 'name')
                    ->orderBy('name')
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

    /**
     * Top 10 Pekerjaan Terbanyak
     */
    public function getTop10Pekerjaan()
    {
        try {
            $data = Cache::remember('pekerjaan_top10', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->select('t3.nama as pekerjaan', DB::raw('COUNT(*) as jumlah'))
                    ->whereNotNull('t3.nama')
                    ->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA'])
                    ->groupBy('t3.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->limit(10)
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

    /**
     * Pekerjaan Per Desa (untuk chart stacked)
     */
    public function getPekerjaanPerDesa()
    {
        try {
            $data = Cache::remember('pekerjaan_per_desa_stacked', self::CACHE_TTL, function () {
                $desas = DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->pluck('name', 'code');

                $result = [
                    'labels' => [],
                    'datasets' => [
                        [
                            'label' => 'Bekerja',
                            'data' => [],
                            'backgroundColor' => '#28a745'
                        ],
                        [
                            'label' => 'Tidak Bekerja',
                            'data' => [],
                            'backgroundColor' => '#dc3545'
                        ],
                        [
                            'label' => 'IRT',
                            'data' => [],
                            'backgroundColor' => '#17a2b8'
                        ],
                        [
                            'label' => 'Pelajar/Mahasiswa',
                            'data' => [],
                            'backgroundColor' => '#ffc107'
                        ]
                    ]
                ];

                foreach ($desas as $code => $name) {
                    $result['labels'][] = $name;

                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->where('t2.desa', $code)
                        ->select([
                            DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "MENGURUS RUMAH TANGGA", "PELAJAR/MAHASISWA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                            DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" THEN 1 ELSE 0 END) as tidak_bekerja'),
                            DB::raw('SUM(CASE WHEN t3.nama = "MENGURUS RUMAH TANGGA" THEN 1 ELSE 0 END) as irt'),
                            DB::raw('SUM(CASE WHEN t3.nama = "PELAJAR/MAHASISWA" THEN 1 ELSE 0 END) as pelajar'),
                        ])
                        ->first();

                    $result['datasets'][0]['data'][] = $data->bekerja;
                    $result['datasets'][1]['data'][] = $data->tidak_bekerja;
                    $result['datasets'][2]['data'][] = $data->irt;
                    $result['datasets'][3]['data'][] = $data->pelajar;
                }

                return $result;
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

    /**
     * Analisis Pekerja Anak (Usia di bawah 15 tahun yang bekerja)
     */
    public function getAnalisisPekerjaAnak()
    {
        try {
            $data = Cache::remember('pekerjaan_analisis_pekerja_anak', self::CACHE_TTL, function () {
                $pekerjaAnak = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15')
                    ->where(function($query) {
                        $query->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA'])
                            ->whereNotNull('t3.nama');
                    })
                    ->select([
                        DB::raw('COUNT(*) as total_pekerja_anak'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) as laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) as perempuan'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 10 THEN 1 ELSE 0 END) as usia_di_bawah_10'),
                        DB::raw('SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 10 AND 14 THEN 1 ELSE 0 END) as usia_10_14'),
                    ])
                    ->first();

                $totalAnak = DB::table('t_kartu_keluarga_anggota')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 15')
                    ->count();

                $persentase = $totalAnak > 0 ?
                    number_format(($pekerjaAnak->total_pekerja_anak / $totalAnak) * 100, 2) : '0.00';

                return [
                    'total_pekerja_anak' => $pekerjaAnak->total_pekerja_anak,
                    'laki_laki' => $pekerjaAnak->laki_laki,
                    'perempuan' => $pekerjaAnak->perempuan,
                    'usia_di_bawah_10' => $pekerjaAnak->usia_di_bawah_10,
                    'usia_10_14' => $pekerjaAnak->usia_10_14,
                    'total_anak' => $totalAnak,
                    'persentase' => $persentase,
                    'status' => $pekerjaAnak->total_pekerja_anak > 0 ? 'perlu_perhatian' : 'aman'
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

    /**
     * Analisis Kesejahteraan Anak per Kelompok Umur
     */
    public function getAnalisisKesejahteraanAnak()
    {
        try {
            $data = Cache::remember('pekerjaan_kesejahteraan_anak', self::CACHE_TTL, function () {
                $kelompokUmur = [
                    '0-4' => [0, 4, 'Balita'],
                    '5-9' => [5, 9, 'Anak Usia SD'],
                    '10-14' => [10, 14, 'Anak Usia SMP'],
                ];

                $result = [];

                foreach ($kelompokUmur as $key => $range) {
                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN ? AND ?', [$range[0], $range[1]])
                        ->select([
                            DB::raw('COUNT(*) as total'),
                            DB::raw('SUM(CASE WHEN t3.nama = "PELAJAR/MAHASISWA" THEN 1 ELSE 0 END) as sekolah'),
                            DB::raw('SUM(CASE WHEN t3.nama = "BELUM/TIDAK BEKERJA" OR t3.nama IS NULL THEN 1 ELSE 0 END) as tidak_bekerja_tidak_sekolah'),
                            DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "PELAJAR/MAHASISWA", "MENGURUS RUMAH TANGGA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as bekerja'),
                        ])
                        ->first();

                    $persenSekolah = $data->total > 0 ? number_format(($data->sekolah / $data->total) * 100, 1) : '0.0';
                    $persenBekerja = $data->total > 0 ? number_format(($data->bekerja / $data->total) * 100, 1) : '0.0';

                    $result[] = [
                        'label' => $range[2] . ' (' . $key . ' tahun)',
                        'total' => $data->total,
                        'sekolah' => $data->sekolah,
                        'bekerja' => $data->bekerja,
                        'tidak_bekerja_tidak_sekolah' => $data->tidak_bekerja_tidak_sekolah,
                        'persen_sekolah' => $persenSekolah,
                        'persen_bekerja' => $persenBekerja,
                        'status' => $data->bekerja > 0 ? 'perlu_perhatian' : 'normal'
                    ];
                }

                return $result;
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

    /**
     * Detail Pekerja Anak Per Desa
     */
    public function getPekerjaAnakPerDesa()
    {
        try {
            $data = Cache::remember('pekerjaan_pekerja_anak_per_desa', self::CACHE_TTL, function () {
                $desas = DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->pluck('name', 'code');

                $result = [];

                foreach ($desas as $code => $name) {
                    $data = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->where('t2.desa', $code)
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15')
                        ->select([
                            DB::raw('COUNT(*) as total_anak'),
                            DB::raw('SUM(CASE WHEN t3.nama = "PELAJAR/MAHASISWA" THEN 1 ELSE 0 END) as sekolah'),
                            DB::raw('SUM(CASE WHEN t3.nama NOT IN ("BELUM/TIDAK BEKERJA", "PELAJAR/MAHASISWA", "MENGURUS RUMAH TANGGA") AND t3.nama IS NOT NULL THEN 1 ELSE 0 END) as pekerja_anak'),
                            DB::raw('SUM(CASE WHEN (t3.nama = "BELUM/TIDAK BEKERJA" OR t3.nama IS NULL) THEN 1 ELSE 0 END) as tidak_sekolah_tidak_bekerja'),
                        ])
                        ->first();

                    $persenSekolah = $data->total_anak > 0 ?
                        number_format(($data->sekolah / $data->total_anak) * 100, 1) : '0.0';

                    $tingkatRisiko = 'Rendah';
                    if ($data->pekerja_anak > 5) $tingkatRisiko = 'Tinggi';
                    elseif ($data->pekerja_anak > 2) $tingkatRisiko = 'Sedang';

                    $result[] = [
                        'desa' => $name,
                        'total_anak' => $data->total_anak,
                        'sekolah' => $data->sekolah,
                        'pekerja_anak' => $data->pekerja_anak,
                        'tidak_sekolah_tidak_bekerja' => $data->tidak_sekolah_tidak_bekerja,
                        'persen_sekolah' => $persenSekolah,
                        'tingkat_risiko' => $tingkatRisiko
                    ];
                }

                return $result;
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

    /**
     * Jenis Pekerjaan yang Dilakukan Anak-anak
     */
    public function getJenisPekerjaanAnak()
    {
        try {
            $data = Cache::remember('pekerjaan_jenis_pekerja_anak', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15')
                    ->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA'])
                    ->whereNotNull('t3.nama')
                    ->select('t3.nama as pekerjaan', DB::raw('COUNT(*) as jumlah'))
                    ->groupBy('t3.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->get()
                    ->pluck('jumlah', 'pekerjaan')
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

    /**
     * DataTable Pekerja Anak untuk Tindak Lanjut
     * NOTE: DataTable tidak menggunakan cache karena ada filter dinamis
     */
    public function getDatatablePekerjaAnak(Request $request)
    {
        try {
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                ->leftJoin('indonesia_villages as t4', 't4.code', '=', 't2.desa')
                ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15')
                ->where(function($q) {
                    $q->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA'])
                      ->whereNotNull('t3.nama');
                })
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't1.jenkel',
                    't1.tgl_lahir',
                    't2.rt',
                    't2.rw',
                    't3.nama as pekerjaan',
                    't4.name as desa',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) as umur')
                ]);

            if ($request->filled('desa')) {
                $query->where('t2.desa', $request->desa);
            }

            if ($request->filled('jenkel')) {
                $query->where('t1.jenkel', $request->jenkel);
            }

            if ($request->filled('kelompok_umur')) {
                if ($request->kelompok_umur == '0-9') {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 10');
                } elseif ($request->kelompok_umur == '10-14') {
                    $query->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 10 AND 14');
                }
            }

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', function ($row) {
                    return $this->maskNumber($row->no_nik);
                })
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', function($row) {
                    return $row->jenkel == 1
                        ? '<span class="badge badge-info"><i class="fas fa-male mr-1"></i>L</span>'
                        : '<span class="badge badge-danger"><i class="fas fa-female mr-1"></i>P</span>';
                })
                ->addColumn('umur_display', function($row) {
                    $badge = $row->umur < 10 ? 'danger' : 'warning';
                    return '<span class="badge badge-'.$badge.'">' . $row->umur . ' th</span>';
                })
                ->addColumn('tgl_lahir_display', function($row) {
                    return Carbon::parse($row->tgl_lahir)->format('d/m/Y');
                })
                ->addColumn('rt_rw', function($row) {
                    return 'RT '.$row->rt.' / RW '.$row->rw;
                })
                ->addColumn('tingkat_bahaya', function($row) {
                    if ($row->umur < 10) {
                        return '<span class="badge badge-danger">Sangat Tinggi</span>';
                    } elseif ($row->umur < 13) {
                        return '<span class="badge badge-warning">Tinggi</span>';
                    }
                    return '<span class="badge badge-info">Sedang</span>';
                })
                ->rawColumns(['jenkel_display', 'umur_display', 'tingkat_bahaya'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Indikator Kesejahteraan Anak per Desa
     */
    public function getIndikatorKesejahteraanAnak()
    {
        try {
            $data = Cache::remember('pekerjaan_indikator_kesejahteraan_anak', self::CACHE_TTL, function () {
                $desas = DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('desa')
                            ->from('t_kartu_keluarga')
                            ->distinct();
                    })
                    ->pluck('name', 'code');

                $result = [];

                foreach ($desas as $code => $name) {
                    $totalAnakWajibBelajar = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->where('t2.desa', $code)
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 7 AND 15')
                        ->count();

                    $sekolahWajibBelajar = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->where('t2.desa', $code)
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 7 AND 15')
                        ->where('t3.nama', 'PELAJAR/MAHASISWA')
                        ->count();

                    $pekerjaAnakWajibBelajar = DB::table('t_kartu_keluarga_anggota as t1')
                        ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                        ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                        ->where('t2.desa', $code)
                        ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) BETWEEN 7 AND 15')
                        ->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA'])
                        ->whereNotNull('t3.nama')
                        ->count();

                    $angkaPartisipasiSekolah = $totalAnakWajibBelajar > 0 ?
                        number_format(($sekolahWajibBelajar / $totalAnakWajibBelajar) * 100, 1) : '0.0';

                    $angkaPekerjaAnak = $totalAnakWajibBelajar > 0 ?
                        number_format(($pekerjaAnakWajibBelajar / $totalAnakWajibBelajar) * 100, 1) : '0.0';

                    $score = 100;
                    if ($angkaPartisipasiSekolah < 90) $score -= 30;
                    elseif ($angkaPartisipasiSekolah < 95) $score -= 15;

                    if ($pekerjaAnakWajibBelajar > 0) $score -= (min($pekerjaAnakWajibBelajar, 10) * 5);

                    $kategori = 'Sangat Baik';
                    $warna = 'success';
                    if ($score < 60) {
                        $kategori = 'Perlu Perhatian Serius';
                        $warna = 'danger';
                    } elseif ($score < 75) {
                        $kategori = 'Perlu Perbaikan';
                        $warna = 'warning';
                    } elseif ($score < 90) {
                        $kategori = 'Cukup Baik';
                        $warna = 'info';
                    }

                    $result[] = [
                        'desa' => $name,
                        'total_anak_wajib_belajar' => $totalAnakWajibBelajar,
                        'sekolah' => $sekolahWajibBelajar,
                        'pekerja_anak' => $pekerjaAnakWajibBelajar,
                        'angka_partisipasi_sekolah' => $angkaPartisipasiSekolah,
                        'angka_pekerja_anak' => $angkaPekerjaAnak,
                        'score' => $score,
                        'kategori' => $kategori,
                        'warna' => $warna
                    ];
                }

                return $result;
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

    /**
     * Get List Desa untuk Filter Pekerja Anak
     */
    public function getListDesaPekerjaAnak()
    {
        try {
            $data = Cache::remember('pekerjaan_list_desa_pekerja_anak', self::CACHE_TTL, function () {
                return DB::table('indonesia_villages')
                    ->whereIn('code', function($query) {
                        $query->select('t2.desa')
                            ->from('t_kartu_keluarga_anggota as t1')
                            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                            ->leftJoin('m_pekerjaan as t3', 't1.jns_pekerjaan', '=', 't3.id')
                            ->whereRaw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 15')
                            ->whereNotIn('t3.nama', ['BELUM/TIDAK BEKERJA', 'PELAJAR/MAHASISWA', 'MENGURUS RUMAH TANGGA'])
                            ->whereNotNull('t3.nama')
                            ->distinct();
                    })
                    ->select('code', 'name')
                    ->orderBy('name')
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

    /**
     * Mask NIK untuk privacy
     */
    private function maskNumber($number)
    {
        if (!$number || strlen($number) < 16) {
            return $number;
        }

        return substr($number, 0, 3)
            . str_repeat('*', 10)
            . substr($number, -3);
    }

    /**
     * Clear All Cache Pekerjaan
     */
    public function clearCache()
    {
        $cacheKeys = [
            'pekerjaan_statistik_jumlah',
            'pekerjaan_statistik_rasio',
            'pekerjaan_distribusi_jenis',
            'pekerjaan_distribusi_jenkel',
            'pekerjaan_distribusi_desa',
            'pekerjaan_distribusi_umur',
            'pekerjaan_status',
            'pekerjaan_umur_jenkel',
            'pekerjaan_detail_desa',
            'pekerjaan_usia_produktif',
            'pekerjaan_kelompok_umur',
            'pekerjaan_list_desa',
            'pekerjaan_top10',
            'pekerjaan_per_desa_stacked',
            'pekerjaan_analisis_pekerja_anak',
            'pekerjaan_kesejahteraan_anak',
            'pekerjaan_pekerja_anak_per_desa',
            'pekerjaan_jenis_pekerja_anak',
            'pekerjaan_indikator_kesejahteraan_anak',
            'pekerjaan_list_desa_pekerja_anak',
        ];

        foreach ($cacheKeys as $key) {
            Cache::forget($key);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cache berhasil dihapus'
        ]);
    }
}
