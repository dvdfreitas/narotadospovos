<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('donations', function (Blueprint $table) {
            $table->id();
           // 1. DADOS FINANCEIROS
            $table->decimal('amount', 8, 2);
            $table->string('donor_email'); // Necessário para recibo/comprovativo
            $table->string('donor_phone');
            $table->string('payment_status')->default('pending');
            $table->string('payment_gateway_id')->nullable();
            $table->string('nif')->nullable();

            // 2. DADOS DO DOADOR
            $table->string('donor_name');

            // 3. EXIBIÇÃO NA ÁRVORE (Público)
            $table->boolean('is_anonymous')->default(false); // Se true, o nome não aparece publicamente
            $table->string('public_message', 140)->nullable(); // Mensagem curta visível na lista/árvore

            // 4. OFERTA / PRENDA
            $table->boolean('is_gift')->default(false);
            $table->string('gift_recipient_name')->nullable();
            $table->string('gift_recipient_email')->nullable(); // Email para enviar o postal/notificação
            $table->text('gift_message')->nullable(); // Mensagem privada para o email da prenda

            // 5. CONTROLO INTERNO
            $table->string('access_code')->nullable()->unique();

            // Colunas temporárias do esquema antigo que foram removidas:
            // is_dedication, dedicated_to_name, dedicated_to_email, dedication_message, show_amount_publicly, show_donor_publicly

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donations');
    }
};
