<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\LeadOrigin;
use App\Models\User;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            [
                'name' => 'Carlos Silva',
                'document_number' => '123.456.789-00',
                'email' => 'carlos.silva@example.com',
                'phone_number' => '11987654321',
                'address' => 'Rua das Flores, 123, São Paulo, SP',
                'birth_date' => '1990-05-15',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
            [
                'name' => 'Ana Paula Santos',
                'document_number' => '987.654.321-00',
                'email' => 'ana.santos@example.com',
                'phone_number' => '11987654322',
                'address' => 'Av. Paulista, 1000, São Paulo, SP',
                'birth_date' => '1985-08-20',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
            [
                'name' => 'Roberto Oliveira',
                'document_number' => '456.789.123-00',
                'email' => 'roberto.oliveira@example.com',
                'phone_number' => '11987654323',
                'address' => 'Rua Augusta, 500, São Paulo, SP',
                'birth_date' => '1988-12-10',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
            [
                'name' => 'Fernanda Costa',
                'document_number' => '789.123.456-00',
                'email' => 'fernanda.costa@example.com',
                'phone_number' => '11987654324',
                'address' => 'Rua Oscar Freire, 200, São Paulo, SP',
                'birth_date' => '1992-03-25',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
            [
                'name' => 'Marcos Pereira',
                'document_number' => '321.654.987-00',
                'email' => 'marcos.pereira@example.com',
                'phone_number' => '11987654325',
                'address' => 'Av. Brigadeiro Faria Lima, 1500, São Paulo, SP',
                'birth_date' => '1987-07-15',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
            [
                'name' => 'Juliana Lima',
                'document_number' => '654.321.987-00',
                'email' => 'juliana.lima@example.com',
                'phone_number' => '11987654326',
                'address' => 'Rua Haddock Lobo, 300, São Paulo, SP',
                'birth_date' => '1995-11-08',
                'lead_origin_id' => LeadOrigin::first()?->id,
                'assigned_to_user_id' => User::where('role', 'vendedor')->first()?->id,
            ],
        ];

        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}


