@extends('admin.layout.main')
@section('title', 'Kartu Keluarga')
@section('content')

    <div class="row">
        <div class="col-md-12">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <div class="card-title">
                        <a href="{{ route('kependudukan.kartu.keluarga.create') }}" class="btn btn-xs bg-gradient-primary"><i
                                class="fa-solid fa-plus"></i>
                            Tambah</a>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="kartu-keluarga-table"
                        class="table-bordered table-hover table-striped rounded-0 table-sm table py-0 text-sm">
                        <thead>
                            <tr class="text-center">
                                <th rowspan="2" style="width: 1%">NO</th>
                                <th rowspan="2" style="width: 1%">AKSI</th>
                                <th colspan="2">NOMOR</th>
                                <th rowspan="2">NAMA</th>
                                <th rowspan="2">TANGGAL LAHIR</th>
                                <th rowspan="2">TEMPAT LAHIR</th>
                                <th rowspan="2">ALAMAT</th>
                            </tr>
                            <tr class="text-center">
                                <th>KK</th>
                                <th>NIK</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('styles')
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#kartu-keluarga-table').DataTable({
                responsive: false,
                autoWidth: false,
                processing: true,
                serverSide: true,
                ordering: true,
                paging: true,
                searching: true,
                info: true,
                ajax: "{{ route('kependudukan.kartu.keluarga.index.data') }}",
                order: [
                    [8, 'desc']
                ],
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        width: '1%',
                        class: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        class: 'text-center nowrap',
                        orderable: false,
                        searchable: false,
                    },
                    {
                        data: 'no_kk',
                        name: 'no_kk',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'no_nik',
                        name: 'no_nik',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'nama',
                        name: 'nama',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tgl_lahir',
                        name: 'tgl_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'tmpt_lahir',
                        name: 'tmpt_lahir',
                        class: 'text-center nowrap',
                    },
                    {
                        data: 'alamat',
                        name: 'alamat',
                        orderable: false,
                        searchable: false,
                        class: 'text-center',
                    },
                    {
                        data: 'created_at',
                        name: 't1.created_at', // Penting: gunakan alias table
                        visible: false, // Hidden column
                        searchable: false
                    }
                ],
            });
        });
    </script>
    <script>
        function deleteData(id) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;

            $.ajax({
                url: "{{ route('kependudukan.kartu.keluarga.delete', ':id') }}".replace(':id', id),
                type: "POST",
                data: {
                    _method: "POST",
                    _token: "{{ csrf_token() }}"
                },
                success: function() {
                    $('#kartu-keluarga-table').DataTable().ajax.reload(null, false);
                },
                error: function() {
                    alert('Gagal menghapus data');
                }
            });
        }
    </script>
@endpush
