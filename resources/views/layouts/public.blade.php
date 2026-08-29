<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name ?? 'Bali Money Exchange' }}</title>

    <!-- Theme Color untuk Navbar Browser Android -->
    <meta name="theme-color" content="#0A1245">
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Favicon & Icon Android/Apple -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('bmex.png') }}?v=3.0">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('bmex.png') }}?v=3.0">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('bmex.png') }}?v=3.0">

    <!-- Web App Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}?v=3.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Tailwind CDN untuk memastikan CSS termuat sempurna -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#050B2E] text-white min-h-screen font-sans antialiased">

    <!-- Header Navy BMEX -->
    <header class="bg-[#0A1245] border-b border-amber-500/30 py-3 px-4 shadow-lg">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-center sm:text-left">
            <!-- Logo / Nama Perusahaan -->
            <div class="flex items-center gap-2">
                <img src="{{ asset('bmex.png') }}" class="w-8 h-8 sm:w-10 sm:h-10 object-contain" alt="Logo">
                <h1 class="text-base sm:text-xl md:text-2xl font-black text-amber-400 tracking-wide">
                    {{ $company->name ?? 'BALI MONEY EXCHANGE' }}
                </h1>
            </div>

            <!-- Waktu Realtime -->
            <div class="text-xs sm:text-sm font-mono font-bold text-gray-300 bg-[#050B2E] px-3 py-1.5 rounded-lg border border-amber-500/20">
                🕒 <span id="realtime-clock">--:--:--</span> WITA
            </div>
        </div>
    </header>

    <!-- Content Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
        function updateClock() {
            const now = new Date();
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('clock').textContent = `${hours}:${minutes}:${seconds}`;
        }
        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>