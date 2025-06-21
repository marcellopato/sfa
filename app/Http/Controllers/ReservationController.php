<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Flight;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Reservation::with(['user', 'flight']);

        // Busca por código do voo, nome do usuário
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('flight', function($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhere('origin', 'like', "%$search%")
                  ->orWhere('destination', 'like', "%$search%")
                  ->orWhere('aircraft', 'like', "%$search%") ;
            })->orWhereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%") ;
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
            'passengers' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'required|numeric',
        ]);
        $data['user_id'] = auth()->id();
        Reservation::create($data);
        return redirect()->route('reservations.index');
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
            'flight_id' => 'required|exists:flights,id',
            'passengers' => 'required|integer|min:1',
            'status' => 'required|in:pending,confirmed,cancelled',
            'total_price' => 'required|numeric',
        ]);
        $reservation->update($data);
        return redirect()->route('reservations.index');
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
