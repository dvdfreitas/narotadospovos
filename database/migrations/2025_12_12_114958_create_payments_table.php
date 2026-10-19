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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            // Nullable porque a referência deriva do id, que só existe depois
            // da inserção. É atribuída logo a seguir, na mesma transação.
            // O índice único permite vários NULL e continua a impedir
            // referências repetidas — que a ifthenpay aceitaria, cobrando
            // duas vezes.
            $table->string('reference', 15)->nullable()->unique();
            $table->morphs('payable');

            $table->string('method', 30)->default('mbway');
            $table->decimal('amount', 10, 2);
            $table->string('status', 20)->default('pending');

            $table->string('provider_request_id', 100)->nullable();
            $table->string('provider_status', 50)->nullable();
            $table->text('provider_message')->nullable();
            $table->json('provider_payload')->nullable();

            $table->timestamp('expires_at')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['status', 'expires_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
