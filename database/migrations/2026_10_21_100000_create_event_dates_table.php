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
        Schema::create('event_dates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('event_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            // Horas nulas significam o dia inteiro.
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            // Cancela-se um dia de cada vez; cancelar todos cancela o evento.
            $table->boolean('is_cancelled')->default(false);
            $table->timestamps();

            $table->index('date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('event_dates');
    }
};
