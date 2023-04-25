<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Page\Pagecategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Pagecategory;

class Pagecategorycreate extends Component
{
    public $title;
    public $slug;



    public function store()
    {
        $validateData = [
            'title' => 'required|min:2|unique:pagecategories,title',
        ];

         // Default data
         $data = [
            'title' => $this->title,
            'slug'  => Str::slug($this->title,),
        ];

        $this->validate($validateData);

        $pagecategory = Pagecategory::create($data);

        // even listener -> emit
        $this->emit('pagecategoryStored', $pagecategory);
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
        return view('livewire.template.backend.nusantara.page.pagecategory.pagecategorycreate');
    }
}
