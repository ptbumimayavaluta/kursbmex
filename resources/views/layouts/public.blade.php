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
    <header class="bg-[#0A1245] border-b-2 border-amber-500 py-2.5 px-3 sm:px-6 shadow-xl">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2.5 sm:gap-4">
            
            <!-- SISI KIRI: LOGO & NAMA TOKO -->
            <div class="flex items-center justify-center sm:justify-start gap-2.5 sm:gap-4 w-full sm:w-auto">
                <!-- Box Logo BMEX -->
                <div class="bg-amber-400 text-[#0A1245] font-black text-lg sm:text-2xl px-3 py-1.5 rounded-xl shadow-md tracking-wider shrink-0">
                    BMEX
                </div>
                
                <!-- Nama Perusahaan -->
                <h1 class="text-amber-400 font-black text-base sm:text-2xl md:text-3xl tracking-wide uppercase leading-tight text-center sm:text-left">
                    BALI MONEY EXCHANGE
                </h1>
            </div>

            <!-- SISI KANAN: WAKTU & TANGGAL REALTIME -->
            <div class="bg-[#050B2E] border border-amber-500/40 rounded-xl px-4 py-1.5 text-center min-w-[150px] sm:min-w-[200px] shadow-inner">
                <div id="header-realtime-time" class="text-amber-400 font-mono font-black text-lg sm:text-2xl tracking-wider leading-none">
                    00:00:00
                </div>
                <div id="header-realtime-date" class="text-gray-200 font-bold text-[11px] sm:text-xs mt-1">
                    --
                </div>
            </div>

        </div>
    </header>

    <!-- Content Utama -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <script>
        function updateHeaderClock() {
            const now = new Date();
            
            // Format Waktu Realtime (HH:MM:SS)
            const hours = String(now.getHours()).padStart(2, '0');
            const minutes = String(now.getMinutes()).padStart(2, '0');
            const seconds = String(now.getSeconds()).padStart(2, '0');
            const timeString = `${hours}:${minutes}:${seconds}`;

            // Format Tanggal Realtime (contoh: Saturday, 29 August 2026)
            const options = { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' };
            const dateString = now.toLocaleDateString('en-US', options);

            // Update Elemen HTML
            const timeElement = document.getElementById('header-realtime-time');
            const dateElement = document.getElementById('header-realtime-date');

            if (timeElement) timeElement.textContent = timeString;
            if (dateElement) dateElement.textContent = dateString;
        }

        // Jalankan setiap 1 detik (1000ms)
        setInterval(updateHeaderClock, 1000);

        // Jalankan pertama kali saat halaman dimuat
        document.addEventListener('DOMContentLoaded', updateHeaderClock);
    </script>
</body>
</html>