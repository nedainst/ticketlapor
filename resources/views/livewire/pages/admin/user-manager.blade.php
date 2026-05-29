<div>
    <div class="mb-6 lg:mb-8 flex flex-col lg:flex-row lg:items-end justify-between gap-4">
        <div>
            <h1 class="text-2xl lg:text-3xl font-bold text-gray-900 dark:text-white tracking-tight">Manajemen Pengguna</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Kelola hak akses dan status aktif pengguna di sistem.</p>
        </div>
        
        <div class="w-full lg:w-72">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari nama atau email..."
                       class="w-full pl-10 pr-4 py-2.5 bg-white dark:bg-dark-card border border-gray-200 dark:border-dark-border rounded-xl text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all dark:text-gray-100 placeholder-gray-400 shadow-sm">
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-dark-border">
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-4 text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @forelse ($users as $user)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $user->avatar_url }}" alt="" class="w-10 h-10 rounded-xl object-cover border border-gray-200 dark:border-dark-border">
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <button wire:click="toggleStatus({{ $user->id }})" 
                                        @disabled($user->id === auth()->id() || ($user->hasRole('super_admin') && !auth()->user()->isSuperAdmin()))
                                        class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed
                                        {{ $user->is_active ? 'bg-emerald-500' : 'bg-gray-300 dark:bg-gray-600' }}">
                                    <span class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform
                                          {{ $user->is_active ? 'translate-x-6' : 'translate-x-1' }}"></span>
                                </button>
                                <span class="ml-2 text-xs font-medium {{ $user->is_active ? 'text-emerald-600 dark:text-emerald-400' : 'text-gray-500 dark:text-gray-400' }}">
                                    {{ $user->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $role = $user->roles->first()?->name ?? 'masyarakat';
                                    $isDisabled = $user->id === auth()->id() || ($role === 'super_admin' && !auth()->user()->isSuperAdmin());
                                @endphp
                                @if($isDisabled)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-medium capitalize
                                        {{ $role === 'super_admin' ? 'bg-purple-50 text-purple-700 dark:bg-purple-900/30 dark:text-purple-400' : 
                                           ($role === 'admin' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-400' : 
                                           'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300') }}">
                                        {{ str_replace('_', ' ', $role) }}
                                    </span>
                                @else
                                    <select wire:change="toggleRole({{ $user->id }}, $event.target.value)"
                                            class="text-xs bg-gray-50 dark:bg-gray-800 border border-gray-200 dark:border-dark-border text-gray-700 dark:text-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 block px-2.5 py-1">
                                        <option value="masyarakat" {{ $role === 'masyarakat' ? 'selected' : '' }}>Masyarakat</option>
                                        <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm">
                                <a href="mailto:{{ $user->email }}" class="text-primary-600 hover:text-primary-900 dark:text-primary-400 dark:hover:text-primary-300 inline-flex items-center gap-1 font-medium transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    Email
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                                </div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-1">Tidak ada pengguna</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">Pencarian tidak menemukan hasil yang cocok.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-gray-100 dark:border-dark-border bg-gray-50/50 dark:bg-gray-800/30">
            {{ $users->links() }}
        </div>
        @endif
    </div>
</div>
