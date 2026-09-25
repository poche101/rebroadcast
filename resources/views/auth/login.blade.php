<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign in — {{ config('app.name', 'The Gathering') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linen-50 flex items-center justify-center px-6">

    <div class="w-full max-w-md">
       <div class="flex flex-col items-center mb-10">
    <span class="flex items-center justify-center w-28 h-28 rounded-full bg-white ring-1 ring-stone-200 shadow-sm mb-5 overflow-hidden">
        <img src="{{ asset('images/celz5-logo.png') }}" alt="CE Lekki Zone 5" class="w-27 h-27 object-contain">
    </span>
    <h1 class="font-serif text-2xl text-stone-900">Welcome back</h1>
    <p class="mt-1 text-sm text-stone-500 text-center">Sign in to join the service, share prayer requests, and see who's here with you.</p>
</div>

        @if ($errors->any())
            <div class="mb-5 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="bg-white border border-stone-800/10 rounded-lg shadow-soft p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Email</label>
                <input type="email" name="email" required autofocus value="{{ old('email') }}"
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Password</label>
                <input type="password" name="password" required
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <label class="flex items-center gap-2 text-sm text-stone-600">
                <input type="checkbox" name="remember" class="rounded border-stone-800/25 text-gold-600 focus:ring-gold-500/40">
                Keep me signed in
            </label>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-navy-900 hover:bg-navy-800 text-linen-50 text-base font-medium rounded-md px-4 py-3 transition-colors">
                Sign in
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-stone-500">
            New here?
            <a href="{{ route('register') }}" class="text-gold-600 hover:underline">Create an account</a>
        </p>
    </div>
</body>
</html>
