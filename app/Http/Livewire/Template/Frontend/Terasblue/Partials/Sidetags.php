<?php

namespace App\Http\Livewire\Template\Frontend\Terasgreen\Partials;

use App\Models\Tag;
use Livewire\Component;

class Sidetags extends Component
{
    public function render()
    {
        return view('livewire.template.frontend.terasgreen.partials.sidetags', [
            'posttags' => Tag::with('posts')->orderBy('title', 'asc')->take(15)->get(),
            'titletags' => 'Tags'
        ]);
    }
}
