<?php

namespace App\Http\Controllers\Admin\Kecamatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class PendapatanKecamatanController extends Controller
{
    // Cache TTL (Time To Live) - 2 jam
    private const CACHE_TTL = 7200;

    // Mapping pendapatan untuk sorting
    private $pendapatanOrder = [
        '0-1 Juta'   => 1,
        '1-2 Juta'   => 2,
        '2-3 Juta'   => 3,
        '3-5 Juta'   => 4,
        '5-10 Juta'  => 5,
        '10-20 Juta' => 6,
        '20-50 Juta' => 7,
        '50-100 Juta'=> 8,
        '>100 Juta'  => 9,
    ];

    // Mapping nilai tengah pendapatan
    private $pendapatanNilai = [
        '0-1 Juta'    => 500000,
        '1-2 Juta'    => 1500000,
        '2-3 Juta'    => 2500000,
        '3-5 Juta'    => 4000000,
        '5-10 Juta'   => 7500000,
        '10-20 Juta'  => 15000000,
        '20-50 Juta'  => 35000000,
        '50-100 Juta' => 75000000,
        '>100 Juta'   => 150000000,
    ];

    // Pekerjaan yang dianggap tidak produktif
    private $tidakProduktif = [
        'BELUM/TIDAK BEKERJA',
        'MENGURUS RUMAH TANGGA',
        'PELAJAR/MAHASISWA',
    ];

    // Ekspresi CASE WHEN kelompok umur (reusable di SQL)
    private function caseUmur(string $alias = 'kelompok'): string
    {
        return "CASE
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 0  AND 17 THEN '0-17'
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 25 THEN '18-25'
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 26 AND 35 THEN '26-35'
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 36 AND 45 THEN '36-45'
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 46 AND 55 THEN '46-55'
            WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 56 AND 65 THEN '56-65'
            ELSE '>65'
        END as {$alias}";
    }

    public function index(Request $request)
    {
        return view('admin.chart.pendapatan.kecamatan');
    }

    /**
     * Base query (hanya dipakai untuk DataTable yang butuh detail baris)
     */
    private function getBaseQuery()
    {
        return DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
            ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                't1.pendapatan_perbulan',
                't5.nama as jenis_pekerjaan',
                't4.nama as hubungan_keluarga',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't2.desa as kode_desa',
            ]);
    }

    // =========================================================================
    // 1. Statistik Jumlah — full SQL aggregation, tanpa PHP looping
    // =========================================================================
    public function getStatistikJumlah()
    {
        try {
            $data = Cache::remember('pendapatan_statistik_jumlah', self::CACHE_TTL, function () {
                $tidakProduktifSql = $this->inSqlString($this->tidakProduktif);

                $row = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->selectRaw("
                        COUNT(*)                                                                                    AS total_penduduk,
                        SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END)                                             AS total_laki,
                        SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END)                                             AS total_perempuan,
                        SUM(CASE WHEN t4.nama = 'KEPALA KELUARGA' THEN 1 ELSE 0 END)                               AS total_kepala_keluarga,
                        SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END) AS total_pekerja,
                        SUM(CASE WHEN t5.nama IS NULL     OR  t5.nama     IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END) AS total_tidak_bekerja,
                        SUM(CASE WHEN t1.pendapatan_perbulan = '0-1 Juta'   THEN 1 ELSE 0 END)                     AS pendapatan_0_1,
                        SUM(CASE WHEN t1.pendapatan_perbulan = '1-2 Juta'   THEN 1 ELSE 0 END)                     AS pendapatan_1_2,
                        SUM(CASE WHEN t1.pendapatan_perbulan = '2-3 Juta'   THEN 1 ELSE 0 END)                     AS pendapatan_2_3,
                        SUM(CASE WHEN t1.pendapatan_perbulan = '3-5 Juta'   THEN 1 ELSE 0 END)                     AS pendapatan_3_5,
                        SUM(CASE WHEN t1.pendapatan_perbulan = '5-10 Juta'  THEN 1 ELSE 0 END)                     AS pendapatan_5_10,
                        SUM(CASE WHEN t1.pendapatan_perbulan IN ('10-20 Juta','20-50 Juta','50-100 Juta','>100 Juta') THEN 1 ELSE 0 END) AS pendapatan_10_plus
                    ")
                    ->first();

                // Pastikan semua field bertipe integer agar JS tidak salah parse
                return [
                    'total_penduduk'       => (int) $row->total_penduduk,
                    'total_laki'           => (int) $row->total_laki,
                    'total_perempuan'      => (int) $row->total_perempuan,
                    'total_kepala_keluarga'=> (int) $row->total_kepala_keluarga,
                    'total_pekerja'        => (int) $row->total_pekerja,
                    'total_tidak_bekerja'  => (int) $row->total_tidak_bekerja,
                    'pendapatan_0_1'       => (int) $row->pendapatan_0_1,
                    'pendapatan_1_2'       => (int) $row->pendapatan_1_2,
                    'pendapatan_2_3'       => (int) $row->pendapatan_2_3,
                    'pendapatan_3_5'       => (int) $row->pendapatan_3_5,
                    'pendapatan_5_10'      => (int) $row->pendapatan_5_10,
                    'pendapatan_10_plus'   => (int) $row->pendapatan_10_plus,
                ];
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getStatistikJumlah: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 2. Statistik Rasio — full SQL aggregation (ganti PHP collection lama)
    // =========================================================================
    public function getStatistikRasio()
    {
        try {
            // Hitung di luar closure agar bebas dari $this binding issue
            $tidakProduktifSql = $this->inSqlString($this->tidakProduktif);
            $rataRataKK        = $this->hitungRataRataPendapatanKeluargaSQL();

            $data = Cache::remember('pendapatan_statistik_rasio', self::CACHE_TTL,
                function () use ($tidakProduktifSql, $rataRataKK) {

                $row = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->selectRaw("
                        COUNT(*)                                                                                         AS total,
                        SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END)  AS total_pekerja,
                        SUM(CASE WHEN t5.nama IS NULL     OR  t5.nama     IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END)  AS total_tidak_bekerja
                    ")
                    ->first();

                $total        = (int) $row->total;
                $pekerja      = (int) $row->total_pekerja;
                $tidakBekerja = (int) $row->total_tidak_bekerja;

                return [
                    'persentase_pekerja'            => $total > 0 ? number_format(($pekerja / $total) * 100, 1) : '0.0',
                    'persentase_tidak_bekerja'      => $total > 0 ? number_format(($tidakBekerja / $total) * 100, 1) : '0.0',
                    'rasio_pekerja'                 => $tidakBekerja > 0 ? number_format($pekerja / $tidakBekerja, 2) : '0.00',
                    'rata_rata_pendapatan_keluarga' => $rataRataKK,
                ];
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getStatistikRasio: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Hitung rata-rata pendapatan per KK menggunakan SQL CASE-WHEN
     * Jauh lebih efisien dari PHP collection looping
     */
    private function hitungRataRataPendapatanKeluargaSQL(): string
    {
        // Buat CASE WHEN untuk nilai tengah pendapatan
        $casePendapatan = "CASE t1.pendapatan_perbulan";
        foreach ($this->pendapatanNilai as $label => $nilai) {
            $casePendapatan .= " WHEN '{$label}' THEN {$nilai}";
        }
        $casePendapatan .= " ELSE 0 END";

        // Sub-query: total pendapatan per KK
        $subQuery = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->selectRaw("t2.id as kk_id, SUM({$casePendapatan}) as total_pendapatan_kk")
            ->groupBy('t2.id');

        // Rata-rata hanya KK yang punya pendapatan > 0
        $result = DB::table(DB::raw("({$subQuery->toSql()}) as kk_data"))
            ->mergeBindings($subQuery)
            ->whereRaw('total_pendapatan_kk > 0')
            ->selectRaw('AVG(total_pendapatan_kk) as rata_rata')
            ->value('rata_rata');

        return $this->formatPendapatan((float) ($result ?? 0));
    }

    // =========================================================================
    // 3. Distribusi Pendapatan
    // =========================================================================
    public function getDistribusiPendapatan()
    {
        try {
            $data = Cache::remember('pendapatan_distribusi', self::CACHE_TTL, function () {
                $rows = DB::table('t_kartu_keluarga_anggota')
                    ->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->selectRaw('pendapatan_perbulan, COUNT(*) as jumlah')
                    ->groupBy('pendapatan_perbulan')
                    ->get()
                    ->pluck('jumlah', 'pendapatan_perbulan')
                    ->toArray();

                // Sort berdasarkan urutan pendapatan yang benar
                uksort($rows, fn($a, $b) =>
                    ($this->pendapatanOrder[$a] ?? 999) <=> ($this->pendapatanOrder[$b] ?? 999)
                );

                return $rows;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDistribusiPendapatan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 4. Distribusi Jenis Kelamin
    // =========================================================================
    public function getDistribusiJenisKelamin()
    {
        try {
            $data = Cache::remember('pendapatan_jenkel', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota')
                    ->selectRaw("CASE WHEN jenkel = 1 THEN 'Laki-laki' ELSE 'Perempuan' END as jenis_kelamin, COUNT(*) as jumlah")
                    ->groupBy('jenkel')
                    ->get()
                    ->pluck('jumlah', 'jenis_kelamin')
                    ->toArray();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDistribusiJenisKelamin: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 5. Distribusi Per Desa
    // =========================================================================
    public function getDistribusiPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_per_desa', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->selectRaw('t3.name as desa, COUNT(*) as jumlah')
                    ->groupBy('t3.name')
                    ->orderBy('jumlah', 'DESC')
                    ->get()
                    ->pluck('jumlah', 'desa')
                    ->toArray();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDistribusiPerDesa: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 6. Distribusi Kelompok Umur
    // =========================================================================
    public function getDistribusiKelompokUmur()
    {
        try {
            $data = Cache::remember('pendapatan_kelompok_umur', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota')
                    ->selectRaw($this->caseUmur('kelompok') . ', COUNT(*) as jumlah')
                    ->groupBy('kelompok')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->pluck('jumlah', 'kelompok')
                    ->toArray();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDistribusiKelompokUmur: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 7. Pendapatan Berdasarkan Umur dan Jenis Kelamin
    // =========================================================================
    public function getPendapatanUmurJenisKelamin()
    {
        try {
            $data = Cache::remember('pendapatan_umur_jenkel', self::CACHE_TTL, function () {
                return DB::table('t_kartu_keluarga_anggota')
                    ->selectRaw("
                        {$this->caseUmur('label')},
                        SUM(CASE WHEN jenkel = 1 THEN 1 ELSE 0 END) as laki,
                        SUM(CASE WHEN jenkel = 2 THEN 1 ELSE 0 END) as perempuan
                    ")
                    ->groupBy('label')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->toArray();
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getPendapatanUmurJenisKelamin: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 8. Pendapatan Berdasarkan Kelompok Umur — full SQL (pivot via CASE WHEN)
    // FIXED: ganti PHP collection O(n²) → SQL aggregation langsung
    // =========================================================================
    public function getPendapatanBerdasarkanUmur()
    {
        try {
            $data = Cache::remember('pendapatan_by_umur_detail', self::CACHE_TTL, function () {
                $semuaKategori = array_keys($this->pendapatanOrder);
                $colors        = ['#28a745','#20c997','#17a2b8','#007bff','#6f42c1','#fd7e14','#ffc107','#dc3545','#e83e8c'];
                $urutanUmur    = ['0-17','18-25','26-35','36-45','46-55','56-65','>65'];

                // Bangun SELECT CASE per kategori pendapatan
                $selects = [$this->caseUmur('kelompok_umur')];
                foreach ($semuaKategori as $kat) {
                    $escaped   = addslashes($kat);
                    $alias     = 'p_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($kat));
                    $selects[] = "SUM(CASE WHEN pendapatan_perbulan = '{$escaped}' THEN 1 ELSE 0 END) AS `{$alias}`";
                }

                $rows = DB::table('t_kartu_keluarga_anggota')
                    ->whereNotNull('pendapatan_perbulan')
                    ->where('pendapatan_perbulan', '!=', '')
                    ->selectRaw(implode(', ', $selects))
                    ->groupBy('kelompok_umur')
                    ->orderByRaw('MIN(TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()))')
                    ->get()
                    ->keyBy('kelompok_umur');

                // Susun labels sesuai urutan yang benar
                $labels   = $urutanUmur;
                $datasets = [];

                foreach ($semuaKategori as $idx => $kat) {
                    $alias      = 'p_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($kat));
                    $dataKat    = [];
                    foreach ($urutanUmur as $umur) {
                        $dataKat[] = isset($rows[$umur]) ? (int) $rows[$umur]->{$alias} : 0;
                    }
                    $datasets[] = [
                        'label'           => $kat,
                        'data'            => $dataKat,
                        'backgroundColor' => $colors[$idx % count($colors)],
                        'borderColor'     => $colors[$idx % count($colors)],
                        'borderWidth'     => 1,
                    ];
                }

                return ['labels' => $labels, 'datasets' => $datasets];
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getPendapatanBerdasarkanUmur: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 9. Top 10 Pekerjaan Pendapatan Tertinggi — full SQL
    // FIXED: ganti PHP groupBy+sortByDesc → SQL GROUP BY + ORDER BY
    // =========================================================================
    public function getTop10PekerjaanPendapatanTertinggi()
    {
        try {
            // Capture sebelum closure agar bebas dari ambiguitas $this di beberapa env
            $tidakProduktif    = $this->tidakProduktif;
            $tidakProduktifSql = $this->inSqlString($tidakProduktif);
            $caseNilai         = $this->buildCasePendapatanNilai('t1.pendapatan_perbulan');

            $data = Cache::remember('top10_pekerjaan_pendapatan', self::CACHE_TTL,
                function () use ($tidakProduktif, $tidakProduktifSql, $caseNilai) {

                $rows = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->whereNotIn('t5.nama', $tidakProduktif)
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->selectRaw("
                        t5.nama                                                        AS jenis_pekerjaan,
                        COUNT(*)                                                        AS jumlah,
                        AVG({$caseNilai})                                               AS rata_rata_pendapatan
                    ")
                    ->groupBy('t5.nama')
                    ->having('rata_rata_pendapatan', '>', 0)
                    ->orderBy('rata_rata_pendapatan', 'DESC')
                    ->limit(10)
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->jenis_pekerjaan] = (int) $row->jumlah;
                }

                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getTop10PekerjaanPendapatanTertinggi: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    // =========================================================================
    // 10. Pendapatan Tertinggi Per Desa — full SQL
    // FIXED: ganti PHP groupBy+map → SQL GROUP BY
    // =========================================================================
    public function getPendapatanTertinggiPerDesa()
    {
        try {
            $caseNilai = $this->buildCasePendapatanNilai('t1.pendapatan_perbulan');

            $data = Cache::remember('pendapatan_tertinggi_desa', self::CACHE_TTL,
                function () use ($caseNilai) {

                $rows = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->selectRaw("
                        t3.name                                                         AS desa,
                        AVG({$caseNilai})                                               AS rata_rata
                    ")
                    ->groupBy('t3.name')
                    ->orderBy('rata_rata', 'DESC')
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->desa] = round((float) $row->rata_rata / 1000000, 2);
                }

                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getPendapatanTertinggiPerDesa: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 11. Detail Per Desa — full SQL aggregation
    // FIXED: eliminasi PHP nested looping O(n²) yang menyebabkan 500 error
    // =========================================================================
    public function getDetailPerDesa()
    {
        try {
            $tidakProduktifSql = $this->inSqlString($this->tidakProduktif);
            $caseNilai         = $this->buildCasePendapatanNilai('t1.pendapatan_perbulan');

            $data = Cache::remember('pendapatan_detail_desa', self::CACHE_TTL,
                function () use ($tidakProduktifSql, $caseNilai) {

                $rows = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->selectRaw("
                        t3.name                                                                                             AS desa,
                        COUNT(*)                                                                                             AS total_penduduk,
                        SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END)                                                     AS laki_laki,
                        SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END)                                                     AS perempuan,
                        SUM(CASE WHEN t4.nama = 'KEPALA KELUARGA' THEN 1 ELSE 0 END)                                       AS kepala_keluarga,
                        SUM(CASE WHEN t5.nama IS NOT NULL AND t5.nama NOT IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END)     AS pekerja,
                        SUM(CASE WHEN t5.nama IS NULL     OR  t5.nama     IN ({$tidakProduktifSql}) THEN 1 ELSE 0 END)     AS tidak_bekerja,
                        AVG(CASE WHEN t1.pendapatan_perbulan != '' AND t1.pendapatan_perbulan IS NOT NULL
                                 THEN {$caseNilai} ELSE NULL END)                                                           AS rata_rata_nilai
                    ")
                    ->groupBy('t3.name')
                    ->orderBy('rata_rata_nilai', 'DESC')
                    ->get();

                return array_map(fn($row) => [
                    'desa'                 => $row->desa,
                    'total_penduduk'       => (int) $row->total_penduduk,
                    'laki_laki'            => (int) $row->laki_laki,
                    'perempuan'            => (int) $row->perempuan,
                    'kepala_keluarga'      => (int) $row->kepala_keluarga,
                    'pekerja'              => (int) $row->pekerja,
                    'tidak_bekerja'        => (int) $row->tidak_bekerja,
                    'rata_rata_pendapatan' => $row->rata_rata_nilai
                        ? self::formatNilaiPendapatan((float) $row->rata_rata_nilai)
                        : '0',
                ], $rows->all());
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDetailPerDesa: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 12. Distribusi Pekerjaan
    // =========================================================================
    public function getDistribusiPekerjaan()
    {
        try {
            $data = Cache::remember('pendapatan_distribusi_pekerjaan', self::CACHE_TTL, function () {
                $pekerjaan = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->selectRaw('t5.nama as jenis_pekerjaan, COUNT(*) as jumlah')
                    ->groupBy('t5.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->get();

                if ($pekerjaan->isEmpty()) {
                    return [];
                }

                $top10    = $pekerjaan->take(10)->pluck('jumlah', 'jenis_pekerjaan')->toArray();
                $lainnya  = (int) $pekerjaan->skip(10)->sum('jumlah');

                if ($lainnya > 0) {
                    $top10['LAINNYA'] = $lainnya;
                }

                return $top10;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getDistribusiPekerjaan: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    // =========================================================================
    // 13. Pendapatan Per Desa (Stacked) — full SQL pivot
    // FIXED: ganti PHP nested foreach O(desa×kategori×n) → SQL GROUP BY pivot
    // =========================================================================
    public function getPendapatanPerDesa()
    {
        try {
            $data = Cache::remember('pendapatan_stacked_desa', self::CACHE_TTL, function () {
                $semuaKategori = array_keys($this->pendapatanOrder);
                $colors        = ['#28a745','#20c997','#17a2b8','#007bff','#6f42c1','#fd7e14','#ffc107','#dc3545','#e83e8c'];

                // Bangun kolom pivot CASE WHEN per kategori
                $selects = ['t3.name AS desa'];
                foreach ($semuaKategori as $kat) {
                    $escaped   = addslashes($kat);
                    $alias     = 'p_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($kat));
                    $selects[] = "SUM(CASE WHEN t1.pendapatan_perbulan = '{$escaped}' THEN 1 ELSE 0 END) AS `{$alias}`";
                }

                $rows = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                    ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                    ->whereNotNull('t1.pendapatan_perbulan')
                    ->where('t1.pendapatan_perbulan', '!=', '')
                    ->selectRaw(implode(', ', $selects))
                    ->groupBy('t3.name')
                    ->orderBy('t3.name')
                    ->get();

                $desas    = $rows->pluck('desa')->toArray();
                $datasets = [];

                foreach ($semuaKategori as $idx => $kat) {
                    $alias  = 'p_' . preg_replace('/[^a-z0-9]/i', '_', strtolower($kat));
                    $values = $rows->map(fn($r) => (int) ($r->{$alias} ?? 0))->toArray();

                    $datasets[] = [
                        'label'           => $kat,
                        'data'            => $values,
                        'backgroundColor' => $colors[$idx % count($colors)],
                        'borderColor'     => $colors[$idx % count($colors)],
                        'borderWidth'     => 1,
                    ];
                }

                return ['labels' => $desas, 'datasets' => $datasets];
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getPendapatanPerDesa: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 14. DataTable Kepala Keluarga
    // =========================================================================
    public function getDatatableKepalaKeluarga(Request $request)
    {
        try {
            $query = $this->getBaseQuery()->where('t4.nama', 'KEPALA KELUARGA');

            if ($request->filled('desa'))       $query->where('t2.desa', $request->desa);
            if ($request->filled('pendapatan')) $query->where('t1.pendapatan_perbulan', $request->pendapatan);
            if ($request->filled('pekerjaan'))  $query->where('t5.nama', $request->pekerjaan);

            return DataTables::of($query)
                ->addIndexColumn()
                ->editColumn('no_nik', fn($row) => $this->maskNumber($row->no_nik))
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->addColumn('jenkel_display', fn($row) =>
                    $row->jenkel == 1
                        ? '<span class="badge badge-info">Laki-laki</span>'
                        : '<span class="badge badge-danger">Perempuan</span>'
                )
                ->addColumn('umur_display', fn($row) =>
                    '<span class="badge badge-secondary">' . $row->umur . ' th</span>'
                )
                ->addColumn('tgl_lahir_display', fn($row) =>
                    $row->tgl_lahir ? date('d-m-Y', strtotime($row->tgl_lahir)) : '-'
                )
                ->addColumn('pendapatan_badge', function ($row) {
                    $colors = [
                        '0-1 Juta'    => 'success',
                        '1-2 Juta'    => 'info',
                        '2-3 Juta'    => 'primary',
                        '3-5 Juta'    => 'warning',
                        '5-10 Juta'   => 'purple',
                        '10-20 Juta'  => 'danger',
                        '20-50 Juta'  => 'dark',
                        '50-100 Juta' => 'secondary',
                        '>100 Juta'   => 'indigo',
                    ];
                    $color = $colors[$row->pendapatan_perbulan] ?? 'secondary';
                    return '<span class="badge badge-' . $color . '">' . ($row->pendapatan_perbulan ?? 'Tidak Ada Data') . '</span>';
                })
                ->addColumn('pekerjaan_display', fn($row) =>
                    '<small>' . ($row->jenis_pekerjaan ?? '-') . '</small>'
                )
                ->rawColumns(['jenkel_display', 'umur_display', 'pendapatan_badge', 'pekerjaan_display'])
                ->make(true);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // 15. Pekerjaan Berdasarkan Gender — full SQL
    // =========================================================================
    public function getPekerjaanBerdasarkanGender()
    {
        try {
            // Capture property sebelum masuk closure agar tidak ada ambiguitas
            $tidakProduktif = $this->tidakProduktif;

            $data = Cache::remember('pendapatan_pekerjaan_gender', self::CACHE_TTL,
                function () use ($tidakProduktif) {

                // Step 1: Ambil top 10 pekerjaan berdasarkan jumlah terbanyak
                $top10 = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereNotNull('t5.nama')
                    ->where('t5.nama', '!=', '')
                    ->whereNotIn('t5.nama', $tidakProduktif)
                    ->selectRaw('t5.nama as jenis_pekerjaan, COUNT(*) as jumlah')
                    ->groupBy('t5.nama')
                    ->orderBy('jumlah', 'DESC')
                    ->limit(10)
                    ->pluck('jenis_pekerjaan')
                    ->toArray();

                if (empty($top10)) {
                    return [];
                }

                // Step 2: Hitung laki/perempuan per pekerjaan
                // FIX: ORDER BY tidak boleh pakai alias (laki/perempuan) di MySQL ONLY_FULL_GROUP_BY
                //      Pakai ekspresi lengkap atau urutkan di PHP setelah query
                $rows = DB::table('t_kartu_keluarga_anggota as t1')
                    ->leftJoin('m_pekerjaan as t5', 't5.id', '=', 't1.jns_pekerjaan')
                    ->whereIn('t5.nama', $top10)
                    ->selectRaw("
                        t5.nama                                                                AS jenis_pekerjaan,
                        SUM(CASE WHEN t1.jenkel = 1 THEN 1 ELSE 0 END)                        AS laki,
                        SUM(CASE WHEN t1.jenkel = 2 THEN 1 ELSE 0 END)                        AS perempuan,
                        SUM(CASE WHEN t1.jenkel IN (1,2) THEN 1 ELSE 0 END)                   AS total_gender
                    ")
                    ->groupBy('t5.nama')
                    // FIX: Gunakan ekspresi asli, bukan alias — aman di semua mode MySQL
                    ->orderByRaw('SUM(CASE WHEN t1.jenkel IN (1,2) THEN 1 ELSE 0 END) DESC')
                    ->get();

                $result = [];
                foreach ($rows as $row) {
                    $result[$row->jenis_pekerjaan] = [
                        'label'     => $row->jenis_pekerjaan,
                        'laki'      => (int) $row->laki,
                        'perempuan' => (int) $row->perempuan,
                    ];
                }

                return $result;
            });

            return response()->json(['success' => true, 'data' => $data]);
        } catch (\Exception $e) {
            \Log::error('Error getPekerjaanBerdasarkanGender: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    // =========================================================================
    // List helpers
    // =========================================================================
    public function getListDesa()
    {
        try {
            $desas = Cache::remember('pendapatan_list_desa', self::CACHE_TTL, function () {
                return DB::table('indonesia_villages')
                    ->whereIn('code', fn($q) => $q->select('desa')->from('t_kartu_keluarga')->distinct())
                    ->orderBy('name')
                    ->get(['code', 'name']);
            });
            return response()->json(['success' => true, 'data' => $desas]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function getListPendapatan()
    {
        return response()->json([
            'success' => true,
            'data'    => array_keys($this->pendapatanOrder),
        ]);
    }

    public function getListPekerjaan()
    {
        try {
            $pekerjaan = Cache::remember('pendapatan_list_pekerjaan', self::CACHE_TTL, function () {
                return DB::table('m_pekerjaan')->orderBy('nama')->pluck('nama')->filter()->values();
            });
            return response()->json(['success' => true, 'data' => $pekerjaan]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage(), 'data' => []], 500);
        }
    }

    // =========================================================================
    // Clear Cache
    // =========================================================================
    public function clearCache()
    {
        try {
            $keys = [
                'pendapatan_statistik_jumlah',
                'pendapatan_statistik_rasio',
                'pendapatan_distribusi',
                'pendapatan_jenkel',
                'pendapatan_per_desa',
                'pendapatan_kelompok_umur',
                'pendapatan_umur_jenkel',
                'pendapatan_by_umur_detail',
                'top10_pekerjaan_pendapatan',
                'pendapatan_tertinggi_desa',
                'pendapatan_detail_desa',
                'pendapatan_distribusi_pekerjaan',
                'pendapatan_stacked_desa',
                'pendapatan_list_desa',
                'pendapatan_list_pekerjaan',
                'pendapatan_pekerjaan_gender',
            ];
            foreach ($keys as $key) {
                Cache::forget($key);
            }
            return response()->json(['success' => true, 'message' => 'Cache berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    // =========================================================================
    // Private Helpers
    // =========================================================================

    /**
     * Format nilai rupiah ke string ringkas (instance method)
     */
    private function formatPendapatan(float $nilai): string
    {
        return self::formatNilaiPendapatan($nilai);
    }

    /**
     * Format nilai rupiah ke string ringkas (static — aman dipanggil dari closure)
     */
    private static function formatNilaiPendapatan(float $nilai): string
    {
        if ($nilai >= 1_000_000) {
            return number_format($nilai / 1_000_000, 1) . ' Juta';
        }
        if ($nilai >= 1_000) {
            return number_format($nilai / 1_000, 0) . ' Ribu';
        }
        return number_format($nilai, 0);
    }

    /**
     * Bangun SQL CASE WHEN untuk mengkonversi label pendapatan → nilai tengah
     */
    private function buildCasePendapatanNilai(string $column): string
    {
        $sql = "CASE {$column}";
        foreach ($this->pendapatanNilai as $label => $nilai) {
            $sql .= " WHEN '{$label}' THEN {$nilai}";
        }
        $sql .= " ELSE 0 END";
        return $sql;
    }

    /**
     * Buat string SQL IN clause dari array: 'A','B','C'
     */
    private function inSqlString(array $items): string
    {
        return implode(',', array_map(fn($s) => "'" . addslashes($s) . "'", $items));
    }

    /**
     * Masking NIK: 3 digit awal + 10 bintang + 3 digit akhir
     */
    private function maskNumber(?string $number): ?string
    {
        if (!$number || strlen($number) < 16) {
            return $number;
        }
        return substr($number, 0, 3) . str_repeat('*', 10) . substr($number, -3);
    }
}
