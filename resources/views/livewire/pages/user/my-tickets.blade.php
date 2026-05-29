<div>
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-2xl font-bold">Laporan Saya</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Daftar semua laporan yang Anda buat</p>
        </div>
        <a href="{{ route('user.tickets.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Buat Laporan
        </a>
    </div>

    {{-- Filters --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-4 mb-6">
        <div class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1">
                <div class="relative">
                    <svg class="w-4 h-4 text-gray-400 absolute left-3 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input wire:model.live.debounce.300ms="search" type="text" placeholder="Cari judul atau nomor tiket..."
                           class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none">
                </div>
            </div>
            <select wire:model.live="status" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                <option value="">Semua Status</option>
                @foreach($statuses as $s)
                <option value="{{ $s->value }}">{{ $s->label() }}</option>
                @endforeach
            </select>
            <select wire:model.live="priority" class="px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                <option value="">Semua Prioritas</option>
                @foreach($priorities as $p)
                <option value="{{ $p->value }}">{{ $p->label() }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- Tickets List --}}
    @if($tickets->count() > 0)
    <div class="space-y-3">
        @foreach($tickets as $ticket)
        <a href="{{ route('user.tickets.show', $ticket) }}" class="block bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft hover:shadow-soft-lg hover:border-primary-200 dark:hover:border-primary-800 transition-all duration-200 p-4 lg:p-5">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: {{ $ticket->category->color }}15;">
                    <span class="text-sm font-bold" style="color: {{ $ticket->category->color }};">{{ substr($ticket->category->name, 0, 2) }}</span>
                </div>
                <div class="min-w-0 flex-1">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h3 class="font-medium text-sm lg:text-base">{{ $ticket->title }}</h3>
                            <div class="flex flex-wrap items-center gap-2 mt-1.5">
                                <span class="text-xs text-gray-400 font-mono">{{ $ticket->ticket_number }}</span>
                                <span class="text-gray-300 dark:text-gray-600">·</span>
                                <span class="text-xs text-gray-400">{{ $ticket->category->name }}</span>
                                <span class="text-gray-300 dark:text-gray-600">·</span>
                                <span class="text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            <span class="px-2 py-0.5 rounded-md text-xs font-medium {{ $ticket->priority->bgClass() }}">{{ $ticket->priority->label() }}</span>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $ticket->status->bgClass() }}">{{ $ticket->status->label() }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $tickets->links() }}
    </div>
    @else
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-12 text-center">
        <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
        </div>
        <h3 class="font-semibold text-gray-700 dark:text-gray-300">Tidak ada laporan ditemukan</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $search || $status || $priority ? 'Coba ubah filter pencarian' : 'Buat laporan pertama Anda' }}</p>
    </div>
    @endif
</div>
