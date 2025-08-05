<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\LeadOrigin;

class LeadOriginSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $origins = json_decode(file_get_contents(database_path("../mocks/lead_origins.json")), true);

        foreach ($origins as $origin) {
            LeadOrigin::create($origin);
        }
    }
}


