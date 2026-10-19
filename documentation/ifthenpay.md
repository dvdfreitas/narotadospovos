# ifthenpay / MB Way

Fonte: `mbway-openapi.yaml`, nesta pasta — a especificação oficial, obtida de
https://ifthenpay.com/docs/en/api/mbway/openapi.yaml

Em caso de dúvida, vale o que lá está, não o que está aqui.

## Configuração

| Chave | O que é |
|---|---|
| `mbway_key` | Identifica a nossa conta. É `UWP-628668` — o próprio número do contrato. |
| `anti_phishing_key` | Segredo escolhido por nós. Prova que a notificação vem mesmo deles. Mínimo 15 caracteres. |

Ambas vêm do `.env`: `IFTHENPAY_MBWAY_KEY` e `IFTHENPAY_ANTI_PHISHING_KEY`.

## Endereços

`https://api.ifthenpay.com/spg/payment`

| Caminho | Para quê |
|---|---|
| `POST /mbway` | pedir um pagamento |
| `GET /mbway/status` | consultar o estado |

O corpo do POST é **JSON**.

## O que enviamos

| Campo | Obrigatório | Limite |
|---|---|---|
| `mbWayKey` | sim | — |
| `orderId` | sim | **15 caracteres** |
| `amount` | sim | separador decimal `.` |
| `mobileNumber` | sim | `351#912345678` |
| `email` | não | 100 caracteres |
| `description` | não | 100 caracteres |
| `notificationUrl` | não | 500 caracteres |

### `notificationUrl`

URL que recebe um **POST** com o estado final do pagamento. Enviado **por pedido**,
o que dispensa configurar o callback no backoffice.

É o mecanismo que usamos. Ver secção "Notificações" mais abaixo.

Formato e validação: https://ifthenpay.com/docs/en/guides/callback/#mbway-notification

## O que recebemos ao pedir

Resposta real, verificada a 2026-10-19 (idêntica à de 2025-12-23):

```json
{
  "Amount":    "5.00",
  "Message":   "Success",
  "OrderId":   "T261019122641",
  "RequestId": "HUin7yJoISkagQqYOD5C",
  "Status":    "000"
}
```

**A especificação está errada sobre a resposta.** Diz `orderId` em minúscula,
`Amount` como número e `Message` igual a `"Pending"`. Nenhuma das três se confirma.

Regra: para os limites (`maxLength`) vale a especificação, que não se observa.
Para a forma da resposta vale o que a API devolve.

Usamos só `Status`, `Message` e `RequestId`. O `OrderId` e o `Amount` são os que
nós enviámos — não há razão para guardar uma segunda cópia.

**Guardar sempre o `RequestId`:** é o que identifica a transação para consultas futuras.

## Referências repetidas são aceites

Verificado a 2026-10-19, com dinheiro real: dois pedidos com o **mesmo `orderId`**
geraram `RequestId` diferentes, ambos foram aceites no telemóvel e **ambos foram
cobrados**. A consulta de estado devolveu `Status: 000` para os dois.

A ifthenpay não liga transações pelo `orderId`. São independentes em tudo.

**A ifthenpay não impõe unicidade no `orderId`.** Quem a garante somos nós, pelo
índice único em `payments.reference`.

> **Nunca reenviar um pagamento em `unknown` sem antes confirmar, pela reconciliação,
> se o primeiro foi pago.** Reenviar não retoma — duplica.

O valor mínimo por transação é **0,01 €** (verificado).

## Comissão

**0,09 € por transação**, verificado no backoffice a 2026-10-19 com três pagamentos
de 0,01 €: recebido 0,03 €, tarifas 0,27 €, líquido −0,24 €.

Não é percentagem — nenhuma percentagem transforma 0,01 em 0,09. É taxa fixa, ou
percentagem com mínimo. **Por confirmar no contrato** se se mantém nos valores altos.

Impacto no preço dos produtos:

| Preço | Fica para a ONGD |
|---|---|
| 0,50 € | 0,41 € (−18%) |
| 2,50 € | 2,41 € (−3,6%) |
| 5,00 € | 4,91 € (−1,8%) |

Cada teste pago custa 0,09 € de tarifa, não o valor do pagamento.

## Códigos de estado

O mesmo código significa coisas diferentes consoante o momento.

### Ao pedir (`POST /mbway`)

| Código | Significa |
|---|---|
| `000` | pedido iniciado, **à espera de aceitação** — não está pago |
| `100` | não foi possível iniciar; pode tentar-se de novo |
| `122` | recusado ao utilizador |
| `999` | erro ao iniciar; pode tentar-se de novo |

### Resposta da consulta, verificada

```json
{
  "CreatedAt": "19-10-2026 15:29:45",
  "Message":   "Success",
  "RequestId": "E7DeySPnwJIMBzKgHi3h",
  "Status":    "000",
  "UpdateAt":  "19-10-2026 15:29:59"
}
```

`UpdateAt` vem sem o "d", tal como na especificação. É a hora a que o pagamento
foi aceite — mais exacta do que o nosso `now()` para o `confirmed_at`.

### Ao consultar (`GET /mbway/status`)

| Código | Significa |
|---|---|
| `000` | **pago** |
| `020` | recusado pelo utilizador |
| `101` | expirou |
| `122` | recusado ao utilizador |

A consulta devolve também `CreatedAt`, `UpdateAt` (sem o "d", tal como está na
especificação), `Message` e `RequestId`.

## Prazos

- O cliente tem **4 minutos** para aceitar na app.
- Se a nossa resposta ao callback não for HTTP 200, a ifthenpay repete **13 vezes**:
  8 de 5 em 5 minutos, depois de hora a hora.

## Notificações

Há dois mecanismos. **Usamos o `notificationUrl`.**

| | Callback (backoffice) | `notificationUrl` (por pedido) |
|---|---|---|
| Configuração | no backoffice, exige Chave de Backoffice | enviado em cada pedido |
| Método | GET com query string | **POST com JSON** |
| Dispara quando | só quando é pago | pago, **recusado** e **expirado** |
| Repetições | 13 tentativas | **uma só vez** |
| Autenticação | chave no URL | **assinatura HMAC** no cabeçalho |

### Corpo do POST

```json
{
  "RequestId": "9iCipyBZ2crhtL4QH8Yv",
  "CreatedAt": "13-10-2026 18:13:02",
  "UpdateAt":  "13-10-2026 18:13:15",
  "Status":    "020",
  "Message":   "Declined by user"
}
```

Identifica o pagamento pelo **`RequestId`**, não pelo nosso `orderId`.
Datas em `dd-MM-yyyy HH:mm:ss`.

### Cabeçalhos

```
Content-Type: application/json
X-Ifthenpay-Event-Id: event_almsywu8w4bdozg2tv17
X-Ifthenpay-Signature: b16d24ac…
```

### Validar a assinatura

HMAC SHA-256 de `orderId + amount + requestId` concatenados sem separadores,
com a **MB Way Key** como segredo. Comparar com `hash_equals()`, nunca com `===`.

```php
hash_hmac('sha256', $orderId . $amount . $requestId, $mbWayKey)
```

Vector de teste oficial, verificado:

```
orderId   order_45678
amount    11.55
requestId 36jvlEhUYeknQ8PHKprR
segredo   AAA-000000
→ d7d2fd272233f0102e6dd0e50969025481cdfe3abb87cc3f135f74cfb47b2561
```

### Porque a notificação chega uma só vez

Não há repetições: se o servidor estiver em baixo, perde-se. O endpoint deve
**validar, guardar o corpo cru, responder 200** e só depois processar — um erro
no processamento não pode destruir a notificação.

O polling do estado é, por isso, parte obrigatória do desenho e não uma rede opcional.

## Callback pelo backoffice (não usado)

Alternativa que dispensámos. GET com os parâmetros que nós escolhemos num modelo:

```
?chave=[ANTI_PHISHING_KEY]&orderId=[ORDER_ID]&amount=[AMOUNT]
&requestId=[REQUEST_ID]&payment_datetime=[PAYMENT_DATETIME]
```

Configura-se em **Administração → Contrato/Contas → linha MBWAY → opções**, e exige
a Chave de Backoffice. Limites: URL 300 caracteres, chave anti-phishing 50.

## Apoio

- suporte@ifthenpay.com
- 808 222 777 | +351 256 245 560
