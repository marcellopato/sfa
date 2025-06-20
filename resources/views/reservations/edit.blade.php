<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Editar Reserva</h1>
        <form action="{{ route('reservations.update', $reservation) }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf
            @method('PUT')
            <div>
                <label for="flight_id" class="block text-sm font-medium text-gray-700">Voo</label>
                <select name="flight_id" id="flight_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    @foreach(App\Models\Flight::all() as $flight)
                        <option value="{{ $flight->id }}" @selected(old('flight_id', $reservation->flight_id) == $flight->id)>{{ $flight->code }} - {{ $flight->origin }} → {{ $flight->destination }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="passengers" class="block text-sm font-medium text-gray-700">Passageiros</label>
                <input type="number" name="passengers" id="passengers" min="1" value="{{ old('passengers', $reservation->passengers) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="pending" @selected(old('status', $reservation->status) == 'pending')>Pendente</option>
                    <option value="confirmed" @selected(old('status', $reservation->status) == 'confirmed')>Confirmada</option>
                    <option value="cancelled" @selected(old('status', $reservation->status) == 'cancelled')>Cancelada</option>
                </select>
            </div>
            <div>
                <label for="total_price" class="block text-sm font-medium text-gray-700">Preço Total</label>
                <input type="number" step="0.01" name="total_price" id="total_price" value="{{ old('total_price', $reservation->total_price) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Atualizar</button>
                <a href="{{ route('reservations.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Voltar</a>
            </div>
        </form>
    </div>
</x-app-layout>