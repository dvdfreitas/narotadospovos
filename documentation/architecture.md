# Arquitectura

O essencial para perceber o código.
Detalhe do MB Way em `ifthenpay.md`. O que está por fazer em `backlog.md`.

## Tabelas

- `products` — catálogo de bens. Serve a campanha **e** a loja.
- `product_variants` — o que se compra (1 kg, 5 kg…), cada opção com o seu preço e uma descrição opcional para explicar o conteúdo ou as diferenças.
- `needs` — quanto falta de cada produto, e com que prioridade.
- `orders` + `order_items` — as compras.
- `payments` — **polimórfico**: a mesma tabela serve donativos e encomendas.

## Três regras que explicam o resto

1. **Um produto é vendável se tiver uma variante activa.** Não existe coluna
   `is_sellable` — a resposta vem dos dados.

2. **Dinheiro é `decimal(10,2)`, nunca `float`.** Comparar com `bccomp($a, $b, 2)`,
   multiplicar com `bcmul`. O Eloquent devolve-o como texto, de propósito.

3. **`order_items` guarda cópia do nome e do preço.** Mudar um preço no catálogo
   não altera encomendas antigas.

## Identificadores

| Nome | Quem o cria | Para quê |
|---|---|---|
| `id` | MySQL | interno, nunca em URLs |
| `access_code` | nós | o cliente consulta a encomenda |
| `payments.reference` | nós | enviado à ifthenpay, máx. 15 caracteres, único **por tentativa** |
| `payments.provider_request_id` | ifthenpay | consultar o estado do pagamento |

## Pagamentos

ifthenpay REST v2 — `POST https://api.ifthenpay.com/spg/payment/mbway`.
Chave em `IFTHENPAY_MBWAY_KEY`. O cliente tem **4 minutos** para aprovar na app.

Uma encomenda pode ter **vários** pagamentos: cada tentativa é um registo.
