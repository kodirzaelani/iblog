<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Historyposition;

use App\Models\Employe;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\Historyposition;
use Illuminate\Support\Facades\Auth;

class Historypositionedit extends Component
{
    public $title;
    public $employe_id;
    public $startdate;
    public $enddate;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Historyposition::find($this->modelId);

        $this->employe_id     = $model->employe_id;
        $this->title     = $model->title;
        $this->startdate     = $model->startdate;
        $this->enddate     = $model->enddate;
    }

    public function update()
    {
        $validateData = [
            'employe_id' => 'required',
            'title'     => 'required',
            'startdate' => 'required',
            'enddate' => 'required',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            // 'employe_id' => $this->employe_id,
            'title'     => $this->title,
            'slug'      => Str::slug(time().$this->title),
            'startdate' => $this->startdate,
            'enddate'   => $this->enddate,
            'updated_by'=> Auth::id(),
        ];

        $historyposition = Historyposition::find($this->modelId);
        $historyposition->update($data);

        $this->emit('historypositionUpdated', $historyposition);
        $this->cleanVars();
    }

    private function cleanVars()
    {
        $this->employe_id = null;
        $this->title = null;
        $this->startdate = null;
        $this->enddate = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.historyposition.historypositionedit',[
            'employes' => Employe::orderBy('name', 'asc')->get(),
        ]);
    }
}
