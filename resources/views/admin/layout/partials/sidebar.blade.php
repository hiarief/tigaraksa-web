<aside class="main-sidebar sidebar-dark-warning elevation-4">

    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="http://3raksa.id/images/siode.png" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">TIGARAKSA</span>
    </a>
    <div
        class="sidebar os-host os-theme-light os-host-overflow os-host-overflow-y os-host-resize-disabled os-host-transition os-host-scrollbar-horizontal-hidden">

        <div class="user-panel d-flex mb-2 mt-2 pb-2">
            <div class="image">
                <img src="{{ asset('assets/img/AdminLTELogo.png') }}" class="img-circle elevation-2">
            </div>
            <div class="info">
                <span class="d-block text-sm text-white">
                    Desa {{ ucfirst(strtolower(Auth::user()->namadesa)) }}
                </span>
            </div>
        </div>
        <div class="form-inline d-flex mb-3 mt-2 pb-0">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar form-control-sm" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar btn-sm">
                        <i class="fas fa-search fa-fw bounce-icon"></i>
                    </button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent"
                data-widget="treeview" role="menu" data-accordion="false">
                {{-- ================= DASHBOARD ================= --}}
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Route::is('dashboard.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line text-primary"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ================= DATA KEPENDUDUKAN ================= --}}
                <li class="nav-header">DATA KEPENDUDUKAN</li>

                <li class="nav-item">
                    <a href="{{ route('penduduk.index') }}"
                        class="nav-link {{ Route::is('penduduk.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users text-info"></i>
                        <p>Data Penduduk</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('umur.umur') }}" class="nav-link {{ Route::is('umur.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-clock text-info"></i>
                        <p>Distribusi Umur</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('perkawinan.index') }}"
                        class="nav-link {{ Route::is('perkawinan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-arrows text-info"></i>
                        <p>Status Perkawinan</p>
                    </a>
                </li>

                {{-- ================= SOSIAL & KESEJAHTERAAN ================= --}}
                <li class="nav-header">SOSIAL & KESEJAHTERAAN</li>

                <li class="nav-item">
                    <a href="{{ route('pendidikan.pendidikan') }}"
                        class="nav-link {{ Route::is('pendidikan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap text-success"></i>
                        <p>Pendidikan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pekerjaan.index') }}"
                        class="nav-link {{ Route::is('pekerjaan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase text-success"></i>
                        <p>Pekerjaan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('bpjs.bpjs') }}" class="nav-link {{ Route::is('bpjs.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-heartbeat text-success"></i>
                        <p>Kesehatan (BPJS)</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kepemilikan.rumah.index') }}"
                        class="nav-link {{ Route::is('kepemilikan.rumah.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-house-user text-success"></i>
                        <p>Kepemilikan Rumah</p>
                    </a>
                </li>

                {{-- ================= EKONOMI & BANTUAN ================= --}}
                <li class="nav-header">EKONOMI & BANTUAN</li>

                <li class="nav-item">
                    <a href="{{ route('pendapatan.pendapatan') }}"
                        class="nav-link {{ Route::is('pendapatan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet text-purple"></i>
                        <p>Pendapatan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('bantuan.pemerintah.index') }}"
                        class="nav-link {{ Route::is('bantuan.pemerintah.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-hand-holding-heart text-purple"></i>
                        <p>Bantuan Pemerintah</p>
                    </a>
                </li>

                {{-- ================= DATA KELUARGA ================= --}}
                <li class="nav-header">DATA KELUARGA</li>

                <li class="nav-item">
                    <a href="{{ route('kependudukan.kartu.keluarga.index') }}"
                        class="nav-link {{ Route::is('kependudukan.kartu.keluarga.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card text-teal"></i>
                        <p>Kepala Keluarga</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kependudukan.anggota.keluarga.index') }}"
                        class="nav-link {{ Route::is('kependudukan.anggota.keluarga.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-friends text-teal"></i>
                        <p>Anggota Keluarga</p>
                    </a>
                </li>

                {{-- ================= ADMINISTRASI DESA ================= --}}
                <li class="nav-header">ADMINISTRASI DESA</li>

                <li class="nav-item">
                    <a href="{{ route('admin.desa.index') }}"
                        class="nav-link {{ Route::is('admin.desa.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-user-shield text-danger"></i>
                        <p>Pengguna Sistem</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('data.hilang.index') }}"
                        class="nav-link {{ Route::is('data.hilang.index*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-triangle-exclamation text-danger"></i>
                        <p>Laporan Data Hilang</p>
                    </a>
                </li>

                <li class="nav-header">USER MANAGE</li>

                <li class="nav-item">
                    <a href="{{ route('admin.permissions.index') }}"
                        class="nav-link {{ Route::is('admin.permissions.index*') ? 'active' : '' }}">
                        <i class="fas fa-user-tag nav-icon bounce-icon"></i>
                        <p>Permission</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.roles.index') }}"
                        class="nav-link {{ Route::is('admin.roles.index*') ? 'active' : '' }}">
                        <i class="fas fa-user-shield nav-icon bounce-icon"></i>
                        <p>Role</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}"
                        class="nav-link {{ Route::is('admin.users.index*') ? 'active' : '' }}">
                        <i class="fas fa-users nav-icon bounce-icon"></i>
                        <p>User</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-alt nav-icon bounce-icon"></i>
                        <p>Profil</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fas fa-user-lock nav-icon bounce-icon"></i>
                        <p>Password</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="" class="nav-link">
                        <i class="fas fa-user-secret nav-icon bounce-icon"></i>
                        <p>Audit</p>
                    </a>
                </li>
                </li>

                <li class="nav-header">KELUAR</li>

                @auth
                    <li class="nav-item">
                        <a href="#" class="nav-link" onclick="event.preventDefault(); confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt text-danger bounce-icon"></i>
                            <p class="text-danger">Keluar</p>
                        </a>

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                    </li>


                @endauth

                <script>
                    function confirmLogout() {
                        Swal.fire({
                            title: 'Apakah Anda yakin ingin keluar?',
                            text: "Anda akan keluar dari sesi ini!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#d33',
                            cancelButtonColor: '#3085d6',
                            confirmButtonText: 'Ya, Keluar',
                            cancelButtonText: 'Batal'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                document.getElementById('logout-form').submit();
                            }
                        });
                    }
                </script>

            </ul>
        </nav>
    </div>
</aside>
