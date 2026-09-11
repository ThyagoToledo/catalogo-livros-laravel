# Catálogo de Livros

Projeto de estudos para desenvolver um CRUD de catálogo de livros com Laravel e SQLite.

## Tecnologias

- PHP
- Laravel
- SQLite
- HTML
- CSS
- JavaScript
- Git e GitHub

## Objetivos

- [ ] Cadastrar livros
- [ ] Listar livros
- [ ] Editar livros
- [ ] Excluir livros

## O que estou aprendendo

- Aprendi a criar um Model e uma Migration usando o Artisan.
- Entendi que a Migration define a estrutura da tabela no banco de dados.
- Aprendi a usar o `$fillable` para informar quais campos podem ser preenchidos.

## Como desenvolvi

### Banco de dados

Escolhi o SQLite por ser simples para configurar e suficiente para este projeto. Criei a Migration da tabela `books` com os campos `title`, `author`, `category` e `status`.

### Model

Criei o Model `Book` para representar os livros no sistema. Nele, defini os campos que poderão receber dados do formulário.

### Controller

### Rotas

### Views

### CSS e JavaScript

## Dificuldades e soluções

- **Dificuldade:** digitei o comando `make:model` de forma incorreta no terminal.
- **Solução:** corrigi o comando para `php artisan make:model Book -m` e entendi que a opção `-m` também cria a Migration.

## Próximos passos

- [ ] Criar o controller e configurar as rotas dos livros.

## Como executar

```powershell
composer install
npm.cmd install
php artisan serve
npm.cmd run dev
```
