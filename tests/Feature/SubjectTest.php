<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Subject;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_subject(): void
    {
        $response = $this->postJson('/api/v1/subjects', [
            'description' => 'Aventura'
        ]);

        $response->assertCreated()
            ->assertJsonFragment(['description' => 'Aventura']);
    }

    public function test_cannot_create_subject_with_invalid_data(): void
    {
        $response = $this->postJson('/api/v1/subjects', []);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['description']);
    }

    public function test_can_list_subjects(): void
    {
        Subject::factory()->count(2)->create();

        $response = $this->getJson('/api/v1/subjects');

        $response->assertOk()
            ->assertJsonCount(2);
    }

    public function test_can_show_single_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->getJson("/api/v1/subjects/{$subject->id}");

        $response->assertOk()
            ->assertJsonFragment(['description' => $subject->description]);
    }

    public function test_showing_non_existing_subject_returns_404(): void
    {
        $response = $this->getJson('/api/v1/subjects/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Assunto não encontrado.']);
    }

    public function test_can_update_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->putJson("/api/v1/subjects/{$subject->id}", [
            'description' => 'Suspense'
        ]);

        $response->assertOk()
            ->assertJsonFragment(['description' => 'Suspense']);
    }

    public function test_updating_non_existing_subject_returns_404(): void
    {
        $response = $this->putJson('/api/v1/subjects/999', [
            'description' => 'Suspense'
        ]);

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Assunto não encontrado.']);
    }

    public function test_can_delete_subject(): void
    {
        $subject = Subject::factory()->create();

        $response = $this->deleteJson("/api/v1/subjects/{$subject->id}");

        $response->assertNoContent();
    }

    public function test_deleting_non_existing_subject_returns_404(): void
    {
        $response = $this->deleteJson('/api/v1/subjects/999');

        $response->assertNotFound()
            ->assertJsonFragment(['message' => 'Assunto não encontrado.']);
    }
}
