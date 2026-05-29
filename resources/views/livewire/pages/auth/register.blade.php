<div class="min-h-screen flex items-center justify-center bg-gray-50 dark:bg-dark-bg p-4 relative overflow-hidden">
    {{-- Background Decorations --}}
    <div class="absolute top-0 left-0 w-full h-96 bg-gradient-to-br from-primary-500/10 to-transparent -skew-y-6 transform origin-top-left -z-10"></div>
    
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 mb-4">
                <div class="w-10 h-10 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/30">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <span class="font-bold text-xl dark:text-white tracking-tight">TicketLapor</span>
            </a>
            <h1 class="text-2xl font-bold dark:text-white">Buat Akun Baru</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-2">Daftar untuk mulai melaporkan masalah di sekitar Anda.</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-3xl shadow-soft-xl border border-gray-100 dark:border-dark-border p-8">
            {{-- Google Login Button --}}
            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full py-3 px-4 rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Daftar dengan Google
            </a>

            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-200 dark:border-dark-border"></div>
                <span class="px-4 text-xs text-gray-400 font-medium">ATAU DENGAN EMAIL</span>
                <div class="flex-grow border-t border-gray-200 dark:border-dark-border"></div>
            </div>

            <form wire:submit="register" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Nama Lengkap</label>
                    <input wire:model="name" type="text" placeholder="John Doe"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                    <input wire:model="email" type="email" placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Password</label>
                    <input wire:model="password" type="password" placeholder="Minimal 8 karakter"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Konfirmasi Password</label>
                    <input wire:model="password_confirmation" type="password" placeholder="Ulangi password"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                </div>

                <div class="pt-2">
                    <button type="submit" class="w-full py-3.5 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-primary-500/25 flex items-center justify-center gap-2">
                        <span wire:loading.remove wire:target="register">Buat Akun</span>
                        <svg wire:loading wire:target="register" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                    </button>
                </div>
            </form>
        </div>

        <p class="text-center mt-6 text-sm text-gray-500 dark:text-gray-400">
            Sudah punya akun? 
            <a href="{{ route('login') }}" class="text-primary-600 dark:text-primary-400 font-semibold hover:underline">Masuk di sini</a>
        </p>
    </div>
</div>
