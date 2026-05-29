<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-blue-50 dark:from-dark-bg dark:via-dark-bg dark:to-slate-900 px-4 py-12">
    <div class="w-full max-w-lg">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="font-bold text-2xl text-gradient">TicketLapor</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lacak Laporan Anda</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Masukkan nomor tiket untuk melihat status terkini</p>
        </div>

        {{-- Search Box --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-soft-lg border border-gray-100 dark:border-dark-border p-6 mb-6">
            <form wire:submit="track" class="flex gap-3">
                <div class="relative flex-1">
                    <svg class="w-5 h-5 text-gray-400 absolute left-4 top-1/2 -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input wire:model="ticketNumber" type="text" placeholder="Contoh: TK-2026-000001"
                           class="w-full pl-12 pr-4 py-3.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm font-mono uppercase"
                           style="letter-spacing: 0.5px;">
                </div>
                <button type="submit"
                        class="px-6 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25 text-sm shrink-0 flex items-center gap-2">
                    <span wire:loading.remove wire:target="track">Lacak</span>
                    <svg wire:loading wire:target="track" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </form>
        </div>

        {{-- Error --}}
        @if($error)
        <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-2xl p-5 mb-6 animate-fade-in">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <p class="text-sm text-red-700 dark:text-red-300">{{ $error }}</p>
            </div>
        </div>
        @endif

        {{-- Result --}}
        @if($ticket)
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-soft-lg border border-gray-100 dark:border-dark-border overflow-hidden animate-fade-in">
            {{-- Header --}}
            <div class="p-6 border-b border-gray-100 dark:border-dark-border">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-xs text-gray-400 font-mono mb-1">{{ $ticket->ticket_number }}</p>
                        <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ $ticket->title }}</h2>
                    </div>
                    <span class="px-3 py-1.5 rounded-xl text-xs font-bold {{ $ticket->status->bgClass() }} shrink-0">
                        {{ $ticket->status->label() }}
                    </span>
                </div>
            </div>

            {{-- Details --}}
            <div class="p-6 space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Kategori</p>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 rounded-md flex items-center justify-center" style="background-color: {{ $ticket->category->color }}15;">
                                <span class="text-[10px] font-bold" style="color: {{ $ticket->category->color }};">{{ substr($ticket->category->name, 0, 2) }}</span>
                            </div>
                            <span class="text-sm font-medium">{{ $ticket->category->name }}</span>
                        </div>
                    </div>
                    <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Prioritas</p>
                        <span class="inline-block px-2 py-0.5 rounded-md text-xs font-medium {{ $ticket->priority->bgClass() }}">{{ $ticket->priority->label() }}</span>
                    </div>
                </div>

                <div class="p-3 bg-gray-50 dark:bg-gray-800 rounded-xl">
                    <p class="text-xs text-gray-400 mb-1">Tanggal Dilaporkan</p>
                    <p class="text-sm font-medium">{{ $ticket->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
                    <p class="text-xs text-gray-400 mt-0.5">{{ $ticket->created_at->diffForHumans() }}</p>
                </div>

                @if($ticket->resolved_at)
                <div class="p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl border border-emerald-100 dark:border-emerald-800">
                    <p class="text-xs text-emerald-500 mb-1">Diselesaikan Pada</p>
                    <p class="text-sm font-medium text-emerald-700 dark:text-emerald-300">{{ $ticket->resolved_at->translatedFormat('d F Y, H:i') }} WIB</p>
                </div>
                @endif

                {{-- Timeline --}}
                <div>
                    <p class="text-xs text-gray-400 mb-3 font-semibold uppercase tracking-wider">Timeline</p>
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-primary-500 mt-1.5 shrink-0 ring-4 ring-primary-100 dark:ring-primary-900/30"></div>
                            <div>
                                <p class="text-sm font-medium">Laporan Dibuat</p>
                                <p class="text-xs text-gray-400">{{ $ticket->created_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @if($ticket->first_responded_at)
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-blue-500 mt-1.5 shrink-0 ring-4 ring-blue-100 dark:ring-blue-900/30"></div>
                            <div>
                                <p class="text-sm font-medium">Ditanggapi</p>
                                <p class="text-xs text-gray-400">{{ $ticket->first_responded_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                        @if($ticket->resolved_at)
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 mt-1.5 shrink-0 ring-4 ring-emerald-100 dark:ring-emerald-900/30"></div>
                            <div>
                                <p class="text-sm font-medium">Selesai</p>
                                <p class="text-xs text-gray-400">{{ $ticket->resolved_at->translatedFormat('d M Y, H:i') }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @elseif($searched && !$error)
        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-soft-lg border border-gray-100 dark:border-dark-border p-12 text-center animate-fade-in">
            <div class="w-16 h-16 mx-auto bg-gray-100 dark:bg-gray-800 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-gray-700 dark:text-gray-300">Tiket tidak ditemukan</h3>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Periksa kembali nomor tiket Anda</p>
        </div>
        @endif

        <div class="text-center mt-6">
            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-primary-600 transition-colors">← Kembali ke Beranda</a>
        </div>
    </div>
</div>
