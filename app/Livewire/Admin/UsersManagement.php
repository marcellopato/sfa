<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class UsersManagement extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;
    public $selectedUserId;
    public $userRoles = [];
    public $isModalOpen = false;

    public function render()
    {
        $users = User::query()
            ->where('name', 'like', '%' . $this->search . '%')
            ->orWhere('email', 'like', '%' . $this->search . '%')
            ->paginate($this->perPage);
        
        $roles = Role::all();

        return view('livewire.admin.users-management', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }

    public function openModal(User $user)
    {
        $this->selectedUserId = $user->id;
        $this->userRoles = $user->roles->pluck('name')->toArray();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->reset(['selectedUserId', 'userRoles']);
    }

    public function updateUserRoles()
    {
        $user = User::findOrFail($this->selectedUserId);
        $user->syncRoles($this->userRoles);
        session()->flash('success', 'Roles atualizadas com sucesso!');
        $this->closeModal();
    }
} 