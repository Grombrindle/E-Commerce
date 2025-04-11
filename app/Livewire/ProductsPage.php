<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Products - E-commerce")]
class ProductsPage extends Component
{

    use WithPagination;

    public function render()
    {
        $products = Product::query()->where('is_active', 1)->get();
        return view('livewire.products-page', [
            'products' => $products->pago(6),
        ]);
    }
}
