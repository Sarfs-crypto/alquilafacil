<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PropertyTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_property()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->post('/properties', [
            'title' => 'Test Property',
            'description' => 'Desc',
            'location' => 'City',
            'price_per_night' => 100,
        ]);
        $response->assertRedirect();
    }
}