<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Reservas</h1>
        <form method="GET" class="flex flex-wrap items-end gap-4 mb-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Voo, usuário, e-mail, origem, destino" class="mt-1 block w-48 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-32 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="pending" @selected(request('status') == 'pending')>Pendente</option>
                    <option value="confirmed" @selected(request('status') == 'confirmed')>Confirmada</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelada</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
                <a href="{{ route('reservations.index') }}" class="ml-2 text-gray-600 hover:underline">Limpar</a>
            </div>
        </form>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Voo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Data da Reserva</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Preço Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Usuário</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="px-4 py-2 font-mono text-sm">{{ $reservation->reservation_code }}</td>
                            <td class="px-4 py-2">{{ $reservation->flight->code ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $reservation->reservation_date->format('d/m/Y H:i') }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-yellow-100 text-yellow-800',
                                        'confirmed' => 'bg-green-100 text-green-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$reservation->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ __(ucfirst($reservation->status)) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">R$ {{ number_format($reservation->total_price, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $reservation->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <a href="{{ route('reservations.show', $reservation) }}" class="text-blue-600 hover:text-blue-800" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                @can('edit reservations')
                                <a href="{{ route('reservations.edit', $reservation) }}" class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3z" /></svg>
                                </a>
                                @endcan
                                @can('delete reservations')
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Excluir" onclick="return confirm('Tem certeza?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $reservations->links() }}
        </div>
    </div>
</x-app-layout>