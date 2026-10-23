<x-mail::message>
# Obrigado, {{ $order->buyer_name }}

Recebemos o seu contributo e já está confirmado.

<x-mail::table>
| Produto | Qt. | Valor |
|:--------|:---:|------:|
@foreach ($order->items as $item)
| {{ $item->product_name }} ({{ $item->variant_label }}) | {{ $item->quantity }} | {{ number_format($item->lineTotal(), 2, ',', ' ') }} € |
@endforeach
| **Total** | | **{{ number_format($order->total, 2, ',', ' ') }} €** |
</x-mail::table>

{{-- O <br>: em Markdown, duas linhas seguidas juntam-se numa só. A hora
     guarda-se em UTC e mostra-se na de Portugal, que é a do comprador. --}}
**Referência:** {{ $order->access_code }}<br>
**Data:** {{ $payment->confirmed_at?->copy()->tz('Europe/Lisbon')->format('d/m/Y \à\s H:i') }}

Guarde esta referência — é o que identifica o seu contributo se precisar de
falar connosco.

@if ($order->tax_number)
O recibo será emitido com o contribuinte {{ $order->tax_number }}.
@endif

Com os nossos agradecimentos,<br>
{{ config('app.name') }}

<x-mail::subcopy>
Recebeu esta mensagem porque fez um contributo no Bazar Solidário.
Se não foi você, responda a este email e nós tratamos do assunto.
</x-mail::subcopy>
</x-mail::message>
