<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        Price::insert(
            [
                ['price' => 25000],
                ['price' => 50000],
                ['price' => 75000],
                ['price' => 100000],
                ['price' => 125000],
                ['price' => 150000],
                ['price' => 175000],
                ['price' => 200000],
            ]
        );
    }
}
