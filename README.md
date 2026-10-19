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

# Próximos

- Setas no Hero
- Melhorar padding e margens
- Melhorar os "números" na página inicial
- Condensar os parceiros

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
