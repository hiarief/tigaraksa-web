<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    {{--  <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">  --}}
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title') | 3RAKSA</title>
    <link rel="icon" href="{{ asset('assets/images/wjk.png') }}" type="image/x-icon" />
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    {{--  <link rel="stylesheet"Zro:300,400,400i,700&display=fallback">  --}}
    <link rel="stylesheet" href="{!! asset('assets/plugins/font-family/font.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/fontawesome-free/css/all.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/css/adminlte.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/daterangepicker/daterangepicker.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') !!}">
    <link rel="stylesheet" href="{!! asset('assets/plugins/jquery-ui/jquery-ui.css') !!}">
    <script>
        if (window.location.protocol === 'https:') {
            var meta = document.createElement('meta');
            meta.setAttribute('http-equiv', 'Content-Security-Policy');
            meta.setAttribute('content', 'upgrade-insecure-requests');
            document.head.appendChild(meta);
        }
    </script>
    <style>
        th {
            position: relative;
            white-space: nowrap;
        }

        .ui-resizable-handle {
            position: absolute;
            z-index: 90;
            width: 7px;
            height: 100%;
            top: 0;
            right: 0;
            cursor: col-resize;
        }
    </style>
    <style>
        .nowrap {
            white-space: nowrap;
        }

        .table td,
        .table th {
            padding: 8px;
        }

        .table hr {
            margin: 0;
        }
    </style>
    @stack('styles')
</head>

<body class="layout-fixed sidebar-mini sidebar-mini-md hold-transition pace-primary">
    <div class="wrapper">
        @include('admin.layout.partials.navbar')
        @include('admin.layout.partials.sidebar')
        <div class="content-wrapper p-0">
            {{--  <div class="content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="breadcrumb-item m-0"><strong>@yield('content-header')</strong></div>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}"
                                        class="text-navy">Dashboard</a></li>
                                <li class="breadcrumb-item active text-dark">@yield('content-header')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>  --}}
            <div class="content mt-1">
                <div class="container-fluid">
                    @if ($errors->count() > 0)
                        <div class="alert alert-danger alert-dismissible">
                            <button type="button" class="close text-white" data-dismiss="alert"
                                aria-hidden="true">×</button>
                            <h5><i class="icon fas fa-ban"></i> Alert !</h5>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{!! $error !!}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @yield('content')
                </div>
            </div>
        </div>
        @include('admin.layout.partials.footer')
    </div>
    <script src="{!! asset('assets/plugins/jquery/jquery.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/jquery-ui/jquery-ui.js') !!}"></script>
    <script src="{!! asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') !!}"></script>
    <script src="{!! asset('assets/js/adminlte.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/datatables/jquery.dataTables.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/datatables-responsive/js/dataTables.responsive.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/moment/moment.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/inputmask/jquery.inputmask.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/daterangepicker/daterangepicker.js') !!}"></script>
    <script src="{!! asset('assets/plugins/sweetalert2/sweetalert2.all.min.js') !!}"></script>
    <script src="{!! asset('assets/plugins/export-excel/xlsx.full.min.js') !!}"></script>
    <script>
        $(function() {
            // Make table headers resizable
            $(".resizable").resizable({
                handles: 'e'
            });

        });
    </script>
    @if (Session::has('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                showConfirmButton: true,
                timer: 1500
            })
        </script>
    @endif
    @if (Session::has('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: '{{ session('error') }}',
                showConfirmButton: true,
                //timer: 1500
            })
        </script>
    @endif
    @stack('scripts')
</body>

</html>
