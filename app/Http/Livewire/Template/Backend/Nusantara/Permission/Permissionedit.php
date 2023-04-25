<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissionedit extends Component
{
    public $name;
    public $description;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Permission::find($this->modelId);
        $this->name        = $model->name;
        $this->description = $model->description;
    }

    public function update()
    {
        $validateData = [
            'name' => 'required|min:2',
        ];

         // Default data
         $data = [
            'name'        => $this->name,
            'description' => $this->description,
        ];

        $this->validate($validateData);
        $pemission = Permission::find($this->modelId);

        $pemission->update($data);

        // even listener -> emit
        $this->emit('permissionUpdated', $pemission);
        // This is to reset our public variables
        $this->cleanVars();

    }


    private function cleanVars()
    {
        // Kosongkan field input
        $this->name        = null;
        $this->description = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.permission.permissionedit');
    }
}
