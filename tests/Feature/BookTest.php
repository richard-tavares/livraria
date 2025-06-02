<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Book;
use App\Models\Author;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BookTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_book(): void
    {
        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $response = $this->postJson('/api/v1/books', [
            'title' => 'Livro de Teste',
            'publisher' => 'Editora Teste',
            'publication_year' => '2024',
            'edition' => 1,
            'price' => 59.90,
            'authors' => [$author->id],
            'subjects' => [$subject->id],
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['title' => 'Livro de Teste']);
    }

    public function test_cannot_create_book_with_invalid_data(): void
    {
        $response = $this->postJson('/api/v1/books', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['title', 'publisher', 'publication_year', 'edition', 'price', 'authors', 'subjects']);
    }

    public function test_can_list_books(): void
    {
        Book::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/books');

        $response->assertOk()
            ->assertJsonCount(2);
    }

    public function test_can_show_single_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->getJson("/api/v1/books/{$book->id}");

        $response->assertOk()
            ->assertJsonFragment(['title' => $book->title]);
    }

    public function test_showing_non_existing_book_returns_404(): void
    {
        $response = $this->getJson('/api/v1/books/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Livro não encontrado.']);
    }

    public function test_can_update_book(): void
    {
        $book = Book::factory()->create();
        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $response = $this->putJson("/api/v1/books/{$book->id}", [
            'title' => 'Atualizado',
            'publisher' => 'Nova Editora',
            'publication_year' => '2023',
            'edition' => 2,
            'price' => 79.90,
            'authors' => [$author->id],
            'subjects' => [$subject->id],
        ]);

        $response->assertOk()
            ->assertJsonFragment(['title' => 'Atualizado']);
    }

    public function test_updating_non_existing_book_returns_404(): void
    {
        $author = Author::factory()->create();
        $subject = Subject::factory()->create();

        $response = $this->putJson('/api/v1/books/999', [
            'title' => 'Qualquer Livro',
            'price' => 59.90,
            'edition' => 1,
            'publication_year' => '2024',
            'publisher' => 'Editora Qualquer',
            'authors' => [$author->id],
            'subjects' => [$subject->id],
        ]);

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Livro não encontrado.']);
    }

    public function test_can_delete_book(): void
    {
        $book = Book::factory()->create();

        $response = $this->deleteJson("/api/v1/books/{$book->id}");

        $response->assertNoContent();
    }

    public function test_deleting_non_existing_book_returns_404(): void
    {
        $response = $this->deleteJson('/api/v1/books/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Livro não encontrado.']);
    }
}
