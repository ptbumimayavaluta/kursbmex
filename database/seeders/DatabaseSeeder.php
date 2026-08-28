<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Currency;
use App\Models\CompanyProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat Akun Admin
        User::updateOrCreate(
            ['email' => 'admin@gmail.com'],
            [
                'name'     => 'Admin BMEX',
                'password' => Hash::make('password123'),
            ]
        );

        // 2. Buat Data Profil Perusahaan Awal
        CompanyProfile::updateOrCreate(
            ['id' => 1],
            [
                'name'             => 'BMEX Money Changer',
                'phone'            => '08123456789',
                'email'            => 'info@bmex.com',
                'whatsapp'         => '628123456789',
                'address'          => 'Jl. Raya Utama No. 88, Bali',
                'description'      => 'Layanan penukaran mata uang asing terpercaya dengan rate terbaik.',
                'running_text'     => 'Selamat datang di BMEX Money Changer! Kami melayani penukaran valas dengan kurs terbaik & tanpa komisi.',
                'instagram'        => 'https://instagram.com',
                'facebook'         => 'https://facebook.com',
                'google_maps_link' => 'https://maps.google.com',
            ]
        );

        // 3. Buat Data Mata Uang Standar (Default Currencies)
        $currencies = [
            [
                'code'      => 'USD',
                'name'      => 'US Dollar',
                'buy_rate'  => 15500.00,
                'sell_rate' => 15700.00,
                'flag'      => 'us',
            ],
            [
                'code'      => 'AUD',
                'name'      => 'Australian Dollar',
                'buy_rate'  => 10200.00,
                'sell_rate' => 10450.00,
                'flag'      => 'au',
            ],
            [
                'code'      => 'EUR',
                'name'      => 'Euro',
                'buy_rate'  => 16800.00,
                'sell_rate' => 17100.00,
                'flag'      => 'eu',
            ],
            [
                'code'      => 'SGD',
                'name'      => 'Singapore Dollar',
                'buy_rate'  => 11400.00,
                'sell_rate' => 11600.00,
                'flag'      => 'sg',
            ],
            [
                'code'      => 'JPY',
                'name'      => 'Japanese Yen',
                'buy_rate'  => 108.00,
                'sell_rate' => 112.00,
                'flag'      => 'jp',
            ],
        ];

        foreach ($currencies as $curr) {
            Currency::updateOrCreate(
                ['code' => $curr['code']],
                $curr
            );
        }
    }
}