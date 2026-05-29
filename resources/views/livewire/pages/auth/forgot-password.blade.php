<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 via-white to-blue-50 dark:from-dark-bg dark:via-dark-bg dark:to-slate-900 px-4 py-12">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <a href="{{ route('home') }}" class="inline-flex items-center gap-3 mb-4">
                <div class="w-11 h-11 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center shadow-lg shadow-primary-500/25">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="font-bold text-2xl text-gradient">TicketLapor</span>
            </a>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Lupa Password</h1>
            <p class="text-gray-500 text-sm mt-1">Masukkan email Anda untuk reset password</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl shadow-soft-lg border border-gray-100 dark:border-dark-border p-8">
            @if($sent)
            <div class="text-center py-4">
                <div class="w-14 h-14 mx-auto bg-emerald-100 dark:bg-emerald-900/30 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-7 h-7 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h3 class="font-semibold mb-1">Email Terkirim!</h3>
                <p class="text-sm text-gray-500">Cek inbox email Anda untuk link reset password.</p>
            </div>
            @else
            <form wire:submit="sendResetLink" class="space-y-5">
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">Email</label>
                    <input wire:model="email" type="email" placeholder="nama@email.com" class="w-full px-4 py-3 rounded-xl border border-gray-200 dark:border-dark-border bg-gray-50 dark:bg-gray-800 text-sm focus:ring-2 focus:ring-primary-500 outline-none">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <button type="submit" class="w-full py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-all text-sm">Kirim Link Reset</button>
            </form>
            @endif
        </div>
        <p class="text-center text-sm text-gray-500 mt-6"><a href="{{ route('login') }}" class="text-primary-600 font-semibold">← Kembali ke Login</a></p>
    </div>
</div>
