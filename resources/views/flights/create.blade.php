<x-app-layout>
    <div class="max-w-2xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Novo Voo</h1>
        <form action="{{ route('flights.store') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
            @csrf
            <div>
                <label for="code" class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="code" id="code" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="origin" class="block text-sm font-medium text-gray-700">Origem</label>
                <input type="text" name="origin" id="origin" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="destination" class="block text-sm font-medium text-gray-700">Destino</label>
                <input type="text" name="destination" id="destination" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="departure_time" class="block text-sm font-medium text-gray-700">Partida</label>
                <input type="datetime-local" name="departure_time" id="departure_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="arrival_time" class="block text-sm font-medium text-gray-700">Chegada</label>
                <input type="datetime-local" name="arrival_time" id="arrival_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Preço</label>
                <input type="number" step="0.01" name="price" id="price" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="aircraft" class="block text-sm font-medium text-gray-700">Aeronave</label>
                <input type="text" name="aircraft" id="aircraft" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                <select name="status" id="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
                    <option value="scheduled">Agendado</option>
                    <option value="cancelled">Cancelado</option>
                    <option value="completed">Concluído</option>
                </select>
            </div>
            <div class="flex space-x-2">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Salvar</button>
                <a href="{{ route('flights.index') }}" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Voltar</a>
            </div>
        </form>
    </div>
</x-app-layout>