<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Worship With Us' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linen-50" x-data="{ mobileOpen: false }">

    <header class="border-b border-stone-800/10 relative">
        <div class="max-w-5xl mx-auto px-6 py-5 flex items-center justify-between">
            <a href="{{ route('rebroadcast.show') }}" class="flex items-center gap-2.5">
                <img src="{{ asset('images/celz5-logo.png') }}" alt="{{ config('app.name') }}" class="h-10 w-10 rounded-full object-contain bg-white">
                <span class="font-serif text-lg text-stone-900 tracking-tight">{{ config('app.name') }}</span>
            </a>

            {{-- Desktop: sign out only --}}
            @auth
                <form method="POST" action="{{ route('logout') }}" class="hidden sm:block">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 border border-stone-800/15 hover:bg-stone-800/5 text-stone-700 text-sm font-medium rounded-md px-4 py-2 transition-colors">
                        <x-icon name="arrow-right" class="w-4 h-4 rotate-180" />
                        Sign out
                    </button>
                </form>
            @endauth

            {{-- Mobile toggle button --}}
            @auth
                <button @click="mobileOpen = !mobileOpen" class="sm:hidden p-2 -mr-2 text-stone-700" aria-label="Toggle menu">
                    <x-icon x-show="!mobileOpen" name="menu" class="w-6 h-6" />
                    <x-icon x-show="mobileOpen" x-cloak name="plus" class="w-6 h-6 rotate-45" />
                </button>
            @endauth
        </div>

        {{-- Mobile dropdown panel: sign out only --}}
        @auth
            <div x-show="mobileOpen" x-cloak @click.away="mobileOpen = false" class="sm:hidden border-t border-stone-800/10 bg-linen-50 px-6 py-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full inline-flex items-center justify-center gap-2 border border-stone-800/15 hover:bg-stone-800/5 text-stone-700 text-sm font-medium rounded-md px-4 py-2.5 transition-colors">
                        <x-icon name="arrow-right" class="w-4 h-4 rotate-180" />
                        Sign out
                    </button>
                </form>
            </div>
        @endauth
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-stone-800/10">
        <div class="max-w-5xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-stone-600">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}.</p>
            <p class="font-serif italic text-stone-500">"Where two or three gather in my name, there am I with them."</p>
        </div>
    </footer>
</body>
</html>
