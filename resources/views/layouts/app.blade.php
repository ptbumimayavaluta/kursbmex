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
            
            <!-- Actions (Ubah Password & Logout) -->
            <div class="flex items-center gap-3">
                <button type="button" onclick="openPasswordModal()" class="text-xs font-bold text-amber-400 hover:text-amber-300 border border-amber-500/30 px-3 py-1.5 rounded-lg bg-amber-950/30 flex items-center gap-1 transition">
                    <span>🔑</span> Ubah Password
                </button>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-xs font-bold text-red-400 hover:text-red-300 border border-red-500/30 px-3 py-1.5 rounded-lg bg-red-950/30 transition">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Alert Sukses -->
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-900/50 border border-green-500 text-green-300 rounded-xl font-bold flex items-center gap-2">
                <span>✅</span> {{ session('success') }}
            </div>
        @endif

        <!-- Alert Validation Error khusus Modal Password -->
        @if($errors->has('current_password') || $errors->has('password'))
            <div class="mb-6 p-4 bg-red-900/50 border border-red-500 text-red-300 rounded-xl font-bold flex items-center gap-2">
                <span>⚠️</span> Terjadi kesalahan saat mengubah password. Silakan coba lagi.
            </div>
        @endif

        <!-- Konten Halaman Dipanggil di Sini -->
        @yield('content')
    </main>

    <!-- MODAL UBAH PASSWORD -->
    <div id="passwordModal" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden">
        <div class="bg-[#0A1245] border-2 border-amber-500/40 w-full max-w-md rounded-2xl p-6 shadow-2xl relative">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-black text-amber-400 flex items-center gap-2">
                    <span>🔑</span> Ubah Password Admin
                </h3>
                <button onclick="closePasswordModal()" class="text-gray-400 hover:text-white font-bold text-xl">&times;</button>
            </div>

            <form action="{{ route('admin.password.update') }}" method="POST" class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-xs font-bold text-amber-300 mb-1">Password Saat Ini</label>
                    <input type="password" name="current_password" required class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none text-sm">
                    @error('current_password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-amber-300 mb-1">Password Baru</label>
                    <input type="password" name="password" required class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none text-sm">
                    @error('password')
                        <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-xs font-bold text-amber-300 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" required class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none text-sm">
                </div>

                <div class="flex justify-end gap-2 pt-3">
                    <button type="button" onclick="closePasswordModal()" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-gray-300 text-xs font-bold rounded-xl transition">
                        Batal
                    </button>
                    <button type="submit" class="px-5 py-2 bg-amber-400 hover:bg-amber-300 text-[#0A1245] text-xs font-black rounded-xl shadow transition">
                        Simpan Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openPasswordModal() {
            document.getElementById('passwordModal').classList.remove('hidden');
        }

        function closePasswordModal() {
            document.getElementById('passwordModal').classList.add('hidden');
        }

        // Buka modal otomatis jika ada error validasi password
        @if($errors->has('current_password') || $errors->has('password'))
            openPasswordModal();
        @endif
    </script>

</body>
</html>