<?php

namespace Database\Seeders;

use App\Models\Need;
use App\Models\Product;
use Illuminate\Database\Seeder;
use RuntimeException;

class NeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $needs = [
            'papas-lacteas'   => 'essential',
            'leite-lactentes' => 'essential',
            'azeite'          => 'nice_to_have',
        ];

        foreach ($needs as $slug => $priority) {
            $product = Product::firstWhere('slug', $slug)
                ?? throw new RuntimeException("Produto não encontrado no seeder: {$slug}");

            Need::updateOrCreate(
                ['product_id' => $product->id],
                ['priority' => $priority],
            );
        }
    }
}
