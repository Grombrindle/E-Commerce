<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Products - E-commerce")]
class ProductsPage extends Component
{


    use WithPagination;



    #[Url]
    public $selected_categories = [];

    #[Url]
    public $selected_brands = [];

    #[Url]
    public $featured = [];

    #[Url]
    public $On_Sale = [];


    #[Url]
    public $price_range = 5000;

    #[Url]
    public $sort = 'latest';

    public function addToCart($product_id)
    {
        $total_count = CartManagement::addItemToCart($product_id);

        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);
    }

    public function render()
    {
        $query = Product::query()->where('is_active', 1);

        if (!empty($this->selected_categories)) {
            $query->whereIn('category_id', $this->selected_categories);
        }
        if (!empty($this->selected_brands)) {
            $query->whereIn('brand_id', $this->selected_brands);
        }
        if ($this->featured) {
            $query->where('is_featured', 1);
        }
        if ($this->On_Sale) {
            $query->where('on_sale', 1);
        }
        if ($this->price_range) {
            $query->whereBetween('price', [0, $this->price_range]);
        }

        if ($this->sort == 'latest') {
            $query->latest();
        }

        if ($this->sort == 'price') {
            $query->orderBy('price');
        }

        $products = $query->paginate(6);

        return view('livewire.products-page', [
            'products' => $products,
            'brands' => Brand::where('is_active', 1)->get(['id', 'name', 'slug']),
            'categories' => Category::where('is_active', 1)->get(['id', 'name', 'slug']),
        ]);
    }
}
