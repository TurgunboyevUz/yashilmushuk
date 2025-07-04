<?php

namespace Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FinancialStatsWidget extends BaseWidget implements HasForms
{
    use InteractsWithForms;
    
    protected ?string $heading = 'Iqtisodiy statistika';
    
    protected int | string | array $columnSpan = 'full';
    
    public ?array $data = [];
    
    public function mount(): void
    {
        $this->form->fill([
            'period' => 'daily',
        ]);
    }
    
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('period')
                    ->label('Vaqt oralig\'i')
                    ->options([
                        'daily' => 'Kunlik',
                        'weekly' => 'Haftalik',
                        'monthly' => 'Oylik',
                        'yearly' => 'Yillik',
                    ])
                    ->native(false)
                    ->default('daily')
                    ->live()
                    ->afterStateUpdated(fn () => $this->dispatch('$refresh')),
            ])
            ->statePath('data');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            \Filament\Actions\SelectAction::make('period')
                ->label('Vaqt oralig\'i')
                ->options([
                    'daily' => 'Kunlik',
                    'weekly' => 'Haftalik',
                    'monthly' => 'Oylik',
                    'yearly' => 'Yillik',
                ])
                ->default('daily')
                ->action(function (string $data) {
                    $this->data['period'] = $data;
                    $this->dispatch('$refresh');
                }),
        ];
    }
    
    public function render(): \Illuminate\View\View
    {
        return view('filament.widgets.financial-stats-widget', [
            'stats' => $this->getStats(),
            'form' => $this->form,
        ]);
    }

    protected function getStats(): array
    {
        $period = $this->data['period'] ?? 'daily';
        
        $dateRange = $this->getDateRange($period);
        
        $salesTotal = $this->getSalesTotal($dateRange);
        $expensesTotal = $this->getExpensesTotal($dateRange);
        $debtsTotal = $this->getDebtsTotal($dateRange);

        return [
            Stat::make('Sotuvlar', $this->formatCurrency($salesTotal)),
            Stat::make('Xarajatlar', $this->formatCurrency($expensesTotal)),
            Stat::make('Qarzlar', $this->formatCurrency($debtsTotal)),
        ];
    }

    private function getDateRange(string $period): array
    {
        $now = Carbon::now();
        
        switch ($period) {
            case 'daily':
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay(),
                ];
                
            case 'weekly':
                return [
                    'start' => $now->copy()->startOfWeek(),
                    'end' => $now->copy()->endOfWeek(),
                ];
                
            case 'monthly':
                return [
                    'start' => $now->copy()->startOfMonth(),
                    'end' => $now->copy()->endOfMonth(),
                ];
                
            case 'yearly':
                return [
                    'start' => $now->copy()->startOfYear(),
                    'end' => $now->copy()->endOfYear(),
                ];

            default:
                return [
                    'start' => $now->copy()->startOfDay(),
                    'end' => $now->copy()->endOfDay(),
                ];
        }
    }

    private function getSalesTotal(array $dateRange): float
    {
        return DB::table('sales')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->sum('total_price');
    }

    private function getExpensesTotal(array $dateRange): float
    {
        return DB::table('expenses')
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->sum('amount');
    }

    private function getDebtsTotal(array $dateRange): float
    {
        return DB::table('debts')
            ->where('status', false)
            ->whereBetween('created_at', [$dateRange['start'], $dateRange['end']])
            ->sum('amount');
    }

    private function formatCurrency(float $amount): string
    {
        return number_format($amount, thousands_separator: ' ') . ' so\'m';
    }
}