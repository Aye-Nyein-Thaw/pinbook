<footer class="site-footer text-sm">
    <div class="mx-auto max-w-6xl px-6 py-6">
        <nav class="flex gap-6">
            @foreach($menu as $label => $link)
                <a href="{{ $link }}" class="link capitalize">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="mt-4 flex items-center justify-between">
            <p>Pinbook, a travel journal</p>
            <p class="text-xs">PINBOOK &copy; {{ date('Y') }}</p>
        </div>
    </div>
</footer>
