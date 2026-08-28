@extends('layouts.app')

@section('content')
<div class="space-y-8">

    <!-- Header & Tombol Tambah Mata Uang -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-2xl font-black text-amber-400">Pengaturan Kurs Mata Uang</h1>
            <p class="text-xs text-gray-400">Perbarui nilai beli, jual, dan bendera secara langsung.</p>
        </div>
        
        <!-- Tombol Toggle Form Tambah -->
        <button onclick="toggleAddForm()" class="bg-amber-400 hover:bg-amber-300 text-[#0A1245] font-black px-5 py-2.5 rounded-xl shadow-lg transition flex items-center gap-2 text-sm">
            <span>➕</span> Tambah Mata Uang
        </button>
    </div>

    <!-- FORM TAMBAH MATA UANG BARU (Tersembunyi secara default) -->
    <div id="addCurrencyForm" class="hidden bg-[#0A1245] border-2 border-amber-400/50 rounded-2xl p-6 shadow-2xl transition-all">
        <h2 class="text-lg font-black text-amber-400 mb-4 flex items-center gap-2">
            <span>✨</span> Tambah Mata Uang Baru
        </h2>
        <form action="{{ route('admin.currencies.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-6 gap-4 items-end">
            @csrf
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Kode Valas</label>
                <input type="text" name="code" placeholder="USD" required class="w-full bg-[#050B2E] border border-slate-700 text-amber-400 font-black rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none uppercase">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Nama Mata Uang</label>
                <input type="text" name="name" placeholder="US Dollar" required class="w-full bg-[#050B2E] border border-slate-700 text-white font-semibold rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">We Buy (Beli)</label>
                <input type="number" name="buy_rate" placeholder="15000" required class="w-full bg-[#050B2E] border border-slate-700 text-green-400 font-mono font-bold rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">We Sell (Jual)</label>
                <input type="number" name="sell_rate" placeholder="15200" required class="w-full bg-[#050B2E] border border-slate-700 text-amber-400 font-mono font-bold rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Kode Bendera (ISO)</label>
                <input type="text" name="flag" placeholder="us" class="w-full bg-[#050B2E] border border-slate-700 text-gray-300 font-mono rounded-xl p-2.5 focus:ring-2 focus:ring-amber-400 focus:outline-none lowercase">
            </div>
            <div class="flex gap-2">
                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 text-white font-bold p-2.5 rounded-xl shadow transition">
                    Simpan
                </button>
                <button type="button" onclick="toggleAddForm()" class="bg-slate-700 hover:bg-slate-600 text-gray-300 font-bold px-3 py-2.5 rounded-xl shadow transition">
                    Batal
                </button>
            </div>
        </form>
    </div>

    <!-- TABEL KURS + FORM UPDATE MASSAL -->
    <form action="{{ route('admin.currencies.updateAll') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="bg-[#0A1245] border border-amber-500/30 rounded-2xl shadow-2xl overflow-hidden mb-6">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-amber-400 text-[#0A1245] text-sm font-black uppercase">
                        <th class="py-3 px-4 text-center w-16">Flag</th>
                        <th class="py-3 px-4 w-24">Valas</th>
                        <th class="py-3 px-4">Nama Mata Uang</th>
                        <th class="py-3 px-4">We Buy (Beli)</th>
                        <th class="py-3 px-4">We Sell (Jual)</th>
                        <th class="py-3 px-4 text-center w-32">Kode Flag</th>
                        <th class="py-3 px-4 text-center w-20">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800 text-sm bg-[#0A1245]">
                    @foreach($currencies as $currency)
                    <tr class="hover:bg-slate-900/50">
                        <!-- Flag Preview -->
                        <td class="py-3 px-4 text-center">
                            @if($currency->flag)
                                <img src="https://flagcdn.com/w80/{{ strtolower($currency->flag) }}.png" class="w-8 h-auto rounded inline-block border border-amber-400/30" alt="{{ $currency->code }}">
                            @else
                                <span class="text-xs text-gray-500">🌐</span>
                            @endif
                        </td>
                        
                        <!-- Kode Valas -->
                        <td class="py-3 px-4 text-amber-400 font-black text-base">{{ $currency->code }}</td>
                        
                        <!-- Nama Valas -->
                        <td class="py-3 px-4 text-gray-200 font-semibold">{{ $currency->name }}</td>
                        
                        <!-- Input Rate Buy -->
                        <td class="py-3 px-4">
                            <input type="number" step="any" name="currencies[{{ $currency->id }}][buy_rate]" value="{{ old('currencies.'.$currency->id.'.buy_rate', $currency->buy_rate) }}" class="w-full bg-[#050B2E] border border-slate-700 text-green-400 font-mono font-bold rounded-lg p-2 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                        </td>
                        
                        <!-- Input Rate Sell -->
                        <td class="py-3 px-4">
                            <input type="number" step="any" name="currencies[{{ $currency->id }}][sell_rate]" value="{{ old('currencies.'.$currency->id.'.sell_rate', $currency->sell_rate) }}" class="w-full bg-[#050B2E] border border-slate-700 text-amber-400 font-mono font-bold rounded-lg p-2 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                        </td>
                        
                        <!-- Input Kode Flag -->
                        <td class="py-3 px-4">
                            <input type="text" name="currencies[{{ $currency->id }}][flag]" value="{{ old('currencies.'.$currency->id.'.flag', $currency->flag) }}" placeholder="us, sg..." class="w-full bg-[#050B2E] border border-slate-700 text-gray-300 font-mono text-center rounded-lg p-2 focus:ring-2 focus:ring-amber-400 focus:outline-none lowercase">
                        </td>

                        <!-- Tombol Hapus -->
                        <td class="py-3 px-4 text-center">
                            <button type="button" onclick="deleteCurrency('{{ $currency->id }}', '{{ $currency->code }}')" class="p-2 bg-red-950/50 hover:bg-red-900 border border-red-500/40 text-red-400 rounded-lg transition" title="Hapus {{ $currency->code }}">
                                🗑️
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-amber-400 hover:bg-amber-300 text-[#0A1245] font-black px-8 py-3 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                <span>💾</span> SIMPAN SEMUA KURS
            </button>
        </div>
    </form>
</div>

<!-- FORM HAPUS (Hidden Trigger) -->
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<script>
    // Toggle Form Tambah Mata Uang
    function toggleAddForm() {
        const form = document.getElementById('addCurrencyForm');
        form.classList.toggle('hidden');
    }

    // Konfirmasi & Eksekusi Hapus Mata Uang
    function deleteCurrency(id, code) {
        if (confirm(`Apakah Anda yakin ingin menghapus mata uang ${code}?`)) {
            const form = document.getElementById('deleteForm');
            form.action = `/admin/currencies/${id}`;
            form.submit();
        }
    }
</script>
@endsection