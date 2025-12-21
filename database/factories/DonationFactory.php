<?php

namespace Database\Factories;

use App\Models\Donation;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Enums\DonationStatus;

class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition()
    {
        $isGift = $this->faker->boolean(20);
        $isAnonymous = $this->faker->boolean(15);

        return [
            // 1. CONTEXTO
            'campaign_slug' => 'natal-25',
            // Se já estás a usar o Trait 'GeneratesAccessCode', podes remover esta linha,
            // mas mantê-la aqui na Factory não faz mal (sobrescreve o automático).
            'access_code' => Str::upper(Str::random(12)), 

            // 2. FINANCEIRO
            'amount' => $this->faker->randomFloat(2, 5, 100),
            'currency' => 'EUR',
            
            // IMPORTANTE: Usa 'paid' para bater certo com o código da Árvore
            'status' => $this->faker->randomElement([
                DonationStatus::Paid, 
                DonationStatus::Paid, 
                DonationStatus::Pending
            ]),
            // REMOVIDO: 'confirmed_at' => ... (Esta coluna não existe na BD)

            // 3. DOADOR
            'donor_name' => $this->faker->name(),
            'donor_email' => $this->faker->safeEmail(),
            'donor_phone' => '91' . $this->faker->randomNumber(7, true),
            'nif' => $this->faker->optional()->numerify('#########'),

            // 4. PRIVACIDADE
            'is_anonymous' => $isAnonymous,

            // 5. JSON MAGIC
            'campaign_data' => [
                'item_type' => $this->faker->randomElement(['papas', 'leite', 'crianca', 'familia', 'custom']),
                'public_message' => $this->faker->boolean(60) ? $this->faker->sentence(6) : null,
                'is_gift' => $isGift,
                'gift_recipient_name' => $isGift ? $this->faker->firstName() : null,
                'gift_message' => $isGift ? $this->faker->sentence(10) : null,
            ],

            // 6. DATAS
            'terms_accepted_at' => now(),
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => now(),
        ];
    }
}