<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalTest extends TestCase
{
    use RefreshDatabase;

    public function test_rental_creation()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/rentals', [
            'property_id' => 1,
            'start_date' => '2026-08-01',
            'end_date' => '2026-08-05',
        ]);
        $response->assertStatus(302);
    }
}