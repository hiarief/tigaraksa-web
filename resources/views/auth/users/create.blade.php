@extends('admin.layout.main')
@section('title', 'Tambah User')

@section('content')
    <div class="row">
        <div class="col-md-8">
            <div class="card card-dark card-outline">
                <div class="card-header">
                    <h3 class="card-title">Tambah User Baru</h3>
                </div>
                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="username">Username <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                id="username" name="username" value="{{ old('username') }}" required>
                            @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="desa">Desa <span class="text-danger">*</span></label>
                            <select class="form-control select2 @error('desa') is-invalid @enderror" id="desa"
                                name="desa" required style="width: 100%;">
                                <option value="">-- Pilih Desa --</option>
                                @foreach ($desa as $item)
                                    <option value="{{ $item->code }}" {{ old('desa') == $item->code ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('desa')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email"
                                name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <hr class="my-4">
                        <h5 class="mb-3">Password</h5>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror"
                                    id="password" name="password" placeholder="Minimal 8 karakter" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Konfirmasi Password <span
                                    class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" placeholder="Ulangi password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePasswordConfirm">
                                        <i class="fas fa-eye" id="eyeIconConfirm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        <div class="form-group">
                            <label>Roles <span class="text-danger">*</span></label>
                            <div class="rounded border p-3" style="background-color: #f8f9fa;">
                                @foreach ($roles as $role)
                                    <div class="custom-control custom-checkbox mb-2">
                                        <input class="custom-control-input" type="checkbox" name="roles[]"
                                            value="{{ $role->name }}" id="role{{ $role->id }}"
                                            {{ in_array($role->name, old('roles', [])) ? 'checked' : '' }}>
                                        <label class="custom-control-label" for="role{{ $role->id }}">
                                            <strong>{{ ucfirst($role->name) }}</strong>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            <small class="form-text text-muted">Pilih minimal satu role untuk user ini</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Simpan
                        </button>
                        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .input-group-append .btn {
            height: 38px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#desa').select2({
                theme: 'bootstrap4',
                placeholder: '-- Pilih Desa --',
                allowClear: true
            });

            // Toggle Password Visibility
            $('#togglePassword').click(function() {
                const passwordField = $('#password');
                const eyeIcon = $('#eyeIcon');

                if (passwordField.attr('type') === 'password') {
                    passwordField.attr('type', 'text');
                    eyeIcon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordField.attr('type', 'password');
                    eyeIcon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Toggle Password Confirmation Visibility
            $('#togglePasswordConfirm').click(function() {
                const passwordConfirmField = $('#password_confirmation');
                const eyeIconConfirm = $('#eyeIconConfirm');

                if (passwordConfirmField.attr('type') === 'password') {
                    passwordConfirmField.attr('type', 'text');
                    eyeIconConfirm.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    passwordConfirmField.attr('type', 'password');
                    eyeIconConfirm.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });
        });
    </script>
@endpush
