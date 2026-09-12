@php
    $currentBook = $book ?? null;
@endphp

<div class="form-group">
    <label for="title">Título</label>
    <input type="text" id="title" name="title" value="{{ old('title', $currentBook?->title) }}" maxlength="255" required aria-describedby="title-feedback" aria-invalid="{{ $errors->has('title') ? 'true' : 'false' }}">
    <p id="title-feedback" class="form-error" aria-live="polite">@error('title'){{ $message }}@enderror</p>
</div>

<div class="form-group">
    <label for="author">Autor</label>
    <input type="text" id="author" name="author" value="{{ old('author', $currentBook?->author) }}" maxlength="255" required aria-describedby="author-feedback" aria-invalid="{{ $errors->has('author') ? 'true' : 'false' }}">
    <p id="author-feedback" class="form-error" aria-live="polite">@error('author'){{ $message }}@enderror</p>
</div>

<div class="form-group">
    <label for="category">Categoria</label>
    <input type="text" id="category" name="category" value="{{ old('category', $currentBook?->category) }}" maxlength="255" required aria-describedby="category-feedback" aria-invalid="{{ $errors->has('category') ? 'true' : 'false' }}">
    <p id="category-feedback" class="form-error" aria-live="polite">@error('category'){{ $message }}@enderror</p>
</div>

<div class="form-group">
    <label for="status">Status</label>
    <select id="status" name="status" required aria-describedby="status-feedback" aria-invalid="{{ $errors->has('status') ? 'true' : 'false' }}">
        <option value="">Selecione um status</option>
        <option value="available" @selected(old('status', $currentBook?->status) === 'available')>Disponível</option>
        <option value="borrowed" @selected(old('status', $currentBook?->status) === 'borrowed')>Emprestado</option>
    </select>
    <p id="status-feedback" class="form-error" aria-live="polite">@error('status'){{ $message }}@enderror</p>
</div>

<div class="form-actions">
    <a href="{{ route('books.index') }}" class="button button-secondary">Cancelar</a>
    <button type="submit" class="button">{{ $submitLabel }}</button>
</div>
