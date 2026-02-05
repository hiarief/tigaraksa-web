<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class KartuKeluargaAnggotaController extends Controller
{
    public function index()
    {
        return view('admin.kependudukan.anggota.index');
    }

    public function indexData(Request $request)
    {
        if ($request->ajax()) {

            $desaId = auth()->user()->desa;
            $userId = auth()->user()->id;

            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->leftJoin('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->leftJoin('m_hubungan_keluarga as t6', 't6.id', '=', 't1.sts_hub_kel')
                ->where('t2.desa', $desaId)
                ->where('t1.sts_mati', 0)
                ->where('t3.id', $userId)
                ->orderByDesc('t1.created_at')
                ->select([
                    't2.id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    't1.nama as nama',
                    't1.tgl_lahir as tgl_lahir',
                    't1.tmpt_lahir as tmpt_lahir',
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't1.created_at as created_at',
                    't1.id as anggota_id',
                    't6.nama as hubungan_keluarga'
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('hubungan_keluarga', fn($row) => strtoupper($row->hubungan_keluarga))
                ->editColumn('tmpt_lahir', fn($row) => strtoupper($row->tmpt_lahir))
                ->editColumn('tgl_lahir', fn($row) => date('d-m-Y', strtotime($row->tgl_lahir)))
                ->addColumn('alamat', function($row) { return strtoupper( $row->kp . ', RT. ' . $row->rt . '/' . $row->rw . ', DS. ' . $row->desa . ', KEC. ' . $row->kecamatan ); })
                ->addColumn('aksi', function ($row) {

                    $viewUrl   = route('kependudukan.kartu.keluarga.show', Crypt::encrypt($row->id));
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
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function create()
    {
        // Ambil data RT yang tersedia
        $rtList = DB::table('m_rt_rw')
            ->whereNotNull('rt')
            ->distinct()
            ->orderBy('rt')
            ->pluck('rt');

        // Ambil data RW yang tersedia
        $rwList = DB::table('m_rt_rw')
            ->whereNotNull('rw')
            ->distinct()
            ->orderBy('rw')
            ->pluck('rw');

        // Ambil master data jenis kelamin
        $jenisKelamin = DB::table('m_jenis_kelamin')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data agama
        $agama = DB::table('m_agama')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data pekerjaan
        $pekerjaan = DB::table('m_pekerjaan')
            ->orderBy('nama')
            ->pluck('nama', 'id');

        // Ambil master data status pernikahan
        $pernikahan = DB::table('m_pernikahan')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data hubungan keluarga
        $hubunganKeluarga = DB::table('m_hubungan_keluarga')
            // ->whereNot('id', 1)
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data golongan darah
        $golDarah = DB::table('m_gol_darah')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data pendidikan keluarga
        $pendidikanKeluarga = DB::table('m_pendidikan_keluarga')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data kewarganegaraan
        $kewarganegaraan = DB::table('m_kewarganegaraan')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data bantuan pemerintah
        $bantuanPemerintah = DB::table('bantuan_pemerintah')
            ->orderBy('id')
            ->pluck('nama', 'id');

        // Ambil master data sakit kronis
        $kronis = DB::table('m_sakit_kronis')
            ->orderBy('id')
            ->pluck('nama', 'id');

        return view('admin.kependudukan.anggota.create', compact(
            'rtList',
            'rwList',
            'jenisKelamin',
            'agama',
            'pekerjaan',
            'pernikahan',
            'hubunganKeluarga',
            'golDarah',
            'pendidikanKeluarga',
            'kewarganegaraan',
            'bantuanPemerintah',
            'kronis'
        ));
    }

    public function kepalaKeluarga(Request $request)
    {
        if ($request->ajax()) {

            $desaId = auth()->user()->desa;
            $userId = auth()->user()->id;
            $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->join('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->join('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->join('indonesia_cities as t6', 't6.code', '=', 't2.kabkot')
                ->join('indonesia_provinces as t7', 't7.code', '=', 't2.provinsi')
                ->where('t1.sts_hub_kel', 1)
                ->orderByDesc('t2.created_at')
                ->where('t2.desa', $desaId)
                ->where('t3.id', $userId)
                ->select([
                    't2.id as kk_id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    't1.nama as nama',
                    't1.tgl_lahir as tgl_lahir',
                    't1.tmpt_lahir as tmpt_lahir',
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't2.kodepos',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't6.name as kabkot',
                    't7.name as provinsi',
                    't1.id as anggota_id',
                    't1.kepemilikan_rumah'
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('tmpt_lahir', fn($row) => strtoupper($row->tmpt_lahir))
                ->editColumn('tgl_lahir', fn($row) => date('d-m-Y', strtotime($row->tgl_lahir)))
                ->addColumn('alamat', function($row) {
                    return strtoupper(
                        $row->kp . ', RT. ' . $row->rt . '/' . $row->rw .
                        ', DS. ' . $row->desa . ', KEC. ' . $row->kecamatan
                    );
                })
                ->addColumn('alamat', function($row) {
                    return strtoupper(
                        $row->kp . ', RT. ' . $row->rt . '/' . $row->rw
                    );
                })
                ->addColumn('aksi', function($row) {
                    $btn = '<button class="btn bg-gradient-info btn-sm text-sm"
                                id="selectFamillies"
                                data-id_kk="'.$row->kk_id.'"
                                data-no_kk="'.$row->no_kk.'"
                                data-nama="'.$row->nama.'"
                                data-kp="'.$row->kp.'"
                                data-rt="'.$row->rt.'"
                                data-rw="'.$row->rw.'"
                                data-kodepos="'.$row->kodepos.'"
                                data-provinsi="'.$row->provinsi.'"
                                data-kabkot="'.$row->kabkot.'"
                                data-kecamatan="'.$row->kecamatan.'"
                                data-kepemilikan_rumah="'.$row->kepemilikan_rumah.'"
                                data-desa="'.$row->desa.'">Pilih
                            </button>';
                    return $btn;
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    public function store(Request $request)
    {
        // Validasi input dengan aturan yang ketat dan aman
        $validated = $request->validate([

            'id_kk' => [
                'required','numeric',
                Rule::exists('t_kartu_keluarga', 'id')
            ],

            // ===== VALIDASI ALAMAT =====
            // Provinsi harus ada dan berupa angka
            'provinsi' => 'required',

            // Kabupaten/Kota harus ada dan berupa angka
            'kabupaten' => 'required',

            // Kecamatan harus ada dan berupa angka
            'kecamatan' => 'required',

            // Desa harus ada dan berupa angka
            'desa' => 'required',

            // Kampung/alamat harus diisi, maksimal 100 karakter
            'kp' => 'required|string|max:100',

            // RT harus ada dalam list yang tersedia
            'rt' => [
                'required',
                Rule::in(DB::table('m_rt_rw')->whereNotNull('rt')->pluck('rt')->toArray())
            ],

            // RW harus ada dalam list yang tersedia
            'rw' => [
                'required',
                Rule::in(DB::table('m_rt_rw')->whereNotNull('rw')->pluck('rw')->toArray())
            ],

            // Kode pos opsional
            'kodepos' => 'nullable|numeric',

            // ===== VALIDASI IDENTITAS KEPALA KELUARGA =====
            // NIK harus 16 digit angka dan unik
            'no_nik' => [
                'required',
                'digits:16',
                'numeric',
                'unique:t_kartu_keluarga_anggota,no_nik'
            ],

            // Nama lengkap wajib diisi, maksimal 100 karakter
            'nama' => 'required|string|max:100',

            // Jenis kelamin harus ada di master data
            'jenkel' => [
                'required',
                Rule::exists('m_jenis_kelamin', 'id')
            ],

            // Tempat lahir wajib diisi, maksimal 50 karakter
            'tmpt_lahir' => 'required|string|max:50',

            // Tanggal lahir harus valid dan tidak lebih dari hari ini
            'tgl_lahir' => 'required|date|before_or_equal:today',

            // Agama harus ada di master data
            'agama' => [
                'required',
                Rule::exists('m_agama', 'id')
            ],

            // Golongan darah harus ada di master data
            'gol_darah' => [
                'required',
                Rule::exists('m_gol_darah', 'id')
            ],

            // ===== VALIDASI PENDIDIKAN =====
            // Pendidikan formal harus ada di master data
            'pendidikan' => [
                'required',
                Rule::exists('m_pendidikan_keluarga', 'id')
            ],

            // Pendidikan non formal opsional, harus sesuai pilihan
            'pendidikan_non' => [
                'nullable',
                Rule::in(['Pesantren Salafiah', 'Pendidikan keagamaan Lainnya', 'Pendidikan Lainnya', 'Tidak Ada'])
            ],

            // ===== VALIDASI PEKERJAAN & PENDAPATAN =====
            // Jenis pekerjaan harus ada di master data
            'jns_pekerjaan' => [
                'required',
                Rule::exists('m_pekerjaan', 'id')
            ],

            // Pendapatan perbulan harus sesuai dengan pilihan yang tersedia
            'pendapatan_perbulan' => [
                'required',
                Rule::in([
                    '0-1 Juta',
                    '1-2 Juta',
                    '2-3 Juta',
                    '3-5 Juta',
                    '5-10 Juta',
                    '10-20 Juta',
                    '20-50 Juta',
                    '50-100 Juta',
                    '>100 Juta'
                ])
            ],

            // ===== VALIDASI STATUS PERKAWINAN =====
            // Status perkawinan harus sesuai pilihan
            'sts_perkawinan' => [
                'required',
                Rule::in(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'])
            ],

            // Status kawin tercatat hanya wajib jika status perkawinan = KAWIN
            'status_kawin_tercatat' => [
                'nullable',
                Rule::requiredIf($request->sts_perkawinan === 'KAWIN'),
                Rule::in(['kawin_tercatat', 'kawin_tidak_tercatat'])
            ],

            // Hubungan keluarga untuk kepala keluarga selalu = 1
            'sts_hub_kel' => 'required',

            // ===== VALIDASI KEWARGANEGARAAN =====
            // Kewarganegaraan harus ada di master data
            'sts_kwn' => [
                'required',
                Rule::exists('m_kewarganegaraan', 'id')
            ],

            // Kepemilikan rumah harus sesuai pilihan
            'kepemilikan_rumah' => [
                'required',
                Rule::in(['Milik Sendiri', 'Orang Tua', 'Ngontrak', 'Lainnya'])
            ],

            // ===== VALIDASI BANTUAN & KESEHATAN =====
            // Kelayakan bantuan pemerintah harus dipilih
            'tanya_bantuanpemerintah' => [
                'required',
                Rule::in(['Tidak Layak', 'Layak'])
            ],

            // Jenis bantuan hanya wajib jika layak mendapat bantuan
            'bantuan_pemerintah' => [
                'nullable',
                Rule::requiredIf($request->tanya_bantuanpemerintah === 'Layak'),
                Rule::exists('bantuan_pemerintah', 'id')
            ],

            // Status sakit kronis harus ada di master data
            'sakitkronis' => [
                'required',
                Rule::exists('m_sakit_kronis', 'id')
            ],

            // Kepemilikan BPJS harus dipilih
            'punya_bpjs' => [
                'required',
                Rule::in(['tidak', 'ya'])
            ],

            // Jenis BPJS hanya wajib jika punya BPJS
            'jenis_bpjs' => [
                'nullable',
                Rule::requiredIf($request->punya_bpjs === 'ya'),
                Rule::in(['bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'memiliki_kedua_bpjs'])
            ],

            // Pembayaran BPJS hanya wajib jika punya BPJS
            'pembayaran_bpjs' => [
                'nullable',
                Rule::requiredIf($request->punya_bpjs === 'ya'),
                Rule::in(['mandiri', 'pemerintah'])
            ],

            // ===== VALIDASI DATA ORANG TUA =====
            // Nama ibu kandung wajib diisi
            'nm_ibu' => 'required|string|max:100',

            // Nama ayah kandung wajib diisi
            'nm_ayah' => 'required|string|max:100',
        ], [
            // ===== CUSTOM ERROR MESSAGES (Bahasa Indonesia) =====
            'id_kk.required' => 'Nomor Kartu Keluarga wajib diisi',
            'id_kk.numeric' => 'Nomor Kartu Keluarga harus berupa angka',
            'id_kk.exists' => 'Nomor Kartu Keluarga tidak valid',

            // Pesan error untuk NIK
            'no_nik.required' => 'NIK wajib diisi',
            'no_nik.digits' => 'NIK harus 16 digit',
            'no_nik.numeric' => 'NIK harus berupa angka',
            'no_nik.unique' => 'NIK sudah terdaftar',

            // Pesan error untuk alamat
            'kp.required' => 'Alamat/Kampung wajib diisi',
            'kp.max' => 'Alamat/Kampung maksimal 100 karakter',
            'rt.required' => 'RT wajib dipilih',
            'rt.in' => 'RT tidak valid',
            'rw.required' => 'RW wajib dipilih',
            'rw.in' => 'RW tidak valid',

            // Pesan error untuk identitas
            'nama.required' => 'Nama lengkap wajib diisi',
            'nama.max' => 'Nama lengkap maksimal 100 karakter',
            'jenkel.required' => 'Jenis kelamin wajib dipilih',
            'jenkel.exists' => 'Jenis kelamin tidak valid',
            'tmpt_lahir.required' => 'Tempat lahir wajib diisi',
            'tmpt_lahir.max' => 'Tempat lahir maksimal 50 karakter',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'tgl_lahir.date' => 'Format tanggal lahir tidak valid',
            'tgl_lahir.before_or_equal' => 'Tanggal lahir tidak boleh lebih dari hari ini',
            'agama.required' => 'Agama wajib dipilih',
            'agama.exists' => 'Agama tidak valid',
            'gol_darah.required' => 'Golongan darah wajib dipilih',
            'gol_darah.exists' => 'Golongan darah tidak valid',

            // Pesan error untuk pendidikan
            'pendidikan.required' => 'Pendidikan formal wajib dipilih',
            'pendidikan.exists' => 'Pendidikan formal tidak valid',
            'pendidikan_non.in' => 'Pendidikan non formal tidak valid',

            // Pesan error untuk pekerjaan
            'jns_pekerjaan.required' => 'Jenis pekerjaan wajib dipilih',
            'jns_pekerjaan.exists' => 'Jenis pekerjaan tidak valid',
            'pendapatan_perbulan.required' => 'Pendapatan perbulan wajib dipilih',
            'pendapatan_perbulan.in' => 'Pendapatan perbulan tidak valid',

            // Pesan error untuk perkawinan
            'sts_perkawinan.required' => 'Status perkawinan wajib dipilih',
            'sts_perkawinan.in' => 'Status perkawinan tidak valid',
            'status_kawin_tercatat.required' => 'Status kawin tercatat wajib dipilih',
            'status_kawin_tercatat.in' => 'Status kawin tercatat tidak valid',

            // Pesan error untuk kewarganegaraan
            'sts_kwn.required' => 'Kewarganegaraan wajib dipilih',
            'sts_kwn.exists' => 'Kewarganegaraan tidak valid',
            'kepemilikan_rumah.required' => 'Kepemilikan rumah wajib dipilih',
            'kepemilikan_rumah.in' => 'Kepemilikan rumah tidak valid',

            // Pesan error untuk bantuan dan kesehatan
            'tanya_bantuanpemerintah.required' => 'Kelayakan bantuan wajib dipilih',
            'tanya_bantuanpemerintah.in' => 'Kelayakan bantuan tidak valid',
            'bantuan_pemerintah.required' => 'Jenis bantuan pemerintah wajib dipilih',
            'bantuan_pemerintah.exists' => 'Jenis bantuan pemerintah tidak valid',
            'sakitkronis.required' => 'Status sakit kronis wajib dipilih',
            'sakitkronis.exists' => 'Status sakit kronis tidak valid',
            'punya_bpjs.required' => 'Status kepemilikan BPJS wajib dipilih',
            'punya_bpjs.in' => 'Status kepemilikan BPJS tidak valid',
            'jenis_bpjs.required' => 'Jenis BPJS wajib dipilih',
            'jenis_bpjs.in' => 'Jenis BPJS tidak valid',
            'pembayaran_bpjs.required' => 'Cara pembayaran BPJS wajib dipilih',
            'pembayaran_bpjs.in' => 'Cara pembayaran BPJS tidak valid',

            // Pesan error untuk orang tua
            'nm_ibu.required' => 'Nama ibu kandung wajib diisi',
            'nm_ibu.max' => 'Nama ibu kandung maksimal 100 karakter',
            'nm_ayah.required' => 'Nama ayah kandung wajib diisi',
            'nm_ayah.max' => 'Nama ayah kandung maksimal 100 karakter',
        ]);

         try {
            // Mulai database transaction untuk keamanan data
            DB::beginTransaction();

            $dataAnggota = [
                'no_kk' => $validated['id_kk'], // Menggunakan ID dari tabel t_kartu_keluarga
                'no_nik' => $validated['no_nik'],
                'nama' => strtoupper($validated['nama']),
                'jenkel' => $validated['jenkel'],
                'tgl_lahir' => $validated['tgl_lahir'],
                'tmpt_lahir' => strtoupper($validated['tmpt_lahir']),
                'agama' => $validated['agama'],
                'pendidikan' => $validated['pendidikan'],
                'pendidikan_non' => $validated['pendidikan_non'] ?? null,
                'jns_pekerjaan' => $validated['jns_pekerjaan'],
                'jenis_umkm' => null, // Field baru, set null jika tidak ada input
                'gol_darah' => $validated['gol_darah'],
                'pendapatan_perbulan' => $validated['pendapatan_perbulan'],
                'sts_perkawinan' => $validated['sts_perkawinan'],
                'status_kawin_tercatat' => $validated['status_kawin_tercatat'] ?? null,
                'sts_hub_kel' => $validated['sts_hub_kel'], // 1 = Kepala Keluarga
                'sts_kwn' => $validated['sts_kwn'],
                'tanya_bantuanpemerintah' => $validated['tanya_bantuanpemerintah'],
                'bantuan_pemerintah' => $validated['bantuan_pemerintah'] ?? null,
                'sakitkronis' => $validated['sakitkronis'],
                'punya_bpjs' => $validated['punya_bpjs'],
                'jenis_bpjs' => $validated['jenis_bpjs'] ?? null,
                'pembayaran_bpjs' => $validated['pembayaran_bpjs'] ?? null,
                'nm_ayah' => strtoupper($validated['nm_ayah']),
                'nm_ibu' => strtoupper($validated['nm_ibu']),
                'kepemilikan_rumah' => $validated['kepemilikan_rumah'],
                'sts_mati' => 0, // Default: masih hidup
                'user_id' => auth()->id(),
                'sts' => 1, // Status aktif
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data Anggota Keluarga (Kepala Keluarga)
            $insertAnggota = DB::table('t_kartu_keluarga_anggota')->insert($dataAnggota);

            if (!$insertAnggota) {
                throw new \Exception('Gagal menyimpan data Anggota Keluarga');
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('kependudukan.anggota.keluarga.index')
                ->with('success', 'Data Anggota Keluarga berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Error saat menyimpan Anggota Keluarga: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            // Decrypt ID
            $anggotaId = Crypt::decrypt($id);

            // Ambil data anggota keluarga dengan join ke tabel terkait
            $anggota = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->leftJoin('indonesia_provinces as t3', 't3.code', '=', 't2.provinsi')
                ->leftJoin('indonesia_cities as t4', 't4.code', '=', 't2.kabkot')
                ->leftJoin('indonesia_districts as t5', 't5.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t6', 't6.code', '=', 't2.desa')
                ->where('t1.id', $anggotaId)
                // ->where('t1.user_id', auth()->id())
                ->select([
                    't1.*',
                    't2.id as kk_id',
                    't2.no_kk',
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't2.kodepos',
                    't2.provinsi as provinsi_code',
                    't2.kabkot as kabkot_code',
                    't2.kecamatan as kecamatan_code',
                    't2.desa as desa_code',
                    't3.name as provinsi',
                    't4.name as kabkot',
                    't5.name as kecamatan',
                    't6.name as desa'
                ])
                ->first();

            // Jika data tidak ditemukan
            if (!$anggota) {
                return redirect()
                    ->route('kependudukan.anggota.keluarga.index')
                    ->with('error', 'Data tidak ditemukan atau Anda tidak memiliki akses');
            }

            // Ambil data RT yang tersedia
            $rtList = DB::table('m_rt_rw')
                ->whereNotNull('rt')
                ->distinct()
                ->orderBy('rt')
                ->pluck('rt');

            // Ambil data RW yang tersedia
            $rwList = DB::table('m_rt_rw')
                ->whereNotNull('rw')
                ->distinct()
                ->orderBy('rw')
                ->pluck('rw');

            // Ambil master data jenis kelamin
            $jenisKelamin = DB::table('m_jenis_kelamin')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data agama
            $agama = DB::table('m_agama')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data pekerjaan
            $pekerjaan = DB::table('m_pekerjaan')
                ->orderBy('nama')
                ->pluck('nama', 'id');

            // Ambil master data status pernikahan
            $pernikahan = DB::table('m_pernikahan')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data hubungan keluarga
            $hubunganKeluarga = DB::table('m_hubungan_keluarga')
                // ->whereNot('id', 1)
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data golongan darah
            $golDarah = DB::table('m_gol_darah')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data pendidikan keluarga
            $pendidikanKeluarga = DB::table('m_pendidikan_keluarga')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data kewarganegaraan
            $kewarganegaraan = DB::table('m_kewarganegaraan')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data bantuan pemerintah
            $bantuanPemerintah = DB::table('bantuan_pemerintah')
                ->orderBy('id')
                ->pluck('nama', 'id');

            // Ambil master data sakit kronis
            $kronis = DB::table('m_sakit_kronis')
                ->orderBy('id')
                ->pluck('nama', 'id');

            return view('admin.kependudukan.anggota.edit', compact(
                'anggota',
                'rtList',
                'rwList',
                'jenisKelamin',
                'agama',
                'pekerjaan',
                'pernikahan',
                'hubunganKeluarga',
                'golDarah',
                'pendidikanKeluarga',
                'kewarganegaraan',
                'bantuanPemerintah',
                'kronis'
            ));

        } catch (\Exception $e) {
            Log::error('Error saat membuka form edit: ' . $e->getMessage());

            return redirect()
                ->route('kependudukan.anggota.keluarga.index')
                ->with('error', 'Terjadi kesalahan saat membuka form edit');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            // Decrypt ID
            $anggotaId = Crypt::decrypt($id);

            // Validasi input dengan aturan yang ketat dan aman
            $validated = $request->validate([

                'id_kk' => [
                    'required','numeric',
                    Rule::exists('t_kartu_keluarga', 'id')
                ],

                // ===== VALIDASI ALAMAT =====
                'provinsi' => 'required',
                'kabupaten' => 'required',
                'kecamatan' => 'required',
                'desa' => 'required',
                'kp' => 'required|string|max:100',
                'rt' => [
                    'required',
                    Rule::in(DB::table('m_rt_rw')->whereNotNull('rt')->pluck('rt')->toArray())
                ],
                'rw' => [
                    'required',
                    Rule::in(DB::table('m_rt_rw')->whereNotNull('rw')->pluck('rw')->toArray())
                ],
                'kodepos' => 'nullable|numeric',

                // ===== VALIDASI IDENTITAS =====
                'no_nik' => [
                    'required',
                    'digits:16',
                    'numeric',
                    Rule::unique('t_kartu_keluarga_anggota', 'no_nik')->ignore($anggotaId)
                ],
                'nama' => 'required|string|max:100',
                'jenkel' => [
                    'required',
                    Rule::exists('m_jenis_kelamin', 'id')
                ],
                'tmpt_lahir' => 'required|string|max:50',
                'tgl_lahir' => 'required|date|before_or_equal:today',
                'agama' => [
                    'required',
                    Rule::exists('m_agama', 'id')
                ],
                'gol_darah' => [
                    'required',
                    Rule::exists('m_gol_darah', 'id')
                ],

                // ===== VALIDASI PENDIDIKAN =====
                'pendidikan' => [
                    'required',
                    Rule::exists('m_pendidikan_keluarga', 'id')
                ],
                'pendidikan_non' => [
                    'nullable',
                    Rule::in(['Pesantren Salafiah', 'Pendidikan keagamaan Lainnya', 'Pendidikan Lainnya', 'Tidak Ada'])
                ],

                // ===== VALIDASI PEKERJAAN & PENDAPATAN =====
                'jns_pekerjaan' => [
                    'required',
                    Rule::exists('m_pekerjaan', 'id')
                ],
                'pendapatan_perbulan' => [
                    'required',
                    Rule::in([
                        '0-1 Juta',
                        '1-2 Juta',
                        '2-3 Juta',
                        '3-5 Juta',
                        '5-10 Juta',
                        '10-20 Juta',
                        '20-50 Juta',
                        '50-100 Juta',
                        '>100 Juta'
                    ])
                ],

                // ===== VALIDASI STATUS PERKAWINAN =====
                'sts_perkawinan' => [
                    'required',
                    Rule::in(['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'])
                ],
                'status_kawin_tercatat' => [
                    'nullable',
                    Rule::requiredIf($request->sts_perkawinan === 'KAWIN'),
                    Rule::in(['kawin_tercatat', 'kawin_tidak_tercatat'])
                ],
                'sts_hub_kel' => 'required',

                // ===== VALIDASI KEWARGANEGARAAN =====
                'sts_kwn' => [
                    'required',
                    Rule::exists('m_kewarganegaraan', 'id')
                ],
                'kepemilikan_rumah' => [
                    'required',
                    Rule::in(['Milik Sendiri', 'Orang Tua', 'Ngontrak', 'Lainnya'])
                ],

                // ===== VALIDASI BANTUAN & KESEHATAN =====
                'tanya_bantuanpemerintah' => [
                    'required',
                    Rule::in(['Tidak Layak', 'Layak'])
                ],
                'bantuan_pemerintah' => [
                    'nullable',
                    Rule::requiredIf($request->tanya_bantuanpemerintah === 'Layak'),
                    Rule::exists('bantuan_pemerintah', 'id')
                ],
                'sakitkronis' => [
                    'required',
                    Rule::exists('m_sakit_kronis', 'id')
                ],
                'punya_bpjs' => [
                    'required',
                    Rule::in(['tidak', 'ya'])
                ],
                'jenis_bpjs' => [
                    'nullable',
                    Rule::requiredIf($request->punya_bpjs === 'ya'),
                    Rule::in(['bpjs_kesehatan', 'bpjs_ketenagakerjaan', 'memiliki_kedua_bpjs'])
                ],
                'pembayaran_bpjs' => [
                    'nullable',
                    Rule::requiredIf($request->punya_bpjs === 'ya'),
                    Rule::in(['mandiri', 'pemerintah'])
                ],

                // ===== VALIDASI DATA ORANG TUA =====
                'nm_ibu' => 'required|string|max:100',
                'nm_ayah' => 'required|string|max:100',
            ], [
                // Custom error messages (sama seperti store)
                'id_kk.required' => 'Nomor Kartu Keluarga wajib diisi',
                'id_kk.numeric' => 'Nomor Kartu Keluarga harus berupa angka',
                'id_kk.exists' => 'Nomor Kartu Keluarga tidak valid',
                'no_nik.required' => 'NIK wajib diisi',
                'no_nik.digits' => 'NIK harus 16 digit',
                'no_nik.numeric' => 'NIK harus berupa angka',
                'no_nik.unique' => 'NIK sudah terdaftar',
                // ... (tambahkan semua pesan error lainnya seperti di store)
            ]);

            // Mulai database transaction
            DB::beginTransaction();

            // Cek apakah data exists dan milik user yang login
            $existingData = DB::table('t_kartu_keluarga_anggota')
                ->where('id', $anggotaId)
                // ->where('user_id', auth()->id())
                ->first();

            if (!$existingData) {
                throw new \Exception('Data tidak ditemukan atau Anda tidak memiliki akses');
            }

            $dataAnggota = [
                'no_kk' => $validated['id_kk'],
                'no_nik' => $validated['no_nik'],
                'nama' => strtoupper($validated['nama']),
                'jenkel' => $validated['jenkel'],
                'tgl_lahir' => $validated['tgl_lahir'],
                'tmpt_lahir' => strtoupper($validated['tmpt_lahir']),
                'agama' => $validated['agama'],
                'pendidikan' => $validated['pendidikan'],
                'pendidikan_non' => $validated['pendidikan_non'] ?? null,
                'jns_pekerjaan' => $validated['jns_pekerjaan'],
                'gol_darah' => $validated['gol_darah'],
                'pendapatan_perbulan' => $validated['pendapatan_perbulan'],
                'sts_perkawinan' => $validated['sts_perkawinan'],
                'status_kawin_tercatat' => $validated['status_kawin_tercatat'] ?? null,
                'sts_hub_kel' => $validated['sts_hub_kel'],
                'sts_kwn' => $validated['sts_kwn'],
                'tanya_bantuanpemerintah' => $validated['tanya_bantuanpemerintah'],
                'bantuan_pemerintah' => $validated['bantuan_pemerintah'] ?? null,
                'sakitkronis' => $validated['sakitkronis'],
                'punya_bpjs' => $validated['punya_bpjs'],
                'jenis_bpjs' => $validated['jenis_bpjs'] ?? null,
                'pembayaran_bpjs' => $validated['pembayaran_bpjs'] ?? null,
                'nm_ayah' => strtoupper($validated['nm_ayah']),
                'nm_ibu' => strtoupper($validated['nm_ibu']),
                'kepemilikan_rumah' => $validated['kepemilikan_rumah'],
                'updated_at' => now(),
            ];

            // Update data Anggota Keluarga
            $updateAnggota = DB::table('t_kartu_keluarga_anggota')
                ->where('id', $anggotaId)
                ->update($dataAnggota);

            if (!$updateAnggota && $updateAnggota !== 0) {
                throw new \Exception('Gagal mengupdate data Anggota Keluarga');
            }

            // Commit transaction
            DB::commit();

            return redirect()
                ->route('kependudukan.anggota.keluarga.index')
                ->with('success', 'Data Anggota Keluarga berhasil diperbarui!');

        } catch (\Exception $e) {
            // Rollback transaction
            DB::rollBack();

            Log::error('Error saat update Anggota Keluarga: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data: ' . $e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            // Decrypt ID
            $anggotaId = Crypt::decrypt($id);

            DB::beginTransaction();

            // Ambil data anggota dengan join ke t_kartu_keluarga
            $anggota = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->where('t1.id', $anggotaId)
                ->where('t2.user_id', auth()->id())
                ->select([
                    't1.*',
                    't2.no_kk as nomor_kk'
                ])
                ->first();

            if (!$anggota) {
                throw new \Exception('Data tidak ditemukan atau Anda tidak memiliki akses');
            }

            // CRITICAL: Cek apakah ini Kepala Keluarga
            if ($anggota->sts_hub_kel == 1) {
                // Cek apakah masih ada anggota keluarga lain di KK yang sama
                $anggotaLain = DB::table('t_kartu_keluarga_anggota')
                    ->where('no_kk', $anggota->no_kk)
                    ->where('id', '!=', $anggotaId)
                    ->count();

                if ($anggotaLain > 0) {
                    return response()->json([
                        'success' => false,
                        'is_kepala_keluarga' => true,
                        'message' => 'Tidak dapat menghapus Kepala Keluarga!',
                        'details' => "Masih terdapat {$anggotaLain} anggota keluarga yang aktif di KK {$anggota->nomor_kk}. Silakan ganti kepala keluarga terlebih dahulu atau hapus semua anggota keluarga lainnya.",
                        'suggestion' => 'Langkah-langkah yang bisa dilakukan:<br>1. Edit salah satu anggota keluarga menjadi Kepala Keluarga, atau<br>2. Hapus semua anggota keluarga lainnya terlebih dahulu'
                    ], 422);
                }
            }

            // Pindahkan data ke tabel backup
            $backupData = [
                'no_kk' => $anggota->no_kk,
                'no_nik' => $anggota->no_nik,
                'nama' => $anggota->nama,
                'jenkel' => $anggota->jenkel,
                'tgl_lahir' => $anggota->tgl_lahir,
                'tmpt_lahir' => $anggota->tmpt_lahir,
                'agama' => $anggota->agama,
                'pendidikan' => $anggota->pendidikan,
                'pendidikan_non' => $anggota->pendidikan_non,
                'jns_pekerjaan' => $anggota->jns_pekerjaan,
                'jenis_umkm' => $anggota->jenis_umkm,
                'gol_darah' => $anggota->gol_darah,
                'pendapatan_perbulan' => $anggota->pendapatan_perbulan,
                'sts_perkawinan' => $anggota->sts_perkawinan,
                'status_kawin_tercatat' => $anggota->status_kawin_tercatat,
                'sts_hub_kel' => $anggota->sts_hub_kel,
                'sts_kwn' => $anggota->sts_kwn,
                'tanya_bantuanpemerintah' => $anggota->tanya_bantuanpemerintah,
                'bantuan_pemerintah' => $anggota->bantuan_pemerintah,
                'sakitkronis' => $anggota->sakitkronis,
                'punya_bpjs' => $anggota->punya_bpjs,
                'jenis_bpjs' => $anggota->jenis_bpjs,
                'pembayaran_bpjs' => $anggota->pembayaran_bpjs,
                'nm_ayah' => $anggota->nm_ayah,
                'nm_ibu' => $anggota->nm_ibu,
                'kepemilikan_rumah' => $anggota->kepemilikan_rumah,
                'sts_mati' => 0,
                'user_id' => $anggota->user_id,
                'sts' => $anggota->sts,
                'original_id' => $anggota->id,
                'deleted_by' => auth()->id(),
                'deleted_at' => now(),
                'created_at' => $anggota->created_at,
                'updated_at' => now()
            ];

            // Insert ke tabel backup
            $inserted = DB::table('t_kartu_keluarga_anggota_delete')->insert($backupData);

            if (!$inserted) {
                throw new \Exception('Gagal memindahkan data ke tabel backup');
            }

            // Hapus dari tabel asli
            $deleted = DB::table('t_kartu_keluarga_anggota')
                ->where('id', $anggotaId)
                ->delete();

            if (!$deleted) {
                throw new \Exception('Gagal menghapus data dari tabel asli');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data anggota keluarga berhasil dihapus dan dipindahkan ke backup!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat delete Anggota Keluarga: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Trash Page
     */
    public function trash()
    {
        return view('admin.kependudukan.anggota.trash');
    }

    /**
     * Trash Data (DataTables)
     */
    public function trashData(Request $request)
    {
        if ($request->ajax()) {

            $desaId = auth()->user()->desa;
            $userId = auth()->user()->id;

            $data = DB::table('t_kartu_keluarga_anggota_delete as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->leftJoin('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->leftJoin('m_hubungan_keluarga as t6', 't6.id', '=', 't1.sts_hub_kel')
                ->where('t2.desa', $desaId)
                ->where('t3.id', $userId)
                ->orderByDesc('t1.deleted_at')
                ->select([
                    't2.id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    't1.nama as nama',
                    't1.tgl_lahir as tgl_lahir',
                    't1.tmpt_lahir as tmpt_lahir',
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't1.deleted_at as deleted_at',
                    't1.id as backup_id',
                    't1.original_id as original_id',
                    't6.nama as hubungan_keluarga'
                ]);

            return DataTables::of($data)
                ->addIndexColumn()
                ->editColumn('nama', fn($row) => strtoupper($row->nama))
                ->editColumn('hubungan_keluarga', fn($row) => strtoupper($row->hubungan_keluarga ?? '-'))
                ->editColumn('tmpt_lahir', fn($row) => strtoupper($row->tmpt_lahir))
                ->editColumn('tgl_lahir', fn($row) => date('d-m-Y', strtotime($row->tgl_lahir)))
                ->editColumn('deleted_at', fn($row) => date('d-m-Y H:i:s', strtotime($row->deleted_at)))
                ->addColumn('alamat', function($row) {
                    return strtoupper( $row->kp . ', RT. ' . $row->rt . '/' . $row->rw . ', DS. ' . $row->desa . ', KEC. ' . $row->kecamatan );
                })
                ->addColumn('aksi', function ($row) {

                    $restoreUrl = route('kependudukan.anggota.keluarga.restore', Crypt::encrypt($row->backup_id));
                    $deleteUrl = route('kependudukan.anggota.keluarga.delete.permanent', Crypt::encrypt($row->backup_id));

                    return '
                        <div class="btn-group btn-group-sm text-center" role="group">
                            <button type="button"
                                class="btn bg-gradient-success"
                                title="Restore"
                                onclick="restoreData(\''.$restoreUrl.'\')">
                                <i class="fas fa-undo"></i> Restore
                            </button>

                            <button type="button"
                                class="btn bg-gradient-danger"
                                title="Hapus Permanen"
                                onclick="deletePermanent(\''.$deleteUrl.'\')">
                                <i class="fas fa-trash-alt"></i> Hapus Permanen
                            </button>
                        </div>
                    ';
                })
                ->rawColumns(['aksi'])
                ->make(true);
        }
    }

    /**
     * Restore (Move back from Backup Table)
     */
    public function restore($id)
    {
        try {
            // Decrypt ID
            $backupId = Crypt::decrypt($id);

            DB::beginTransaction();

            // Ambil data dari tabel backup
            $backupData = DB::table('t_kartu_keluarga_anggota_delete as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->where('t1.id', $backupId)
                ->where('t2.user_id', auth()->id())
                ->select('t1.*')
                ->first();

            if (!$backupData) {
                throw new \Exception('Data tidak ditemukan atau Anda tidak memiliki akses');
            }

            // Cek apakah NIK sudah ada di tabel asli (untuk menghindari duplikasi)
            $existingNik = DB::table('t_kartu_keluarga_anggota')
                ->where('no_nik', $backupData->no_nik)
                ->exists();

            if ($existingNik) {
                throw new \Exception('NIK sudah terdaftar di database aktif. Data tidak dapat di-restore.');
            }

            // Kembalikan data ke tabel asli
            $restoreData = [
                'no_kk' => $backupData->no_kk,
                'no_nik' => $backupData->no_nik,
                'nama' => $backupData->nama,
                'jenkel' => $backupData->jenkel,
                'tgl_lahir' => $backupData->tgl_lahir,
                'tmpt_lahir' => $backupData->tmpt_lahir,
                'agama' => $backupData->agama,
                'pendidikan' => $backupData->pendidikan,
                'pendidikan_non' => $backupData->pendidikan_non,
                'jns_pekerjaan' => $backupData->jns_pekerjaan,
                'jenis_umkm' => $backupData->jenis_umkm,
                'gol_darah' => $backupData->gol_darah,
                'pendapatan_perbulan' => $backupData->pendapatan_perbulan,
                'sts_perkawinan' => $backupData->sts_perkawinan,
                'status_kawin_tercatat' => $backupData->status_kawin_tercatat,
                'sts_hub_kel' => $backupData->sts_hub_kel,
                'sts_kwn' => $backupData->sts_kwn,
                'tanya_bantuanpemerintah' => $backupData->tanya_bantuanpemerintah,
                'bantuan_pemerintah' => $backupData->bantuan_pemerintah,
                'sakitkronis' => $backupData->sakitkronis,
                'punya_bpjs' => $backupData->punya_bpjs,
                'jenis_bpjs' => $backupData->jenis_bpjs,
                'pembayaran_bpjs' => $backupData->pembayaran_bpjs,
                'nm_ayah' => $backupData->nm_ayah,
                'nm_ibu' => $backupData->nm_ibu,
                'kepemilikan_rumah' => $backupData->kepemilikan_rumah,
                'sts_mati' => 0,
                'user_id' => $backupData->user_id,
                'sts' => $backupData->sts,
                'created_at' => $backupData->created_at,
                'updated_at' => now()
            ];

            // Insert kembali ke tabel asli
            $restored = DB::table('t_kartu_keluarga_anggota')->insert($restoreData);

            if (!$restored) {
                throw new \Exception('Gagal mengembalikan data ke tabel asli');
            }

            // Hapus dari tabel backup
            $deleted = DB::table('t_kartu_keluarga_anggota_delete')
                ->where('id', $backupId)
                ->delete();

            if (!$deleted) {
                throw new \Exception('Gagal menghapus data dari tabel backup');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dikembalikan!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat restore Anggota Keluarga: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete Permanent (Delete from Backup Table)
     */
    public function deletePermanent($id)
    {
        try {
            // Decrypt ID
            $backupId = Crypt::decrypt($id);

            DB::beginTransaction();

            // Cek apakah data exists dan milik user yang login
            $existingData = DB::table('t_kartu_keluarga_anggota_delete as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->where('t1.id', $backupId)
                ->where('t2.user_id', auth()->id())
                ->select('t1.*')
                ->first();

            if (!$existingData) {
                throw new \Exception('Data tidak ditemukan atau Anda tidak memiliki akses');
            }

            // Hapus permanen dari tabel backup
            $deleted = DB::table('t_kartu_keluarga_anggota_delete')
                ->where('id', $backupId)
                ->delete();

            if (!$deleted) {
                throw new \Exception('Gagal menghapus data secara permanen');
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus secara permanen!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat delete permanent Anggota Keluarga: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore All
     */
    public function restoreAll()
    {
        try {
            DB::beginTransaction();

            $userId = auth()->user()->id;

            // Ambil semua data backup milik user
            $backupDataList = DB::table('t_kartu_keluarga_anggota_delete as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->where('t2.user_id', $userId)
                ->select('t1.*')
                ->get();

            if ($backupDataList->isEmpty()) {
                throw new \Exception('Tidak ada data yang bisa di-restore');
            }

            $restoredCount = 0;
            $skippedCount = 0;

            foreach ($backupDataList as $backupData) {
                // Cek apakah NIK sudah ada di tabel asli
                $existingNik = DB::table('t_kartu_keluarga_anggota')
                    ->where('no_nik', $backupData->no_nik)
                    ->exists();

                if ($existingNik) {
                    $skippedCount++;
                    continue;
                }

                // Kembalikan data ke tabel asli
                $restoreData = [
                    'no_kk' => $backupData->no_kk,
                    'no_nik' => $backupData->no_nik,
                    'nama' => $backupData->nama,
                    'jenkel' => $backupData->jenkel,
                    'tgl_lahir' => $backupData->tgl_lahir,
                    'tmpt_lahir' => $backupData->tmpt_lahir,
                    'agama' => $backupData->agama,
                    'pendidikan' => $backupData->pendidikan,
                    'pendidikan_non' => $backupData->pendidikan_non,
                    'jns_pekerjaan' => $backupData->jns_pekerjaan,
                    'jenis_umkm' => $backupData->jenis_umkm,
                    'gol_darah' => $backupData->gol_darah,
                    'pendapatan_perbulan' => $backupData->pendapatan_perbulan,
                    'sts_perkawinan' => $backupData->sts_perkawinan,
                    'status_kawin_tercatat' => $backupData->status_kawin_tercatat,
                    'sts_hub_kel' => $backupData->sts_hub_kel,
                    'sts_kwn' => $backupData->sts_kwn,
                    'tanya_bantuanpemerintah' => $backupData->tanya_bantuanpemerintah,
                    'bantuan_pemerintah' => $backupData->bantuan_pemerintah,
                    'sakitkronis' => $backupData->sakitkronis,
                    'punya_bpjs' => $backupData->punya_bpjs,
                    'jenis_bpjs' => $backupData->jenis_bpjs,
                    'pembayaran_bpjs' => $backupData->pembayaran_bpjs,
                    'nm_ayah' => $backupData->nm_ayah,
                    'nm_ibu' => $backupData->nm_ibu,
                    'kepemilikan_rumah' => $backupData->kepemilikan_rumah,
                    'sts_mati' => 0,
                    'user_id' => $backupData->user_id,
                    'sts' => $backupData->sts,
                    'created_at' => $backupData->created_at,
                    'updated_at' => now()
                ];

                DB::table('t_kartu_keluarga_anggota')->insert($restoreData);

                // Hapus dari tabel backup
                DB::table('t_kartu_keluarga_anggota_delete')
                    ->where('id', $backupData->id)
                    ->delete();

                $restoredCount++;
            }

            DB::commit();

            $message = "Berhasil mengembalikan {$restoredCount} data!";
            if ($skippedCount > 0) {
                $message .= " ({$skippedCount} data dilewati karena NIK sudah terdaftar)";
            }

            return response()->json([
                'success' => true,
                'message' => $message
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat restore all: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete All Permanent
     */
    public function deleteAllPermanent()
    {
        try {
            DB::beginTransaction();

            $userId = auth()->user()->id;

            // Hapus semua data backup milik user
            $deleted = DB::table('t_kartu_keluarga_anggota_delete as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->where('t2.user_id', $userId)
                ->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => "Berhasil menghapus {$deleted} data secara permanen!"
            ]);

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Error saat delete all permanent: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}