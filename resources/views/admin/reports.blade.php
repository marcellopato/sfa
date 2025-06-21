<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Relatórios do Sistema</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Voos por Status</h2>
                <ul>
                    <li>Agendados: <span class="font-bold">{{ $flightsByStatus['scheduled'] ?? 0 }}</span></li>
                    <li>Concluídos: <span class="font-bold">{{ $flightsByStatus['completed'] ?? 0 }}</span></li>
                    <li>Cancelados: <span class="font-bold">{{ $flightsByStatus['cancelled'] ?? 0 }}</span></li>
                </ul>
            </div>
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Reservas por Status</h2>
                <ul>
                    <li>Pendentes: <span class="font-bold">{{ $reservationsByStatus['pending'] ?? 0 }}</span></li>
                    <li>Confirmadas: <span class="font-bold">{{ $reservationsByStatus['confirmed'] ?? 0 }}</span></li>
                    <li>Canceladas: <span class="font-bold">{{ $reservationsByStatus['cancelled'] ?? 0 }}</span></li>
                </ul>
            </div>
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Faturamento Total</h2>
                <div class="text-2xl font-bold text-green-700">R$ {{ number_format($totalRevenue, 2, ',', '.') }}</div>
            </div>
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Top 5 Usuários que Mais Reservam</h2>
                <ol class="list-decimal ml-6">
                    @foreach($topUsers as $user)
                        <li>{{ $user->name }} ({{ $user->reservations_count }} reservas)</li>
                    @endforeach
                </ol>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Próximos 10 Voos Agendados</h2>
                <table class="min-w-full text-xs">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Código</th>
                            <th class="px-2 py-1">Origem</th>
                            <th class="px-2 py-1">Destino</th>
                            <th class="px-2 py-1">Partida</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($nextFlights as $flight)
                            <tr>
                                <td class="px-2 py-1">{{ $flight->code }}</td>
                                <td class="px-2 py-1">{{ $flight->origin }}</td>
                                <td class="px-2 py-1">{{ $flight->destination }}</td>
                                <td class="px-2 py-1">{{ $flight->departure_time }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="bg-white rounded shadow p-6">
                <h2 class="text-lg font-semibold mb-4">Top 5 Voos Mais Reservados</h2>
                <table class="min-w-full text-xs">
                    <thead>
                        <tr>
                            <th class="px-2 py-1">Código</th>
                            <th class="px-2 py-1">Reservas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($topFlights as $flight)
                            <tr>
                                <td class="px-2 py-1">{{ $flight->code }}</td>
                                <td class="px-2 py-1">{{ $flight->reservations_count }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="bg-white rounded shadow p-6 mb-8">
            <h2 class="text-lg font-semibold mb-4">Reservas por Dia (Últimos 30 dias)</h2>
            <table class="min-w-full text-xs">
                <thead>
                    <tr>
                        <th class="px-2 py-1">Data</th>
                        <th class="px-2 py-1">Reservas</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservationsByDay as $day => $total)
                        <tr>
                            <td class="px-2 py-1">{{ $day }}</td>
                            <td class="px-2 py-1">{{ $total }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout> 