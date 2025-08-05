<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sale;
use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\User;

class SaleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $motorcycles = Motorcycle::where('status', 'DISPONIVEL')->get();
        $vendedores = User::where('role', 'vendedor')->get();

        // Criar algumas vendas
        for ($i = 0; $i < min(4, count($customers), count($motorcycles)); $i++) {
            $customer = $customers[$i];
            $motorcycle = $motorcycles[$i];
            $vendedor = $vendedores->random();

            $salePrice = $motorcycle->sale_price;
            $discount = rand(0, 1000); // Desconto aleatório
            $finalPrice = $salePrice - $discount;

            Sale::create([
                'motorcycle_id' => $motorcycle->id,
                'customer_id' => $customer->id,
                'user_id' => $vendedor->id,
                'sale_date' => now()->subDays(rand(1, 60)),
                'final_sale_price' => $finalPrice,
                'payment_method' => $this->getRandomPaymentMethod(),
                'trade_in_motorcycle_id' => null,
                'notes' => 'Venda realizada com sucesso',
            ]);

            // Atualizar status da moto para vendida
            $motorcycle->update(['status' => 'VENDIDA']);
        }
    }

    private function getRandomPaymentMethod(): string
    {
        $methods = ['A_VISTA', 'FINANCIAMENTO', 'CONSORCIO', 'CARTAO'];
        return $methods[array_rand($methods)];
    }
}