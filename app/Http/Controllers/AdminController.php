<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\CompanyProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AdminController extends Controller
{
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
            'flag' => strtolower($request->flag), // Contoh: us, au, sg, jp
            'buy_rate' => $request->buy_rate,
            'sell_rate' => $request->sell_rate,
            'order_number' => $lastOrder + 1,
        ]);

        return redirect()->back()->with('success', 'Mata uang baru berhasil ditambahkan!');
    }

    // Update Kurs & Bendera
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

        return redirect()->back()->with('success', 'Kurs ' . $currency->code . ' berhasil diperbarui!');
    }

    // Hapus Mata Uang (Opsional)
    public function destroyCurrency(Currency $currency)
    {
        $currency->delete();
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

        // Ambil baris pertama, jika belum ada data maka buat otomatis baris baru
        $company = CompanyProfile::firstOrCreate(['id' => 1]);

        // Update data dengan data yang sudah divalidasi
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

        return redirect()->back()->with('success', 'Semua kurs mata uang berhasil diperbarui!');
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