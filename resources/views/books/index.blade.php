@extends('layouts.app')

@section('title', 'Lista de livros')

@section('content')
    <section class="page-header">
        <div>
            <h1>Catálogo de Livros</h1>
            <p>Consulte e gerencie os livros cadastrados.</p>
        </div>

        <a href="{{ route('books.create') }}" class="button">
            Cadastrar livro
        </a>
    </section>


    <section aria-labelledby="books-table-title">
        <h2 id="books-table-title">Livros cadastrados</h2>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th scope="col">Título</th>
                        <th scope="col">Autor</th>
                        <th scope="col">Categoria</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($books as $book)
                        <tr>
                            <td>{{ $book->title }}</td>
                            <td>{{ $book->author }}</td>
                            <td>{{ $book->category }}</td>
                            <td>
                                @if ($book->status === 'available')
                                    Disponível
                                @else
                                    Emprestado
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('books.edit', $book) }}">
                                    Editar
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                Nenhum livro cadastrado.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection
