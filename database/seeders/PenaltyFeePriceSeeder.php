<?php

namespace Database\Seeders;

use App\Models\PenaltyFeePrice;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenaltyFeePriceSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        PenaltyFeePrice::insert(
            [
                ['price' => 10000],
                ['price' => 20000],
            ]
        );
    }
}
