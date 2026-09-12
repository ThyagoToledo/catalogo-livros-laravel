<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(): View
    {
        $books = Book::query()
            ->orderBy('title')
            ->get();

        return view('books.index', compact('books'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate(
            [
                'title' => ['required', 'string', 'max:255'],
                'author' => ['required', 'string', 'max:255'],
                'category' => ['required', 'string', 'max:255'],
                'status' => ['required', 'in:available,borrowed'],
            ],
            [
                'title.required' => 'O título é obrigatório.',
                'title.string' => 'O título deve ser um texto.',
                'title.max' => 'O título não pode ter mais de 255 caracteres.',
                'author.required' => 'O autor é obrigatório.',
                'author.string' => 'O autor deve ser um texto.',
                'author.max' => 'O autor não pode ter mais de 255 caracteres.',
                'category.required' => 'A categoria é obrigatória.',
                'category.string' => 'A categoria deve ser um texto.',
                'category.max' => 'A categoria não pode ter mais de 255 caracteres.',
                'status.required' => 'O status é obrigatório.',
                'status.in' => 'Selecione um status válido.',
            ],
        );

        Book::create($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro cadastrado com sucesso!');
    }

    public function edit(Book $book): View
    {
        return view('books.edit', compact('book'));
    }

    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:available,borrowed'],
        ]);

        $book->update($validated);

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro atualizado com sucesso!');
    }

    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()
            ->route('books.index')
            ->with('success', 'Livro excluído com sucesso!');
    }
}
