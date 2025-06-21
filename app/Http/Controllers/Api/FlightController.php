<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FlightResource;
use App\Models\Flight;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Flights",
 *     description="API Endpoints for Flights"
 * )
 */
class FlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *      path="/api/flights",
     *      operationId="getFlightsList",
     *      tags={"Flights"},
     *      summary="Get list of flights",
     *      description="Returns list of flights",
     *      security={{"bearerAuth":{}}},
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/FlightResource")
     *          )
     *       )
     * )
     */
    public function index()
    {
        return FlightResource::collection(Flight::paginate(10));
    }

    /**
     * @OA\Post(
     *      path="/api/flights",
     *      operationId="storeFlight",
     *      tags={"Flights"},
     *      summary="Store new flight",
     *      description="Returns flight data",
     *      security={{"bearerAuth":{}}},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreFlightRequest")
     *      ),
     *      @OA\Response(
     *          response=201,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/FlightResource")
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:flights|max:255',
            'origin' => 'required|string|max:255',
            'destination' => 'required|string|max:255',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date|after:departure_time',
            'price' => 'required|numeric|min:0',
            'aircraft' => 'required|string|max:255',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        $flight = Flight::create($data);

        return new FlightResource($flight);
    }

    /**
     * @OA\Get(
     *      path="/api/flights/{id}",
     *      operationId="getFlightById",
     *      tags={"Flights"},
     *      summary="Get flight information",
     *      description="Returns flight data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Flight id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/FlightResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function show(Flight $flight)
    {
        return new FlightResource($flight);
    }

    /**
     * @OA\Put(
     *      path="/api/flights/{id}",
     *      operationId="updateFlight",
     *      tags={"Flights"},
     *      summary="Update existing flight",
     *      description="Returns updated flight data",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Flight id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/StoreFlightRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/FlightResource")
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Validation error"
     *      )
     * )
     */
    public function update(Request $request, Flight $flight)
    {
        $data = $request->validate([
            'code' => 'sometimes|required|unique:flights,code,' . $flight->id . '|max:255',
            'origin' => 'sometimes|required|string|max:255',
            'destination' => 'sometimes|required|string|max:255',
            'departure_time' => 'sometimes|required|date',
            'arrival_time' => 'sometimes|required|date|after:departure_time',
            'price' => 'sometimes|required|numeric|min:0',
            'aircraft' => 'sometimes|required|string|max:255',
            'status' => 'sometimes|required|in:scheduled,cancelled,completed',
        ]);

        $flight->update($data);

        return new FlightResource($flight);
    }

    /**
     * @OA\Delete(
     *      path="/api/flights/{id}",
     *      operationId="deleteFlight",
     *      tags={"Flights"},
     *      summary="Delete existing flight",
     *      description="Deletes a record and returns no content",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          name="id",
     *          description="Flight id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=204,
     *          description="Successful operation",
     *       ),
     *      @OA\Response(
     *          response=404,
     *          description="Resource Not Found"
     *      )
     * )
     */
    public function destroy(Flight $flight)
    {
        $flight->delete();

        return response()->noContent();
    }
}
