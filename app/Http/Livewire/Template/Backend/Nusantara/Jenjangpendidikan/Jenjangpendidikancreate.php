<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Jenjangpendidikan;

use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Jenjangpendidikan;

class Jenjangpendidikancreate extends Component
{
    public $sortid;
    public $title;



    public function store()
    {
        $validateData = [
            'sortid' => 'required|min:1|unique:jenjangpendidikans,sortid',
            'title' => 'required|min:2|unique:jenjangpendidikans,title',
        ];

         // Default data
         $data = [
            'sortid'        => $this->sortid,
            'title' => $this->title,
            'slug'      => Str::slug(time().$this->title),
        ];

        $this->validate($validateData);

        $jenjangpendidikan = Jenjangpendidikan::create($data);

        // even listener -> emit
        $this->emit('jenjangpendidikanStored', $jenjangpendidikan);
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
        return view('livewire.template.backend.nusantara.jenjangpendidikan.jenjangpendidikancreate');
    }
}
