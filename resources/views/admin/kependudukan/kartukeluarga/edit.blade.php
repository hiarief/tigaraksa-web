@extends('admin.layout.main')
@section('title', 'Edit Data Kartu Keluarga')
@section('content')

<div class="row">
    <div class="col-md-12">
        <div class="card card-dark card-outline">
            <div class="card-header">
                <h3 class="card-title">Form Edit Kartu Keluarga</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('kependudukan.kartu.keluarga.update', Crypt::encrypt($kartuKeluarga->id)) }}" method="POST"
                      enctype="multipart/form-data" autocomplete="off" id="formKK">
                    @csrf
                    @method('PUT')

                    {{-- SECTION: NOMOR KARTU KELUARGA --}}
                    <div class="bg-gradient-dark mb-3 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-id-card mr-2"></i>NOMOR KARTU KELUARGA</h6>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_kk">No Kartu Keluarga (NKK) <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="no_kk"
                                       id="no_kk"
                                       value="{{ old('no_kk', $kartuKeluarga->no_kk) }}"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       inputmode="numeric"
                                       class="form-control form-control-sm @error('no_kk') is-invalid @enderror"
                                       placeholder="Masukkan 16 digit NKK"
                                       title="NKK harus 16 digit angka"
                                       oninvalid="this.setCustomValidity('NKK harus diisi dengan 16 digit angka')"
                                       oninput="this.setCustomValidity('')"
                                       required>
                                <small id="nkkFeedback" class="form-text text-muted"></small>
                                @error('no_kk')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: ALAMAT KARTU KELUARGA --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-map-marker-alt mr-2"></i>ALAMAT KARTU KELUARGA</h6>
                    </div>

                    <div class="row">
                        {{-- Provinsi --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="provinsi_display">Provinsi <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="provinsi_display"
                                       class="form-control form-control-sm text-uppercase"
                                       value="BANTEN"
                                       disabled>
                                <input type="hidden" name="provinsi" value="36">
                            </div>
                        </div>

                        {{-- Kabupaten/Kota --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kabkot_display">Kabupaten / Kota <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="kabkot_display"
                                       class="form-control form-control-sm text-uppercase"
                                       value="KABUPATEN TANGERANG"
                                       disabled>
                                <input type="hidden" name="kabkot" value="3603">
                            </div>
                        </div>

                        {{-- Kecamatan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kecamatan_display">Kecamatan <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="kecamatan_display"
                                       class="form-control form-control-sm text-uppercase"
                                       value="TIGARAKSA"
                                       disabled>
                                <input type="hidden" name="kecamatan" value="360303">
                            </div>
                        </div>

                        {{-- Desa --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="desa_display">Desa <span class="text-danger">*</span></label>
                                <input type="text"
                                       id="desa_display"
                                       class="form-control form-control-sm text-uppercase"
                                       value="{{ auth()->user()->namadesa }}"
                                       disabled>
                                <input type="hidden" name="desa" value="{{ auth()->user()->desa }}">
                            </div>
                        </div>

                        {{-- Alamat/Kampung --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kp">Alamat / Kampung <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="kp"
                                       id="kp"
                                       value="{{ old('kp', $kartuKeluarga->kp) }}"
                                       class="form-control form-control-sm text-uppercase @error('kp') is-invalid @enderror"
                                       placeholder="Contoh: KP. BOJONG"
                                       required>
                                @error('kp')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- RT --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rt">RT <span class="text-danger">*</span></label>
                                <select name="rt"
                                        id="rt"
                                        class="form-control form-control-sm @error('rt') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih RT</option>
                                    @foreach ($rtList as $rt)
                                        <option value="{{ $rt }}" {{ old('rt', $kartuKeluarga->rt) == $rt ? 'selected' : '' }}>
                                            {{ $rt }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rt')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- RW --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="rw">RW <span class="text-danger">*</span></label>
                                <select name="rw"
                                        id="rw"
                                        class="form-control form-control-sm @error('rw') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih RW</option>
                                    @foreach ($rwList as $rw)
                                        <option value="{{ $rw }}" {{ old('rw', $kartuKeluarga->rw) == $rw ? 'selected' : '' }}>
                                            {{ $rw }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('rw')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Kode Pos (Hidden) --}}
                        <input type="hidden" name="kodepos" value="0">
                    </div>

                    {{-- SECTION: IDENTITAS KEPALA KELUARGA --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-user-tie mr-2"></i>IDENTITAS KEPALA KELUARGA</h6>
                    </div>

                    <div class="row">
                        {{-- NIK --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="no_nik">No Induk Kependudukan (NIK) <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="no_nik"
                                       id="no_nik"
                                       value="{{ old('no_nik', $kepalaKeluarga->no_nik) }}"
                                       maxlength="16"
                                       pattern="[0-9]{16}"
                                       inputmode="numeric"
                                       class="form-control form-control-sm @error('no_nik') is-invalid @enderror"
                                       placeholder="Masukkan 16 digit NIK"
                                       title="NIK harus 16 digit angka"
                                       oninvalid="this.setCustomValidity('NIK harus diisi dengan 16 digit angka')"
                                       oninput="this.setCustomValidity('')"
                                       required>
                                <small id="nikFeedback" class="form-text text-muted"></small>
                                @error('no_nik')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama Lengkap --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nama">Nama Lengkap <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nama"
                                       id="nama"
                                       value="{{ old('nama', $kepalaKeluarga->nama) }}"
                                       class="form-control form-control-sm text-uppercase @error('nama') is-invalid @enderror"
                                       placeholder="Masukkan nama lengkap"
                                       required>
                                @error('nama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Jenis Kelamin --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="jenkel">Jenis Kelamin <span class="text-danger">*</span></label>
                                <select name="jenkel"
                                        id="jenkel"
                                        class="form-control form-control-sm select2 @error('jenkel') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Jenis Kelamin</option>
                                    @foreach ($jenisKelamin as $id => $nama)
                                        <option value="{{ $id }}" {{ old('jenkel', $kepalaKeluarga->jenkel) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jenkel')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Tempat Lahir --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tmpt_lahir">Tempat Lahir <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="tmpt_lahir"
                                       id="tmpt_lahir"
                                       value="{{ old('tmpt_lahir', $kepalaKeluarga->tmpt_lahir) }}"
                                       class="form-control form-control-sm text-uppercase @error('tmpt_lahir') is-invalid @enderror"
                                       placeholder="Contoh: TANGERANG"
                                       required>
                                @error('tmpt_lahir')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Tanggal Lahir --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                <input type="date"
                                       name="tgl_lahir"
                                       id="tgl_lahir"
                                       value="{{ old('tgl_lahir', $kepalaKeluarga->tgl_lahir) }}"
                                       class="form-control form-control-sm @error('tgl_lahir') is-invalid @enderror"
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('tgl_lahir')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Agama --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="agama">Agama <span class="text-danger">*</span></label>
                                <select name="agama"
                                        id="agama"
                                        class="form-control form-control-sm select2 @error('agama') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Agama</option>
                                    @foreach ($agama as $id => $nama)
                                        <option value="{{ $id }}" {{ old('agama', $kepalaKeluarga->agama) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('agama')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Golongan Darah --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="gol_darah">Golongan Darah <span class="text-danger">*</span></label>
                                <select name="gol_darah"
                                        id="gol_darah"
                                        class="form-control form-control-sm select2 @error('gol_darah') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Golongan Darah</option>
                                    @foreach ($golDarah as $id => $nama)
                                        <option value="{{ $id }}" {{ old('gol_darah', $kepalaKeluarga->gol_darah) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('gol_darah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: PENDIDIKAN --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-graduation-cap mr-2"></i>PENDIDIKAN</h6>
                    </div>

                    <div class="row">
                        {{-- Pendidikan Formal --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pendidikan">Pendidikan Formal <span class="text-danger">*</span></label>
                                <select name="pendidikan"
                                        id="pendidikan"
                                        class="form-control form-control-sm select2 @error('pendidikan') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Pendidikan Formal</option>
                                    @foreach ($pendidikanKeluarga as $id => $nama)
                                        <option value="{{ $id }}" {{ old('pendidikan', $kepalaKeluarga->pendidikan) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('pendidikan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Pendidikan Non Formal --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pendidikan_non">Pendidikan Non Formal</label>
                                <select name="pendidikan_non"
                                        id="pendidikan_non"
                                        class="form-control form-control-sm select2 @error('pendidikan_non') is-invalid @enderror">
                                    <option value="" hidden>Pilih Pendidikan Non Formal</option>
                                    <option value="Pesantren Salafiah" {{ old('pendidikan_non', $kepalaKeluarga->pendidikan_non) == 'Pesantren Salafiah' ? 'selected' : '' }}>Pesantren Salafiah</option>
                                    <option value="Pendidikan keagamaan Lainnya" {{ old('pendidikan_non', $kepalaKeluarga->pendidikan_non) == 'Pendidikan keagamaan Lainnya' ? 'selected' : '' }}>Pendidikan Keagamaan Lainnya</option>
                                    <option value="Pendidikan Lainnya" {{ old('pendidikan_non', $kepalaKeluarga->pendidikan_non) == 'Pendidikan Lainnya' ? 'selected' : '' }}>Pendidikan Lainnya</option>
                                    <option value="Tidak Ada" {{ old('pendidikan_non', $kepalaKeluarga->pendidikan_non) == 'Tidak Ada' ? 'selected' : '' }}>Tidak Ada</option>
                                </select>
                                @error('pendidikan_non')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: PEKERJAAN & PENDAPATAN --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-briefcase mr-2"></i>PEKERJAAN & PENDAPATAN</h6>
                    </div>

                    <div class="row">
                        {{-- Jenis Pekerjaan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="jns_pekerjaan">Jenis Pekerjaan <span class="text-danger">*</span></label>
                                <select name="jns_pekerjaan"
                                        id="jns_pekerjaan"
                                        class="form-control form-control-sm select2 @error('jns_pekerjaan') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Jenis Pekerjaan</option>
                                    @foreach ($pekerjaan as $id => $nama)
                                        <option value="{{ $id }}" {{ old('jns_pekerjaan', $kepalaKeluarga->jns_pekerjaan) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('jns_pekerjaan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Pendapatan Perbulan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="pendapatan_perbulan">Pendapatan Perbulan <span class="text-danger">*</span></label>
                                <select name="pendapatan_perbulan"
                                        id="pendapatan_perbulan"
                                        class="form-control form-control-sm select2 @error('pendapatan_perbulan') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Pendapatan Perbulan</option>
                                    <option value="0-1 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '0-1 Juta' ? 'selected' : '' }}>0 - 1 Juta</option>
                                    <option value="1-2 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '1-2 Juta' ? 'selected' : '' }}>1 Juta - 2 Juta</option>
                                    <option value="2-3 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '2-3 Juta' ? 'selected' : '' }}>2 Juta - 3 Juta</option>
                                    <option value="3-5 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '3-5 Juta' ? 'selected' : '' }}>3 Juta - 5 Juta</option>
                                    <option value="5-10 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '5-10 Juta' ? 'selected' : '' }}>5 Juta - 10 Juta</option>
                                    <option value="10-20 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '10-20 Juta' ? 'selected' : '' }}>10 Juta - 20 Juta</option>
                                    <option value="20-50 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '20-50 Juta' ? 'selected' : '' }}>20 Juta - 50 Juta</option>
                                    <option value="50-100 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '50-100 Juta' ? 'selected' : '' }}>50 Juta - 100 Juta</option>
                                    <option value=">100 Juta" {{ old('pendapatan_perbulan', $kepalaKeluarga->pendapatan_perbulan) == '>100 Juta' ? 'selected' : '' }}>Lebih dari 100 Juta</option>
                                </select>
                                @error('pendapatan_perbulan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: STATUS PERKAWINAN --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-ring mr-2"></i>STATUS PERKAWINAN & HUBUNGAN KELUARGA</h6>
                    </div>

                    <div class="row">
                        {{-- Status Perkawinan --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sts_perkawinan">Status Perkawinan <span class="text-danger">*</span></label>
                                <select name="sts_perkawinan"
                                        id="sts_perkawinan"
                                        class="form-control form-control-sm @error('sts_perkawinan') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Status Perkawinan</option>
                                    <option value="BELUM KAWIN" {{ old('sts_perkawinan', $kepalaKeluarga->sts_perkawinan) == 'BELUM KAWIN' ? 'selected' : '' }}>BELUM KAWIN</option>
                                    <option value="KAWIN" {{ old('sts_perkawinan', $kepalaKeluarga->sts_perkawinan) == 'KAWIN' ? 'selected' : '' }}>KAWIN</option>
                                    <option value="CERAI HIDUP" {{ old('sts_perkawinan', $kepalaKeluarga->sts_perkawinan) == 'CERAI HIDUP' ? 'selected' : '' }}>CERAI HIDUP</option>
                                    <option value="CERAI MATI" {{ old('sts_perkawinan', $kepalaKeluarga->sts_perkawinan) == 'CERAI MATI' ? 'selected' : '' }}>CERAI MATI</option>
                                </select>
                                @error('sts_perkawinan')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Status Kawin Tercatat --}}
                        <div class="col-md-4" id="kawin_tercatat_container" style="display: none;">
                            <div class="form-group">
                                <label for="status_kawin_tercatat">Status Kawin Tercatat</label>
                                <select name="status_kawin_tercatat"
                                        id="status_kawin_tercatat"
                                        class="form-control form-control-sm select2 @error('status_kawin_tercatat') is-invalid @enderror">
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="kawin_tercatat" {{ old('status_kawin_tercatat', $kepalaKeluarga->status_kawin_tercatat) == 'kawin_tercatat' ? 'selected' : '' }}>Kawin Tercatat</option>
                                    <option value="kawin_tidak_tercatat" {{ old('status_kawin_tercatat', $kepalaKeluarga->status_kawin_tercatat) == 'kawin_tidak_tercatat' ? 'selected' : '' }}>Kawin Tidak Tercatat</option>
                                </select>
                                @error('status_kawin_tercatat')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Hubungan Dalam Keluarga --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sts_hub_kel">Hubungan Dalam Keluarga <span class="text-danger">*</span></label>
                                <select name="sts_hub_kel"
                                        id="sts_hub_kel"
                                        class="form-control form-control-sm @error('sts_hub_kel') is-invalid @enderror"
                                        readonly>
                                    <option value="1" selected>KEPALA KELUARGA</option>
                                </select>
                                @error('sts_hub_kel')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: KEWARGANEGARAAN --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-flag mr-2"></i>KEWARGANEGARAAN</h6>
                    </div>

                    <div class="row">
                        {{-- Kewarganegaraan --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="sts_kwn">Kewarganegaraan <span class="text-danger">*</span></label>
                                <select name="sts_kwn"
                                        id="sts_kwn"
                                        class="form-control form-control-sm select2 @error('sts_kwn') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Kewarganegaraan</option>
                                    @foreach ($kewarganegaraan as $id => $nama)
                                        <option value="{{ $id }}" {{ old('sts_kwn', $kepalaKeluarga->sts_kwn) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sts_kwn')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Kepemilikan Rumah --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kepemilikan_rumah">Kepemilikan Rumah <span class="text-danger">*</span></label>
                                <select name="kepemilikan_rumah"
                                        id="kepemilikan_rumah"
                                        class="form-control form-control-sm select2 @error('kepemilikan_rumah') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Kepemilikan Rumah</option>
                                    <option value="Milik Sendiri" {{ old('kepemilikan_rumah', $kepalaKeluarga->kepemilikan_rumah) == 'Milik Sendiri' ? 'selected' : '' }}>Milik Sendiri</option>
                                    <option value="Orang Tua" {{ old('kepemilikan_rumah', $kepalaKeluarga->kepemilikan_rumah) == 'Orang Tua' ? 'selected' : '' }}>Orang Tua</option>
                                    <option value="Ngontrak" {{ old('kepemilikan_rumah', $kepalaKeluarga->kepemilikan_rumah) == 'Ngontrak' ? 'selected' : '' }}>Ngontrak</option>
                                    <option value="Lainnya" {{ old('kepemilikan_rumah', $kepalaKeluarga->kepemilikan_rumah) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                </select>
                                @error('kepemilikan_rumah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: BANTUAN & KESEHATAN --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-hand-holding-medical mr-2"></i>BANTUAN PEMERINTAH & KESEHATAN</h6>
                    </div>

                    <div class="row">
                        {{-- Bantuan Pemerintah --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="tanya_bantuanpemerintah">Kelayakan Bantuan Pemerintah <span class="text-danger">*</span></label>
                                <select name="tanya_bantuanpemerintah"
                                        id="tanya_bantuanpemerintah"
                                        class="form-control form-control-sm @error('tanya_bantuanpemerintah') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="Tidak Layak" {{ old('tanya_bantuanpemerintah', $kepalaKeluarga->tanya_bantuanpemerintah) == 'Tidak Layak' ? 'selected' : '' }}>Tidak Layak</option>
                                    <option value="Layak" {{ old('tanya_bantuanpemerintah', $kepalaKeluarga->tanya_bantuanpemerintah) == 'Layak' ? 'selected' : '' }}>Layak</option>
                                </select>
                                @error('tanya_bantuanpemerintah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Jenis Bantuan Pemerintah --}}
                        <div class="col-md-4" id="wrapper_bantuan_pemerintah" style="display: none;">
                            <div class="form-group">
                                <label for="bantuan_pemerintah">Jenis Bantuan Pemerintah</label>
                                <select name="bantuan_pemerintah"
                                        id="bantuan_pemerintah"
                                        class="form-control form-control-sm select2 @error('bantuan_pemerintah') is-invalid @enderror">
                                    <option value="" hidden>Pilih Jenis Bantuan</option>
                                    @foreach ($bantuanPemerintah as $id => $nama)
                                        <option value="{{ $id }}" {{ old('bantuan_pemerintah', $kepalaKeluarga->bantuan_pemerintah) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('bantuan_pemerintah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Sakit Kronis --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="sakitkronis">Menderita Sakit Kronis <span class="text-danger">*</span></label>
                                <select name="sakitkronis"
                                        id="sakitkronis"
                                        class="form-control form-control-sm select2 @error('sakitkronis') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Status</option>
                                    @foreach ($kronis as $id => $nama)
                                        <option value="{{ $id }}" {{ old('sakitkronis', $kepalaKeluarga->sakitkronis) == $id ? 'selected' : '' }}>
                                            {{ $nama }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('sakitkronis')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- BPJS --}}
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="punya_bpjs">Kepemilikan BPJS <span class="text-danger">*</span></label>
                                <select name="punya_bpjs"
                                        id="punya_bpjs"
                                        class="form-control form-control-sm @error('punya_bpjs') is-invalid @enderror"
                                        required>
                                    <option value="" hidden>Pilih Status</option>
                                    <option value="tidak" {{ old('punya_bpjs', $kepalaKeluarga->punya_bpjs) == 'tidak' ? 'selected' : '' }}>Tidak</option>
                                    <option value="ya" {{ old('punya_bpjs', $kepalaKeluarga->punya_bpjs) == 'ya' ? 'selected' : '' }}>Ya</option>
                                </select>
                                @error('punya_bpjs')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Jenis BPJS --}}
                        <div class="col-md-4" id="jenis_bpjs_container" style="display: none;">
                            <div class="form-group">
                                <label for="jenis_bpjs">Jenis BPJS</label>
                                <select name="jenis_bpjs"
                                        id="jenis_bpjs"
                                        class="form-control form-control-sm @error('jenis_bpjs') is-invalid @enderror">
                                    <option value="" hidden>Pilih Jenis BPJS</option>
                                    <option value="bpjs_kesehatan" {{ old('jenis_bpjs', $kepalaKeluarga->jenis_bpjs) == 'bpjs_kesehatan' ? 'selected' : '' }}>BPJS Kesehatan</option>
                                    <option value="bpjs_ketenagakerjaan" {{ old('jenis_bpjs', $kepalaKeluarga->jenis_bpjs) == 'bpjs_ketenagakerjaan' ? 'selected' : '' }}>BPJS Ketenagakerjaan</option>
                                    <option value="memiliki_kedua_bpjs" {{ old('jenis_bpjs', $kepalaKeluarga->jenis_bpjs) == 'memiliki_kedua_bpjs' ? 'selected' : '' }}>Memiliki Kedua BPJS</option>
                                </select>
                                @error('jenis_bpjs')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Pembayaran BPJS --}}
                        <div class="col-md-4" id="pembayaran_bpjs_container" style="display: none;">
                            <div class="form-group">
                                <label for="pembayaran_bpjs">Pembayaran BPJS</label>
                                <select name="pembayaran_bpjs"
                                        id="pembayaran_bpjs"
                                        class="form-control form-control-sm @error('pembayaran_bpjs') is-invalid @enderror">
                                    <option value="" hidden>Pilih Cara Pembayaran</option>
                                    <option value="mandiri" {{ old('pembayaran_bpjs', $kepalaKeluarga->pembayaran_bpjs) == 'mandiri' ? 'selected' : '' }}>Mandiri</option>
                                    <option value="pemerintah" {{ old('pembayaran_bpjs', $kepalaKeluarga->pembayaran_bpjs) == 'pemerintah' ? 'selected' : '' }}>Pemerintah / Perusahaan</option>
                                </select>
                                @error('pembayaran_bpjs')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- SECTION: ORANG TUA --}}
                    <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                        <h6 class="mb-0 text-white"><i class="fas fa-users mr-2"></i>DATA ORANG TUA</h6>
                    </div>

                    <div class="row">
                        {{-- Nama Ibu --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nm_ibu">Nama Ibu Kandung <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nm_ibu"
                                       id="nm_ibu"
                                       value="{{ old('nm_ibu', $kepalaKeluarga->nm_ibu) }}"
                                       class="form-control form-control-sm text-uppercase @error('nm_ibu') is-invalid @enderror"
                                       placeholder="Masukkan nama ibu kandung"
                                       required>
                                @error('nm_ibu')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        {{-- Nama Ayah --}}
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nm_ayah">Nama Ayah Kandung <span class="text-danger">*</span></label>
                                <input type="text"
                                       name="nm_ayah"
                                       id="nm_ayah"
                                       value="{{ old('nm_ayah', $kepalaKeluarga->nm_ayah) }}"
                                       class="form-control form-control-sm text-uppercase @error('nm_ayah') is-invalid @enderror"
                                       placeholder="Masukkan nama ayah kandung"
                                       required>
                                @error('nm_ayah')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </form>
            </div>

            <div class="card-footer text-center">
                <a href="{{ route('kependudukan.kartu.keluarga.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fas fa-times mr-1"></i> Batal
                </a>
                <button type="submit" form="formKK" class="btn btn-primary btn-sm">
                    <i class="fas fa-save mr-1"></i> Update Data
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    /* Styling untuk form yang lebih baik */
    .form-group label {
        font-weight: 500;
        margin-bottom: 0.3rem;
    }

    .text-danger {
        font-weight: bold;
    }

    .bg-gradient-dark {
        background: linear-gradient(90deg, #343a40 0%, #23272b 100%);
    }
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {

    // ============================================================
    // CUSTOM VALIDATION MESSAGES (Bahasa Indonesia)
    // Mengubah semua pesan validasi HTML5 ke bahasa Indonesia
    // ============================================================
    const customValidationMessages = {
        // Pesan untuk input yang wajib diisi
        valueMissing: function(element) {
            const fieldName = $(element).prev('label').text().replace(' *', '');
            return `${fieldName} wajib diisi`;
        },

        // Pesan untuk pattern yang tidak sesuai
        patternMismatch: function(element) {
            const title = element.getAttribute('title');
            if (title) return title;
            return 'Format input tidak sesuai';
        },

        // Pesan untuk type mismatch
        typeMismatch: function(element) {
            const type = element.type;
            if (type === 'email') return 'Format email tidak valid';
            if (type === 'url') return 'Format URL tidak valid';
            if (type === 'date') return 'Format tanggal tidak valid';
            return 'Format input tidak sesuai';
        },

        // Pesan untuk nilai terlalu panjang
        tooLong: function(element) {
            return `Input terlalu panjang (maksimal ${element.maxLength} karakter)`;
        },

        // Pesan untuk nilai terlalu pendek
        tooShort: function(element) {
            return `Input terlalu pendek (minimal ${element.minLength} karakter)`;
        }
    };

    // Fungsi untuk set custom validation message
    function setCustomValidation(element) {
        const validity = element.validity;

        if (validity.valueMissing) {
            element.setCustomValidity(customValidationMessages.valueMissing(element));
        } else if (validity.patternMismatch) {
            element.setCustomValidity(customValidationMessages.patternMismatch(element));
        } else if (validity.typeMismatch) {
            element.setCustomValidity(customValidationMessages.typeMismatch(element));
        } else if (validity.tooLong) {
            element.setCustomValidity(customValidationMessages.tooLong(element));
        } else if (validity.tooShort) {
            element.setCustomValidity(customValidationMessages.tooShort(element));
        } else {
            element.setCustomValidity('');
        }
    }

    // Apply custom validation ke semua input, select, dan textarea
    $('input, select, textarea').each(function() {
        $(this).on('invalid', function() {
            setCustomValidation(this);
        });

        $(this).on('input change', function() {
            this.setCustomValidity('');
        });
    });

    // ============================================================
    // VALIDASI NIK: Harus 16 digit angka
    // ============================================================
    $('#no_nik').on('input', function() {
        let nik = $(this).val();
        let feedback = $('#nikFeedback');

        if (nik.length === 16 && /^\d{16}$/.test(nik)) {
            feedback.text('✓ NIK valid').removeClass('text-danger').addClass('text-success');
            this.setCustomValidity('');
        } else if (nik.length > 0) {
            feedback.text('NIK harus 16 digit angka').removeClass('text-success').addClass('text-danger');
        } else {
            feedback.text('');
        }
    });

    // ============================================================
    // VALIDASI NKK: Harus 16 digit angka
    // ============================================================
    $('#no_kk').on('input', function() {
        let nkk = $(this).val();
        let feedback = $('#nkkFeedback');

        if (nkk.length === 16 && /^\d{16}$/.test(nkk)) {
            feedback.text('✓ NKK valid').removeClass('text-danger').addClass('text-success');
            this.setCustomValidity('');
        } else if (nkk.length > 0) {
            feedback.text('NKK harus 16 digit angka').removeClass('text-success').addClass('text-danger');
        } else {
            feedback.text('');
        }
    });

    // ============================================================
    // SHOW/HIDE: Status Kawin Tercatat
    // Muncul hanya jika status perkawinan = KAWIN
    // ============================================================
    $('#sts_perkawinan').on('change', function() {
        if ($(this).val() === 'KAWIN') {
            $('#kawin_tercatat_container').slideDown();
        } else {
            $('#kawin_tercatat_container').slideUp();
            $('#status_kawin_tercatat').val('');
        }
    });

    // Trigger saat halaman load untuk mempertahankan state
    if ($('#sts_perkawinan').val() === 'KAWIN') {
        $('#kawin_tercatat_container').show();
    }

    // ============================================================
    // SHOW/HIDE: Jenis Bantuan Pemerintah
    // Muncul hanya jika kelayakan bantuan = Layak
    // ============================================================
    $('#tanya_bantuanpemerintah').on('change', function() {
        if ($(this).val() === 'Layak') {
            $('#wrapper_bantuan_pemerintah').slideDown();
        } else {
            $('#wrapper_bantuan_pemerintah').slideUp();
            $('#bantuan_pemerintah').val('');
        }
    });

    // Trigger saat halaman load
    if ($('#tanya_bantuanpemerintah').val() === 'Layak') {
        $('#wrapper_bantuan_pemerintah').show();
    }

    // ============================================================
    // SHOW/HIDE: Jenis BPJS & Pembayaran BPJS
    // Muncul hanya jika punya BPJS = ya
    // ============================================================
    $('#punya_bpjs').on('change', function() {
        if ($(this).val() === 'ya') {
            $('#jenis_bpjs_container').slideDown();
            $('#pembayaran_bpjs_container').slideDown();
        } else {
            $('#jenis_bpjs_container').slideUp();
            $('#pembayaran_bpjs_container').slideUp();
            $('#jenis_bpjs').val('');
            $('#pembayaran_bpjs').val('');
        }
    });

    // Trigger saat halaman load
    if ($('#punya_bpjs').val() === 'ya') {
        $('#jenis_bpjs_container').show();
        $('#pembayaran_bpjs_container').show();
    }

    // ============================================================
    // VALIDASI FORM: Cek sebelum submit
    // ============================================================
    $('#formKK').on('submit', function(e) {
        let nik = $('#no_nik').val();
        let nkk = $('#no_kk').val();

        // Validasi NIK
        if (nik.length !== 16 || !/^\d{16}$/.test(nik)) {
            e.preventDefault();
            alert('NIK harus berisi 16 digit angka!');
            $('#no_nik').focus();
            return false;
        }

        // Validasi NKK
        if (nkk.length !== 16 || !/^\d{16}$/.test(nkk)) {
            e.preventDefault();
            alert('Nomor Kartu Keluarga harus berisi 16 digit angka!');
            $('#no_kk').focus();
            return false;
        }

        return true;
    });

    // ============================================================
    // INITIALIZE: Select2 untuk dropdown yang lebih baik
    // ============================================================
    $('.select2').select2({
        theme: 'bootstrap4',
        width: '100%',
        language: {
            noResults: function() {
                return "Tidak ada hasil ditemukan";
            },
            searching: function() {
                return "Mencari...";
            },
            inputTooShort: function(args) {
                return "Masukkan " + (args.minimum - args.input.length) + " karakter lagi";
            },
            loadingMore: function() {
                return "Memuat lebih banyak hasil...";
            }
        }
    });

});
</script>
@endpush
