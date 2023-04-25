<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Page\Pagecategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Pagecategory;

class Pagecategoryedit extends Component
{
    public $title;
    public $slug;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Pagecategory::find($this->modelId);

        $this->title = $model->title;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
        ];

         // Default data
         $data = [
            'title'     => $this->title,
            'slug'      => Str::slug($this->title,),
        ];

        $this->validate($validateData);
        $pagecategory = Pagecategory::find($this->modelId);

        $pagecategory->update($data);

        // even listener -> emit
        $this->emit('pagecategoryUpdated', $pagecategory);
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
        return view('livewire.template.backend.nusantara.page.pagecategory.pagecategoryedit');
    }
}
