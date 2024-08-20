<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // User::factory(10)->create();

        User::create([
            'name' => 'Test User',
            'email' => 'teszt@davidfabian.hu',
            'password' => '$2y$12$7mkzpcVuWUhpKqxzN6gAxun39wxgkD1PZ4nYgcxA6W05q8xz3wVlO',
            'email_verified_at' => '2024-08-19 14:38:30'
        ]);

        $this->call([
            PriceSeeder::class,
            StatusSeeder::class,
            WorkTypesSeeder::class,
            PenaltyFeePriceSeeder::class,
            PenaltyFeeStatusSeeder::class,
        ]);
    }
}
