<?php

namespace Tests\Feature;

use App\Models\Author;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_author(): void
    {
        $response = $this->postJson('/api/v1/authors', [
            'name' => 'Machado de Assis',
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['name' => 'Machado de Assis']);
    }

    public function test_cannot_create_author_without_name(): void
    {
        $response = $this->postJson('/api/v1/authors', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_cannot_create_author_with_long_name(): void
    {
        $response = $this->postJson('/api/v1/authors', [
            'name' => str_repeat('a', 41),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_can_list_authors(): void
    {
        Author::factory()->count(3)->create();

        $response = $this->getJson('/api/v1/authors');

        $response->assertOk()
            ->assertJsonCount(3);
    }

    public function test_can_show_single_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->getJson("/api/v1/authors/{$author->id}");

        $response->assertOk()
            ->assertJsonFragment(['name' => $author->name]);
    }

    public function test_showing_non_existing_author_returns_404(): void
    {
        $response = $this->getJson('/api/v1/authors/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Autor não encontrado.']);
    }

    public function test_can_update_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/v1/authors/{$author->id}", [
            'name' => 'Novo Nome',
        ]);

        $response->assertOk()
            ->assertJsonFragment(['name' => 'Novo Nome']);
    }

    public function test_cannot_update_author_with_invalid_data(): void
    {
        $author = Author::factory()->create();

        $response = $this->putJson("/api/v1/authors/{$author->id}", [
            'name' => str_repeat('x', 45),
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors('name');
    }

    public function test_updating_non_existing_author_returns_404(): void
    {
        $response = $this->putJson('/api/v1/authors/999', [
            'name' => 'Qualquer Nome',
        ]);

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Autor não encontrado.']);
    }

    public function test_can_delete_author(): void
    {
        $author = Author::factory()->create();

        $response = $this->deleteJson("/api/v1/authors/{$author->id}");

        $response->assertNoContent();
    }

    public function test_deleting_non_existing_author_returns_404(): void
    {
        $response = $this->deleteJson('/api/v1/authors/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Autor não encontrado.']);
    }
}
