<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>
        @if($title)
            {{ $title }} | PINBOOK
        @else
            PINBOOK
        @endif
    </title>

    @fonts
</head>
<body>

<div>
    <x-site-layout-header />

    <main>
        {{ $slot }}
    </main>

    <x-site-layout-footer />
</div>

</body>
</html>
