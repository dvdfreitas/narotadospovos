# Desenvolvimento local

A aplicação usa PHP, Composer, MySQL e Node.js instalados localmente.
As dependências de testes atuais suportam PHP 8.2 a 8.4.

No `.env`, configura a ligação à base de dados local:

```dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=nrp
DB_USERNAME=nrp
DB_PASSWORD="password do utilizador MySQL nrp"
```

A base de dados e o utilizador MySQL devem existir antes de executar as migrations.
Para instalar as dependências e preparar as tabelas:

```bash
composer install
npm ci
php artisan config:clear
php artisan migrate
```

Para desenvolver, executa `php artisan serve` e, noutro terminal, `npm run dev`.

# Emails do Bazar Solidário e cron

Quando um contributo é confirmado como pago, são colocadas duas mensagens na
fila: a confirmação para o comprador e um aviso interno para
`bazar@narotadospovos.org`, com o resumo e uma ligação ao painel.
O endereço interno pode ser alterado com `BAZAR_NOTIFICATION_ADDRESS`; este é
também o valor por defeito, pelo que não é obrigatório acrescentá-lo ao `.env`.
Cada mensagem tem o seu trabalho na fila e as confirmações repetidas de um
mesmo pagamento não voltam a criar os emails.

No `.env` do **servidor de produção**, configura:

```dotenv
APP_URL=https://www.narotadospovos.org
QUEUE_CONNECTION=database
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_ENCRYPTION=tls
MAIL_USERNAME=bazar@narotadospovos.org
MAIL_PASSWORD="PALAVRA_PASSE_DE_APLICACAO"
MAIL_FROM_ADDRESS=bazar@narotadospovos.org
MAIL_FROM_NAME="Na Rota dos Povos"
BAZAR_NOTIFICATION_ADDRESS=bazar@narotadospovos.org
```

Usa a palavra-passe de aplicação da conta Google e o domínio público real em
`APP_URL`. Depois de publicar o código e atualizar o `.env`, executa na pasta
da aplicação:

```bash
php artisan config:cache
php artisan schedule:list
```

No painel do alojamento, cria **uma única tarefa cron a cada minuto**
(`* * * * *`). No campo do comando, coloca:

```bash
cd /caminho/da/aplicacao && /caminho/do/php artisan schedule:run >> /caminho/da/aplicacao/storage/logs/cron.log 2>&1
```

Substitui os caminhos pelos do servidor. A pasta da aplicação é a que contém
`artisan`, acima de `public`; o PHP deve ser o executável CLI compatível com o
projeto (8.2 a 8.4). Se configurares por `crontab -e`, coloca os cinco asteriscos
antes desse comando. Se já houver uma tarefa para `schedule:run` a cada minuto,
mantém apenas essa entrada.

O agendador já executa a verificação de pagamentos MB Way e o processamento da
fila, definidos em `routes/console.php`. Não é preciso outro cron para o email.
O campo de email do painel do cron é para a saída das tarefas; o destinatário
dos contributos é definido pela aplicação. O comando acima guarda a saída em
`storage/logs/cron.log`.

Para testar apenas o SMTP, envia explicitamente um exemplo:

```bash
php artisan bazar:testar-email bazar@narotadospovos.org
```

Este teste envia imediatamente e não valida o cron. Para verificar o circuito
completo, confirma no próximo contributo pago que chegam os dois emails após
a execução do cron. Para diagnosticar falhas:

```bash
php artisan queue:failed
tail -n 50 storage/logs/cron.log
tail -n 50 storage/logs/laravel.log
```

# Próximos

- Melhorar os "números" na página inicial

Acrescentar testes caso faltam elementos no .env

# YouTube

- Vídeos não estão disponíveis

# Outros

- Acrescentar o link para YouTube no footer

# Fazer um menu sem bibliotecas 

## Guest Layout (retirar)

<script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>

<link href="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.css" rel="stylesheet" />


# Criar um esquema de nomes para as cores

# 


# Ifthenpay

MBWAY_KEY	Chave específica para MBWay
MULTIBANCO_KEY	Chave específica para Multibanco
BACKOFFICE_KEY	Chave geral de autenticação
ENTIDADE	Identificador Multibanco
CALLBACK_URL	Endpoint teu
ANTIPHISHING_KEY	Validação de segurança
