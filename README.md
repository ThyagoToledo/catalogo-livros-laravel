# Catálogo de Livros

CRUD de catálogo de livros desenvolvido como teste técnico.

## Tecnologias

- PHP
- Laravel
- SQLite
- HTML
- CSS
- JavaScript
- Git e GitHub

## Funcionalidades

- [x] Cadastrar livros
- [x] Listar livros
- [x] Editar livros
- [x] Excluir livros
- [x] Buscar e filtrar livros

## Como executar

Primeiro, instale as dependências e prepare o arquivo de ambiente:

```powershell
composer install
npm.cmd install
Copy-Item .env.example .env
php artisan key:generate
php artisan migrate
```

Para iniciar o projeto, abra dois terminais.

No primeiro terminal:

```powershell
php artisan serve
```

No segundo:

```powershell
npm.cmd run dev
```

Os testes podem ser executados com:

```powershell
php artisan test --compact
```
