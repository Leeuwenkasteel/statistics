<?php

namespace Leeuwenkasteel\Statistics\Livewire;

use Livewire\Component;
use Leeuwenkasteel\Cashdesk\Models\Receipt;
use Leeuwenkasteel\Cashdesk\Models\ReceiptPayments;

class Dashboard extends Component
{
    public $todayIncome = 0;
    public $weekIncome = 0;
    public $monthIncome = 0;

    public $todayCount = 0;
    public $weekCount = 0;
    public $monthCount = 0;

    public $averageReceipt = 0;

    public function mount()
    {
        $this->todayIncome = Receipt::whereDate('paid_at', today())
            ->where('status', 'paid')
            ->sum('total');

        $this->weekIncome = Receipt::whereBetween('paid_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])
        ->where('status', 'paid')
        ->sum('total');

        $this->monthIncome = Receipt::whereBetween('paid_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])
        ->where('status', 'paid')
        ->sum('total');

        $this->todayCount = Receipt::whereDate('paid_at', today())
            ->where('status', 'paid')
            ->count();

        $this->weekCount = Receipt::whereBetween('paid_at', [
            now()->startOfWeek(),
            now()->endOfWeek()
        ])
        ->where('status', 'paid')
        ->count();

        $this->monthCount = Receipt::whereBetween('paid_at', [
            now()->startOfMonth(),
            now()->endOfMonth()
        ])
        ->where('status', 'paid')
        ->count();

        $this->averageReceipt = $this->monthCount > 0
            ? $this->monthIncome / $this->monthCount
            : 0;
    }

    public function render()
    {
        return view('statistics::livewire.dashboard');
    }
}