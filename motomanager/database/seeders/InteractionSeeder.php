<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Interaction;
use App\Models\Customer;
use App\Models\User;

class InteractionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = Customer::all();
        $users = User::all();

        $types = ['LIGACAO', 'WHATSAPP', 'EMAIL', 'VISITA_LOJA', 'EVENTO'];

        foreach ($customers as $customer) {
            // Criar 2-4 interações por cliente
            $numInteractions = rand(2, 4);
            
            for ($i = 0; $i < $numInteractions; $i++) {
                $user = $users->random();
                $type = $types[array_rand($types)];

                Interaction::create([
                    'customer_id' => $customer->id,
                    'user_id' => $user->id,
                    'type' => $type,
                    'notes' => $this->getRandomNotes($type),
                    'interaction_date' => now()->subDays(rand(1, 30)),
                ]);
            }
        }
    }

    private function getRandomNotes(string $type): string
    {
        $notes = [
            'LIGACAO' => 'Ligação de acompanhamento realizada. Cliente demonstrou interesse em moto específica.',
            'EMAIL' => 'Proposta enviada por email com condições especiais. Aguardando retorno do cliente.',
            'WHATSAPP' => 'Contato via WhatsApp realizado. Cliente solicitou mais informações sobre financiamento.',
            'VISITA_LOJA' => 'Cliente visitou a loja e testou algumas motos. Demonstrou preferência por modelo específico.',
            'EVENTO' => 'Contato realizado durante evento. Cliente interessado em motos esportivas.',
        ];

        return $notes[$type] ?? 'Interação realizada com sucesso';
    }
}