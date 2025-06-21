<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Voos</h1>
        <form method="GET" class="flex flex-wrap items-end gap-4 mb-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}" placeholder="Código, origem, destino, aeronave" class="mt-1 block w-48 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-32 border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Todos</option>
                    <option value="scheduled" @selected(request('status') == 'scheduled')>Agendado</option>
                    <option value="cancelled" @selected(request('status') == 'cancelled')>Cancelado</option>
                    <option value="completed" @selected(request('status') == 'completed')>Concluído</option>
                </select>
            </div>
            <div>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Filtrar</button>
                <a href="{{ route('flights.index') }}" class="ml-2 text-gray-600 hover:underline">Limpar</a>
            </div>
        </form>
        @role('admin')
        <a href="{{ route('flights.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">Novo Voo</a>
        @endrole
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Código</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Origem</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Destino</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Aeronave</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Partida</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Chegada</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Preço</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($flights as $flight)
                        <tr>
                            <td class="px-4 py-2">{{ $flight->id }}</td>
                            <td class="px-4 py-2">{{ $flight->code }}</td>
                            <td class="px-4 py-2">{{ $flight->origin }}</td>
                            <td class="px-4 py-2">{{ $flight->destination }}</td>
                            <td class="px-4 py-2">{{ $flight->aircraft }}</td>
                            <td class="px-4 py-2">{{ $flight->departure_time }}</td>
                            <td class="px-4 py-2">{{ $flight->arrival_time }}</td>
                            <td class="px-4 py-2">
                                @php
                                    $statusColors = [
                                        'scheduled' => 'bg-blue-100 text-blue-800',
                                        'cancelled' => 'bg-red-100 text-red-800',
                                        'completed' => 'bg-green-100 text-green-800',
                                    ];
                                @endphp
                                <span class="px-2 py-1 rounded text-xs font-semibold {{ $statusColors[$flight->status] ?? 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($flight->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">R$ {{ number_format($flight->price, 2, ',', '.') }}</td>
                            <td class="px-4 py-2 space-x-2 flex items-center">
                                <a href="{{ route('flights.show', $flight) }}" class="text-blue-600 hover:text-blue-800" title="Ver">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                </a>
                                @role('admin')
                                <a href="{{ route('flights.edit', $flight) }}" class="text-yellow-600 hover:text-yellow-800" title="Editar">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13h3l8-8a2.828 2.828 0 10-4-4l-8 8v3z" /></svg>
                                </a>
                                <form action="{{ route('flights.destroy', $flight) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800" title="Excluir" onclick="return confirm('Tem certeza?')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </form>
                                @endrole
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $flights->links() }}
        </div>
    </div>
</x-app-layout>