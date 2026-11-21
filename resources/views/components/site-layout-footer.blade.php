<footer class="border-t border-teal-200 bg-teal-100 px-10 py-6 text-sm text-teal-900">
    <nav class="flex gap-6">
        @foreach($menu as $label => $link)
            <a href="{{ $link }}" class="font-medium capitalize text-teal-800 hover:underline">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="mt-4 flex items-center justify-between">
        <p>Pinbook, a travel journal</p>
        <p class="text-xs text-teal-700">PINBOOK &copy; {{ date('Y') }}</p>
    </div>
</footer>
