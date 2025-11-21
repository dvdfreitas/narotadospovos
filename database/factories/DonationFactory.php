<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class DonationFactory extends Factory
{
    public function definition()
    {
        $isGift = $this->faker->boolean(20); // 20% das doações são prenda
        $isAnonymous = $this->faker->boolean(15); // 15% anónimas

        return [
            // 1. FINANCEIRO
            'amount' => $this->faker->randomFloat(2, 2, 250), // €2 a €250
            'donor_email' => $this->faker->safeEmail(),
            'donor_phone' => $this->faker->numerify('9########'), // nº PT
            'payment_status' => $this->faker->randomElement(['pending', 'paid', 'failed']),
            'payment_gateway_id' => $this->faker->optional()->uuid(),

            // 2. DOADOR
            'donor_name' => $isAnonymous
                ? 'Anónimo'
                : $this->faker->name(),

            // 3. EXPOSIÇÃO PÚBLICA
            'is_anonymous' => $isAnonymous,
            'public_message' => $this->faker->optional(0.6)->sentence(6, true), // 60% têm mensagem

            // 4. PRENDA / GIFT
            'is_gift' => $isGift,
            'gift_recipient_name' => $isGift ? $this->faker->name() : null,
            'gift_recipient_email' => $isGift ? $this->faker->safeEmail() : null,
            'gift_message' => $isGift
                ? $this->faker->optional(0.8)->sentence(10)
                : null,

            // 5. CONTROLO
            'access_code' => Str::random(12),

            'created_at' => now()->subDays(rand(0, 20)),
            'updated_at' => now(),
        ];
    }
}
