<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_create_rental_request()
    {
        $client = User::factory()->create(['role' => 'client']);
        $response = $this->actingAs($client)->post('/rentals', [
            'equipment_ids' => [1],
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-05',
        ]);
        $response->assertStatus(302);
    }
}