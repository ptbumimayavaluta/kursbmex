@extends('layouts.public')

@section('content')
<meta http-equiv="refresh" content="30">

<div class="space-y-4 md:space-y-8 max-w-full overflow-hidden px-1 sm:px-4">

    <!-- 1. TAMPILAN KURS (PALING ATAS) -->
    <section>
        <div class="bg-[#0A1245] rounded-xl md:rounded-2xl border border-amber-500/50 shadow-2xl overflow-hidden">
            
            <!-- Tampilan Desktop (Tabel) -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-amber-400 text-[#0A1245] text-xs sm:text-base md:text-xl font-black uppercase tracking-wider border-b-2 border-amber-500">
                            <th class="py-3 px-2 sm:px-4 md:px-8 text-center w-12 sm:w-20">Flag</th>
                            <th class="py-3 px-2 sm:px-4 md:px-8">Valas</th>
                            <th class="py-3 px-2 sm:px-4 md:px-8 hidden sm:table-cell">Mata Uang</th>
                            <th class="py-3 px-2 sm:px-4 md:px-8 text-right">We Buy</th>
                            <th class="py-3 px-2 sm:px-4 md:px-8 text-right">We Sell</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-800/80 text-sm sm:text-lg md:text-2xl font-bold bg-[#0A1245]">
                        @foreach($currencies as $currency)
                        <tr class="hover:bg-[#121B5E] transition">
                            <td class="py-3 md:py-5 px-2 sm:px-4 md:px-8 text-center">
                                @if($currency->flag)
                                    <img src="https://flagcdn.com/w80/{{ strtolower($currency->flag) }}.png" class="w-7 sm:w-9 md:w-12 h-auto rounded inline-block shadow-md border border-amber-500/30" alt="{{ $currency->code }}">
                                @else
                                    <span class="text-xs text-gray-400">🌐</span>
                                @endif
                            </td>
                            <td class="py-3 md:py-5 px-2 sm:px-4 md:px-8 text-amber-400 font-black text-base sm:text-xl md:text-3xl tracking-wide whitespace-nowrap">
                                {{ $currency->code }}
                                <span class="block sm:hidden text-[10px] font-normal text-gray-300 truncate max-w-[80px]">{{ $currency->name }}</span>
                            </td>
                            <td class="py-3 md:py-5 px-2 sm:px-4 md:px-8 text-gray-100 text-base md:text-xl font-semibold hidden sm:table-cell">{{ $currency->name }}</td>
                            <td class="py-3 md:py-5 px-2 sm:px-4 md:px-8 text-right text-green-400 font-mono font-black text-sm sm:text-xl md:text-3xl whitespace-nowrap">
                                {{ number_format($currency->buy_rate, 0, ',', '.') }}
                            </td>
                            <td class="py-3 md:py-5 px-2 sm:px-4 md:px-8 text-right text-amber-400 font-mono font-black text-sm sm:text-xl md:text-3xl whitespace-nowrap">
                                {{ number_format($currency->sell_rate, 0, ',', '.') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </section>

    <!-- 2. RUNNING TEXT (DI BAWAH KURS) -->
    @if($company && $company->running_text)
    <section>
        <div class="bg-[#0A1245] border border-amber-500/40 rounded-xl p-2.5 sm:p-3 shadow-xl overflow-hidden">
            <marquee class="text-sm sm:text-base md:text-xl text-amber-400 font-extrabold tracking-wider">
                📢 {{ $company->running_text }}
            </marquee>
        </div>
    </section>
    @endif

    <!-- 3. KALKULATOR CONVERTER -->
    <section class="bg-[#0A1245] border border-amber-500/30 rounded-2xl p-4 sm:p-6 md:p-8 shadow-2xl">
        <h2 class="text-lg sm:text-xl md:text-2xl font-black text-amber-400 mb-4 sm:mb-6 flex items-center gap-2">
            <span>🧮</span> Kalkulator Konversi Valas
        </h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4 items-center">
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">Jenis Transaksi</label>
                <select id="calc_type" onchange="calculate()" class="w-full bg-[#050B2E] border border-amber-500/40 text-amber-400 text-sm font-bold rounded-xl p-2.5 sm:p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    <option value="buy">Tukar Valas ke IDR (We Buy)</option>
                    <option value="sell">Beli Valas dari Toko (We Sell)</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">Pilih Mata Uang</label>
                <select id="calc_currency" onchange="calculate()" class="w-full bg-[#050B2E] border border-amber-500/40 text-white text-sm font-bold rounded-xl p-2.5 sm:p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
                    @foreach($currencies as $currency)
                        <option value="{{ $currency->id }}" data-buy="{{ $currency->buy_rate }}" data-sell="{{ $currency->sell_rate }}">
                            {{ $currency->code }} - {{ $currency->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">Jumlah Valas</label>
                <input type="number" id="calc_amount" value="0" oninput="calculate()" class="w-full bg-[#050B2E] border border-amber-500/40 text-white font-mono text-sm font-bold rounded-xl p-2.5 sm:p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1.5">Estimasi Total Rupiah (IDR)</label>
                <div id="calc_result" class="bg-[#050B2E] border border-amber-400 text-amber-400 font-mono font-black text-lg sm:text-xl rounded-xl p-2.5 sm:p-3 text-right shadow-inner">
                    Rp 0
                </div>
            </div>
        </div>
    </section>

    <!-- 4. PROFIL PERUSAHAAN, KONTAK & MAPS -->
    <section class="bg-[#0A1245] border border-amber-500/30 rounded-2xl p-4 sm:p-6 md:p-8 shadow-2xl space-y-6 sm:space-y-8">
        
        <!-- Informasi Toko -->
        <div class="space-y-4">
            <div>
                <h2 class="text-lg sm:text-xl md:text-2xl font-black text-amber-400 flex items-center gap-2">
                    <span>🏢</span> {{ $company->name ?? 'Bali Money Exchange' }}
                </h2>
                <p class="text-gray-200 text-xs sm:text-sm mt-2 leading-relaxed">
                    {{ $company->description ?? 'Layanan penukaran mata uang asing resmi dan terpercaya dengan nilai tukar terbaik.' }}
                </p>
            </div>

            <!-- Detail Alamat & Kontak -->
            <div class="space-y-2 text-xs sm:text-sm text-gray-200 font-semibold pt-2 border-t border-slate-800">
                @if(!empty($company->address))
                <div class="flex items-start gap-2.5">
                    <span class="text-amber-400 font-bold shrink-0">📍</span>
                    <span class="break-words">{{ $company->address }}</span>
                </div>
                @endif

                @if(!empty($company->phone))
                <div class="flex items-center gap-2.5">
                    <span class="text-amber-400 font-bold shrink-0">📞</span>
                    <span>{{ $company->phone }}</span>
                </div>
                @endif

                @if(!empty($company->email))
                <div class="flex items-center gap-2.5">
                    <span class="text-amber-400 font-bold shrink-0">✉️</span>
                    <span class="break-all">{{ $company->email }}</span>
                </div>
                @endif
            </div>
        </div>

        <hr class="border-slate-800">

        <!-- Tombol Kontak -->
        <div class="space-y-3">
            <h3 class="text-base sm:text-lg font-bold text-amber-400">Contact Us</h3>
            <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-2.5 sm:gap-3">
                @if($company && $company->whatsapp)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <span>💬</span> WhatsApp
                </a>
                @endif

                @if($company && $company->google_maps_link)
                <a href="{{ $company->google_maps_link }}" target="_blank" class="bg-blue-600 hover:bg-blue-500 text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <span>🗺️</span> Maps
                </a>
                @endif

                @if($company && $company->instagram)
                <a href="{{ $company->instagram }}" target="_blank" class="bg-pink-600 hover:bg-pink-500 text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <span>📸</span> Instagram
                </a>
                @endif

                @if($company && $company->facebook)
                <a href="{{ $company->facebook }}" target="_blank" class="bg-indigo-600 hover:bg-indigo-500 text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <span>👍</span> Facebook
                </a>
                @endif
            </div>
        </div>

        <!-- Google Maps Embed -->
        <div class="pt-4 border-t border-slate-800 space-y-3">
            <h3 class="text-xs sm:text-sm font-bold text-amber-400 flex items-center gap-2">
                <span>📍</span> Our Location on Google Maps
            </h3>
            <div class="w-full h-48 sm:h-64 md:h-80 rounded-xl overflow-hidden border border-amber-500/20 shadow-inner">
                <iframe 
                    class="w-full h-full border-0"
                    loading="lazy"
                    allowfullscreen
                    referrerpolicy="no-referrer-when-downgrade"
                    src="https://maps.google.com/maps?q={{ urlencode($company->address ?? 'Bali Money Exchange') }}&t=&z=15&ie=UTF8&iwloc=&output=embed">
                </iframe>
            </div>
        </div>
    </section>

</div>

<script>
    function calculate() {
        const type = document.getElementById('calc_type').value;
        const select = document.getElementById('calc_currency');
        const selectedOption = select.options[select.selectedIndex];
        const amount = parseFloat(document.getElementById('calc_amount').value) || 0;

        const rate = type === 'buy' 
            ? parseFloat(selectedOption.getAttribute('data-buy')) 
            : parseFloat(selectedOption.getAttribute('data-sell'));

        const total = amount * rate;
        document.getElementById('calc_result').textContent = 'Rp ' + total.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', calculate);
</script>
@endsection