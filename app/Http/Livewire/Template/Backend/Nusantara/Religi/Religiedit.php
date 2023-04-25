<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Religi;

use Livewire\Component;
use App\Models\Agama;

class Religiedit extends Component
{
    public $agamaid;
    public $nama;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Agama::find($this->modelId);
        $this->agamaid        = $model->agamaid;
        $this->nama = $model->nama;
    }

    public function update()
    {
        $validateData = [
            'agamaid' => 'required|min:1',
            'nama' => 'required|min:2',
        ];

         // Default data
         $data = [
            'agamaid'        => $this->agamaid,
            'nama' => $this->nama,
        ];

        $this->validate($validateData);
        $religi = Agama::find($this->modelId);

        $religi->update($data);

        // even listener -> emit
        $this->emit('religiUpdated', $religi);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->agamaid        = null;
        $this->nama = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.religi.religiedit');
    }
}
