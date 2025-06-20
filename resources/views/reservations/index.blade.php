<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Reservas</h1>
        <a href="{{ route('reservations.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded mb-4 hover:bg-blue-700">Nova Reserva</a>
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Voo</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Passageiros</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Preço Total</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Usuário</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($reservations as $reservation)
                        <tr>
                            <td class="px-4 py-2">{{ $reservation->id }}</td>
                            <td class="px-4 py-2">{{ $reservation->flight->code ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $reservation->passengers }}</td>
                            <td class="px-4 py-2">{{ ucfirst($reservation->status) }}</td>
                            <td class="px-4 py-2">R$ {{ number_format($reservation->total_price, 2, ',', '.') }}</td>
                            <td class="px-4 py-2">{{ $reservation->user->name ?? '-' }}</td>
                            <td class="px-4 py-2 space-x-2">
                                <a href="{{ route('reservations.show', $reservation) }}" class="text-blue-600 hover:underline">Ver</a>
                                <a href="{{ route('reservations.edit', $reservation) }}" class="text-yellow-600 hover:underline">Editar</a>
                                <form action="{{ route('reservations.destroy', $reservation) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline" onclick="return confirm('Tem certeza?')">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>