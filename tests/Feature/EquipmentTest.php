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

    public function test_admin_can_create_equipment()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $category = Category::factory()->create();

        $response = $this->actingAs($admin)->post('/admin/equipos', [
            'category_id' => $category->id,
            'name' => 'Laptop Dell',
            'code' => 'LAP-001',
            'daily_price' => 50.00,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('equipment', ['code' => 'LAP-001']);
    }

    public function test_equipment_can_be_rented_only_if_available()
    {
        $equipment = Equipment::factory()->create(['status' => 'available']);
        $this->assertEquals('available', $equipment->status);

        $equipment->update(['status' => 'rented']);
        $this->assertEquals('rented', $equipment->status);
    }

    public function test_client_can_view_catalog()
    {
        $client = User::factory()->create(['role' => 'client']);
        $response = $this->actingAs($client)->get('/catalogo');
        $response->assertStatus(200);
    }

    public function test_equipment_can_be_set_to_maintenance_by_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $equipment = Equipment::factory()->create(['status' => 'available']);

        $response = $this->actingAs($admin)->patch("/admin/equipo/{$equipment->id}/mantenimiento");
        $response->assertRedirect();
        $this->assertDatabaseHas('equipment', ['id' => $equipment->id, 'status' => 'maintenance']);
    }
}