<?php

namespace App\Http\Livewire\Template\Backend\Nusantara\Management;

use App\Models\Pergub;
use App\Models\Employe;
use Livewire\Component;
use App\Models\Management;
use Illuminate\Support\Str;
use App\Models\Structuroganization;
use Illuminate\Support\Facades\Auth;

class Managementedit extends Component
{
    public $employe_id;
    public $structuroganization_id;
    public $startdate;
    public $enddate;
    public $sortm;

    public $modelId;

    protected $listeners = [
        'getModelId',
    ];

    public function getModelId($modelId)
    {
        $this->modelId = $modelId;

        $model = Management::find($this->modelId);

        $this->employe_id     = $model->employe_id;
        $this->structuroganization_id     = $model->structuroganization_id;
        $this->startdate     = $model->startdate;
        $this->enddate     = $model->enddate;
        $this->sortm     = $model->sortm;
    }

    public function update()
    {
        $validateData = [
            'employe_id' => 'required',
            'structuroganization_id'     => 'required',
            'startdate'     => 'required',
            'sortm'     => 'required',
        ];

        $this->validate($validateData);

        $data = [];

        $data = [
            'employe_id'     => $this->employe_id,
            'structuroganization_id'     => $this->structuroganization_id,
            'startdate'     => $this->startdate,
            'enddate'     => $this->enddate,
            'sortm'     => $this->sortm,
            'updated_by'     => Auth::id(),
        ];

        $management = Management::find($this->modelId);

        $management->update($data);

        $this->emit('managementUpdated', $management);
        $this->cleanVars();

    }


    private function cleanVars()
    {
        $this->employe_id = null;
        $this->structuroganization_id = null;
        $this->startdate = null;
        $this->enddate = null;
        $this->sortm = null;
    }

    public function render()
    {
        return view('livewire.template.backend.nusantara.management.managementedit',[
            'employes' => Employe::orderBy('name', 'asc')->get(),
            'structuroganization' => Structuroganization::where('status', 1)->orderBy('department', 'asc')->get(),
        ]);
    }
}
