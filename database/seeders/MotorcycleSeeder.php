<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Motorcycle;

class MotorcycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $motorcycles = json_decode(file_get_contents(database_path("../mocks/motorcycles.json")), true);

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create([
                'brand' => $motorcycle['brand'],
                'model' => $motorcycle['model'],
                'version' => $motorcycle['version'] ?? null,
                'model_year' => $motorcycle['model_year'],
                'manufacture_year' => $motorcycle['manufacture_year'],
                'type' => $motorcycle['type'],
                'license_plate' => $motorcycle['license_plate'] ?? null,
                'chassis_number' => $motorcycle['chassis_number'] ?? null,
                'renavam' => $motorcycle['renavam'] ?? null,
                'color' => $motorcycle['color'],
                'mileage' => $motorcycle['mileage'] ?? 0,
                'engine_details' => $motorcycle['engine_details'] ?? null,
                'purchase_price' => $motorcycle['purchase_price'],
                'refurbishment_cost' => $motorcycle['refurbishment_cost'] ?? 0.00,
                'sale_price' => $motorcycle['sale_price'],
                'status' => $motorcycle['status'],
                'purchase_date' => $motorcycle['purchase_date'] ?? now()->toDateString(),
                'details' => $motorcycle['details'] ?? null,
                'fipe_code' => $motorcycle['fipe_code'] ?? null,
            ]);
        }
    }
}


