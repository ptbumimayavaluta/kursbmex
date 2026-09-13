<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'BMEX Admin') }} - Login Portal</title>

        <!-- FAVICON (LOGO TAB BROWSER) -->
        <link rel="icon" type="image/png" href="{{ asset('bmex.png') }}">
        <link rel="apple-touch-icon" href="{{ asset('bmex.png') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts & Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://cdn.tailwindcss.com"></script>
    </head>
    <body class="font-sans antialiased bg-[#050B2E] text-white selection:bg-amber-500 selection:text-black">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <!-- Logo Header Form -->
            <div class="mb-4 text-center">
                <a href="/" class="inline-flex flex-col items-center gap-2 group">
                    <img src="{{ asset('bmex.png') }}" alt="BMEX Logo" class="w-16 h-16 object-contain drop-shadow-md transition group-hover:scale-105" onerror="this.style.display='none'">
                    <span class="font-black text-2xl text-amber-400 tracking-wider">BMEX ADMIN</span>
                </a>
            </div>

            <!-- Card Box Login -->
            <div class="w-full sm:max-w-md mt-2 px-6 py-8 bg-[#0A1245] border border-amber-500/20 shadow-2xl rounded-2xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>