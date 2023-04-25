<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Menu;

use App\Models\Menufrontend;
use Livewire\Component;

class Menucreate extends Component
{
    public $name;
    public $status;



    public function store()
    {
        $validateData = [
            'name' => 'required|min:2|unique:admin_menus,name',
        ];

         // Default data
         $data = [
            'name'   => $this->name,
            'status' => 1,
        ];

        $this->validate($validateData);
        $menucategory = Menufrontend::create($data);


        // even listener -> emit
        $this->emit('menucategoryStored', $menucategory);
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
        return view('livewire.template.backend.nusantara.menu.menucreate');
    }
}
