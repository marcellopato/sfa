<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Flight;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:edit reservations')->only(['edit', 'update']);
        $this->middleware('permission:delete reservations')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'flight']);

        if (!$request->user()->hasRole('admin')) {
            $query->where('user_id', $request->user()->id);
        }
        
        // Busca por código do voo, nome do usuário
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('reservation_code', 'like', "%$search%")
                  ->orWhereHas('flight', function($subq) use ($search) {
                    $subq->where('code', 'like', "%$search%")
                         ->orWhere('origin', 'like', "%$search%")
                         ->orWhere('destination', 'like', "%$search%");
                })->orWhereHas('user', function($subq) use ($search) {
                    $subq->where('name', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
                });
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $reservations = $query->orderByDesc('created_at')->paginate(10)->withQueryString();
        return view('reservations.index', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reservations.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'flight_id' => 'required|exists:flights,id',
        ]);
        
        $flight = Flight::findOrFail($data['flight_id']);

        Reservation::create([
            'user_id' => auth()->id(),
            'flight_id' => $flight->id,
            'reservation_code' => 'SFA-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'reservation_date' => now(),
            'status' => 'confirmed',
            'total_price' => $flight->price,
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reserva criada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $reservation = Reservation::with(['user', 'flight'])->findOrFail($id);
        return view('reservations.show', compact('reservation'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reservation = Reservation::with(['user', 'flight'])->findOrFail($id);
        return view('reservations.edit', compact('reservation'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $data = $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled',
        ]);
        $reservation->update($data);
        return redirect()->route('reservations.index')->with('success', 'Reserva atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();
        return redirect()->route('reservations.index');
    }
}
