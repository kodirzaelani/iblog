<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Religi;

use Livewire\Component;
use App\Models\Agama;

class Religicreate extends Component
{
    public $agamaid;
    public $nama;



    public function store()
    {
        $validateData = [
            'agamaid' => 'required|min:1|unique:agama,agamaid',
            'nama' => 'required|min:2|unique:agama,nama',
        ];

         // Default data
         $data = [
            'agamaid'        => $this->agamaid,
            'nama' => $this->nama,
        ];

        $this->validate($validateData);

        $religi = Agama::create($data);

        // even listener -> emit
        $this->emit('religiStored', $religi);
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
        return view('livewire.template.backend.nusantara.religi.religicreate');
    }
}
