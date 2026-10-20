# Por fazer

Lista directa do que ficou pendente. Actualizar à medida que se resolve.

---

## Antes de a loja ir para o ar

- [ ] **Email de confirmação do contributo.** Não existe. Hoje a pessoa só tem a
  referência no ecrã — se fechar o separador, fica sem comprovativo.
  Falta a mensagem **e** a configuração: `mail.default` está em `log` e o
  remetente é `hello@example.com`, os valores por omissão do Laravel.
  Enviar quando o pagamento ficar `paid`, tanto pela notificação como pelo polling.

- [ ] **Ver a tarifa no contrato.** São 0,09 € por transação nos valores pequenos
  (verificado). Confirmar se se mantém fixa nos valores altos ou se passa a
  percentagem — decide se compensa vender produtos baratos avulso ou só em cabazes.

- [ ] **Preços reais.** Os do `ProductSeeder` são inventados. Substituir.
- [x] **Descrições dos produtos.** Os quatro produtos têm uma descrição curta do contributo de cada compra.
- [ ] **Composição real dos cabazes.** As opções Solidário e Família têm conteúdos exemplificativos para teste, apresentados na janela de descrição. Substituir pelos conteúdos reais antes da venda.
- [x] **Seleção no catálogo.** Cada variante tem uma quantidade independente, sincronizada entre o cartão e a janela de descrição. Permite combinar opções no mesmo produto (0 a 99 unidades por opção), com cálculo exato do total.
- [x] **Manter a seleção.** As quantidades ficam guardadas neste navegador e são recuperadas ao atualizar ou voltar à página. Só são repostas variantes disponíveis, dentro dos limites permitidos; os preços vêm sempre do catálogo atual.
- [x] **Limpar a seleção.** “Limpar tudo” repõe todas as opções a zero e remove as quantidades guardadas, incluindo produtos que já não estão no catálogo. A seleção inicial é vazia e mantém-se vazia após refresh.
- [ ] **Ligar o catálogo ao checkout.** Os botões Comprar seleção, no topo e no fundo, abrem o resumo conjunto mas ainda não criam uma encomenda. Ao implementar, validar a quantidade no servidor e recalcular o total com o preço da variante na base de dados.
- [x] ~~Validar `migrate:fresh --seed`~~ — feito a 2026-10-19, sem erros.

## Acessibilidade da página

### Acesso (quem lá chega)

- [ ] `/loja-solidaria` está **aberta a quem tiver o link**. Tem `X-Robots-Tag: noindex, nofollow`, logo não é indexada — mas não é privada.
- [ ] Decidir antes de aceitar pagamentos reais: deixar aberta, pôr palavra-passe, ou mudar para um caminho não adivinhável.
- [ ] A página **não está no menu**. Se um dia for para o menu, rever o `noindex`.

### Acessibilidade web (a11y)

- [x] Botões "Comprar seleção" identificam o número total de unidades e o valor conjunto para leitores de ecrã. O resumo discrimina produtos, variantes e quantidades.
- [ ] Verificar contraste das cores (`text-neutral-600` sobre branco).
- [ ] Garantir navegação por teclado no fluxo de compra.
- [ ] O preço `4,20 €` é lido bem? Confirmar com leitor de ecrã.
- [ ] Formulário de checkout: `label` associado a cada campo, erros ligados por `aria-describedby`.

## ifthenpay / MB Way

- [x] ~~URL de callback no backoffice~~ — **dispensado.** Usamos o `notificationUrl`,
  enviado em cada pedido. Não é preciso Chave de Backoffice nem corrigir o URL antigo.
  O que lá está (um túnel `sail share` morto) fica inofensivo: nunca dispara, porque
  só dispararia num pagamento bem sucedido e não dependemos dele.
- [ ] **Chave anti-phishing é adivinhável** (nome da organização + ano). Deixou de ser
  crítica — a notificação que usamos é autenticada por HMAC, não por esta chave. Só
  volta a importar se algum dia se activar o callback do backoffice.
- [ ] **`APP_URL` está vazio** no `.env`. Preencher: o `notificationUrl` é construído
  a partir dele, e sem APP_URL não há como gerar o endereço absoluto.
- [ ] **Nunca registar a `mbWayKey` nos logs.** O código antigo fazia-o; não repetir.
- [x] ~~Confirmar o valor mínimo por transação~~ — 0,50 € passou (2026-10-19).
- [ ] Guardar cópia do `storage/logs/laravel.log` antes de `migrate:fresh` — é a prova de que a REST v2 funciona.

## Dívida técnica conhecida

- [ ] **Validar o dígito de controlo do NIF.** Hoje valida-se só `digits:9`, que
  aceita `123456789`. Como vai num recibo, um NIF com gralha é um problema real.
  São ~10 linhas: somar os 8 primeiros dígitos com pesos 9..2 e comparar o resto.

- [ ] **Dois testes antigos falham** por configuração, não por código:
  `ExampleTest` (classe PHPUnit clássica, não apanha o `RefreshDatabase` do Pest) e
  `PagesResponseTest` (faz `artisan('migrate')` à mão, que não combina com SQLite em memória).
- [ ] `config/database.php:61` usa `PDO::MYSQL_ATTR_SSL_CA`, obsoleta no PHP 8.4.
  Faz todos os testes aparecerem como *deprecated* embora passem.

- [ ] **Dois estilos para estados no mesmo projecto.** `Donation` usa um enum (`DonationStatus`),
  `Payment` e `Order` usam constantes de classe. Unificar em enums quando houver tempo.
- [ ] `Donation` usa `$guarded = []` — tudo é gravável em massa. Rever quando houver dados de facturação.
- [ ] Considerar *soft deletes* em `products` se vier a existir admin com botão de apagar.
  Não urgente: a cópia congelada em `order_items` já protege as encomendas.
- [ ] A página de admin `admin.donations-index` **não tem rota**. É inalcançável.
- [ ] **Rotas do Natal comentadas** em `routes/web.php` (`/natal`, `/cards/christmas/{code}`, `/natal/privacidade`).
  Desactivadas porque o modal cria donativos sem pedir pagamento. Descomentar quando o MB Way funcionar
  e a campanha arrancar — nada no menu aponta para lá, por isso é só tirar os `//`.
- [ ] O modal do Natal cria donativos mas **não pede pagamento** (desligado de propósito na limpeza). Religar ao novo cliente MB Way.
- [ ] Os testes usam `DB_DATABASE=testing` na mesma instância de MySQL local. Confirmar que essa base existe, ou pôr `DB_CONNECTION=sqlite` + `:memory:` no `phpunit.xml`.

## Decisões adiadas (não fazer já)

- **Contabilidade das necessidades:** `em falta = quantity − financiado − entregue em espécie`.
  Só pagamentos **confirmados** podem contar, senão qualquer um faz desaparecer uma campanha
  iniciando pagamentos MB Way que nunca aprova.
- **Entregas em espécie:** registar intenção e confirmar entrega.
- **Histórico de preços:** tabela própria com `valid_from`. Só se os preços passarem a mudar com frequência.
- **Tabela `units`:** vocabulário controlado para as unidades base. Só se a loja crescer.
- **Checkout com vários produtos.** O catálogo já reúne vários produtos e variantes num resumo conjunto; falta criar e pagar a encomenda correspondente.
- **Histórico do comprador.** Quem criar conta com o mesmo email deve poder ver o
  que já comprou e contribuiu. Os dados já lá estão (`orders.buyer_email`,
  `donations.donor_email`); falta ligar, por `orders.user_id` nullable.
  **Só mostrar histórico a contas com email verificado** — senão basta registar-se
  com o email de outra pessoa para ver o que comprou, com nome, NIF e morada.
  Implica que a base de produção nunca seja limpa.
- **Guardar os dados do comprador** para não os repetir na compra seguinte.
  Decidir entre conta de utilizador (o Jetstream já lá está) ou só preenchimento
  automático no browser. Se for conta, acrescentar `orders.user_id` nullable —
  é barato de acrescentar depois, por isso não se faz já.
- **NIF:** hoje é `nullable` e opcional no formulário. Confirmar com a contabilidade
  se a Loja Solidária é venda (NIF dispensável) ou donativo (NIF permite dedução no IRS).
- **Facturação pelo site.** Exige software certificado pela AT. Hoje a factura é emitida fora.

## Para rever com calma

- [ ] **`Cache::add()` como trava.** Usado em `shop/index.blade.php`, no
  `checkPayment`, para a consulta à API do MB Way não correr mais do que uma vez
  a cada 10 segundos por pagamento.

  `Cache::add(chave, valor, segundos)` escreve **só se a chave não existir** e
  devolve `true`; se já existir, não faz nada e devolve `false`. Como cada pedido
  HTTP é um processo PHP novo, uma variável não serviria — a cache é o único sítio
  onde "há 3 segundos já perguntei" sobrevive entre pedidos.

  O que falta perceber é porque não se usa `Cache::has()` seguido de `Cache::put()`:
  entre as duas instruções há um intervalo em que dois pedidos simultâneos veem
  ambos "não existe" e ambos chamam a API. O `add` faz as duas numa operação
  indivisível. Mesma ideia do índice único na base de dados.
