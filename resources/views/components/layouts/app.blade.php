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
            <a href="{{ route('rebroadcast.show') }}" class="flex items-center gap-2.5">
                <span class="flex items-center justify-center w-12 h-12 rounded-full bg-white-900 text-linen-50">
                    <img src="/images/celz5-logo.png" alt="logo">
                </span>
                <span class="font-serif text-lg text-stone-900 tracking-tight">{{ config('app.name', 'The Gathering') }}</span>
            </a>
            <nav class="hidden sm:flex items-center gap-8 text-sm text-stone-700">
                <a href="#watch" class="hover:text-stone-900 transition-colors">Watch</a>
                <a href="#give" class="hover:text-stone-900 transition-colors">Give</a>
                @auth
                    <span class="text-stone-400">&middot;</span>
                    <span class="text-stone-500">{{ auth()->user()->name }}</span>
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.rebroadcasts.index') }}" class="text-gold-600 hover:underline">Console</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="hover:text-stone-900 transition-colors">Sign out</button>
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
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'The Gathering') }}.</p>
            <p class="font-serif italic text-stone-500">"Where two or three gather in my name, there am I with them."</p>
        </div>
    </footer>
</body>
</html>
