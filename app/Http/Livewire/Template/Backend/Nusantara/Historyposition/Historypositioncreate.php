<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Historyposition;

use App\Models\Employe;
use Livewire\Component;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Historyposition;
use Illuminate\Support\Facades\Auth;

class Historypositioncreate extends Component
{
    public $title;
    public $employe_id;
    public $startdate;
    public $enddate;

    public $modelId;

    protected $listeners = [
        'getEmployeId',
    ];

    public function getEmployeId($modelId)
    {
        $this->modelId = $modelId;

    }

    public function store()
    {
        $validateData = [
            'title' => 'required',
            'startdate'  => 'required',
            'enddate'    => 'required',
        ];

        $this->validate($validateData);

        // dd($this->modelId);

        $data = [];

        $data = [
            'employe_id'=> $this->modelId,
            'title'     => $this->title,
            'slug'      => Str::slug(time().$this->title),
            'startdate' => $this->startdate,
            'enddate'   => $this->enddate,
            'author_id' => Auth::id(),
        ];

        $historyposition = Historyposition::create($data);

        $this->emit('historypositionStored', $historyposition);
        $this->cleanVars();

    }

    private function cleanVars()
    {
        $this->title = null;
        $this->employe_id = null;
        $this->startdate = null;
        $this->enddate = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.historyposition.historypositioncreate',[
            'employes' => Employe::orderBy('name', 'asc')->get(),
        ]);
    }
}
