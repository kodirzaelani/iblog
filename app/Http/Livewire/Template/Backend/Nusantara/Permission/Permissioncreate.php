<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Permission;

use Livewire\Component;
use Spatie\Permission\Models\Permission;

class Permissioncreate extends Component
{
    public $name;
    public $description;



    public function store()
    {
        $validateData = [
            'name' => 'required|min:2|unique:permissions,name',
        ];

         // Default data
         $data = [
            'name'        => $this->name,
            'description' => $this->description,
        ];

        $this->validate($validateData);

        $pemission = Permission::create($data);

        // even listener -> emit
        $this->emit('permissionStored', $pemission);
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
        return view('livewire.template.backend.nusantara.permission.permissioncreate');
    }
}
