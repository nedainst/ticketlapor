<div>
    {{-- Header --}}
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <a href="{{ route('user.tickets') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <span class="text-sm text-gray-400 font-mono">{{ $ticket->ticket_number }}</span>
            </div>
            <h1 class="text-xl lg:text-2xl font-bold">{{ $ticket->title }}</h1>
        </div>
        <div class="flex items-center gap-2 shrink-0">
            <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $ticket->priority->bgClass() }}">{{ $ticket->priority->label() }}</span>
            <span class="px-3 py-1.5 rounded-xl text-xs font-semibold {{ $ticket->status->bgClass() }}">{{ $ticket->status->label() }}</span>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Description --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-6">
                <h2 class="font-semibold mb-3">Deskripsi Laporan</h2>
                <div class="prose prose-sm dark:prose-invert max-w-none text-gray-600 dark:text-gray-400">
                    {!! $ticket->description !!}
                </div>

                @if($ticket->attachments->count() > 0)
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-dark-border">
                    <p class="text-sm font-medium mb-2">Lampiran</p>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        @foreach($ticket->attachments as $attachment)
                        <a href="{{ $attachment->url }}" target="_blank" class="flex items-center gap-2 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            @if($attachment->is_image)
                                <img src="{{ $attachment->url }}" alt="{{ $attachment->file_name }}" class="w-10 h-10 rounded object-cover">
                            @else
                                <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            @endif
                            <div class="min-w-0">
                                <p class="text-xs font-medium truncate">{{ $attachment->file_name }}</p>
                                <p class="text-xs text-gray-400">{{ $attachment->human_size }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            {{-- Chat --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft">
                <div class="p-4 border-b border-gray-100 dark:border-dark-border">
                    <h2 class="font-semibold">Percakapan</h2>
                </div>

                {{-- Messages --}}
                <div class="p-4 space-y-4 max-h-96 overflow-y-auto" id="chat-messages">
                    @forelse($messages as $message)
                    @if(!$message->is_internal)
                    <div class="flex gap-3 {{ $message->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                        <img src="{{ $message->user->avatar_url }}" alt="{{ $message->user->name }}" class="w-8 h-8 rounded-lg shrink-0">
                        <div class="max-w-[75%]">
                            <div class="flex items-center gap-2 mb-1 {{ $message->user_id === auth()->id() ? 'flex-row-reverse' : '' }}">
                                <span class="text-xs font-medium">{{ $message->user->name }}</span>
                                <span class="text-xs text-gray-400">{{ $message->created_at->format('H:i') }}</span>
                            </div>
                            <div class="px-4 py-2.5 rounded-2xl text-sm
                                {{ $message->user_id === auth()->id() ? 'bg-primary-600 text-white rounded-tr-md' : 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-tl-md' }}">
                                {!! $message->body !!}
                            </div>
                            @if($message->is_read && $message->user_id === auth()->id())
                            <p class="text-[10px] text-gray-400 mt-0.5 text-right">✓ Dibaca</p>
                            @endif
                        </div>
                    </div>
                    @endif
                    @empty
                    <div class="text-center py-8">
                        <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                        <p class="text-sm text-gray-400">Belum ada percakapan</p>
                    </div>
                    @endforelse
                </div>

                {{-- Chat Input --}}
                @if(!in_array($ticket->status->value, ['selesai', 'ditolak']))
                <div class="p-4 border-t border-gray-100 dark:border-dark-border">
                    <form wire:submit="sendMessage" class="flex gap-2">
                        <input wire:model="newMessage" type="text" placeholder="Ketik pesan..." class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                        <button type="submit" class="px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl transition-colors shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/></svg>
                        </button>
                    </form>
                </div>
                @endif
            </div>
        </div>

        {{-- Sidebar Info --}}
        <div class="space-y-4">
            {{-- Info Card --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
                <h3 class="font-semibold text-sm mb-4">Informasi Tiket</h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Kategori</span>
                        <span class="text-sm font-medium">{{ $ticket->category->name }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Dibuat</span>
                        <span class="text-sm">{{ $ticket->created_at->format('d M Y, H:i') }}</span>
                    </div>
                    @if($ticket->assignee)
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Petugas</span>
                        <div class="flex items-center gap-2">
                            <img src="{{ $ticket->assignee->avatar_url }}" class="w-5 h-5 rounded-md">
                            <span class="text-sm">{{ $ticket->assignee->name }}</span>
                        </div>
                    </div>
                    @endif
                    @if($ticket->response_time_minutes)
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Waktu Respon</span>
                        <span class="text-sm">{{ $ticket->response_time_minutes < 60 ? $ticket->response_time_minutes . ' menit' : round($ticket->response_time_minutes / 60, 1) . ' jam' }}</span>
                    </div>
                    @endif
                    @if($ticket->resolved_at)
                    <div class="flex items-center justify-between">
                        <span class="text-xs text-gray-400">Diselesaikan</span>
                        <span class="text-sm">{{ $ticket->resolved_at->format('d M Y') }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Location --}}
            @if($ticket->latitude && $ticket->longitude)
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft overflow-hidden">
                <div class="p-4 border-b border-gray-100 dark:border-dark-border">
                    <h3 class="font-semibold text-sm">Lokasi Kejadian</h3>
                </div>
                <div wire:ignore>
                    <div id="ticket-map" class="h-48" x-data x-init="
                        setTimeout(() => {
                            if(typeof L !== 'undefined') {
                                const map = L.map('ticket-map').setView([{{ $ticket->latitude }}, {{ $ticket->longitude }}], 15);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OSM' }).addTo(map);
                                L.marker([{{ $ticket->latitude }}, {{ $ticket->longitude }}]).addTo(map);
                            }
                        }, 500);
                    "></div>
                </div>
                @if($ticket->address)
                <div class="p-3">
                    <p class="text-xs text-gray-500">{{ $ticket->address }}</p>
                </div>
                @endif
            </div>
            @endif

            {{-- Timeline --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
                <h3 class="font-semibold text-sm mb-4">Timeline</h3>
                <div class="space-y-3">
                    <div class="flex gap-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm font-medium">Laporan dibuat</p>
                            <p class="text-xs text-gray-400">{{ $ticket->created_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @if($ticket->first_responded_at)
                    <div class="flex gap-3">
                        <div class="w-2 h-2 bg-blue-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm font-medium">Diproses</p>
                            <p class="text-xs text-gray-400">{{ $ticket->first_responded_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                    @if($ticket->resolved_at)
                    <div class="flex gap-3">
                        <div class="w-2 h-2 bg-emerald-500 rounded-full mt-1.5 shrink-0"></div>
                        <div>
                            <p class="text-sm font-medium">Selesai</p>
                            <p class="text-xs text-gray-400">{{ $ticket->resolved_at->format('d M Y, H:i') }}</p>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
