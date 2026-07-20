<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_equipment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $response = $this->actingAs($admin)->post('/admin/equipos', [
            'name' => 'Test Equipment',
            'code' => 'TEST001',
            'daily_price' => 50,
            'category_id' => 1,
        ]);
        $response->assertStatus(302);
    }
}