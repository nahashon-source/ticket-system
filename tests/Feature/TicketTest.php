<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Ticket;
use App\Models\User;
use App\Models\Category;
use App\Models\Label;
use Tests\TestCase;

class TicketTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function it_creates_a_ticket(): void
    {
        $user = User::factory()->create();
        $category = Category::first(); // Assuming categories exist
        $label = Label::first(); // Assuming labels exist

        $response = $this->postJson('/api/tickets', [
            'title' => 'Test Ticket',
            'description' => 'Test description',
            'priority' => 'high',
            'status' => 'open',
            'user_id' => $user->id,
            'categories' => [$category->id],
            'labels' => [$label->id],
            'files' => [\Illuminate\Http\UploadedFile::fake()->image('test.jpg')],  // Fake file upload
        ]);

        $response->assertStatus(201); // Assert the ticket was created successfully
        $this->assertDatabaseHas('tickets', ['title' => 'Test Ticket']);
        
    }
}
