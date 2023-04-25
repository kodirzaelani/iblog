<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Videocategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Videocategory;
use Illuminate\Support\Facades\Auth;

class Videocategorycreate extends Component
{
    public $title;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:videocategories,title',
        ];

         // Default data
         $data = [
            'title'        => $this->title,
            'slug'      => Str::slug($this->title),
            'author_id'     => Auth::id(),
        ];

        $this->validate($validateData);

        $videocategory = Videocategory::create($data);

        // even listener -> emit
        $this->emit('videocategoryStored', $videocategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title        = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.videocategory.videocategorycreate');
    }
}
