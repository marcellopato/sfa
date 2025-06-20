<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Detalhes do Voo</h1>
        <div class="bg-white rounded shadow p-6">
            <h5 class="text-lg font-semibold mb-2">{{ $flight->code }}</h5>
            <p class="mb-1"><span class="font-medium">Origem:</span> {{ $flight->origin }}</p>
            <p class="mb-1"><span class="font-medium">Destino:</span> {{ $flight->destination }}</p>
            <p class="mb-1"><span class="font-medium">Aeronave:</span> {{ $flight->aircraft }}</p>
            <p class="mb-1"><span class="font-medium">Partida:</span> {{ $flight->departure_time }}</p>
            <p class="mb-1"><span class="font-medium">Chegada:</span> {{ $flight->arrival_time }}</p>
            <p class="mb-1"><span class="font-medium">Status:</span> {{ ucfirst($flight->status) }}</p>
            <p class="mb-1"><span class="font-medium">Preço:</span> R$ {{ number_format($flight->price, 2, ',', '.') }}</p>
        </div>
        <div class="flex space-x-2 mt-4">
            <a href="{{ route('flights.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Voltar</a>
            <a href="{{ route('flights.edit', $flight) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
        </div>
    </div>
</x-app-layout>