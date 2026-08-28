<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $company->name ?? 'BMEX Money Changer' }}</title>
    <link rel="icon" type="image/png" href="{{ asset('bmex.png') }}?v=1.0">
    <link rel="apple-touch-icon" href="{{ asset('bmex.png') }}?v=1.0">
    
    <!-- Tailwind CDN untuk memastikan CSS termuat sempurna -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#050B2E] text-white min-h-screen font-sans antialiased">

    <!-- Header Navy BMEX -->
    <header class="bg-[#0A1245] border-b-2 border-amber-400 sticky top-0 z-50 shadow-2xl">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex justify-between items-center">
            <div class="flex items-center gap-3">
                @if(isset($company->logo) && $company->logo)
                    <img src="{{ asset('storage/' . $company->logo) }}" alt="BMEX Logo" class="h-12 w-auto rounded border border-amber-400/40">
                @else
                    <div class="bg-amber-400 text-[#0A1245] font-black text-2xl px-3.5 py-1 rounded shadow-lg tracking-wider">BMEX</div>
                @endif
                <div>
                    <h1 class="text-xl md:text-2xl font-black text-amber-400 tracking-wider uppercase">
                        {{ $company->name ?? 'BMEX MONEY CHANGER' }}
                    </h1>
                    <p class="text-xs text-amber-200/80 font-medium hidden sm:block">
                        {{ $company->address ?? 'Authorized Money Changer' }}
                    </p>
                </div>
            </div>
            
            <div class="text-right bg-[#050B2E]/60 px-4 py-1.5 rounded-xl border border-amber-400/30">
                <div id="clock" class="text-xl md:text-2xl font-mono font-black text-amber-400">00:00:00</div>
                <div class="text-xs text-gray-300 font-medium">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</div>
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