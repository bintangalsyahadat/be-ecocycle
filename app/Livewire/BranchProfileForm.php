<?php

namespace App\Livewire;

use App\Models\Branch;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasSort;
use Joaopaulolndev\FilamentEditProfile\Concerns\HasUser;
use Joaopaulolndev\FilamentEditProfile\Livewire\BaseProfileForm;

class BranchProfileForm extends BaseProfileForm
{
    use HasSort;
    use HasUser;

    protected static int $sort = 25;

    protected string $view = 'livewire.branch-profile-form';

    public ?array $data = [];

    public function mount(): void
    {
        $this->user = $this->getUser();

        $this->form->fill([
            'branches' => $this->user->branches()->pluck('branches.id')->toArray(),
        ]);
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Branch Access')
                    ->description('Select which branches you have access to')
                    ->aside()
                    ->schema([
                        Select::make('branches')
                            ->label('Branches')
                            ->options(Branch::where('is_active', true)->pluck('name', 'id'))
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        $this->user->branches()->sync($data['branches'] ?? []);

        Notification::make()
            ->success()
            ->title('Branch access updated')
            ->send();
    }
}
