@extends('layouts.app')

@section('title', 'Editar livro')

@section('content')
    <section class="page-header">
        <div>
            <h1>Editar livro</h1>
            <p>Atualize os dados do livro selecionado.</p>
        </div>
    </section>

    <form action="{{ route('books.update', $book) }}" method="POST" class="book-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Título</label>
            <input type="text" id="title" name="title" value="{{ old('title', $book->title) }}" maxlength="255" required>
            @error('title')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="author">Autor</label>
            <input type="text" id="author" name="author" value="{{ old('author', $book->author) }}" maxlength="255" required>
            @error('author')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="category">Categoria</label>
            <input type="text" id="category" name="category" value="{{ old('category', $book->category) }}" maxlength="255" required>
            @error('category')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select id="status" name="status" required>
                <option value="available" @selected(old('status', $book->status) === 'available')>Disponível</option>
                <option value="borrowed" @selected(old('status', $book->status) === 'borrowed')>Emprestado</option>
            </select>
            @error('status')
                <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-actions">
            <a href="{{ route('books.index') }}" class="button">Cancelar</a>
            <button type="submit" class="button">Salvar alterações</button>
        </div>
    </form>
@endsection
