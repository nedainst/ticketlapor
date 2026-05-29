<div>
    <div class="flex items-center gap-2 mb-6">
        <a href="{{ route('admin.tickets') }}" class="text-gray-400 hover:text-gray-600"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg></a>
        <span class="text-sm text-gray-400 font-mono">{{ $ticket->ticket_number }}</span>
        <span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $ticket->status->bgClass() }}">{{ $ticket->status->label() }}</span>
        <span class="px-2 py-0.5 rounded-md text-xs font-medium {{ $ticket->priority->bgClass() }}">{{ $ticket->priority->label() }}</span>
    </div>

    <h1 class="text-xl font-bold mb-6">{{ $ticket->title }}</h1>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 space-y-6">
            {{-- Description --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-6">
                <div class="flex items-center gap-3 mb-4">
                    <img src="{{ $ticket->user ? $ticket->user->avatar_url : 'https://ui-avatars.com/api/?name='.urlencode($ticket->reporter_name ?? 'Anonim Darurat').'&background=EF4444&color=fff' }}" class="w-8 h-8 rounded-lg">
                    <div>
                        <p class="text-sm font-medium">{{ $ticket->user->name ?? $ticket->reporter_name ?? 'Anonim Darurat' }}</p>
                        <p class="text-xs text-gray-400">{{ $ticket->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="prose prose-sm dark:prose-invert max-w-none">{!! $ticket->description !!}</div>
            </div>

            {{-- Chat --}}
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft">
                <div class="p-4 border-b border-gray-100 dark:border-dark-border"><h2 class="font-semibold">Percakapan</h2></div>
                <div class="p-4 space-y-4 max-h-96 overflow-y-auto">
                    @foreach($messages as $msg)
                    <div class="flex gap-3 {{ $msg->is_internal ? 'opacity-70 bg-amber-50 dark:bg-amber-900/10 -mx-4 px-4 py-2 rounded-lg' : '' }}">
                        <img src="{{ $msg->user->avatar_url }}" class="w-7 h-7 rounded-lg shrink-0">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-xs font-medium">{{ $msg->user->name }}</span>
                                @if($msg->is_internal)<span class="text-[10px] bg-amber-200 dark:bg-amber-800 text-amber-800 dark:text-amber-200 px-1.5 py-0.5 rounded font-medium">Internal</span>@endif
                                <span class="text-xs text-gray-400">{{ $msg->created_at->format('d M H:i') }}</span>
                            </div>
                            <div class="text-sm text-gray-700 dark:text-gray-300">{!! $msg->body !!}</div>
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- Reply --}}
                <div class="p-4 border-t border-gray-100 dark:border-dark-border space-y-3">
                    <form wire:submit="sendMessage" class="flex gap-2">
                        <input wire:model="newMessage" type="text" placeholder="Balas pesan..." class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none focus:ring-2 focus:ring-primary-500">
                        <button type="submit" class="px-4 py-2.5 bg-primary-600 hover:bg-primary-700 text-white rounded-xl text-sm font-medium transition-colors">Kirim</button>
                    </form>
                    <form wire:submit="sendInternalNote" class="flex gap-2">
                        <input wire:model="internalNote" type="text" placeholder="Catatan internal (hanya admin)..." class="flex-1 px-4 py-2.5 rounded-xl border border-amber-200 dark:border-amber-800 bg-amber-50 dark:bg-amber-900/20 text-sm outline-none focus:ring-2 focus:ring-amber-500">
                        <button type="submit" class="px-4 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-xl text-sm font-medium transition-colors">Internal</button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-4">
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
                <h3 class="font-semibold text-sm mb-4">Kelola Tiket</h3>

                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Status</label>
                        <select wire:change="updateStatus($event.target.value)" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none">
                            @foreach($statuses as $s)<option value="{{ $s->value }}" {{ $ticket->status === $s ? 'selected' : '' }}>{{ $s->label() }}</option>@endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-xs text-gray-400 mb-1 block">Tugaskan ke</label>
                        <select wire:change="assign($event.target.value)" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm outline-none">
                            <option value="">-- Pilih Petugas --</option>
                            @foreach($admins as $admin)<option value="{{ $admin->id }}" {{ $ticket->assigned_to == $admin->id ? 'selected' : '' }}>{{ $admin->name }}</option>@endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
                <h3 class="font-semibold text-sm mb-3">Info</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-400">Kategori</span><span>{{ $ticket->category->name }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Pelapor</span><span>{{ $ticket->user->name ?? $ticket->reporter_name ?? 'Anonim Darurat' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Email</span><span class="text-xs">{{ $ticket->user->email ?? '-' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">HP</span><span>{{ $ticket->user ? ($ticket->user->phone ?? '-') : ($ticket->reporter_phone ?? '-') }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-400">Dibuat</span><span>{{ $ticket->created_at->format('d/m/Y H:i') }}</span></div>
                    @if(!$ticket->latitude && $ticket->address)
                    <div class="flex justify-between"><span class="text-gray-400">Lokasi</span><span class="text-right text-xs max-w-[60%]">{{ $ticket->address }}</span></div>
                    @endif
                </div>
            </div>

            {{-- Location Map --}}
            @if($ticket->latitude && $ticket->longitude)
            <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft overflow-hidden">
                <div class="p-4 border-b border-gray-100 dark:border-dark-border">
                    <h3 class="font-semibold text-sm">Lokasi Kejadian</h3>
                </div>
                <div wire:ignore>
                    <div id="admin-ticket-map" class="h-48" x-data x-init="
                        setTimeout(() => {
                            if(typeof L !== 'undefined') {
                                const map = L.map('admin-ticket-map').setView([{{ $ticket->latitude }}, {{ $ticket->longitude }}], 15);
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
        </div>
    </div>
</div>
