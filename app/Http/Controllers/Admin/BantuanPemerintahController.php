<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Cache;

class BantuanPemerintahController extends Controller
{
    private const CACHE_TTL = 7200; // 2 jam

    public function index()
    {
        return view('admin.chart.bantuan-pemerintah.bantuan');
    }

    public function getStatistik()
    {
        $desaId = auth()->user()->desa;

        return Cache::remember("bantuan_pemerintah_statistik_{$desaId}", self::CACHE_TTL, function() use ($desaId) {
            // Query utama
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->leftJoin('bantuan_pemerintah as t4', 't4.Id', '=', 't1.bantuan_pemerintah')
                ->where('t2.desa', $desaId)
                ->select([
                    't1.no_nik',
                    't1.nama',
                    't2.no_kk',
                    't2.kp',
                    't1.jenkel',
                    't1.tgl_lahir',
                    DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                    DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                    't3.name AS desa',
                    't1.tanya_bantuanpemerintah',
                    't1.bantuan_pemerintah',
                    't4.nama AS nama_bantuan'
                ])->get();

            // 1. Total Penduduk & KK
            $totalPenduduk = $data->count();
            $totalKK = $data->pluck('no_kk')->unique()->count();

            // 2. Status Kelayakan
            $layak = $data->where('tanya_bantuanpemerintah', 'Layak')->count();
            $tidakLayak = $data->where('tanya_bantuanpemerintah', 'Tidak Layak')->count();
            $persenLayak = $totalPenduduk > 0 ? round(($layak / $totalPenduduk) * 100, 2) : 0;
            $persenTidakLayak = $totalPenduduk > 0 ? round(($tidakLayak / $totalPenduduk) * 100, 2) : 0;

            // 3. Distribusi Penerima Bantuan
            $distribusiBantuan = $data->groupBy('nama_bantuan')->map(function ($item) {
                return $item->count();
            });

            $belumMenerima = $data->whereNull('bantuan_pemerintah')->count();
            if ($belumMenerima > 0) {
                $distribusiBantuan['Belum Menerima Bantuan'] = $belumMenerima;
            }

            // 4. Layak tapi Belum Menerima (KRITIS)
            $layakBelumMenerima = $data->where('tanya_bantuanpemerintah', 'Layak')
                ->whereNull('bantuan_pemerintah')
                ->count();
            $persenLayakBelumMenerima = $layak > 0 ? round(($layakBelumMenerima / $layak) * 100, 2) : 0;

            // 5. Tidak Layak tapi Menerima (ANOMALI)
            $tidakLayakMenerima = $data->where('tanya_bantuanpemerintah', 'Tidak Layak')
                ->whereNotNull('bantuan_pemerintah')
                ->count();

            // Anomali detail per jenis bantuan
            $anomaliDetail = $data->where('tanya_bantuanpemerintah', 'Tidak Layak')
                ->whereNotNull('bantuan_pemerintah')
                ->groupBy('nama_bantuan')
                ->map(function ($item) {
                    return $item->count();
                });

            // 6. Klasifikasi Umur
            $kelompokUmur = $data->map(function ($item) {
                $umur = $item->umur;
                if ($umur <= 5) return 'Balita (0-5)';
                if ($umur <= 12) return 'Anak (6-12)';
                if ($umur <= 17) return 'Remaja (13-17)';
                if ($umur <= 35) return 'Produktif Muda (18-35)';
                if ($umur <= 59) return 'Produktif (36-59)';
                return 'Lansia (≥60)';
            });

            $distribusiUmur = collect($kelompokUmur)->countBy();

            // Penerima bantuan per kelompok umur
            $bantuanPerUmur = $data->whereNotNull('bantuan_pemerintah')
                ->groupBy(function ($item) {
                    $umur = $item->umur;
                    if ($umur <= 5) return 'Balita (0-5)';
                    if ($umur <= 12) return 'Anak (6-12)';
                    if ($umur <= 17) return 'Remaja (13-17)';
                    if ($umur <= 35) return 'Produktif Muda (18-35)';
                    if ($umur <= 59) return 'Produktif (36-59)';
                    return 'Lansia (≥60)';
                })
                ->map(function ($item) {
                    return $item->count();
                });

            // Layak per kelompok umur
            $layakPerUmur = $data->where('tanya_bantuanpemerintah', 'Layak')
                ->groupBy(function ($item) {
                    $umur = $item->umur;
                    if ($umur <= 5) return 'Balita (0-5)';
                    if ($umur <= 12) return 'Anak (6-12)';
                    if ($umur <= 17) return 'Remaja (13-17)';
                    if ($umur <= 35) return 'Produktif Muda (18-35)';
                    if ($umur <= 59) return 'Produktif (36-59)';
                    return 'Lansia (≥60)';
                })
                ->map(function ($item, $key) use ($distribusiUmur) {
                    $total = $distribusiUmur[$key] ?? 1;
                    return [
                        'jumlah' => $item->count(),
                        'persen' => round(($item->count() / $total) * 100, 2)
                    ];
                });

            // 7. Distribusi Gender
            $lakiLaki = $data->where('jenkel', 1)->count();
            $perempuan = $data->where('jenkel', 2)->count();

            $lakiLakiBantuan = $data->where('jenkel', 1)->whereNotNull('bantuan_pemerintah')->count();
            $perempuanBantuan = $data->where('jenkel', 2)->whereNotNull('bantuan_pemerintah')->count();

            // 8. Distribusi per RT/RW
            $distribusiRTRW = $data->groupBy('rt_rw')
                ->map(function ($item) {
                    return [
                        'total' => $item->count(),
                        'penerima' => $item->whereNotNull('bantuan_pemerintah')->count()
                    ];
                })
                ->sortByDesc('penerima')
                ->take(10);

            // 9. Distribusi per Kampung
            $distribusiKampung = $data->groupBy('kp')
                ->map(function ($item) {
                    $total = $item->count();
                    $penerima = $item->whereNotNull('bantuan_pemerintah')->count();
                    return [
                        'total' => $total,
                        'penerima' => $penerima,
                        'persen' => $total > 0 ? round(($penerima / $total) * 100, 2) : 0
                    ];
                })
                ->sortByDesc('penerima');

            // 10. Statistik KK
            $kkPenerima = $data->whereNotNull('bantuan_pemerintah')
                ->pluck('no_kk')
                ->unique()
                ->count();
            $kkBelumMenerima = $totalKK - $kkPenerima;

            // Multi penerima dalam 1 KK
            $multiPenerima = $data->whereNotNull('bantuan_pemerintah')
                ->groupBy('no_kk')
                ->filter(function ($item) {
                    return $item->count() > 1;
                })
                ->count();

            return [
                'ringkasan' => [
                    'total_penduduk' => $totalPenduduk,
                    'total_kk' => $totalKK,
                    'total_penerima_bantuan' => $data->whereNotNull('bantuan_pemerintah')->count(),
                    'layak_belum_menerima' => $layakBelumMenerima,
                    'tidak_layak_menerima' => $tidakLayakMenerima,
                    'lansia_layak_persen' => $layakPerUmur['Lansia (≥60)']['persen'] ?? 0
                ],
                'kelayakan' => [
                    'layak' => $layak,
                    'tidak_layak' => $tidakLayak,
                    'persen_layak' => $persenLayak,
                    'persen_tidak_layak' => $persenTidakLayak
                ],
                'distribusi_bantuan' => $distribusiBantuan,
                'kritis' => [
                    'layak_belum_menerima' => $layakBelumMenerima,
                    'persen_layak_belum_menerima' => $persenLayakBelumMenerima
                ],
                'anomali' => [
                    'tidak_layak_menerima' => $tidakLayakMenerima,
                    'detail' => $anomaliDetail
                ],
                'umur' => [
                    'distribusi' => $distribusiUmur,
                    'penerima_bantuan' => $bantuanPerUmur,
                    'layak_per_umur' => $layakPerUmur
                ],
                'gender' => [
                    'laki_laki' => $lakiLaki,
                    'perempuan' => $perempuan,
                    'laki_laki_bantuan' => $lakiLakiBantuan,
                    'perempuan_bantuan' => $perempuanBantuan
                ],
                'wilayah' => [
                    'rt_rw' => $distribusiRTRW,
                    'kampung' => $distribusiKampung
                ],
                'kk' => [
                    'kk_penerima' => $kkPenerima,
                    'kk_belum_menerima' => $kkBelumMenerima,
                    'multi_penerima' => $multiPenerima
                ]
            ];
        });
    }

    public function getDatatables(Request $request)
    {
        $desaId = auth()->user()->desa;
        $kategori = $request->get('kategori', 'semua');

        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoin('bantuan_pemerintah as t4', 't4.Id', '=', 't1.bantuan_pemerintah')
            ->where('t2.desa', $desaId)
            ->select([
                't1.no_nik',
                't1.nama',
                't2.no_kk',
                't2.kp',
                't1.jenkel',
                't1.tgl_lahir',
                DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE()) AS umur'),
                DB::raw("CONCAT(t2.rt,'/',t2.rw) AS rt_rw"),
                't3.name AS desa',
                't1.tanya_bantuanpemerintah',
                't1.bantuan_pemerintah',
                't4.nama AS nama_bantuan'
            ]);

        // Filter berdasarkan kategori
        switch ($kategori) {
            case 'layak':
                $query->where('t1.tanya_bantuanpemerintah', 'Layak');
                break;
            case 'tidak_layak':
                $query->where('t1.tanya_bantuanpemerintah', 'Tidak Layak');
                break;
            case 'penerima':
                $query->whereNotNull('t1.bantuan_pemerintah');
                break;
            case 'belum_menerima':
                $query->whereNull('t1.bantuan_pemerintah');
                break;
            case 'layak_belum_menerima':
                $query->where('t1.tanya_bantuanpemerintah', 'Layak')
                    ->whereNull('t1.bantuan_pemerintah');
                break;
            case 'anomali':
                $query->where('t1.tanya_bantuanpemerintah', 'Tidak Layak')
                    ->whereNotNull('t1.bantuan_pemerintah');
                break;
        }

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('no_nik', function ($row) {
                return $this->maskNumber($row->no_nik);
            })
            ->editColumn('no_kk', function ($row) {
                return $this->maskNumber($row->no_kk);
            })
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->addColumn('jenkel_text', function ($row) {
                return $row->jenkel == 1 ? 'L' : 'P';
            })
            ->addColumn('kelompok_umur', function ($row) {
                $umur = $row->umur;
                if ($umur <= 5) return 'Balita (0-5)';
                if ($umur <= 12) return 'Anak (6-12)';
                if ($umur <= 17) return 'Remaja (13-17)';
                if ($umur <= 35) return 'Produktif Muda (18-35)';
                if ($umur <= 59) return 'Produktif (36-59)';
                return 'Lansia (≥60)';
            })
            ->addColumn('status_bantuan', function ($row) {
                if ($row->bantuan_pemerintah) {
                    return '<span class="badge badge-success">Menerima</span>';
                }
                return '<span class="badge badge-secondary">Belum Menerima</span>';
            })
            ->addColumn('status_kelayakan', function ($row) {
                if ($row->tanya_bantuanpemerintah == 'Layak') {
                    return '<span class="badge badge-info">Layak</span>';
                }
                return '<span class="badge badge-warning">Tidak Layak</span>';
            })
            ->rawColumns(['status_bantuan', 'status_kelayakan'])
            ->make(true);
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

    /**
     * Method untuk clear cache ketika ada update data
     * Panggil method ini di controller yang handle CRUD
     */
    public function clearCache()
    {
        $desaId = auth()->user()->desa;

        Cache::forget("bantuan_pemerintah_statistik_{$desaId}");

        return response()->json(['message' => 'Cache cleared successfully']);
    }
}
