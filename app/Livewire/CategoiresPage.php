<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoiresPage extends Component
{
    public function render()
    {
        $categories = Category::where('is_active', 1)->get();
        return view('livewire.categoires-page', [
            'categories' => $categories,
        ]);
    }
}
