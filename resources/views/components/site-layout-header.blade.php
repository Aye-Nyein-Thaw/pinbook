<header class="site-header">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-4 px-6 py-4">
        <a href="{{ route('welcome') }}" class="brand flex items-center gap-2">
            <x-breeze.application-logo class="h-6 w-6 fill-current" />
            Pinbook
        </a>

        <nav class="flex gap-8">
            @foreach($menu as $label => $link)
                <a href="{{ $link }}" class="text-sm font-medium capitalize">{{ $label }}</a>
            @endforeach
        </nav>

        <div class="text-sm">
            @auth
                {{ auth()->user()->name }}:
                <a href="{{ route('dashboard') }}" class="font-medium capitalize">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="font-medium capitalize">Login</a>
                -
                <a href="{{ route('register') }}" class="font-medium capitalize">Register</a>
            @endauth
        </div>
    </div>
</header>
