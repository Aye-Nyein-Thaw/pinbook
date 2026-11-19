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
    <div>
        <a href="{{ route('welcome') }}">PINBOOK</a>
        <hr/>
    </div>

    <main>
        {{ $slot }}
    </main>

    <div>
        <hr/>
        Pinbook, a travel journal
    </div>
</div>

</body>
</html>
