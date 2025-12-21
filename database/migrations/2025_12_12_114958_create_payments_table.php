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
            $table->foreignId('donation_id')->constrained()->cascadeOnDelete();

            $table->string('method', 30);
            $table->decimal('amount', 10, 2);
            $table->string('status', 20);

            $table->string('provider_request_id', 100)->nullable();
            $table->string('provider_status', 50)->nullable();
            $table->text('provider_message')->nullable();
            $table->json('provider_payload')->nullable();

            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index(['donation_id', 'status']);
            $table->index('provider_request_id');
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
