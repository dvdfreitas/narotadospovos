<x-mail::message>
# Novo contributo pago

Foi confirmado um contributo no Bazar Solidário.

**Referência:** {{ $order->access_code }}<br>
**Nome:** {{ $order->buyer_name }}<br>
**Email:** {{ $order->buyer_email }}<br>
**Data:** {{ $payment->confirmed_at?->copy()->tz('Europe/Lisbon')->format('d/m/Y \à\s H:i') }}

<x-mail::table>
| Produto | Qt. | Valor |
|:--------|:---:|------:|
@foreach ($order->items as $item)
| {{ $item->product_name }} ({{ $item->variant_label }}) | {{ $item->quantity }} | {{ number_format($item->lineTotal(), 2, ',', ' ') }} € |
@endforeach
| **Total** | | **{{ number_format($order->total, 2, ',', ' ') }} €** |
</x-mail::table>

<x-mail::button :url="route('admin.orders', ['q' => $order->access_code])">
Consultar no painel
</x-mail::button>

<x-mail::subcopy>
Notificação interna para a equipa do Bazar Solidário.
</x-mail::subcopy>
</x-mail::message>
