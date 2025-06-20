<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Detalhes da Reserva</h1>
        <div class="bg-white rounded shadow p-6">
            <h5 class="text-lg font-semibold mb-2">Reserva #{{ $reservation->id }}</h5>
            <p class="mb-1"><span class="font-medium">Voo:</span> {{ $reservation->flight->code ?? '-' }}</p>
            <p class="mb-1"><span class="font-medium">Origem:</span> {{ $reservation->flight->origin ?? '-' }}</p>
            <p class="mb-1"><span class="font-medium">Destino:</span> {{ $reservation->flight->destination ?? '-' }}</p>
            <p class="mb-1"><span class="font-medium">Passageiros:</span> {{ $reservation->passengers }}</p>
            <p class="mb-1"><span class="font-medium">Status:</span> {{ ucfirst($reservation->status) }}</p>
            <p class="mb-1"><span class="font-medium">Preço Total:</span> R$ {{ number_format($reservation->total_price, 2, ',', '.') }}</p>
            <p class="mb-1"><span class="font-medium">Usuário:</span> {{ $reservation->user->name ?? '-' }}</p>
        </div>
        <div class="flex space-x-2 mt-4">
            <a href="{{ route('reservations.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Voltar</a>
            <a href="{{ route('reservations.edit', $reservation) }}" class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600">Editar</a>
        </div>
    </div>
</x-app-layout>