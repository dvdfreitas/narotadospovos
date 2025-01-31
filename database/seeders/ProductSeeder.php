<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'name' => 'Leite tipo 2',
            'slug' => 'leite-tipo-2',
        ]);

        Product::create([
            'name' => 'Papas lácteas',
            'slug' => 'papas-lacteas',
        ]);

        Product::create([
            'name' => 'Latas de atum',
            'slug' => 'latas-de-atum',
        ]);

        Product::create([
            'name' => 'Massas',
            'slug' => 'massas',
        ]);

        Product::create([
            'name' => 'Salsichas',
            'slug' => 'salsichas',
        ]);

        Product::create([
            'name' => 'Tomate enlatado',
            'slug' => 'tomate-enlatado',
        ]);

        Product::create([
            'name' => 'Nestum',
            'slug' => 'nestum',
        ]);

        Product::create([
            'name' => 'Arroz',
            'slug' => 'arroz',
        ]);

        Product::create([
            'name' => 'Azeite',
            'slug' => 'azeite',
        ]);

        Product::create([
            'name' => 'Bolachas',
            'slug' => 'bolachas',
        ]);

        Product::create([
            'name' => 'Detergentes',
            'slug' => 'detergentes',
        ]);

        Product::create([
            'name' => 'Sabão em barra',
            'slug' => 'sabao-em-barra',
        ]);

        Product::create([
            'name' => 'Leite Nido',
            'slug' => 'leite-nido',
        ]);

        Product::create([
            'name' => 'Leite lactentes',
            'slug' => 'leite-lactentes',
        ]);

        Product::create([
            'name' => 'Brinquedos',
            'slug' => 'brinquedos',
        ]);
    }
}
