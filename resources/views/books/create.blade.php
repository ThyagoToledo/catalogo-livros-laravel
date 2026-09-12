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
    >
        @csrf

        <div class="form-group">
            <label for="title">Título</label>

            <input
                type="text"
                id="title"
                name="title"
                value="{{ old('title') }}"
                maxlength="255"
                required
            >

            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="author">Autor</label>

            <input
                type="text"
                id="author"
                name="author"
                value="{{ old('author') }}"
                maxlength="255"
                required
            >

            @error('author')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Categoria</label>

            <input
                type="text"
                id="category"
                name="category"
                value="{{ old('category') }}"
                maxlength="255"
                required
            >

            @error('category')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>

            <select id="status" name="status" required>
                <option value="available" @selected(old('status') === 'available')>
                    Disponível
                </option>

                <option value="borrowed" @selected(old('status') === 'borrowed')>
                    Emprestado
                </option>
            </select>

            @error('status')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('books.index') }}" class="button button-secondary">
                Cancelar
            </a>

            <button type="submit" class="button">
                Salvar livro
            </button>
        </div>
    </form>
@endsection
