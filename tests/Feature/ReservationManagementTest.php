<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Flight;
use App\Models\Reservation;

class ReservationManagementTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;
    private $otherUser;
    private $flight;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\PermissionsSeeder::class);
        $this->admin = User::factory()->create()->assignRole('admin');
        $this->user = User::factory()->create()->assignRole('user');
        $this->otherUser = User::factory()->create()->assignRole('user');
        $this->flight = Flight::factory()->create();
    }

    public function test_guests_cannot_manage_reservations()
    {
        $this->get('/reservations')->assertRedirect('/login');
        $this->get('/reservations/create')->assertRedirect('/login');
    }

    public function test_user_can_create_and_view_their_own_reservations()
    {
        $this->actingAs($this->user);
        
        // User can access the reservation creation page for a specific flight
        $this->get("/flights/{$this->flight->id}/reservations/create")->assertOk();

        // User can create a reservation
        $reservationData = ['flight_id' => $this->flight->id];
        $this->post("/flights/{$this->flight->id}/reservations", $reservationData)
             ->assertRedirect('/reservations');

        $this->assertDatabaseHas('reservations', [
            'user_id' => $this->user->id,
            'flight_id' => $this->flight->id,
        ]);

        // User can see their own reservations
        $this->get('/reservations')->assertSee($this->flight->code);
    }

    public function test_user_cannot_view_other_users_reservations()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->otherUser->id, 'flight_id' => $this->flight->id]);
        
        $this->actingAs($this->user);
        
        $this->get('/reservations')->assertDontSee($reservation->flight->code);
        $this->get("/reservations/{$reservation->id}")->assertForbidden();
    }

    public function test_user_cannot_create_reservation_for_another_user()
    {
        $this->actingAs($this->user);
        
        $reservationData = ['flight_id' => $this->flight->id, 'user_id' => $this->otherUser->id];
        $this->post("/flights/{$this->flight->id}/reservations", $reservationData);

        $this->assertDatabaseHas('reservations', [
            'flight_id' => $this->flight->id,
            'user_id' => $this->user->id, // Should be the logged-in user's ID
        ]);

        $this->assertDatabaseMissing('reservations', [
            'flight_id' => $this->flight->id,
            'user_id' => $this->otherUser->id,
        ]);
    }

    public function test_admin_can_view_all_reservations()
    {
        Reservation::factory()->create(['user_id' => $this->user->id, 'flight_id' => $this->flight->id]);
        Reservation::factory()->create(['user_id' => $this->otherUser->id, 'flight_id' => Flight::factory()->create()->id]);

        $this->actingAs($this->admin);

        $response = $this->get('/reservations');
        $response->assertOk();
        $this->assertCount(2, Reservation::all());
    }

    public function test_reservation_requires_a_valid_flight()
    {
        $this->actingAs($this->user);
        
        $this->post("/flights/999/reservations", ['flight_id' => 999])
             ->assertNotFound();
    }
}
