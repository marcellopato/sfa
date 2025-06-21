<?php

namespace Tests\Feature;

use App\Models\Flight;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class FlightManagementTest extends TestCase
{
    use RefreshDatabase;

    private $admin;
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        // Seed the roles
        $this->artisan('db:seed', ['--class' => 'PermissionsSeeder']);

        $this->admin = User::factory()->create();
        $this->admin->assignRole('admin');

        $this->user = User::factory()->create();
        $this->user->assignRole('user');
    }

    /** @test */
    public function guests_cannot_manage_flights()
    {
        $flight = Flight::factory()->create();

        $this->get('/flights')->assertOk(); // List is public
        $this->get("/flights/{$flight->id}")->assertOk(); // Show is public

        $this->get('/flights/create')->assertRedirect('/login');
        $this->post('/flights', [])->assertRedirect('/login');
        $this->get("/flights/{$flight->id}/edit")->assertRedirect('/login');
        $this->put("/flights/{$flight->id}", [])->assertRedirect('/login');
        $this->delete("/flights/{$flight->id}")->assertRedirect('/login');
    }

    /** @test */
    public function regular_users_can_view_flights_but_cannot_manage_them()
    {
        $this->actingAs($this->user);
        $flight = Flight::factory()->create();

        $this->get('/flights')->assertOk();
        $this->get("/flights/{$flight->id}")->assertOk();

        $this->get('/flights/create')->assertForbidden();
        $this->get("/flights/{$flight->id}/edit")->assertForbidden();
        $this->post('/flights', [])->assertForbidden();
        $this->put("/flights/{$flight->id}", [])->assertForbidden();
        $this->delete("/flights/{$flight->id}")->assertForbidden();
    }


    /** @test */
    public function admin_can_create_a_flight()
    {
        $this->actingAs($this->admin);

        $flightData = Flight::factory()->make()->toArray();

        $this->post(route('flights.store'), $flightData)
             ->assertRedirect(route('flights.index'));

        $this->assertDatabaseHas('flights', ['code' => $flightData['code']]);
    }

    /** @test */
    public function admin_can_update_a_flight()
    {
        $this->actingAs($this->admin);
        $flight = Flight::factory()->create();
        $updatedData = [
            'code' => 'NEWCODE123',
            'origin' => 'New Origin',
            'destination' => 'New Destination',
            'departure_time' => now()->addDays(2)->toDateTimeString(),
            'arrival_time' => now()->addDays(2)->addHours(3)->toDateTimeString(),
            'price' => 2500.00,
            'aircraft' => 'Boeing 777',
            'status' => 'scheduled',
        ];

        $this->put(route('flights.update', $flight), $updatedData)
             ->assertRedirect(route('flights.index'));

        $this->assertDatabaseHas('flights', ['id' => $flight->id, 'code' => 'NEWCODE123']);
    }

    /** @test */
    public function admin_can_delete_a_flight()
    {
        $this->actingAs($this->admin);
        $flight = Flight::factory()->create();

        $this->delete(route('flights.destroy', $flight))
             ->assertRedirect(route('flights.index'));

        $this->assertDatabaseMissing('flights', ['id' => $flight->id]);
    }

    /** @test */
    public function flight_creation_requires_valid_data()
    {
        $this->actingAs($this->admin);

        // Missing 'code'
        $flightData = Flight::factory()->make(['code' => ''])->toArray();

        $this->post(route('flights.store'), $flightData)
             ->assertSessionHasErrors(['code']);

        $this->assertDatabaseMissing('flights', ['destination' => $flightData['destination']]);
    }

    /** @test */
    public function list_flights_can_be_filtered()
    {
        Flight::factory()->create(['destination' => 'Unfiltered Flight', 'status' => 'scheduled']);
        Flight::factory()->create(['destination' => 'Filtered Flight', 'status' => 'cancelled']);

        $this->get('/flights?status=cancelled')
            ->assertOk()
            ->assertSee('Filtered Flight')
            ->assertDontSee('Unfiltered Flight');

        $this->get('/flights?search=Filtered')
            ->assertOk()
            ->assertSee('Filtered Flight')
            ->assertDontSee('Unfiltered Flight');
    }
} 