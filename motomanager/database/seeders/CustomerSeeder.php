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
        $customers = json_decode(file_get_contents(database_path("../mocks/customers.json")), true);

        $firstLeadOrigin = LeadOrigin::first();
        $firstUser = User::first();

        foreach ($customers as $customer) {
            Customer::create([
                'name' => $customer['name'],
                'document_number' => $customer['document_number'] ?? null,
                'email' => $customer['email'] ?? null,
                'phone_number' => $customer['phone_number'],
                'address' => $customer['address'] ?? null,
                'birth_date' => $customer['birth_date'] ?? null,
                'lead_origin_id' => $firstLeadOrigin ? $firstLeadOrigin->id : null,
                'assigned_to_user_id' => $firstUser ? $firstUser->id : null,
            ]);
        }
    }
}


