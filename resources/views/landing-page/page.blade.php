<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('assets/img/desa.png') }}" type="image/x-icon" />
    <title>DesaBisa - Kembali Ke Desa</title>
    @include('landing-page.partials.styles')
</head>

<body>
    <!-- Header -->
    @include('landing-page.partials.header')

    <!-- Hero Section -->
    @include('landing-page.partials.hero-section')

    <!-- TOP 6 KEY METRICS -->
    @include('landing-page.partials.key-metrics')

    <!-- Statistics Section -->
    @include('landing-page.partials.statistics-section')

    <!-- Villages Section -->
    @include('landing-page.partials.villages-section')

    <!-- Footer -->
    @include('landing-page.partials.footer')

    @include('landing-page.partials.scripts')


</body>

</html>
