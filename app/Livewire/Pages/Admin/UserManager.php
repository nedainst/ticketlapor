<?php

namespace App\Livewire\Pages\Admin;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('components.layouts.app')]
#[Title('Manajemen Pengguna')]
class UserManager extends Component
{
    use WithPagination;

    #[Url(as: 'cari')]
    public string $search = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleRole(int $userId, string $newRole)
    {
        // Don't allow changing your own role to prevent lockout
        if ($userId === auth()->id()) {
            $this->dispatch('toast', message: 'Anda tidak dapat mengubah role Anda sendiri.', type: 'error');
            return;
        }

        $user = User::findOrFail($userId);
        
        // Prevent changing super_admin role if not a super_admin
        if ($user->hasRole('super_admin') && !auth()->user()->isSuperAdmin()) {
            $this->dispatch('toast', message: 'Anda tidak berhak mengubah Super Admin.', type: 'error');
            return;
        }

        // Sync new role (this removes old roles and sets the new one)
        $user->syncRoles([$newRole]);

        $this->dispatch('toast', message: "Role {$user->name} berhasil diubah menjadi {$newRole}.", type: 'success');
    }

    public function toggleStatus(int $userId)
    {
        // Don't allow deactivating yourself
        if ($userId === auth()->id()) {
            $this->dispatch('toast', message: 'Anda tidak dapat menonaktifkan akun sendiri.', type: 'error');
            return;
        }

        $user = User::findOrFail($userId);

        if ($user->hasRole('super_admin') && !auth()->user()->isSuperAdmin()) {
            $this->dispatch('toast', message: 'Anda tidak berhak menonaktifkan Super Admin.', type: 'error');
            return;
        }

        $user->update([
            'is_active' => !$user->is_active,
        ]);

        $status = $user->is_active ? 'diaktifkan' : 'dinonaktifkan';
        $this->dispatch('toast', message: "Akun {$user->name} berhasil {$status}.", type: 'success');
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.pages.admin.user-manager', [
            'users' => $users,
        ]);
    }
}
