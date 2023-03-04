<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\ClickedAd;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        for ($i = 0; $i < 100; $i++) {
            Ad::create([
                'title' => Str::random(10),
                'body' => Str::random(100),
            ]);
        }
        for ($i = 0; $i < 100; $i++) {
            ClickedAd::create([
                'ad_id' => 10,
                'user_id' => 3,
            ]);
        }
        for ($i = 0; $i < 100; $i++) {
            Transaction::create([
                'phone_number' => '+237678909876',
                'email' => Str::random(10) . '@gmail.com',
                'amount' => 1000,
                'method' => 'paypal',
                'type' => 'deposit',
                'user_id' => 5,
            ]);
        }
    }
}