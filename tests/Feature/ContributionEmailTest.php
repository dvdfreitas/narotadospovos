<?php

use App\Mail\ContributionConfirmed;
use App\Mail\ContributionReceived;
use App\Models\Order;
use App\Models\Payment;
use App\Services\IfThenPay\MbWayClient;
use App\Services\Payments\CheckMbWayPayment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

beforeEach(function () {
    config(['mail.bazar_address' => 'bazar@narotadospovos.org']);
});

function contributo(): Payment
{
    $order = Order::create([
        'total' => '25.00', 'buyer_name' => 'David Freitas',
        'buyer_email' => 'david@exemplo.pt', 'buyer_phone' => '935566333',
    ]);

    $order->items()->create([
        'product_name' => 'Cabaz solidário', 'variant_label' => '1 cabaz',
        'unit_price' => '25.00', 'quantity' => 1,
    ]);

    return $order->payments()->create([
        'reference' => 'T' . fake()->unique()->numberBetween(1, 99999),
        'method' => 'mbway', 'amount' => '25.00',
        'status' => Payment::STATUS_REQUESTED,
        'provider_request_id' => 'REQ-MAIL',
    ]);
}

it('agradece por email quando o contributo é pago', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $payment = (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    expect($payment->status)->toBe(Payment::STATUS_PAID);

    Mail::assertQueued(ContributionConfirmed::class, fn ($mail) =>
        $mail->hasTo('david@exemplo.pt')
        && $mail->order->access_code === $payment->payable->access_code);

    Mail::assertQueued(ContributionReceived::class, fn ($mail) =>
        $mail->hasTo('bazar@narotadospovos.org')
        && $mail->order->id === $payment->payable_id
        && $mail->payment->id === $payment->id);
    Mail::assertQueuedCount(2);
});

it('não agradece quando o pagamento não se concretiza', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '020', 'Message' => 'Declined'])]);

    (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    Mail::assertNothingQueued();
});

it('mantém o pagamento pago mesmo que o email rebente', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    // Um remetente inválido faz o envio rebentar.
    config(['mail.from.address' => '']);
    Mail::shouldReceive('to')->andThrow(new RuntimeException('servidor de email em baixo'));

    $payment = (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    // O dinheiro entrou. Um email que não sai não desfaz isso.
    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID);
});

it('agradece uma só vez quando dois caminhos confirmam ao mesmo tempo', function () {
    Mail::fake();
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    // O ecrã de espera e a notificação carregam o pagamento no mesmo
    // instante: ambos o veem requested, antes de qualquer um confirmar.
    $payment         = contributo();
    $pelaNotificacao = Payment::find($payment->id);
    $peloEcra        = Payment::find($payment->id);

    $check = new CheckMbWayPayment(new MbWayClient('UWP-TESTE'));

    $check->check($pelaNotificacao);
    $primeiraHora = $pelaNotificacao->fresh()->confirmed_at;

    $this->travel(5)->seconds();
    $check->check($peloEcra);

    Mail::assertQueued(ContributionConfirmed::class, 1);
    Mail::assertQueued(ContributionReceived::class, 1);
    Mail::assertQueuedCount(2);

    // Quem chegou em segundo não reescreve a hora de quem chegou primeiro.
    expect($payment->fresh()->confirmed_at->equalTo($primeiraHora))->toBeTrue()
        ->and($peloEcra->status)->toBe(Payment::STATUS_PAID);
});

it('avisa o bazar mesmo que falhe a colocação do email do comprador na fila', function () {
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    Mail::shouldReceive('to')->with('david@exemplo.pt')->once()
        ->andThrow(new RuntimeException('fila indisponível para o comprador'));
    $pending = Mockery::mock(\Illuminate\Mail\PendingMail::class);
    $pending->shouldReceive('send')->once()->with(Mockery::type(ContributionReceived::class));
    Mail::shouldReceive('to')->with('bazar@narotadospovos.org')->once()->andReturn($pending);

    $payment = (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    expect($payment->fresh()->status)->toBe(Payment::STATUS_PAID);
});

it('inclui os dados do contributo e o acesso ao painel no aviso interno', function () {
    $this->travelTo(\Illuminate\Support\Carbon::parse('2026-07-01 12:00:00', 'UTC'));
    $example = ContributionConfirmed::example();
    $mail = new ContributionReceived($example->order, $example->payment);

    expect($mail->envelope()->subject)->toBe('Novo contributo pago — EXEMPLO')
        ->and($mail->render())->toContain(
            'Maria Silva', 'maria@exemplo.pt', 'Cabaz', 'Papas lácteas', '27,50 €',
            '01/07/2026 às 13:00', route('admin.orders', ['q' => 'EXEMPLO']),
        );
});

it('processa os dois emails pela fila da base de dados', function () {
    config(['queue.default' => 'database', 'mail.default' => 'array']);
    Http::fake(['api.ifthenpay.com/*' => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    (new CheckMbWayPayment(new MbWayClient('UWP-TESTE')))->check(contributo());

    $this->assertDatabaseCount('jobs', 2);

    $this->artisan('queue:work', [
        'connection' => 'database', '--stop-when-empty' => true, '--tries' => 1,
    ])->assertSuccessful();

    $this->assertDatabaseCount('jobs', 0);
    $this->assertDatabaseCount('failed_jobs', 0);

    $messages = Mail::mailer()->getSymfonyTransport()->messages();
    expect($messages)->toHaveCount(2);
    expect($messages->map(fn ($message) => $message->getOriginalMessage()->getTo()[0]->getAddress())->all())
        ->toBe(['david@exemplo.pt', 'bazar@narotadospovos.org']);
});

it('envia um email de teste sem gravar nada', function () {
    Mail::fake();

    $this->artisan('bazar:testar-email', ['para' => 'bazar@exemplo.pt'])->assertSuccessful();

    Mail::assertSent(ContributionConfirmed::class, fn ($mail) =>
        $mail->hasTo('bazar@exemplo.pt')
        && $mail->envelope()->subject === '[Teste] Obrigado pelo seu contributo — EXEMPLO'
    );

    expect(Order::count())->toBe(0)
        ->and(Payment::count())->toBe(0);
});

it('recusa um endereço inválido', function () {
    Mail::fake();

    $this->artisan('bazar:testar-email', ['para' => 'isto-nao'])->assertFailed();

    Mail::assertNothingSent();
});

it('o exemplo tem um total que bate certo com as linhas', function () {
    $mail = ContributionConfirmed::example();

    $sum = $mail->order->items->reduce(fn ($sum, $item) => bcadd($sum, $item->lineTotal(), 2), '0.00');

    expect($sum)->toBe($mail->order->total);
});

it('mostra a hora de Portugal no email', function () {
    $this->travelTo(\Illuminate\Support\Carbon::parse('2026-07-01 12:00:00', 'UTC'));

    // Em Julho, Portugal está em UTC+1.
    expect(ContributionConfirmed::example()->render())->toContain('01/07/2026 às 13:00');
});

it('pré-visualiza o email só para administradores', function () {
    config(['app.admin_emails' => ['admin@exemplo.pt']]);

    $this->get('/admin/emails/confirmacao')->assertRedirect('/login');

    $this->actingAs(\App\Models\User::factory()->create(['email' => 'outro@exemplo.pt']))
        ->get('/admin/emails/confirmacao')->assertForbidden();

    $this->actingAs(\App\Models\User::factory()->create(['email' => 'admin@exemplo.pt']))
        ->get('/admin/emails/confirmacao')
        ->assertOk()
        ->assertSee('Obrigado, Maria Silva');
});
