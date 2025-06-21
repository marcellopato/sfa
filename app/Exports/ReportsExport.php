<?php

namespace App\Exports;

use App\Models\Flight;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReportsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = collect();

        // Seção 1: Voos por Status
        $data->push(['Voos por Status']);
        $flightsByStatus = Flight::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')->get();
        foreach ($flightsByStatus as $row) {
            $data->push([$row->status, $row->total]);
        }
        $data->push([]); // Linha em branco para separar seções

        // Seção 2: Faturamento Total
        $data->push(['Faturamento Total (Reservas Confirmadas)']);
        $totalRevenue = Reservation::where('status', 'confirmed')->sum('total_price');
        $data->push([number_format($totalRevenue, 2, ',', '.')]);
        $data->push([]); // Linha em branco

        // Seção 3: Top 5 Voos Mais Reservados
        $data->push(['Top 5 Voos Mais Reservados']);
        $data->push(['Código do Voo', 'Origem -> Destino', 'Nº de Reservas']);
        $topFlights = Flight::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->limit(5)
            ->get();
        foreach ($topFlights as $flight) {
            $data->push([$flight->code, "{$flight->origin} -> {$flight->destination}", $flight->reservations_count]);
        }
        $data->push([]); // Linha em branco

        // Seção 4: Top 5 Usuários com Mais Reservas
        $data->push(['Top 5 Usuários com Mais Reservas']);
        $data->push(['Nome do Usuário', 'Email', 'Nº de Reservas']);
        $topUsers = User::withCount('reservations')
            ->orderByDesc('reservations_count')
            ->limit(5)
            ->get();
        foreach ($topUsers as $user) {
            $data->push([$user->name, $user->email, $user->reservations_count]);
        }

        return $data;
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        // Adiciona um cabeçalho geral ao arquivo
        return [
            ['Relatório Geral do Sistema - SFA'],
            ['Gerado em: ' . now()->format('d/m/Y H:i:s')],
            [], // Linha em branco
        ];
    }
}
