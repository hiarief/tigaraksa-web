<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PendapatanController extends Controller
{
    public function pendapatan()
    {
        return view('admin.chart.pendapatan.pendapatan');
    }

    private function getBaseQuery()
    {
        $desaId = auth()->user()->desa;
        return DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
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
                't1.pendapatan_perbulan',
                't1.punya_bpjs',
                't1.jenis_bpjs',
                't1.pembayaran_bpjs',
            ]);
    }

    // 1. Statistik Dasar Kependudukan
    public function getStatistikDasar()
    {
        $data = $this->getBaseQuery()->get();

        $totalPenduduk = $data->count();
        $totalKK = $data->unique('no_kk')->count();
        $rataAnggotaPerKK = $totalKK > 0 ? round($totalPenduduk / $totalKK, 2) : 0;

        $jenisKelamin = [
            'Laki-laki' => $data->where('jenkel', 1)->count(),
            'Perempuan' => $data->where('jenkel', 2)->count(),
        ];

        $umurData = $data->pluck('umur')->filter();
        $statistikUmur = [
            'rata_rata' => round($umurData->avg(), 2),
            'median' => $umurData->median(),
            'tertua' => $umurData->max(),
            'termuda' => $umurData->min(),
        ];

        return response()->json([
            'total_penduduk' => $totalPenduduk,
            'total_kk' => $totalKK,
            'rata_anggota_per_kk' => $rataAnggotaPerKK,
            'jenis_kelamin' => $jenisKelamin,
            'statistik_umur' => $statistikUmur,
        ]);
    }

    // 2. Distribusi Pendapatan
    public function getDistribusiPendapatan()
    {
        $data = $this->getBaseQuery()->get();

        $distribusi = $data->groupBy('pendapatan_perbulan')->map(function($item) use ($data) {
            return [
                'jumlah' => $item->count(),
                'persentase' => round(($item->count() / $data->count()) * 100, 2)
            ];
        });

        // Urutkan berdasarkan kategori pendapatan
        $urutan = ['0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '>5 Juta'];
        $sorted = [];
        foreach ($urutan as $kategori) {
            if (isset($distribusi[$kategori])) {
                $sorted[$kategori] = $distribusi[$kategori];
            }
        }

        return response()->json($sorted);
    }

    // 3. Pendapatan per Kelompok Umur
    public function getPendapatanPerUmur()
    {
        $data = $this->getBaseQuery()->get();

        $kelompokUmur = $data->map(function($item) {
            if ($item->umur < 25) return '<25';
            if ($item->umur <= 40) return '26-40';
            if ($item->umur <= 60) return '41-60';
            return '>60';
        });

        $result = [];
        foreach (['<25', '26-40', '41-60', '>60'] as $kelompok) {
            $dataKelompok = $data->filter(function($item) use ($kelompok) {
                $umur = $item->umur;
                switch ($kelompok) {
                    case '<25': return $umur < 25;
                    case '26-40': return $umur >= 26 && $umur <= 40;
                    case '41-60': return $umur >= 41 && $umur <= 60;
                    case '>60': return $umur > 60;
                }
            });

            $result[$kelompok] = $dataKelompok->groupBy('pendapatan_perbulan')
                ->map(fn($item) => $item->count())->toArray();
        }

        return response()->json($result);
    }

    // 4. Pendapatan per Jenis Kelamin
    public function getPendapatanPerJenkel()
    {
        $data = $this->getBaseQuery()->get();

        $result = [
            'Laki-laki' => [],
            'Perempuan' => []
        ];

        foreach ([1, 2] as $jenkel) {
            $jenkelLabel = $jenkel == 1 ? 'Laki-laki' : 'Perempuan';
            $dataJenkel = $data->where('jenkel', $jenkel);

            $result[$jenkelLabel] = $dataJenkel->groupBy('pendapatan_perbulan')
                ->map(fn($item) => $item->count())->toArray();
        }

        return response()->json($result);
    }

    // 5. Pendapatan per RT/RW
    public function getPendapatanPerRT()
    {
        $data = $this->getBaseQuery()->get();

        $result = $data->groupBy('rt_rw')->map(function($items, $rt) use ($data) {
            $totalRT = $items->count();
            $rendah = $items->where('pendapatan_perbulan', '0-1 Juta')->count();

            return [
                'total' => $totalRT,
                'rendah' => $rendah,
                'persentase_rendah' => $totalRT > 0 ? round(($rendah / $totalRT) * 100, 2) : 0
            ];
        })->sortByDesc('persentase_rendah')->take(10);

        return response()->json($result);
    }

    // 6. Kelompok Rentan (Lansia Berpendapatan Rendah)
    public function getKelompokRentan()
    {
        $data = $this->getBaseQuery()
            ->where(DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE())'), '>=', 60)
            ->whereIn('t1.pendapatan_perbulan', ['0-1 Juta', '1-2 Juta'])
            ->get();

        $distribusi = $data->groupBy('pendapatan_perbulan')->map(fn($item) => $item->count());

        return response()->json([
            'total' => $data->count(),
            'distribusi' => $distribusi
        ]);
    }

    // 7. DataTables - Semua Penduduk
    public function datatablePenduduk(Request $request)
    {
        // Jika request untuk mendapatkan list RT/RW
        if ($request->has('get_rt_rw')) {
            $desaId = auth()->user()->desa;

            $rtRwList = DB::table('t_kartu_keluarga as t2')
                ->where('t2.desa', $desaId)
                ->select(DB::raw("CONCAT(t2.rt,'/',t2.rw) as rt_rw"))
                ->distinct()
                ->orderByRaw("CAST(t2.rt AS UNSIGNED), CAST(t2.rw AS UNSIGNED)")
                ->pluck('rt_rw')
                ->toArray();

            return response()->json(['rt_rw_list' => $rtRwList]);
        }

        $data = $this->getBaseQuery();

        return DataTables::of($data)
            ->addIndexColumn()
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->editColumn('jenkel', function ($row) {
                return $row->jenkel == 1 ? 'L' : 'P';
            })
            ->editColumn('punya_bpjs', function ($row) {
                return $row->punya_bpjs == 'ya' ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-danger">Tidak</span>';
            })
            ->editColumn('pembayaran_bpjs', function ($row) {
                $rowData = $row->pembayaran_bpjs;
                if (!$rowData || $rowData === '') {
                    return '<span class="text-muted">-</span>';
                }
                return str_replace('_', ' ', strtoupper($rowData));
            })
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->addColumn('kategori_umur', function($row) {
                if ($row->umur < 25) return '<25';
                if ($row->umur <= 40) return '26-40';
                if ($row->umur <= 60) return '41-60';
                return '>60';
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('pendapatan') && $request->pendapatan != '') {
                    $query->where('t1.pendapatan_perbulan', $request->pendapatan);
                }
                if ($request->has('rt_rw') && $request->rt_rw != '') {
                    $query->whereRaw("CONCAT(t2.rt,'/',t2.rw) = ?", [$request->rt_rw]);
                }
                if ($request->has('kelompok_umur') && $request->kelompok_umur != '') {
                    $kelompok = $request->kelompok_umur;
                    $umurRaw = DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE())');

                    switch ($kelompok) {
                        case '<25':
                            $query->where($umurRaw, '<', 25);
                            break;
                        case '26-40':
                            $query->whereBetween($umurRaw, [26, 40]);
                            break;
                        case '41-60':
                            $query->whereBetween($umurRaw, [41, 60]);
                            break;
                        case '>60':
                            $query->where($umurRaw, '>', 60);
                            break;
                    }
                }
            })
            ->rawColumns(['punya_bpjs','pembayaran_bpjs'])
            ->make(true);
    }

    // 8. DataTables - Lansia Rentan
    public function datatableLansiaRentan(Request $request)
    {
        $data = $this->getBaseQuery()
            ->where(DB::raw('TIMESTAMPDIFF(YEAR, t1.tgl_lahir, CURDATE())'), '>=', 60)
            ->whereIn('t1.pendapatan_perbulan', ['0-1 Juta', '1-2 Juta']);

        return DataTables::of($data)

            ->addIndexColumn()
            ->editColumn('nama', fn($row) => strtoupper($row->nama))
            ->editColumn('kp', fn($row) => strtoupper($row->kp))
            ->editColumn('tgl_lahir', function ($row) {
                return date('d-m-Y', strtotime($row->tgl_lahir));
            })
            ->editColumn('jenkel', function ($row) {
                return $row->jenkel == 1 ? 'L' : 'P';
            })

            ->editColumn('punya_bpjs', function ($row) {
                return $row->punya_bpjs == 'ya' ? '<span class="badge badge-success">Ya</span>' : '<span class="badge badge-danger">Tidak</span>';
            })
            ->editColumn('pembayaran_bpjs', function ($row) {
                $rowData = $row->pembayaran_bpjs;
                if (!$rowData || $rowData === '') {
                    return '<span class="text-muted">-</span>';
                }
                return str_replace('_', ' ', strtoupper($rowData));
            })
            ->filter(function ($query) use ($request) {
                if ($request->has('pendapatan') && $request->pendapatan != '') {
                    $query->where('t1.pendapatan_perbulan', $request->pendapatan);
                }
                if ($request->has('rt_rw') && $request->rt_rw != '') {
                    $query->whereRaw("CONCAT(t2.rt,'/',t2.rw) = ?", [$request->rt_rw]);
                }
            })
            ->rawColumns(['punya_bpjs','pembayaran_bpjs'])
            ->make(true);
    }

    // 9. DataTables - Per RT/RW
    public function datatablePerRT(Request $request, $rt_rw)
    {
        $data = $this->getBaseQuery()
            ->whereRaw("CONCAT(t2.rt,'/',t2.rw) = ?", [$rt_rw]);

        return DataTables::of($data)
            ->addColumn('jenkel_label', function($row) {
                return $row->jenkel == 1 ? 'Laki-laki' : 'Perempuan';
            })
            ->make(true);
    }
}