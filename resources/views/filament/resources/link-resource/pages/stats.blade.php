<x-filament-panels::page>
    <div class="mb-4 p-4 bg-white dark:bg-gray-900 rounded-xl shadow-sm">
        <p class="text-sm text-gray-500">Оригинальный URL:</p>
        <p class="font-medium break-all">{{ $this->record->original_url }}</p>
    </div>

    {{ $this->table }}
</x-filament-panels::page>
