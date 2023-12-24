# Tests Builder (Gerador de Provas - Escolar)

Projeto desenvolvido com o framework PHP [Laravel](https://laravel.com) e [Inertia](https://inertiajs.com/) para um frontend moderno e responsivo.

## Installation

Clone o repositório:

```sh
git clone https://github.com/bholiveiradev/gerador-provas
cd gerador-provas
```

Instale as dependências do PHP:

```sh
composer install
```

Instale as dependências do NPM:

```sh
npm ci
```

Compile os assets:

```sh
npm run dev
```

Configure as variáveis de ambiente:

```sh
cp .env.example .env
```

Gere a chave da aplicação:

```sh
php artisan key:generate
```

Crie o banco de dados SQLite. Você também pode usar outros bancos (MySQL, Postgres), apenas atualize as configurações necessárias.

```sh
touch database/database.sqlite
```

Rode as migrations:

```sh
php artisan migrate
```

Rode as seeders:

```sh
php artisan db:seed
```

Rode o servidor de desenvolvimento:

```sh
php artisan serve
```

Pronto! A aplicação será aberta no browser, faça login:

- **Username:** johndoe@example.com
- **Password:** secret

## Rodando testes

Para os testes, rode o comando:

```
phpunit
```
