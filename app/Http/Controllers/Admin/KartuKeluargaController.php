<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;

class KartuKeluargaController extends Controller
{
    public function index()
    {
        return view('admin.kependudukan.kartukeluarga.index');
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
                ->where('t1.sts_hub_kel', 1)
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
                    't1.id as anggota_id'
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
                ->addColumn('aksi', function ($row) {

                    $viewUrl   = route('kependudukan.kartu.keluarga.show', Crypt::encrypt($row->id));
                    $editUrl   = route('kependudukan.kartu.keluarga.edit', Crypt::encrypt($row->id));
                    $deleteUrl = route('kependudukan.kartu.keluarga.delete', Crypt::encrypt($row->id));

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
                                onclick="deleteData('.$row->id.')">
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

        return view('admin.kependudukan.kartukeluarga.create', compact(
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

    /**
     * Menyimpan data kartu keluarga baru
     */
    public function store(Request $request)
    {
        // Validasi input dengan aturan yang ketat dan aman
        $validated = $request->validate([
            // ===== VALIDASI NOMOR KARTU KELUARGA =====
            // NKK harus 16 digit angka dan unik
            'no_kk' => [
                'required',
                'digits:16',
                'numeric',
                'unique:t_kartu_keluarga,no_kk'
            ],

            // ===== VALIDASI ALAMAT =====
            // Provinsi harus ada dan berupa angka
            'provinsi' => 'required|numeric',

            // Kabupaten/Kota harus ada dan berupa angka
            'kabkot' => 'required|numeric',

            // Kecamatan harus ada dan berupa angka
            'kecamatan' => 'required|numeric',

            // Desa harus ada dan berupa angka
            'desa' => 'required|numeric',

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
            'sts_hub_kel' => 'required|in:1',

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

            // Pesan error untuk NKK
            'no_kk.required' => 'Nomor Kartu Keluarga wajib diisi',
            'no_kk.digits' => 'Nomor Kartu Keluarga harus 16 digit',
            'no_kk.numeric' => 'Nomor Kartu Keluarga harus berupa angka',
            'no_kk.unique' => 'Nomor Kartu Keluarga sudah terdaftar',

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

            // ===================================================================
            // STEP 1: SIMPAN DATA KE TABLE t_kartu_keluarga (Data KK)
            // ===================================================================
            $dataKK = [
                'no_kk' => $validated['no_kk'],
                'kp' => strtoupper($validated['kp']),
                'rt' => $validated['rt'],
                'rw' => $validated['rw'],
                'kodepos' => $validated['kodepos'] ?? '0',
                'desa' => $validated['desa'],
                'kecamatan' => $validated['kecamatan'],
                'kabkot' => $validated['kabkot'],
                'provinsi' => $validated['provinsi'],
                'user_id' => auth()->id(),
                'sts' => 1, // Status aktif
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert data Kartu Keluarga dan dapatkan ID yang baru dibuat
            $kartuKeluargaId = DB::table('t_kartu_keluarga')->insertGetId($dataKK);

            if (!$kartuKeluargaId) {
                throw new \Exception('Gagal menyimpan data Kartu Keluarga');
            }

            // ===================================================================
            // STEP 2: SIMPAN DATA KE TABLE t_kartu_keluarga_anggota (Kepala KK)
            // ===================================================================
            $dataAnggota = [
                'no_kk' => $kartuKeluargaId, // Menggunakan ID dari tabel t_kartu_keluarga
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
                'sts_kwn' => $validated['sts_kwn'], // Duplikasi untuk field kewarganegaraan
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
                ->route('kependudukan.kartu.keluarga.index')
                ->with('success', 'Data Kartu Keluarga berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Error saat menyimpan Kartu Keluarga: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage());
        }
    }

      /**
     * Menampilkan form edit kartu keluarga
     */
    public function edit($id)
    {

        try {
            // Decrypt ID yang dienkripsi
            $id = Crypt::decrypt($id);

            // Ambil data Kartu Keluarga berdasarkan ID
            $kartuKeluarga = DB::table('t_kartu_keluarga')
                ->where('id', $id)
                ->first();

            // Jika data tidak ditemukan
            if (!$kartuKeluarga) {
                return redirect()
                    ->route('kependudukan.kartu.keluarga.index')
                    ->with('error', 'Data Kartu Keluarga tidak ditemukan!');
            }

            // Ambil data Kepala Keluarga dari tabel anggota
            $kepalaKeluarga = DB::table('t_kartu_keluarga_anggota')
                ->where('no_kk', $id)
                ->where('sts_hub_kel', 1) // 1 = Kepala Keluarga
                ->first();

            // Jika data kepala keluarga tidak ditemukan
            if (!$kepalaKeluarga) {
                return redirect()
                    ->route('kependudukan.kartu.keluarga.index')
                    ->with('error', 'Data Kepala Keluarga tidak ditemukan!');
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
                ->orderBy('nama')
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

            return view('admin.kependudukan.kartukeluarga.edit', compact(
                'kartuKeluarga',
                'kepalaKeluarga',
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
            // Log error untuk debugging
            \Log::error('Error saat membuka form edit Kartu Keluarga: ' . $e->getMessage());

            return redirect()
                ->route('kependudukan.kartu.keluarga.index')
                ->with('error', 'Terjadi kesalahan saat membuka form edit!');
        }
    }

    /**
     * Update data kartu keluarga
     */
    public function update(Request $request, $id)
    {
        try {
            // Decrypt ID yang dienkripsi
            $id = Crypt::decrypt($id);

            // Cek apakah data KK ada
            $existingKK = DB::table('t_kartu_keluarga')
                ->where('id', $id)
                ->first();

            if (!$existingKK) {
                return redirect()
                    ->route('kependudukan.kartu.keluarga.index')
                    ->with('error', 'Data Kartu Keluarga tidak ditemukan!');
            }

            // Cek apakah data Kepala Keluarga ada
            $existingKepala = DB::table('t_kartu_keluarga_anggota')
                ->where('no_kk', $id)
                ->where('sts_hub_kel', 1)
                ->first();

            if (!$existingKepala) {
                return redirect()
                    ->route('kependudukan.kartu.keluarga.index')
                    ->with('error', 'Data Kepala Keluarga tidak ditemukan!');
            }

            // Validasi input dengan aturan yang ketat dan aman
            $validated = $request->validate([
                // ===== VALIDASI NOMOR KARTU KELUARGA =====
                // NKK harus 16 digit angka dan unik (kecuali untuk data yang sedang diedit)
                'no_kk' => [
                    'required',
                    'digits:16',
                    'numeric',
                    Rule::unique('t_kartu_keluarga', 'no_kk')->ignore($id)
                ],

                // ===== VALIDASI ALAMAT =====
                'provinsi' => 'required|numeric',
                'kabkot' => 'required|numeric',
                'kecamatan' => 'required|numeric',
                'desa' => 'required|numeric',
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

                // ===== VALIDASI IDENTITAS KEPALA KELUARGA =====
                // NIK harus 16 digit angka dan unik (kecuali untuk data yang sedang diedit)
                'no_nik' => [
                    'required',
                    'digits:16',
                    'numeric',
                    Rule::unique('t_kartu_keluarga_anggota', 'no_nik')->ignore($existingKepala->id)
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
                        '0-1 Juta', '1-2 Juta', '2-3 Juta', '3-5 Juta', '5-10 Juta',
                        '10-20 Juta', '20-50 Juta', '50-100 Juta', '>100 Juta'
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
                'sts_hub_kel' => 'required|in:1',

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
                // ===== CUSTOM ERROR MESSAGES (Bahasa Indonesia) =====
                'no_kk.required' => 'Nomor Kartu Keluarga wajib diisi',
                'no_kk.digits' => 'Nomor Kartu Keluarga harus 16 digit',
                'no_kk.numeric' => 'Nomor Kartu Keluarga harus berupa angka',
                'no_kk.unique' => 'Nomor Kartu Keluarga sudah terdaftar',
                'no_nik.required' => 'NIK wajib diisi',
                'no_nik.digits' => 'NIK harus 16 digit',
                'no_nik.numeric' => 'NIK harus berupa angka',
                'no_nik.unique' => 'NIK sudah terdaftar',
                'kp.required' => 'Alamat/Kampung wajib diisi',
                'kp.max' => 'Alamat/Kampung maksimal 100 karakter',
                'rt.required' => 'RT wajib dipilih',
                'rt.in' => 'RT tidak valid',
                'rw.required' => 'RW wajib dipilih',
                'rw.in' => 'RW tidak valid',
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
                'pendidikan.required' => 'Pendidikan formal wajib dipilih',
                'pendidikan.exists' => 'Pendidikan formal tidak valid',
                'pendidikan_non.in' => 'Pendidikan non formal tidak valid',
                'jns_pekerjaan.required' => 'Jenis pekerjaan wajib dipilih',
                'jns_pekerjaan.exists' => 'Jenis pekerjaan tidak valid',
                'pendapatan_perbulan.required' => 'Pendapatan perbulan wajib dipilih',
                'pendapatan_perbulan.in' => 'Pendapatan perbulan tidak valid',
                'sts_perkawinan.required' => 'Status perkawinan wajib dipilih',
                'sts_perkawinan.in' => 'Status perkawinan tidak valid',
                'status_kawin_tercatat.required' => 'Status kawin tercatat wajib dipilih',
                'status_kawin_tercatat.in' => 'Status kawin tercatat tidak valid',
                'sts_kwn.required' => 'Kewarganegaraan wajib dipilih',
                'sts_kwn.exists' => 'Kewarganegaraan tidak valid',
                'kepemilikan_rumah.required' => 'Kepemilikan rumah wajib dipilih',
                'kepemilikan_rumah.in' => 'Kepemilikan rumah tidak valid',
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
                'nm_ibu.required' => 'Nama ibu kandung wajib diisi',
                'nm_ibu.max' => 'Nama ibu kandung maksimal 100 karakter',
                'nm_ayah.required' => 'Nama ayah kandung wajib diisi',
                'nm_ayah.max' => 'Nama ayah kandung maksimal 100 karakter',
            ]);

            // Mulai database transaction
            DB::beginTransaction();

            // ===================================================================
            // STEP 1: UPDATE DATA TABLE t_kartu_keluarga
            // ===================================================================
            $updateKK = DB::table('t_kartu_keluarga')
                ->where('id', $id)
                ->update([
                    'no_kk' => $validated['no_kk'],
                    'kp' => strtoupper($validated['kp']),
                    'rt' => $validated['rt'],
                    'rw' => $validated['rw'],
                    'kodepos' => $validated['kodepos'] ?? '0',
                    'desa' => $validated['desa'],
                    'kecamatan' => $validated['kecamatan'],
                    'kabkot' => $validated['kabkot'],
                    'provinsi' => $validated['provinsi'],
                    'updated_at' => now(),
                ]);

            if (!$updateKK) {
                throw new \Exception('Gagal mengupdate data Kartu Keluarga');
            }

            // ===================================================================
            // STEP 2: UPDATE DATA TABLE t_kartu_keluarga_anggota
            // ===================================================================
            $updateAnggota = DB::table('t_kartu_keluarga_anggota')
                ->where('id', $existingKepala->id)
                ->update([
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
                ]);

            if (!$updateAnggota) {
                throw new \Exception('Gagal mengupdate data Anggota Keluarga');
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('kependudukan.kartu.keluarga.index')
                ->with('success', 'Data Kartu Keluarga berhasil diupdate!');

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Error saat update Kartu Keluarga: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat mengupdate data: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $id = Crypt::decrypt($id);
        $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->leftJoin('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->leftJoin('indonesia_cities as t12', 't12.code', '=', 't2.kabkot')
                ->leftJoin('indonesia_provinces as t13', 't13.code', '=', 't2.provinsi')
                ->join('m_hubungan_keluarga as t6', 't6.id', '=', 't1.sts_hub_kel')
                ->join('m_agama as t7', 't7.id', '=', 't1.agama')
                ->join('m_pendidikan_keluarga as t8', 't8.id', '=', 't1.pendidikan')
                ->join('m_pekerjaan as t9', 't9.id', '=', 't1.jns_pekerjaan')
                ->join('m_gol_darah as t10', 't10.id', '=', 't1.gol_darah')
                ->join('m_jenis_kelamin as t11', 't11.id', '=', 't1.jenkel')
                ->where('t2.id', $id)
                ->where('t1.sts_mati', 0)
                ->select([
                    't2.id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    DB::raw('UPPER(t1.nama) as nama'),
                    't1.tgl_lahir as tgl_lahir',
                    DB::raw('UPPER(t1.tmpt_lahir) as tmpt_lahir'),
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't12.name as kabupaten',
                    't13.name as provinsi',
                    't1.id as anggota_id',
                    't6.nama as hubungan_keluarga',
                    't6.id as hubungan_id',
                    DB::raw('UPPER(t1.nm_ayah) as nm_ayah'),
                    DB::raw('UPPER(t1.nm_ibu) as nm_ibu'),
                    't11.nama as jenkel',
                    't7.nama as agama',
                    't8.nama as pendidikan',
                    't9.nama as pekerjaan',
                    't10.nama as golongan_darah',
                    't1.sts_kwn',
                    DB::raw("
                        CASE
                            WHEN UPPER(t1.sts_perkawinan) = 'KAWIN'
                                AND t1.status_kawin_tercatat = 'kawin_tercatat'
                                THEN 'KAWIN TERCATAT'
                            WHEN UPPER(t1.sts_perkawinan) = 'KAWIN'
                                AND t1.status_kawin_tercatat = 'kawin_tidak_tercatat'
                                THEN 'KAWIN TIDAK TERCATAT'
                            WHEN UPPER(t1.sts_perkawinan) = 'BELUM KAWIN'
                                THEN 'BELUM KAWIN'
                            ELSE UPPER(t1.sts_perkawinan)
                        END AS status_perkawinan
                    "),
                ])
                ->orderBy('t6.id')
                ->get();

        $kepalaKeluarga = $data->first();

        return view('admin.kependudukan.kartukeluarga.view', compact('data', 'kepalaKeluarga'));
    }

    // Tambahkan method baru untuk print
    public function print($id)
    {
        $data = DB::table('t_kartu_keluarga_anggota as t1')
                ->join('t_kartu_keluarga as t2', 't2.id', '=', 't1.no_kk')
                ->join('users as t3', 't3.id', '=', 't2.user_id')
                ->leftJoin('indonesia_districts as t4', 't4.code', '=', 't2.kecamatan')
                ->leftJoin('indonesia_villages as t5', 't5.code', '=', 't2.desa')
                ->leftJoin('indonesia_cities as t12', 't12.code', '=', 't2.kabkot')
                ->leftJoin('indonesia_provinces as t13', 't13.code', '=', 't2.provinsi')
                ->join('m_hubungan_keluarga as t6', 't6.id', '=', 't1.sts_hub_kel')
                ->join('m_agama as t7', 't7.id', '=', 't1.agama')
                ->join('m_pendidikan_keluarga as t8', 't8.id', '=', 't1.pendidikan')
                ->join('m_pekerjaan as t9', 't9.id', '=', 't1.jns_pekerjaan')
                ->join('m_gol_darah as t10', 't10.id', '=', 't1.gol_darah')
                ->join('m_jenis_kelamin as t11', 't11.id', '=', 't1.jenkel')
                ->join('m_kewarganegaraan as t14', 't14.id', '=', 't1.sts_kwn')
                ->where('t2.id', $id)
                ->where('t1.sts_mati', 0)
                ->select([
                    't2.id',
                    't2.no_kk as no_kk',
                    't1.no_nik as no_nik',
                    DB::raw('UPPER(t1.nama) as nama'),
                    't1.tgl_lahir as tgl_lahir',
                    DB::raw('UPPER(t1.tmpt_lahir) as tmpt_lahir'),
                    't2.kp',
                    't2.rt',
                    't2.rw',
                    't5.name as desa',
                    't4.name as kecamatan',
                    't12.name as kabupaten',
                    't13.name as provinsi',
                    't1.id as anggota_id',
                    't6.nama as hubungan_keluarga',
                    't6.id as hubungan_id',
                    DB::raw('UPPER(t1.nm_ayah) as nm_ayah'),
                    DB::raw('UPPER(t1.nm_ibu) as nm_ibu'),
                    't11.nama as jenkel',
                    't7.nama as agama',
                    't8.nama as pendidikan',
                    't9.nama as pekerjaan',
                    't10.nama as golongan_darah',
                    't14.nama as sts_kwn',
                    DB::raw("
                        CASE
                            WHEN UPPER(t1.sts_perkawinan) = 'KAWIN'
                                AND t1.status_kawin_tercatat = 'kawin_tercatat'
                                THEN 'KAWIN TERCATAT'
                            WHEN UPPER(t1.sts_perkawinan) = 'KAWIN'
                                AND t1.status_kawin_tercatat = 'kawin_tidak_tercatat'
                                THEN 'KAWIN TIDAK TERCATAT'
                            WHEN UPPER(t1.sts_perkawinan) = 'BELUM KAWIN'
                                THEN 'BELUM KAWIN'
                            ELSE UPPER(t1.sts_perkawinan)
                        END AS status_perkawinan
                    "),
                ])
                ->orderBy('t6.id')
                ->get();

        $kepalaKeluarga = $data->first();

        return view('admin.kependudukan.kartukeluarga.print', compact('data', 'kepalaKeluarga'));
    }

    /**
     * Soft delete kartu keluarga (pindah ke tabel backup)
     */
    public function delete($id)
    {
        try {
            // Decrypt ID yang dienkripsi
            // $id = Crypt::decrypt($id);
            // dd($id);
            // Mulai database transaction
            DB::beginTransaction();

            // ===================================================================
            // STEP 1: Ambil data Kartu Keluarga yang akan dihapus
            // ===================================================================
            $kartuKeluarga = DB::table('t_kartu_keluarga')
                ->where('id', $id)
                ->first();

            if (!$kartuKeluarga) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Kartu Keluarga tidak ditemukan!'
                ], 404);
            }

            // ===================================================================
            // STEP 2: Ambil semua anggota keluarga yang terkait dengan KK ini
            // ===================================================================
            $anggotaKeluarga = DB::table('t_kartu_keluarga_anggota')
                ->where('no_kk', $id)
                ->get();

            if ($anggotaKeluarga->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data Anggota Keluarga tidak ditemukan!'
                ], 404);
            }

            // ===================================================================
            // STEP 3: Backup data Kartu Keluarga ke tabel t_kartu_keluarga_delete
            // ===================================================================
            $dataKKBackup = [
                'original_id' => $kartuKeluarga->id,
                'no_kk' => $kartuKeluarga->no_kk,
                'kp' => $kartuKeluarga->kp,
                'rt' => $kartuKeluarga->rt,
                'rw' => $kartuKeluarga->rw,
                'kodepos' => $kartuKeluarga->kodepos,
                'desa' => $kartuKeluarga->desa,
                'kecamatan' => $kartuKeluarga->kecamatan,
                'kabkot' => $kartuKeluarga->kabkot,
                'provinsi' => $kartuKeluarga->provinsi,
                'user_id' => $kartuKeluarga->user_id,
                'deleted_by' => auth()->id(), // User yang menghapus
                'deleted_at' => now(), // Waktu penghapusan
                'created_at' => $kartuKeluarga->created_at,
                'updated_at' => $kartuKeluarga->updated_at,
            ];

            $insertBackupKK = DB::table('t_kartu_keluarga_delete')->insert($dataKKBackup);

            if (!$insertBackupKK) {
                throw new \Exception('Gagal backup data Kartu Keluarga');
            }

            // ===================================================================
            // STEP 4: Backup data Anggota Keluarga ke tabel t_kartu_keluarga_anggota_delete
            // ===================================================================
            foreach ($anggotaKeluarga as $anggota) {
                $dataAnggotaBackup = [
                    'original_id' => $anggota->id,
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
                    'jenis_umkm' => $anggota->jenis_umkm ?? null,
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
                    'sts_mati' => $anggota->sts_mati,
                    'user_id' => $anggota->user_id,
                    'deleted_by' => auth()->id(), // User yang menghapus
                    'deleted_at' => now(), // Waktu penghapusan
                    'created_at' => $anggota->created_at,
                    'updated_at' => $anggota->updated_at,
                ];

                $insertBackupAnggota = DB::table('t_kartu_keluarga_anggota_delete')->insert($dataAnggotaBackup);

                if (!$insertBackupAnggota) {
                    throw new \Exception('Gagal backup data Anggota Keluarga');
                }
            }

            // ===================================================================
            // STEP 5: Hapus data Anggota Keluarga dari tabel utama
            // ===================================================================
            $deleteAnggota = DB::table('t_kartu_keluarga_anggota')
                ->where('no_kk', $id)
                ->delete();

            if (!$deleteAnggota) {
                throw new \Exception('Gagal menghapus data Anggota Keluarga dari tabel utama');
            }

            // ===================================================================
            // STEP 6: Hapus data Kartu Keluarga dari tabel utama
            // ===================================================================
            $deleteKK = DB::table('t_kartu_keluarga')
                ->where('id', $id)
                ->delete();

            if (!$deleteKK) {
                throw new \Exception('Gagal menghapus data Kartu Keluarga dari tabel utama');
            }

            // Commit transaction jika semua berhasil
            DB::commit();

            // Log aktivitas penghapusan
            \Log::info('Data Kartu Keluarga berhasil dihapus', [
                'kk_id' => $id,
                'no_kk' => $kartuKeluarga->no_kk,
                'jumlah_anggota' => $anggotaKeluarga->count(),
                'deleted_by' => auth()->id(),
                'deleted_at' => now()
            ]);

            // Return success response untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Data Kartu Keluarga berhasil dihapus!'
            ], 200);

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Error saat menghapus Kartu Keluarga: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return error response untuk AJAX
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }

     /**
     * Menampilkan halaman data Kartu Keluarga yang sudah dihapus
     */
    public function trash()
    {
        return view('admin.kependudukan.kartukeluarga.trash');
    }

    /**
     * Data untuk DataTable trash (data yang sudah dihapus)
     */
    public function trashData()
    {
        try {
            // Ambil data dari tabel backup
            $data = DB::table('t_kartu_keluarga_delete as kk')
                ->join('t_kartu_keluarga_anggota_delete as anggota', function($join) {
                    $join->on('kk.original_id', '=', 'anggota.no_kk')
                         ->where('anggota.sts_hub_kel', '=', 1); // Kepala keluarga
                })
                ->select([
                    'kk.id',
                    'kk.original_id',
                    'kk.no_kk',
                    'anggota.no_nik',
                    'anggota.nama',
                    'anggota.tgl_lahir',
                    'anggota.tmpt_lahir',
                    DB::raw("CONCAT(kk.kp, ' RT ', kk.rt, ' RW ', kk.rw) as alamat"),
                    'kk.deleted_at',
                    'kk.deleted_by'
                ])
                ->orderBy('kk.deleted_at', 'desc');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('aksi', function($row) {
                    $btn = '<div class="btn-group" role="group">';

                    // Tombol Restore
                    $btn .= '<button onclick="restoreData('.$row->id.')"
                               class="btn btn-success btn-sm" title="Restore">
                               <i class="fas fa-undo"></i> Restore
                             </button>';

                    // Tombol Delete Permanent
                    $btn .= '<button onclick="deletePermanent('.$row->id.')"
                               class="btn btn-danger btn-sm" title="Hapus Permanen">
                               <i class="fas fa-trash-alt"></i> Hapus Permanen
                             </button>';

                    $btn .= '</div>';

                    return $btn;
                })
                ->editColumn('tgl_lahir', function($row) {
                    return $row->tgl_lahir ? date('d-m-Y', strtotime($row->tgl_lahir)) : '-';
                })
                ->editColumn('deleted_at', function($row) {
                    return $row->deleted_at ? date('d-m-Y H:i:s', strtotime($row->deleted_at)) : '-';
                })
                ->addColumn('deleted_by_name', function($row) {
                    if ($row->deleted_by) {
                        $user = DB::table('users')->where('id', $row->deleted_by)->first();
                        return $user ? $user->name : 'Unknown';
                    }
                    return '-';
                })
                ->rawColumns(['aksi'])
                ->make(true);

        } catch (\Exception $e) {
            \Log::error('Error saat load data trash: ' . $e->getMessage());

            return response()->json([
                'error' => 'Terjadi kesalahan saat memuat data'
            ], 500);
        }
    }

     /**
     * Restore data Kartu Keluarga dari tabel backup ke tabel utama
     */
    public function restore($id)
    {
        try {
            // Mulai database transaction
            DB::beginTransaction();

            // ===================================================================
            // STEP 1: Ambil data Kartu Keluarga dari tabel backup
            // ===================================================================
            $kartuKeluargaBackup = DB::table('t_kartu_keluarga_delete')
                ->where('id', $id)
                ->first();

            if (!$kartuKeluargaBackup) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data backup Kartu Keluarga tidak ditemukan!'
                ], 404);
            }

            // ===================================================================
            // STEP 2: Cek apakah NO_KK sudah ada di tabel utama
            // ===================================================================
            $existingKK = DB::table('t_kartu_keluarga')
                ->where('no_kk', $kartuKeluargaBackup->no_kk)
                ->first();

            if ($existingKK) {
                return response()->json([
                    'success' => false,
                    'message' => 'Nomor KK sudah terdaftar di database! Tidak dapat restore data duplikat.'
                ], 422);
            }

            // ===================================================================
            // STEP 3: Ambil semua anggota keluarga dari tabel backup
            // ===================================================================
            $anggotaKeluargaBackup = DB::table('t_kartu_keluarga_anggota_delete')
                ->where('no_kk', $kartuKeluargaBackup->original_id)
                ->get();

            if ($anggotaKeluargaBackup->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data backup Anggota Keluarga tidak ditemukan!'
                ], 404);
            }

            // ===================================================================
            // STEP 4: Restore data Kartu Keluarga ke tabel utama
            // ===================================================================
            $dataKKRestore = [
                'no_kk' => $kartuKeluargaBackup->no_kk,
                'kp' => $kartuKeluargaBackup->kp,
                'rt' => $kartuKeluargaBackup->rt,
                'rw' => $kartuKeluargaBackup->rw,
                'kodepos' => $kartuKeluargaBackup->kodepos,
                'desa' => $kartuKeluargaBackup->desa,
                'kecamatan' => $kartuKeluargaBackup->kecamatan,
                'kabkot' => $kartuKeluargaBackup->kabkot,
                'provinsi' => $kartuKeluargaBackup->provinsi,
                'user_id' => $kartuKeluargaBackup->user_id,
                'sts' => 1, // Set status aktif
                'created_at' => $kartuKeluargaBackup->created_at,
                'updated_at' => now(), // Update timestamp
            ];

            // Insert dan dapatkan ID baru
            $newKKId = DB::table('t_kartu_keluarga')->insertGetId($dataKKRestore);

            if (!$newKKId) {
                throw new \Exception('Gagal restore data Kartu Keluarga');
            }

            // ===================================================================
            // STEP 5: Restore data Anggota Keluarga ke tabel utama
            // ===================================================================
            foreach ($anggotaKeluargaBackup as $anggota) {
                // Cek apakah NIK sudah ada di tabel utama
                $existingNIK = DB::table('t_kartu_keluarga_anggota')
                    ->where('no_nik', $anggota->no_nik)
                    ->first();

                if ($existingNIK) {
                    // Rollback dan beri tahu user
                    throw new \Exception('NIK ' . $anggota->no_nik . ' sudah terdaftar! Tidak dapat restore.');
                }

                $dataAnggotaRestore = [
                    'no_kk' => $newKKId, // Gunakan ID baru dari tabel t_kartu_keluarga
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
                    'sts_mati' => $anggota->sts_mati,
                    'user_id' => $anggota->user_id,
                    'sts' => 1, // Set status aktif
                    'created_at' => $anggota->created_at,
                    'updated_at' => now(),
                ];

                $insertAnggota = DB::table('t_kartu_keluarga_anggota')->insert($dataAnggotaRestore);

                if (!$insertAnggota) {
                    throw new \Exception('Gagal restore data Anggota Keluarga');
                }
            }

            // ===================================================================
            // STEP 6: Hapus data dari tabel backup setelah berhasil restore
            // ===================================================================
            DB::table('t_kartu_keluarga_anggota_delete')
                ->where('no_kk', $kartuKeluargaBackup->original_id)
                ->delete();

            DB::table('t_kartu_keluarga_delete')
                ->where('id', $id)
                ->delete();

            // Commit transaction jika semua berhasil
            DB::commit();

            // Log aktivitas restore
            \Log::info('Data Kartu Keluarga berhasil di-restore', [
                'backup_id' => $id,
                'new_kk_id' => $newKKId,
                'no_kk' => $kartuKeluargaBackup->no_kk,
                'jumlah_anggota' => $anggotaKeluargaBackup->count(),
                'restored_by' => auth()->id(),
                'restored_at' => now()
            ]);

            // Return success response untuk AJAX
            return response()->json([
                'success' => true,
                'message' => 'Data Kartu Keluarga berhasil di-restore!'
            ], 200);

        } catch (\Exception $e) {
            // Rollback transaction jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            \Log::error('Error saat restore Kartu Keluarga: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());

            // Return error response untuk AJAX
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat restore data: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Hapus permanen data dari tabel backup
     */
    public function deletePermanent($id)
    {
        try {
            // Mulai database transaction
            DB::beginTransaction();

            // Ambil data backup untuk logging
            $kartuKeluargaBackup = DB::table('t_kartu_keluarga_delete')
                ->where('id', $id)
                ->first();

            if (!$kartuKeluargaBackup) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data backup tidak ditemukan!'
                ], 404);
            }

            // Hapus anggota keluarga dari backup
            $deleteAnggota = DB::table('t_kartu_keluarga_anggota_delete')
                ->where('no_kk', $kartuKeluargaBackup->original_id)
                ->delete();

            // Hapus kartu keluarga dari backup
            $deleteKK = DB::table('t_kartu_keluarga_delete')
                ->where('id', $id)
                ->delete();

            if (!$deleteKK) {
                throw new \Exception('Gagal menghapus data backup');
            }

            // Commit transaction
            DB::commit();

            // Log aktivitas
            \Log::warning('Data Kartu Keluarga dihapus PERMANEN', [
                'backup_id' => $id,
                'no_kk' => $kartuKeluargaBackup->no_kk,
                'deleted_permanently_by' => auth()->id(),
                'deleted_permanently_at' => now()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus permanen!'
            ], 200);

        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('Error saat hapus permanen: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }
}