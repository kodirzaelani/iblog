<?php

namespace App\Http\Livewire\Template\Frontend\Terasgreen\Partials;

use Livewire\Component;
use App\Models\Postcategory;

class Sidecategory extends Component
{
    public function render()
    {
        return view('livewire.template.frontend.terasgreen.partials.sidecategory', [
            'postcategories' => Postcategory::with('posts')->orderBy('title', 'asc')->get(),
            'titlecategory' => 'Kategori',
        ]);
    }
}
