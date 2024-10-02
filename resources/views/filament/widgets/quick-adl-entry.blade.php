<x-filament-widgets::widget>
    <x-filament::card>
        <form wire:submit.prevent="submit">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-4">
                Create ADL Record
            </x-filament::button>
        </form>
    </x-filament::card>
</x-filament-widgets::widget>
