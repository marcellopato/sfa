<div>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Gerenciamento de Usuários</h1>
        <div class="mb-4">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Buscar por nome ou e-mail..." class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
        </div>
        @if (session()->has('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        <div class="overflow-x-auto bg-white rounded shadow">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">ID</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Nome</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">E-mail</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Roles</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ações</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->getRoleNames()->implode(', ') }}</td>
                            <td class="px-4 py-2">
                                <button wire:click="openModal({{ $user->id }})" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Editar Roles</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
    @if($isModalOpen)
    <div class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-xl w-full max-w-md">
            <h2 class="text-xl font-bold mb-4">Editar Roles</h2>
            <form wire:submit.prevent="updateUserRoles">
                <div class="space-y-2">
                    @foreach($roles as $role)
                        <label class="flex items-center">
                            <input type="checkbox" wire:model="userRoles" value="{{ $role->name }}" class="form-checkbox h-5 w-5 text-blue-600">
                            <span class="ml-2 text-gray-700">{{ ucfirst($role->name) }}</span>
                        </label>
                    @endforeach
                </div>
                <div class="mt-4 flex justify-end space-x-2">
                    <button type="button" wire:click="closeModal" class="bg-gray-300 text-gray-800 px-4 py-2 rounded hover:bg-gray-400">Cancelar</button>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Salvar</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div> 