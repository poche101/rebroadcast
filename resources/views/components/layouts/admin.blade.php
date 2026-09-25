<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Media Console' }} — Admin</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linen-100" x-data="{ nav: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="hidden lg:flex lg:flex-col w-64 shrink-0 bg-navy-900 text-linen-100">
            <div class="px-6 py-6 flex items-center gap-2.5 border-b border-white/10">
                <span class="flex items-center justify-center w-8 h-8 rounded-full bg-gold-500 text-stone-900">
                    <x-icon name="cross" class="w-4 h-4" />
                </span>
                <span class="font-serif text-base tracking-tight">Media Console</span>
            </div>
            <nav class="flex-1 px-3 py-5 space-y-1 text-sm">
                <a href="{{ route('admin.rebroadcasts.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.rebroadcasts.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                    <x-icon name="video-camera" class="w-4.5 h-4.5" />
                    Rebroadcasts
                </a>
                <a href="{{ route('admin.prayer-requests.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.prayer-requests.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                    <x-icon name="inbox" class="w-4.5 h-4.5" />
                    Prayer requests
                </a>
                <a href="{{ route('admin.comments.index') }}"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md transition-colors {{ request()->routeIs('admin.comments.*') ? 'bg-white/10 text-white' : 'text-stone-300 hover:bg-white/5 hover:text-white' }}">
                    <x-icon name="book-open" class="w-4.5 h-4.5" />
                    Comments
                </a>
                <a href="{{ route('rebroadcast.show') }}" target="_blank"
                   class="flex items-center gap-3 px-3 py-2.5 rounded-md text-stone-300 hover:bg-white/5 hover:text-white transition-colors">
                    <x-icon name="arrow-right" class="w-4.5 h-4.5" />
                    View live site
                </a>
            </nav>
            <div class="px-6 py-5 border-t border-white/10 flex items-center justify-between text-sm text-stone-300">
                <span class="flex items-center gap-2.5">
                    <x-icon name="user-circle" class="w-5 h-5" />
                    {{ auth()->user()->name ?? 'Media Team' }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-stone-400 hover:text-white text-xs">Sign out</button>
                </form>
            </div>
        </aside>

        {{-- Mobile topbar --}}
        <div class="lg:hidden fixed top-0 inset-x-0 z-20 bg-navy-900 text-white flex items-center justify-between px-4 py-3.5">
            <span class="font-serif">Media Console</span>
            <button @click="nav = !nav"><x-icon name="menu" class="w-5 h-5" /></button>
        </div>
        <div x-show="nav" x-cloak @click.away="nav = false" class="lg:hidden fixed top-12 inset-x-0 z-20 bg-navy-900 text-white px-4 py-3 space-y-1 text-sm">
            <a href="{{ route('admin.rebroadcasts.index') }}" class="block py-2">Rebroadcasts</a>
            <a href="{{ route('admin.prayer-requests.index') }}" class="block py-2">Prayer requests</a>
            <a href="{{ route('admin.comments.index') }}" class="block py-2">Comments</a>
        </div>

        {{-- Main content --}}
        <div class="flex-1 min-w-0">
            <header class="bg-white/70 border-b border-stone-800/10 px-6 sm:px-10 py-6 mt-12 lg:mt-0">
                <h1 class="font-serif text-2xl text-stone-900">{{ $title ?? 'Dashboard' }}</h1>
                @isset($subtitle)
                    <p class="mt-1 text-sm text-stone-500">{{ $subtitle }}</p>
                @endisset
            </header>

            @if (session('status'))
                <div class="mx-6 sm:mx-10 mt-6 flex items-center gap-2.5 rounded-md bg-olive-500/10 border border-olive-500/20 px-4 py-3 text-sm text-olive-700">
                    <x-icon name="check" class="w-4 h-4" />
                    {{ session('status') }}
                </div>
            @endif

            <main class="px-6 sm:px-10 py-8">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
