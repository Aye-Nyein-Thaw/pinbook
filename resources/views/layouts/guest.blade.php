<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
            @vite(['resources/css/app.css', 'resources/js/app.js'])
        @else
            <!-- Tailwind CSS & Alpine.js via CDN -->
            <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
            <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.15.1/dist/cdn.min.js"></script>
        @endif

        <!-- Pinbook theme -->
        <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/pinbook.css') }}">
    </head>
    <body class="pinbook antialiased">
        <div class="auth-page">
            <div class="auth-photo">
                <p class="photo-credit">Photo: Oia sunset by TomasEE, CC BY 3.0, Wikimedia Commons</p>
            </div>

            <div class="auth-form">
                <a href="/" class="auth-logo">
                    <x-breeze.application-logo />
                    <h1>Pinbook</h1>
                </a>

                <div class="card">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
