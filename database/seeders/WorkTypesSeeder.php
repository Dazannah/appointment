<?php

namespace Database\Seeders;

use App\Models\WorkTypes;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WorkTypesSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        WorkTypes::insert(
            [
                ['name' => 'Light bulb replecament', 'duration' => 15, 'price_id' => 1],
                ['name' => 'Oil change', 'duration' => 30, 'price_id' => 2],
                ['name' => 'Carburetor maintenance', 'duration' => 120, 'price_id' => 6],
            ]
        );
    }
}
