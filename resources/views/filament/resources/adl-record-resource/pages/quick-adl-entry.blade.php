<x-filament::widget>
    <x-filament::card>
        <h2 class="text-lg font-medium text-gray-900 mb-4">Quick ADL Entry</h2>
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-4">
                Create ADL Record
            </x-filament::button>
        </form>
    </x-filament::card>
</x-filament::widget>
