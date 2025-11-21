<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Donation;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donation>
 */
class DonationFactory extends Factory
{
    protected $model = Donation::class;

    public function definition(): array
    {
        // 50% de probabilidade de ser uma prenda/oferta
        $isGift = $this->faker->boolean(50);
        // 20% de probabilidade de ser anónimo
        $isAnonymous = $this->faker->boolean(20);

        $donorName = $this->faker->name();
        $donorEmail = $this->faker->safeEmail();

        return [
            // 1. DADOS FINANCEIROS (entre 5€ e 500€)
            'amount' => $this->faker->randomFloat(2, 5, 500),

            // 2. DADOS DO DOADOR
            'donor_name' => $donorName,
            'donor_email' => $donorEmail,

            // 3. EXIBIÇÃO NA ÁRVORE
            'is_anonymous' => $isAnonymous,
            'public_message' => $this->faker->optional(0.7, null)->sentence(3, true), // 70% de chance de ter uma mensagem

            // 4. OFERTA / PRENDA
            'is_gift' => $isGift,
            'gift_recipient_name' => $isGift ? $this->faker->name() : null,
            'gift_recipient_email' => $isGift ? $this->faker->safeEmail() : null,
            'gift_message' => $isGift ? $this->faker->text(100) : null,

            // 5. CONTROLO INTERNO
            'access_code' => $this->faker->unique()->lexify('????????????'), // 12 caracteres aleatórios

            // Data de criação escalonada para simular o tempo real
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'now'),
        ];
    }

}
