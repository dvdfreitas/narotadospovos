<?php

use App\Services\IfThenPay\MbWayClient;
use App\Services\IfThenPay\MbWayUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Support\Facades\Http;

// Liga a aplicação sem base de dados: o cliente não toca em nada persistido.
uses(Tests\TestCase::class);

const ENDPOINT = 'api.ifthenpay.com/*';

function client(): MbWayClient
{
    return new MbWayClient('UWP-TESTE');
}

function respostaAceite(array $extra = []): array
{
    return array_merge([
        'Amount'    => '0.50',
        'Message'   => 'Success',
        'OrderId'   => 'T1',
        'RequestId' => 'HUin7yJoISkagQqYOD5C',
        'Status'    => '000',
    ], $extra);
}

it('envia os campos no formato que a ifthenpay espera', function () {
    Http::fake([ENDPOINT => Http::response(respostaAceite())]);

    client()->requestPayment('T1', '0.50', '935566333', 'Teste', 'a@b.pt');

    Http::assertSent(function ($request) {
        expect($request->url())->toBe('https://api.ifthenpay.com/spg/payment/mbway');

        return $request['mbWayKey'] === 'UWP-TESTE'
            && $request['orderId'] === 'T1'
            && $request['amount'] === '0.50'
            && $request['mobileNumber'] === '351#935566333'
            && $request['email'] === 'a@b.pt';
    });
});

it('omite o email quando não existe', function () {
    Http::fake([ENDPOINT => Http::response(respostaAceite())]);

    client()->requestPayment('T1', '0.50', '935566333', 'Teste');

    Http::assertSent(fn ($request) => ! array_key_exists('email', $request->data()));
});

it('corta a descrição aos 100 caracteres', function () {
    Http::fake([ENDPOINT => Http::response(respostaAceite())]);

    client()->requestPayment('T1', '0.50', '935566333', str_repeat('a', 150));

    Http::assertSent(fn ($request) => mb_strlen($request['description']) === 100);
});

it('aceita o pedido quando o Status é 000', function () {
    Http::fake([ENDPOINT => Http::response(respostaAceite())]);

    $resultado = client()->requestPayment('T1', '0.50', '935566333', 'Teste');

    expect($resultado->wasAccepted())->toBeTrue()
        ->and($resultado->requestId)->toBe('HUin7yJoISkagQqYOD5C');
});

it('não aceita o pedido quando o Status não é 000', function () {
    Http::fake([ENDPOINT => Http::response(['Status' => '999', 'Message' => 'Error'])]);

    $resultado = client()->requestPayment('T1', '0.50', '935566333', 'Teste');

    expect($resultado->wasAccepted())->toBeFalse()
        ->and($resultado->requestId)->toBeNull();
});

it('trata um erro HTTP como estado desconhecido', function () {
    Http::fake([ENDPOINT => Http::response('<html>manutencao</html>', 500)]);

    client()->requestPayment('T1', '0.50', '935566333', 'Teste');
})->throws(MbWayUnavailableException::class, 'A ifthenpay respondeu HTTP 500');

it('trata uma falha de ligação como estado desconhecido', function () {
    Http::fake(fn () => throw new ConnectionException('cURL error 28: timed out'));

    client()->requestPayment('T1', '0.50', '935566333', 'Teste');
})->throws(MbWayUnavailableException::class);

it('recusa um orderId com mais de 15 caracteres', function () {
    Http::fake();

    client()->requestPayment(str_repeat('X', 16), '0.50', '935566333', 'Teste');
})->throws(InvalidArgumentException::class);


// ---------------------------------------------------------------------------
// checkStatus
// ---------------------------------------------------------------------------

it('consulta o estado com a chave e o requestId na query string', function () {
    Http::fake([ENDPOINT => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    client()->checkStatus('HUin7yJoISkagQqYOD5C');

    Http::assertSent(fn ($request) => $request->url() ===
        'https://api.ifthenpay.com/spg/payment/mbway/status'
        . '?mbWayKey=UWP-TESTE&requestId=HUin7yJoISkagQqYOD5C');
});

it('reconhece um pagamento confirmado', function () {
    Http::fake([ENDPOINT => Http::response(['Status' => '000', 'Message' => 'Success'])]);

    $estado = client()->checkStatus('abc');

    expect($estado->isPaid())->toBeTrue()
        ->and($estado->isRejected())->toBeFalse()
        ->and($estado->isExpired())->toBeFalse();
});

it('reconhece uma recusa do cliente', function () {
    Http::fake([ENDPOINT => Http::response(['Status' => '020', 'Message' => 'Declined by user'])]);

    expect(client()->checkStatus('abc')->isRejected())->toBeTrue();
});

it('reconhece um pedido expirado', function () {
    Http::fake([ENDPOINT => Http::response(['Status' => '101', 'Message' => 'Expired'])]);

    expect(client()->checkStatus('abc')->isExpired())->toBeTrue();
});

it('trata um erro HTTP na consulta como estado desconhecido', function () {
    Http::fake([ENDPOINT => Http::response('', 503)]);

    client()->checkStatus('abc');
})->throws(MbWayUnavailableException::class, 'A ifthenpay respondeu HTTP 503');
