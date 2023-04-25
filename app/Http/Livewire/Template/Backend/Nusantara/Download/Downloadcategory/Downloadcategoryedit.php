<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Download\Downloadcategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Downloadcategory;
use Livewire\WithFileUploads;

class Downloadcategoryedit extends Component
{
    use WithFileUploads;
    public $title;
    public $slug;
    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Downloadcategory::find($this->modelId);

        $this->title     = $model->title;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
        ];

        $this->validate($validateData);

        $data = [];

        // Default data
        $data = [
            'title'     => $this->title,
            'slug'      => Str::slug($this->title,),
        ];

        $downloadcategory = Downloadcategory::find($this->modelId);

        $downloadcategory->update($data);

        // even listener -> emit
        $this->emit('downloadcategoryUpdated', $downloadcategory);
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
        return view('livewire.template.backend.nusantara.download.downloadcategory.downloadcategoryedit');
    }
}
