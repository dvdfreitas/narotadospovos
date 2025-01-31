<?php

namespace Database\Seeders;

use App\Models\Need;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NeedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $product_id = Product::where('slug', 'leite-tipo-2')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'papas-lacteas')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'latas-de-atum')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'massas')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'salsichas')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'tomate-enlatado')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'nestum')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'essential',
        ]);

        $product_id = Product::where('slug', 'arroz')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'azeite')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'bolachas')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'detergentes')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'sabao-em-barra')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'leite-nido')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'leite-lactentes')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'nice_to_have',
        ]);

        $product_id = Product::where('slug', 'brinquedos')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'dont_want',
        ]);

        $product_id = Product::where('slug', 'roupa-de-adulto')->first()->id;
        Need::create([
            'product_id' => $product_id,
            'priority' => 'dont_want',
        ]);

    }
}
