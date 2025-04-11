<?php

namespace App\Livewire;

use App\Models\Brand;
use App\Models\Category;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title("Home Page - E-commerce")]

class HomePage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        $brands = Brand::where('is_active', 1)->get();
        return view('livewire.home-page', [
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }
}
