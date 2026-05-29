<div>
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Admin Dashboard</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Overview seluruh laporan dan statistik sistem</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-primary-100 dark:bg-primary-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                </div>
                <span class="text-xs font-medium text-emerald-600 bg-emerald-50 dark:bg-emerald-900/20 px-2 py-0.5 rounded-md">+{{ $todayTickets }} hari ini</span>
            </div>
            <p class="text-2xl font-bold">{{ number_format($totalTickets) }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Total Laporan</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $pendingTickets }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Menunggu Ditangani</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $resolvedTickets }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Selesai</p>
        </div>

        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
            </div>
            <p class="text-2xl font-bold">{{ $totalUsers }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Total Pengguna</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        {{-- Chart Area --}}
        <div class="lg:col-span-2 bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
            <h3 class="font-semibold mb-4">Tren Laporan 6 Bulan Terakhir</h3>
            <div wire:ignore>
                <div id="trend-chart" x-data x-init="
                    setTimeout(() => {
                        if(typeof ApexCharts !== 'undefined') {
                            new ApexCharts(document.querySelector('#trend-chart'), {
                                chart: { type: 'area', height: 280, toolbar: { show: false }, fontFamily: 'Inter' },
                                series: [
                                    { name: 'Total Laporan', data: {{ json_encode(array_column($monthlyData, 'total')) }} },
                                    { name: 'Selesai', data: {{ json_encode(array_column($monthlyData, 'resolved')) }} }
                                ],
                                xaxis: { categories: {{ json_encode(array_column($monthlyData, 'month')) }} },
                                colors: ['#3B82F6', '#10B981'],
                                fill: { type: 'gradient', gradient: { opacityFrom: 0.4, opacityTo: 0.1 } },
                                stroke: { curve: 'smooth', width: 2 },
                                grid: { borderColor: '#E5E7EB', strokeDashArray: 4 },
                                dataLabels: { enabled: false },
                                tooltip: { theme: document.documentElement.classList.contains('dark') ? 'dark' : 'light' }
                            }).render();
                        }
                    }, 100);
                " class="min-h-[280px]"></div>
            </div>
        </div>

        {{-- Category Stats --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
            <h3 class="font-semibold mb-4">Per Kategori</h3>
            <div class="space-y-3">
                @foreach($categoryStats as $cat)
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0" style="background-color: {{ $cat->color }}15;">
                        <span class="text-xs font-bold" style="color: {{ $cat->color }};">{{ substr($cat->name, 0, 2) }}</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-sm truncate">{{ $cat->name }}</span>
                            <span class="text-xs font-medium text-gray-500 shrink-0">{{ $cat->tickets_count }}</span>
                        </div>
                        <div class="w-full h-1.5 bg-gray-100 dark:bg-gray-800 rounded-full overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-500" style="width: {{ $totalTickets > 0 ? ($cat->tickets_count / $totalTickets * 100) : 0 }}%; background-color: {{ $cat->color }};"></div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Recent Tickets --}}
    <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft">
        <div class="p-5 border-b border-gray-100 dark:border-dark-border flex items-center justify-between">
            <h3 class="font-semibold">Laporan Terbaru</h3>
            <a href="{{ route('admin.tickets') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:underline">Lihat Semua →</a>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b border-gray-100 dark:border-dark-border">
                        <th class="p-4">No. Tiket</th>
                        <th class="p-4">Judul</th>
                        <th class="p-4">Pelapor</th>
                        <th class="p-4">Kategori</th>
                        <th class="p-4">Status</th>
                        <th class="p-4">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-dark-border">
                    @foreach($recentTickets as $ticket)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors cursor-pointer" onclick="window.location='{{ route('admin.tickets.show', $ticket) }}'">
                        <td class="p-4 text-sm font-mono text-primary-600">{{ $ticket->ticket_number }}</td>
                        <td class="p-4 text-sm font-medium max-w-[200px] truncate">{{ $ticket->title }}</td>
                        <td class="p-4">
                            <div class="flex items-center gap-3">
                                <img src="{{ $ticket->user ? $ticket->user->avatar_url : 'https://ui-avatars.com/api/?name='.urlencode($ticket->reporter_name ?? 'Anonim').'&background=EF4444&color=fff' }}" class="w-8 h-8 rounded-lg shrink-0">
                                <span class="text-sm">{{ $ticket->user->name ?? $ticket->reporter_name ?? 'Anonim Darurat' }}</span>
                            </div>
                        </td>
                        <td class="p-4 text-sm">{{ $ticket->category->name }}</td>
                        <td class="p-4"><span class="px-2.5 py-1 rounded-lg text-xs font-medium {{ $ticket->status->bgClass() }}">{{ $ticket->status->label() }}</span></td>
                        <td class="p-4 text-sm text-gray-500">{{ $ticket->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
