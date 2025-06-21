<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *     name="Reservations",
 *     description="API Endpoints for Reservations"
 * )
 */
class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/reservations",
     *      operationId="getReservationsList",
     *      tags={"Reservations"},
     *      summary="Get list of reservations",
     *      description="Returns list of reservations. Admins see all, users see only their own.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/ReservationResource")
     *          )
     *       )
     * )
     */
    public function index()
    {
        $user = Auth::user();
        $query = Reservation::with('flight', 'user');

        if (!$user->hasRole('admin')) {
            $query->where('user_id', $user->id);
        }

        return ReservationResource::collection($query->paginate(10));
    }

    /**
     * @OA\Post(
     *      path="/api/reservations",
     *      operationId="storeReservation",
     *      tags={"Reservations"},
     *      summary="Store new reservation",
     *      description="Returns reservation data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreReservationRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ReservationResource")
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'flight_id' => 'required|exists:flights,id',
        ]);

        $flight = \App\Models\Flight::findOrFail($data['flight_id']);

        $reservation = Reservation::create([
            'user_id' => Auth::id(),
            'flight_id' => $flight->id,
            'reservation_code' => 'SFA-' . strtoupper(Str::random(8)),
            'reservation_date' => now(),
            'status' => 'confirmed', // ou 'pending' dependendo da regra de negócio
            'total_price' => $flight->price,
        ]);

        return new ReservationResource($reservation->load('flight', 'user'));
    }

    /**
     * @OA\Get(
     *      path="/api/reservations/{id}",
     *      operationId="getReservationById",
     *      tags={"Reservations"},
     *      summary="Get reservation information",
     *      description="Returns reservation data. Users can only see their own reservations.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Reservation id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ReservationResource")
     *       ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function show(Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        return new ReservationResource($reservation->load('flight', 'user'));
    }

    /**
     * @OA\Put(
     *      path="/api/reservations/{id}",
     *      operationId="updateReservation",
     *      tags={"Reservations"},
     *      summary="Update existing reservation status (for admins)",
     *      description="Returns updated reservation data. Only admins can update reservations.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Reservation id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(
     *              required={"status"},
     *              @OA\Property(property="status", type="string", enum={"confirmed", "cancelled"}, example="cancelled")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/ReservationResource")
     *       ),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function update(Request $request, Reservation $reservation)
    {
        $this->authorize('update', $reservation);

        $data = $request->validate([
            'status' => 'required|in:confirmed,cancelled',
        ]);

        $reservation->update($data);

        return new ReservationResource($reservation->load('flight', 'user'));
    }

    /**
     * @OA\Delete(
     *      path="/api/reservations/{id}",
     *      operationId="deleteReservation",
     *      tags={"Reservations"},
     *      summary="Delete existing reservation (for admins)",
     *      description="Deletes a record and returns no content. Only admins can delete reservations.",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Reservation id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(response=204, description="Successful operation"),
     *      @OA\Response(response=403, description="Forbidden"),
     *      @OA\Response(response=404, description="Resource Not Found")
     * )
     */
    public function destroy(Reservation $reservation)
    {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return response()->noContent();
    }
}
