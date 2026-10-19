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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('access_code', 64)->unique();

            $table->string('status', 20)->default('pending');
            $table->decimal('total', 10, 2);

            $table->string('buyer_name');
            $table->string('buyer_email');
            // Sem nullable: o MB Way é o telemóvel. Sem ele não há pagamento.
            $table->string('buyer_phone', 30);
            $table->string('tax_number', 20)->nullable();

            // Esconde o nome na lista pública de contributos.
            // Default false: o anonimato é uma escolha deliberada.
            $table->boolean('is_anonymous')->default(false);

            $table->string('address_line')->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('city')->nullable();

            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
