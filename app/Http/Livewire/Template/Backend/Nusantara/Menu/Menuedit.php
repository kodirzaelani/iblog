<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menu;

use App\Models\Menufrontend;
use Livewire\Component;

class Menuedit extends Component
{
    public $name;
    public $status;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Menufrontend::find($this->modelId);

        $this->name = $model->name;
    }

    public function update()
    {
        $validateData = [
            'name' => 'required|min:2',
        ];

         // Default data
         $data = [
            'name'   => $this->name,
        ];

        $this->validate($validateData);
        $menu = Menufrontend::find($this->modelId);

        $menu->update($data);

        // even listener -> emit
        $this->emit('menucategoryUpdated', $menu);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->name = null;
    }
    public function render()
    {
        return view('livewire.template.backend.nusantara.menu.menuedit');
    }
}
