<x-filament::page>
    <x-filament::widgets
        :widgets="$this->getHeaderWidgets()"
        class="filament-dashboard-widgets"
    />

    <x-filament::widgets
        :widgets="$this->getFooterWidgets()"
        class="filament-dashboard-widgets"
    />
</x-filament::page>
