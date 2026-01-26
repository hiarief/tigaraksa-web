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

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Route::is('dashboard.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">DATA PENDUDUK</li>

                <li class="nav-item">
                    <a href="{{ route('penduduk.index') }}"
                        class="nav-link {{ Route::is('penduduk.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Kependudukan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('umur.umur') }}" class="nav-link {{ Route::is('umur.umur') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-birthday-cake"></i>
                        <p>Umur</p>
                    </a>
                </li>

                <li class="nav-header">SOSIAL</li>

                <li class="nav-item">
                    <a href="{{ route('pendidikan.pendidikan') }}"
                        class="nav-link {{ Route::is('pendidikan.pendidikan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-graduation-cap"></i>
                        <p>Pendidikan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('pekerjaan.index') }}"
                        class="nav-link {{ Route::is('pekerjaan.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-briefcase"></i>
                        <p>Pekerjaan</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('bpjs.bpjs') }}" class="nav-link {{ Route::is('bpjs.bpjs') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>BPJS</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('kepemilikan.rumah.index') }}"
                        class="nav-link {{ Route::is('kepemilikan.rumah.index') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-house-user"></i>
                        <p>Kepemilikan Rumah</p>
                    </a>
                </li>

                <li class="nav-header">EKONOMI</li>

                <li class="nav-item">
                    <a href="{{ route('pendapatan.pendapatan') }}"
                        class="nav-link {{ Route::is('pendapatan.pendapatan') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-wallet"></i>
                        <p>Pendapatan</p>
                    </a>
                </li>


                <li class="nav-header">PENDUDUK</li>
                <li class="nav-item {{ Route::is('kependudukan.*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Route::is('kependudukan.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-people-group text-info"></i>
                        <p>
                            Kependudukan
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>

                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('kependudukan.kartu.keluarga.index') }}"
                                class="nav-link {{ Route::is('kependudukan.kartu.keluarga.*') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon text-success"></i>
                                <p>Kepala Keluarga</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://3raksa.id/siode/kependudukan/kartu-keluarga/anggota-keluarga"
                                class="nav-link">
                                <i class="far fa-circle nav-icon text-primary"></i>
                                <p>Anggota Keluarga</p>
                            </a>
                        </li>
                    </ul>
                </li>
                {{--  @can('users-manage')
                    <li class="nav-header">USER MANAGE</li>

                    <li class="nav-item {!! request()->is('user-manage') || request()->is('user-manage/*') ? 'menu-open' : '' !!}">
                        <a href="#" class="nav-link {!! request()->is('user-manage') || request()->is('user-manage/*') ? 'active' : '' !!}">
                            <i class="nav-icon fas fa-user-cog bounce-icon"></i>
                            <p>
                                User Manage
                                <i class="right fas fa-angle-left bounce-icon"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('permissions.index') }}" class="nav-link {!! request()->is('user-manage/permissions') || request()->is('user-manage/permissions/*') ? 'active' : '' !!}">
                                    <i class="fas fa-user-tag nav-icon bounce-icon"></i>
                                    <p>Permission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('roles.index') }}" class="nav-link {!! request()->is('user-manage/roles') || request()->is('user-manage/roles/*') ? 'active' : '' !!}">
                                    <i class="fas fa-user-shield nav-icon bounce-icon"></i>
                                    <p>Role</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link {!! request()->is('user-manage/users') || request()->is('user-manage/users/*') ? 'active' : '' !!}">
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
                            <li class="nav-item">
                                <a href="{{ route('logs') }}" class="nav-link">
                                    <i class="fas fa-user-clock nav-icon bounce-icon"></i>
                                    <p>Log</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('keylock.index') }}" class="nav-link">
                                    <i class="fas fa-lock nav-icon bounce-icon"></i>
                                    <p>Keylock</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                @endcan  --}}

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
