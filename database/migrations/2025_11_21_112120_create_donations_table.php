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

    $table->string('campaign_slug')->index();
    $table->string('access_code', 64)->unique();

    $table->decimal('amount', 8, 2);
    $table->string('currency', 3)->default('EUR');
    $table->string('status', 20)->default('pendente');

    $table->string('donor_name');
    $table->string('donor_email'); // mais tarde podes encriptar via cast
    $table->string('donor_phone', 30)->nullable();
    $table->string('nif', 20)->nullable();

    $table->boolean('is_anonymous')->default(false);
    $table->json('campaign_data')->nullable();

    $table->timestamp('terms_accepted_at')->nullable();

    $table->timestamps();
    $table->softDeletes();

    $table->index(['campaign_slug', 'status']);
    $table->index(['campaign_slug', 'created_at']);
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
