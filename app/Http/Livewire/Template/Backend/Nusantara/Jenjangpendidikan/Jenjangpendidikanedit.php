<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Jenjangpendidikan;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Jenjangpendidikan;

class Jenjangpendidikanedit extends Component
{
    public $sortid;
    public $title;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Jenjangpendidikan::find($this->modelId);
        $this->sortid        = $model->sortid;
        $this->title = $model->title;
    }

    public function update()
    {
        $validateData = [
            'sortid' => 'required|min:1',
            'title' => 'required|min:2',
        ];

         // Default data
         $data = [
            'sortid'        => $this->sortid,
            'title' => $this->title,
            'slug'      => Str::slug(time().$this->title),
        ];

        $this->validate($validateData);
        $jenjangpendidikan = Jenjangpendidikan::find($this->modelId);

        $jenjangpendidikan->update($data);

        // even listener -> emit
        $this->emit('jenjangpendidikanUpdated', $jenjangpendidikan);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->sortid        = null;
        $this->title = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.jenjangpendidikan.jenjangpendidikanedit');
    }
}
