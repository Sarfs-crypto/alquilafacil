<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Category;
use App\Models\Equipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EquipmentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_create_equipment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/equipos', [
            'category_id' => $category->id,
            'name' => 'Laptop Dell XPS',
            'code' => 'LAP-001',
            'daily_price' => 50.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('equipment', ['code' => 'LAP-001']);
    }

    /** @test */
    public function equipment_can_be_rented_only_if_available()
    {
        $equipment = Equipment::factory()->create(['status' => 'available']);
        $this->assertEquals('available', $equipment->status);

        $equipment->update(['status' => 'rented']);
        $this->assertEquals('rented', $equipment->status);
    }

    /** @test */
    public function client_can_view_catalog()
    {
        $client = User::factory()->create(['role' => 'client']);
        $response = $this->actingAs($client)->get('/catalogo');
        $response->assertStatus(200);
    }

    /** @test */
    public function admin_can_set_equipment_to_maintenance()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $equipment = Equipment::factory()->create(['status' => 'available']);

        $response = $this->actingAs($admin)->patch("/admin/equipo/{$equipment->id}/mantenimiento");
        $response->assertRedirect();
        $this->assertDatabaseHas('equipment', ['id' => $equipment->id, 'status' => 'maintenance']);
    }
}