@extends('admin.layout.main')
@section('title', 'Tambah Permission')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Tambah Permission Baru</h3>
                </div>
                <form action="{{ route('admin.permissions.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Permission <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" placeholder="create-user, edit-user, delete-user"
                                required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                            <small class="form-text text-muted">Gunakan format: action-resource, contoh: create-user,
                                edit-post</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
