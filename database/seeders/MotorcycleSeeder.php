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
        $motorcycles = [
            [
                'brand' => 'Honda',
                'model' => 'CG 160 Titan',
                'version' => 'S',
                'model_year' => 2025,
                'manufacture_year' => 2025,
                'type' => 'NOVA',
                'license_plate' => null,
                'chassis_number' => '9C6ABC123DEF45678',
                'renavam' => '12345678901',
                'color' => 'Azul Perolizado',
                'mileage' => 0,
                'engine_details' => '162.7cc',
                'purchase_price' => 15000.00,
                'refurbishment_cost' => 0.00,
                'sale_price' => 18500.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(30)->toDateString(),
                'details' => 'Moto nova, 0km, com garantia de fábrica',
                'fipe_code' => '001234-5',
            ],
            [
                'brand' => 'Yamaha',
                'model' => 'NMAX 160',
                'version' => 'ABS',
                'model_year' => 2023,
                'manufacture_year' => 2022,
                'type' => 'USADA',
                'license_plate' => 'BRA2E19',
                'chassis_number' => '9C6ABC123DEF45679',
                'renavam' => '12345678902',
                'color' => 'Preto Fosco',
                'mileage' => 8500,
                'engine_details' => '155cc',
                'purchase_price' => 16000.00,
                'refurbishment_cost' => 1200.00,
                'sale_price' => 19800.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(45)->toDateString(),
                'details' => 'Moto usada em excelente estado, revisada',
                'fipe_code' => '001235-6',
            ],
            [
                'brand' => 'Honda',
                'model' => 'PCX 160',
                'version' => 'ABS',
                'model_year' => 2024,
                'manufacture_year' => 2024,
                'type' => 'NOVA',
                'license_plate' => null,
                'chassis_number' => '9C6ABC123DEF45680',
                'renavam' => '12345678903',
                'color' => 'Branco Perolizado',
                'mileage' => 0,
                'engine_details' => '157cc',
                'purchase_price' => 18000.00,
                'refurbishment_cost' => 0.00,
                'sale_price' => 22000.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(15)->toDateString(),
                'details' => 'Scooter nova, ideal para cidade',
                'fipe_code' => '001236-7',
            ],
            [
                'brand' => 'Yamaha',
                'model' => 'MT-03',
                'version' => 'ABS',
                'model_year' => 2022,
                'manufacture_year' => 2021,
                'type' => 'USADA',
                'license_plate' => 'BRA3F20',
                'chassis_number' => '9C6ABC123DEF45681',
                'renavam' => '12345678904',
                'color' => 'Azul Metálico',
                'mileage' => 12000,
                'engine_details' => '321cc',
                'purchase_price' => 25000.00,
                'refurbishment_cost' => 2000.00,
                'sale_price' => 32000.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(60)->toDateString(),
                'details' => 'Naked usada, muito bem conservada',
                'fipe_code' => '001237-8',
            ],
            [
                'brand' => 'Honda',
                'model' => 'CB 300F Twister',
                'version' => 'ABS',
                'model_year' => 2023,
                'manufacture_year' => 2023,
                'type' => 'USADA',
                'license_plate' => 'BRA4G21',
                'chassis_number' => '9C6ABC123DEF45682',
                'renavam' => '12345678905',
                'color' => 'Vermelho',
                'mileage' => 5000,
                'engine_details' => '293.5cc',
                'purchase_price' => 22000.00,
                'refurbishment_cost' => 800.00,
                'sale_price' => 28000.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(20)->toDateString(),
                'details' => 'Moto seminova, poucos km rodados',
                'fipe_code' => '001238-9',
            ],
            [
                'brand' => 'Kawasaki',
                'model' => 'Ninja 400',
                'version' => 'ABS',
                'model_year' => 2021,
                'manufacture_year' => 2020,
                'type' => 'USADA',
                'license_plate' => 'BRA5H22',
                'chassis_number' => '9C6ABC123DEF45683',
                'renavam' => '12345678906',
                'color' => 'Verde Kawasaki',
                'mileage' => 15000,
                'engine_details' => '399cc',
                'purchase_price' => 35000.00,
                'refurbishment_cost' => 3000.00,
                'sale_price' => 45000.00,
                'status' => 'DISPONIVEL',
                'purchase_date' => now()->subDays(90)->toDateString(),
                'details' => 'Sport usada, revisada completa',
                'fipe_code' => '001239-0',
            ],
        ];

        foreach ($motorcycles as $motorcycle) {
            Motorcycle::create($motorcycle);
        }
    }
}


