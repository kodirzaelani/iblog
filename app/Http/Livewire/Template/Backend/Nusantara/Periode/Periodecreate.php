<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Periode;

use App\Models\Pergub;
use App\Models\Periode;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class Periodecreate extends Component
{
    public $pergub_id;
    public $slug;
    public $startdate;
    public $enddate;



    public function store()
    {
        $validateData = [
            'pergub_id' => 'required',
            'startdate'     => 'required|min:4|numeric',
            'enddate'     => 'required|min:4|numeric',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            'pergub_id'     => $this->pergub_id,
            'slug'      => Str::slug(time().$this->startdate),
            'startdate'     => $this->startdate,
            'enddate'     => $this->enddate,
            'author_id'           => Auth::id(),
        ];

        $periode = Periode::create($data);

        $this->emit('periodeStored', $periode);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->pergub_id = null;
        $this->startdate = null;
        $this->enddate = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.periode.periodecreate',[
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
        ]);
    }
}
