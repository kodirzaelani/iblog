<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download\Downloadcategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Downloadcategory;
use Illuminate\Support\Facades\Auth;

class Downloadcategorycreate extends Component
{
    public $title;
    public $slug;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:downloadcategories,title',
        ];

        $this->validate($validateData);

        $data = [];

        // Default data
        $data = [
            'title'     => $this->title,
            'slug'      => Str::slug($this->title,),
            'author_id'           => Auth::id(),
        ];

        $downloadcategory = Downloadcategory::create($data);

        // even listener -> emit
        $this->emit('downloadcategoryStored', $downloadcategory);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->title = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.download.downloadcategory.downloadcategorycreate');
    }
}
