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
}
