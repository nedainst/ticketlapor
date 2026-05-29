<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-red-50 via-white to-amber-50 dark:from-dark-bg dark:via-dark-bg dark:to-slate-900 px-4 py-12">
    @assets
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    @endassets
    
    <div class="w-full max-w-2xl">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                <div class="w-11 h-11 bg-gradient-to-br from-red-500 to-red-700 rounded-xl flex items-center justify-center shadow-lg shadow-red-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <span class="font-bold text-2xl text-red-600 dark:text-red-500">Laporan Darurat</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Layanan Pengaduan Cepat</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 max-w-lg mx-auto">Gunakan formulir ini <strong>hanya</strong> untuk melaporkan kejadian darurat yang membutuhkan penanganan segera (prioritas tinggi) tanpa perlu login.</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-soft-lg border border-red-100 dark:border-red-900/50 p-6 md:p-8">
            @if(!$submittedTicket)
            <form wire:submit="submit" class="space-y-6">
                {{-- Data Pelapor --}}
                <div class="bg-red-50 dark:bg-red-900/10 rounded-xl p-4 md:p-5 border border-red-100 dark:border-red-900/30">
                    <h2 class="text-sm font-semibold text-red-800 dark:text-red-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Data Pelapor
                    </h2>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="reporter_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                            <input wire:model="reporter_name" type="text" id="reporter_name" placeholder="Nama Anda"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all text-sm">
                            @error('reporter_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="reporter_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor HP / WhatsApp <span class="text-red-400">*</span></label>
                            <input wire:model="reporter_phone" type="tel" id="reporter_phone" placeholder="Contoh: 081234567890"
                                   class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all text-sm">
                            @error('reporter_phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                {{-- Detail Kejadian --}}
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Kategori Laporan <span class="text-red-400">*</span></label>
                    <select wire:model="category_id" id="category" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-red-500 outline-none appearance-none">
                        <option value="">Pilih Kategori Kejadian</option>
                        @foreach($categories as $c)
                            <option value="{{ $c->id }}">{{ $c->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Judul Kejadian <span class="text-red-400">*</span></label>
                    <input wire:model="title" type="text" id="title" placeholder="Contoh: Kebakaran di Pasar Inpres"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Deskripsi Singkat & Lokasi <span class="text-red-400">*</span></label>
                    <textarea wire:model="description" id="description" rows="3" placeholder="Jelaskan kejadian secara singkat dan sebutkan lokasi spesifiknya"
                              class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-red-500 focus:border-transparent outline-none transition-all text-sm resize-none"></textarea>
                    @error('description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Peta Lokasi --}}
                <div wire:ignore x-data="emergencyMap()" x-init="initMap()">
                    <div class="flex items-center justify-between mb-1.5">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Titik Lokasi (Opsional)</label>
                        <button type="button" @click="getLocation()" class="text-xs text-red-600 hover:text-red-700 font-medium flex items-center gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Gunakan GPS Saya
                        </button>
                    </div>
                    <div id="map" class="w-full h-64 rounded-xl border border-gray-200 dark:border-dark-border z-0"></div>
                    <p class="text-xs text-gray-500 mt-2">Geser pin merah untuk menyesuaikan titik lokasi kejadian.</p>
                    <input type="hidden" wire:model="latitude">
                    <input type="hidden" wire:model="longitude">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Foto Kejadian (Opsional)</label>
                    <div class="relative">
                        <input wire:model="photo" type="file" id="photo" accept="image/*" class="hidden">
                        <label for="photo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 dark:border-dark-border border-dashed rounded-xl cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors {{ $photo ? 'bg-emerald-50 dark:bg-emerald-900/10 border-emerald-300' : 'bg-gray-50 dark:bg-gray-800/50' }}">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                @if($photo)
                                    <svg class="w-8 h-8 text-emerald-500 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    <p class="text-sm font-medium text-emerald-600 dark:text-emerald-400">Foto terpilih</p>
                                @else
                                    <svg class="w-8 h-8 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    <p class="text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">PNG, JPG up to 10MB</p>
                                @endif
                            </div>
                        </label>
                    </div>
                    @error('photo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-red-500/25 flex items-center justify-center gap-2 text-sm">
                        <span wire:loading.remove wire:target="submit">Kirim Laporan Darurat Sekarang</span>
                        <svg wire:loading wire:target="submit" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </button>
                    <p class="text-xs text-center text-gray-500 mt-3 flex items-center justify-center gap-1">
                        <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        Kami menjaga kerahasiaan identitas Anda
                    </p>
                </div>
            </form>
            @else
            {{-- Success State --}}
            <div class="text-center animate-fade-in py-8">
                <div class="w-20 h-20 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-full flex items-center justify-center mb-6">
                    <svg class="w-10 h-10 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </div>
                
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Laporan Berhasil Dibuat!</h2>
                <p class="text-gray-600 dark:text-gray-400 mb-8 max-w-md mx-auto">Tim kami telah menerima laporan darurat Anda dan akan segera menindaklanjutinya.</p>
                
                <div class="bg-gray-50 dark:bg-gray-800 rounded-2xl p-6 border border-gray-100 dark:border-dark-border inline-block min-w-[300px] mb-8 relative group">
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-2 font-medium uppercase tracking-wider">Nomor Tiket Anda</p>
                    <div class="text-3xl font-mono font-bold text-primary-600 dark:text-primary-400 tracking-wider bg-white dark:bg-dark-card py-3 px-6 rounded-xl border border-gray-200 dark:border-dark-border shadow-inner">
                        {{ $submittedTicket->ticket_number }}
                    </div>
                    <p class="text-xs text-red-500 mt-4 font-medium bg-red-50 dark:bg-red-900/20 py-2 px-3 rounded-lg">⚠️ Harap catat atau screenshot nomor ini untuk melacak laporan Anda!</p>
                </div>
                
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('track') }}" class="w-full sm:w-auto px-8 py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-bold rounded-xl transition-all duration-200 hover:shadow-lg flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        Lacak Tiket Ini
                    </a>
                    <button wire:click="$set('submittedTicket', null)" class="w-full sm:w-auto px-8 py-3.5 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300 font-bold rounded-xl transition-colors">
                        Buat Laporan Lain
                    </button>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

@script
<script>
    Alpine.data('emergencyMap', () => ({
        map: null,
        marker: null,
        
        initMap() {
            // Default center (Jakarta)
            let defaultLat = -6.200000;
            let defaultLng = 106.816666;

            this.map = L.map('map').setView([defaultLat, defaultLng], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors'
            }).addTo(this.map);

            this.marker = L.marker([defaultLat, defaultLng], {draggable: true}).addTo(this.map);

            this.marker.on('dragend', (e) => {
                let position = this.marker.getLatLng();
                $wire.set('latitude', position.lat);
                $wire.set('longitude', position.lng);
            });

            this.map.on('click', (e) => {
                this.marker.setLatLng(e.latlng);
                $wire.set('latitude', e.latlng.lat);
                $wire.set('longitude', e.latlng.lng);
            });
        },
        
        getLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        let lat = position.coords.latitude;
                        let lng = position.coords.longitude;
                        
                        this.map.setView([lat, lng], 16);
                        this.marker.setLatLng([lat, lng]);
                        
                        $wire.set('latitude', lat);
                        $wire.set('longitude', lng);
                    },
                    (error) => {
                        alert("Tidak dapat mengambil lokasi. Pastikan GPS aktif dan Anda memberikan izin.");
                    },
                    { enableHighAccuracy: true }
                );
            } else {
                alert("Browser Anda tidak mendukung fitur Geolocation.");
            }
        }
    }));
</script>
@endscript
