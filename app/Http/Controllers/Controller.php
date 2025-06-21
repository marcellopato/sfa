<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="SFA - Air Charter Service API",
 *      description="API para o sistema de fretamento de voos SFA.",
 *      @OA\Contact(
 *          email="admin@sfa.com"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 *
 * @OA\Components(
 *      @OA\Schema(
 *          schema="FlightResource",
 *          title="Flight Resource",
 *          description="Flight resource model",
 *          @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *          @OA\Property(property="code", type="string", example="SFA123"),
 *          @OA\Property(property="origin", type="string", example="New York (JFK)"),
 *          @OA\Property(property="destination", type="string", example="Los Angeles (LAX)"),
 *          @OA\Property(property="departure_time", type="string", format="date-time", example="2024-09-01T10:00:00Z"),
 *          @OA\Property(property="arrival_time", type="string", format="date-time", example="2024-09-01T13:00:00Z"),
 *          @OA\Property(property="price", type="number", format="float", example=450.75),
 *          @OA\Property(property="aircraft", type="string", example="Boeing 737"),
 *          @OA\Property(property="status", type="string", enum={"scheduled", "cancelled", "completed"}, example="scheduled"),
 *          @OA\Property(property="created_at", type="string", format="date-time", readOnly=true),
 *          @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true)
 *      ),
 *      @OA\Schema(
 *          schema="StoreFlightRequest",
 *          title="Store Flight Request",
 *          description="Request body for creating or updating a flight",
 *          required={"code", "origin", "destination", "departure_time", "arrival_time", "price", "aircraft", "status"},
 *          @OA\Property(property="code", type="string", example="SFA124"),
 *          @OA\Property(property="origin", type="string", example="Chicago (ORD)"),
 *          @OA\Property(property="destination", type="string", example="Miami (MIA)"),
 *          @OA\Property(property="departure_time", type="string", format="date-time", example="2024-10-15T14:00:00Z"),
 *          @OA\Property(property="arrival_time", type="string", format="date-time", example="2024-10-15T17:30:00Z"),
 *          @OA\Property(property="price", type="number", format="float", example=320.50),
 *          @OA\Property(property="aircraft", type="string", example="Airbus A320"),
 *          @OA\Property(property="status", type="string", enum={"scheduled", "cancelled", "completed"}, example="scheduled")
 *      ),
 *      @OA\Schema(
 *          schema="ReservationResource",
 *          title="Reservation Resource",
 *          description="Reservation resource model",
 *          @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *          @OA\Property(property="reservation_code", type="string", readOnly=true, example="SFA-ABC123D4"),
 *          @OA\Property(property="reservation_date", type="string", format="date-time", readOnly=true),
 *          @OA\Property(property="status", type="string", enum={"confirmed", "cancelled"}, example="confirmed"),
 *          @OA\Property(property="total_price", type="number", format="float", readOnly=true, example=320.50),
 *          @OA\Property(
 *              property="user",
 *              type="object",
 *              @OA\Property(property="id", type="integer", readOnly=true),
 *              @OA\Property(property="name", type="string", readOnly=true),
 *              @OA\Property(property="email", type="string", readOnly=true)
 *          ),
 *          @OA\Property(property="flight", ref="#/components/schemas/FlightResource")
 *      ),
 *      @OA\Schema(
 *          schema="StoreReservationRequest",
 *          title="Store Reservation Request",
 *          description="Request body for creating a reservation",
 *          required={"flight_id"},
 *          @OA\Property(property="flight_id", type="integer", example=1, description="The ID of the flight to reserve")
 *      )
 * )
 *
 * @OA\SecurityScheme(
 *     type="http",
 *     description="Login with email and password to get the authentication token",
 *     name="Token based Based",
 *     in="header",
 *     scheme="bearer",
 *     bearerFormat="JWT",
 *     securityScheme="bearerAuth",
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
