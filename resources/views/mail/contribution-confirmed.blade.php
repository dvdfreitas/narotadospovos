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

**Referência:** {{ $order->access_code }}
**Data:** {{ $payment->confirmed_at?->format('d/m/Y \à\s H:i') }}

Guarde esta referência — é o que identifica o seu contributo se precisar de
falar connosco.

@if ($order->tax_number)
O recibo será emitido com o contribuinte {{ $order->tax_number }}.
@endif

Com os nossos agradecimentos,<br>
{{ config('app.name') }}

<x-mail::subcopy>
Recebeu esta mensagem porque fez um contributo na Loja Solidária.
Se não foi você, responda a este email e nós tratamos do assunto.
</x-mail::subcopy>
</x-mail::message>
