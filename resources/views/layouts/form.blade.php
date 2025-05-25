<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <!-- CSS (Opsional: Bootstrap & Kustom) -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('library/bootstrap/dist/css/bootstrap.min.css') }}">

    @stack('style')
</head>
<body style="background-color: #f8f9fa;">

    <!-- HEADER -->
    <header class="text-white p-3" style="background-color: #065ba6;">
        <div class="container d-flex align-items-center">
            <img src="{{ asset('img/Logo_Jti.png') }}" alt="Logo JTI" style="height: 50px; margin-right: 10px;">
            <div>
                <h1 class="h4 mb-0 fw-bold">Tracer Study</h1>
                <small>Jurusan Teknologi Informasi</small>
            </div>
        </div>
    </header>    

    <!-- MAIN CONTENT -->
    <main class="py-5">
        <div class="container">
            @yield('main')
        </div>
    </main>

    <!-- FOOTER -->
    @include('components.footer')

    <!-- JS -->
    <script src="{{ asset('library/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('library/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    @stack('scripts')

</body>
</html>
