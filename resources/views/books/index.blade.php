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
                            <td data-label="Título">{{ $book->title }}</td>
                            <td data-label="Autor">{{ $book->author }}</td>
                            <td data-label="Categoria">{{ $book->category }}</td>
                            <td data-label="Status">
                                @if ($book->status === 'available')
                                    <span class="status status-available">Disponível</span>
                                @else
                                    <span class="status status-borrowed">Emprestado</span>
                                @endif
                            </td>
                            <td data-label="Ações">
                                <div class="table-actions">
                                    <a href="{{ route('books.edit', $book) }}" class="button button-secondary button-small">
                                        Editar
                                    </a>

                                    <form
                                        action="{{ route('books.destroy', $book) }}"
                                        method="POST"
                                        onsubmit="return confirm('Tem certeza que deseja excluir este livro?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button-danger button-small">
                                            Excluir
                                        </button>
                                    </form>
                                </div>
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
