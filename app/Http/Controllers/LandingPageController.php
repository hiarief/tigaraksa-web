<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class LandingPageController extends Controller
{
    private const CACHE_TTL = 600;

    public function page()
    {
        $kk = DB::table('t_kartu_keluarga')->count();
        $nik = DB::table('t_kartu_keluarga_anggota')->count();
        $totalDesa = DB::table('t_kartu_keluarga')
            ->distinct('desa')
            ->count('desa');

        return view('landing-page.page', compact('kk', 'nik', 'totalDesa'));
    }

    // ========================================
    // 1️⃣ BASIC STATS (Paling Ringan - Load Pertama)
    // ========================================
    public function getBasicStats()
    {
        try {
            return Cache::remember('basic_stats', self::CACHE_TTL, function () {
                return response()->json([
                    'total_kk' => DB::table('t_kartu_keluarga')->count(),
                    'total_penduduk' => DB::table('t_kartu_keluarga_anggota')->count(),
                    'total_desa' => DB::table('t_kartu_keluarga')->distinct('desa')->count('desa'),
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getBasicStats: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load basic stats'], 500);
        }
    }

    // ========================================
    // 2️⃣ KEY METRICS (6 Indikator Utama)
    // ========================================
    public function getKeyMetrics()
    {
        try {
            return Cache::remember('key_metrics', self::CACHE_TTL, function () {
                $totalKK = DB::table('t_kartu_keluarga')->count();

                // Subquery untuk Kepala Keluarga
                $kkSubquery = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    });

                // 1. Total KK (sudah ada di atas)

                // 2. Pendapatan Rendah
                $pendapatanRendah = (clone $kkSubquery)
                    ->where('t2.pendapatan_perbulan', '0-1 Juta')
                    ->count();
                $persentasePendapatanRendah = $totalKK > 0 ? round(($pendapatanRendah / $totalKK) * 100, 1) : 0;

                // 3. Lansia
                $jumlahLansia = (clone $kkSubquery)
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60')
                    ->count();
                $persentaseLansia = $totalKK > 0 ? round(($jumlahLansia / $totalKK) * 100, 1) : 0;

                // 4. Layak Belum Dapat Bantuan
                $layakBelumDapat = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('bantuan_pemerintah as t3', 't2.bantuan_pemerintah', '=', 't3.Id')
                    ->where('t2.tanya_bantuanpemerintah', 'Layak')
                    ->where('t3.nama', 'Belum Pernah Dapat Bantuan')
                    ->count();
                $persentaseLayakBelumDapat = $totalKK > 0 ? round(($layakBelumDapat / $totalKK) * 100, 1) : 0;

                // 5. Tanpa BPJS
                $tidakBPJS = (clone $kkSubquery)
                    ->where(function($query) {
                        $query->where('t2.punya_bpjs', 'tidak')
                              ->orWhereNull('t2.punya_bpjs');
                    })
                    ->count();
                $persentaseTidakBPJS = $totalKK > 0 ? round(($tidakBPJS / $totalKK) * 100, 1) : 0;

                // 6. Keluarga Sangat Rentan
                $keluargaSangatRentan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('bantuan_pemerintah as t3', 't2.bantuan_pemerintah', '=', 't3.Id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60')
                    ->where('t2.pendapatan_perbulan', '0-1 Juta')
                    ->where('t3.nama', 'Belum Pernah Dapat Bantuan')
                    ->count();

                // Lansia Belum Bantuan
                $lansiaBlmBantuan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('bantuan_pemerintah as t3', 't2.bantuan_pemerintah', '=', 't3.Id')
                    ->whereRaw('TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60')
                    ->where('t3.nama', 'Belum Pernah Dapat Bantuan')
                    ->count();

                return response()->json([
                    'total_kk' => $totalKK,
                    'pendapatan_rendah' => $pendapatanRendah,
                    'persentase_pendapatan_rendah' => $persentasePendapatanRendah,
                    'jumlah_lansia' => $jumlahLansia,
                    'persentase_lansia' => $persentaseLansia,
                    'layak_belum_dapat' => $layakBelumDapat,
                    'persentase_layak_belum_dapat' => $persentaseLayakBelumDapat,
                    'tidak_punya_bpjs' => $tidakBPJS,
                    'persentase_tidak_bpjs' => $persentaseTidakBPJS,
                    'keluarga_sangat_rentan' => $keluargaSangatRentan,
                    'lansia_belum_bantuan' => $lansiaBlmBantuan,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getKeyMetrics: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load key metrics'], 500);
        }
    }

    // ========================================
    // 3️⃣ DEMOGRAFI KK (Gender & Age)
    // ========================================
    public function getDemografiKK()
    {
        try {
            return Cache::remember('demografi_kk', self::CACHE_TTL, function () {
                // Jenis Kelamin Kepala Keluarga
                $genderKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.jenkel', DB::raw('count(*) as total'))
                    ->groupBy('t2.jenkel')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [$item->jenkel == 1 ? 'laki_laki' : 'perempuan' => $item->total];
                    });

                // Kelompok Usia Kepala Keluarga
                $ageGroupsKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->selectRaw("
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) < 25 THEN 1 ELSE 0 END) as muda,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) BETWEEN 25 AND 44 THEN 1 ELSE 0 END) as produktif,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) BETWEEN 45 AND 59 THEN 1 ELSE 0 END) as pra_lansia,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, t2.tgl_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia
                    ")
                    ->first();

                return response()->json([
                    'gender_kk' => $genderKK,
                    'age_groups_kk' => $ageGroupsKK,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getDemografiKK: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load demografi KK'], 500);
        }
    }

    // ========================================
    // 4️⃣ EKONOMI (Pendapatan & Kepemilikan Rumah)
    // ========================================
    public function getEkonomi()
    {
        try {
            return Cache::remember('ekonomi', self::CACHE_TTL, function () {
                // Distribusi Pendapatan KK
                $pendapatanKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.pendapatan_perbulan as nama', DB::raw('count(*) as total'))
                    ->whereNotNull('t2.pendapatan_perbulan')
                    ->where('t2.pendapatan_perbulan', '!=', '')
                    ->groupBy('t2.pendapatan_perbulan')
                    ->orderByRaw("
                        CASE t2.pendapatan_perbulan
                            WHEN '0-1 Juta' THEN 1
                            WHEN '1-2 Juta' THEN 2
                            WHEN '2-3 Juta' THEN 3
                            WHEN '3-5 Juta' THEN 4
                            ELSE 5
                        END
                    ")
                    ->get();

                // Kepemilikan Rumah
                $kepemilikanRumah = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.kepemilikan_rumah as nama', DB::raw('count(*) as total'))
                    ->whereNotNull('t2.kepemilikan_rumah')
                    ->where('t2.kepemilikan_rumah', '!=', '')
                    ->groupBy('t2.kepemilikan_rumah')
                    ->orderBy('total', 'desc')
                    ->get();

                return response()->json([
                    'pendapatan_kk' => $pendapatanKK,
                    'kepemilikan_rumah' => $kepemilikanRumah,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getEkonomi: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load ekonomi'], 500);
        }
    }

    // ========================================
    // 5️⃣ BANTUAN PEMERINTAH
    // ========================================
    public function getBantuan()
    {
        try {
            return Cache::remember('bantuan', self::CACHE_TTL, function () {
                // Layak vs Tidak Layak
                $kelayakanBantuan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.tanya_bantuanpemerintah', DB::raw('count(*) as total'))
                    ->whereNotNull('t2.tanya_bantuanpemerintah')
                    ->groupBy('t2.tanya_bantuanpemerintah')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [strtolower($item->tanya_bantuanpemerintah) => $item->total];
                    });

                // Jenis Bantuan yang Diterima
                $jenisBantuan = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('bantuan_pemerintah as t3', 't2.bantuan_pemerintah', '=', 't3.Id')
                    ->select('t3.nama', DB::raw('count(*) as total'))
                    ->groupBy('t3.nama')
                    ->orderBy('total', 'desc')
                    ->get();

                return response()->json([
                    'kelayakan_bantuan' => $kelayakanBantuan,
                    'jenis_bantuan' => $jenisBantuan,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getBantuan: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load bantuan'], 500);
        }
    }

    // ========================================
    // 6️⃣ KESEHATAN (BPJS & Sakit Kronis)
    // ========================================
    public function getKesehatan()
    {
        try {
            return Cache::remember('kesehatan', self::CACHE_TTL, function () {
                // Kepemilikan BPJS KK
                $bpjsKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->selectRaw("
                        SUM(CASE WHEN t2.punya_bpjs = 'ya' THEN 1 ELSE 0 END) as punya_bpjs,
                        SUM(CASE WHEN t2.punya_bpjs = 'tidak' OR t2.punya_bpjs IS NULL THEN 1 ELSE 0 END) as tidak_punya_bpjs
                    ")
                    ->first();

                // Jenis BPJS
                $jenisBPJS = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->select('t2.jenis_bpjs', DB::raw('count(*) as total'))
                    ->where('t2.punya_bpjs', 'ya')
                    ->whereNotNull('t2.jenis_bpjs')
                    ->groupBy('t2.jenis_bpjs')
                    ->get();

                // Penyakit Kronis (Agregat)
                $sakitKronis = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('m_sakit_kronis as t3', 't2.sakitkronis', '=', 't3.id')
                    ->select('t3.nama', DB::raw('count(*) as total'))
                    ->groupBy('t3.nama')
                    ->orderBy('total', 'desc')
                    ->get();

                return response()->json([
                    'bpjs_kk' => $bpjsKK,
                    'jenis_bpjs' => $jenisBPJS,
                    'sakit_kronis' => $sakitKronis,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getKesehatan: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load kesehatan'], 500);
        }
    }

    // ========================================
    // 7️⃣ PENDIDIKAN & PEKERJAAN
    // ========================================
    public function getPendidikanPekerjaan()
    {
        try {
            return Cache::remember('pendidikan_pekerjaan', self::CACHE_TTL, function () {
                // Pendidikan KK
                $pendidikanKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('m_pendidikan_keluarga as t3', 't2.pendidikan', '=', 't3.id')
                    ->select('t3.nama', DB::raw('count(*) as total'))
                    ->groupBy('t3.nama')
                    ->orderBy('total', 'desc')
                    ->get();

                // Pekerjaan KK
                $pekerjaanKK = DB::table('t_kartu_keluarga as t1')
                    ->join('t_kartu_keluarga_anggota as t2', function($join) {
                        $join->on('t1.id', '=', 't2.no_kk')
                             ->where('t2.sts_hub_kel', '=', 1);
                    })
                    ->join('m_pekerjaan as t3', 't2.jns_pekerjaan', '=', 't3.id')
                    ->select('t3.nama', DB::raw('count(*) as total'))
                    ->groupBy('t3.nama')
                    ->orderBy('total', 'desc')
                    ->limit(10)
                    ->get();

                return response()->json([
                    'pendidikan_kk' => $pendidikanKK,
                    'pekerjaan_kk' => $pekerjaanKK,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getPendidikanPekerjaan: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load pendidikan & pekerjaan'], 500);
        }
    }

    // ========================================
    // 8️⃣ STATISTIK PENDUDUK (Semua Anggota)
    // ========================================
    public function getStatistikPenduduk()
    {
        try {
            return Cache::remember('statistik_penduduk', self::CACHE_TTL, function () {
                // Gender Stats (Semua Penduduk)
                $genderStats = DB::table('t_kartu_keluarga_anggota')
                    ->select('jenkel', DB::raw('count(*) as total'))
                    ->groupBy('jenkel')
                    ->get()
                    ->mapWithKeys(function ($item) {
                        return [$item->jenkel == 1 ? 'laki_laki' : 'perempuan' => $item->total];
                    });

                // Age Stats (Semua Penduduk)
                $ageStats = DB::table('t_kartu_keluarga_anggota')
                    ->selectRaw("
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 5 THEN 1 ELSE 0 END) as balita,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 5 AND 17 THEN 1 ELSE 0 END) as anak,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) BETWEEN 18 AND 59 THEN 1 ELSE 0 END) as dewasa,
                        SUM(CASE WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 60 THEN 1 ELSE 0 END) as lansia
                    ")
                    ->first();

                // Agama Stats
                $agamaStats = DB::table('t_kartu_keluarga_anggota as t1')
                    ->join('m_agama as t2', 't1.agama', '=', 't2.id')
                    ->select('t2.nama', DB::raw('count(*) as total'))
                    ->groupBy('t2.nama')
                    ->orderBy('total', 'desc')
                    ->get();

                return response()->json([
                    'gender' => $genderStats,
                    'age' => $ageStats,
                    'agama' => $agamaStats,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getStatistikPenduduk: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load statistik penduduk'], 500);
        }
    }

    // ========================================
    // 9️⃣ DATA PER DESA
    // ========================================
    public function getDataDesa()
    {
        try {
            return Cache::remember('data_desa', self::CACHE_TTL, function () {
                // Statistik Per Desa
                $desaStats = DB::table('t_kartu_keluarga as t1')
                    ->join('indonesia_villages as t2', 't1.desa', '=', 't2.code')
                    ->select(
                        't2.name as nama_desa',
                        DB::raw('COUNT(DISTINCT t1.id) as jumlah_kk')
                    )
                    ->groupBy('t2.name')
                    ->orderBy('jumlah_kk', 'desc')
                    ->get();

                // Hitung jumlah penduduk per desa
                foreach ($desaStats as $desa) {
                    $desa->jumlah_penduduk = DB::table('t_kartu_keluarga as t1')
                        ->join('t_kartu_keluarga_anggota as t2', 't1.id', '=', 't2.no_kk')
                        ->join('indonesia_villages as t3', 't1.desa', '=', 't3.code')
                        ->where('t3.name', $desa->nama_desa)
                        ->count();
                }

                return response()->json([
                    'desa' => $desaStats,
                ]);
            });
        } catch (\Exception $e) {
            Log::error('Error in getDataDesa: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to load data desa'], 500);
        }
    }

    // ========================================
    // 🔟 BACKWARD COMPATIBILITY (Optional)
    // ========================================
    public function getStatistics()
    {
        try {
            // Panggil semua endpoint dan gabungkan hasilnya
            $basic = json_decode($this->getBasicStats()->getContent(), true);
            $keyMetrics = json_decode($this->getKeyMetrics()->getContent(), true);
            $demografi = json_decode($this->getDemografiKK()->getContent(), true);
            $ekonomi = json_decode($this->getEkonomi()->getContent(), true);
            $bantuan = json_decode($this->getBantuan()->getContent(), true);
            $kesehatan = json_decode($this->getKesehatan()->getContent(), true);
            $pendidikanPekerjaan = json_decode($this->getPendidikanPekerjaan()->getContent(), true);
            $penduduk = json_decode($this->getStatistikPenduduk()->getContent(), true);
            $desa = json_decode($this->getDataDesa()->getContent(), true);

            return response()->json(array_merge(
                ['basic' => $basic],
                $keyMetrics,
                $demografi,
                $ekonomi,
                $bantuan,
                $kesehatan,
                $pendidikanPekerjaan,
                $penduduk,
                $desa
            ));

        } catch (\Exception $e) {
            Log::error('Error in getStatistics: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to load statistics',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}