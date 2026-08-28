@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    
    <div>
        <h1 class="text-2xl font-black text-amber-400">Pengaturan Profil & Running Text</h1>
        <p class="text-xs text-gray-400">Kelola teks berjalan, kontak toko, dan tautan sosial media.</p>
    </div>

    <!-- Alert Notifikasi Berhasil -->
    @if(session('success'))
    <div class="bg-green-500/20 border border-green-500 text-green-300 px-4 py-3 rounded-xl text-sm flex items-center gap-2">
        <span>✅</span>
        <span>{{ session('success') }}</span>
    </div>
    @endif

    <!-- Alert Notifikasi Validation Error -->
    @if($errors->any())
    <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-xl text-sm">
        <p class="font-bold mb-1">Terjadi kesalahan input:</p>
        <ul class="list-disc list-inside space-y-1">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.company.update') }}" method="POST" class="bg-[#0A1245] border border-amber-500/30 rounded-2xl p-6 md:p-8 shadow-2xl space-y-6">
        @csrf

        <!-- Running Text -->
        <div>
            <label class="block text-sm font-bold text-amber-400 mb-2">📢 Running Text (Pengumuman Display)</label>
            <textarea name="running_text" rows="2" class="w-full bg-[#050B2E] border border-slate-700 text-amber-300 font-bold rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none" placeholder="Masukkan teks pengumuman berjalan...">{{ old('running_text', $company->running_text ?? '') }}</textarea>
        </div>

        <hr class="border-slate-800">

        <!-- Informasi Umum Toko -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Nama Perusahaan / Toko</label>
                <input type="text" name="name" value="{{ old('name', $company->name ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Nomor Telepon / Hotline</label>
                <input type="text" name="phone" value="{{ old('phone', $company->phone ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Email Perusahaan</label>
                <input type="email" name="email" value="{{ old('email', $company->email ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">WhatsApp CS (Contoh: 628123456789)</label>
                <input type="text" name="whatsapp" value="{{ old('whatsapp', $company->whatsapp ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-300 mb-1">Alamat Lengkap</label>
            <textarea name="address" rows="2" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">{{ old('address', $company->address ?? '') }}</textarea>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-300 mb-1">Deskripsi Singkat Perusahaan</label>
            <textarea name="description" rows="3" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">{{ old('description', $company->description ?? '') }}</textarea>
        </div>

        <hr class="border-slate-800">

        <!-- Sosial Media & Maps -->
        <h3 class="text-sm font-bold text-amber-400">Tautan Sosial Media & Lokasi</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Link Google Maps</label>
                <input type="text" name="google_maps_link" value="{{ old('google_maps_link', $company->google_maps_link ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Link Instagram</label>
                <input type="text" name="instagram" value="{{ old('instagram', $company->instagram ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-300 mb-1">Link Facebook</label>
                <input type="text" name="facebook" value="{{ old('facebook', $company->facebook ?? '') }}" class="w-full bg-[#050B2E] border border-slate-700 text-white rounded-xl p-3 focus:ring-2 focus:ring-amber-400 focus:outline-none">
            </div>
        </div>

        <div class="flex justify-end pt-4">
            <button type="submit" class="bg-amber-400 hover:bg-amber-300 text-[#0A1245] font-black px-8 py-3 rounded-xl shadow-lg transition transform active:scale-95 flex items-center gap-2">
                <span>💾</span> SIMPAN PROFIL PERUSAHAAN
            </button>
        </div>
    </form>
</div>
@endsection