<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Lead;
use App\Models\Customer;
use App\Models\Motorcycle;
use App\Models\LeadOrigin;
use App\Models\User;

class LeadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $motorcycles = Motorcycle::all();
        $leadOrigins = LeadOrigin::all();
        $vendedores = User::where('role', 'vendedor')->get();

        $statuses = ['NOVO', 'CONTATADO', 'PROPOSTA_ENVIADA', 'NEGOCIACAO', 'GANHO', 'PERDIDO'];

        foreach ($customers as $index => $customer) {
            $motorcycle = $motorcycles->random();
            $leadOrigin = $leadOrigins->random();
            $vendedor = $vendedores->random();
            $status = $statuses[array_rand($statuses)];

            Lead::create([
                'customer_id' => $customer->id,
                'motorcycle_of_interest_id' => $motorcycle->id,
                'assigned_to_user_id' => $vendedor->id,
                'lead_origin_id' => $leadOrigin->id,
                'status' => $status,
            ]);
        }
    }

    private function getRandomNotes(string $status): string
    {
        $notes = [
            'NOVO' => 'Cliente interessado em moto nova, busca financiamento',
            'CONTATADO' => 'Primeiro contato realizado, aguardando retorno',
            'PROPOSTA_ENVIADA' => 'Proposta enviada, aguardando resposta do cliente',
            'NEGOCIACAO' => 'Em negociação de preço e condições',
            'GANHO' => 'Venda realizada com sucesso',
            'PERDIDO' => 'Cliente desistiu da compra',
        ];

        return $notes[$status] ?? 'Lead criado automaticamente';
    }
}