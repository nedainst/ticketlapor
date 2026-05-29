@props(['scanError' => null])
<div class="my-4 p-4 bg-white rounded-lg shadow-lg text-center border border-gray-100 dark:border-gray-800">
    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3 font-medium">Isi otomatis & amankan salinan KTP (PDF)</p>
    
    <label class="w-full py-2.5 px-4 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg transition shadow-md cursor-pointer flex items-center justify-center gap-2" wire:loading.class="opacity-50 cursor-wait">
        <span wire:loading.remove wire:target="ktpPhoto">
            <svg class="w-5 h-5 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
            Upload Foto KTP
        </span>
        <span wire:loading wire:target="ktpPhoto">
            <svg class="w-5 h-5 animate-spin inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/></svg>
            Memproses ke PDF & Ekstrak Data...
        </span>
        <input type="file" accept="image/*" wire:model="ktpPhoto" class="hidden" />
    </label>

    @if($scanError)
        <div class="mt-2 text-sm text-red-600">{{ $scanError }}</div>
    @endif
</div>
