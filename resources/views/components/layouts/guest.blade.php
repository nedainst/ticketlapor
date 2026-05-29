<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="TicketLapor - Sistem pengaduan dan pelaporan masyarakat Indonesia yang modern, cepat, dan transparan">

    <title>{{ $title ?? 'TicketLapor - Suara Anda, Perubahan Nyata' }}</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>📋</text></svg>">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-white dark:bg-dark-bg text-gray-900 dark:text-gray-100 font-sans antialiased">
    <!-- Toast Notification -->
    <div x-data="{ toasts: [] }"
         @toast.window="toasts.push({id: Date.now(), message: $event.detail.message, type: $event.detail.type}); setTimeout(() => toasts.shift(), 4000)"
         class="fixed top-4 right-4 z-[100] space-y-2">
        <template x-for="toast in toasts" :key="toast.id">
            <div x-show="true"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-x-8"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 :class="{
                    'bg-emerald-500': toast.type === 'success',
                    'bg-red-500': toast.type === 'error',
                    'bg-amber-500': toast.type === 'warning',
                    'bg-blue-500': toast.type === 'info'
                 }"
                 class="text-white px-5 py-3 rounded-xl shadow-lg text-sm font-medium flex items-center gap-2 min-w-[280px]">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </template>
                <span x-text="toast.message"></span>
            </div>
        </template>
    </div>

    {{ $slot }}

    @livewireScripts
    <!-- Tesseract JS -->
    <script src="https://cdn.jsdelivr.net/npm/tesseract.js@5/dist/tesseract.min.js"></script>
</body>
</html>
