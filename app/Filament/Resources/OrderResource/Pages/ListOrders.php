<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
    protected function getHeaderWidgets(): array
    {
        return [
            orderResource\Widgets\OrderStats::class,
        ];
    }

    public function getTabs(): array
    {
        return [
            null => Tab::make("All"),
            'new' => Tab::make()->query(fn($query) => $query->where('status', 'new')),
            'Processing' => Tab::make()->query(fn($query) => $query->where('status', 'processing')),
            'Shipped' => Tab::make()->query(fn($query) => $query->where('status', 'shipped')),
            'Deliverd' => Tab::make()->query(fn($query) => $query->where('status', 'delivered')),
            'Canceled' => Tab::make()->query(fn($query) => $query->where('status', 'canceled')),
        ];
    }
}
