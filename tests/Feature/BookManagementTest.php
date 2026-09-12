<?php

namespace Tests\Feature;

use App\Models\Book;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_books_list_is_displayed(): void
    {
        Book::create([
            'title' => 'Dom Casmurro',
            'author' => 'Machado de Assis',
            'category' => 'Romance',
            'status' => 'available',
        ]);

        $response = $this->get(route('books.index'));

        $response
            ->assertOk()
            ->assertSee('Dom Casmurro')
            ->assertSee('Machado de Assis')
            ->assertSee('Disponível');
    }

    public function test_a_book_can_be_created(): void
    {
        $book = [
            'title' => 'Quincas Borba',
            'author' => 'Machado de Assis',
            'category' => 'Romance',
            'status' => 'available',
        ];

        $response = $this->post(route('books.store'), $book);

        $response
            ->assertRedirectToRoute('books.index')
            ->assertSessionHas('success', 'Livro cadastrado com sucesso!');

        $this->assertDatabaseHas('books', $book);
    }

    public function test_book_fields_are_required(): void
    {
        $response = $this->post(route('books.store'), []);

        $response
            ->assertSessionHasErrors(['title', 'author', 'category', 'status']);

        $this->assertDatabaseCount('books', 0);
    }

    public function test_edit_form_displays_the_current_book_data(): void
    {
        $book = Book::create([
            'title' => 'Vidas Secas',
            'author' => 'Graciliano Ramos',
            'category' => 'Romance',
            'status' => 'borrowed',
        ]);

        $this->get(route('books.edit', $book))
            ->assertOk()
            ->assertSee('Vidas Secas')
            ->assertSee('Graciliano Ramos')
            ->assertSee('value="borrowed" selected', false);
    }

    public function test_book_update_validation_uses_portuguese_messages_and_keeps_input(): void
    {
        $book = Book::create([
            'title' => 'Vidas Secas',
            'author' => 'Graciliano Ramos',
            'category' => 'Romance',
            'status' => 'available',
        ]);

        $response = $this
            ->from(route('books.edit', $book))
            ->put(route('books.update', $book), [
                'title' => '',
                'author' => 'Autor informado novamente',
                'category' => '',
                'status' => 'invalid',
            ]);

        $response
            ->assertRedirect(route('books.edit', $book))
            ->assertSessionHasErrors([
                'title' => 'O título é obrigatório.',
                'category' => 'A categoria é obrigatória.',
                'status' => 'Selecione um status válido.',
            ])
            ->assertSessionHasInput('author', 'Autor informado novamente');

        $this->get(route('books.edit', $book))
            ->assertSee('value="Autor informado novamente"', false);

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Vidas Secas',
        ]);
    }

    public function test_a_book_can_be_updated(): void
    {
        $book = Book::create([
            'title' => 'O Alienista',
            'author' => 'Machado de Assis',
            'category' => 'Conto',
            'status' => 'available',
        ]);

        $updatedBook = [
            'title' => 'Memórias Póstumas de Brás Cubas',
            'author' => 'Machado de Assis',
            'category' => 'Romance',
            'status' => 'borrowed',
        ];

        $this->put(route('books.update', $book), $updatedBook)
            ->assertRedirectToRoute('books.index')
            ->assertSessionHas('success', 'Livro atualizado com sucesso!');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            ...$updatedBook,
        ]);
    }
}
