@extends('admin.layout.main')
@section('title', 'Detail Kartu Keluarga')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-id-card"></i> KARTU KELUARGA
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <table class="table-borderless table-sm table">
                                <tr>
                                    <td width="180"><strong>Nomor KK</strong></td>
                                    <td>: <span class="badge badge-dark px-3 py-2"
                                            style="font-size: 14px;">{{ $kepalaKeluarga->no_kk ?? '-' }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nama Kepala Keluarga</strong></td>
                                    <td>: {{ $data->where('hubungan_id', 1)->first()->nama ?? '-' }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table-borderless table-sm table">
                                <tr>
                                    <td width="120"><strong>Alamat</strong></td>
                                    <td>: {{ strtoupper($kepalaKeluarga->kp ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>RT / RW</strong></td>
                                    <td>: {{ $kepalaKeluarga->rt ?? '-' }} / {{ $kepalaKeluarga->rw ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Desa/Kelurahan</strong></td>
                                    <td>: {{ strtoupper($kepalaKeluarga->desa ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kecamatan</strong></td>
                                    <td>: {{ strtoupper($kepalaKeluarga->kecamatan ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Kabupaten/Kota</strong></td>
                                    <td>: {{ strtoupper($kepalaKeluarga->kabupaten ?? '-') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Provinsi</strong></td>
                                    <td>: {{ strtoupper($kepalaKeluarga->provinsi ?? '-') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <hr>

                    <h5 class="mb-3"><strong>Susunan Anggota Keluarga</strong></h5>
                    <div class="table-responsive">
                        <table class="table-bordered table-hover table-sm table">
                            <thead class="thead-light">
                                <tr class="text-center">
                                    <th width="30">No</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>JK</th>
                                    <th>Tempat, Tgl Lahir</th>
                                    <th>Hub. Keluarga</th>
                                    <th>Agama</th>
                                    <th>Pendidikan</th>
                                    <th>Pekerjaan</th>
                                    <th>Status Kawin</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($data as $index => $anggota)
                                    <tr>
                                        <td class="text-center">{{ $index + 1 }}</td>
                                        <td><small>{{ $anggota->no_nik }}</small></td>
                                        <td><strong>{{ $anggota->nama }}</strong></td>
                                        <td class="text-center">
                                            @if (strtoupper($anggota->jenkel) == 'LAKI-LAKI' || strtoupper($anggota->jenkel) == 'L')
                                                <span class="badge badge-primary">L</span>
                                            @else
                                                <span class="badge badge-danger">P</span>
                                            @endif
                                        </td>
                                        <td><small>{{ $anggota->tmpt_lahir }},
                                                {{ \Carbon\Carbon::parse($anggota->tgl_lahir)->format('d-m-Y') }}</small>
                                        </td>
                                        <td class="text-center"><span
                                                class="badge badge-info">{{ $anggota->hubungan_keluarga }}</span></td>
                                        <td><small>{{ $anggota->agama }}</small></td>
                                        <td><small>{{ $anggota->pendidikan }}</small></td>
                                        <td><small>{{ $anggota->pekerjaan }}</small></td>
                                        <td class="text-center"><small>{{ $anggota->status_perkawinan }}</small></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-muted text-center">
                                            <i>Tidak ada data anggota keluarga</i>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('kependudukan.kartu.keluarga.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Kembali
                        </a>
                        <a href="{{ route('kependudukan.kartu.keluarga.print', $kepalaKeluarga->id) }}" target="_blank"
                            class="btn btn-primary">
                            <i class="fas fa-print"></i> Cetak KK
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <style>
        .table-borderless td {
            padding: 0.3rem 0.5rem;
        }
    </style>
@endpush
