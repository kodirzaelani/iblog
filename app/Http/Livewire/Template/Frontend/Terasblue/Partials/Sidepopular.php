<?php

namespace App\Http\Livewire\Template\Frontend\Terasgreen\Partials;

use App\Models\Post;
use Livewire\Component;

class Sidepopular extends Component
{
    public function render()
    {
        return view('livewire.template.frontend.terasgreen.partials.sidepopular', [
            'post_popular' => Post::published()
                ->publishedate()
                ->popular()
                ->take(4)
                ->get(),
            'titlepopular' => 'Update Populer'
        ]);
    }
}
