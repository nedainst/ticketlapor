<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-blue-50 dark:from-dark-bg dark:via-dark-bg dark:to-slate-900 px-4 py-12">
    <div class="w-full max-w-md">
        {{-- Logo --}}
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <span class="font-bold text-2xl text-gradient">TicketLapor</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Selamat Datang Kembali</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Masuk ke akun Anda untuk melanjutkan</p>
        </div>

        {{-- Form Card --}}
        <div class="bg-white dark:bg-dark-card rounded-3xl shadow-soft-xl border border-gray-100 dark:border-dark-border p-8">
            {{-- Google Login Button --}}
            <a href="{{ route('auth.google') }}" class="flex items-center justify-center gap-3 w-full py-3 px-4 rounded-xl border border-gray-200 dark:border-dark-border bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors font-medium">
                <svg class="w-5 h-5" viewBox="0 0 24 24">
                    <path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                    <path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                    <path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/>
                    <path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/>
                </svg>
                Masuk dengan Google
            </a>

            <div class="flex items-center my-6">
                <div class="flex-grow border-t border-gray-200 dark:border-dark-border"></div>
                <span class="px-4 text-xs text-gray-400 font-medium">ATAU DENGAN EMAIL</span>
                <div class="flex-grow border-t border-gray-200 dark:border-dark-border"></div>
            </div>

            @if (session('error'))
                <div class="mb-4 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-800 text-red-600 dark:text-red-400 px-4 py-3 rounded-xl text-sm flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <form wire:submit="login" class="space-y-5">
                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                    <input wire:model="email" type="email" id="email" placeholder="nama@email.com"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Password --}}
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs text-primary-600 hover:text-primary-700 dark:text-primary-400">Lupa Password?</a>
                    </div>
                    <input wire:model="password" type="password" id="password" placeholder="••••••••"
                           class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100 placeholder-gray-400 focus:ring-2 focus:ring-primary-500 focus:border-transparent outline-none transition-all text-sm">
                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                {{-- Remember --}}
                <div class="flex items-center gap-2">
                    <input wire:model="remember" type="checkbox" id="remember" class="w-4 h-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                    <label for="remember" class="text-sm text-gray-600 dark:text-gray-400">Ingat saya</label>
                </div>

                {{-- Submit --}}
                <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-primary-500/25 flex items-center justify-center gap-2 text-sm">
                    <span wire:loading.remove>Masuk</span>
                    <svg wire:loading class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
                </button>
            </form>
        </div>

        {{-- Register link --}}
        <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-6">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-primary-600 hover:text-primary-700 dark:text-primary-400 font-semibold">Daftar Sekarang</a>
        </p>
    </div>
</div>
