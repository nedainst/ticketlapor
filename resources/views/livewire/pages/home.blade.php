<div>
    {{-- Navbar --}}
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         x-data="{ scrolled: false }"
         @scroll.window="scrolled = window.scrollY > 20"
         :class="scrolled ? 'bg-white/90 dark:bg-dark-bg/90 backdrop-blur-xl shadow-soft border-b border-gray-200/50 dark:border-dark-border/50' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <span class="font-bold text-xl text-gradient">TicketLapor</span>
                </div>

                <div class="hidden md:flex items-center gap-8">
                    <a href="#fitur" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Cara Kerja</a>
                    <a href="{{ route('track') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">Lacak Laporan</a>
                    <a href="#faq" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 dark:hover:text-primary-400 transition-colors">FAQ</a>
                </div>

                <div class="flex items-center gap-3">
                    <button onclick="toggleDarkMode()" class="p-2 rounded-xl hover:bg-gray-100 dark:hover:bg-gray-800 transition-colors">
                        <svg class="w-5 h-5 dark:hidden text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/></svg>
                        <svg class="w-5 h-5 hidden dark:block text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </button>
                    @auth
                        <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('user.dashboard') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-primary-500/25">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-primary-600 transition-colors hidden sm:block">Masuk</a>
                        <a href="{{ route('register') }}" class="px-4 py-2 bg-primary-600 hover:bg-primary-700 text-white text-sm font-medium rounded-xl transition-all duration-200 hover:shadow-lg hover:shadow-primary-500/25">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    {{-- Hero Section --}}
    <section class="relative min-h-screen flex items-center overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0 bg-gradient-to-br from-primary-50 via-white to-blue-50 dark:from-dark-bg dark:via-dark-bg dark:to-slate-900"></div>
        <div class="absolute inset-0 opacity-30 dark:opacity-20" style="background-image: radial-gradient(circle at 25% 25%, rgba(59,130,246,0.15) 0%, transparent 50%), radial-gradient(circle at 75% 75%, rgba(139,92,246,0.15) 0%, transparent 50%);"></div>

        {{-- Floating shapes --}}
        <div class="absolute top-20 left-10 w-72 h-72 bg-primary-400/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/10 rounded-full blur-3xl animate-float" style="animation-delay: -3s;"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-24 pb-16">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="animate-fade-in">
                    <div class="inline-flex items-center gap-2 bg-primary-100 dark:bg-primary-900/30 text-primary-700 dark:text-primary-400 px-4 py-1.5 rounded-full text-sm font-medium mb-6">
                        <span class="w-2 h-2 bg-primary-500 rounded-full animate-pulse"></span>
                        Platform Pengaduan #1 Indonesia
                    </div>

                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold leading-tight mb-6">
                        Suara Anda,
                        <span class="text-gradient">Perubahan</span>
                        <span class="block">Nyata</span>
                    </h1>

                    <p class="text-lg text-gray-600 dark:text-gray-400 mb-8 max-w-lg leading-relaxed">
                        Sampaikan laporan, keluhan, kritik, dan saran Anda secara mudah, cepat, dan transparan. Kami memastikan setiap suara didengar dan ditindaklanjuti.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 mb-6">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-2xl transition-all duration-300 hover:shadow-xl hover:shadow-primary-500/30 hover:-translate-y-0.5 text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            Buat Laporan Sekarang
                        </a>
                        <a href="{{ route('track') }}" class="inline-flex items-center justify-center gap-2 px-8 py-4 bg-white dark:bg-dark-card text-gray-700 dark:text-gray-300 font-semibold rounded-2xl border border-gray-200 dark:border-dark-border hover:border-primary-300 dark:hover:border-primary-700 transition-all duration-300 hover:shadow-lg text-base">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                            Lacak Laporan
                        </a>
                    </div>

                    <a href="{{ route('emergency') }}" class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-red-50 dark:bg-red-900/20 text-red-600 dark:text-red-400 font-semibold rounded-xl border border-red-200 dark:border-red-800/50 hover:bg-red-100 dark:hover:bg-red-900/40 transition-colors text-sm w-full sm:w-auto">
                        <svg class="w-5 h-5 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        🚨 Laporan Darurat Tanpa Login
                    </a>
                </div>

                {{-- Hero illustration --}}
                <div class="hidden lg:block animate-fade-in" style="animation-delay: 0.3s;">
                    <div class="relative">
                        {{-- Main card --}}
                        <div class="glass rounded-3xl p-6 shadow-soft-lg">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-400"></div>
                            </div>
                            <div class="space-y-3">
                                <div class="flex items-center gap-3 p-3 bg-emerald-50 dark:bg-emerald-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-emerald-800 dark:text-emerald-400">TK-2026-000042</p>
                                        <p class="text-xs text-emerald-600 dark:text-emerald-500">Jalan rusak di Jl. Sudirman — Selesai</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-blue-800 dark:text-blue-400">TK-2026-000043</p>
                                        <p class="text-xs text-blue-600 dark:text-blue-500">Pelayanan lambat Disdukcapil — Diproses</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-3 p-3 bg-amber-50 dark:bg-amber-900/20 rounded-xl">
                                    <div class="w-8 h-8 bg-amber-100 dark:bg-amber-900/30 rounded-lg flex items-center justify-center">
                                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-medium text-amber-800 dark:text-amber-400">TK-2026-000044</p>
                                        <p class="text-xs text-amber-600 dark:text-amber-500">Sampah menumpuk di TPS — Pending</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Floating badges --}}
                        <div class="absolute -top-4 -right-4 glass rounded-2xl p-3 shadow-soft animate-float" style="animation-delay: -1s;">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-emerald-100 dark:bg-emerald-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Terselesaikan</p>
                                    <p class="text-lg font-bold text-emerald-600">98.5%</p>
                                </div>
                            </div>
                        </div>

                        <div class="absolute -bottom-4 -left-4 glass rounded-2xl p-3 shadow-soft animate-float" style="animation-delay: -4s;">
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-primary-100 dark:bg-primary-900/30 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Respon Cepat</p>
                                    <p class="text-lg font-bold text-primary-600">&lt;2 Jam</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Statistics --}}
    <section class="py-16 bg-white dark:bg-dark-card border-y border-gray-100 dark:border-dark-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 lg:gap-8">
                <div class="text-center" data-animate>
                    <div class="text-3xl sm:text-4xl font-extrabold text-gradient mb-1"
                         x-data="{ count: 0 }" x-init="let target = {{ $totalTickets }}; let step = target / 60; let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 16);"
                         x-text="Math.floor(count).toLocaleString('id-ID')">0</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Total Laporan</p>
                </div>
                <div class="text-center" data-animate>
                    <div class="text-3xl sm:text-4xl font-extrabold text-emerald-600 mb-1"
                         x-data="{ count: 0 }" x-init="let target = {{ $resolvedTickets }}; let step = target / 60; let interval = setInterval(() => { count += step; if(count >= target) { count = target; clearInterval(interval); } }, 16);"
                         x-text="Math.floor(count).toLocaleString('id-ID')">0</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Selesai Ditangani</p>
                </div>
                <div class="text-center" data-animate>
                    <div class="text-3xl sm:text-4xl font-extrabold text-amber-500 mb-1">
                        @if($avgResponseTime > 0)
                            {{ $avgResponseTime < 60 ? $avgResponseTime . ' Min' : round($avgResponseTime / 60, 1) . ' Jam' }}
                        @else
                            < 1 Jam
                        @endif
                    </div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Rata-rata Respon</p>
                </div>
                <div class="text-center" data-animate>
                    <div class="text-3xl sm:text-4xl font-extrabold text-purple-600 mb-1">4.8/5</div>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Kepuasan Pengguna</p>
                </div>
            </div>
        </div>
    </section>

    {{-- Categories --}}
    <section id="fitur" class="py-20 bg-gray-50 dark:bg-dark-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Kategori <span class="text-gradient">Pengaduan</span></h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Pilih kategori yang sesuai dengan laporan Anda untuk penanganan yang lebih cepat dan tepat sasaran</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                @foreach($categories as $category)
                <div class="group bg-white dark:bg-dark-card rounded-2xl p-6 border border-gray-100 dark:border-dark-border hover:border-primary-200 dark:hover:border-primary-800 hover:shadow-soft-lg transition-all duration-300 cursor-pointer hover:-translate-y-1" data-animate>
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-4 transition-transform duration-300 group-hover:scale-110" style="background-color: {{ $category->color }}15;">
                        <svg class="w-6 h-6" style="color: {{ $category->color }};" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            @switch($category->icon)
                                @case('building-office')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                    @break
                                @case('user-group')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                    @break
                                @case('academic-cap')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/>
                                    @break
                                @case('heart')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    @break
                                @case('shield-check')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                    @break
                                @case('globe-americas')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    @break
                                @case('truck')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m-12 0l-4 8h16l-4-8m-8 0v8m8-8v8m-8 0h8m-8 0a2 2 0 100 4 2 2 0 000-4zm8 0a2 2 0 100 4 2 2 0 000-4z"/>
                                    @break
                                @default
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            @endswitch
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg mb-1">{{ $category->name }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-3 line-clamp-2">{{ $category->description }}</p>
                    <span class="text-xs font-medium text-primary-600 dark:text-primary-400">{{ $category->tickets_count }} laporan →</span>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- How it works --}}
    <section id="cara-kerja" class="py-20 bg-white dark:bg-dark-card">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Cara <span class="text-gradient">Kerja</span></h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Hanya butuh 4 langkah mudah untuk menyampaikan laporan Anda</p>
            </div>

            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
                @php
                $steps = [
                    ['num' => '01', 'title' => 'Buat Akun', 'desc' => 'Daftar dengan email dan data diri Anda. Proses cepat dan aman.', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                    ['num' => '02', 'title' => 'Tulis Laporan', 'desc' => 'Sampaikan keluhan dengan detail, sertakan bukti foto/video jika ada.', 'icon' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z'],
                    ['num' => '03', 'title' => 'Proses Verifikasi', 'desc' => 'Tim kami akan memverifikasi dan menindaklanjuti laporan Anda.', 'icon' => 'M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4'],
                    ['num' => '04', 'title' => 'Masalah Selesai', 'desc' => 'Anda akan mendapat notifikasi saat laporan sudah ditindaklanjuti.', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
                ];
                @endphp

                @foreach($steps as $step)
                <div class="relative text-center" data-animate>
                    <div class="w-16 h-16 mx-auto bg-primary-50 dark:bg-primary-900/20 rounded-2xl flex items-center justify-center mb-4">
                        <svg class="w-7 h-7 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $step['icon'] }}"/></svg>
                    </div>
                    <span class="text-xs font-bold text-primary-400 uppercase tracking-wider">Langkah {{ $step['num'] }}</span>
                    <h3 class="font-bold text-lg mt-1 mb-2">{{ $step['title'] }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $step['desc'] }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Testimonials --}}
    <section class="py-20 bg-gray-50 dark:bg-dark-bg">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Apa Kata <span class="text-gradient">Mereka</span></h2>
                <p class="text-gray-500 dark:text-gray-400 max-w-2xl mx-auto">Ribuan masyarakat telah merasakan manfaat TicketLapor</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                @php
                $testimonials = [
                    ['name' => 'Ahmad Rizki', 'role' => 'Warga Jakarta Selatan', 'text' => 'Laporkan jalan berlubang di depan rumah, 3 hari kemudian langsung diperbaiki! Luar biasa responsif.', 'rating' => 5],
                    ['name' => 'Siti Nurhaliza', 'role' => 'Warga Surabaya', 'text' => 'Sangat mudah digunakan, bahkan orang tua saya yang gaptek pun bisa membuat laporan sendiri. UI-nya sangat intuitif.', 'rating' => 5],
                    ['name' => 'Dewi Lestari', 'role' => 'Warga Yogyakarta', 'text' => 'Transparansi yang luar biasa! Bisa tracking status laporan secara realtime. Tidak ada lagi laporan yang hilang.', 'rating' => 5],
                ];
                @endphp

                @foreach($testimonials as $testimonial)
                <div class="bg-white dark:bg-dark-card rounded-2xl p-6 border border-gray-100 dark:border-dark-border shadow-soft hover:shadow-soft-lg transition-all duration-300" data-animate>
                    <div class="flex gap-1 mb-4">
                        @for($i = 0; $i < $testimonial['rating']; $i++)
                        <svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 dark:text-gray-400 mb-4 text-sm leading-relaxed">"{{ $testimonial['text'] }}"</p>
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($testimonial['name']) }}&background=3B82F6&color=fff&size=40" alt="{{ $testimonial['name'] }}" class="w-10 h-10 rounded-xl">
                        <div>
                            <p class="font-semibold text-sm">{{ $testimonial['name'] }}</p>
                            <p class="text-xs text-gray-500">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- FAQ --}}
    <section id="faq" class="py-20 bg-white dark:bg-dark-card">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12" data-animate>
                <h2 class="text-3xl sm:text-4xl font-extrabold mb-4">Pertanyaan <span class="text-gradient">Umum</span></h2>
            </div>

            <div class="space-y-3" x-data="{ active: null }">
                @php
                $faqs = [
                    ['q' => 'Apakah layanan ini gratis?', 'a' => 'Ya, TicketLapor sepenuhnya gratis untuk seluruh masyarakat Indonesia. Anda tidak perlu membayar apapun untuk membuat laporan atau menggunakan fitur lainnya.'],
                    ['q' => 'Berapa lama laporan saya akan ditanggapi?', 'a' => 'Tim kami berusaha menanggapi setiap laporan dalam waktu kurang dari 24 jam. Untuk kasus darurat, respons akan lebih cepat dalam hitungan jam.'],
                    ['q' => 'Apakah identitas pelapor dijaga kerahasiaannya?', 'a' => 'Ya, kami menjamin kerahasiaan identitas pelapor. Data pribadi Anda dilindungi dan tidak akan dibagikan ke pihak ketiga tanpa persetujuan.'],
                    ['q' => 'Bagaimana cara melacak status laporan saya?', 'a' => 'Setelah login, Anda bisa melihat status laporan secara realtime di Dashboard. Anda juga akan menerima notifikasi setiap ada perubahan status.'],
                    ['q' => 'Apa saja jenis laporan yang bisa dibuat?', 'a' => 'Anda bisa melaporkan berbagai hal mulai dari infrastruktur rusak, pelayanan publik buruk, masalah pendidikan, kesehatan, keamanan, lingkungan, transportasi, dan lainnya.'],
                ];
                @endphp

                @foreach($faqs as $index => $faq)
                <div class="border border-gray-200 dark:border-dark-border rounded-2xl overflow-hidden transition-all duration-200" :class="active === {{ $index }} ? 'shadow-soft' : ''" data-animate>
                    <button @click="active = active === {{ $index }} ? null : {{ $index }}"
                            class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        <span class="font-medium text-sm pr-4">{{ $faq['q'] }}</span>
                        <svg class="w-5 h-5 text-gray-400 shrink-0 transition-transform duration-200" :class="active === {{ $index }} ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    <div x-show="active === {{ $index }}" x-collapse>
                        <div class="px-5 pb-5 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">{{ $faq['a'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- CTA --}}
    <section class="py-20 bg-gradient-to-r from-primary-600 to-primary-800 dark:from-primary-800 dark:to-primary-950 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        <div class="relative max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">Siap Menyampaikan Aspirasi Anda?</h2>
            <p class="text-primary-100 mb-8 text-lg">Bergabung dengan ribuan masyarakat yang telah merasakan perubahan nyata</p>
            <a href="{{ route('register') }}" class="inline-flex items-center gap-2 px-8 py-4 bg-white text-primary-700 font-bold rounded-2xl hover:bg-gray-50 transition-all duration-300 hover:shadow-xl hover:-translate-y-0.5 text-base">
                Mulai Sekarang — Gratis
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-gray-900 dark:bg-dark-card text-gray-400 py-12 border-t border-gray-800 dark:border-dark-border">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div class="md:col-span-2">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-9 h-9 bg-gradient-to-br from-primary-500 to-primary-700 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                        </div>
                        <span class="font-bold text-xl text-white">TicketLapor</span>
                    </div>
                    <p class="text-sm leading-relaxed max-w-sm">Sistem pengaduan dan pelaporan masyarakat Indonesia yang modern, transparan, dan terpercaya.</p>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-sm">Layanan</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Buat Laporan</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Lacak Status</a></li>
                        <li><a href="#" class="hover:text-primary-400 transition-colors">Statistik</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-white mb-3 text-sm">Kontak</h4>
                    <ul class="space-y-2 text-sm">
                        <li>📧 support@ticketlapor.id</li>
                        <li>📱 0812-0000-0001</li>
                        <li>🏢 Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>
            <div class="pt-8 border-t border-gray-800 text-center text-sm">
                <p>© {{ date('Y') }} TicketLapor. Dibuat dengan ❤️ untuk Indonesia.</p>
            </div>
        </div>
    </footer>
</div>
