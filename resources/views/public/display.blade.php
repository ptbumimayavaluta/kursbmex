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
                            <th class="py-3 px-2 sm:px-4 md:px-8">Currencies</th>
                            <th class="py-3 px-2 sm:px-4 md:px-8 hidden sm:table-cell"></th>
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
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $company->whatsapp) }}" target="_blank" class="bg-[#25D366] hover:bg-[#1EBE5D] text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <!-- SVG WhatsApp -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                    </svg>
                    <span>WhatsApp</span>
                </a>
                @endif

                @if($company && $company->google_maps_link)
                <a href="{{ $company->google_maps_link }}" target="_blank" class="bg-[#4285F4] hover:bg-[#3367D6] text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <!-- SVG Google Maps -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                    </svg>
                    <span>Maps</span>
                </a>
                @endif

                @if($company && $company->instagram)
                <a href="{{ $company->instagram }}" target="_blank" class="bg-gradient-to-r from-[#833ab4] via-[#fd1d1d] to-[#fcb045] hover:opacity-90 text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <!-- SVG Instagram -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                    <span>Instagram</span>
                </a>
                @endif

                @if($company && $company->facebook)
                <a href="{{ $company->facebook }}" target="_blank" class="bg-[#1877F2] hover:bg-[#0d65d9] text-white text-xs sm:text-sm font-bold p-2.5 sm:p-3 rounded-xl flex items-center justify-center gap-2 transition shadow-lg">
                    <!-- SVG Facebook -->
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                    <span>Facebook</span>
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