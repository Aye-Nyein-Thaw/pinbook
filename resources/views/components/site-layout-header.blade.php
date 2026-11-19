<header>
    <a href="{{ route('welcome') }}">PINBOOK</a>

    @foreach($menu as $label => $link)
        <a href="{{ $link }}">{{ $label }}</a>
    @endforeach

    <hr/>
</header>
