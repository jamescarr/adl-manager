<x-filament::widget>
    <x-filament::card>
        <div class="grid grid-cols-3 gap-4">
            <div>
                <h3 class="text-lg font-medium text-gray-900">Total Patients</h3>
                <p class="mt-1 text-3xl font-semibold text-primary-600">{{ $this->totalPatients }}</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Total ADLs</h3>
                <p class="mt-1 text-3xl font-semibold text-primary-600">{{ $this->totalAdls }}</p>
            </div>
            <div>
                <h3 class="text-lg font-medium text-gray-900">Completed Today</h3>
                <p class="mt-1 text-3xl font-semibold text-primary-600">{{ $this->completedToday }}</p>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>
