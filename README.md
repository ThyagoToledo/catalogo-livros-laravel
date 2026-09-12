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

- [x] Cadastrar livros
- [x] Listar livros
- [x] Editar livros
- [x] Excluir livros

## O que estou aprendendo

- Aprendi a criar um Model e uma Migration usando o Artisan.
- Entendi que a Migration define a estrutura da tabela no banco de dados.
- Aprendi a usar o `$fillable` para informar quais campos podem ser preenchidos.
- Aprendi a usar um controller resource para organizar as ações do catálogo.
- Entendi como as rotas nomeadas conectam os formulários, o controller e as views.
- Usei a validação do Laravel para impedir o cadastro de dados inválidos.
- Aprendi a preencher o formulário de edição com os dados atuais e preservar os valores após erros de validação.
- Aprendi a enviar exclusões com um formulário protegido por CSRF e a pedir confirmação antes de remover um livro.
- Aprendi a complementar a validação do Laravel com feedback acessível no navegador e a reutilizar os mesmos campos no cadastro e na edição.

## Como desenvolvi

### Banco de dados

Escolhi o SQLite por ser simples para configurar e suficiente para este projeto. Criei a Migration da tabela `books` com os campos `title`, `author`, `category` e `status`.

### Model

Criei o Model `Book` para representar os livros no sistema. Nele, defini os campos que poderão receber dados do formulário.

### Controller

Criei o `BookController` para listar os livros, abrir os formulários e validar, salvar, atualizar e excluir os dados enviados.

### Rotas

Configurei rotas resource para manter as URLs e as ações do catálogo organizadas. A página inicial redireciona para a lista de livros.

### Views

Criei um layout compartilhado e as telas de listagem, cadastro e edição com Blade. Os dois formulários reutilizam os mesmos campos, preservam os dados preenchidos quando há um erro e exibem feedback acessível. A listagem permite excluir um livro após confirmação.

### CSS e JavaScript

Criei um CSS próprio para deixar a navegação, a tabela, os formulários, os botões, os alertas e os estados mais claros. Em telas pequenas, cada livro vira um cartão com ações fáceis de usar.

## Dificuldades e soluções

- **Dificuldade:** digitei o comando `make:model` de forma incorreta no terminal.
- **Solução:** corrigi o comando para `php artisan make:model Book -m` e entendi que a opção `-m` também cria a Migration.

## Próximos passos

- [ ] Impedir o cadastro de livros duplicados.

## Fontes para estudo

- [Controllers](https://laravel.com/docs/13.x/controllers)
- [Rotas](https://laravel.com/docs/13.x/routing)
- [Blade](https://laravel.com/docs/13.x/blade)
- [Proteção CSRF](https://laravel.com/docs/13.x/csrf)
- [Validação](https://laravel.com/docs/13.x/validation)

## Como executar

```powershell
composer install
npm.cmd install
php artisan serve
npm.cmd run dev
```
