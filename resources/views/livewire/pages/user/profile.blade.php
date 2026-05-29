<div>
    <h1 class="text-2xl font-bold mb-6">Profil Saya</h1>

    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-6 lg:p-8 max-w-2xl">
        <form wire:submit="updateProfile" class="space-y-5">
            <div class="flex items-center gap-4 mb-6">
                @if($avatar)
                    <img src="{{ $avatar->temporaryUrl() }}" alt="Preview" class="w-16 h-16 rounded-2xl object-cover">
                @else
                    <img src="{{ auth()->user()->avatar_url }}" alt="Avatar" class="w-16 h-16 rounded-2xl object-cover">
                @endif
                <div>
                    <label class="inline-flex items-center gap-2 px-4 py-2 bg-gray-100 dark:bg-gray-800 rounded-xl text-sm font-medium cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        Ganti Foto
                        <input wire:model="avatar" type="file" class="hidden" accept="image/*">
                    </label>
                    <div wire:loading wire:target="avatar" class="text-xs text-primary-600 mt-1">Mengupload...</div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                <input wire:model="name" type="text" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                <input wire:model="email" type="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nomor HP</label>
                <input wire:model="phone" type="tel" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
            </div>

            <x-ktp-scan :scanError="$scanError" />

            <div x-data="{
                scanning: false,
                scanError: null,
                handleKtpScan(e) {
                    const file = e.target.files[0];
                    if (!file) return;
                    
                    this.scanning = true;
                    this.scanError = null;
                    
                    if (typeof Tesseract === 'undefined') {
                        this.scanError = 'Library pemindai belum siap. Pastikan koneksi internet lancar.';
                        this.scanning = false;
                        return;
                    }

                    Tesseract.recognize(file, 'ind').then(({ data: { text } }) => {
                        let extractedNik = '';
                        let extractedNama = '';
                        let extractedAlamat = '';

                        // 1. Ekstrak NIK (Paling agresif)
                        // Buang spasi, titik, strip. Ganti huruf yang sering salah baca jadi angka.
                        let rawTextForNik = text.replace(/[\s\-\.:]/g, '')
                                                .replace(/[oO]/g, '0')
                                                .replace(/[lI\|]/g, '1')
                                                .replace(/[bB]/g, '8')
                                                .replace(/[sS]/g, '5')
                                                .replace(/[gG]/g, '6')
                                                .replace(/[zZ]/g, '2')
                                                .replace(/[tT]/g, '7')
                                                .replace(/[aA]/g, '4');
                        // Cari angka minimal 14-16 digit (kadang NIK ada digit terpotong)
                        const nikMatch = rawTextForNik.match(/\d{14,16}/);
                        if (nikMatch) {
                            extractedNik = nikMatch[0];
                        }

                        // 2. Ekstrak Nama & Alamat line by line
                        const lines = text.split('\n').map(l => l.trim()).filter(l => l.length > 0);
                        
                        for (let i = 0; i < lines.length; i++) {
                            const line = lines[i];
                            const lower = line.toLowerCase();
                            
                            if (/(provinsi|kota|kabupaten|nik|kewarganegaraan|berlaku|gol\.\s*darah)/i.test(lower)) continue;
                            
                            // Ekstrak Nama
                            if (/(nama|nama\s*:)/i.test(lower) && !extractedNama) {
                                let nameStr = line.replace(/^(.*?nama\s*[:;=]?\s*)/i, '').trim();
                                if (nameStr.length < 3 && i + 1 < lines.length) {
                                    nameStr = lines[i + 1].trim();
                                }
                                // Buang tanda baca di awal (seperti -)
                                nameStr = nameStr.replace(/^[^a-zA-Z]+/, '');
                                // Buang kata kecil (noise seperti ag, en, dll)
                                nameStr = nameStr.replace(/\b[a-z]{1,4}\b\.?/g, '');
                                extractedNama = nameStr.replace(/[^a-zA-Z\s.,\']/g, '').replace(/\s+/g, ' ').trim().toUpperCase();
                            }
                            
                            // Ekstrak Alamat
                            if (/(alamat|alamat\s*:)/i.test(lower) && !extractedAlamat) {
                                let alamatStr = line.replace(/^(.*?alamat\s*[:;=]?\s*)/i, '').trim();
                                
                                for (let j = 1; j <= 4; j++) {
                                    if (i + j < lines.length) {
                                        const nextLine = lines[i + j];
                                        const nextLower = nextLine.toLowerCase();
                                        
                                        if (/(agama|status|tempat|pekerjaan)/i.test(nextLower)) break;
                                        
                                        if (/(rt\/?rw)/i.test(nextLower)) {
                                            alamatStr += ', ' + nextLine.replace(/^(.*?rt\/?rw\s*[:;=]?\s*)/i, 'RT/RW ');
                                        } else if (/(kel\/?desa)/i.test(nextLower)) {
                                            alamatStr += ', ' + nextLine.replace(/^(.*?kel\/?desa\s*[:;=]?\s*)/i, 'Kel. ');
                                        } else if (/(kecamatan)/i.test(nextLower)) {
                                            alamatStr += ', ' + nextLine.replace(/^(.*?kecamatan\s*[:;=]?\s*)/i, 'Kec. ');
                                        } else if (!/:/.test(nextLine)) {
                                            alamatStr += ' ' + nextLine;
                                        }
                                    }
                                }
                                // Buang kata kecil noise
                                alamatStr = alamatStr.replace(/\b[a-z]{1,4}\b\.?/g, '');
                                extractedAlamat = alamatStr.replace(/[^a-zA-Z0-9\s.,\/-]/g, '').replace(/\s+/g, ' ').trim().toUpperCase();
                            }
                        }

                        if (extractedNik) $wire.set('nik', extractedNik);
                        if (extractedNama) $wire.set('name', extractedNama);
                        if (extractedAlamat) $wire.set('address', extractedAlamat);
                        
                        if (!extractedNik && !extractedNama) {
                            this.scanError = 'Data KTP tidak terdeteksi jelas. Silakan input manual.';
                        } else {
                            this.scanError = null;
                        }
                    }).catch(err => {
                        this.scanError = 'Terjadi kesalahan saat memindai gambar.';
                    }).finally(() => {
                        this.scanning = false;
                        e.target.value = ''; 
                    });
                }
            }">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">NIK (16 Digit)</label>
                <div class="flex gap-2">
                    <input wire:model="nik" type="text" placeholder="Masukkan 16 digit NIK" maxlength="16"
                           class="flex-1 px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 outline-none text-sm">
                    
                    <button type="button" @click="$refs.ktpInput.click()" class="px-4 py-3 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 rounded-xl text-sm font-medium transition-colors flex items-center justify-center min-w-[120px]">
                        <span x-show="!scanning" class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Scan KTP
                        </span>
                        <span x-show="scanning" class="flex items-center gap-2 text-primary-600">
                            <svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                            Memindai...
                        </span>
                    </button>
                </div>
                <input type="file" x-ref="ktpInput" accept="image/*" class="hidden" @change="handleKtpScan">
                <p x-show="scanError" x-text="scanError" x-transition class="text-amber-500 text-xs mt-1"></p>
                @error('nik') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Alamat</label>
                <textarea wire:model="address" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none resize-none"></textarea>
            </div>

            <button type="submit" class="px-6 py-2.5 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all hover:shadow-lg hover:shadow-primary-500/25">
                <span wire:loading.remove>Simpan Perubahan</span>
                <span wire:loading>Menyimpan...</span>
            </button>
        </form>
    </div>
</div>
