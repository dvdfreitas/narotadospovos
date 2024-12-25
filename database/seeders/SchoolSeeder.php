<?php

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        School::create([
            'name' => 'Escola Sembé Djessi',
            'location' => 'Catió',
            'country' => 'Guiné-Bissau'
        ]);

        School::create([
            'name' => 'Liceu Regional Areolino Cruz',
            'location' => 'Catió',
            'country' => 'Guiné-Bissau'
        ]);
    }
}
