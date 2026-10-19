# MB Way — desenho e plano

Como está pensado o pagamento, e por que ordem se constrói.
Referência dos campos: `ifthenpay.md`. Especificação: `mbway-openapi.yaml`.

## Seis princípios

**1. O `boKey` nunca entra na aplicação web.**
A chave de backoffice permite listar pagamentos, activar callbacks **e emitir
reembolsos**. Uma chave que tira dinheiro da conta não pode estar ao alcance de
um pedido vindo da internet. Fica para comandos de consola, corridos à mão.

**2. Uma notificação nunca basta para marcar como pago.**
A assinatura HMAC usa a `mbWayKey` como segredo: quem a tiver forja notificações
válidas. Ao receber uma, confirmamos sempre com `GET /mbway/status`, que não pode
ser forjado. A notificação é um aviso, não uma prova.

**3. Um timeout não é uma falha — é um "não sei".**
Se a ligação cair depois de a ifthenpay receber o pedido, o telemóvel do cliente
toca na mesma e ele pode pagar. Nunca dizer "falhou" nesse caso.

**4. Gravar o `Payment` antes de chamar a API.**
Sem registo prévio não há referência para a notificação encontrar, nem prova de
que tentámos.

**5. Reenviar duplica, nunca retoma.**
A ifthenpay aceita o mesmo `orderId` duas vezes e cria duas transações. Um pagamento
em `unknown` só se reenvia depois de a reconciliação dizer que o primeiro não foi pago.

**6. Identificadores rebentam, texto trunca.**
Um `orderId` cortado seria enviado diferente do que está gravado. Uma `description`
cortada não faz mal a ninguém.

## Estados do pagamento

| Estado | Significa | Temos `RequestId`? |
|---|---|---|
| `pending` | gravado, ainda não enviado | não |
| `requested` | aceite pela ifthenpay, telemóvel tocou | sim |
| `unknown` | enviado, sem resposta | não |
| `paid` | confirmado pelo `/mbway/status` | sim |
| `rejected` | recusado pelo cliente | sim |
| `expired` | passaram os 4 minutos | sim |
| `failed` | a ifthenpay recusou criar | não |

## O fluxo

```
CHECKOUT
  grava Payment (pending)
  POST /mbway  com notificationUrl = /api/mbway/notify/{reference}
    ├── Status 000          → requested, guarda RequestId
    ├── Status 100/122/999  → failed
    └── timeout / rede      → unknown

NOTIFICAÇÃO  (POST no nosso notificationUrl)
  valida assinatura HMAC
  guarda o corpo cru
  responde 200
  confirma com GET /mbway/status
    └── 000 → paid   020/122 → rejected   101 → expired

POLLING  (job periódico)
  para os que ficaram em requested há mais de 4 minutos
  GET /mbway/status

RECONCILIAÇÃO  (consola, com boKey)
  para os que ficaram em unknown
  List of Payments, procura por orderId
```

## Porque a referência vai no URL da notificação

O corpo da notificação só traz o `RequestId`. No caso do timeout nunca o
recebemos, por isso não teríamos como ligar a notificação ao pagamento.

Pondo a nossa referência no caminho do `notificationUrl`, a notificação
identifica-se sozinha — e o `unknown` resolve-se sem intervenção.

## Plano de construção

| # | Peça | O que faz | Estado |
|---|---|---|---|
| 1 | `MbWayRequestResult` | resposta ao pedido — `wasAccepted()` | **feito** |
| 2 | `MbWayUnavailableException` | distingue falha de rede de recusa | **feito** |
| 3 | `MbWayClient::requestPayment()` | envia o pedido, lê a resposta | **feito** |
| 4 | `MbWayClient::checkStatus()` + `MbWayStatusResult` | consulta o estado | **feito** |
| 5 | Testes do cliente | 13 testes, sem base de dados | **feito** |
| 6 | Estados no `Payment` | constantes e transições | **feito** |
| 7 | Checkout | grava o pagamento e chama o cliente | — |
| 8 | Endpoint da notificação | valida HMAC, confirma com o status | — |
| 9 | Job de polling | resolve os pendentes | — |
| 10 | Comando de reconciliação | consola, com `boKey` | — |
| 11 | Teste ponta a ponta | com telemóvel real | — |

## Por confirmar com a ifthenpay

- Qual a representação de `amount` usada na assinatura: a enviada (`"5.00"`) ou a
  normalizada. Enviamos sempre com duas casas para eliminar a dúvida.
- Se a *List of Payments* mostra pagamentos no próprio dia ou só após liquidação.
