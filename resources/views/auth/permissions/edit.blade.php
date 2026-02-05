@extends('admin.layout.main')
@section('title', 'Edit Permission')
@section('content')

    <div class="row">
        <div class="col-md-8">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Edit Permission</h3>
                </div>
                <form action="{{ route('admin.permissions.update', $permission) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Permission <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name', $permission->name) }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
