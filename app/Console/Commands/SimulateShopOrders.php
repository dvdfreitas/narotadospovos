<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Payment;
use App\Models\ProductVariant;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

/**
 * Enche a base local com encomendas fictícias da Loja Solidária.
 *
 * Para ver a lista pública e a página de pagamentos com volume — a
 * paginação, o "Ver mais", os anónimos, as pendentes — sem passar pelo
 * checkout uma vez por linha. Para o fluxo de compra em si, usar o
 * IFTHENPAY_FAKE (ver FakeMbWayClient).
 *
 * Só fora de produção: inventa pagamentos que nunca existiram.
 */
class SimulateShopOrders extends Command
{
    protected $signature = 'loja:simular {quantidade=15 : Quantas encomendas criar}';

    protected $description = 'Cria encomendas fictícias da Loja Solidária (só fora de produção)';

    public function handle(): int
    {
        if (app()->isProduction()) {
            $this->error('Não em produção: estas encomendas são inventadas.');

            return self::FAILURE;
        }

        $variants = ProductVariant::with('product')->where('is_active', true)->get();

        if ($variants->isEmpty()) {
            $this->error('Não há produtos activos. Corre primeiro o db:seed.');

            return self::FAILURE;
        }

        $faker = fake('pt_PT');
        $total = (int) $this->argument('quantidade');

        for ($i = 0; $i < $total; $i++) {
            // Cerca de 1 em 5 fica por pagar, para o filtro do admin ter
            // o que mostrar; e 1 em 4 anónima.
            $paid = $faker->boolean(80);
            $when = now()->subMinutes($faker->numberBetween(5, 60 * 24 * 30));

            DB::transaction(function () use ($faker, $variants, $paid, $when) {
                $lines = $variants->random(min($variants->count(), $faker->numberBetween(1, 3)))
                    ->map(fn ($variant) => [
                        'product_variant_id' => $variant->id,
                        'product_name'       => $variant->product->name,
                        'variant_label'      => $variant->label,
                        'unit_price'         => $variant->price,
                        'quantity'           => $faker->numberBetween(1, 4),
                    ]);

                $sum = $lines->reduce(
                    fn ($sum, $line) => bcadd($sum, bcmul($line['unit_price'], (string) $line['quantity'], 2), 2),
                    '0.00',
                );

                $order = Order::create([
                    'status'            => $paid ? Order::STATUS_PAID : Order::STATUS_PENDING,
                    'total'             => $sum,
                    'buyer_name'        => $faker->firstName() . ' ' . $faker->lastName() . ' ' . $faker->lastName(),
                    'buyer_email'       => $faker->unique()->safeEmail(),
                    'buyer_phone'       => '91' . $faker->numerify('#######'),
                    'tax_number'        => $faker->boolean(40) ? $faker->numerify('2########') : null,
                    'is_anonymous'      => $faker->boolean(25),
                    'city'              => $faker->boolean(40) ? $faker->city() : null,
                    'terms_accepted_at' => $when,
                    'paid_at'           => $paid ? $when->copy()->addMinute() : null,
                ]);

                $order->items()->createMany($lines->all());

                $payment = $order->payments()->create([
                    'method'              => 'mbway',
                    'amount'              => $sum,
                    'status'              => $paid ? Payment::STATUS_PAID : Payment::STATUS_EXPIRED,
                    'provider_request_id' => 'FAKE-SEED-' . $order->id,
                    'provider_message'    => 'Simulado',
                    'confirmed_at'        => $order->paid_at,
                ]);
                $payment->assignReference();

                // As datas de criação a condizer, senão tudo parecia de agora.
                $order->forceFill(['created_at' => $when, 'updated_at' => $when])->saveQuietly();
                $payment->forceFill(['created_at' => $when, 'updated_at' => $when])->saveQuietly();
            });
        }

        $this->info("{$total} encomenda(s) fictícia(s) criada(s).");

        return self::SUCCESS;
    }
}
