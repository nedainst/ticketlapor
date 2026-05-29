<div>
    {{-- Welcome --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Selamat Datang, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Pantau dan kelola laporan Anda dari sini</p>
    </div>

    {{-- Quick Action --}}
    <a href="{{ route('user.tickets.create') }}" class="mb-6 flex items-center gap-4 p-4 bg-gradient-to-r from-primary-600 to-primary-700 rounded-2xl text-white shadow-lg shadow-primary-500/20 hover:shadow-xl hover:shadow-primary-500/30 transition-all duration-300 hover:-translate-y-0.5 group">
        <div class="w-12 h-12 bg-white/20 rounded-xl flex items-center justify-center group-hover:scale-110 transition-transform">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <div>
            <p class="font-semibold">Buat Laporan Baru</p>
            <p class="text-primary-100 text-sm">Sampaikan keluhan, saran, atau pengaduan Anda</p>
        </div>
        <svg class="w-5 h-5 ml-auto opacity-70 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>

    {{-- Quick Report Shortcuts --}}
    <div class="mb-6">
        <h2 class="text-sm font-semibold text-gray-500 dark:text-gray-400 mb-3 uppercase tracking-wider">⚡ Laporan Cepat</h2>
        <div class="grid grid-cols-3 sm:grid-cols-4 lg:grid-cols-6 gap-2">
            @foreach($categories as $cat)
            <a href="{{ route('user.tickets.create', ['kategori' => $cat->id]) }}"
               class="group flex flex-col items-center gap-2 p-3 bg-white dark:bg-dark-card rounded-xl border border-gray-100 dark:border-dark-border hover:border-primary-300 dark:hover:border-primary-700 hover:shadow-soft transition-all duration-200 hover:-translate-y-0.5">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center transition-transform group-hover:scale-110" style="background-color: {{ $cat->color }}15;">
                    <span class="text-sm font-bold" style="color: {{ $cat->color }};">{{ substr($cat->name, 0, 2) }}</span>
                </div>
                <span class="text-[11px] font-medium text-gray-600 dark:text-gray-400 text-center leading-tight truncate w-full">{{ $cat->name }}</span>
            </a>
            @endforeach
        </div>
    </div>

    {{-- Stats Grid --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $totalTickets }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Total Laporan</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $pendingTickets }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Menunggu</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $processedTickets }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Diproses</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center gap-3 mb-3">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $resolvedTickets }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">Selesai</p>
        </div>
    </div>

    {{-- Recent Tickets --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft">
        <div class="p-5 border-b border-gray-100 dark:border-dark-border flex items-center justify-between">
            <h2 class="font-semibold">Laporan Terbaru</h2>
            <a href="{{ route('user.tickets') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua →</a>
        </div>

        @if($recentTickets->count() > 0)
        <div class="divide-y divide-gray-100 dark:divide-dark-border">
            @foreach($recentTickets as $ticket)
            <a href="{{ route('user.tickets.show', $ticket) }}" class="flex items-center gap-4 p-4 hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0" style="background-color: {{ $ticket->category->color }}15;">
                    <span class="text-sm font-bold" style="color: {{ $ticket->category->color }};">{{ substr($ticket->category->name, 0, 2) }}</span>
                </div>
                <div class="min-w-0 flex-1">
                    <p class="font-medium text-sm truncate">{{ $ticket->title }}</p>
                    <div class="flex items-center gap-2 mt-1">
                        <span class="text-xs text-gray-400">{{ $ticket->ticket_number }}</span>
                        <span class="text-gray-300 dark:text-gray-600">·</span>
                        <span class="text-xs text-gray-400">{{ $ticket->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $ticket->status->bgClass() }}">
                    {{ $ticket->status->label() }}
                </span>
            </a>
            @endforeach
        </div>
        @else
        <div class="p-12 text-center">
            <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Belum ada laporan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">Buat laporan pertama Anda sekarang</p>
            <a href="{{ route('user.tickets.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-primary-600 text-white text-sm font-medium rounded-xl hover:bg-primary-700 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Laporan
            </a>
        </div>
        @endif
    </div>
</div>
