<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Judul Tab Browser -->
    <title>{{ $company->name ?? 'Bali Money Exchange' }} - Board Rate Valas</title>

    <!-- FAVICON LINK -->
    <link rel="icon" type="image/png" href="{{ asset('bmex.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('bmex.png') }}">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Tailwind CDN (Opsional jika Vite sudah dikonfigurasi) -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#050B2E] text-white min-h-screen font-sans antialiased">

    <!-- Top Admin Bar -->
    <header class="bg-[#0A1245] border-b border-amber-500/30 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <span class="font-black text-amber-400 text-xl tracking-wider">BMEX ADMIN</span>
                <nav class="flex gap-4">
                    <a href="{{ route('admin.currencies.index') }}" class="text-sm font-bold text-gray-200 hover:text-amber-400 transition">Kelola Kurs</a>
                    <a href="{{ route('admin.company.edit') }}" class="text-sm font-bold text-gray-200 hover:text-amber-400 transition">Profil Perusahaan</a>
                    <a href="{{ route('public.display') }}" target="_blank" class="text-sm font-bold text-amber-400 hover:underline flex items-center gap-1">
                        <span>🌐</span> Lihat Display Utama
                    </a>
                </nav>
            </div>
            
            <!-- User Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 border border-red-500/30 px-3 py-1.5 rounded-lg bg-red-950/30">
                    Logout
                </button>
            </form>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/50 border border-green-500 text-green-300 rounded-xl font-bold flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <!-- Konten Halaman Dipanggil di Sini -->
        @yield('content')
    </main>

</body>
</html>