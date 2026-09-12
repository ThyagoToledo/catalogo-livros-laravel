<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class BookController extends Controller
{
    public function index(Request $request): View
    {
        $search = trim($request->string('search')->toString());
        $status = $request->string('status')->toString();

        $books = Book::query()
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($query) use ($search): void {
                    $query
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when(
                in_array($status, ['available', 'borrowed'], true),
                fn ($query) => $query->where('status', $status),
            )
            ->orderBy('title')
            ->get();

        return view('books.index', compact('books', 'search', 'status'));
    }

    public function create(): View
    {
        return view('books.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validateBook($request);

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
        $validated = $this->validateBook($request, $book);

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

    /**
     * @return array{title: string, author: string, category: string, status: string}
     *
     * @throws ValidationException
     */
    private function validateBook(Request $request, ?Book $currentBook = null): array
    {
        $request->merge([
            'title' => is_string($request->input('title')) ? trim($request->input('title')) : $request->input('title'),
            'author' => is_string($request->input('author')) ? trim($request->input('author')) : $request->input('author'),
        ]);

        $validator = Validator::make(
            $request->all(),
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

        $validator->after(function ($validator) use ($request, $currentBook): void {
            if ($validator->errors()->hasAny(['title', 'author'])) {
                return;
            }

            $duplicateExists = Book::query()
                ->where('normalized_title', Str::lower($request->string('title')->toString()))
                ->where('normalized_author', Str::lower($request->string('author')->toString()))
                ->when($currentBook, fn ($query) => $query->whereKeyNot($currentBook->getKey()))
                ->exists();

            if ($duplicateExists) {
                $validator->errors()->add('title', 'Este livro já está cadastrado para o autor informado.');
            }
        });

        return $validator->validate();
    }
}
