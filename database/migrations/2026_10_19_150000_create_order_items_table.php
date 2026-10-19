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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();

            // Uma linha sem encomenda não quer dizer nada: vai atrás.
            $table->foreignId('order_id')->constrained()->cascadeOnDelete();

            // Apagar o produto desfaz a ligação, mas a linha fica legível
            // graças às cópias abaixo.
            $table->foreignId('product_variant_id')->nullable()->constrained()->nullOnDelete();

            // Cópias congeladas no momento da compra.
            $table->string('product_name');
            $table->string('variant_label', 40);
            $table->decimal('unit_price', 10, 2);

            $table->unsignedInteger('quantity');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
