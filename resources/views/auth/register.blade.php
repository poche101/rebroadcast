<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account — {{ config('app.name', 'The Gathering') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-linen-50 flex items-center justify-center px-6">

    <div class="w-full max-w-md">
        <div class="flex flex-col items-center mb-10">
            <span class="flex items-center justify-center w-35 h-35 rounded-full bg-white ring-1 ring-stone-200 shadow-sm mb-5 overflow-hidden">
                <img src="{{ asset('images/celz5-logo.png') }}" alt="CE Lekki Zone 5" class="w-36 h-36 object-contain">
            </span>
            <h1 class="font-serif text-2xl text-stone-900">Join us</h1>
            <p class="mt-1 text-sm text-stone-500 text-center">Create an account to access services, notes, and prayer.</p>
        </div>

        @if ($errors->any())
            <div class="mb-5 rounded-md bg-red-50 border border-red-200 px-4 py-3 text-sm text-red-700">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}" class="bg-white border border-stone-800/10 rounded-lg shadow-soft p-8 space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Full name</label>
                <input type="text" name="name" required autofocus value="{{ old('name') }}"
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Email</label>
                <input type="email" name="email" required value="{{ old('email') }}"
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Password</label>
                <input type="password" name="password" required
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <div>
                <label class="block text-sm font-medium text-stone-800 mb-1.5">Confirm password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full text-base rounded-md border border-stone-200 focus:border-gold-500 focus:ring-gold-500/30 px-4 py-3">
            </div>
            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 bg-navy-900 hover:bg-navy-800 text-linen-50 text-base font-medium rounded-md px-4 py-3 transition-colors">
                Create account
            </button>
        </form>

        <p class="mt-6 text-center text-sm text-stone-500">
            Already have an account?
            <a href="{{ route('login') }}" class="text-gold-600 hover:underline">Sign in</a>
        </p>
    </div>
</body>
</html>
