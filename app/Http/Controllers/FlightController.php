<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;

class FlightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
        $this->middleware('role:admin')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Flight::query();

        // Busca por código, origem, destino ou aeronave
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhere('origin', 'like', "%$search%")
                  ->orWhere('destination', 'like', "%$search%")
                  ->orWhere('aircraft', 'like', "%$search%") ;
            });
        }

        // Filtro por status
        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $flights = $query->orderByDesc('departure_time')->paginate(10)->withQueryString();
        return view('flights.index', compact('flights'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('flights.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|unique:flights',
            'origin' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'price' => 'required|numeric',
            'aircraft' => 'required',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);
        Flight::create($data);
        return redirect()->route('flights.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $flight = Flight::findOrFail($id);
        return view('flights.show', compact('flight'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $flight = \App\Models\Flight::findOrFail($id);
        return view('flights.edit', compact('flight'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $flight = Flight::findOrFail($id);
        $data = $request->validate([
            'code' => 'required|unique:flights,code,'.$flight->id,
            'origin' => 'required',
            'destination' => 'required',
            'departure_time' => 'required|date',
            'arrival_time' => 'required|date',
            'price' => 'required|numeric',
            'aircraft' => 'required',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);
        $flight->update($data);
        return redirect()->route('flights.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $flight = Flight::findOrFail($id);
        $flight->delete();
        return redirect()->route('flights.index');
    }
}
