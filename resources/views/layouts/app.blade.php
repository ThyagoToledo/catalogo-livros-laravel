<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Catálogo de Livros')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header class="site-header">
        <div class="container">
            <a class="site-title" href="{{ route('books.index') }}">
                Catálogo de Livros
            </a>

            <nav aria-label="Navegação principal">
                <a href="{{ route('books.index') }}">
                    Lista de livros
                </a>

                <a href="{{ route('books.create') }}">
                    Cadastrar livro
                </a>
            </nav>
        </div>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="alert alert-success" role="status">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>