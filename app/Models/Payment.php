<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

class Payment extends Model
{
    /** Gravado, ainda não enviado à ifthenpay. */
    public const STATUS_PENDING = 'pending';

    /** Enviado e aceite: o telemóvel do cliente tocou, aguarda decisão. */
    public const STATUS_REQUESTED = 'requested';

    /** Enviado sem resposta. O único estado que não afirma nada: pode ter
     *  sido criado e pago. Nunca dizer ao comprador que falhou. */
    public const STATUS_UNKNOWN = 'unknown';

    /** Confirmado pelo /mbway/status. O dinheiro entrou. */
    public const STATUS_PAID = 'paid';

    /** O cliente recusou, ou a recusa foi-lhe apresentada. */
    public const STATUS_REJECTED = 'rejected';

    /** Passaram os 4 minutos sem decisão. Separado de rejected porque
     *  convida a tentar de novo. */
    public const STATUS_EXPIRED = 'expired';

    /** A ifthenpay recusou criar o pedido. Nada foi criado, com certeza. */
    public const STATUS_FAILED = 'failed';

    /**
     * payable_type e payable_id ficam de fora de propósito: um pagamento
     * cria-se sempre através da relação — $order->payments()->create([...]) —
     * que preenche o par sozinho e sem hipótese de o trocar.
     */
    protected $fillable = [
        'reference',
        'method',
        'amount',
        'status',
        'provider_request_id',
        'provider_status',
        'provider_message',
        'provider_payload',
        'expires_at',
        'confirmed_at',
    ];

    /**
     * amount em texto com duas casas, pronto a entregar à ifthenpay.
     * provider_payload guarda o corpo cru da notificação, antes de interpretado.
     * As datas vêm como Carbon, para o polling poder perguntar ->isPast().
     */
    protected $casts = [
        'amount'           => 'decimal:2',
        'provider_payload' => 'array',
        'expires_at'       => 'datetime',
        'confirmed_at'     => 'datetime',
    ];

    /**
     * O que este pagamento está a pagar.
     * Pode ser uma Donation, uma Order, ou o que vier a seguir.
     */
    public function payable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Já não há nada à espera de acontecer a este pagamento.
     *
     * Um pagamento pode ser resolvido por dois caminhos independentes — a
     * notificação e o job de polling — e nada impede que ambos lhe cheguem.
     * Quem chegar em segundo tem de parar aqui, senão reescreve o
     * confirmed_at com uma hora posterior à real.
     */
    public function isFinal(): bool
    {
        return in_array($this->status, [
            self::STATUS_PAID,
            self::STATUS_REJECTED,
            self::STATUS_EXPIRED,
            self::STATUS_FAILED,
        ]);
    }

    /**
     * Atribui a referência que vai ser enviada à ifthenpay.
     *
     * Deriva do id, por isso só pode ser chamada depois de a linha existir.
     *
     * O prefixo é a inicial do ambiente (P, L, T). A base de desenvolvimento
     * é limpa com frequência e os ids voltam ao 1, enquanto a de produção
     * nunca recua — sem prefixo, a sobreposição seria garantida. A ifthenpay
     * guarda o histórico todo e aceita referências repetidas sem reclamar.
     *
     * O contexto legível vai na descrição enviada no pedido, que tem 100
     * caracteres e aparece no backoffice deles.
     */
    public function assignReference(): void
    {
        $this->update([
            'reference' => strtoupper(substr(config('app.env'), 0, 1)) . $this->id,
        ]);
    }

    /**
     * A ifthenpay aceitou o pedido e o telemóvel do cliente tocou.
     *
     * O requestId e a validade são obrigatórios porque não existe um
     * pagamento neste estado sem eles: pedi-los no argumento torna
     * impossível gravar o estado pela metade.
     */
    public function markAsRequested(string $requestId, Carbon $expiresAt): void
    {
        $this->update([
            'status'              => self::STATUS_REQUESTED,
            'provider_request_id' => $requestId,
            'expires_at'          => $expiresAt,
        ]);
    }

    /**
     * Confirmado pelo /mbway/status: o dinheiro entrou.
     *
     * A hora é a nossa, a de quando soubemos. A ifthenpay devolve também
     * a hora a que o pagamento foi aceite (UpdateAt), mais exacta para o
     * recibo — acrescenta-se quando houver quem a passe.
     */
    public function markAsPaid(): void
    {
        $this->update([
            'status'       => self::STATUS_PAID,
            'confirmed_at' => now(),
        ]);
    }

    /**
     * O cliente recusou, ou a recusa foi-lhe apresentada.
     *
     * Sem argumentos: uma recusa não traz dados consigo. O texto que a
     * ifthenpay enviou vive em provider_message.
     */
    public function markAsRejected(): void
    {
        $this->update(['status' => self::STATUS_REJECTED]);
    }

    /**
     * Passaram os 4 minutos sem decisão do cliente.
     *
     * O expires_at diz quando vale a pena perguntar, não decide sozinho:
     * marcar como expirado só depois de o /mbway/status o confirmar. Um
     * relógio adiantado marcaria como expirado um pagamento ainda em curso.
     */
    public function markAsExpired(): void
    {
        $this->update(['status' => self::STATUS_EXPIRED]);
    }

    /**
     * A ifthenpay respondeu e recusou criar o pedido (códigos 100, 122, 999).
     *
     * O que define este estado é a certeza: eles responderam, o telemóvel não
     * tocou, nada ficou pendente. Só por isso é seguro dizer ao comprador que
     * não foi possível e que pode tentar de novo.
     */
    public function markAsFailed(): void
    {
        $this->update(['status' => self::STATUS_FAILED]);
    }

    /**
     * Enviámos e não sabemos o que aconteceu: timeout, ligação caída,
     * HTTP inesperado. O único estado gravado sem a ifthenpay ter dito nada.
     *
     * Não é uma conclusão, é uma confissão. O pedido pode existir e o cliente
     * pode tê-lo aprovado, por isso nunca tratar como falhado: ao comprador
     * diz-se que estamos a confirmar, e a reconciliação resolve depois.
     */
    public function markAsUnknown(): void
    {
        $this->update(['status' => self::STATUS_UNKNOWN]);
    }
}
