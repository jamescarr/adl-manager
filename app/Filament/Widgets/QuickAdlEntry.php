<?php

namespace App\Filament\Widgets;

use App\Models\AdlRecord;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Widgets\Widget;

class QuickAdlEntry extends Widget
{
    protected static string $view = 'filament.widgets.quick-adl-entry';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('patient_id')
                    ->relationship('patient', 'name')
                    ->searchable()
                    ->required(),
                Forms\Components\Select::make('adl_type_id')
                    ->relationship('adlType', 'name')
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'completed' => 'Completed',
                        'in_progress' => 'In Progress',
                        'cancelled' => 'Cancelled',
                    ])
                    ->required(),
                Forms\Components\DateTimePicker::make('recorded_at')
                    ->required(),
                Forms\Components\TextInput::make('duration')
                    ->numeric()
                    ->label('Duration (minutes)'),
                Forms\Components\Select::make('assistance_level')
                    ->options(AdlRecord::ASSISTANCE_LEVELS),
                Forms\Components\Select::make('mood')
                    ->options(AdlRecord::MOOD_OPTIONS),
                Forms\Components\TextInput::make('pain_level')
                    ->numeric()
                    ->min(0)
                    ->max(10),
                Forms\Components\Textarea::make('notes'),
            ])
            ->statePath('data');
    }

    public function submit(): void
    {
        $data = $this->form->getState();
        $data['created_by'] = auth()->id();

        AdlRecord::create($data);

        $this->form->fill();

        $this->dispatch('adl-created');
    }
}
