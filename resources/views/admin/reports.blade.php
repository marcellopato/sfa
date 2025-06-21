<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Relatórios') }}
            </h2>
            <a href="{{ route('admin.reports.export') }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-900 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                {{ __('Exportar para CSV') }}
            </a>
        </div>
    </x-slot>

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