@extends('layouts.app')

@section('title', 'Editar livro')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar livro</h1>
            <p>Atualize os dados do livro selecionado.</p>
        </div>
    </section>

    <form action="{{ route('books.update', $book) }}" method="POST" class="book-form" data-validate novalidate>
        @csrf
        @method('PUT')
        @include('books._form', ['submitLabel' => 'Salvar alterações'])
    </form>
@endsection
