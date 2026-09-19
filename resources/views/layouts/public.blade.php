<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name ?? 'Bali Money Exchange' }} - Board Rate</title>
    
    <!-- FAVICON -->
    <link rel="icon" type="image/png" href="{{ asset('bmex.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('bmex.png') }}">

    <!-- MANIFEST & PWA CONFIG (TAMBAHKAN INI) -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0A1245">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- REGISTER SERVICE WORKER (TAMBAHKAN INI) -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</head>
<body class="bg-[#050B2E] text-white min-h-screen font-sans antialiased flex flex-col justify-between">

    <header class="bg-[#0A1245] border-b-2 border-amber-400 py-4 px-4 flex flex-col items-center text-center shadow-2xl gap-3">
        
        <!-- 1. LOGO BMEX -->
        <div>
            <img src="{{ asset('bmex.png') }}" alt="BMEX Logo" class="h-16 sm:h-20 w-auto object-contain drop-shadow mx-auto">
        </div>

        <!-- 2. TEKS NAMA & AUTHORIZED -->
        <div class="flex flex-col items-center">
            <h1 class="text-xl sm:text-3xl md:text-4xl font-black text-amber-400 tracking-wider leading-none">
                BALI MONEY EXCHANGE
            </h1>
            <span class="text-xs sm:text-sm md:text-base font-bold text-gray-300 tracking-widest uppercase mt-1">
                AUTHORIZED
            </span>
        </div>

        <!-- 3. TANGGAL & WAKTU (REALTIME) -->
        <div class="bg-[#050B2E] border border-amber-400/40 px-5 py-2 rounded-2xl text-center shadow-inner mt-1">
            <div id="liveClock" class="text-xl sm:text-3xl font-black text-amber-400 font-mono tracking-wider">
                00:00:00
            </div>
            <div id="liveDate" class="text-xs sm:text-sm font-semibold text-gray-300">
                Loading date...
            </div>
        </div>

        <!-- 4. INFO LAST UPDATE (SUDAH ADA NAMA HARI) -->
        @php
            $lastUpdated = \App\Models\Currency::max('updated_at');
        @endphp
        <div class="bg-[#050B2E] px-3 py-1 rounded-full border border-amber-400/30 text-amber-300 font-mono text-[11px] flex items-center gap-1.5 shadow-inner mt-1">
            <span class="animate-pulse">🔄</span> Last Update: 
            <span class="text-white font-bold">
                {{ $lastUpdated ? \Carbon\Carbon::parse($lastUpdated)->setTimezone('Asia/Makassar')->translatedFormat('l, d M Y - H:i:s') : '-' }} WITA
            </span>
        </div>

    </header>

    <!-- KONTEN UTAMA -->
    <main class="flex-grow py-4 sm:py-6">
        @yield('content')
    </main>

    <!-- SCRIPT JAM REALTIME -->
    <script>
        function updateClock() {
            const now = new Date();
            
            // Format Jam (HH:MM:SS)
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            document.getElementById('liveClock').textContent = `${hours}:${minutes}:${seconds}`;

            // Format Tanggal
            const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
            document.getElementById('liveDate').textContent = now.toLocaleDateString('en-US', options);
        }

        setInterval(updateClock, 1000);
        updateClock();
    </script>
</body>
</html>