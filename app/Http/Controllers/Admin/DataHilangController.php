<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Yajra\DataTables\Facades\DataTables;

class DataHilangController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $desaId = auth()->user()->desa;

            // Deteksi anomali KK level
            $kkAnomalies = $this->getKKAnomalies($desaId, $request);

            // Query dasar untuk data anggota
            $query = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
                ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
                ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
                ->leftJoin('bantuan_pemerintah as t5', 't5.Id', '=', 't1.bantuan_pemerintah')
                ->leftJoin('m_pernikahan as t6', 't6.id', '=', 't1.sts_kwn')
                ->leftJoin('users as t7', 't7.id', '=', 't1.user_id')
                ->where('t2.desa', $desaId)
                ->select(
                    't1.id as anggota_id',
                    't1.no_nik',
                    't2.id as kk_id',
                    't2.no_kk',
                    't1.nama',
                    't1.tmpt_lahir as tempat_lahir',
                    't1.tgl_lahir as tanggal_lahir',
                    't1.jenkel as jenis_kelamin',
                    't1.sts_perkawinan as perkawinan',
                    't1.status_kawin_tercatat as perkawinan_tercatat',
                    't6.nama as status_perkawinan',
                    't4.nama as hubungan_keluarga',
                    't1.tanya_bantuanpemerintah as bantuan_pemerintah',
                    't5.nama as jenis_bantuan_pemerintah',
                    't1.punya_bpjs',
                    't1.jenis_bpjs',
                    't1.pembayaran_bpjs',
                    't1.kepemilikan_rumah',
                    't2.kp as alamat',
                    't2.rt',
                    't2.rw',
                    't3.name as desa',
                    't7.name as user_input'
                );

            // Filter RT
            if ($request->filled('rt')) {
                $query->where('t2.rt', $request->rt);
            }

            // Filter RW
            if ($request->filled('rw')) {
                $query->where('t2.rw', $request->rw);
            }

            $data = $query->orderBy('t3.name')->get();

            // Deteksi anomali dan filtering
            $anomaliData = $data->map(function ($item) use ($kkAnomalies) {
                $anomali = $this->detectAnomali($item);

                // Tambahkan anomali dari level KK
                if (isset($kkAnomalies[$item->no_kk])) {
                    $anomali['categories'] = array_merge($anomali['categories'], $kkAnomalies[$item->no_kk]['categories']);
                    $anomali['messages'] = array_merge($anomali['messages'], $kkAnomalies[$item->no_kk]['messages']);
                    $anomali['categories'] = array_unique($anomali['categories']);
                }

                $item->anomali_categories = $anomali['categories'];
                $item->anomali_messages = $anomali['messages'];
                $item->has_anomali = count($anomali['categories']) > 0;
                return $item;
            })->filter(function ($item) use ($request) {
                // Filter hanya data yang memiliki anomali
                if (!$item->has_anomali) {
                    return false;
                }

                // Filter berdasarkan kategori tab
                if ($request->filled('category') && $request->category !== 'all') {
                    return in_array($request->category, $item->anomali_categories);
                }

                return true;
            });

            // Tambahkan data KK tanpa anggota jika kategori sesuai
            if ((!$request->filled('category') || $request->category === 'all' || $request->category === 'kk_tanpa_anggota')) {
                $kkTanpaAnggota = $this->getKKTanpaAnggota($desaId, $request);
                $anomaliData = $anomaliData->concat($kkTanpaAnggota);
            }

            return DataTables::of($anomaliData)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('user_input', fn($row) => strtoupper($row->user_input))
                ->addColumn('umur', function ($row) {
                    try {
                        if (!empty($row->tanggal_lahir)) {
                            return Carbon::parse($row->tanggal_lahir)->age;
                        }
                        return '-';
                    } catch (\Exception $e) {
                        return 'Invalid';
                    }
                })
                ->addColumn('anomali_badge', function ($row) {
                    $badges = '';
                    foreach ($row->anomali_categories as $category) {
                        $badges .= '<span class="badge badge-danger mr-1">' . $this->getCategoryLabel($category) . '</span>';
                    }
                    return $badges;
                })
                ->addColumn('detail_anomali', function ($row) {
                    $details = '<ul class="mb-0">';
                    foreach ($row->anomali_messages as $message) {
                        $details .= '<li><small>' . $message . '</small></li>';
                    }
                    $details .= '</ul>';
                    return $details;
                })
                ->addColumn('aksi', function ($row) {

                    $viewUrl   = route('kependudukan.kartu.keluarga.show', Crypt::encrypt($row->kk_id));
                    $editUrl   = route('kependudukan.anggota.keluarga.edit', Crypt::encrypt($row->anggota_id));
                    $deleteUrl = route('kependudukan.anggota.keluarga.delete', Crypt::encrypt($row->anggota_id));

                    return '
                        <div class="btn-group btn-group-sm text-center" role="group">
                            <a href="'.$viewUrl.'"
                            class="btn bg-gradient-info"
                            target="_blank"
                            rel="noopener noreferrer"
                            title="Lihat">
                                <i class="fa-solid fa-eye"></i>
                            </a>

                            <a href="'.$editUrl.'"
                            class="btn bg-gradient-warning"
                            title="Edit">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button type="button"
                                class="btn bg-gradient-danger"
                                title="Hapus"
                                onclick="deleteData(\''.Crypt::encrypt($row->anggota_id).'\')">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['anomali_badge', 'detail_anomali', 'aksi'])
                ->make(true);
        }

        // Untuk view biasa
        $desaId = auth()->user()->desa;

        // Get unique RT dan RW untuk filter
        $rtList = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->distinct()
            ->orderBy('rt')
            ->pluck('rt');

        $rwList = DB::table('t_kartu_keluarga')
            ->where('desa', $desaId)
            ->distinct()
            ->orderBy('rw')
            ->pluck('rw');

        // Hitung jumlah anomali per kategori
        $anomaliStats = $this->getAnomaliStatistics($desaId);

        return view('admin.data-hilang.hilang', compact('rtList', 'rwList', 'anomaliStats'));
    }

    private function getKKAnomalies($desaId, $request)
    {
        $kkAnomalies = [];

        // Query untuk menghitung kepala keluarga per KK
        $kkQuery = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->join('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
            ->where('t2.desa', $desaId);

        // Filter RT
        if ($request->filled('rt')) {
            $kkQuery->where('t2.rt', $request->rt);
        }

        // Filter RW
        if ($request->filled('rw')) {
            $kkQuery->where('t2.rw', $request->rw);
        }

        $kkData = $kkQuery->select(
                't2.no_kk',
                't4.nama as hubungan_keluarga'
            )
            ->get()
            ->groupBy('no_kk');

        foreach ($kkData as $noKK => $anggota) {
            $kepalaKeluarga = $anggota->where('hubungan_keluarga', 'KEPALA KELUARGA');
            $jumlahKepala = $kepalaKeluarga->count();

            // Cek KK dengan lebih dari 1 kepala keluarga
            if ($jumlahKepala > 1) {
                $kkAnomalies[$noKK] = [
                    'categories' => ['kepala_keluarga_ganda'],
                    'messages' => ["KK memiliki {$jumlahKepala} kepala keluarga"]
                ];
            }
            // Cek KK tanpa kepala keluarga
            else if ($jumlahKepala == 0) {
                $kkAnomalies[$noKK] = [
                    'categories' => ['kk_tanpa_kepala'],
                    'messages' => ["KK tidak memiliki kepala keluarga"]
                ];
            }
        }

        return $kkAnomalies;
    }

    private function getKKTanpaAnggota($desaId, $request)
    {
        // Query untuk mencari KK yang tidak memiliki anggota sama sekali
        $query = DB::table('t_kartu_keluarga as t2')
            ->leftJoin('t_kartu_keluarga_anggota as t1', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->where('t2.desa', $desaId)
            ->whereNull('t1.id');

        // Filter RT
        if ($request->filled('rt')) {
            $query->where('t2.rt', $request->rt);
        }

        // Filter RW
        if ($request->filled('rw')) {
            $query->where('t2.rw', $request->rw);
        }

        $kkTanpaAnggota = $query->select(
                DB::raw('NULL as anggota_id'),
                DB::raw('NULL as no_nik'),
                't2.id as kk_id',
                't2.no_kk',
                DB::raw('"[TIDAK ADA ANGGOTA]" as nama'),
                DB::raw('NULL as tempat_lahir'),
                DB::raw('NULL as tanggal_lahir'),
                DB::raw('NULL as jenis_kelamin'),
                DB::raw('NULL as perkawinan'),
                DB::raw('NULL as perkawinan_tercatat'),
                DB::raw('NULL as status_perkawinan'),
                DB::raw('NULL as hubungan_keluarga'),
                DB::raw('NULL as bantuan_pemerintah'),
                DB::raw('NULL as jenis_bantuan_pemerintah'),
                DB::raw('NULL as punya_bpjs'),
                DB::raw('NULL as jenis_bpjs'),
                DB::raw('NULL as pembayaran_bpjs'),
                DB::raw('NULL as kepemilikan_rumah'),
                't2.kp as alamat',
                't2.rt',
                't2.rw',
                't3.name as desa'
            )
            ->get();

        // Tandai sebagai anomali
        return $kkTanpaAnggota->map(function($item) {
            $item->anomali_categories = ['kk_tanpa_anggota'];
            $item->anomali_messages = ['KK tidak memiliki anggota sama sekali'];
            $item->has_anomali = true;
            return $item;
        });
    }

    private function detectAnomali($item)
    {
        $categories = [];
        $messages = [];

        // 1. Cek KK tanpa anggota (akan dicek di level berbeda, skip untuk sekarang)

        // 2. Cek umur abnormal (< 0 atau > 120 tahun)
        try {
            $umur = Carbon::parse($item->tanggal_lahir)->age;
            if ($umur < 0 || $umur > 120) {
                $categories[] = 'umur_abnormal';
                $messages[] = "Umur tidak wajar: {$umur} tahun";
            }
        } catch (\Exception $e) {
            $categories[] = 'umur_abnormal';
            $messages[] = "Tanggal lahir tidak valid";
        }

        // 3. Cek status perkawinan tidak konsisten
        $perkawinan = strtoupper(trim($item->perkawinan ?? ''));
        $perkawinanTercatat = strtolower(trim($item->perkawinan_tercatat ?? ''));

        if ($perkawinan === 'BELUM KAWIN' && $perkawinanTercatat === 'kawin_tercatat') {
            $categories[] = 'perkawinan_tidak_konsisten';
            $messages[] = "Status belum kawin tapi tercatat kawin";
        }

        if ($perkawinan === 'KAWIN' && empty($perkawinanTercatat)) {
            $categories[] = 'perkawinan_tidak_konsisten';
            $messages[] = "Status kawin tapi tidak ada catatan perkawinan";
        }

        // 4. Cek bantuan pemerintah tidak konsisten
        $bantuanStatus = strtolower(trim($item->bantuan_pemerintah ?? ''));
        $jenisBantuan = trim($item->jenis_bantuan_pemerintah ?? '');

        if ($bantuanStatus === 'layak' && $jenisBantuan === 'Belum Pernah Dapat Bantuan') {
            $categories[] = 'bantuan_tidak_konsisten';
            $messages[] = "Status layak bantuan tapi belum pernah dapat bantuan";
        }

        if ($bantuanStatus === 'layak' && empty($jenisBantuan)) {
            $categories[] = 'bantuan_tidak_konsisten';
            $messages[] = "Status layak bantuan tapi jenis bantuan kosong";
        }

        if ($bantuanStatus === 'tidak layak' && !empty($jenisBantuan) && $jenisBantuan !== 'Belum Pernah Dapat Bantuan') {
            $categories[] = 'bantuan_tidak_konsisten';
            $messages[] = "Status tidak layak tapi memiliki jenis bantuan";
        }

        // 5. Cek BPJS tidak konsisten
        $punyaBpjs = strtolower(trim($item->punya_bpjs ?? ''));
        $jenisBpjs = trim($item->jenis_bpjs ?? '');
        $pembayaranBpjs = trim($item->pembayaran_bpjs ?? '');

        if ($punyaBpjs === 'ya' && (empty($jenisBpjs) || $jenisBpjs === 'Pilih')) {
            $categories[] = 'bpjs_tidak_konsisten';
            $messages[] = "Punya BPJS tapi jenis BPJS tidak diisi";
        }

        if ($punyaBpjs === 'ya' && (empty($pembayaranBpjs) || $pembayaranBpjs === 'Pilih')) {
            $categories[] = 'bpjs_tidak_konsisten';
            $messages[] = "Punya BPJS tapi pembayaran BPJS tidak diisi";
        }

        if ($punyaBpjs === 'tidak' && (!empty($jenisBpjs) && $jenisBpjs !== 'Pilih')) {
            $categories[] = 'bpjs_tidak_konsisten';
            $messages[] = "Tidak punya BPJS tapi ada jenis BPJS";
        }

        if ($punyaBpjs === 'tidak' && (!empty($pembayaranBpjs) && $pembayaranBpjs !== 'Pilih')) {
            $categories[] = 'bpjs_tidak_konsisten';
            $messages[] = "Tidak punya BPJS tapi ada pembayaran BPJS";
        }

        // 6. Cek kepemilikan rumah kosong
        if (empty(trim($item->kepemilikan_rumah ?? ''))) {
            $categories[] = 'kepemilikan_rumah_kosong';
            $messages[] = "Data kepemilikan rumah tidak diisi";
        }

        return [
            'categories' => array_unique($categories),
            'messages' => $messages
        ];
    }

    private function getCategoryLabel($category)
    {
        $labels = [
            'kk_tanpa_anggota' => 'KK Tanpa Anggota',
            'kk_tanpa_kepala' => 'KK Tanpa Kepala Keluarga',
            'kepala_keluarga_ganda' => 'Kepala Keluarga Ganda',
            'umur_abnormal' => 'Umur Abnormal',
            'perkawinan_tidak_konsisten' => 'Status Perkawinan Tidak Konsisten',
            'bantuan_tidak_konsisten' => 'Bantuan Tidak Konsisten',
            'bpjs_tidak_konsisten' => 'BPJS Tidak Konsisten',
            'kepemilikan_rumah_kosong' => 'Kepemilikan Rumah Kosong'
        ];

        return $labels[$category] ?? $category;
    }

    private function getAnomaliStatistics($desaId)
    {
        $query = DB::table('t_kartu_keluarga_anggota as t1')
            ->join('t_kartu_keluarga as t2', 't1.no_kk', '=', 't2.id')
            ->leftJoin('indonesia_villages as t3', 't3.code', '=', 't2.desa')
            ->leftJoin('m_hubungan_keluarga as t4', 't4.id', '=', 't1.sts_hub_kel')
            ->leftJoin('bantuan_pemerintah as t5', 't5.Id', '=', 't1.bantuan_pemerintah')
            ->leftJoin('m_pernikahan as t6', 't6.id', '=', 't1.sts_kwn')
            ->where('t2.desa', $desaId)
            ->select(
                't1.id as anggota_id',
                't1.no_nik',
                't2.id as kk_id',
                't2.no_kk',
                't1.nama',
                't1.tmpt_lahir as tempat_lahir',
                't1.tgl_lahir as tanggal_lahir',
                't1.jenkel as jenis_kelamin',
                't1.sts_perkawinan as perkawinan',
                't1.status_kawin_tercatat as perkawinan_tercatat',
                't6.nama as status_perkawinan',
                't4.nama as hubungan_keluarga',
                't1.tanya_bantuanpemerintah as bantuan_pemerintah',
                't5.nama as jenis_bantuan_pemerintah',
                't1.punya_bpjs',
                't1.jenis_bpjs',
                't1.pembayaran_bpjs',
                't1.kepemilikan_rumah',
                't2.kp as alamat',
                't2.rt',
                't2.rw',
                't3.name as desa',
            )
            ->get();

        $stats = [
            'all' => 0,
            'kk_tanpa_anggota' => 0,
            'kk_tanpa_kepala' => 0,
            'kepala_keluarga_ganda' => 0,
            'umur_abnormal' => 0,
            'perkawinan_tidak_konsisten' => 0,
            'bantuan_tidak_konsisten' => 0,
            'bpjs_tidak_konsisten' => 0,
            'kepemilikan_rumah_kosong' => 0,
        ];

        // Hitung anomali KK level
        $kkAnomalies = $this->getKKAnomalies($desaId, new Request());

        // Hitung KK tanpa anggota
        $kkTanpaAnggota = $this->getKKTanpaAnggota($desaId, new Request());
        $stats['kk_tanpa_anggota'] = $kkTanpaAnggota->count();

        // Track KK yang sudah dihitung
        $processedKK = [];

        foreach ($query as $item) {
            $anomali = $this->detectAnomali($item);

            // Tambahkan anomali dari level KK
            if (isset($kkAnomalies[$item->no_kk])) {
                $anomali['categories'] = array_merge($anomali['categories'], $kkAnomalies[$item->no_kk]['categories']);
                $anomali['categories'] = array_unique($anomali['categories']);
            }

            if (count($anomali['categories']) > 0) {
                // Hitung hanya sekali per KK untuk anomali level KK
                $isNewKK = !in_array($item->no_kk, $processedKK);

                if ($isNewKK || !in_array('kepala_keluarga_ganda', $anomali['categories']) && !in_array('kk_tanpa_kepala', $anomali['categories'])) {
                    $stats['all']++;
                }

                foreach ($anomali['categories'] as $category) {
                    if (isset($stats[$category])) {
                        // Untuk anomali level KK, hitung hanya sekali per KK
                        if (in_array($category, ['kepala_keluarga_ganda', 'kk_tanpa_kepala'])) {
                            if ($isNewKK) {
                                $stats[$category]++;
                            }
                        } else {
                            // Untuk anomali level anggota, hitung per anggota
                            $stats[$category]++;
                        }
                    }
                }

                $processedKK[] = $item->no_kk;
            }
        }

        // Tambahkan jumlah KK tanpa anggota ke total
        $stats['all'] += $stats['kk_tanpa_anggota'];

        return $stats;
    }
}
