<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Buat Laporan Baru</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Sampaikan pengaduan Anda dengan lengkap dan jelas</p>
    </div>

    {{-- Progress Steps --}}
    <div class="flex items-center gap-2 mb-8">
        @foreach([1 => 'Info Dasar', 2 => 'Detail', 3 => 'Lokasi & Lampiran', 4 => 'Review'] as $num => $label)
        <div class="flex items-center gap-2 {{ $num > 1 ? 'flex-1' : '' }}">
            @if($num > 1)
            <div class="flex-1 h-0.5 {{ $step >= $num ? 'bg-primary-500' : 'bg-gray-200 dark:bg-dark-border' }} transition-colors"></div>
            @endif
            <div class="flex items-center gap-2 shrink-0">
                <div class="w-8 h-8 rounded-full flex items-center justify-center text-xs font-bold transition-all duration-200
                    {{ $step > $num ? 'bg-primary-500 text-white' : ($step === $num ? 'bg-primary-500 text-white ring-4 ring-primary-100 dark:ring-primary-900/50' : 'bg-gray-200 dark:bg-dark-border text-gray-500') }}">
                    @if($step > $num)
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    @else
                        {{ $num }}
                    @endif
                </div>
                <span class="text-xs font-medium hidden sm:block {{ $step >= $num ? 'text-primary-600 dark:text-primary-400' : 'text-gray-400' }}">{{ $label }}</span>
            </div>
        </div>
        @endforeach
    </div>

    <form wire:submit="submit">
        <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-6 lg:p-8">

            {{-- Step 1: Info Dasar --}}
            @if($step === 1)
            <div class="space-y-5 animate-fade-in">
                <h2 class="text-lg font-semibold mb-4">Informasi Dasar</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Judul Laporan</label>
                    <input wire:model="title" type="text" placeholder="Contoh: Jalan rusak di Jl. Sudirman"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori</label>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                        @foreach($categories as $cat)
                        <label class="cursor-pointer">
                            <input wire:model="category_id" type="radio" value="{{ $cat->id }}" class="hidden peer">
                            <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-dark-border peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-gray-300 dark:hover:border-gray-600 transition-all text-center">
                                <div class="w-8 h-8 mx-auto rounded-lg flex items-center justify-center mb-1" style="background-color: {{ $cat->color }}15;">
                                    <span class="text-xs font-bold" style="color: {{ $cat->color }};">{{ substr($cat->name, 0, 2) }}</span>
                                </div>
                                <p class="text-xs font-medium truncate">{{ $cat->name }}</p>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Prioritas</label>
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($priorities as $p)
                        <label class="cursor-pointer">
                            <input wire:model="priority" type="radio" value="{{ $p->value }}" class="hidden peer">
                            <div class="p-3 rounded-xl border-2 border-gray-200 dark:border-dark-border peer-checked:border-primary-500 peer-checked:bg-primary-50 dark:peer-checked:bg-primary-900/20 hover:border-gray-300 dark:hover:border-gray-600 transition-all text-center">
                                <span class="inline-block px-2 py-0.5 rounded-md text-xs font-medium {{ $p->bgClass() }}">{{ $p->label() }}</span>
                            </div>
                        </label>
                        @endforeach
                    </div>
                    @error('priority') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            @endif

            {{-- Step 2: Detail --}}
            @if($step === 2)
            <div class="space-y-5 animate-fade-in">
                <h2 class="text-lg font-semibold mb-4">Detail Laporan</h2>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi Lengkap</label>
                    <textarea wire:model="description" rows="10" placeholder="Jelaskan detail pengaduan Anda. Sertakan informasi seperti waktu kejadian, dampak, dan hal yang Anda harapkan..."
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all resize-none"></textarea>
                    <p class="text-xs text-gray-400 mt-1">Minimal 20 karakter</p>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            @endif

            {{-- Step 3: Location & Files --}}
            @if($step === 3)
            <div class="space-y-5 animate-fade-in">
                <h2 class="text-lg font-semibold mb-4">Lokasi & Lampiran</h2>

                {{-- Location --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lokasi Kejadian <span class="text-gray-400">(opsional)</span></label>
                    <div class="rounded-xl border border-gray-200 dark:border-dark-border overflow-hidden" wire:ignore>
                        <div id="location-map" class="h-64 bg-gray-100 dark:bg-gray-800" x-data x-init="
                            setTimeout(() => {
                                if(typeof L !== 'undefined') {
                                    const map = L.map('location-map').setView([-6.2088, 106.8456], 12);
                                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                                        attribution: '© OpenStreetMap'
                                    }).addTo(map);
                                    let marker = null;
                                    map.on('click', (e) => {
                                        if(marker) map.removeLayer(marker);
                                        marker = L.marker(e.latlng).addTo(map);
                                        $wire.set('latitude', e.latlng.lat);
                                        $wire.set('longitude', e.latlng.lng);
                                    });
                                }
                            }, 500);
                        "></div>
                    </div>
                    <input wire:model="address" type="text" placeholder="Alamat lengkap (opsional)"
                           class="w-full mt-2 px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all">
                </div>

                {{-- File Upload --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Lampiran <span class="text-gray-400">(opsional, max 10MB per file)</span></label>
                    <div class="border-2 border-dashed border-gray-300 dark:border-dark-border rounded-xl p-6 text-center hover:border-primary-400 dark:hover:border-primary-600 transition-colors cursor-pointer"
                         onclick="document.getElementById('file-upload').click()">
                        <input wire:model="files" type="file" id="file-upload" class="hidden" multiple accept="image/*,video/*,.pdf">
                        <svg class="w-10 h-10 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Klik atau seret file ke sini</p>
                        <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF, MP4 (max 10MB)</p>
                    </div>

                    <div wire:loading wire:target="files" class="mt-2 text-sm text-primary-600 flex items-center gap-2">
                        <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                        Mengupload...
                    </div>

                    @if(count($files) > 0)
                    <div class="mt-3 space-y-2">
                        @foreach($files as $index => $file)
                        <div class="flex items-center gap-3 p-2 bg-gray-50 dark:bg-gray-800 rounded-lg">
                            <svg class="w-5 h-5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/></svg>
                            <span class="text-sm truncate flex-1">{{ $file->getClientOriginalName() }}</span>
                            <button wire:click="removeFile({{ $index }})" type="button" class="text-red-500 hover:text-red-700 shrink-0">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>
                    @endif
                    @error('files.*') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            @endif

            {{-- Step 4: Review --}}
            @if($step === 4)
            <div class="space-y-5 animate-fade-in">
                <h2 class="text-lg font-semibold mb-4">Review Laporan</h2>

                <div class="space-y-4">
                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Judul</p>
                        <p class="font-medium">{{ $title }}</p>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-xs text-gray-400 mb-1">Kategori</p>
                            <p class="font-medium">{{ $categories->find($category_id)?->name ?? '-' }}</p>
                        </div>
                        <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                            <p class="text-xs text-gray-400 mb-1">Prioritas</p>
                            @php $p = \App\Enums\TicketPriority::tryFrom($priority); @endphp
                            <span class="inline-block px-2 py-0.5 rounded-md text-xs font-medium {{ $p?->bgClass() }}">{{ $p?->label() }}</span>
                        </div>
                    </div>
                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Deskripsi</p>
                        <p class="text-sm whitespace-pre-wrap">{{ $description }}</p>
                    </div>
                    @if($address)
                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Lokasi</p>
                        <p class="text-sm">{{ $address }}</p>
                    </div>
                    @endif
                    @if(count($files) > 0)
                    <div class="p-4 bg-gray-50 dark:bg-gray-800 rounded-xl">
                        <p class="text-xs text-gray-400 mb-1">Lampiran ({{ count($files) }} file)</p>
                        @foreach($files as $file)
                        <p class="text-sm text-gray-600 dark:text-gray-400">📎 {{ $file->getClientOriginalName() }}</p>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        {{-- Navigation Buttons --}}
        <div class="flex items-center justify-between mt-6">
            @if($step > 1)
            <button wire:click="previousStep" type="button" class="px-6 py-2.5 text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition-colors">
                ← Kembali
            </button>
            @else
            <div></div>
            @endif

            @if($step < 4)
            <button wire:click="nextStep" type="button" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25">
                Lanjutkan →
            </button>
            @else
            <button type="submit" class="px-8 py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white text-sm font-semibold rounded-xl transition-all hover:shadow-lg hover:shadow-emerald-500/25 flex items-center gap-2">
                <span wire:loading.remove wire:target="submit">✓ Kirim Laporan</span>
                <svg wire:loading wire:target="submit" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            </button>
            @endif
        </div>
    </form>
</div>
