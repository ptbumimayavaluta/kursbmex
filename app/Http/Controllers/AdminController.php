<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http; // <-- 1. IMPORT HTTP CLIENT LARAVEL
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
    /**
     * Helper privat untuk mengirim data sync ke MC POS
     * Agar kodingan tidak duplikat di setiap method.
     */
    private function syncRateToPOS()
    {
        try {
            $activeCurrencies = Currency::all();

            $payload = [
                'rates' => $activeCurrencies->map(function ($item) {
                    return [
                        'code'      => $item->code,
                        'buy_rate'  => $item->buy_rate,
                        'sell_rate' => $item->sell_rate
                    ];
                })->toArray()
            ];

            // Tembak endpoint API MC POS
            // Ganti URL 'https://pos.domainanda.com/api/v1/sync-rates' dengan URL POS Anda (atau http://IP_SERVER:8000/api/v1/sync-rates jika lokal)
            $response = Http::withHeaders([
                'X-API-Token' => 'bmex2026', // Harus sama persis dengan token di api.php MC POS
            ])->post('https://pos.domainanda.com/api/v1/sync-rates', $payload);

            if ($response->failed()) {
                \Log::error('Gagal sinkronisasi kurs ke MC POS: ' . $response->body());
            }
        } catch (\Exception $e) {
            // Ditangkap agar jika server MC POS offline, web rate tetap aman & tidak error 500
            \Log::error('Koneksi sync error ke MC POS: ' . $e->getMessage());
        }
    }

    public function currencies()
    {
        $currencies = Currency::orderBy('order_number', 'asc')->get();
        return view('admin.currencies.index', compact('currencies'));
    }

    // Tambah Mata Uang Baru
    public function storeCurrency(Request $request)
    {
        $request->validate([
            'code' => 'required|string|max:10|unique:currencies,code',
            'name' => 'required|string|max:255',
            'flag' => 'nullable|string|max:5',
            'buy_rate' => 'required|numeric',
            'sell_rate' => 'required|numeric',
        ]);

        $lastOrder = Currency::max('order_number') ?? 0;

        Currency::create([
            'code' => strtoupper($request->code),
            'name' => $request->name,
            'flag' => strtolower($request->flag),
            'buy_rate' => $request->buy_rate,
            'sell_rate' => $request->sell_rate,
            'order_number' => $lastOrder + 1,
        ]);

        // 2. TRIGGER SYNC OTOMATIS KE MC POS
        $this->syncRateToPOS();

        return redirect()->back()->with('success', 'Mata uang baru berhasil ditambahkan dan disinkronkan ke POS!');
    }

    // Update Kurs & Bendera (Satuan)
    public function updateCurrency(Request $request, Currency $currency)
    {
        $request->validate([
            'buy_rate' => 'required|numeric',
            'sell_rate' => 'required|numeric',
            'flag' => 'nullable|string|max:5',
        ]);

        $currency->update([
            'buy_rate' => $request->buy_rate,
            'sell_rate' => $request->sell_rate,
            'flag' => strtolower($request->flag),
        ]);

        // 3. TRIGGER SYNC OTOMATIS KE MC POS
        $this->syncRateToPOS();

        return redirect()->back()->with('success', 'Kurs ' . $currency->code . ' berhasil diperbarui dan disinkronkan ke POS!');
    }

    // Hapus Mata Uang (Opsional)
    public function destroyCurrency(Currency $currency)
    {
        $currency->delete();
        
        // Opsional: jika dihapus, sinkronkan ulang sisa data ke POS
        $this->syncRateToPOS();

        return redirect()->back()->with('success', 'Mata uang berhasil dihapus!');
    }

    public function editCompany()
    {
        $company = CompanyProfile::first();
        return view('admin.company.edit', compact('company'));
    }

    public function updateCompany(Request $request)
    {
        $validated = $request->validate([
            'name'             => 'nullable|string|max:255',
            'phone'            => 'nullable|string|max:255',
            'email'            => 'nullable|email|max:255',
            'whatsapp'         => 'nullable|string|max:255',
            'address'          => 'nullable|string',
            'description'      => 'nullable|string',
            'running_text'     => 'nullable|string',
            'instagram'        => 'nullable|string|max:255',
            'facebook'         => 'nullable|string|max:255',
            'google_maps_link' => 'nullable|string',
        ]);

        $company = CompanyProfile::firstOrCreate(['id' => 1]);
        $company->update($validated);

        return redirect()->back()->with('success', 'Informasi perusahaan berhasil diperbarui!');
    }

    // Update Semua Kurs Sekaligus
    public function updateAllCurrencies(Request $request)
    {
        $request->validate([
            'currencies' => 'required|array',
            'currencies.*.buy_rate' => 'required|numeric',
            'currencies.*.sell_rate' => 'required|numeric',
            'currencies.*.flag' => 'nullable|string|max:5',
        ]);

        foreach ($request->currencies as $id => $data) {
            $currency = Currency::find($id);
            if ($currency) {
                $currency->update([
                    'buy_rate' => $data['buy_rate'],
                    'sell_rate' => $data['sell_rate'],
                    'flag' => isset($data['flag']) ? strtolower($data['flag']) : null,
                ]);
            }
        }

        // 4. TRIGGER SYNC OTOMATIS KE MC POS
        $this->syncRateToPOS();

        return redirect()->back()->with('success', 'Semua kurs mata uang berhasil diperbarui dan disinkronkan ke POS!');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ], [
            'current_password.current_password' => 'Password saat ini tidak cocok.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }
}