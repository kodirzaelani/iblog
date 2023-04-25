<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Videocategory;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Videocategory;
use Illuminate\Support\Facades\Auth;

class Videocategoryedit extends Component
{
    public $title;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Videocategory::find($this->modelId);
        $this->title        = $model->title;
    }

    public function update()
    {
        $validateData = [
            'title' => 'required|min:2',
        ];

         // Default data
         $data = [
            'title'        => $this->title,
            'slug'      => Str::slug($this->title),
            'updated_by'     => Auth::id(),
        ];

        $this->validate($validateData);
        $videocategory = Videocategory::find($this->modelId);

        $videocategory->update($data);

        // even listener -> emit
        $this->emit('videocategoryUpdated', $videocategory);
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
        return view('livewire.template.backend.nusantara.videocategory.videocategoryedit');
    }
}
