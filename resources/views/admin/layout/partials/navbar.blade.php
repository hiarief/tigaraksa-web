<nav class="main-header navbar navbar-expand navbar-white navbar-light text-sm">

    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link text-dark" data-widget="pushmenu" href="#" role="button"><i
                    class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link"><strong>@yield('title')</strong></a>
        </li>
    </ul>


    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown user-menu">
            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" aria-expanded="true">
                <img src="{{ asset('assets/img/AdminLTELogo.png') }}" class="user-image img-circle elevation-2"
                    alt="{!! Auth::user()->name !!}">
                <span class="d-none d-md-inline text-dark"><strong>{{ Auth::user()->name }}</strong></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="left: inherit; right: 0px;">
                <li class="user-header bg-gradient-navy">
                    <img src="{{ asset('assets/img/AdminLTELogo.png') }}" class="img-circle elevation-2"
                        alt="{!! Auth::user()->name !!}">
                    <p class="">
                        {!! Auth::user()->name !!}
                        {{--  <small>Sebagai : {{ Auth::user()->roles->pluck('name')[0] ?? '' }}</small>  --}}
                        <small>{{ Carbon\Carbon::now()->isoFormat('DD MMM Y') }}</small>
                    </p>
                </li>
                <li class="user-footer">
                    @auth
                        <a href="#" class="btn btn-default btn-flat btn-sm">
                            <i class="fa fa-fw fa-user text-lightblue"></i>
                            Ganti Password
                        </a>
                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-inline">
                            @csrf
                            <button type="button" onclick="confirmLogout()"
                                class="btn btn-default btn-flat btn-sm float-right">
                                <i class="fa fa-fw fa-power-off text-red"></i>
                                Keluar
                            </button>
                        </form>

                    @endauth
                </li>
            </ul>
        </li>
    </ul>
</nav>
