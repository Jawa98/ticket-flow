<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Event;
use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;

class EventApiTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function it_can_create_an_event()
    {
        $eventData = [
            'name' => 'Test Event',
            'description' => 'Test Description',
            'start_date' => '2025-04-25 10:00:00',
            'end_date' => '2025-04-25 12:00:00',
            'ticket_count' => 50,
        ];

        $response = $this->postJson('/api/events', $eventData);

        $response->assertStatus(201)
                 ->assertJson([
                    'data' => [
                        'name' => 'Test Event',
                        'description' => 'Test Description',
                        'start_date' => '2025-04-25 10:00:00',
                        'end_date' => '2025-04-25 12:00:00',
                        'ticket_count' => 50,
                    ]
                ]);

        $this->assertDatabaseHas('events', $eventData);
    }

    #[Test]
    public function it_can_get_all_events()
    {
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'data' => [
                         '*' => ['id', 'name', 'description', 'start_date', 'end_date', 'ticket_count']
                     ],
                     'links' => [
                        'first', 'last', 'prev', 'next'
                    ],
                    'meta' => [
                        'current_page', 'from', 'last_page', 'path', 'per_page', 'to', 'total'
                    ]
                ]);
    }

    #[Test]
    public function it_can_get_a_single_event()
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/events/{$event->id}");

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'id' => $event->id,
                        'name' => $event->name,
                        'description' => $event->description,
                        'start_date' => $event->start_date->format('Y-m-d H:i:s'),
                        'end_date' => $event->end_date->format('Y-m-d H:i:s'),
                        'ticket_count' => $event->ticket_count,
                    ]
                ]);
    }

    #[Test]
    public function it_can_update_an_event()
    {
        $event = Event::factory()->create();

        $updateData = [
            'name' => 'Updated Event Name',
            'description' => 'Updated Description',
            'start_date' => '2025-05-01 08:00:00',
            'end_date' => '2025-05-01 10:00:00',
            'ticket_count' => 100,
        ];

        $response = $this->putJson("/api/events/{$event->id}", $updateData);

        $response->assertStatus(200)
                 ->assertJson([
                    'data' => [
                        'name' => 'Updated Event Name',
                        'description' => 'Updated Description',
                        'start_date' => '2025-05-01 08:00:00',
                        'end_date' => '2025-05-01 10:00:00',
                        'ticket_count' => 100,
                    ]
                ]);

        $this->assertDatabaseHas('events', $updateData);
    }

    #[Test]
    public function it_can_delete_an_event()
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(200)
                 ->assertJson(['message' => 'Deleted successfully!']);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }
}
