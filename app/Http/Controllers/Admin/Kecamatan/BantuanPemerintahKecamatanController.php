<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class BantuanPemerintahKecamatanController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    // ─────────────────────────────────────────────
    // Base Query Builder (DRY)
    // ─────────────────────────────────────────────
    private function baseQuery()
    {
        return DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoin('bantuan_pemerintah as t4', 't4.Id', '=', 't1.bantuan_pemerintah');
    }

    // ─────────────────────────────────────────────
    // INDEX – Halaman utama statistik
    // ─────────────────────────────────────────────
    public function index()
    {
        return view('admin.chart.bantuan-pemerintah.kecamatan');
    }

    // ─────────────────────────────────────────────
    // 1. Statistik Jumlah (Ringkasan Angka)
    // ─────────────────────────────────────────────
    public function statistikJumlah()
    {
        try {
            $data = Cache::remember('bantuan_statistik_jumlah', self::CACHE_TTL, function() {
                return $this->baseQuery()
                    ->select([
                        DB::raw('COUNT(*) AS total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) AS total_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) AS total_perempuan'),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' THEN 1 ELSE 0 END) AS layak"),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Tidak Layak' THEN 1 ELSE 0 END) AS tidak_layak"),
                        // Bantuan berbasis NIK (individu)
                        DB::raw("SUM(CASE WHEN t4.nama = 'Belum Pernah Dapat Bantuan' THEN 1 ELSE 0 END) AS belum_dapat"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Bantuan Pangan Non Tunai (BPNT)' THEN 1 ELSE 0 END) AS bpnt"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Bantuan Langsung Tunai (BLT)' THEN 1 ELSE 0 END) AS blt"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Program Keluarga Harapan (PKH)' THEN 1 ELSE 0 END) AS pkh"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'BSU Ketenagakerjaan' THEN 1 ELSE 0 END) AS bsu"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Bantuan Pemerintah Lainnya' THEN 1 ELSE 0 END) AS lainnya"),
                    ])
                    ->first();
            });

            return response()->json([
                'success' => true,
                'data'    => [
                    'total_penduduk' => (int) $data->total_penduduk,
                    'total_laki'     => (int) $data->total_laki,
                    'total_perempuan'=> (int) $data->total_perempuan,
                    'layak'          => (int) $data->layak,
                    'tidak_layak'    => (int) $data->tidak_layak,
                    'belum_dapat'    => (int) $data->belum_dapat,
                    'bpnt'           => (int) $data->bpnt,
                    'blt'            => (int) $data->blt,
                    'pkh'            => (int) $data->pkh,
                    'bsu'            => (int) $data->bsu,
                    'lainnya'        => (int) $data->lainnya,
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 2. Statistik Rasio
    // ─────────────────────────────────────────────
    public function statistikRasio()
    {
        try {
            $data = Cache::remember('bantuan_statistik_rasio', self::CACHE_TTL, function() {
                $raw = $this->baseQuery()
                    ->select([
                        DB::raw('COUNT(*) AS total'),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' THEN 1 ELSE 0 END) AS layak"),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Tidak Layak' THEN 1 ELSE 0 END) AS tidak_layak"),
                    ])
                    ->first();

                $total      = (int) $raw->total;
                $layak      = (int) $raw->layak;
                $tidakLayak = (int) $raw->tidak_layak;

                $pctLayak  = $total > 0 ? round(($layak / $total) * 100, 2)      : 0;
                $pctTidak  = $total > 0 ? round(($tidakLayak / $total) * 100, 2) : 0;
                $rasio     = $tidakLayak > 0 ? round($layak / $tidakLayak, 2)     : $layak;

                return [
                    'persentase_layak'       => $pctLayak,
                    'persentase_tidak_layak' => $pctTidak,
                    'rasio_kelayakan'        => $rasio,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 3. Distribusi Jenis Bantuan
    // ─────────────────────────────────────────────
    public function distribusiJenisBantuan()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_jenis', self::CACHE_TTL, function() {
                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("COALESCE(t4.nama, 'Tidak Ada Bantuan') AS jenis_bantuan"),
                        DB::raw('COUNT(*) AS jumlah'),
                    ])
                    ->groupBy('t4.nama')
                    ->orderByDesc('jumlah')
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->jenis_bantuan] = (int) $row->jumlah;
                }
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 4. Distribusi Jenis Kelamin
    // ─────────────────────────────────────────────
    public function distribusiJenkel()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_jenkel', self::CACHE_TTL, function() {
                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("CASE WHEN t1.jenkel = 1 THEN 'Laki-laki' ELSE 'Perempuan' END AS label"),
                        DB::raw('COUNT(*) AS jumlah'),
                    ])
                    ->whereIn('t1.jenkel', [1, 2])
                    ->groupBy('t1.jenkel')
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->label] = (int) $row->jumlah;
                }
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 5. Distribusi Per Desa (Penerima Bantuan)
    // ─────────────────────────────────────────────
    public function distribusiPerDesa()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_desa', self::CACHE_TTL, function() {
                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("COALESCE(t3.name, 'Tidak Diketahui') AS desa"),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' THEN 1 ELSE 0 END) AS layak"),
                    ])
                    ->groupBy('t3.name', 't2.desa')
                    ->orderBy('t3.name')
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->desa] = (int) $row->layak;
                }
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 6. Distribusi Kelompok Umur
    // ─────────────────────────────────────────────
    public function distribusiUmur()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_umur', self::CACHE_TTL, function() {
                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 5   THEN '0-4'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 13  THEN '5-12'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18  THEN '13-17'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 26  THEN '18-25'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 36  THEN '26-35'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 46  THEN '36-45'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 56  THEN '46-55'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 65  THEN '56-64'
                                ELSE '65+'
                            END AS kelompok_umur
                        "),
                        DB::raw('COUNT(*) AS jumlah'),
                    ])
                    ->groupBy('kelompok_umur')
                    ->orderBy(DB::raw("
                        CASE
                            WHEN CASE
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 5   THEN '0-4'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 13  THEN '5-12'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18  THEN '13-17'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 26  THEN '18-25'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 36  THEN '26-35'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 46  THEN '36-45'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 56  THEN '46-55'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 65  THEN '56-64'
                                ELSE '65+'
                            END = '0-4' THEN 1
                            WHEN CASE
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 5   THEN '0-4'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 13  THEN '5-12'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18  THEN '13-17'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 26  THEN '18-25'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 36  THEN '26-35'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 46  THEN '36-45'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 56  THEN '46-55'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 65  THEN '56-64'
                                ELSE '65+'
                            END = '5-12' THEN 2
                            ELSE 3
                        END
                    "))
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->kelompok_umur] = (int) $row->jumlah;
                }
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 7. Bantuan per Umur & Gender (Grouped Bar)
    // ─────────────────────────────────────────────
    public function distribusiUmurJenkel()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_umur_jenkel', self::CACHE_TTL, function() {
                $kelompokUrutan = ['0-4','5-12','13-17','18-25','26-35','36-45','46-55','56-64','65+'];

                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("
                            CASE
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 5  THEN '0-4'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 13 THEN '5-12'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 18 THEN '13-17'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 26 THEN '18-25'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 36 THEN '26-35'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 46 THEN '36-45'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 56 THEN '46-55'
                                WHEN TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) < 65 THEN '56-64'
                                ELSE '65+'
                            END AS kelompok_umur
                        "),
                        't1.jenkel',
                        DB::raw('COUNT(*) AS jumlah'),
                    ])
                    ->groupBy('kelompok_umur', 't1.jenkel')
                    ->get();

                $grouped = [];
                foreach ($rows as $row) {
                    $k = $row->kelompok_umur;
                    if (!isset($grouped[$k])) {
                        $grouped[$k] = ['label' => $k, 'laki' => 0, 'perempuan' => 0];
                    }
                    if ($row->jenkel == 1) {
                        $grouped[$k]['laki'] = (int) $row->jumlah;
                    } else {
                        $grouped[$k]['perempuan'] = (int) $row->jumlah;
                    }
                }

                // Sort sesuai urutan
                $result = [];
                foreach ($kelompokUrutan as $k) {
                    if (isset($grouped[$k])) {
                        $result[$k] = $grouped[$k];
                    }
                }
                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 8. Jenis Bantuan Per Desa (Stacked Bar)
    // ─────────────────────────────────────────────
    public function distribusiBantuanPerDesa()
    {
        try {
            $data = Cache::remember('bantuan_distribusi_per_desa', self::CACHE_TTL, function() {
                $jenisBantuan = [
                    'Belum Pernah Dapat Bantuan',
                    'Bantuan Pangan Non Tunai (BPNT)',
                    'Bantuan Langsung Tunai (BLT)',
                    'Program Keluarga Harapan (PKH)',
                    'BSU Ketenagakerjaan',
                    'Bantuan Pemerintah Lainnya',
                ];

                $rows = $this->baseQuery()
                    ->select([
                        DB::raw("COALESCE(t3.name, 'Tidak Diketahui') AS desa"),
                        DB::raw("COALESCE(t4.nama, 'Tidak Ada Data') AS jenis_bantuan"),
                        DB::raw('COUNT(*) AS jumlah'),
                    ])
                    ->groupBy('t3.name', 't2.desa', 't4.nama')
                    ->orderBy('t3.name')
                    ->get();

                // Kumpulkan label desa unik
                $desas = $rows->pluck('desa')->unique()->sort()->values()->toArray();

                // Bangun datasets per jenis bantuan
                $datasetColors = [
                    '#28a745', // Belum Dapat – hijau
                    '#007bff', // BPNT – biru
                    '#ffc107', // BLT – kuning
                    '#17a2b8', // PKH – cyan
                    '#6f42c1', // BSU – ungu
                    '#fd7e14', // Lainnya – oranye
                ];

                $datasets = [];
                foreach ($jenisBantuan as $idx => $jenis) {
                    $row_data = [];
                    foreach ($desas as $desa) {
                        $found = $rows->first(fn($r) => $r->desa === $desa && $r->jenis_bantuan === $jenis);
                        $row_data[] = $found ? (int) $found->jumlah : 0;
                    }
                    $datasets[] = [
                        'label'           => $jenis,
                        'data'            => $row_data,
                        'backgroundColor' => $datasetColors[$idx],
                        'borderColor'     => $datasetColors[$idx],
                        'borderWidth'     => 1,
                        'borderRadius'    => 4,
                    ];
                }

                return [
                    'labels'   => $desas,
                    'datasets' => $datasets,
                ];
            });

            return response()->json([
                'success' => true,
                'data'    => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 9. Detail Per Desa (Tabel Ringkasan)
    // ─────────────────────────────────────────────
    public function detailPerDesa()
    {
        try {
            $data = Cache::remember('bantuan_detail_desa', self::CACHE_TTL, function() {
                return $this->baseQuery()
                    ->select([
                        DB::raw("COALESCE(t3.name, 'Tidak Diketahui') AS desa"),
                        DB::raw('COUNT(*) AS total_penduduk'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END) AS laki_laki'),
                        DB::raw('SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END) AS perempuan'),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' THEN 1 ELSE 0 END) AS layak"),
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Tidak Layak' THEN 1 ELSE 0 END) AS tidak_layak"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Bantuan Pangan Non Tunai (BPNT)' THEN 1 ELSE 0 END) AS bpnt"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Bantuan Langsung Tunai (BLT)' THEN 1 ELSE 0 END) AS blt"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Program Keluarga Harapan (PKH)' THEN 1 ELSE 0 END) AS pkh"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'BSU Ketenagakerjaan' THEN 1 ELSE 0 END) AS bsu"),
                        DB::raw("SUM(CASE WHEN t4.nama = 'Belum Pernah Dapat Bantuan' THEN 1 ELSE 0 END) AS belum_dapat"),
                    ])
                    ->groupBy('t3.name', 't2.desa')
                    ->orderBy('t3.name')
                    ->get();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 10. Data Abnormal (Inkonsistensi Data)
    // ─────────────────────────────────────────────
    public function dataAbnormal()
    {
        try {
            $data = Cache::remember('bantuan_data_abnormal', self::CACHE_TTL, function() {
                $counts = $this->baseQuery()
                    ->select([
                        // Layak tapi tidak ada bantuan sama sekali (bantuan_pemerintah NULL)
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' AND t1.bantuan_pemerintah IS NULL THEN 1 ELSE 0 END) AS layak_tanpa_bantuan"),
                        // Layak tapi isi bantuan = "Belum Pernah Dapat Bantuan"
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Layak' AND t4.nama = 'Belum Pernah Dapat Bantuan' THEN 1 ELSE 0 END) AS layak_belum_dapat"),
                        // Tidak Layak tapi ada data bantuan (selain null & bukan "Belum Pernah")
                        DB::raw("SUM(CASE WHEN t1.tanya_bantuanpemerintah = 'Tidak Layak' AND t4.nama IS NOT NULL AND t4.nama != 'Belum Pernah Dapat Bantuan' THEN 1 ELSE 0 END) AS tidak_layak_ada_bantuan"),
                    ])
                    ->first();

                return [
                    'Layak Tanpa Data Bantuan'        => (int) $counts->layak_tanpa_bantuan,
                    'Layak tapi Belum Pernah Dapat'   => (int) $counts->layak_belum_dapat,
                    'Tidak Layak tapi Ada Bantuan'    => (int) $counts->tidak_layak_ada_bantuan,
                ];
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 11. List Desa (untuk select2 filter)
    // ─────────────────────────────────────────────
    public function listDesa()
    {
        try {
            $data = Cache::remember('bantuan_list_desa', self::CACHE_TTL, function() {
                return DB::table('t_kartu_keluarga as t2')
                    ->join('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->select('t3.code', 't3.name')
                    ->groupBy('t3.code', 't3.name')
                    ->orderBy('t3.name')
                    ->get();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // ─────────────────────────────────────────────
    // 12. DataTable – Data Abnormal
    // ─────────────────────────────────────────────
    public function datatableAbnormal(Request $request)
    {
        $query = $this->baseQuery()
            ->select([
                't1.no_nik',
                't1.nama',
                't3.name as desa',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't1.tanya_bantuanpemerintah',
                't4.nama AS nama_bantuan',
                't1.bantuan_pemerintah',
            ])
            ->where(function ($q) {
                $q->where(function ($q2) {
                    // Layak tapi tidak ada bantuan
                    $q2->where('t1.tanya_bantuanpemerintah', 'Layak')
                       ->whereNull('t1.bantuan_pemerintah');
                })->orWhere(function ($q2) {
                    // Layak tapi "Belum Pernah Dapat Bantuan"
                    $q2->where('t1.tanya_bantuanpemerintah', 'Layak')
                       ->where('t4.nama', 'Belum Pernah Dapat Bantuan');
                })->orWhere(function ($q2) {
                    // Tidak Layak tapi memiliki bantuan selain "Belum Pernah"
                    $q2->where('t1.tanya_bantuanpemerintah', 'Tidak Layak')
                       ->whereNotNull('t1.bantuan_pemerintah')
                       ->where('t4.nama', '!=', 'Belum Pernah Dapat Bantuan');
                });
            });

        // Filter kategori
        if ($request->kategori) {
            if ($request->kategori === 'Layak Tanpa Data Bantuan') {
                $query->where('t1.tanya_bantuanpemerintah', 'Layak')->whereNull('t1.bantuan_pemerintah');
            } elseif ($request->kategori === 'Layak tapi Belum Pernah Dapat') {
                $query->where('t1.tanya_bantuanpemerintah', 'Layak')->where('t4.nama', 'Belum Pernah Dapat Bantuan');
            } elseif ($request->kategori === 'Tidak Layak tapi Ada Bantuan') {
                $query->where('t1.tanya_bantuanpemerintah', 'Tidak Layak')
                      ->whereNotNull('t1.bantuan_pemerintah')
                      ->where('t4.nama', '!=', 'Belum Pernah Dapat Bantuan');
            }
        }

        // Filter desa
        if ($request->desa) {
            $query->where('t2.desa', $request->desa);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->addColumn('jenkel_display', function ($row) {
                $icon  = $row->jenkel == 1
                    ? '<i class="fas fa-male text-info"></i> Laki-laki'
                    : '<i class="fas fa-female text-danger"></i> Perempuan';
                return '<span class="badge badge-' . ($row->jenkel == 1 ? 'info' : 'danger') . '">' . $icon . '</span>';
            })
            ->addColumn('umur_display', function ($row) {
                $umur = $row->tgl_lahir
                    ? \Carbon\Carbon::parse($row->tgl_lahir)->age
                    : '-';
                return '<span class="badge badge-secondary">' . $umur . ' thn</span>';
            })
            ->addColumn('tgl_lahir_display', function ($row) {
                return $row->tgl_lahir
                    ? \Carbon\Carbon::parse($row->tgl_lahir)->format('d/m/Y')
                    : '-';
            })
            ->addColumn('kategori_badge', function ($row) {
                if ($row->tanya_bantuanpemerintah === 'Layak' && is_null($row->bantuan_pemerintah)) {
                    return '<span class="badge badge-warning">Layak Tanpa Data Bantuan</span>';
                }
                if ($row->tanya_bantuanpemerintah === 'Layak' && $row->nama_bantuan === 'Belum Pernah Dapat Bantuan') {
                    return '<span class="badge badge-warning">Layak tapi Belum Pernah Dapat</span>';
                }
                return '<span class="badge badge-danger">Tidak Layak tapi Ada Bantuan</span>';
            })
            ->addColumn('detail_masalah', function ($row) {
                if ($row->tanya_bantuanpemerintah === 'Layak' && is_null($row->bantuan_pemerintah)) {
                    return '<small class="text-warning">Status layak namun kolom bantuan kosong</small>';
                }
                if ($row->tanya_bantuanpemerintah === 'Layak' && $row->nama_bantuan === 'Belum Pernah Dapat Bantuan') {
                    return '<small class="text-warning">Layak namun diisi "Belum Pernah Dapat"</small>';
                }
                return '<small class="text-danger">Tidak layak tapi tercatat: ' . ($row->nama_bantuan ?? '-') . '</small>';
            })
            ->rawColumns(['jenkel_display', 'umur_display', 'kategori_badge', 'detail_masalah'])
            ->make(true);
    }

    // ─────────────────────────────────────────────
    // 13. DataTable – Semua Penduduk & Bantuan
    // ─────────────────────────────────────────────
    public function datatablePenduduk(Request $request)
    {
        $query = $this->baseQuery()
            ->select([
                't1.no_nik',
                't1.nama',
                't3.name as desa',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't1.tanya_bantuanpemerintah',
                't4.nama AS nama_bantuan',
            ]);

        // Filter desa
        if ($request->desa) {
            $query->where('t2.desa', $request->desa);
        }

        // Filter status kelayakan
        if ($request->status_bantuan) {
            $query->where('t1.tanya_bantuanpemerintah', $request->status_bantuan);
        }

        // Filter jenis kelamin
        if ($request->jenkel) {
            $query->where('t1.jenkel', $request->jenkel);
        }

        // Filter jenis bantuan
        if ($request->jenis_bantuan) {
            $query->where('t4.nama', $request->jenis_bantuan);
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->addColumn('jenkel_display', function ($row) {
                $icon = $row->jenkel == 1
                    ? '<i class="fas fa-male text-info"></i> Laki-laki'
                    : '<i class="fas fa-female text-danger"></i> Perempuan';
                return '<span class="badge badge-' . ($row->jenkel == 1 ? 'info' : 'danger') . '">' . $icon . '</span>';
            })
            ->addColumn('umur_display', function ($row) {
                $umur = $row->tgl_lahir
                    ? \Carbon\Carbon::parse($row->tgl_lahir)->age
                    : '-';
                return '<span class="badge badge-secondary">' . $umur . ' thn</span>';
            })
            ->addColumn('tgl_lahir_display', function ($row) {
                return $row->tgl_lahir
                    ? \Carbon\Carbon::parse($row->tgl_lahir)->format('d/m/Y')
                    : '-';
            })
            ->addColumn('status_badge', function ($row) {
                $cls = $row->tanya_bantuanpemerintah === 'Layak' ? 'success' : 'secondary';
                $icon = $row->tanya_bantuanpemerintah === 'Layak' ? 'check-circle' : 'times-circle';
                return '<span class="badge badge-' . $cls . '"><i class="fas fa-' . $icon . '"></i> ' . $row->tanya_bantuanpemerintah . '</span>';
            })
            ->addColumn('bantuan_display', function ($row) {
                if (!$row->nama_bantuan) {
                    return '<span class="text-muted">-</span>';
                }
                $colorMap = [
                    'Belum Pernah Dapat Bantuan'     => 'secondary',
                    'Bantuan Pangan Non Tunai (BPNT)'=> 'primary',
                    'Bantuan Langsung Tunai (BLT)'   => 'warning',
                    'Program Keluarga Harapan (PKH)' => 'info',
                    'BSU Ketenagakerjaan'             => 'purple',
                    'Bantuan Pemerintah Lainnya'      => 'danger',
                ];
                $cls = $colorMap[$row->nama_bantuan] ?? 'dark';
                return '<span class="badge badge-' . $cls . '">' . $row->nama_bantuan . '</span>';
            })
            ->rawColumns(['jenkel_display', 'umur_display', 'status_badge', 'bantuan_display'])
            ->make(true);
    }

    // ─────────────────────────────────────────────
    // 14. Clear Cache (Optional - untuk admin)
    // ─────────────────────────────────────────────
    public function clearCache()
    {
        try {
            $cacheKeys = [
                'bantuan_statistik_jumlah',
                'bantuan_statistik_rasio',
                'bantuan_distribusi_jenis',
                'bantuan_distribusi_jenkel',
                'bantuan_distribusi_desa',
                'bantuan_distribusi_umur',
                'bantuan_distribusi_umur_jenkel',
                'bantuan_distribusi_per_desa',
                'bantuan_detail_desa',
                'bantuan_data_abnormal',
                'bantuan_list_desa',
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
