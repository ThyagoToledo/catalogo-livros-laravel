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

    public function test_a_duplicate_book_cannot_be_created(): void
    {
        Book::create([
            'title' => 'Água Viva',
            'author' => 'Clarice Lispector',
            'category' => 'Romance',
            'status' => 'available',
        ]);

        $this->post(route('books.store'), [
            'title' => '  ÁGUA VIVA  ',
            'author' => 'CLARICE LISPECTOR',
            'category' => 'Clássico',
            'status' => 'borrowed',
        ])
            ->assertSessionHasErrors([
                'title' => 'Este livro já está cadastrado para o autor informado.',
            ]);

        $this->assertDatabaseCount('books', 1);
        $this->assertDatabaseHas('books', [
            'normalized_title' => 'água viva',
            'normalized_author' => 'clarice lispector',
        ]);
    }

    public function test_book_fields_are_required(): void
    {
        $response = $this->post(route('books.store'), []);

        $response
            ->assertSessionHasErrors(['title', 'author', 'category', 'status']);

        $this->assertDatabaseCount('books', 0);
    }

    public function test_create_form_has_shared_accessible_browser_validation(): void
    {
        $this->get(route('books.create'))
            ->assertOk()
            ->assertSee('data-validate', false)
            ->assertSee('novalidate', false)
            ->assertSee('required aria-describedby="title-feedback" aria-invalid="false"', false)
            ->assertSee('id="title-feedback" class="form-error" aria-live="polite"', false)
            ->assertSee('value="">Selecione um status', false);
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

    public function test_a_book_cannot_be_updated_to_duplicate_another_book(): void
    {
        Book::create([
            'title' => 'Dom Casmurro',
            'author' => 'Machado de Assis',
            'category' => 'Romance',
            'status' => 'available',
        ]);
        $book = Book::create([
            'title' => 'Iracema',
            'author' => 'José de Alencar',
            'category' => 'Romance',
            'status' => 'available',
        ]);

        $this->put(route('books.update', $book), [
            'title' => 'DOM CASMURRO',
            'author' => 'machado de assis',
            'category' => 'Romance',
            'status' => 'borrowed',
        ])->assertSessionHasErrors('title');

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'title' => 'Iracema',
        ]);
    }

    public function test_a_book_can_be_updated_without_conflicting_with_itself(): void
    {
        $book = Book::create([
            'title' => 'O Alienista',
            'author' => 'Machado de Assis',
            'category' => 'Conto',
            'status' => 'available',
        ]);

        $this->put(route('books.update', $book), [
            'title' => 'O Alienista',
            'author' => 'Machado de Assis',
            'category' => 'Clássico',
            'status' => 'borrowed',
        ])->assertSessionDoesntHaveErrors();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            'category' => 'Clássico',
            'status' => 'borrowed',
        ]);
    }

    public function test_books_list_displays_a_protected_deletion_form_with_confirmation(): void
    {
        $book = Book::create([
            'title' => 'Capitães da Areia',
            'author' => 'Jorge Amado',
            'category' => 'Romance',
            'status' => 'available',
        ]);

        $this->get(route('books.index'))
            ->assertOk()
            ->assertSee('action="'.route('books.destroy', $book).'"', false)
            ->assertSee('name="_token"', false)
            ->assertSee('name="_method" value="DELETE"', false)
            ->assertSee("return confirm('Tem certeza que deseja excluir este livro?')", false);
    }

    public function test_a_book_can_be_deleted(): void
    {
        $book = Book::create([
            'title' => 'Iracema',
            'author' => 'José de Alencar',
            'category' => 'Romance',
            'status' => 'borrowed',
        ]);

        $this->delete(route('books.destroy', $book))
            ->assertRedirectToRoute('books.index')
            ->assertSessionHas('success', 'Livro excluído com sucesso!');

        $this->assertDatabaseMissing('books', [
            'id' => $book->id,
        ]);
    }
}
