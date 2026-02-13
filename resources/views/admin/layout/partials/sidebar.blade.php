<aside class="main-sidebar sidebar-dark-warning elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link-custom">
        <div class="brand-wrapper">
            <div class="logo-glow"></div>
            <img src="{{ asset('assets/img/siode.png') }}" alt="SIODE Logo" class="brand-image-custom">
        </div>
    </a>

    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel-custom">
            <div class="user-avatar">
                <img src="{{ asset('assets/img/desa.png') }}" alt="User Avatar">
                <div class="status-dot"></div>
            </div>
            <div class="user-info">
                <span class="user-name">Desa {{ ucfirst(strtolower(Auth::user()->namadesa)) }}</span>
                <span class="user-status">Online</span>
            </div>
        </div>

        <!-- Sidebar Search -->
        <div class="sidebar-search-wrapper">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar-custom" type="search" placeholder="Cari menu..."
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar-custom">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent"
                data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}"
                        class="nav-link {{ Route::is('dashboard.*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>Dashboard</p>
                        <span class="nav-glow"></span>
                    </a>
                </li>

                @can('kecamatan-chart')
                    <li class="nav-header">
                        <i class="fas fa-users header-icon"></i>
                        <span>DATA KEPENDUDUKAN</span>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('kecamatan.kependudukan.index') }}"
                            class="nav-link {{ Route::is('kecamatan.kependudukan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Penduduk</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kecamatan.umur.index') }}"
                            class="nav-link {{ Route::is('kecamatan.umur.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>Distribusi Umur</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kecamatan.perkawinan.index') }}"
                            class="nav-link {{ Route::is('kecamatan.perkawinan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-people-arrows"></i>
                            <p>Status Perkawinan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <!-- SOSIAL & KESEJAHTERAAN -->
                    <li class="nav-header">
                        <i class="fas fa-heart header-icon"></i>
                        <span>SOSIAL & KESEJAHTERAAN</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kecamatan.pendidikan.index') }}"
                            class="nav-link {{ Route::is('kecamatan.pendidikan*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>Pendidikan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kecamatan.pekerjaan.index') }}"
                            class="nav-link {{ Route::is('kecamatan.pekerjaan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Pekerjaan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                @endcan

                @can('desa-chart')
                    <li class="nav-header">
                        <i class="fas fa-users header-icon"></i>
                        <span>DATA KEPENDUDUKAN</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('penduduk.index') }}"
                            class="nav-link {{ Route::is('penduduk.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Data Penduduk</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('umur.umur') }}" class="nav-link {{ Route::is('umur.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-clock"></i>
                            <p>Distribusi Umur</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('perkawinan.index') }}"
                            class="nav-link {{ Route::is('perkawinan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-people-arrows"></i>
                            <p>Status Perkawinan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <!-- SOSIAL & KESEJAHTERAAN -->
                    <li class="nav-header">
                        <i class="fas fa-heart header-icon"></i>
                        <span>SOSIAL & KESEJAHTERAAN</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pendidikan.pendidikan') }}"
                            class="nav-link {{ Route::is('pendidikan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-graduation-cap"></i>
                            <p>Pendidikan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pekerjaan.index') }}"
                            class="nav-link {{ Route::is('pekerjaan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-briefcase"></i>
                            <p>Pekerjaan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bpjs.bpjs') }}" class="nav-link {{ Route::is('bpjs.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-heartbeat"></i>
                            <p>Kesehatan (BPJS)</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('kepemilikan.rumah.index') }}"
                            class="nav-link {{ Route::is('kepemilikan.rumah.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-house-user"></i>
                            <p>Kepemilikan Rumah</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <!-- EKONOMI & BANTUAN -->
                    <li class="nav-header">
                        <i class="fas fa-wallet header-icon"></i>
                        <span>EKONOMI & BANTUAN</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('pendapatan.pendapatan') }}"
                            class="nav-link {{ Route::is('pendapatan.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-wallet"></i>
                            <p>Pendapatan</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('bantuan.pemerintah.index') }}"
                            class="nav-link {{ Route::is('bantuan.pemerintah.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hand-holding-heart"></i>
                            <p>Bantuan Pemerintah</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>

                    <!-- DATA KELUARGA -->
                    @can('data-keluarga')
                        <li class="nav-header">
                            <i class="fas fa-home header-icon"></i>
                            <span>DATA KELUARGA</span>
                        </li>

                        @can('kepala-keluarga')
                            <li class="nav-item">
                                <a href="{{ route('kependudukan.kartu.keluarga.index') }}"
                                    class="nav-link {{ Route::is('kependudukan.kartu.keluarga.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-id-card"></i>
                                    <p>Kepala Keluarga</p>
                                    <span class="nav-glow"></span>
                                </a>
                            </li>
                        @endcan
                        @can('anggota-keluarga')
                            <li class="nav-item">
                                <a href="{{ route('kependudukan.anggota.keluarga.index') }}"
                                    class="nav-link {{ Route::is('kependudukan.anggota.keluarga.*') ? 'active' : '' }}">
                                    <i class="nav-icon fas fa-user-friends"></i>
                                    <p>Anggota Keluarga</p>
                                    <span class="nav-glow"></span>
                                </a>
                            </li>
                        @endcan
                    @endcan

                    @can('administrasi-desa')
                        <li class="nav-header">
                            <i class="fas fa-cog header-icon"></i>
                            <span>ADMINISTRASI DESA</span>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('admin.desa.index') }}"
                                class="nav-link {{ Route::is('admin.desa.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-shield"></i>
                                <p>Pengguna Sistem</p>
                                <span class="nav-glow"></span>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('data.hilang.index') }}"
                                class="nav-link {{ Route::is('data.hilang.index*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-triangle-exclamation"></i>
                                <p>Laporan Data Hilang</p>
                                <span class="nav-glow"></span>
                            </a>
                        </li>
                    @endcan
                @endcan

                @can('user-manage')
                    <li class="nav-header">
                        <i class="fas fa-user-cog header-icon"></i>
                        <span>USER MANAGE</span>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.permissions.index') }}"
                            class="nav-link {{ Route::is('admin.permissions.index*') ? 'active' : '' }}">
                            <i class="fas fa-user-tag nav-icon"></i>
                            <p>Permission</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}"
                            class="nav-link {{ Route::is('admin.roles.index*') ? 'active' : '' }}">
                            <i class="fas fa-user-shield nav-icon"></i>
                            <p>Role</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}"
                            class="nav-link {{ Route::is('admin.users.index*') ? 'active' : '' }}">
                            <i class="fas fa-users nav-icon"></i>
                            <p>User</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-alt nav-icon"></i>
                            <p>Profil</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="fas fa-user-lock nav-icon"></i>
                            <p>Password</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="" class="nav-link">
                            <i class="fas fa-user-secret nav-icon"></i>
                            <p>Audit</p>
                            <span class="nav-glow"></span>
                        </a>
                    </li>
                @endcan

                <li class="nav-header">
                    <i class="fas fa-sign-out-alt header-icon"></i>
                    <span>KELUAR</span>
                </li>

                @auth
                    <li class="nav-item">
                        <a href="#" class="nav-link nav-link-danger"
                            onclick="event.preventDefault(); confirmLogout();">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                            <span class="nav-glow-danger"></span>
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                            @csrf
                        </form>
                    </li>
                @endauth

            </ul>
        </nav>
    </div>
</aside>

<script>
    function confirmLogout() {
        Swal.fire({
            title: 'Apakah Anda yakin ingin keluar?',
            text: "Anda akan keluar dari sesi ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ffc107',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Keluar',
            cancelButtonText: 'Batal',
            background: '#343a40',
            color: '#ffffff'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('logout-form').submit();
            }
        });
    }
</script>
