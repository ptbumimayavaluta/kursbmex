<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\CompanyProfile;
use App\Models\Currency;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSetupSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Akun Admin Default
        User::create([
            'name' => 'Admin BMEX',
            'email' => 'admin@bmex.com',
            'password' => Hash::make('password123'), // Ganti password ini nanti di dashboard
        ]);

        // 2. Data Profil Perusahaan Awal
        CompanyProfile::create([
            'company_name' => 'BMEX Money Changer',
            'about_us' => 'Layanan penukaran mata uang asing terpercaya dengan kurs terbaik.',
            'whatsapp' => '6281234567890',
            'email' => 'info@bmex.com',
            'facebook' => 'https://facebook.com/bmex',
            'instagram' => 'https://instagram.com/bmex',
            'address' => 'Jl. Utama BMEX No. 88, Bali',
            'running_text' => 'Selamat datang di BMEX Money Changer. Kurs dapat berubah sewaktu-waktu tanpa pemberitahuan terlebih dahulu.',
        ]);

        // 3. Data Sample Kurs Mata Uang
        $currencies = [
            ['code' => 'USD', 'name' => 'US Dollar', 'buy_rate' => 15500, 'sell_rate' => 15700, 'order_number' => 1],
            ['code' => 'AUD', 'name' => 'Australian Dollar', 'buy_rate' => 10200, 'sell_rate' => 10450, 'order_number' => 2],
            ['code' => 'EUR', 'name' => 'Euro', 'buy_rate' => 16800, 'sell_rate' => 17100, 'order_number' => 3],
            ['code' => 'SGD', 'name' => 'Singapore Dollar', 'buy_rate' => 11400, 'sell_rate' => 11600, 'order_number' => 4],
        ];

        foreach ($currencies as $c) {
            Currency::create($c);
        }
    }
}