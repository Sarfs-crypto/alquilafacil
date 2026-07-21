<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Equipment;
use App\Models\Rental;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RentalTest extends TestCase
{
    use RefreshDatabase;

    public function test_client_can_create_rental_request()
    {
        $client = User::factory()->create(['role' => 'client']);
        $equipment = Equipment::factory()->create(['status' => 'available']);

        $response = $this->actingAs($client)->post('/rental/solicitar', [
            'equipment_ids' => [$equipment->id],
            'start_date' => now()->addDay()->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('rentals', ['client_id' => $client->id]);
    }

    public function test_client_can_cancel_pending_rental()
    {
        $client = User::factory()->create(['role' => 'client']);
        $rental = Rental::factory()->create([
            'client_id' => $client->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($client)->patch("/rental/{$rental->id}/cancelar");
        $response->assertRedirect();
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'cancelled']);
    }

    public function test_admin_can_approve_rental()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $rental = Rental::factory()->create(['status' => 'pending']);

        $response = $this->actingAs($admin)->patch("/admin/rental/{$rental->id}/aprobar");
        $response->assertRedirect();
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'active']);
    }

    public function test_admin_can_return_rental()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $rental = Rental::factory()->create(['status' => 'active']);

        $response = $this->actingAs($admin)->patch("/admin/rental/{$rental->id}/devolver");
        $response->assertRedirect();
        $this->assertDatabaseHas('rentals', ['id' => $rental->id, 'status' => 'returned']);
    }
}