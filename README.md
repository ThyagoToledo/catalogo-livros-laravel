# Catálogo de Livros

Este é um projeto de estudos que criei para praticar um CRUD com Laravel e SQLite.

## Tecnologias

- PHP
- Laravel
- SQLite
- HTML
- CSS
- JavaScript
- Git e GitHub

## Objetivos

- [x] Cadastrar livros
- [x] Listar livros
- [x] Editar livros
- [x] Excluir livros
- [x] Buscar e filtrar livros

## O que aprendi

- Usei migrations e models para criar e acessar a tabela de livros.
- Organizei o CRUD com um controller resource, rotas nomeadas e views Blade.
- Trabalhei com validação no servidor e no navegador, proteção CSRF e mensagens de erro nos formulários.
- Implementei busca, filtro e uma regra para evitar livros duplicados pelo título e autor.
- Criei testes para os principais fluxos e revisei a navegação por teclado.

## Como desenvolvi

### Banco de dados

Escolhi o SQLite por ser simples para configurar e suficiente para este projeto. Criei a Migration da tabela `books` com os campos `title`, `author`, `category` e `status`.

### Model

Criei o Model `Book` para representar os livros no sistema. Nele, defini os campos que poderão receber dados do formulário.

### Controller

Centralizei no `BookController` as ações de listar, cadastrar, editar e excluir. Também coloquei nele a busca por texto, o filtro por status e a validação que impede livros duplicados.

### Rotas

Configurei rotas resource para manter as URLs e as ações do catálogo organizadas. A página inicial redireciona para a lista de livros.

### Views

Criei um layout compartilhado e as telas de listagem, cadastro e edição com Blade. Cadastro e edição usam os mesmos campos, e a exclusão pede uma confirmação antes de continuar.

### CSS e JavaScript

Fiz o CSS sem biblioteca visual. Em telas menores, as linhas da tabela se transformam em cartões. O JavaScript mostra mensagens de validação em português e leva o foco para o primeiro campo inválido.

## Dificuldades e soluções

- **Dificuldade:** digitei o comando `make:model` de forma incorreta no terminal.
- **Solução:** corrigi o comando para `php artisan make:model Book -m` e entendi que a opção `-m` também cria a Migration.

## Fontes para estudo

- [Controllers](https://laravel.com/docs/13.x/controllers)
- [Rotas](https://laravel.com/docs/13.x/routing)
- [Blade](https://laravel.com/docs/13.x/blade)
- [Proteção CSRF](https://laravel.com/docs/13.x/csrf)
- [Validação](https://laravel.com/docs/13.x/validation)
- [Testes HTTP](https://laravel.com/docs/13.x/http-tests)
- [Banco de dados nos testes](https://laravel.com/docs/13.x/database-testing)

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
