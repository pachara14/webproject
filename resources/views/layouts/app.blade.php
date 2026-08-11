<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'ศูนย์จัดการโครงงาน')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@400;500;600;700&family=Prompt:wght@500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('public/css/dashboard.css') }}">

    <!-- สำหรับแทรก CSS เฉพาะหน้า -->
    @stack('styles')
</head>

<body>
    <div class="app">
        <!-- ดึง Sidebar มาแสดง -->
        @include('layouts.partials.sidebar')

        <div class="content">
            <!-- ดึง Topbar มาแสดง -->
            @include('layouts.partials.topbar')

            @yield('content')
        </div>
    </div>
    <script>
        window.calendarEventsUrl = "{{ url('/calendar/events') }}";
    </script>
    <script src="{{ asset('public/js/dashboard.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('scripts')
</body>

</html>
