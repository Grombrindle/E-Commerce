<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Illuminate\Support\Number;
use App\Models\Order;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class OrderStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('new Orders', Order::query()->where('status', 'new')->count())
                ->description('Being orderd')
                ->descriptionIcon('heroicon-m-shopping-bag')
                ->color('warning'),

            Stat::make('Orders Processing', Order::where('status', 'processing')->count())
                ->color('info')
                ->description('Currently being processed')
                ->descriptionIcon('heroicon-m-arrow-path'),

            Stat::make('Orders Shipped', Order::where('status', 'shipped')->count())
                ->color('info')
                ->description('On their way to customers')
                ->descriptionIcon('heroicon-m-truck'),

            Stat::make('Average Order Value', Number::currency(Order::avg('grand_total')))
                ->description('Across all orders')
                ->color('success')
                ->descriptionIcon('heroicon-m-currency-dollar')
        ];
    }
}
