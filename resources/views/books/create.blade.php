@extends('layouts.app')

@section('title', 'Cadastrar livro')

@section('content')
    <section class="page-header">
        <div>
            <h1>Cadastrar livro</h1>
            <p>Preencha os dados para adicionar um livro ao catálogo.</p>
        </div>
    </section>

    <form
        action="{{ route('books.store') }}"
        method="POST"
        class="book-form"
        data-validate
        novalidate
    >
        @csrf
        @include('books._form', ['submitLabel' => 'Salvar livro'])
    </form>
@endsection
