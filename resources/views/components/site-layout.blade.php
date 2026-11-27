<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <title>
        @if($title)
            {{ $title }} | PINBOOK
        @else
            PINBOOK
        @endif
    </title>

    @fonts
    <link href="https://fonts.googleapis.com/css2?family=Fraunces:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles / Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link rel="stylesheet" href="{{ asset('css/pinbook.css') }}">
</head>
<body class="pinbook antialiased">

<div class="flex min-h-screen flex-col">
    <x-site-layout-header :menu="$menu" />

    <main class="mx-auto w-full max-w-6xl flex-1 px-6 py-10">
        {{ $slot }}
    </main>

    <x-site-layout-footer :menu="$menu" />
</div>

</body>
</html>
