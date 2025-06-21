<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Editar Reserva #{{ $reservation->reservation_code }}</h1>
        
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Detalhes do Voo</h2>
            <p><strong>Código:</strong> {{ $reservation->flight->code }}</p>
            <p><strong>Origem:</strong> {{ $reservation->flight->origin }}</p>
            <p><strong>Destino:</strong> {{ $reservation->flight->destination }}</p>
            <p><strong>Data:</strong> {{ $reservation->flight->departure_time->format('d/m/Y H:i') }}</p>
        </div>

        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-lg font-semibold mb-4">Detalhes do Passageiro</h2>
            <p><strong>Nome:</strong> {{ $reservation->user->name }}</p>
            <p><strong>Email:</strong> {{ $reservation->user->email }}</p>
        </div>

        <form action="{{ route('reservations.update', $reservation->id) }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-700">Status da Reserva</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="pending" @selected($reservation->status == 'pending')>Pendente</option>
                    <option value="confirmed" @selected($reservation->status == 'confirmed')>Confirmada</option>
                    <option value="cancelled" @selected($reservation->status == 'cancelled')>Cancelada</option>
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('reservations.index') }}" class="mr-4 text-gray-600">Cancelar</a>
                <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded hover:bg-yellow-700">Atualizar Status</button>
            </div>
        </form>
    </div>
</x-app-layout>