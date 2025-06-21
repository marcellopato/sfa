<x-app-layout>
    <div class="max-w-4xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Nova Reserva</h1>
        <form action="{{ route('reservations.store') }}" method="POST" class="bg-white p-6 rounded shadow">
            @csrf
            <div class="mb-4">
                <label for="flight_id" class="block text-sm font-medium text-gray-700">Voo</label>
                <select name="flight_id" id="flight_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">Selecione um voo</option>
                    @foreach(\App\Models\Flight::where('status', 'scheduled')->get() as $flight)
                        <option value="{{ $flight->id }}">
                            {{ $flight->code }} ({{ $flight->origin }} -> {{ $flight->destination }}) - R$ {{ number_format($flight->price, 2, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('reservations.index') }}" class="mr-4 text-gray-600">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Criar Reserva</button>
            </div>
        </form>
    </div>
</x-app-layout>