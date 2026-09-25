<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Worship With Us' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linen-50">

    <header class="border-b border-stone-800/10">
        <div class="max-w-5xl mx-auto px-6 py-5 flex items-center justify-between">
            <a href="{{ route('rebroadcast.show') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('images/celz5-logo.png') }}" alt="{{ config('app.name') }}" class="h-9 w-auto object-contain transition-transform duration-300 group-hover:scale-105">
                <span class="font-serif text-lg text-stone-900 tracking-tight">{{ config('app.name') }}</span>
            </a>

            <nav class="hidden sm:flex items-center gap-9 text-sm">
                <a href="#watch" class="relative text-stone-600 uppercase tracking-wider text-xs font-medium transition-colors duration-200 hover:text-navy-900 after:absolute after:-bottom-1.5 after:left-0 after:h-px after:w-0 after:bg-gold-500 after:transition-all after:duration-300 ease-out hover:after:w-full">
                    Watch
                </a>
                <a href="#give" class="relative text-stone-600 uppercase tracking-wider text-xs font-medium transition-colors duration-200 hover:text-navy-900 after:absolute after:-bottom-1.5 after:left-0 after:h-px after:w-0 after:bg-gold-500 after:transition-all after:duration-300 ease-out hover:after:w-full">
                    Give
                </a>

                @auth
                    <span class="h-4 w-px bg-stone-800/15"></span>

                    <span class="text-stone-500">{{ auth()->user()->name }}</span>

                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.rebroadcasts.index') }}"
                           class="inline-flex items-center gap-1 text-xs font-medium uppercase tracking-wide text-gold-600 border border-gold-500/40 rounded-full px-3 py-1 transition-all duration-200 hover:bg-gold-500/10 hover:border-gold-500/70">
                            Console
                        </a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="relative text-stone-500 transition-colors duration-200 hover:text-navy-900 after:absolute after:-bottom-1 after:left-0 after:h-px after:w-0 after:bg-stone-400 after:transition-all after:duration-300 hover:after:w-full">
                            Sign out
                        </button>
                    </form>
                @endauth
            </nav>
        </div>
    </header>

    <main>
        {{ $slot }}
    </main>

    <footer class="mt-24 border-t border-stone-800/10">
        <div class="max-w-5xl mx-auto px-6 py-10 flex flex-col sm:flex-row items-center justify-between gap-4 text-sm text-stone-600">
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Grace and peace to you.</p>
            <p class="font-serif italic text-stone-500">"Where two or three gather in my name, there am I with them."</p>
        </div>
    </footer>
</body>
</html>
