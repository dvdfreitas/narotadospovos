<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Marca uma história para ir para o topo de /noticias, ao lado da mais
     * recente. Pode haver várias marcadas: aparece a mais recente delas.
     */
    public function up(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->boolean('is_featured')->default(false)->after('visible');
        });
    }

    public function down(): void
    {
        Schema::table('stories', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
};
