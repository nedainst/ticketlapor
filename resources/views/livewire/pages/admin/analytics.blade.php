<div>
    <h1 class="text-2xl font-bold mb-6">Analitik & Statistik</h1>

    {{-- KPIs --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <p class="text-2xl font-bold text-gradient">{{ number_format($totalTickets) }}</p>
            <p class="text-xs text-gray-500 mt-1">Total Laporan</p>
        </div>
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <p class="text-2xl font-bold text-emerald-600">{{ number_format($resolvedTickets) }}</p>
            <p class="text-xs text-gray-500 mt-1">Selesai</p>
        </div>
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <p class="text-2xl font-bold text-amber-500">{{ $avgResponseTime < 60 ? $avgResponseTime . ' min' : round($avgResponseTime / 60, 1) . ' jam' }}</p>
            <p class="text-xs text-gray-500 mt-1">Rata-rata Respon</p>
        </div>
        <div class="bg-white dark:bg-dark-card rounded-2xl p-5 border border-gray-100 dark:border-dark-border shadow-soft">
            <p class="text-2xl font-bold text-purple-600">{{ $resolutionRate }}%</p>
            <p class="text-xs text-gray-500 mt-1">Tingkat Penyelesaian</p>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6 mb-6">
        {{-- Monthly Trend --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
            <h3 class="font-semibold mb-4">Tren 12 Bulan</h3>
            <div wire:ignore>
                <div id="monthly-chart" x-data x-init="
                    setTimeout(() => {
                        if(typeof ApexCharts !== 'undefined') {
                            new ApexCharts($el, {
                                chart: { type: 'bar', height: 300, toolbar: { show: false }, fontFamily: 'Inter' },
                                series: [
                                    { name: 'Total', data: {{ json_encode(array_column($monthlyData, 'total')) }} },
                                    { name: 'Selesai', data: {{ json_encode(array_column($monthlyData, 'resolved')) }} }
                                ],
                                xaxis: { categories: {{ json_encode(array_column($monthlyData, 'month')) }}, labels: { rotate: -45, style: { fontSize: '10px' } } },
                                colors: ['#3B82F6', '#10B981'],
                                plotOptions: { bar: { borderRadius: 4, columnWidth: '60%' } },
                                grid: { borderColor: '#E5E7EB', strokeDashArray: 4 },
                                dataLabels: { enabled: false },
                            }).render();
                        }
                    }, 100);
                " class="min-h-[300px]"></div>
            </div>
        </div>

        {{-- Category Pie --}}
        <div class="bg-white dark:bg-dark-card rounded-2xl border border-gray-100 dark:border-dark-border shadow-soft p-5">
            <h3 class="font-semibold mb-4">Per Kategori</h3>
            <div wire:ignore>
                <div id="category-chart" x-data x-init="
                    setTimeout(() => {
                        if(typeof ApexCharts !== 'undefined') {
                            new ApexCharts($el, {
                                chart: { type: 'donut', height: 300, fontFamily: 'Inter' },
                                series: {{ json_encode($categories->pluck('tickets_count')->toArray()) }},
                                labels: {{ json_encode($categories->pluck('name')->toArray()) }},
                                colors: {{ json_encode($categories->pluck('color')->toArray()) }},
                                plotOptions: { pie: { donut: { size: '55%' } } },
                                legend: { position: 'bottom', fontSize: '12px' },
                                dataLabels: { enabled: false },
                            }).render();
                        }
                    }, 100);
                " class="min-h-[300px]"></div>
            </div>
        </div>
    </div>
</div>
