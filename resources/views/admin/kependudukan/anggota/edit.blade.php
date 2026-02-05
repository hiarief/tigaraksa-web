@extends('admin.layout.main')
@section('title', 'Edit Data Anggota Keluarga')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Form Edit Anggota Keluarga</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('kependudukan.anggota.keluarga.update', Crypt::encrypt($anggota->id)) }}"
                        method="POST" enctype="multipart/form-data" autocomplete="off" id="formKK">
                        @csrf
                        @method('PUT')

                        <div class="bg-gradient-dark mb-3 rounded px-3 py-2">
                            <h6 class="mb-0 text-white"><i class="fas fa-id-card mr-2"></i>DATA KEPALA KELUARGA</h6>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="">No Kartu Keluarga</label>
                                    <div class="input-group input-group-sm">
                                        <input type="hidden" name="id_kk" id="id_kk"
                                            value="{{ old('id_kk', $anggota->kk_id) }}">
                                        <input type="text" name="nk" id="no_kk"
                                            value="{{ old('nk', $anggota->no_kk) }}"
                                            class="form-control form-control-sm text-sm" style="text-transform:uppercase"
                                            aria-describedby="button-addon2" readonly required>
                                        <button class="btn btn-outline-secondary btn-sm" style="text-transform:uppercase"
                                            type="button" id="button-addon2" data-toggle="modal"
                                            data-target="#modalFamillies"><i class="fas fa-search"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md">
                                <div class="fom-group">
                                    <label for="">Nama Kepala Keluarga</label>
                                    <input id="nama_kk" type="text" class="form-control form-control-sm text-sm"
                                        name="namakk" style="text-transform:uppercase" readonly>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                            <h6 class="mb-0 text-white"><i class="fas fa-map-marker-alt mr-2"></i>ALAMAT KARTU KELUARGA</h6>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Provinsi</label>
                                    <input type="text" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="provinsi"
                                        value="{{ old('provinsi', $anggota->provinsi) }}" id="provinsi" readonly required>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Kabupaten / Kota</label>
                                    <input type="text" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="kabupaten"
                                        value="{{ old('kabupaten', $anggota->kabkot) }}" id="kabkot" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Kecamatan</label>
                                    <input type="text" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="kecamatan"
                                        value="{{ old('kecamatan', $anggota->kecamatan) }}" id="kecamatan" readonly
                                        required>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <label for="">Desa</label>
                                    <input type="text" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="desa"
                                        value="{{ old('desa', $anggota->desa) }}" id="desa" readonly required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-0">
                                <div class="form-group">
                                    <label for="">Alamat / Kampung</label>
                                    <input type="text" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="kp"
                                        value="{{ old('kp', $anggota->kp) }}" id="kp" required readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="row">
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="">Rt</label>
                                            <input type="text" class="form-control form-control-sm text-sm"
                                                style="text-transform:uppercase" name="rt"
                                                value="{{ old('rt', $anggota->rt) }}" id="rt" readonly required>
                                        </div>
                                    </div>
                                    <div class="col-md">
                                        <div class="form-group">
                                            <label for="">Rw</label>
                                            <input type="text" class="form-control form-control-sm text-sm"
                                                style="text-transform:uppercase" name="rw"
                                                value="{{ old('rw', $anggota->rw) }}" id="rw" readonly required>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md">
                                <div class="form-group">
                                    <input type="hidden" class="form-control form-control-sm text-sm"
                                        style="text-transform:uppercase" name="kodepos"
                                        value="{{ old('kodepos', $anggota->kodepos) }}" id="kodepos" required readonly>
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: IDENTITAS ANGGOTA KELUARGA --}}
                        <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                            <h6 class="mb-0 text-white"><i class="fas fa-user-tie mr-2"></i>IDENTITAS ANGGOTA KELUARGA
                            </h6>
                        </div>

                        <div class="row">
                            {{-- NIK --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="no_nik">No Induk Kependudukan (NIK) <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="no_nik" id="no_nik"
                                        value="{{ old('no_nik', $anggota->no_nik) }}" maxlength="16" pattern="[0-9]{16}"
                                        inputmode="numeric"
                                        class="form-control form-control-sm @error('no_nik') is-invalid @enderror"
                                        placeholder="Masukkan 16 digit NIK" title="NIK harus 16 digit angka"
                                        oninvalid="this.setCustomValidity('NIK harus diisi dengan 16 digit angka')"
                                        oninput="this.setCustomValidity('')" required>
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
                                    <input type="text" name="nama" id="nama"
                                        value="{{ old('nama', $anggota->nama) }}"
                                        class="form-control form-control-sm text-uppercase @error('nama') is-invalid @enderror"
                                        placeholder="Masukkan nama lengkap" required>
                                    @error('nama')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Jenis Kelamin --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="jenkel">Jenis Kelamin <span class="text-danger">*</span></label>
                                    <select name="jenkel" id="jenkel"
                                        class="form-control form-control-sm select2 @error('jenkel') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Jenis Kelamin</option>
                                        @foreach ($jenisKelamin as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('jenkel', $anggota->jenkel) == $id ? 'selected' : '' }}>
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
                                    <input type="text" name="tmpt_lahir" id="tmpt_lahir"
                                        value="{{ old('tmpt_lahir', $anggota->tmpt_lahir) }}"
                                        class="form-control form-control-sm text-uppercase @error('tmpt_lahir') is-invalid @enderror"
                                        placeholder="Contoh: TANGERANG" required>
                                    @error('tmpt_lahir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Tanggal Lahir --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tgl_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                    <input type="date" name="tgl_lahir" id="tgl_lahir"
                                        value="{{ old('tgl_lahir', $anggota->tgl_lahir) }}"
                                        class="form-control form-control-sm @error('tgl_lahir') is-invalid @enderror"
                                        max="{{ date('Y-m-d') }}" required>
                                    @error('tgl_lahir')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Agama --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agama">Agama <span class="text-danger">*</span></label>
                                    <select name="agama" id="agama"
                                        class="form-control form-control-sm select2 @error('agama') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Agama</option>
                                        @foreach ($agama as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('agama', $anggota->agama) == $id ? 'selected' : '' }}>
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
                                    <select name="gol_darah" id="gol_darah"
                                        class="form-control form-control-sm select2 @error('gol_darah') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Golongan Darah</option>
                                        @foreach ($golDarah as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('gol_darah', $anggota->gol_darah) == $id ? 'selected' : '' }}>
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
                                    <select name="pendidikan" id="pendidikan"
                                        class="form-control form-control-sm select2 @error('pendidikan') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Pendidikan Formal</option>
                                        @foreach ($pendidikanKeluarga as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('pendidikan', $anggota->pendidikan) == $id ? 'selected' : '' }}>
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
                                    <select name="pendidikan_non" id="pendidikan_non"
                                        class="form-control form-control-sm select2 @error('pendidikan_non') is-invalid @enderror">
                                        <option value="" hidden>Pilih Pendidikan Non Formal</option>
                                        <option value="Pesantren Salafiah"
                                            {{ old('pendidikan_non', $anggota->pendidikan_non) == 'Pesantren Salafiah' ? 'selected' : '' }}>
                                            Pesantren Salafiah</option>
                                        <option value="Pendidikan keagamaan Lainnya"
                                            {{ old('pendidikan_non', $anggota->pendidikan_non) == 'Pendidikan keagamaan Lainnya' ? 'selected' : '' }}>
                                            Pendidikan Keagamaan Lainnya</option>
                                        <option value="Pendidikan Lainnya"
                                            {{ old('pendidikan_non', $anggota->pendidikan_non) == 'Pendidikan Lainnya' ? 'selected' : '' }}>
                                            Pendidikan Lainnya</option>
                                        <option value="Tidak Ada"
                                            {{ old('pendidikan_non', $anggota->pendidikan_non) == 'Tidak Ada' ? 'selected' : '' }}>
                                            Tidak Ada</option>
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
                                    <select name="jns_pekerjaan" id="jns_pekerjaan"
                                        class="form-control form-control-sm select2 @error('jns_pekerjaan') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Jenis Pekerjaan</option>
                                        @foreach ($pekerjaan as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('jns_pekerjaan', $anggota->jns_pekerjaan) == $id ? 'selected' : '' }}>
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
                                    <label for="pendapatan_perbulan">Pendapatan Perbulan <span
                                            class="text-danger">*</span></label>
                                    <select name="pendapatan_perbulan" id="pendapatan_perbulan"
                                        class="form-control form-control-sm select2 @error('pendapatan_perbulan') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Pendapatan Perbulan</option>
                                        @php
                                            $pendapatanOptions = [
                                                '0-1 Juta',
                                                '1-2 Juta',
                                                '2-3 Juta',
                                                '3-5 Juta',
                                                '5-10 Juta',
                                                '10-20 Juta',
                                                '20-50 Juta',
                                                '50-100 Juta',
                                                '>100 Juta',
                                            ];
                                        @endphp
                                        @foreach ($pendapatanOptions as $option)
                                            <option value="{{ $option }}"
                                                {{ old('pendapatan_perbulan', $anggota->pendapatan_perbulan) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('pendapatan_perbulan')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: STATUS PERKAWINAN --}}
                        <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                            <h6 class="mb-0 text-white"><i class="fas fa-ring mr-2"></i>STATUS PERKAWINAN & HUBUNGAN
                                KELUARGA</h6>
                        </div>

                        <div class="row">
                            {{-- Status Perkawinan --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sts_perkawinan">Status Perkawinan <span
                                            class="text-danger">*</span></label>
                                    <select name="sts_perkawinan" id="sts_perkawinan"
                                        class="form-control form-control-sm @error('sts_perkawinan') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Status Perkawinan</option>
                                        @php
                                            $statusPerkawinan = ['BELUM KAWIN', 'KAWIN', 'CERAI HIDUP', 'CERAI MATI'];
                                        @endphp
                                        @foreach ($statusPerkawinan as $status)
                                            <option value="{{ $status }}"
                                                {{ old('sts_perkawinan', $anggota->sts_perkawinan) == $status ? 'selected' : '' }}>
                                                {{ $status }}
                                            </option>
                                        @endforeach
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
                                    <select name="status_kawin_tercatat" id="status_kawin_tercatat"
                                        class="form-control form-control-sm select2 @error('status_kawin_tercatat') is-invalid @enderror">
                                        <option value="" hidden>Pilih Status</option>
                                        <option value="kawin_tercatat"
                                            {{ old('status_kawin_tercatat', $anggota->status_kawin_tercatat) == 'kawin_tercatat' ? 'selected' : '' }}>
                                            Kawin Tercatat</option>
                                        <option value="kawin_tidak_tercatat"
                                            {{ old('status_kawin_tercatat', $anggota->status_kawin_tercatat) == 'kawin_tidak_tercatat' ? 'selected' : '' }}>
                                            Kawin Tidak Tercatat</option>
                                    </select>
                                    @error('status_kawin_tercatat')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Hubungan Dalam Keluarga --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="sts_hub_kel">Hubungan Dalam Keluarga <span
                                            class="text-danger">*</span></label>
                                    <select name="sts_hub_kel" id="sts_hub_kel"
                                        class="form-control form-control-sm select2 @error('sts_hub_kel') is-invalid @enderror">
                                        @foreach ($hubunganKeluarga as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('sts_hub_kel', $anggota->sts_hub_kel) == $id ? 'selected' : '' }}>
                                                {{ $nama }}
                                            </option>
                                        @endforeach
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
                                    <select name="sts_kwn" id="sts_kwn"
                                        class="form-control form-control-sm select2 @error('sts_kwn') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Kewarganegaraan</option>
                                        @foreach ($kewarganegaraan as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('sts_kwn', $anggota->sts_kwn) == $id ? 'selected' : '' }}>
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
                                    <label for="kepemilikan_rumah">Kepemilikan Rumah <span
                                            class="text-danger">*</span></label>
                                    <select name="kepemilikan_rumah" id="kepemilikan_rumah"
                                        class="form-control form-control-sm select2 @error('kepemilikan_rumah') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Kepemilikan Rumah</option>
                                        @php
                                            $kepemilikanOptions = ['Milik Sendiri', 'Orang Tua', 'Ngontrak', 'Lainnya'];
                                        @endphp
                                        @foreach ($kepemilikanOptions as $option)
                                            <option value="{{ $option }}"
                                                {{ old('kepemilikan_rumah', $anggota->kepemilikan_rumah) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('kepemilikan_rumah')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- SECTION: BANTUAN & KESEHATAN --}}
                        <div class="bg-gradient-dark mb-3 mt-4 rounded px-3 py-2">
                            <h6 class="mb-0 text-white"><i class="fas fa-hand-holding-medical mr-2"></i>BANTUAN PEMERINTAH
                                & KESEHATAN</h6>
                        </div>

                        <div class="row">
                            {{-- Bantuan Pemerintah --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="tanya_bantuanpemerintah">Kelayakan Bantuan Pemerintah <span
                                            class="text-danger">*</span></label>
                                    <select name="tanya_bantuanpemerintah" id="tanya_bantuanpemerintah"
                                        class="form-control form-control-sm @error('tanya_bantuanpemerintah') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Status</option>
                                        <option value="Tidak Layak"
                                            {{ old('tanya_bantuanpemerintah', $anggota->tanya_bantuanpemerintah) == 'Tidak Layak' ? 'selected' : '' }}>
                                            Tidak Layak</option>
                                        <option value="Layak"
                                            {{ old('tanya_bantuanpemerintah', $anggota->tanya_bantuanpemerintah) == 'Layak' ? 'selected' : '' }}>
                                            Layak</option>
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
                                    <select name="bantuan_pemerintah" id="bantuan_pemerintah"
                                        class="form-control form-control-sm select2 @error('bantuan_pemerintah') is-invalid @enderror">
                                        <option value="" hidden>Pilih Jenis Bantuan</option>
                                        @foreach ($bantuanPemerintah as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('bantuan_pemerintah', $anggota->bantuan_pemerintah) == $id ? 'selected' : '' }}>
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
                                    <label for="sakitkronis">Menderita Sakit Kronis <span
                                            class="text-danger">*</span></label>
                                    <select name="sakitkronis" id="sakitkronis"
                                        class="form-control form-control-sm select2 @error('sakitkronis') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Status</option>
                                        @foreach ($kronis as $id => $nama)
                                            <option value="{{ $id }}"
                                                {{ old('sakitkronis', $anggota->sakitkronis) == $id ? 'selected' : '' }}>
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
                                    <select name="punya_bpjs" id="punya_bpjs"
                                        class="form-control form-control-sm @error('punya_bpjs') is-invalid @enderror"
                                        required>
                                        <option value="" hidden>Pilih Status</option>
                                        <option value="tidak"
                                            {{ old('punya_bpjs', $anggota->punya_bpjs) == 'tidak' ? 'selected' : '' }}>
                                            Tidak</option>
                                        <option value="ya"
                                            {{ old('punya_bpjs', $anggota->punya_bpjs) == 'ya' ? 'selected' : '' }}>
                                            Ya</option>
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
                                    <select name="jenis_bpjs" id="jenis_bpjs"
                                        class="form-control form-control-sm @error('jenis_bpjs') is-invalid @enderror">
                                        <option value="" hidden>Pilih Jenis BPJS</option>
                                        <option value="bpjs_kesehatan"
                                            {{ old('jenis_bpjs', $anggota->jenis_bpjs) == 'bpjs_kesehatan' ? 'selected' : '' }}>
                                            BPJS Kesehatan</option>
                                        <option value="bpjs_ketenagakerjaan"
                                            {{ old('jenis_bpjs', $anggota->jenis_bpjs) == 'bpjs_ketenagakerjaan' ? 'selected' : '' }}>
                                            BPJS Ketenagakerjaan</option>
                                        <option value="memiliki_kedua_bpjs"
                                            {{ old('jenis_bpjs', $anggota->jenis_bpjs) == 'memiliki_kedua_bpjs' ? 'selected' : '' }}>
                                            Memiliki Kedua BPJS</option>
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
                                    <select name="pembayaran_bpjs" id="pembayaran_bpjs"
                                        class="form-control form-control-sm @error('pembayaran_bpjs') is-invalid @enderror">
                                        <option value="" hidden>Pilih Cara Pembayaran</option>
                                        <option value="mandiri"
                                            {{ old('pembayaran_bpjs', $anggota->pembayaran_bpjs) == 'mandiri' ? 'selected' : '' }}>
                                            Mandiri</option>
                                        <option value="pemerintah"
                                            {{ old('pembayaran_bpjs', $anggota->pembayaran_bpjs) == 'pemerintah' ? 'selected' : '' }}>
                                            Pemerintah / Perusahaan</option>
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
                                    <input type="text" name="nm_ibu" id="nm_ibu"
                                        value="{{ old('nm_ibu', $anggota->nm_ibu) }}"
                                        class="form-control form-control-sm text-uppercase @error('nm_ibu') is-invalid @enderror"
                                        placeholder="Masukkan nama ibu kandung" required>
                                    @error('nm_ibu')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            {{-- Nama Ayah --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nm_ayah">Nama Ayah Kandung <span class="text-danger">*</span></label>
                                    <input type="text" name="nm_ayah" id="nm_ayah"
                                        value="{{ old('nm_ayah', $anggota->nm_ayah) }}"
                                        class="form-control form-control-sm text-uppercase @error('nm_ayah') is-invalid @enderror"
                                        placeholder="Masukkan nama ayah kandung" required>
                                    @error('nm_ayah')
                                        <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="card-footer text-center">
                    <a href="{{ route('kependudukan.anggota.keluarga.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times mr-1"></i> Batal
                    </a>
                    <button type="submit" form="formKK" class="btn btn-primary btn-sm">
                        <i class="fas fa-save mr-1"></i> Update Data
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal Kepala Keluarga --}}
    <div class="modal fade" id="modalFamillies" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content rounded-0 text-sm">
                <div class="modal-header">
                    <h5 class="modal-title">Data Kepala Keluarga</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table id="kartukeluarga" class="table-bordered table-striped table-sm table">
                            <thead>
                                <tr class="nowrap text-center">
                                    <th>NO</th>
                                    <th>NO KK</th>
                                    <th>NO NIK</th>
                                    <th>NAMA</th>
                                    <th>ALAMAT</th>
                                    <th class="text-center">PILIH</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
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
            var table = null;

            // Inisialisasi DataTable saat modal dibuka
            $('#modalFamillies').on('shown.bs.modal', function() {
                if (!$.fn.DataTable.isDataTable('#kartukeluarga')) {
                    table = $('#kartukeluarga').DataTable({
                        responsive: false,
                        autoWidth: false,
                        processing: true,
                        serverSide: true,
                        ordering: true,
                        paging: true,
                        searching: true,
                        info: true,
                        ajax: "{{ route('kependudukan.anggota.keluarga.index.kepala.keluarga.data') }}",
                        columns: [{
                                data: 'DT_RowIndex',
                                name: 'DT_RowIndex',
                                width: '1%',
                                class: 'text-center nowrap',
                                orderable: false,
                                searchable: false,
                            },
                            {
                                data: 'no_kk',
                                name: 't2.no_kk',
                                class: 'text-center nowrap',
                            },
                            {
                                data: 'no_nik',
                                name: 't1.no_nik',
                                class: 'text-center nowrap',
                            },
                            {
                                data: 'nama',
                                name: 't1.nama',
                                class: 'text-center nowrap',
                            },
                            {
                                data: 'alamat',
                                name: 'alamat',
                                class: 'text-center nowrap',
                            },
                            {
                                data: 'aksi',
                                name: 'aksi',
                                width: '1%',
                                class: 'text-center nowrap',
                                orderable: false,
                                searchable: false,
                            },
                        ]
                    });
                }
            });

            // Event handler untuk tombol select
            $(document).on('click', '#selectFamillies', function() {
                var id_kk = $(this).data('id_kk');
                var nama = $(this).data('nama');
                var no_kk = $(this).data('no_kk');
                var kp = $(this).data('kp');
                var rt = $(this).data('rt');
                var rw = $(this).data('rw');
                var kodepos = $(this).data('kodepos');
                var desa = $(this).data('desa');
                var kecamatan = $(this).data('kecamatan');
                var kabkot = $(this).data('kabkot');
                var provinsi = $(this).data('provinsi');

                $('#id_kk').val(id_kk);
                $('#nama_kk').val(nama);
                $('#no_kk').val(no_kk);
                $('#kp').val(kp);
                $('#rt').val(rt);
                $('#rw').val(rw);
                $('#kodepos').val(kodepos);
                $('#desa').val(desa);
                $('#kecamatan').val(kecamatan);
                $('#kabkot').val(kabkot);
                $('#provinsi').val(provinsi);

                $('#modalFamillies').modal('hide');
            });

            // Destroy DataTable saat modal ditutup
            $('#modalFamillies').on('hidden.bs.modal', function() {
                if ($.fn.DataTable.isDataTable('#kartukeluarga')) {
                    $('#kartukeluarga').DataTable().destroy();
                    table = null;
                }
            });

            // ============================================================
            // VALIDASI NIK
            // ============================================================
            $('#no_nik').on('input', function() {
                let nik = $(this).val();
                let feedback = $('#nikFeedback');

                if (nik.length === 16 && /^\d{16}$/.test(nik)) {
                    feedback.text('✓ NIK valid').removeClass('text-danger').addClass('text-success');
                    this.setCustomValidity('');
                } else if (nik.length > 0) {
                    feedback.text('NIK harus 16 digit angka').removeClass('text-success').addClass(
                        'text-danger');
                } else {
                    feedback.text('');
                }
            });

            // ============================================================
            // SHOW/HIDE: Status Kawin Tercatat
            // ============================================================
            $('#sts_perkawinan').on('change', function() {
                if ($(this).val() === 'KAWIN') {
                    $('#kawin_tercatat_container').slideDown();
                } else {
                    $('#kawin_tercatat_container').slideUp();
                    $('#status_kawin_tercatat').val('');
                }
            });

            // Trigger saat halaman load
            if ($('#sts_perkawinan').val() === 'KAWIN') {
                $('#kawin_tercatat_container').show();
            }

            // ============================================================
            // SHOW/HIDE: Jenis Bantuan Pemerintah
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
            // INITIALIZE: Select2
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
                    }
                }
            });

        });
    </script>
@endpush
