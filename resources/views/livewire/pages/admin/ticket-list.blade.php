<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Kelola Tiket</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Kelola semua laporan dari masyarakat</p>
        </div>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari..."
                       class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
            </div>
            <select wire:model.live="status" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)<option value="{{ $s->value }}">{{ $s->label() }}</option>@endforeach
            </select>
            <select wire:model.live="priority" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none">
                <option value="">Semua Prioritas</option>
                @foreach($priorities as $p)<option value="{{ $p->value }}">{{ $p->label() }}</option>@endforeach
            </select>
            <select wire:model.live="category" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)<option value="{{ $c->id }}">{{ $c->name }}</option>@endforeach
            </select>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-dark-border bg-gray-50 dark:bg-gray-800/50">
                        <th class="p-4">Tiket</th>
                        <th class="p-4">Pelapor</th>
                        <th class="p-4">Prioritas</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Petugas</th>
                        <th class="p-4">Tanggal</th>
                        <th class="p-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @forelse($tickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                        <td class="p-4">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="hover:text-primary-600">
                                <p class="text-sm font-medium">{{ Str::limit($ticket->title, 40) }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $ticket->ticket_number }}</p>
                            </a>
                        </td>
                        <td class="p-4">
                            <div class="flex items-center gap-2">
                                <img src="{{ $ticket->user ? $ticket->user->avatar_url : 'https://ui-avatars.com/api/?name='.urlencode($ticket->reporter_name ?? 'Anonim').'&background=EF4444&color=fff' }}" class="w-6 h-6 rounded-md">
                                <span class="text-sm">{{ $ticket->user->name ?? $ticket->reporter_name ?? 'Anonim Darurat' }}</span>
                            </div>
                        </td>
                        <td class="p-4"><span class="px-2 py-0.5 rounded-md text-xs font-medium {{ $ticket->priority->bgClass() }}">{{ $ticket->priority->label() }}</span></td>
                        <td class="p-4">
                            <select wire:change="updateStatus({{ $ticket->id }}, $event.target.value)" class="text-xs px-2 py-1 rounded-lg border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 outline-none">
                                @foreach($statuses as $s)
                                <option value="{{ $s->value }}" {{ $ticket->status === $s ? 'selected' : '' }}>{{ $s->label() }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-4">
                            <select wire:change="assignTicket({{ $ticket->id }}, $event.target.value)" class="text-xs px-2 py-1 rounded-lg border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 outline-none">
                                <option value="">-- Pilih --</option>
                                @foreach($admins as $admin)
                                <option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="p-4 text-sm text-gray-500">{{ $ticket->created_at->format('d/m/Y') }}</td>
                        <td class="p-4">
                            <a href="{{ route('admin.tickets.show', $ticket) }}" class="p-2 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors inline-block">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-12 text-center text-gray-500">Tidak ada tiket ditemukan</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($tickets->hasPages())
        <div class="p-4 border-t border-gray-100 dark:border-dark-border">{{ $tickets->links() }}</div>
        @endif
    </div>
</div>
