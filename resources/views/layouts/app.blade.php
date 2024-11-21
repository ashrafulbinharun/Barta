<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    {{-- fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />

    <title> @yield('title') | {{ env('APP_NAME', 'Barta') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-100">
    @include('layouts.partials.navbar', ['user' => auth()->user()])

    <main class="container max-w-xl min-h-screen px-2 mx-auto mt-8 space-y-6 md:px-0">
        @include('layouts.partials.session-message')
        @yield('content')
    </main>

    @include('layouts.partials.footer')
    @stack('scripts')
</body>

</html>
