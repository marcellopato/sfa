<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Flight;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsController extends Controller
{
    public function index(Request $request)
    {
        // Voos por status
        $flightsByStatus = Flight::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Próximos 10 voos agendados
        $nextFlights = Flight::where('status', 'scheduled')
            ->where('departure_time', '>=', now())
            ->orderBy('departure_time')
            ->limit(10)
            ->get();

        // Top 5 voos mais reservados
        $topFlights = Flight::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->limit(5)
            ->get();

        // Reservas por status
        $reservationsByStatus = Reservation::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Faturamento total de reservas confirmadas
        $totalRevenue = Reservation::where('status', 'confirmed')->sum('total_price');

        // Reservas por dia nos últimos 30 dias
        $reservationsByDay = Reservation::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as day'), DB::raw('count(*) as total'))
            ->groupBy('day')
            ->orderBy('day')
            ->pluck('total', 'day');

        // Top 5 usuários que mais reservam
        $topUsers = User::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->limit(5)
            ->get();

        return view('admin.reports', compact(
            'flightsByStatus',
            'nextFlights',
            'topFlights',
            'reservationsByStatus',
            'totalRevenue',
            'reservationsByDay',
            'topUsers'
        ));
    }
} 