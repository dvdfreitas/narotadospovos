<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * ATENÇÃO: os preços são provisórios e não têm base real.
     * Substituir pelos preços praticados antes de a loja ir para o ar.
     */
    public function run(): void
    {
        // nome, slug, unidade base, descrição, [ [label, quantidade, preço, descrição da opção], … ]
        $products = [
            [
                'Papas lácteas', 'papas-lacteas', 'un',
                'Contribua com um pacote de papas lácteas para a alimentação das crianças apoiadas pela associação.',
                [['1 pacote', 1, 0.01, null]],
            ],
            [
                'Azeite', 'azeite', 'L',
                'Ajude a preparar as refeições de quem precisa, contribuindo com um litro de azeite.',
                [['1 L', 1, 0.01, null]],
            ],
            [
                'Leite lactentes', 'leite-lactentes', 'lata',
                'Uma lata de leite para lactentes para apoiar a alimentação dos bebés acompanhados pela associação.',
                [['1 lata', 1, 0.01, null]],
            ],
            [
                'Cabaz', 'cabaz-solidario', 'un',
                'Contribua para um cabaz de bens essenciais. Escolha entre as opções Solidário e Família.',
                [
                    ['Solidário', 1, 0.01, '1 kg de arroz, 1 kg de massa, 1 L de azeite e 2 latas de conserva.'],
                    ['Família', 1, 0.01, '2 kg de arroz, 2 kg de massa, 2 L de azeite e 4 latas de conserva — o dobro das quantidades do Solidário.'],
                ],
            ],
        ];

        foreach ($products as [$name, $slug, $unit, $description, $variants]) {
            $product = Product::updateOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'unit' => $unit, 'description' => $description],
            );

            if (empty($product->image)) {
                $product->update(['image' => "images/products/{$slug}.webp"]);
            }

            foreach ($variants as [$label, $quantity, $price, $variantDescription]) {
                $product->variants()->updateOrCreate(
                    ['label' => $label],
                    ['quantity' => $quantity, 'price' => $price, 'description' => $variantDescription],
                );
            }
        }
    }
}
