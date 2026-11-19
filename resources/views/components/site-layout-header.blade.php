<header class="flex items-center justify-between bg-teal-700 px-10 py-4 text-white">
    <a href="{{ route('welcome') }}" class="text-lg font-bold tracking-widest text-white">PINBOOK</a>

    <nav class="flex gap-8">
        @foreach($menu as $label => $link)
            <a href="{{ $link }}" class="text-sm font-medium capitalize text-teal-100 hover:text-white">{{ $label }}</a>
        @endforeach
    </nav>

    <div class="text-sm">
        @auth
            {{ auth()->user()->name }}:
            <a href="{{ route('dashboard') }}" class="font-medium capitalize text-teal-100 hover:text-white">Dashboard</a>
        @else
            <a href="{{ route('login') }}" class="font-medium capitalize text-teal-100 hover:text-white">Login</a>
            -
            <a href="{{ route('register') }}" class="font-medium capitalize text-teal-100 hover:text-white">Register</a>
        @endauth
    </div>
</header>
