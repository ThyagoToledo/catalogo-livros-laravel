<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Catálogo de Livros')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <a class="skip-link" href="#conteudo-principal">Ir para o conteúdo principal</a>

    <header class="site-header">
        <div class="container">
            <a class="site-title" href="{{ route('books.index') }}">
                Catálogo de Livros
            </a>

            <nav aria-label="Navegação principal">
                <a href="{{ route('books.index') }}" @if (request()->routeIs('books.index', 'books.edit')) aria-current="page" @endif>
                    Lista de livros
                </a>

                <a href="{{ route('books.create') }}" @if (request()->routeIs('books.create')) aria-current="page" @endif>
                    Cadastrar livro
                </a>
            </nav>
        </div>
    </header>

    <main id="conteudo-principal" class="container" tabindex="-1">
        @if (session('success'))
            <div class="alert alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
