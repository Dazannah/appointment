<?php

namespace Database\Seeders;

use App\Models\PenaltyFeeStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenaltyFeeStatusSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        PenaltyFeeStatus::insert(
            [
                ['name' => 'New'],
                ['name' => 'Payed'],
                ['name' => 'Late'],
            ]
        );
    }
}
