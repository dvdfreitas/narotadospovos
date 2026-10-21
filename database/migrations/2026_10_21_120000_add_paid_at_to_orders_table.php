<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * A hora a que a encomenda ficou paga, copiada do pagamento que a pagou.
     *
     * Podia ler-se de payments.confirmed_at, mas a encomenda tem várias
     * tentativas: ordenar a lista pública por ela obrigava a um join à
     * procura da tentativa certa. O índice serve essa lista.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->timestamp('paid_at')->nullable()->after('terms_accepted_at');
            $table->index(['status', 'paid_at']);
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status', 'paid_at']);
            $table->dropColumn('paid_at');
        });
    }
};
