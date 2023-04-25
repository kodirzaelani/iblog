<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Periode;

use App\Models\Pergub;
use App\Models\Periode;
use Livewire\Component;
use Illuminate\Support\Str;

class Periodeedit extends Component
{
    public $pergub_id;
    public $slug;
    public $startdate;
    public $enddate;
    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Periode::find($this->modelId);

        $this->pergub_id     = $model->pergub_id;
        $this->startdate     = $model->startdate;
        $this->enddate     = $model->enddate;
    }

    public function update()
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
        ];

        $periode = Periode::find($this->modelId);

        $periode->update($data);

        $this->emit('periodeUpdated', $periode);
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
        return view('livewire.template.backend.nusantara.periode.periodeedit',[
            'pergubs' => Pergub::orderBy('year', 'asc')->get(),
        ]);
    }
}
